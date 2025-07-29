<?php
// echo 'test';
include '../../config.php';
// include '../../function/DB/local-db.php';
include $path.'function/session.php';
$action=$_GET['action'];
$data = [];
$slctcampvalue = 'NONE';

if($action == 'getBilling')
{
    $fromdatevalue=$_GET['fromdatevalue'];
    $todatevalue=$_GET['todatevalue'];
    $slctcampvalue=$_GET['slctcampvalue'];

    if($slctcampvalue == '')
    {
        // echo 'test';
        $query  = mysqli_query($conn, "SELECT * FROM `campaigns_details` WHERE `status` = 'Active'");
        while($getCamps = mysqli_fetch_assoc($query))
        {
            $campaigns[] = $getCamps['campaign_value'];
        }
    }
    else
    {
        $campaigns = [$slctcampvalue];
    }

    if($fromdatevalue == $today_date)
    {
        $rootDbname = 'vicidial_agent_log';

    }
    else if($fromdatevalue != $today_date)
    {
        $rootDbname = 'vicidial_agent_log_archive';
    }
    // echo $fromdatevalue;
    // echo $today_date;
    foreach($campaigns as $camp)
    {
        echo $camp.'<br>';
        $sql  = mysqli_query($conn, "SELECT * FROM `campaigns_details` WHERE `campaign_value` = '$camp'");
        if($getDetai = mysqli_fetch_assoc($sql))
        {
            $servername =  $getDetai['camp_ip'];
            $dbusername =  $getDetai['db_username'];
            $dbpassword = $getDetai['db_password'];
            $database = $getDetai['db_database'];
            $tempCon = new PDO("mysql:host=$servername;dbname=$database", $dbusername, $dbpassword);
            $tempCon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            if($camp == 'EDU_SB1')
            {
                if($fromdatevalue != $today_date)
                {
                    $servername =  '192.168.200.231';
                }
            }
            // echo $today_date;
            $getQ = mysqli_query($tempCon, "SELECT $rootDbname.campaign_id as camp,$rootDbname.user as users ,vicidial_users.full_name,$rootDbname.event_time,count($rootDbname.talk_sec) as Totalcalls,sum(($rootDbname.talk_sec)+($rootDbname.wait_sec)+($rootDbname.dispo_sec)+($rootDbname.dead_sec)) as Hrs,sum(case when $rootDbname.status = 'TRA' || $rootDbname.status = 'IBTRA' then 1 else 0 end) AS Transfer,sum(case when $rootDbname.status = 'TRA' || $rootDbname.status = 'NOIB' || $rootDbname.status = 'DROPIN' then 1 else 0 end) AS successtransfer from $rootDbname INNER JOIN vicidial_users ON $rootDbname.user=vicidial_users.user where $rootDbname.event_time>= '$fromdatevalue 00:00:00' and $rootDbname.event_time <= '$fromdatevalue 23:59:59' AND $rootDbname.campaign_id='$camp' AND wait_sec<65000 AND talk_sec<65000 AND dispo_sec<65000 AND (vicidial_users.user_level='1' OR vicidial_users.user_level='7') AND $rootDbname.status != 'NULL' GROUP BY $rootDbname.user order by $rootDbname.campaign_id ASC");
            if($getC = mysqli_fetch_assoc($getQ))
            {
                $data[$camp][] = $getC;
            }
            // $sth = $tempCon->prepare("SELECT $rootDbname.campaign_id as camp,$rootDbname.user as users ,vicidial_users.full_name,$rootDbname.event_time,count($rootDbname.talk_sec) as Totalcalls,sum(($rootDbname.talk_sec)+($rootDbname.wait_sec)+($rootDbname.dispo_sec)+($rootDbname.dead_sec)) as Hrs,sum(case when $rootDbname.status = 'TRA' || $rootDbname.status = 'IBTRA' then 1 else 0 end) AS Transfer,sum(case when $rootDbname.status = 'TRA' || $rootDbname.status = 'NOIB' || $rootDbname.status = 'DROPIN' then 1 else 0 end) AS successtransfer from $rootDbname INNER JOIN vicidial_users ON $rootDbname.user=vicidial_users.user where $rootDbname.event_time>= '$fromdatevalue 00:00:00' and $rootDbname.event_time <= '$fromdatevalue 23:59:59' AND $rootDbname.campaign_id='$camp' AND wait_sec<65000 AND talk_sec<65000 AND dispo_sec<65000 AND (vicidial_users.user_level='1' OR vicidial_users.user_level='7') AND $rootDbname.status != 'NULL' GROUP BY $rootDbname.user order by $rootDbname.campaign_id ASC
            // ");
        }


    }
      
    $result['status'] = "Ok";
}


    // $sth->execute();
    // $data = $sth->fetchAll(PDO::FETCH_ASSOC);
    $result['data'] = $data;

echo json_encode($result);

?>