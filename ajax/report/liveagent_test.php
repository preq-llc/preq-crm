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
				$callcenter_query = "AND user LIKE '%$call_center%'";
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

					$sth = $con->prepare("SELECT extension , user , conf_exten , status , campaign_id , comments FROM `vicidial_live_agents` where campaign_id='$camp' $callcenter_query");
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

				$sth = $con->prepare("SELECT extension , user , conf_exten , status , campaign_id , comments, server_ip FROM `vicidial_live_agents` where campaign_id='$slctcampvalue' $callcenter_query ");

				$sth->execute();
				$data = $sth->fetchAll(PDO::FETCH_ASSOC);

				$result['status'] = 'Ok';
				$result['data'] = $data;
				$result['campip'] = $dbip;

			}

	}

echo json_encode($result);
?>