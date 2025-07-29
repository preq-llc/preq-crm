<?php
// echo 'test';
	include '../../config.php';
	include $path.'function/session.php';

	// $role=$_SESSION['role'];
	// $campaign_name=$_SESSION['user_camp'];
	$username = $_SESSION['username'];
	$times=date('H:i');

	$action=$_GET['action'];


	if($action=='all')
	{
		// echo 'test';
			$slctcampvalue=$_GET['slctcampvalue'];
			$fromdatevalue=$_GET['fromdatevalue'];
			$call_center=$_GET['call_center'];
			// include 'db_new51.php';call_center

			$callcenter_query = '';
			if($call_center != "")
			{
				$callcenter_query = "AND va.user LIKE '%$call_center%'";
			}

			if($slctcampvalue == 'FTE_ALL')
			{
				$dual_camps = ['EDU_SB', 'EDU_SB1'];
				$getresponse = [];

				foreach ($dual_camps as $camp) {
					$ss = "select * from campaigns_details where campaign_value='$camp' AND status='ACTIVE'";
					$rr = mysqli_query($conn, $ss) or die(mysqli_error($conn));
					$fr = mysqli_fetch_array($rr);

					$dbip = $fr['camp_ip'];
					$db_name = $fr['db_username'];
					$db_password = $fr['db_password'];
					$db_database = $fr['db_database'];

					$servername =  "$dbip";
					$dbusername =  "$db_name";
					$dbpassword = "$db_password";
					$database = "$db_database";
					$con = new PDO("mysql:host=$servername;dbname=$database", $dbusername, $dbpassword);
					$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

					$sth = $con->prepare("SELECT extension , user , conf_exten , status , campaign_id , comments,  FROM `vicidial_live_agents` where campaign_id='$camp' $callcenter_query");
					$sth->execute();
					$getresult = $sth->fetchAll(PDO::FETCH_ASSOC);
					$getresponse = array_merge($getresponse, $getresult);
				}

				$result['status'] = 'Ok';
				$result['campip'] = $dbip;
				$result['data'] = $getresponse;

			}
			else
			{
				// echo 'test';
				$ss="select * from campaigns_details where campaign_value='$slctcampvalue' AND status='ACTIVE'";
				$rr=mysqli_query($conn,$ss)or die(mysqli_error($conn));
				$fr=mysqli_fetch_array($rr);

				$dbip=$fr['camp_ip'];
				$db_name=$fr['db_username'];
				$db_password=$fr['db_password'];
				$db_database=$fr['db_database'];

				// echo $slctcampvalue;

				$servername =  "$dbip";
				$dbusername =  "$db_name";
				$dbpassword = "$db_password";
				$database = "$db_database";
				$con = new PDO("mysql:host=$servername;dbname=$database", $dbusername, $dbpassword);
				$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				// if($username=='Jennifer' || $username=='Yameen')
				// {
	
				// 	$sth = $con->prepare("SELECT extension , user , conf_exten , status , campaign_id , comments FROM `vicidial_live_agents` where campaign_id='$slctcampvalue' AND user LIKE '%$group%'");
	
				// }
				// else
				// {
				// }
				// SELECT vicidial_live_agents.extension , vicidial_live_agents.user , vicidial_live_agents.conf_exten , vicidial_live_agents.status , vicidial_live_agents.campaign_id , vicidial_live_agents.comments, vicidial_users.full_name FROM `vicidial_live_agents` LEFT JOIN vicidial_users ON vicidial_users.user = vicidial_live_agents.user where vicidial_live_agents.campaign_id='$slctcampvalue' $callcenter_query
				$sth = $con->prepare("SELECT va.extension , va.user , va.conf_exten , va.status , va.campaign_id , va.comments, va.server_ip, va.last_call_time, va.last_update_time, va.calls_today, vicidial_users.full_name ,vc.phone_number FROM vicidial_live_agents va LEFT JOIN vicidial_users ON vicidial_users.user = va.user LEFT JOIN vicidial_closer_log vc ON vc.lead_id = va.lead_id where va.campaign_id='$slctcampvalue' $callcenter_query GROUP BY va.user");

				$sth->execute();
				$data = $sth->fetchAll(PDO::FETCH_ASSOC);

				$result['status'] = 'Ok';
				$result['data'] = $data;
				$result['campip'] = $dbip;

			}

	}
	else if($action == 'waitingcalls')
	{
			$slctcampvalue=$_GET['slctcampvalue'];
			$fromdatevalue=$_GET['fromdatevalue'];
			$call_center=$_GET['call_center'];

			$ss="select * from campaigns_details where campaign_value='$slctcampvalue' AND status='ACTIVE'";
			$rr=mysqli_query($conn,$ss)or die(mysqli_error($conn));
			$fr=mysqli_fetch_array($rr);

			$dbip=$fr['camp_ip'];
			$db_name=$fr['db_username'];
			$db_password=$fr['db_password'];
			$db_database=$fr['db_database'];

			$in_camp_name = $slctcampvalue;
			// echo $slctcampvalue;
			$callcenter_query = '';
			// if($call_center != "")
			// {
			// 	$callcenter_query = "AND va.user LIKE '%$call_center%'";
			// }
			// echo $dbip;
			$servername =  "$dbip";
			$dbusername =  "$db_name";
			$dbpassword = "$db_password";
			$database = "$db_database";
			$con = new PDO("mysql:host=$servername;dbname=$database", $dbusername, $dbpassword);
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$sth = $con->prepare("SELECT * FROM `vicidial_auto_calls` where campaign_id LIKE '%$in_camp_name%'ORDER BY `queue_position` DESC");

				$sth->execute();
				$data = $sth->fetchAll(PDO::FETCH_ASSOC);

				$result['status'] = 'Ok';
				$result['calls_waiting'] = $data;
				// $result['campip'] = $dbip;
	}

	else if ($action == 'extradatainlivecalls') {

			$slctcampvalue=$_GET['slctcampvalue'];
			$fromdatevalue=$_GET['fromdatevalue'];
			$call_center=$_GET['call_center'];
	    // Step 1: Retrieve campaign-specific DB credentials from the central database
	    $campaignQuery = "
	        SELECT * 
	        FROM campaigns_details 
	        WHERE campaign_value = '$slctcampvalue' 
	        AND status = 'ACTIVE'
	    ";
	    $campaignResult = mysqli_query($conn, $campaignQuery) or die(mysqli_error($conn));
	    $campaignData = mysqli_fetch_assoc($campaignResult);

	    // Extract credentials for the remote campaign database
	    $remoteHost     = $campaignData['camp_ip'];
	    $remoteUser     = $campaignData['db_username'];
	    $remotePassword = $campaignData['db_password'];
	    $remoteDatabase = $campaignData['db_database'];

	    try {
	        // Step 2: Connect to the remote campaign database using PDO
	        $pdo = new PDO("mysql:host=$remoteHost;dbname=$remoteDatabase", $remoteUser, $remotePassword);
	        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	        // Step 3: Proceed only if the selected date is today
	        if ($fromdatevalue == $today_date) {
	            // Step 3a: Apply optional filter based on selected call center/user
	            $userFilter = '';
	            if (!empty($call_center)) {
	                $userFilter = " AND val.user LIKE '%$call_center%'";
	            }

	             if($slctcampvalue == "PSPM_ACA" && $slctcampvalueview == "TAX")
                    {
                        $removedDeadSec = '';
                    }
                    else
                    {
                        $removedDeadSec = "+(val.dead_sec)";
                    }

	            // Step 4: Prepare SQL to retrieve aggregated call data per user
	            $query = "
	                SELECT 
	                    SUM(val.talk_sec + val.wait_sec + val.dispo_sec $removedDeadSec) AS Hrs,
	                    SUM(CASE WHEN val.status = 'TRA' THEN 1 ELSE 0 END) AS Transfer,
	                    SUM(CASE WHEN val.status = 'SUBMIT' THEN 1 ELSE 0 END) AS successtransfer
	                FROM 
	                    vicidial_agent_log val
	                WHERE 
	                    val.event_time BETWEEN '$fromdatevalue 00:00:00' AND '$fromdatevalue 23:59:59'
	                    AND val.campaign_id = '$slctcampvalue'
	                    $userFilter
	                GROUP BY 
	                    val.campaign_id
	                ORDER BY 
	                    val.campaign_id ASC
	            ";

	            // Step 5: Execute the query
	            $stmt = $pdo->prepare($query);
	            $stmt->execute();
	            $data = $stmt->fetchAll(PDO::FETCH_ASSOC); // 

	            // Step 6: Return results
	            $result['status'] = 'Ok';
	            $result['tra_waiting'] = $data;
	        }
	    } catch (PDOException $e) {
	        // Handle any database errors
	        echo "Database Error: " . $e->getMessage();
	    }
	}





echo json_encode($result);
?>