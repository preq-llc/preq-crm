<?php
include '../../config.php';
include $path . 'function/session.php';
require_once '../../libs/SimpleXLSXGen.php';

use Shuchkin\SimpleXLSXGen;

$action = $_GET['action'];
$data = [];
$format = $_GET['format'] ?? 'csv';

if ($format === 'xlsx') {
    $startDate = $_GET['startDate'];
    $endDate = $_GET['endDate'];
    $campaign = $_GET['campaign'];
    $today_date = date('Y-m-d'); // You forgot to define this

    $table = ($startDate == $today_date) ? 'vicidial_agent_log' : 'vicidial_agent_log_archive';
    $log_table = ($startDate == $today_date) ? 'vicidial_closer_log' : 'vicidial_closer_log_archive';

    $getDb = mysqli_query($conn, "SELECT * FROM campaigns_details WHERE campaign_value='$campaign' AND status='ACTIVE'")
        or die("Error fetching campaign details: " . mysqli_error($conn));

    if (mysqli_num_rows($getDb) == 0) {
        die("No active campaign found for value: $campaign");
    }

    $fr = mysqli_fetch_assoc($getDb);

    // Extract DB credentials
    $dbip = $fr['camp_ip'];
    $db_name = $fr['db_username'];
    $db_password = $fr['db_password'];
    $db_database = $fr['db_database'];

    // Connect to campaign DB
    $temcon = mysqli_connect($dbip, $db_name, $db_password, $db_database);

    $sql = mysqli_query($temcon, "
        SELECT mt.*, vicidial_list.phone_number 
        FROM $table mt 
        LEFT JOIN vicidial_list ON vicidial_list.lead_id = mt.lead_id 
        WHERE mt.event_time BETWEEN '$startDate 00:00:00' AND '$endDate 23:59:59' 
        AND mt.campaign_id = '$campaign' AND mt.lead_id IS NOT NULL
    ");

    // XLSX Header row
    $data[] = [
        "Call ID", "Time Stamp", "Campaign ID", "Call Type", "Agent", "Agent Name", "Disposition",
        "Telephone Dialed", "Total Call Time", "Ring Time", "Talk Time", "After Call Work Time",
        "Valid Number", "Transfers", "DNC", "Answer Machine", "Live Answer"
    ];

    while ($result = mysqli_fetch_assoc($sql)) {
        $agent_log_id = $result['agent_log_id'];
        $event_time = $result['event_time'];
        $campaign_id = $result['campaign_id'];
        $comments = $result['comments'] ?? "OUTBOUND";
        $user_name = $result['user'];
        $status = $result['status'];
        $phone_number = $result['phone_number'];

        $wait_sec = $result['wait_sec'];
        $talk_sec = $result['talk_sec'];
        $dispo_sec = $result['dispo_sec'];
        $dead_sec = $result['dead_sec'];

        $total_sec = $wait_sec + $talk_sec + $dispo_sec + $dead_sec;

        $valid_number = "Yes";
        $transfer = in_array($status, ["TRANSFER", "TRA", "DROPIN", "SUBMIT"]) ? "Yes" : "No";
        $dnc = $status === "DNC" ? "Yes" : "No";
        $ans_mach = $status === "A" ? "Yes" : "No";
        $live_ans = $status !== "A" ? "Yes" : "No";

        $data[] = [
            $agent_log_id,
            $event_time,
            $campaign_id,
            $comments,
            $user_name,
            $user_name,
            $status,
            $phone_number,
            $total_sec,
            $wait_sec,
            $talk_sec,
            $dispo_sec,
            $valid_number,
            $transfer,
            $dnc,
            $ans_mach,
            $live_ans
        ];
    }

    $filename = "Agent_Detail_Log_Report_{$campaign}_" . date('d-m-Y') . ".xlsx";
    SimpleXLSXGen::fromArray($data)->downloadAs($filename);
    exit;
}
else{
    $startDate=$_GET['startDate'];
    $endDate=$_GET['endDate'];
    $campaign=$_GET['campaign'];
   
    // echo $startDate;
    // echo $endDate;

    $table = ($startDate == $today_date) ? 'vicidial_agent_log' : 'vicidial_agent_log_archive';
    $log_table = ($startDate == $today_date) ? 'vicidial_closer_log' : 'vicidial_closer_log_archive';
    $getDb = mysqli_query($conn, "SELECT * FROM campaigns_details WHERE campaign_value='$campaign' AND status='ACTIVE'") 
    or die("Error fetching campaign details: " . mysqli_error($conn));

    if (mysqli_num_rows($getDb) == 0) {
        die("No active campaign found for value: $campaign");
    }

    $fr = mysqli_fetch_assoc($getDb);

    // Extract database credentials
    $dbip = $fr['camp_ip'];
    $db_name = $fr['db_username'];
    $db_password = $fr['db_password'];
    $db_database = $fr['db_database'];
    $voice_key = $fr['voice_key'];
    $campaign_inbound = $fr['inbound_camp'];


    // Connect to campaign database
    $temcon = mysqli_connect($dbip, $db_name, $db_password, $db_database);
    // echo $log_table;
    $sql = mysqli_query($temcon, "SELECT mt.*, vicidial_list.phone_number FROM $table mt LEFT JOIN `vicidial_list` ON vicidial_list.lead_id = mt.lead_id WHERE mt.event_time BETWEEN '$startDate 00:00:00' AND '$endDate 23:59:59' AND mt.campaign_id = '$campaign' AND mt.lead_id IS NOT NULL");

    // Set CSV headers for download
    $filename = "Agent_Detail_Log_Report_{$campaign}_" . date('d-m-Y') . ".csv";
    header("Content-Disposition: attachment; filename=\"$filename\"");
    $output = fopen('php://output', 'w');

    // Define CSV column headers
    $heading = [
        "Call ID",
        "Time Stamp",
        "Campaign ID",
        "Call Type",
        "Agent",
        "Agent Name",
        "Disposition",
        "Telephone Dialed",
        "Total Call Time",
        "Ring Time",
        "Talk Time",
        "After Call Work Time",
        "Valid Number",
        "Transfers",
        "DNC",
        "Answer Machine", 
        "Live Answer"
    ];

    fputcsv($output, $heading); // Write header row

    // Fetch and write data rows
    while ($result = mysqli_fetch_assoc($sql)) {
        $agent_log_id = $result['agent_log_id'];
        $event_time = $result['event_time'];
        $campaign_id = $result['campaign_id'];
        $comments = $result['comments'] == null ? "OUTBOUND" : $result['comments'];
        $user_name = $result['user'];
        $status = $result['status'];
        $phone_number = $result['phone_number'];

        $wait_sec = $result['wait_sec'];
        $talk_sec = $result['talk_sec'];
        $dispo_sec = $result['dispo_sec'];
        $dead_sec = $result['dead_sec'];

        $total_sec = $wait_sec + $talk_sec + $dispo_sec + $dead_sec;

        $valid_number = "Yes";
        $transfer = in_array($status, ["TRANSFER", "TRA", "DROPIN", "SUBMIT"]) ? "Yes" : "No";
        $dnc = in_array($status, ["DNC"]) ? "Yes" : "No";
        $ans_mach = $status == "A" ? "Yes" : "No";
        $live_ans = $status != "A" ? "Yes" : "No";

        // Data row for CSV
        $body = [
            $agent_log_id,
            $event_time,
            $campaign_id,
            $comments,
            $user_name,
            $user_name,
            $status,
            $phone_number,
            $total_sec,
            $wait_sec,
            $talk_sec,
            $dispo_sec,
            $valid_number,
            $transfer,
            $dnc,
            $ans_mach,
            $live_ans
        ];

        fputcsv($output, $body);
    }

    fclose($output);
    exit;
}
?>
