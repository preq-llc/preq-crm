<?php
include '../../config.php';
include $path . 'function/session.php';
require_once '../../libs/SimpleXLSXGen.php';

use Shuchkin\SimpleXLSXGen;

$action = $_GET['action'] ?? '';
$data = [];

if ($action === "gethoursreport") {
    $startDate       = $_GET['fromdatevalue'];
    $endDate         = $_GET['todatevalue'];
    $campaign        = $_GET['slctcampvalue'];
    // $call_centervalue = $_GET['call_centervalue'];

    // Get DB credentials from central config table
    $sql = "SELECT * FROM campaigns_details WHERE campaign_value = '$campaign' AND status = 'ACTIVE'";
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($res);

    $servername = $row['camp_ip'];
    $dbusername = $row['db_username'];
    $dbpassword = $row['db_password'];
    $database   = $row['db_database'];

    // Define time range
    $startDateTime = "$startDate 00:00:00";
    $endDateTime   = "$endDate 23:59:59";
    $today         = date('Y-m-d');
    $table         = ($startDate === $today && $endDate === $today) ? "vicidial_agent_log" : "vicidial_agent_log_archive";
    if ($campaign == "PSPM_ACA") {
        $removedDeadSec = '';
    } else {
        $removedDeadSec = "+($table.dead_sec)";
    }
    // Example of multiple centers from GET (comma separated string)
    $call_centers = isset($_GET['call_centervalue']) ? explode(',', $_GET['call_centervalue']) : [];

    if (count($call_centers) > 0) {
        $likeClauses = array_map(function ($center) use ($conn) {
            $center_esc = mysqli_real_escape_string($conn, trim($center));
            return "t1.user LIKE '%$center_esc%'";
        }, $call_centers);
        $call_center_sql = "(" . implode(" OR ", $likeClauses) . ")";
    } else {
        $call_center_sql = "1"; // no filter
    }

    $query = "
    SELECT 
        HOUR(t1.event_time) AS hr,
        t1.campaign_id AS campaignid,
        SUM((t1.talk_sec) + (t1.wait_sec) + (t1.dispo_sec) $removedDeadSec) AS totalhours,
        (
            SELECT COUNT(*) 
            FROM $table t2
            WHERE t2.campaign_id = '$campaign' AND
                (" . implode(" OR ", array_map(function ($center) use ($conn) {
            $center_esc = mysqli_real_escape_string($conn, trim($center));
            return "t2.user LIKE '%$center_esc%'";
        }, $call_centers)) . ")
                AND HOUR(t2.event_time) = HOUR(t1.event_time)
                AND t2.event_time BETWEEN '$startDateTime' AND '$endDateTime'
                AND t2.status IN ('SUBMIT', 'TRA', 'DROPIN')
        ) AS total
    FROM $table t1
    WHERE t1.campaign_id = '$campaign' AND
        $call_center_sql
        AND t1.event_time BETWEEN '$startDateTime' AND '$endDateTime'
    GROUP BY hr
    ORDER BY hr
    ";


    $escapedQuery = escapeshellarg($query);
    $cmd = "mysql -u $dbusername -p$dbpassword -h $servername -D $database -N -e $escapedQuery";
    $output = shell_exec($cmd);

    $data = [];
    $total_count = 0;

    function formatHour($hour)
    {
        $ampm = $hour >= 12 ? 'PM' : 'AM';
        $hour12 = $hour % 12;
        if ($hour12 == 0) $hour12 = 12;
        return str_pad($hour12, 2, '0', STR_PAD_LEFT) . ":00 $ampm";
    }

    if (!empty($output)) {
        $lines = explode("\n", trim($output));
        foreach ($lines as $line) {
            list($hour, $campaignid, $totalSecs, $count) = explode("\t", $line); // include campaignid
            $hour = (int)$hour;

            $start_label = formatHour($hour);
            $end_label   = formatHour(($hour + 1) % 24);

            $data[] = [
                'campaignid' => $campaignid,
                'hours'      => "$start_label - $end_label",
                'hours_cunt' => (int)$count,
                'full_hours' => "$start_label to $end_label",
                'totalhours' => (int)$totalSecs
            ];

            $total_count += (int)$count;
        }
    }

    header('Content-Type: application/json');
    echo json_encode([
        'data' => $data,
        'total_count' => $total_count
    ]);
    exit;
} else if ($_POST['action'] === 'getHourlyListData') {
    $campaign = mysqli_real_escape_string($conn, $_POST['campaign_id']);
    $call_centervalue = mysqli_real_escape_string($conn, $_POST['call_centervalue']);
    $date = $_POST['selected_date'];
    $hour = (int)$_POST['hour'];

    // Get campaign DB credentials
    $sql = "SELECT * FROM campaigns_details WHERE campaign_value = '$campaign' AND status = 'ACTIVE'";
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($res);

    if (!$row) {
        echo json_encode(['error' => 'Campaign not found or inactive.']);
        exit;
    }

    $camp_ip     = $row['camp_ip'];
    $db_username = $row['db_username'];
    $db_password = $row['db_password'];
    $db_database = $row['db_database'];

    // Connect to campaign DB
    $camp_conn = new mysqli($camp_ip, $db_username, $db_password, $db_database);
    if ($camp_conn->connect_error) {
        echo json_encode(['error' => 'Database connection failed.']);
        exit;
    }

    $startTime = "$date " . str_pad($hour, 2, "0", STR_PAD_LEFT) . ":00:00";
    $endTime   = "$date " . str_pad($hour + 1, 2, "0", STR_PAD_LEFT) . ":00:00";

    // Get distinct lead_ids and count by list_id
    $query = "
        SELECT 
            vl.list_id, 
            val.campaign_id, 
            COUNT(DISTINCT val.lead_id) AS successtransfer,
            (SELECT COUNT(*) FROM vicidial_list WHERE list_id = vl.list_id) AS total_count
        FROM vicidial_agent_log val
        JOIN vicidial_list vl ON val.lead_id = vl.lead_id
        WHERE val.event_time BETWEEN '$startTime' AND '$endTime'
        AND val.campaign_id = '$campaign'
        AND val.status IN ('SUBMIT', 'TRA', 'DROPIN')
        GROUP BY vl.list_id
    ";

    $result = $camp_conn->query($query);
    if (!$result) {
        echo json_encode([
            'error' => 'Query failed.',
            'sql' => $query,
            'mysqli_error' => $camp_conn->error
        ]);
        $camp_conn->close();
        exit;
    }

    $data = [];

    while ($row = $result->fetch_assoc()) {
        $list_id = $row['list_id'];
        $campaign_id = $row['campaign_id'];
        $total_count = $row['total_count'];
        $successtransfer = $row['successtransfer'];

        // Fetch list name & description
        $list_safe = $camp_conn->real_escape_string($list_id);
        $listInfoQuery = "SELECT list_name, list_description FROM vicidial_lists WHERE list_id = '$list_safe' LIMIT 1";
        $listInfoResult = $camp_conn->query($listInfoQuery);

        $list_name = '';
        $list_desc = '';
        if ($listInfoResult && $listInfoResult->num_rows > 0) {
            $info = $listInfoResult->fetch_assoc();
            $list_name = $info['list_name'];
            $list_desc = $info['list_description'];
        }

        $data[] = [
            'list_id' => $list_id,
            'campaign_id' => $campaign_id,
            'total_count' => (int)$total_count,
            'successtransfer' => (int)$successtransfer,
            'list_name' => $list_name,
            'list_description' => $list_desc
        ];
    }

    $camp_conn->close();
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}
