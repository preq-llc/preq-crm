<?php
include('../../config.php'); 
include('../../function/session.php');

date_default_timezone_set('America/New_York');
$today = date("Y-m-d");

$responseData = [];

$action = $_GET['action'] ?? '';

if ($action === 'agenttiming') {

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
      
         $query = "SELECT 
            HOUR(event_time) AS hour_of_day,
            COUNT(DISTINCT user) AS agent_count,
            SUM(CASE WHEN status = 'TRA' THEN 1 ELSE 0 END) AS billable,
            SUM(CASE WHEN status IN ('SUBMIT', 'MEDDS') THEN 1 ELSE 0 END) AS transfer
        FROM 
            vicidial_agent_log
        WHERE 
            campaign_id = '$selectedCampaign'
            AND event_time BETWEEN '$today 00:00:00' AND '$today 23:59:59'
        GROUP BY 
            HOUR(event_time)
        ORDER BY 
            hour_of_day";

        $command = "mysql -u $dbUser -p$dbPass -h $campIp -D $dbName -N -e \"$query\"";
        $result = shell_exec($command);

        if (!empty($result)) {
            $rows = explode("\n", trim($result));
            foreach ($rows as $row) {
                $cols = explode("\t", $row);
                $responseData[] = [
                    'hours' => $cols[0] ?? '',
                    'agent_count' => (int)($cols[1] ?? 0),
                    'billable' => $cols[2] ?? '',
                    'transfer' => $cols[3] ?? '',
                ];
            }
        }


}

else if ($action === 'carddata') {

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
      
          $query = " SELECT 
        COUNT(*) AS TotalCalls,
        SUM(val.talk_sec + val.wait_sec + val.dispo_sec + val.dead_sec) AS Hrs,
        SUM(CASE WHEN val.status = 'TRA' THEN 1 ELSE 0 END) AS billable,
        SUM(CASE WHEN val.status IN ('SUBMIT', 'MEDDS') THEN 1 ELSE 0 END) AS transfer
    FROM 
        vicidial_agent_log AS val
    WHERE 
        val.event_time BETWEEN '$today 00:00:00' AND '$today 23:59:59'
        AND val.campaign_id = '$selectedCampaign'
        AND val.status IS NOT NULL
    GROUP BY 
        val.campaign_id
    ORDER BY 
        val.campaign_id ASC ";


        $command = "mysql -u $dbUser -p$dbPass -h $campIp -D $dbName -N -e \"$query\"";
        $result = shell_exec($command);

        if (!empty($result)) {
            $rows = explode("\n", trim($result));
            foreach ($rows as $row) {
                $cols = explode("\t", $row);
                $responseData[] = [
                    'TotalCalls' => $cols[0] ?? '',
                    'Hrs' => (int)($cols[1] ?? 0),
                    'billable' => (int)($cols[2] ?? 0),
                    'transfer' => (int)($cols[3] ?? 0)
                ];
            }
        }


}


else if ($action === 'contactratio') {
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


    // 1st Query: Get agentCalls by hour
    $agentQuery = "SELECT 
                    HOUR(event_time) AS hour_of_day,
                    COUNT(agent_log_id) AS agentCalls,
                    SUM(CASE WHEN status = 'A' THEN 1 ELSE 0 END) AS answermachinecalls
                  FROM vicidial_agent_log
                  WHERE event_time BETWEEN '$today 00:00:00' AND '$today 23:59:59'
                    AND campaign_id = '$selectedCampaign'
                    AND status IS NOT NULL
                  GROUP BY HOUR(event_time)
                  ORDER BY hour_of_day";

    $agentCommand = "mysql -u $dbUser -p$dbPass -h $campIp -D $dbName -N -e \"$agentQuery\"";
    $agentResult = shell_exec($agentCommand);

    $agentData = [];
        if (!empty($agentResult)) {
            $rows = explode("\n", trim($agentResult));
            foreach ($rows as $row) {
                list($hour, $agentCalls, $answermachinecalls) = explode("\t", $row);
                $agentData[$hour] = [
                    'agentCalls' => (int)$agentCalls,
                    'answermachinecalls' => (int)$answermachinecalls
                ];
            }
        }

    // 2nd Query: Get totalCalls & Answering Machine calls by hour from vicidial_log only
   $callsQuery = "SELECT 
                HOUR(call_date) AS hour_of_day,
                COUNT(uniqueid) AS totalCalls
                
              FROM vicidial_log
              WHERE call_date BETWEEN '$today 00:00:00' AND '$today 23:59:59'
                AND campaign_id = '$selectedCampaign'
                AND status IS NOT NULL
              GROUP BY HOUR(call_date)
              ORDER BY hour_of_day";


    $callsCommand = "mysql -u $dbUser -p$dbPass -h $campIp -D $dbName -N -e \"$callsQuery\"";
    $callsResult = shell_exec($callsCommand);

    $responseData = [];
    if (!empty($callsResult)) {
        $rows = explode("\n", trim($callsResult));
        foreach ($rows as $row) {
            list($hour, $totalCalls, $ansMachine) = explode("\t", $row);

            $responseData[] = [
                'hour' => $hour,
                'agentCalls' => $agentData[$hour]['agentCalls'] ?? 0,
                'totalCalls' => (int)$totalCalls,
                'answermachinecalls' => $agentData[$hour]['answermachinecalls'] ?? 0
            ];
        }
    }

}

else if($action === 'topfiveperformer'){


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



    $query = "SELECT 
                val.user AS agent_id,
                vc.full_name AS agent_name,
                COUNT(val.agent_log_id) AS total_calls,
                ROUND(SUM(val.talk_sec + val.wait_sec + val.dispo_sec + val.dead_sec) / 3600, 2) AS total_hours,
                SUM(CASE WHEN val.status = 'TRA' THEN 1 ELSE 0 END) AS billable,
                SUM(CASE WHEN val.status IN ('SUBMIT', 'MEDDS') THEN 1 ELSE 0 END) AS transfer
            FROM 
                vicidial_agent_log AS val 
            LEFT JOIN 
                vicidial_users AS vc ON vc.user = val.user   
            WHERE 
                val.campaign_id = '$selectedCampaign'
                AND val.event_time BETWEEN '$today 00:00:00' AND '$today 23:59:59'
            GROUP BY 
                val.user
            ORDER BY 
                transfer DESC
            LIMIT 5
            ";

        $command = "mysql -u $dbUser -p$dbPass -h $campIp -D $dbName -N -e \"$query\"";
        $result = shell_exec($command);

        if (!empty($result)) {
            $rows = explode("\n", trim($result));
            foreach ($rows as $row) {
                $cols = explode("\t", $row);
                $responseData[] = [
                    'agent_id' => $cols[0] ?? '',
                    'agent_name' => $cols[1] ?? '',
                    'total_calls' => (int)($cols[2] ?? 0),
                    'total_hours' => $cols[3] ?? '',
                    'billable' => $cols[4] ?? '',
                    'transfer' => $cols[5] ?? ''
                    
                ];
            }
        }




}




    header('Content-Type: application/json');
    echo json_encode($responseData);