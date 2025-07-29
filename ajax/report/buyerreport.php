<?php
// echo 'test';

include '../../config.php';
include $path.'function/session.php';
include '../../function/DB/db-70.php';
$action=$_GET['action'];
$data = [];
// echo 'tet';
if($action == 'getbuyerreport')
{
    $fromdatevalue=$_GET['fromdatevalue'];
    $todatevalue=$_GET['todatevalue'];
    $slctcampvalue=$_GET['slctcampvalue'];
    $buyer_id = $_GET['buyer_id'];

    $buyer_id_array = explode(',', $buyer_id);

    $currentData = [];
    $createNewArray = [];
    $count = 0;
    $chck_sql = mysqli_query($conn, "SELECT * FROM `campaigns_details` WHERE `campaign_value` = '$slctcampvalue'");
    $get_fil = mysqli_fetch_assoc($chck_sql);
    $serverip = $get_fil['camp_ip'];
    $serverusrename = $get_fil['db_username'];
    $serverpassword = $get_fil['db_password'];
    $serverdb = $get_fil['db_database'];

    $camDb = mysqli_connect($serverip, $serverusrename, $serverpassword, $serverdb);

    $dbName = 'vicidial_agent_log';

    if($today_date != $fromdatevalue)
    {
        $dbName = 'vicidial_agent_log_archive';
    }


    $buyerCount = 1;
    foreach($buyer_id_array as $oneByer) {

        $bufferSec = 120;
        if($oneByer == '307937944')
        {
            $bufferSec = 180;
        }

        $buyerName = "buyer ".$buyerCount++;
        $sql = mysqli_query($con70, "SELECT *, '$slctcampvalue' AS camp, '$buyerName' AS buyername FROM `recording_log` WHERE `start_time` BETWEEN '$fromdatevalue 00:00:00' AND '$todatevalue 23:59:59' AND `user` = '$oneByer' AND length_in_sec >= '$bufferSec' ORDER BY `length_in_sec` DESC");
        while($getData = mysqli_fetch_assoc($sql)) 
        {
            $phoneNo = $getData['extension'];
            $starttime = $getData['start_time'];

            $cmDb = mysqli_query($camDb, "SELECT vl.user as agent_id, vu.full_name as agent_name FROM user_call_log ul 
                                          LEFT JOIN $dbName vl ON ul.lead_id = vl.lead_id 
                                          LEFT JOIN vicidial_users vu ON vu.user = vl.user 
                                          WHERE ul.callerid='$phoneNo'
                                          AND vl.status IN ('TRA', 'SUBMIT', 'CTRA')
                                          AND ul.campaign_id = '$slctcampvalue'");
            $getcm = mysqli_fetch_assoc($cmDb);
            // print_r('test'.$getcm);
            $getData['agent_id'] = $getcm['agent_id'];
            $getData['agent_name'] = $getcm['agent_name'];


            // print_r('agentid' . $getcm['agent_id']);
            // print_r( $getcm['agent_name']);
      
            if (!isset($createNewArray[$phoneNo]) || $createNewArray[$phoneNo]['length_in_sec'] < $getData['length_in_sec']) {
                $createNewArray[$phoneNo] = $getData;
            }
        }
    }
    
    $data['data'] = $createNewArray;

    $data['status'] = 'Ok';
}

header('Content-Type: application/json');
echo json_encode($data);
?>