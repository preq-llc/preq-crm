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
    if($action == 'userupdate')
    {
        $username = $_GET['username'];
        $password = $_GET['password'];
        $role = $_GET['role'];
        $campaignName = $_GET['campaignName'];
        $group = $_GET['group'];
        $userAction = $_GET['userAction'];
        $status = $_GET['status'];

        if($userAction == 'create')
        {
            $sql = mysqli_query($conn, "SELECT Username FROM users WHERE Username = '$username'");
            if($checkUser = mysqli_fetch_assoc($sql))
            {
                $res['status'] = 'Available';
            }
            else
            {
                mysqli_query($conn, "INSERT INTO `users`(`username`, `emp_id`, `password`, `role`, `status`, `campaign_name`, `group`, `created_by`, `created_at`, `userimg`) VALUES ('$username','$username','$password','$role','$status','$campaignName','$group','Zea','$today_dateTime', 'admin-img.gif')");


                mysqli_query($conn, "ALTER TABLE `allow_camps` ADD `$username` VARCHAR(20) NULL");
                $res['status'] = 'Ok';

                $user_agent = $_SERVER['HTTP_USER_AGENT'];

                // Get the user IP address
                $user_ip = $_SERVER['REMOTE_ADDR'];
                $data = [
                    'CreatorIP' => $user_ip,
                    'CreatorUsername' => $logged_in_user_name,
                    'CreatoruserAgent' => $user_agent,
                    'NewUser' => $username,
                    'CreateStatus' => 'Success'
                ];
                $JsonData = json_encode($data);
                mysqli_query($conn, "INSERT INTO `activity_log`(`activity`, `data`, `timestamp`) VALUES ('UserCreate','$JsonData','$today_dateTime')");
            }
        }
        else
        {
            mysqli_query($conn, "UPDATE `users` SET `username`='$username',`emp_id`='$username',`password`='$password',`role`='$role',`status`='$status',`campaign_name`='$campaignName',`group`='$group',`updated_at`='$today_dateTime' WHERE `username` = '$username'");

            $res['status'] = 'Ok';

            $user_ip = $_SERVER['REMOTE_ADDR'];
                $data = [
                    'UpdatorIP' => $user_ip,
                    'UpdatorUsername' => $logged_in_user_name,
                    'UpdatoruserAgent' => $user_agent,
                    'UpdatedUser' => $username,
                    'UpdateStatus' => 'Success'
                ];
                $JsonData = json_encode($data);
                mysqli_query($conn, "INSERT INTO `activity_log`(`activity`, `data`, `timestamp`) VALUES ('UserUpdate','$JsonData','$today_dateTime')");

        }
    }
    else if($action == 'getCampPermission')
    {
        $campaignName = $_GET['campaign'];
        $sql = mysqli_query($conn, "SELECT * FROM `allow_camps` WHERE campaign = '$campaignName'");
        while($get = mysqli_fetch_assoc($sql))
        {
            $res['data'][] = $get;
        }
        $res['status'] = 'Ok';

       
    }
    else if($action == 'permissionUpdate')
    {
        $checkBoxUsers = json_decode($_POST['checkBoxUsers']);
        $checkBoxCamps = json_decode($_POST['checkBoxCamps']);
        $flag = 0;
        $campName = '';
        foreach($checkBoxUsers as $key => $user)
        {
            $camp = $checkBoxCamps[$key];
            mysqli_query($conn, "UPDATE `allow_camps` SET `$user`='ACCEPT' WHERE campaign = '$camp'");

            if($flag == 0)
            {
                $campName = $camp;
            }
        }

        $res['status'] = 'Ok';
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $user_ip = $_SERVER['REMOTE_ADDR'];
        $data = [
            'UpdatorIP' => $user_ip,
            'UpdatorUsername' => $logged_in_user_name,
            'UpdatoruserAgent' => $user_agent,
            'UpdatedCampaign' => $campName,
            'UpdateStatus' => 'Success'
        ];
        $JsonData = json_encode($data);
        mysqli_query($conn, "INSERT INTO `activity_log`(`activity`, `data`, `timestamp`) VALUES ('campPermissonUpdate','$JsonData','$today_dateTime')");

    }
        else if ($action == 'createCamp') {
            $camp_ip        = $_GET['camp_ip'];
            $camp_name      = $_GET['camp_name'];
            $zenba_no       = $_GET['zenba_no'];
            $zenba_ip       = $_GET['zenba_ip'];
            $zenba_db       = $_GET['zenba_db'];
            $zenba_username = $_GET['zenba_username'];
            $zenba_pass     = $_GET['zenba_pass'];
            $camp_db        = $_GET['camp_db'];
            $camp_user      = $_GET['camp_user'];
            $camp_pass      = $_GET['camp_pass'];
            $statuscampaign  = $_GET['statuscampaign'];
            $recordingpath  = $_GET['recordingpath'];
            $show_recordings = $_GET['show_recordings'];
            $campaction     = $_GET['campaction'];

            if ($campaction == 'create') {

                // Check for existing campaign name
                $checkSql = mysqli_query($conn, "SELECT * FROM `campaigns_details` WHERE campaign_value = '$camp_name'");
                if (mysqli_num_rows($checkSql) > 0) {
                    $res['status'] = 'Exists';
                } else {
                    // Save the raw JSON string of multi IPs
                    mysqli_query($conn, "INSERT INTO `campaigns_details` (
                        `campaign_value`, `name_display`, `show_camp`, `category`,
                        `zenba_number`, `zenba_username`, `zenba_ip`, `zenba_password`, `zenba_db`, `camp_ip`, 
                        `multi_camp_ip`, `db_username`, `db_password`, `db_database`, `status`,
                        `list_id`, `limit_prcentage`, `available_agent`, `recordingpath`, `show_recordings`
                    ) VALUES (
                        '$camp_name', '$camp_name', '$camp_name', '2',
                        '$zenba_no', '$zenba_username', '$zenba_ip', '$zenba_pass', '$zenba_db',
                        '$camp_ip', '$camp_ip', '$camp_user', '$camp_pass', '$camp_db', '$statuscampaign',
                        '80', '100', '1','$recordingpath','$show_recordings')");

                    $res['status'] = 'Ok';
                }

            } else {
                // Update logic
                mysqli_query($conn, "UPDATE `campaigns_details` SET
                    `campaign_value`='$camp_name',
                    `name_display`='$camp_name',
                    `show_camp`='$camp_name',
                    `zenba_number`='$zenba_no',
                    `zenba_username`='$zenba_username',
                    `zenba_ip`='$zenba_ip',
                    `zenba_password`='$zenba_pass',
                    `zenba_db`='$zenba_db',
                    `multi_camp_ip`='$camp_ip',
                    `camp_ip`='$camp_ip',
                    `db_username`='$camp_user',
                    `db_password`='$camp_pass',
                    `db_database`='$camp_db',
                    `status`='$statuscampaign',
                     `recordingpath`='$recordingpath',
                      `show_recordings`='$show_recordings',
                WHERE campaign_value = '$camp_name'");

                $res['status'] = 'Ok';
            }

            echo json_encode($res);
            exit;
        }

    else if($action == 'getCampaign')
    {
        $rowid = $_GET['rowid'];
        $sql = mysqli_query($conn, "SELECT * FROM `campaigns_details` WHERE id = '$rowid'");
        while($get = mysqli_fetch_assoc($sql))
        {
            $res['data'][] = $get;
        }

        $res['status'] = 'Ok';
    }

echo json_encode($res);
?>