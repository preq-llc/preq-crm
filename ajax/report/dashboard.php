<?php
    // echo str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);
    // session_start();
    // $current_user = $_SESSION['username'];
    include('../../config.php');
    // include($path.'DB/local-db.php');
    date_default_timezone_set('America/New_York');

    $today_date=date("Y-m-d");
    
    $action = $_GET['action'];
    $result = array();

    if(isset($_GET['startDate']))
    {
        $fromdatevaluesview=$_GET['startDate'];
        $todatevaluesview=$_GET['endDate'];
        $slctcampvalueview=$_GET['campaign_name'];
        $call_centervalue=$_GET['call_center'];
    }

    if($action == 'report')
    {
        
        $ss="select * from campaigns_details where campaign_value='$slctcampvalueview' AND status='ACTIVE'";
        $rr=mysqli_query($conn,$ss)or die(mysqli_error($conn));
        $fr=mysqli_fetch_assoc($rr);

        $dbip=$fr['camp_ip'];
        $db_name=$fr['db_username'];
        $db_password=$fr['db_password'];
        $db_database=$fr['db_database'];
        $voice_key=$fr['voice_key'];

        if($slctcampvalueview != 'FTE_ALL')
        {
           
            
            // echo 'test';
            if($slctcampvalueview == 'EDU_SB1')
            {
                if($fromdatevaluesview == $today_date)
                {
                    $servername =  "$dbip";
        
                }
                else
                {
                    $servername =  "192.168.200.231";
        
                }
            }
            else
            {
                $servername =  "$dbip";
            }
            // echo $call_centervalue;
            $dbusername =  "$db_name";
            $dbpassword = "$db_password";
            $database = "$db_database";
            try
            {
                $con = new PDO("mysql:host=$servername;dbname=$database", $dbusername, $dbpassword);
                $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                if($fromdatevaluesview != $today_date)
                {
                    $callcenter_query = '';
                    if($call_centervalue != '')
                    {
                        $callcenter_query = " AND vicidial_agent_log_archive.user  LIKE '%$call_centervalue%'";
                    }
                    if($slctcampvalueview == "PSPM_ACA" || $slctcampvalueview == "TAX")
                    {
                        $removedDeadSec = '';
                    }
                    else
                    {
                        $removedDeadSec = "+(vicidial_agent_log_archive.dead_sec)";
                    }

                    if($slctcampvalueview != "SSDI"){

                     $adddropin = "|| vicidial_agent_log_archive.status = 'DROPIN'";

                    }
                    else{

                        $adddropin ='';
                    }



                    if($slctcampvalueview == 'ACA1'){


                      $addmedds = ",sum(case when vicidial_agent_log_archive.status = 'MEDDS' then 1 else 0 end) AS medds";
           

                    }

                    else{


                        $addmedds = "";

                    }
                        // if($slctcampvalueview != "SHOW1")
                        // {
                            $sth = $con->prepare("SELECT vicidial_agent_log_archive.campaign_id as camp,vicidial_agent_log_archive.user as users ,vicidial_users.full_name as username, vicidial_agent_log_archive.event_time,count(vicidial_agent_log_archive.talk_sec) as Totalcalls, sum((vicidial_agent_log_archive.talk_sec)+(vicidial_agent_log_archive.wait_sec)+(vicidial_agent_log_archive.dispo_sec)$removedDeadSec) as Hrs,sum(vicidial_agent_log_archive.pause_sec) AS pause_sec, sum(case when  vicidial_agent_log_archive.status = 'TRA' || vicidial_agent_log_archive.status = 'TRADS'  then 1 else 0 end) AS Transfer,sum(case when vicidial_agent_log_archive.status = 'SUBMIT' || vicidial_agent_log_archive.status = 'SUBDS' || vicidial_agent_log_archive.status = 'TRA'  || vicidial_agent_log_archive.status = 'TRADS' || vicidial_agent_log_archive.status = 'EDGEDS' || vicidial_agent_log_archive.status = 'APPS' || vicidial_agent_log_archive.status = 'TD'  $adddropin then 1 else 0 end) AS successtransfer  $addmedds from vicidial_agent_log_archive INNER JOIN vicidial_users ON vicidial_agent_log_archive.user=vicidial_users.user where vicidial_agent_log_archive.event_time>= '$fromdatevaluesview 00:00:00' AND vicidial_agent_log_archive.event_time <= '$todatevaluesview 23:59:59' AND vicidial_agent_log_archive.campaign_id='$slctcampvalueview' $callcenter_query AND wait_sec<65000 AND talk_sec<65000 AND dispo_sec<65000 AND (vicidial_users.user_level='1' OR vicidial_users.user_level='7') AND vicidial_agent_log_archive.status != 'NULL' GROUP BY vicidial_agent_log_archive.user order by vicidial_agent_log_archive.campaign_id ASC");
                        // }
                        // else
                        // {
                        //     $result['status'] = 'Error';
                        //     // $result['data'] = $data;
                        // }
                        
                    
                }
                else if($fromdatevaluesview == $today_date)
                {
                    $callcenter_query = '';
                    if($call_centervalue != '')
                    {
                        $callcenter_query = " AND vicidial_agent_log.user  LIKE '%$call_centervalue%'";
                    }
                    if($slctcampvalueview == "PSPM_ACA" || $slctcampvalueview == "TAX")
                    {
                        $removedDeadSec = '';
                    }
                    else
                    {
                        $removedDeadSec = "+(vicidial_agent_log.dead_sec)";
                    }

                    if($slctcampvalueview != "SSDI"){

                     $adddropin = "|| vicidial_agent_log.status = 'DROPIN'";
                     
                    }
                    else{

                        $adddropin ='';
                    }

                    if($slctcampvalueview == 'ACA1'){


                      $addmedds = ",sum(case when vicidial_agent_log.status = 'MEDDS' then 1 else 0 end) AS medds";
                      // echo    $addmedds;

                    }

                    else{


                        $addmedds = "";

                    }
                       
                    // $Stime = ($Stalk_sec + $Spause_sec + $Swait_sec + $Sdispo_sec);
                        $sth = $con->prepare("SELECT vicidial_agent_log.campaign_id as camp,vicidial_agent_log.user as users ,vicidial_users.full_name as username,vicidial_agent_log.event_time,count(vicidial_agent_log.talk_sec) as Totalcalls,sum((vicidial_agent_log.talk_sec)+(vicidial_agent_log.wait_sec)+(vicidial_agent_log.dispo_sec)$removedDeadSec) as Hrs, sum(vicidial_agent_log.pause_sec) AS pause_sec, sum(case when  vicidial_agent_log.status = 'TRA' || vicidial_agent_log.status = 'TRADS' || vicidial_agent_log.status = 'SALE'  then 1 else 0 end) AS Transfer,sum(case when vicidial_agent_log.status = 'SUBMIT' || vicidial_agent_log.status = 'SUBDS' || vicidial_agent_log.status = 'TRA'  || vicidial_agent_log.status = 'TRADS' || vicidial_agent_log.status = 'EDGEDS' || vicidial_agent_log.status = 'APPS' || vicidial_agent_log.status = 'TD' $adddropin then 1 else 0 end) AS successtransfer $addmedds from vicidial_agent_log INNER JOIN vicidial_users ON vicidial_agent_log.user=vicidial_users.user where vicidial_agent_log.event_time>= '$fromdatevaluesview 00:00:00' AND vicidial_agent_log.event_time <= '$todatevaluesview 23:59:59' AND vicidial_agent_log.campaign_id='$slctcampvalueview' $callcenter_query AND wait_sec<65000 AND talk_sec<65000 AND dispo_sec<65000 AND (vicidial_users.user_level='1' OR vicidial_users.user_level='7') AND  vicidial_agent_log.status != 'NULL' AND vicidial_agent_log.user  LIKE '%$voice_key%'  GROUP BY vicidial_agent_log.user order by vicidial_agent_log.campaign_id ASC");
                }

                $result['status'] = 'Ok';
            }
            catch (PDOException $e) 
            {
                // Handle database connection or query errors
                echo "Error: " . $e->getMessage();
            }

        }
        else
        {
            
            $flag = 1;
            $campagns = ['EDU_SB','EDU_SB1'];
            $getresponse = [];
            foreach($campagns as $singlecamp)
            {
                $ss="select * from campaigns_details where campaign_value='$singlecamp' AND status='ACTIVE'";
                $rr=mysqli_query($conn,$ss)or die(mysqli_error($conn));
                $fr=mysqli_fetch_array($rr);
        
                $dbip=$fr['camp_ip'];
                $db_name=$fr['db_username'];
                $db_password=$fr['db_password'];
                $db_database=$fr['db_database'];
                $voice_key=$fr['voice_key'];

                if($singlecamp == "EDU_SB1")
                {
                    if($fromdatevaluesview == $today_date)
                    {
                        $servername =  "$dbip";
        
                    }
                    else
                    {
                        $servername =  "192.168.200.231";
        
                    }
                }
                else
                {
                    $servername =  "$dbip";

                }
                $dbusername =  "$db_name";
                $dbpassword = "$db_password";
                $database = "$db_database";
                $con = new PDO("mysql:host=$servername;dbname=$database", $dbusername, $dbpassword);
                $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // if($fromdatevaluesview != $today_date)
                // {
                //     $sth = $con->prepare("SELECT 'EDU_SB' as camp,vicidial_agent_log_archive.user as users ,vicidial_agent_log_archive.event_time,count(vicidial_agent_log_archive.talk_sec) as Totalcalls,sum((vicidial_agent_log_archive.talk_sec)+(vicidial_agent_log_archive.wait_sec)+(vicidial_agent_log_archive.dispo_sec)+(vicidial_agent_log_archive.dead_sec)) as Hrs,sum(case when  vicidial_agent_log_archive.status = 'TRA' || vicidial_agent_log_archive.status = 'TRADS'   then 1 else 0 end) AS Transfer,sum(case when vicidial_agent_log_archive.status = 'SUBMIT' || vicidial_agent_log_archive.status = 'SUBDS' || vicidial_agent_log_archive.status = 'TRA'  || vicidial_agent_log_archive.status = 'TRADS' || vicidial_agent_log_archive.status = 'EDGEDS' || vicidial_agent_log_archive.status = 'DROPIN' || vicidial_agent_log_archive.status = 'APPS' then 1 else 0 end) AS successtransfer from vicidial_agent_log_archive INNER JOIN vicidial_users ON vicidial_agent_log_archive.user=vicidial_users.user where vicidial_agent_log_archive.event_time>= '$fromdatevaluesview 00:00:00' AND vicidial_agent_log_archive.event_time <= '$todatevaluesview 23:59:59' AND vicidial_agent_log_archive.campaign_id='$singlecamp'  AND wait_sec<65000 AND talk_sec<65000 AND dispo_sec<65000 AND (vicidial_users.user_level='1' OR vicidial_users.user_level='7') AND vicidial_agent_log_archive.status != 'NULL' AND vicidial_agent_log_archive.user  LIKE '%$call_centervalue%' GROUP BY vicidial_agent_log_archive.user order by vicidial_agent_log_archive.campaign_id ASC");
                // }
                // else if($fromdatevaluesview == $today_date)
                // {
                //     $sth = $con->prepare("SELECT 'EDU_SB' as camp,vicidial_agent_log.user as users ,vicidial_agent_log.event_time,count(vicidial_agent_log.talk_sec) as Totalcalls,sum((vicidial_agent_log.talk_sec)+(vicidial_agent_log.wait_sec)+(vicidial_agent_log.dispo_sec)+(vicidial_agent_log.dead_sec)) as Hrs,sum(case when  vicidial_agent_log.status = 'TRA' || vicidial_agent_log.status = 'TRADS' || vicidial_agent_log.status = 'SALE'  then 1 else 0 end) AS Transfer,sum(case when vicidial_agent_log.status = 'SUBMIT' || vicidial_agent_log.status = 'SUBDS' || vicidial_agent_log.status = 'TRA'  || vicidial_agent_log.status = 'TRADS' || vicidial_agent_log.status = 'EDGEDS' || vicidial_agent_log.status = 'DROPIN' || vicidial_agent_log.status = 'APPS' then 1 else 0 end) AS successtransfer from vicidial_agent_log INNER JOIN vicidial_users ON vicidial_agent_log.user=vicidial_users.user where vicidial_agent_log.event_time>= '$fromdatevaluesview 00:00:00' AND vicidial_agent_log.event_time <= '$todatevaluesview 23:59:59' AND vicidial_agent_log.campaign_id='$singlecamp'  AND wait_sec<65000 AND talk_sec<65000 AND dispo_sec<65000 AND (vicidial_users.user_level='1' OR vicidial_users.user_level='7') AND  vicidial_agent_log.status != 'NULL' AND vicidial_agent_log.user  LIKE '%$call_centervalue%' GROUP BY vicidial_agent_log.user order by vicidial_agent_log.campaign_id ASC ");
                // }
                $sth->execute();
                $getresult = $sth->fetchAll(PDO::FETCH_ASSOC);
                $getresponse = array_merge($getresponse, $getresult);

            }
            $result['status'] = 'Ok';
            $result['data'] = $getresponse;
           
        }
    }
    else if($action == 'liveagent')
    {
        $slctcampvalueview=$_GET['campaign_name'];

        if($slctcampvalueview == "FTE_ALL")
        {
            
            $flag = 1;
            $campagns = ['EDU_SB','EDU_SB1'];
            $getresponse = [];
            foreach($campagns as $singlecamp)
            {
                $ss="select * from campaigns_details where campaign_value='$singlecamp' AND status='ACTIVE'";
                $rr=mysqli_query($conn,$ss)or die(mysqli_error($conn));
                $fr=mysqli_fetch_array($rr);
        
                $dbip=$fr['camp_ip'];
                $db_name=$fr['db_username'];
                $db_password=$fr['db_password'];
                $db_database=$fr['db_database'];
                $voice_key=$fr['voice_key'];

                if($singlecamp == "EDU_SB1")
                {
                    if($fromdatevaluesview == $today_date)
                    {
                        $servername =  "$dbip";
        
                    }
                    else
                    {
                        $servername =  "192.168.200.231";
        
                    }
                }
                else
                {
                    $servername =  "$dbip";

                }
                $dbusername =  "$db_name";
                $dbpassword = "$db_password";
                $database = "$db_database";
                $con = new PDO("mysql:host=$servername;dbname=$database", $dbusername, $dbpassword);
                $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $sth = $con->prepare("SELECT user as liveagent FROM `vicidial_live_agents` WHERE `last_update_time` LIKE '%$today_date%' AND campaign_id='$singlecamp'");
                
                $sth->execute();
                $getresult = $sth->fetchAll(PDO::FETCH_ASSOC);
                $getresponse = array_merge($getresponse, $getresult);

            }
            $result['status'] = 'Ok';
            $result['data'] = $getresponse;
           
        }
        else
        {

            $ss="select * from campaigns_details where campaign_value='$slctcampvalueview' AND status='ACTIVE'";
            $rr=mysqli_query($conn,$ss)or die(mysqli_error($conn));
            $fr=mysqli_fetch_array($rr);
    
            $dbip=$fr['camp_ip'];
            $db_name=$fr['db_username'];
            $db_password=$fr['db_password'];
            $db_database=$fr['db_database'];
            $voice_key=$fr['voice_key'];
    
            if($slctcampvalueview == 'EDU_SB1')
            {
                if($fromdatevaluesview == $today_date)
                {
                    $servername =  "$dbip";
        
                }
                else
                {
                    $servername =  "192.168.200.231";
        
                }
            }
            else
            {
                $servername =  "$dbip";
            }
            // echo $servername;
    
            $dbusername =  "$db_name";
            $dbpassword = "$db_password";
            $database = "$db_database";
            $con = new PDO("mysql:host=$servername;dbname=$database", $dbusername, $dbpassword);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            $sth = $con->prepare("SELECT user as liveagent FROM `vicidial_live_agents` WHERE `last_update_time` LIKE '%$today_date%' AND campaign_id='$slctcampvalueview'");
            
        }


    }
    else if($action == 'selectcamp')
    {
        $current_username = $_GET['current_username'];
        // $sth = $conn->prepare("SELECT campaign , display_name FROM `allow_camps` WHERE $current_username='ACCEPT' AND campaign!='SUBS_ALL' ");
        // echo $current_username;
        $sql = mysqli_query($conn, "SELECT ac.campaign , ac.display_name, cd.buyer_id, cd.camp_ip, cd.id FROM allow_camps ac LEFT JOIN campaigns_details cd ON cd.campaign_value = ac.campaign WHERE `$current_username`='ACCEPT' AND `campaign`!='SUBS_ALL' AND cd.status = 'ACTIVE' ORDER BY cd.id ASC");
        while($data = mysqli_fetch_assoc($sql))
        {
            $result['data'][] = $data;
        }
        $result['status'] = 'Ok';
    }
    // else if($action == 'showcampext')
    // {
    //     $sth = $con->prepare("SELECT count(uniqueid) as total_dials, SUM(case when phone_number duplicate count which is heigest number its that list_id count) FROM `vicidial_log`");
    // }
    if($action != 'selectcamp' && $slctcampvalueview != 'FTE_ALL')
    {
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        
        $result['status'] = 'Ok';
        $result['data'] = $data;
    }
    
    
    echo json_encode($result);

?>