<?php
include('../../config.php'); 
include('../../function/session.php');

date_default_timezone_set('America/New_York');
$today = date("Y-m-d");

$responseData = [];

$action = $_GET['action'] ?? '';

if ($action === 'statusdata') {

    $selectedCampaign = $_POST['campaign'] ?? '';

    // Fetch database connection details for the selected campaign
    $campaignQuery = "SELECT * FROM campaigns_details 
                      WHERE campaign_value = '$selectedCampaign' AND status = 'ACTIVE'";
    $campaignResult = mysqli_query($conn, $campaignQuery) or die(mysqli_error($conn));
    $campaignData = mysqli_fetch_assoc($campaignResult);

    $campIp   = $campaignData['camp_ip'];
    $dbUser   = $campaignData['db_username'];
    $dbPass   = $campaignData['db_password'];
    $dbName   = $campaignData['db_database'];
    $voiceKey = $campaignData['voice_key'];

    // Construct the query for campaign log aggregation
    $query = "
        SELECT 
            val.campaign_id AS camp,
            COUNT(*) AS Totalcalls,
            SUM(val.talk_sec + val.wait_sec + val.dispo_sec + val.dead_sec) AS Hrs,
            SUM(CASE WHEN val.status = 'TRA' THEN 1 ELSE 0 END) AS billable,
            SUM(CASE WHEN val.status IN ('SUBMIT','MEDDS') THEN 1 ELSE 0 END) AS transfer,
            SUM(CASE WHEN val.status = 'SUBMIT' THEN 1 ELSE 0 END) AS acatransfer,
            SUM(CASE WHEN val.status = 'MEDDS' THEN 1 ELSE 0 END) AS medtransfer
        FROM vicidial_agent_log AS val
        LEFT JOIN vicidial_list ON val.lead_id = vicidial_list.lead_id
        WHERE val.event_time >= '$today 00:00:00' 
          AND val.event_time <= '$today 23:59:59'
          AND val.campaign_id = '$selectedCampaign'
          AND val.status IS NOT NULL
        GROUP BY val.campaign_id
        ORDER BY val.campaign_id ASC
    ";

    // Execute query via shell and collect results
    $command = "mysql -u $dbUser -p$dbPass -h $campIp -D $dbName -N -e \"$query\"";
    $result = shell_exec($command);

if (!empty($result)) {
    $cols = explode("\t", trim($result));
    $responseData = [
        'camp'            => $cols[0] ?? '',
        'Totalcalls'      => $cols[1] ?? 0,
        'Hrs'             => $cols[2] ?? 0,
        'billable'        => $cols[3] ?? 0,
        'transfer'        => $cols[4] ?? 0,
        'acatransfer'     => $cols[5] ?? 0,
        'medtransfer'     => $cols[6] ?? 0
    ];
}

}

    header('Content-Type: application/json');
    echo json_encode($responseData);