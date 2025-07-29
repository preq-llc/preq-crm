<?php
// Include configuration and session files
include '../../config.php';
include $path . 'function/session.php';

// Load required library
require_once '../../libs/SimpleXLSXGen.php';
use Shuchkin\SimpleXLSXGen;

// Initialize variables
$action = $_GET['action'] ?? '';
$format = $_GET['format'] ?? '';
$data = [];
$campConn = mysqli_connect('192.168.200.59','zeal', '4321','Agent_calls_FAPI');
if (!$campConn) {
die(json_encode(['error' => 'Failed to connect to campaign database']));
}

if ($action === 'getcount') {
    // Extract input parameters
    $fromDate    = $_GET['fromdatevalue'] ?? '';
    $toDate      = $_GET['todatevalue'] ?? '';
    $campaignVal = $_GET['slctcampvalue'] ?? '';
    $callCenter  = $_GET['call_centervalue'] ?? '';
    $agentId     = $_GET['agent_id'] ?? '';

    if (!empty($campaignVal)) {
        // Get campaign connection details from the main database
        $campaignQuery = "SELECT * FROM campaigns_details WHERE campaign_value = '$campaignVal' AND status = 'ACTIVE'";
        $campaignResult = mysqli_query($conn, $campaignQuery) or die(mysqli_error($conn));
        $campaignData = mysqli_fetch_assoc($campaignResult);

        // Extract campaign database connection parameters
        $server   = $campaignData['camp_ip'];
        $dbUser   = $campaignData['db_username'];
        $dbPass   = $campaignData['db_password'];
        $dbName   = $campaignData['db_database'];

        // Apply additional filters if provided
        if (!empty($callCenter)) {
            $callCenterquery = " AND agent_username LIKE '%$callCenter%'";
        }

        if (!empty($agentId)) {
            $agentIdquery = " AND agent_username = '$agentId'";
        }



    
        // Build the AI status count query
        $query = "
            SELECT 
                SUM(CASE WHEN ai_status = 'neutral'  THEN 1 ELSE 0 END) AS neutral,
                SUM(CASE WHEN ai_status = 'positive' THEN 1 ELSE 0 END) AS positive,
                SUM(CASE WHEN ai_status = 'negative' THEN 1 ELSE 0 END) AS negative,
                SUM(CASE WHEN ai_status IS NULL      THEN 1 ELSE 0 END) AS pending,
                SUM(CASE WHEN ai_status = 'failed'   THEN 1 ELSE 0 END) AS failed,
                SUM(CASE WHEN ai_status = 'queue'    THEN 1 ELSE 0 END) AS processing
            FROM QC_Reports
            WHERE camp = '$campaignVal'$callCenterquery $agentIdquery
              AND timestamp BETWEEN '$fromDate 00:00:00' AND '$toDate 23:59:59'
        ";


        // Execute the query and fetch results
        $result = mysqli_query($campConn, $query);
        $counts = mysqli_fetch_assoc($result);

        // Format the result into a structured array
       

        foreach ($counts as $status => $count) {
            $data[] = [
                'name'   => ucfirst($status),
                'status' => $status,
                'count'  => (int) $count
            ];
        }

        // Output or return the result (you may want to echo json_encode($structuredCounts); here)
    }
}


if ($action === 'getdisporeport') {
    // Retrieve filter parameters
    $fromDate     = $_GET['fromdatedispo'] ?? '';
    $toDate       = $_GET['todatedispo'] ?? '';
    $campaignVal  = $_GET['camp'] ?? '';
    $callCenter   = $_GET['call_center'] ?? '';
    $agentId      = $_GET['agent_id'] ?? '';
    $dispView     =$_GET['dispView']?? '';

    if($dispView  == 'pending'){

        $dispViewquery = "AND ai_status IS NULL";

    }

     else if($dispView  == 'processing'){

        $dispViewquery = "AND ai_status ='queue'";

    }

    else {

        $dispViewquery =  "AND ai_status = '$dispView'";
    }

         // Apply additional filters if provided
        if (!empty($callCenter)) {
            $callCenterquery = " AND agent_username LIKE '%$callCenter%'";
        }

        if (!empty($agentId)) {
            $agentIdquery = " AND agent_username = '$agentId'";
        }



        // Build the SQL query
 $query = "SELECT id,   phone_number, agent_username, agent_first_name, status, leadid, camp, ai_status, ai_score, ai_response, ai_status_update_timestamp,first_name,last_name,audio_link_url
                  FROM QC_Reports
                  WHERE camp = '$campaignVal'
                  $dispViewquery $callCenterquery $agentIdquery
                  AND timestamp BETWEEN '$fromDate 00:00:00' AND '$toDate 23:59:59'";

    
        $result = mysqli_query($campConn, $query);

        // Prepare data and status-wise counts


        while ($row = mysqli_fetch_assoc($result)) {
            // Add each record to the data array
            $data[] = [
                'phone_number'                => $row['phone_number'],
                'agent_id'                    => $row['agent_username'],
                'firstname'                   => $row['agent_first_name'],
                'status'                     => $row['status'],
                'leadid'                     => $row['leadid'],
                'campid'                     => $row['camp'],
                'ai_status'                  => $row['ai_status'],
                'ai_score'                   => $row['ai_score'],
                'ai_response'                => $row['ai_response'],
                'ai_status_update_timestamp' => $row['ai_status_update_timestamp'],
                'cus_first_name'                => $row['first_name'],
                'cus_last_name'                => $row['last_name'],
                'audio'                        => $row['audio_link_url'],
                'id'                          => $row['id']
                
            ];
    }
}

// Return the final response as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
