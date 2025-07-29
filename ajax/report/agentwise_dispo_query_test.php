<?php
include '../../config.php';
include $path . 'function/session.php';

$action = $_GET['action'];

if ($action == "getuserstatsDetails") {
    // $agent = $_GET['agent'];
    $startDate = $_GET['fromdatedispo'];
    $endDate = $_GET['todatedispo'];
    $campaign = $_GET['campaign_id'];

    // Get DB credentials
    $ss = "SELECT * FROM campaigns_details WHERE campaign_value='$campaign' AND status='ACTIVE'";
    $rr = mysqli_query($conn, $ss) or die(mysqli_error($conn));
    $fr = mysqli_fetch_array($rr);

    $dbip = $fr['camp_ip'];
    $db_name = $fr['db_username'];
    $db_password = $fr['db_password'];
    $db_database = $fr['db_database'];

    $servername = $dbip;
    $dbusername = $db_name;
    $dbpassword = $db_password;
    $database = $db_database;

    $startDateTime = $startDate . " 00:00:00";
    $endDateTime = $endDate . " 23:59:59";
    $today = date('Y-m-d');

    if ($startDate === $today && $endDate === $today) {
        $table = "vicidial_agent_log";
    } else {
        $table = "vicidial_agent_log_archive";
    }
    // Only include specific statuses
    $allowedStatuses = ['A', 'CALLBK', 'DC', 'DISMX', 'DNC', 'DROPIN', 'HANGUP', 'N', 'NES', 'NI', 'PU', 'RIN'];
    $statusList = "'" . implode("','", $allowedStatuses) . "'";

    // Build query
    // echo "SELECT user, user_group, campaign_id, status, COUNT(*) AS total
    //       FROM $table
    //       WHERE status IN ($statusList)
    //         AND campaign_id = '$campaign'
    //         AND event_time BETWEEN '$startDateTime' AND '$endDateTime'
    //       GROUP BY user, status";
    // Updated query with IFNULL to replace NULL status with 'ND'
    $query = "SELECT user, user_group, campaign_id, IFNULL(status, 'ND') AS status, COUNT(*) AS total
          FROM $table
          WHERE campaign_id = '$campaign'
            AND event_time BETWEEN '$startDateTime' AND '$endDateTime'
          GROUP BY user, status";

    // Run query via shell
    $values = shell_exec("mysql -u $dbusername -p$dbpassword -h $servername -D $database -N -e \"$query\"");

    // Prepare data structure
    $data = [
        'statuses' => [],  // dynamic columns
        'users' => [],     // user data with counts
    ];

    if (!empty($values)) {
        $rows = explode("\n", trim($values));
        foreach ($rows as $row) {
            list($user, $user_group, $campaign_id, $status, $count) = explode("\t", $row);

            $status = $status ?: 'ND'; // fallback if status is empty string

            // Collect unique status types
            if (!in_array($status, $data['statuses'])) {
                $data['statuses'][] = $status;
            }

            // Group by user
            if (!isset($data['users'][$user])) {
                $data['users'][$user] = [
                    'user' => $user,
                    'user_group' => $user_group,
                    'campaign_id' => $campaign_id,
                    'statuses' => [],
                ];
            }

            $data['users'][$user]['statuses'][$status] = $count;
        }

        // Re-index users array for JSON output
        $data['users'] = array_values($data['users']);
    }

    // Output JSON
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}
