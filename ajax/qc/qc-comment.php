<?php
// include '../../function/DB/pdo-db-59.php';
$conn = mysqli_connect('192.168.200.59', 'zeal', '4321', 'Agent_calls_FAPI');
include $path.'function/session.php';
$action=$_GET['action'];
if($action == 'getQccommentsCount')
{
    $fromdatevalue = $_GET['fromdatevalue'];
    $todatevalue = $_GET['todatevalue'];
    $call_center = $_GET['call_center'];
    $slctcampvalue = $_GET['slctcampvalue'];

    $campQuery = '';
    if($slctcampvalue == '')
    {
        $campQuery = "AND `camp` = '$slctcampvalue'";
    }
    $centerQuery = '';
    if($call_center == '')
    {
        $centerQuery = "AND `agent_username` LIKE '$call_center%'";
    }

    $massArray = [];
    $sql = mysqli_query($conn, "SELECT QC_comments FROM `QC_Reports` WHERE `timestamp`>='$fromdatevalue 00:00:00' AND `timestamp`<='$todatevalue 23:59:59' AND QC_Audited!='' $campQuery $centerQuery");
    while ($get = mysqli_fetch_assoc($sql)) {
        $qcComment = $get['QC_comments'];
        $spltArray = explode(',', $qcComment);
    
        foreach ($spltArray as $splt) {
            $qcsql = mysqli_query($conn, "SELECT dnq FROM `QC_DNQ` WHERE id='$splt'");
            $qcval = mysqli_fetch_assoc($qcsql);
            $value = $qcval['dnq'];
            if (array_key_exists($value, $massArray)) {
                $getLastValue = $massArray[$value];
                $addNewCount = $getLastValue + 1;
                $massArray[$value] = $addNewCount;
            } else {
                $massArray[$value] = 1;
            }
        }
    }
    $res['data'] = $massArray;
    $res['status'] = 'Ok';
}
echo json_encode($res);
?>