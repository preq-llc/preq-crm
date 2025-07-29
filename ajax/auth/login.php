<?php
    include('../../config.php');
    // include($path.'DB/local-db.php');
    
    $action = $_GET['action'];
    $res = [];
    if($action == 'userlogin')
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
        if($check = mysqli_fetch_assoc($sql))
        {
            $db_status = $check['status'];
            $db_pass = $check['password'];
            if($db_status == "ACTIVE")
            {
                // echo $db_pass;
                // echo $password;
                if($db_pass == $password)
                {
                    session_start();
                    $_SESSION['username'] = $check['username'];
                    $_SESSION['role'] = $check['role'];
                    $_SESSION['group'] = $check['group'];
                    $_SESSION['userimg'] = $check['userimg'];
                    $_SESSION['campaignname'] = $check['campaign_name'];
                    $res['status'] = 'Ok';
                    $res['campaignname'] = $check['campaign_name'];
                    $res['role'] = $check['role'];

                    $user_agent = $_SERVER['HTTP_USER_AGENT'];

                    // Get the user IP address
                    $user_ip = $_SERVER['REMOTE_ADDR'];
                    $data = [
                        'IP' => $user_ip,
                        'Username' => $check['username'],
                        'Role' => $check['role'],
                        'userAgent' => $user_agent,
                        'loginStatus' => 'Success'
                    ];
                    $JsonData = json_encode($data);
                    mysqli_query($conn, "INSERT INTO `activity_log`(`activity`, `data`, `timestamp`) VALUES ('Login','$JsonData','$today_dateTime')");
                }
                else
                {
                    $res['status'] = 'WrongPass';

                    $user_agent = $_SERVER['HTTP_USER_AGENT'];

                    // Get the user IP address
                    $user_ip = $_SERVER['REMOTE_ADDR'];
                    $data = [
                        'IP' => $user_ip,
                        'Username' => $check['username'],
                        'Role' => $check['role'],
                        'userAgent' => $user_agent,
                        'loginStatus' => 'Faild'
                    ];
                    $JsonData = json_encode($data);
                    mysqli_query($conn, "INSERT INTO `activity_log`(`activity`, `data`, `timestamp`) VALUES ('Login','$JsonData','$today_dateTime')");
                }

            }
            else
            {
                $res['status'] = 'InActive';
                
            }

        }
        else
        {
            $res['status'] = 'notFound';
        }
    }

echo json_encode($res);
?>