<?php
	
include 'db1.php';


$fromdate=$_GET['fromdate'];
	$todate=$_GET['todate'];
	$campaign=$_GET['campaign'];
	$phonenum=$_GET['phonenum'];

			$ss="select * from campaigns_details where campaign_value='$campaign' AND status='ACTIVE'";
                    $rr=mysqli_query($con,$ss)or die(mysqli_error($con));
                    $fr=mysqli_fetch_array($rr);

                    $dbip=$fr['camp_ip'];
                    $db_name=$fr['db_username'];
                    $db_password=$fr['db_password'];

    //.................................. Localhost FETCH DATA End ...................................//


//.................................................. DB Connection start ...................................//

$servername =  "$dbip";
$dbusername =  "$db_name";
$dbpassword = "$db_password";
$database = "asterisk";
$conn = new PDO("mysql:host=$servername;dbname=$database", $dbusername, $dbpassword);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//.................................................. DB Connection End  ...................................//

	
		
	
	$sth = $conn->prepare("SELECT `user_call_log`.`user`, callerid as callerid ,call_date,lead_id,campaign_id  FROM `user_call_log` WHERE `call_date`>='$fromdate 00:00:00' AND `call_date`<='$todate 23:59:59' AND callerid='$phonenum' AND `campaign_id`='$campaign'  group by `user_call_log`.`user` , callerid");

	

	

	$sth->execute();
$result = $sth->fetchAll(PDO::FETCH_ASSOC);


echo json_encode($result);

?>