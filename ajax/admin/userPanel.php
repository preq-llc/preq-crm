<?php
    include('../../config.php');
    
// $conn = mysqli_connect('localhost', 'zeal', '4321', 'zealoustest');
// $conn = mysqli_connect('localhost', 'root', '', 'zealous');

if(!$conn)
{
    echo 'Mysql Error :'.mysqli_connect_error();
}

    //Path
    // $path = "/zealous/";
    // Change time Zone
    date_default_timezone_set('America/New_York');

    $today_date = date('Y-m-d');
    $today_dateTime = date('Y-m-d H:i:s');

    include('../../session.php');
    // include($path.'DB/local-db.php');
    
    $action = $_GET['action'];
    $res = [];
    if($action == 'getCampaign')
    {
        $current_username = $_GET['current_username'];
        $cmp = mysqli_query($conn, "SELECT cd.*
                                    FROM campaigns_details cd
                                    LEFT JOIN allow_camps ac ON ac.campaign = cd.campaign_value
                                    WHERE cd.status = 'ACTIVE' 
                                    AND ac.`$current_username` = 'ACCEPT'");
        while($get = mysqli_fetch_assoc($cmp))
        {
            $server_ip = $get['camp_ip'];
            $db_database = $get['db_database'];
            $db_password = $get['db_password'];
            $db_username = $get['db_username'];
            $campaign_id = $get['campaign_value'];
            // $res['data'][] = $get;

            $con = mysqli_connect($server_ip, $db_username, $db_password, $db_database);
            $det_s = mysqli_query($con, "SELECT campaign_id, campaign_name, active, lead_order, auto_dial_level, dial_prefix, dial_method, lead_filter_id, dial_statuses FROM `vicidial_campaigns` WHERE `campaign_id` = '$campaign_id'");
            $w = mysqli_fetch_assoc($det_s);
            
            $res['data'][] = $w;
        }

        $res['status'] = 'Ok';
    }

else if ($action == 'updateCampaign') {

    $campaign_id = $_POST['campaign_id'];
    $dial_level = $_POST['dial_level'];
    $dial_prefix = $_POST['dial_prefix'];
    $status_two = $_POST['status_two'];

    $cmp = mysqli_query($conn, "SELECT cd.*
                                FROM campaigns_details cd
                                WHERE cd.status = 'ACTIVE' AND cd.campaign_value = '$campaign_id'");

    while ($get = mysqli_fetch_assoc($cmp)) {
        $server_ip = $get['camp_ip'];
        $db_database = $get['db_database'];
        $db_password = $get['db_password'];
        $db_username = $get['db_username'];
        $campaign_value = $get['campaign_value']; // **don’t overwrite $campaign_id**

        $con = mysqli_connect($server_ip, $db_username, $db_password, $db_database);
        if ($con) {
            $update_query = "UPDATE `vicidial_campaigns` 
                             SET `active` = '$status_two', 
                                 `auto_alt_dial` = '$dial_level',
                                 `dial_prefix` = '$dial_prefix' 
                             WHERE `campaign_id` = '$campaign_value'";
            $det_s = mysqli_query($con, $update_query);

            $res['data'][] = $det_s ? 'Updated Successfully' : 'Update Failed';
        } else {
            $res['data'][] = 'DB Connection Failed';
        }
    }

    $res['status'] = 'Ok';
}


elseif ($action == 'voipshow') {
    // Sanitize input
    $server_ip = mysqli_real_escape_string($conn, $_POST['server_ip']);
    
    // Query active campaigns for the specified server IP
    $campaign_query = mysqli_query($conn, 
        "SELECT cd.*
         FROM campaigns_details cd
         WHERE cd.status = 'ACTIVE' AND cd.camp_ip = '$server_ip'");
    
    $res = ['status' => 'Ok', 'data' => []];
    
    // Process each matching campaign
    if ($campaign = mysqli_fetch_assoc($campaign_query)) {
        try {
            // Connect to the campaign's database
            $campaign_db = mysqli_connect(
                $campaign['camp_ip'],
                $campaign['db_username'],
                $campaign['db_password'],
                $campaign['db_database']
            );
            
            if (!$campaign_db) {
                throw new Exception("Failed to connect to campaign database");
            }
            
            // Fetch carrier information
            $carriers_query = mysqli_query($campaign_db, 
                "SELECT `carrier_id`, `carrier_name`, `server_ip`, `user_group`, `active` 
                 FROM `vicidial_server_carriers`");
            
            while ($carrier = mysqli_fetch_assoc($carriers_query)) {
                $res['data'][] = $carrier;
            }
            
            mysqli_close($campaign_db);
            
        } catch (Exception $e) {
            // Log error or handle connection failure
            $res['status'] = 'Error';
            $res['message'] = $e->getMessage();
        }
    }
}


elseif ($action == 'voipupdate') {
    // Initialize response
    $response = ['status' => 'error', 'message' => '', 'updated_count' => 0];
    
    // Validate required inputs
    if (empty($_POST['server_ip']) || empty($_POST['status']) || empty($_POST['carriers'])) {
        $response['message'] = 'Missing required parameters';
        echo json_encode($response);
        exit;
    }

    // Sanitize inputs
    $server_ip = mysqli_real_escape_string($conn, $_POST['server_ip']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $carriers = $_POST['carriers']; 
    
    // Get campaign database credentials
    $campaign_query = mysqli_query($conn, 
        "SELECT camp_ip, db_username, db_password, db_database 
         FROM campaigns_details 
         WHERE status = 'ACTIVE' AND camp_ip = '$server_ip'");
    
    if (!$campaign_query || mysqli_num_rows($campaign_query) === 0) {
        $response['message'] = 'No active campaign found for this server';
        echo json_encode($response);
        exit;
    }

    $campaign = mysqli_fetch_assoc($campaign_query);
    
    // Connect to campaign database
    $campaign_db = mysqli_connect(
        $campaign['camp_ip'],
        $campaign['db_username'],
        $campaign['db_password'],
        $campaign['db_database']
    );
    
    if (!$campaign_db) {
        $response['message'] = 'Failed to connect to campaign database: ' . mysqli_connect_error();
        echo json_encode($response);
        exit;
    }

    // Process each carrier
    $updated_count = 0;
    foreach ($carriers as $carrier_id) {
        $clean_carrier_id = mysqli_real_escape_string($campaign_db, $carrier_id);
        
        $update_query = "UPDATE vicidial_server_carriers 
                        SET active = '$status' 
                        WHERE carrier_id = '$clean_carrier_id'";
        
        if (mysqli_query($campaign_db, $update_query)) {
            $updated_count += mysqli_affected_rows($campaign_db);
        }
    }

    // Close connection
    mysqli_close($campaign_db);

    // Prepare success response
    $res = [
        'status' => 'success',
        'message' => "Updated $updated_count carriers",
        'updated_count' => $updated_count
    ];
    
   
}




echo json_encode($res);
?>