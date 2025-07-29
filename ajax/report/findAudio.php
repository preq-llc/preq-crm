<?php
// echo 'test';

include '../../config.php';
include $path.'function/session.php';
$action=$_GET['action'];
$data = [];
// echo 'tet';
$con151 = mysqli_connect('192.168.200.151', 'zeal', '4321', 'asterisk');

if($action == 'getAudio')
{
    $number=$_GET['number'];

    $sql = mysqli_query($con151, "SELECT `filename` FROM `recording_log` WHERE `filename` LIKE '%$number%'");
    
    if($get = mysqli_fetch_assoc($sql))
    {
        $data['status'] = 'Ok';
        $data['filename'] = $get['filename'];
    }
    else
    {
        $data['status'] = 'NoFound';

    }
}

header('Content-Type: application/json');
echo json_encode($data);
?>