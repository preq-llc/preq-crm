<?php
// echo 'test';

include '../../config.php';
include $path.'function/session.php';
include '../../function/DB/db-70.php';
$action=$_GET['action'];
$data = [];
// echo 'tet';
if($action == 'getcampdetails')
{
    $fromdatevalue=$_GET['fromdatevalue'];
    $todatevalue=$_GET['todatevalue'];
    

    $chck_sql = mysqli_query($conn, "SELECT * FROM `campaigns_details` WHERE `status` = 'ACTIVE'");
    while($get_fil = mysqli_fetch_assoc($chck_sql))
    {
        $data['data'][] = $get_fil;
    }
   
}

header('Content-Type: application/json');
echo json_encode($data);
?>