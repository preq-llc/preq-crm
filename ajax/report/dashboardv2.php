<?php
    // echo str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);
    session_start();
    $current_user = $_SESSION['username'];
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
        
        // $ss="select * from campaigns_details where campaign_value='$slctcampvalueview' AND status='ACTIVE'";
        // $rr=mysqli_query($conn,$ss)or die(mysqli_error($conn));
        // $fr=mysqli_fetch_assoc($rr);

        // $dbip=$fr['camp_ip'];
        // $db_name=$fr['db_username'];
        // $db_password=$fr['db_password'];
        // $db_database=$fr['db_database'];
        // $voice_key=$fr['voice_key'];
        // echo $slctcampvalueview;
        $flag = 1;
        $campagns = ['EDU_SB','EDU_SB1', 'EDU_TEST'];
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
            if($fromdatevaluesview != $today_date)
            {
                $sth = $con->prepare("SELECT '$singlecamp' as camp,vicidial_agent_log_archive.user as users ,vicidial_agent_log_archive.event_time,count(vicidial_agent_log_archive.talk_sec) as Totalcalls,sum((vicidial_agent_log_archive.talk_sec)+(vicidial_agent_log_archive.wait_sec)+(vicidial_agent_log_archive.dispo_sec)+(vicidial_agent_log_archive.dead_sec)) as Hrs,sum(case when  vicidial_agent_log_archive.status = 'TRA' || vicidial_agent_log_archive.status = 'TRADS'   then 1 else 0 end) AS Transfer,sum(case when vicidial_agent_log_archive.status = 'SUBMIT' || vicidial_agent_log_archive.status = 'SUBDS' || vicidial_agent_log_archive.status = 'TRA'  || vicidial_agent_log_archive.status = 'TRADS' || vicidial_agent_log_archive.status = 'EDGEDS' || vicidial_agent_log_archive.status = 'DROPIN' then 1 else 0 end) AS successtransfer from vicidial_agent_log_archive INNER JOIN vicidial_users ON vicidial_agent_log_archive.user=vicidial_users.user where vicidial_agent_log_archive.event_time>= '$fromdatevaluesview 00:00:00' AND vicidial_agent_log_archive.event_time <= '$todatevaluesview 23:59:59' AND vicidial_agent_log_archive.campaign_id='$singlecamp'  AND wait_sec<65000 AND talk_sec<65000 AND dispo_sec<65000 AND (vicidial_users.user_level='1' OR vicidial_users.user_level='7') AND vicidial_agent_log_archive.status != 'NULL' AND vicidial_agent_log_archive.user  LIKE '%$call_centervalue%' GROUP BY vicidial_agent_log_archive.user order by vicidial_agent_log_archive.campaign_id ASC");
            }
            else if($fromdatevaluesview == $today_date)
            {
                $sth = $con->prepare("SELECT '$singlecamp' as camp,vicidial_agent_log.user as users ,vicidial_agent_log.event_time,count(vicidial_agent_log.talk_sec) as Totalcalls,sum((vicidial_agent_log.talk_sec)+(vicidial_agent_log.wait_sec)+(vicidial_agent_log.dispo_sec)+(vicidial_agent_log.dead_sec)) as Hrs,sum(case when  vicidial_agent_log.status = 'TRA' || vicidial_agent_log.status = 'TRADS' || vicidial_agent_log.status = 'SALE'  then 1 else 0 end) AS Transfer,sum(case when vicidial_agent_log.status = 'SUBMIT' || vicidial_agent_log.status = 'SUBDS' || vicidial_agent_log.status = 'TRA'  || vicidial_agent_log.status = 'TRADS' || vicidial_agent_log.status = 'EDGEDS' || vicidial_agent_log.status = 'DROPIN' then 1 else 0 end) AS successtransfer from vicidial_agent_log INNER JOIN vicidial_users ON vicidial_agent_log.user=vicidial_users.user where vicidial_agent_log.event_time>= '$fromdatevaluesview 00:00:00' AND vicidial_agent_log.event_time <= '$todatevaluesview 23:59:59' AND vicidial_agent_log.campaign_id='$singlecamp'  AND wait_sec<65000 AND talk_sec<65000 AND dispo_sec<65000 AND (vicidial_users.user_level='1' OR vicidial_users.user_level='7') AND  vicidial_agent_log.status != 'NULL' AND vicidial_agent_log.user  LIKE '%$call_centervalue%' GROUP BY vicidial_agent_log.user order by vicidial_agent_log.campaign_id ASC ");
            }
            $sth->execute();
            $getresult = $sth->fetchAll(PDO::FETCH_ASSOC);
            $getresponse = array_merge($getresponse, $getresult);

        }

        // $result['status'] = 'Ok';
        // $result['data'] = $getresponse;

        // $allDatas =
        // print_r($getresponse);
        
        $edu_test_total_calls = 0;
        $edu_test_Hrs = 0;
        $edu_test_Transfer = 0;
        $edu_test_successtransfer = 0;

        // mysqli_query($conn, "TRUNCATE TABLE `temp_stats`");
        mysqli_query($conn, "DELETE FROM `temp_stats` WHERE `user_id` = '$current_user'");
        // DELETE FROM `activity_log` WHERE `activity_log`.`id` = 3158"
        foreach($getresponse as $response)
        {
            $camp = $response['camp'];
            $users = $response['users'];
            $Totalcalls = $response['Totalcalls'];
            $Hrs = $response['Hrs'];
            $Transfer = $response['Transfer'];
            $successtransfer = $response['successtransfer'];


            // echo $camp;
            if($camp != 'EDU_TEST')
            {
                // echo 'test_camp <br />';

                $sql = mysqli_query($conn, "SELECT * FROM `temp_stats` WHERE `campaign_name` = '$camp' AND `agent_id` = $users AND `user_id` = '$current_user'");
                if($gche = mysqli_fetch_assoc($sql))
                {

                }
                else
                {
                    mysqli_query($conn, "INSERT INTO `temp_stats`(`campaign_name`, `agent_id`, `total_hrs`, `total_calls`, `transfer`, `billable`, `user_id`) VALUES ('$camp', '$users', '$Hrs', '$Totalcalls', '$successtransfer', '$Transfer', '$current_user')");

                }
                // $overall_test_Transfer += $Transfer;
                // $overall_success_Transfer += $successtransfer;
            }
            else
            {
                $edu_test_total_calls += $Totalcalls;
                $edu_test_Hrs += $Hrs;
                $edu_test_Transfer += $Transfer;
                $edu_test_successtransfer += $successtransfer;
            }

        }
        // echo $overall_test_Transfer;
        // echo $overall_success_Transfer;
        // echo $edu_test_total_calls.': total call<br />';
        // echo $edu_test_Transfer.': Billable<br />';
        // echo $edu_test_Hrs.': hr<br />';
        // echo $edu_test_successtransfer.': Transfer <br />';
        // echo $edu_test_Transfer.'<br />';
        $gettingAction = ['transfer', 'billable'];
        // echo $edu_test_successtransfer;
        // echo $edu_test_Transfer;
        foreach($gettingAction as $eakAction)
        {
            if($eakAction == 'transfer')
            {
                $countingPoint = $edu_test_successtransfer;
            }
            else
            {
                $countingPoint = $edu_test_Transfer;
            }
       
                    // Assume $conn is your database connection
                    // $countingPoint = 20;
                    // $lastdate = '2024-07-02';
                    $today_date = date('Y-m-d');
                    // echo $fromdatevaluesview;
                    if($today_date == $fromdatevaluesview)
                    {
                        $HrsQuery = "AND `total_hrs` > 2000";
                    }
                    else
                    {
                        $HrsQuery = "";
                    }
                    $agentCount = 0;

                    $getUser = mysqli_query($conn, "SELECT agent_id FROM `temp_stats` WHERE `agent_id` LIKE 'ZD%' AND `user_id` = '$current_user' $HrsQuery ORDER BY `agent_id` ASC");
                    $agents = [];
                    while($thisAgent = mysqli_fetch_assoc($getUser)) {
                        $agents[] = $thisAgent['agent_id'];
                        $agentCount++;  
                    }

                    // echo $agentCount;
                    $currentAgentIndex = 0;

                    for ($i = 1; $i <= $countingPoint; $i++) {
                        $thisAgentId = $agents[$currentAgentIndex];
                        // echo $thisAgentId;
                        if ($eakAction == 'transfer') {
                            mysqli_query($conn, "UPDATE `temp_stats` SET `transfer` = `transfer` + 1 WHERE `agent_id` = '$thisAgentId' AND `user_id` = '$current_user'");
                        } else {
                            mysqli_query($conn, "UPDATE `temp_stats` SET `billable` = `billable` + 1 WHERE `agent_id` = '$thisAgentId' AND `user_id` = '$current_user'");
                        }
                        
                        // Move to the next agent
                        $currentAgentIndex++;
                        
                        // If we reached the last agent, start again from the first agent
                        if ($currentAgentIndex >= $agentCount) {
                            $currentAgentIndex = 0;
                        }
                    }

                  

                    
        }
        if($slctcampvalueview == "FTE_ALL")
        {
            $campQuery = '';
        }
        else
        {
            $campQuery = "AND campaign_name = '$slctcampvalueview'";
        }

        $callCalterQuery = '';
        if($call_centervalue != "")
        {
            $callCalterQuery = "AND agent_id LIKE '$call_centervalue%'";
        }

        $getFinSql = mysqli_query($conn, "SELECT * FROM `temp_stats` WHERE `user_id` = '$current_user' $campQuery $callCalterQuery");
        while($finalData = mysqli_fetch_assoc($getFinSql))
        {
            $res['data'][] = $finalData;
        }
        
        $res['status'] = 'Ok';
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
        $sql = mysqli_query($conn, "SELECT campaign , display_name FROM `allow_camps` WHERE $current_username='ACCEPT' AND campaign!='SUBS_ALL'");
        while($data = mysqli_fetch_assoc($sql))
        {
            $result['data'][] = $data;
        }
        $result['status'] = 'Ok';
    }

    // if($action != 'selectcamp' && $slctcampvalueview != 'FTE_ALL')
    // {
        // $sth->execute();
        // $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        // 
        // $result['status'] = 'Ok';
        // $result['data'] = $data;
    // }
    // 
    
    echo json_encode($res);

?>