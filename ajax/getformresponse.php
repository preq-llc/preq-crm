<?php
    $conn = mysqli_connect('localhost', 'zeal', '4321', 'zealousv2');
    $res = [];
    if(isset($_GET['action']) == 'webhook')
    {
        $camp = $_GET['camp'];
        $phone = $_GET['phone'];
        $sec = $_GET['sec'];
        $result = $_GET['result'];

        if($phone != '' && $result != '')
        {
            mysqli_query($conn, "INSERT INTO `webhook_result`(`phone`, `camp`, `sec`, `result`) VALUES ('$phone', '$camp', '$sec', '$result')");
            $insertId = mysqli_insert_id($conn);
            $res['status'] = 'Ok';
            $res['record_id'] = $insertId;
        }
        else
        {
            $res['status'] = 'Phone or result is missing!';
        }
        
    }
    else
    {
        $res['status'] = 'Action is Missing!';
    }
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($res);
?>