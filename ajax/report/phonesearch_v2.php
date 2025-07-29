<?php
include '../../config.php';
$action = isset($_GET['action']) ? $_GET['action'] : '';
$response = [];

if ($action === 'phonesearchlead') {
    $phonenumber = isset($_GET['phonenumber']) ? trim($_GET['phonenumber']) : '';
    $campaign = isset($_GET['campaign']) ? trim($_GET['campaign']) : '';
    $status = 'ACTIVE';

    if (empty($phonenumber) || empty($campaign)) {
        echo json_encode(['status' => 'error', 'message' => 'Phone number and campaign are required']);
        exit;
    }

    $sqlone = "SELECT `camp_ip`, `db_username`, `db_password`, `db_database` 
               FROM `campaigns_details` 
               WHERE `status` = '$status' AND `campaign_value` = '$campaign'";

    $result = mysqli_query($conn, $sqlone);

    if (!$result || mysqli_num_rows($result) === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Campaign details not found']);
        exit;
    }

    $campaignDetails = mysqli_fetch_assoc($result);
    $camp_conn = new mysqli(
        $campaignDetails['camp_ip'],
        $campaignDetails['db_username'],
        $campaignDetails['db_password'],
        $campaignDetails['db_database']
    );

    if ($camp_conn->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to connect to campaign DB']);
        exit;
    }

    // Escape for shell command usage
    $escapedPhone = escapeshellarg($phonenumber);
    $escapedCampaign = escapeshellarg($campaign);

    // Set credentials for shell command
    $dbusername = escapeshellcmd($campaignDetails['db_username']);
    $dbpassword = escapeshellcmd($campaignDetails['db_password']);
    $servername = escapeshellcmd($campaignDetails['camp_ip']);
    $database = escapeshellcmd($campaignDetails['db_database']);

    $command = "mysql -u $dbusername -p$dbpassword -h $servername -D $database -N -e \"
        SELECT lead_id, list_id, campaign_id, call_date, length_in_sec, status, phone_number, user
        FROM vicidial_log 
        WHERE campaign_id = $escapedCampaign AND phone_number = $escapedPhone

        UNION

        SELECT lead_id, list_id, campaign_id, call_date, length_in_sec, status, phone_number, user
        FROM vicidial_log_archive 
        WHERE campaign_id = $escapedCampaign AND phone_number = $escapedPhone
    \"";

    $leadQuery = shell_exec($command);
    $leadData = [];

    if (!empty($leadQuery)) {
        $rows = explode("\n", trim($leadQuery));
        foreach ($rows as $row) {
            $cols = explode("\t", $row);
            $leadData[] = array(
                'lead_id' => $cols[0],
                'list_id' => $cols[1],
                'campaign_id' => $cols[2],
                'call_date' => $cols[3],
                'length_in_sec' => $cols[4],
                'status' => $cols[5],
                'phone_number' => $cols[6],
                'user' => $cols[7],
            );
        }
        $response = ['status' => 'success', 'data' => $leadData];
    } else {
        $response = ['status' => 'error', 'message' => 'Lead not found'];
    }

    $camp_conn->close();
} else {
    $response = ['status' => 'error', 'message' => 'Invalid action'];
}

echo json_encode($response);
?>
