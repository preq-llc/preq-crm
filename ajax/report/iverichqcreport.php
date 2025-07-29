<?php
// echo 'test';

include '../../config.php';
include $path.'function/session.php';
$action=$_GET['action'];
$data = [];
// echo 'tet';
if ($action == 'getqcleads') {
    // Fetch GET parameters with validation
    $fromdatevalue = isset($_GET['fromdatevalue']) ? $_GET['fromdatevalue'] : '';
    $todatevalue = isset($_GET['todatevalue']) ? $_GET['todatevalue'] : '';
    $source = isset($_GET['source']) ? $_GET['source'] : '';
    $slctcampvalue = isset($_GET['slctcampvalue']) ? $_GET['slctcampvalue'] : '';
    $call_centervalue = isset($_GET['call_centervalue']) ? $_GET['call_centervalue'] : '';
    $today_date = date('Y-m-d'); // Format today's date

    // Fetch campaign details from the first database
    $campaign_query = "SELECT * FROM campaigns_details WHERE campaign_value='$slctcampvalue' AND status='ACTIVE'";
    $campaign_result = mysqli_query($conn, $campaign_query) or die(mysqli_error($conn));
    $campaign_data = mysqli_fetch_array($campaign_result);

    // Extract connection details from the campaign data
    $dbip = !empty($campaign_data['camp_ip']) ? $campaign_data['camp_ip'] : "192.168.200.151";
    $db_name = !empty($campaign_data['db_username']) ? $campaign_data['db_username'] : "zeal";
    $db_password = !empty($campaign_data['db_password']) ? $campaign_data['db_password'] : "4321";
    $db_database = !empty($campaign_data['db_database']) ? $campaign_data['db_database'] : "asterisk";


    // First database connection
    $connone = mysqli_connect($dbip, $db_name, $db_password, $db_database);
    if (!$connone) {
        die(json_encode(['status' => 'error', 'message' => 'Failed to connect to the first database: ' . mysqli_connect_error()]));
    }

    // Second database connection
    $servernametwo = "192.168.200.42";
    $dbusernametwo = "zeal";
    $dbpasswordtwo = "4321";
    $databasetwo = "zealousv2";
    $conntwo = mysqli_connect($servernametwo, $dbusernametwo, $dbpasswordtwo, $databasetwo);
    if (!$conntwo) {
        die(json_encode(['status' => 'error', 'message' => 'Failed to connect to the second database: ' . mysqli_connect_error()]));
    }

    // Set the table name
    $table = 'IVE_QC_Reports';

    // Add a condition for call center filter if provided
    $callcenter_condition = ($call_centervalue != '') ? " AND $table.agent_first_name LIKE '%$call_centervalue%'" : '';

    $campaign_condition = ($slctcampvalue != '') ? " AND $table.campid = '$slctcampvalue'" : '';
 





    // Add a condition based on source filter
    if ($source == 'IVEIN') {
        $source_condition = "AND $table.camp = ''";
    } elseif ($source == 'IVE360') {
        $source_condition = "AND $table.camp ='IVE360'";
    } else {
        $source_condition = '';  // No condition, fetch all data
    }

    // Query to fetch leads with filters
     $query = "
        SELECT 
            $table.agent_first_name AS agent, 
            $table.leadid,  
            $table.campid, 
            $table.status, 
            $table.timestamp AS event_time, 
            $table.audio_link_url,
            $table.phone_number,
            $table.camp
        FROM 
            $table
        WHERE 
            timestamp >= '$fromdatevalue 00:00:00'
            AND timestamp <= '$todatevalue 23:59:59'
            $campaign_condition
            $callcenter_condition
            $source_condition
        GROUP BY 
            $table.leadid
    ";

    // Execute the shell command to retrieve the values from the second database
    $values = shell_exec("mysql -u $dbusernametwo -p$dbpasswordtwo -h $servernametwo -D $databasetwo -N -e \"$query\"");

    // Process the results
    if (!empty($values)) {
        $rows = explode("\n", trim($values));
        $data = [];

        foreach ($rows as $row) {
            $cols = explode("\t", $row);
            $leadid = trim($cols[1]);
            $campaignid = trim($cols[2]);
            $agent = trim($cols[0]);

            // Fetch user details (full_name and user_group) from the first database
            $user_query = "SELECT `full_name`, `user_group` FROM `vicidial_users` WHERE `user` = '$agent'";
            $user_details = $connone->query($user_query);
            $user_details_result = ($user_details && $user_details->num_rows > 0) ? $user_details->fetch_assoc() : null;

            // Fetch QC data from the second database
            $qc_query = "SELECT `leadid`, `campid`, `QC_dispo` AS qcstatus, `QC_comments` AS qccomments 
                         FROM `IVE_QC_Reports` 
                         WHERE `leadid` = $leadid AND `campid` = '$campaignid'";
            $qc_result = $conntwo->query($qc_query);

            // Prepare data entry for output
            $entry = [
                'agent' => $cols[0],
                'lead_id' => $cols[1],
                'campaign_id' => $cols[2],
                'status' => $cols[3],
                'event_time' => $cols[4],
                'location' => $cols[5],
                'phone_number' => $cols[6],
                'client' => $cols[7],
                'qc_status' => null,
                'qc_comments' => null,
                'full_name' => $user_details_result['full_name'] ,  
                'user_group' => $user_details_result['user_group']
            ];

            // If QC data exists, add it to the entry
            if ($qc_result && $qc_result->num_rows > 0) {
                $qc_data = $qc_result->fetch_assoc();
                $entry['qc_status'] = $qc_data['qcstatus'];
                $entry['qc_comments'] = $qc_data['qccomments'];
            }

            // Add the entry to the final data array
            $data[] = $entry;
        }

        // Return the final data as a JSON response
        echo json_encode(['status' => 'success', 'data' => $data]);
    } else {
        // Handle case when no data is found
        echo json_encode(['status' => 'error', 'message' => 'No data found for the given parameters.']);
    }
}




elseif ($action == 'getrecorddata') {

    // Get POST parameters
    $leadid = isset($_POST['leadid']) ? mysqli_real_escape_string($conn, $_POST['leadid']) : '';
    $phonenumber = isset($_POST['phonenumber']) ? mysqli_real_escape_string($conn, $_POST['phonenumber']) : '';
    $slctcampvalue = isset($_POST['campaign']) ? mysqli_real_escape_string($conn, $_POST['campaign']) : '';
    $client = isset($_POST['client']) ? mysqli_real_escape_string($conn, $_POST['client']) : '';

    // Array to hold response data
    $data = [];

    // Check if campaign value is set and client is empty
    if (!empty($slctcampvalue) && empty($client)) {

        // Query to fetch campaign details from campaigns_details table
        $query = "SELECT camp_ip, db_username, db_password, db_database 
                  FROM campaigns_details 
                  WHERE campaign_value = '$slctcampvalue' 
                  AND status = 'ACTIVE'";

        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $campaignDetails = mysqli_fetch_assoc($result);

            // Extract database credentials
            $dbip = $campaignDetails['camp_ip'];
            $dbusername = $campaignDetails['db_username'];
            $dbpassword = $campaignDetails['db_password'];
            $database = $campaignDetails['db_database'];

            // Connect to the campaign-specific database
            $campConn = mysqli_connect($dbip, $dbusername, $dbpassword, $database);

            if (!$campConn) {
                die(json_encode(['status' => 'error', 'message' => 'Failed to connect to the campaign database.']));
            }

            // Query to fetch lead data
            $leadQuery = "SELECT first_name, last_name, address1, city, state, postal_code, lead_id, phone_number, email 
                          FROM vicidial_list 
                          WHERE lead_id = '$leadid' 
                          AND phone_number = '$phonenumber'";

            $leadResult = mysqli_query($campConn, $leadQuery);

            if ($leadResult && mysqli_num_rows($leadResult) > 0) {
                while ($row = mysqli_fetch_assoc($leadResult)) {
                    $data[] = $row;
                }

                // Return the data as a JSON response
                echo json_encode(['status' => 'success', 'data' => $data]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'No lead data found.']);
            }

            // Close campaign-specific connection
            mysqli_close($campConn);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No active campaign found.']);
        }
    } 
    // If the client is set, connect to a different database
    else {
        // Connection details for the second database
        $servernametwo = "192.168.200.42";
        $dbusernametwo = "zeal";
        $dbpasswordtwo = "4321";
        $databasetwo = "zealousv2";
        
        // Establish connection to the second database
        $conntwo = mysqli_connect($servernametwo, $dbusernametwo, $dbpasswordtwo, $databasetwo);

        if (!$conntwo) {
            die(json_encode(['status' => 'error', 'message' => 'Failed to connect to the second database: ' . mysqli_connect_error()]));
        }

        // Query to fetch QC report data
        $qcQuery = "SELECT first_name, last_name, leadid, phone_number 
                    FROM IVE_QC_Reports 
                    WHERE leadid = '$leadid' 
                    AND phone_number = '$phonenumber' 
                    AND camp = '$client'
                    AND campid ='$slctcampvalue'";

        $qcResult = mysqli_query($conntwo, $qcQuery);

        if ($qcResult && mysqli_num_rows($qcResult) > 0) {
            while ($row = mysqli_fetch_assoc($qcResult)) {
                $data[] = $row;
            }

            // Return the QC report data as a JSON response
            echo json_encode(['status' => 'success', 'data' => $data]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No QC report data found.']);
        }

        // Close the second database connection
        mysqli_close($conntwo);
    }
}



else if($action == 'insertdata') {

    // Database connection details
    $servername = "192.168.200.42";
    $dbusername = "zeal";
    $dbpassword = "4321";
    $database = "zealousv2";

    // Establish connection to the database
    $conn = new mysqli($servername, $dbusername, $dbpassword, $database);

    // Check connection for any errors
    if ($conn->connect_error) {
        die(json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]));
    }

    // Fetch POST data from the request
    $leadid = $_POST['leadid'];
    $campaign = $_POST['campaign'];
    $phone = $_POST['phone'];
    $qcstatus = $_POST['qcstatus'];
    $qccomments = $_POST['qccomments'];
    $date=date('Y-m-d H:i:s');

    // Check if a record already exists in the IVE_QC_Reports table
    echo $checkQuery = "SELECT `Id`, `leadid` FROM `IVE_QC_Reports` 
                   WHERE `leadid` = '$leadid' AND `campid` = '$campaign' AND `phone_number` = '$phone'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult && $checkResult->num_rows > 0) {
        // If the record exists, update the QC status and comments
        echo $updateQuery = "UPDATE `IVE_QC_Reports` 
                        SET `QC_dispo` = '$qcstatus', `QC_comments` = '$qccomments' , `QC_update_timestamp`='$date'
                        WHERE `leadid` = '$leadid' AND `campid` = '$campaign' AND `phone_number` = '$phone'";
        
        if ($conn->query($updateQuery) === TRUE) {
            echo json_encode(['status' => 'success', 'message' => 'QC record updated successfully']);
        } else {
            // Handle update error
            echo json_encode(['status' => 'error', 'message' => 'Update failed: ' . $conn->error]);
        }
    } else {
        // If no record is found, return an error message
        echo json_encode(['status' => 'error', 'message' => 'No matching record found to update']);
    }

    // Close the database connection
    $conn->close();
}





?>