

<?php
	

		 include 'db1.php';
         // include 'db131.php';
	
	$userview=mysqli_real_escape_string($con,$_POST['userview']);
    $leadidnew=mysqli_real_escape_string($con,$_POST['leadidnew']);
    $campaignnew=mysqli_real_escape_string($con,$_POST['campaignnew']);
    $datenew=mysqli_real_escape_string($con,$_POST['datenew']);


    $ss="select * from campaigns_details where campaign_value='$campaignnew' AND status='ACTIVE'";
                    $rr=mysqli_query($con,$ss)or die(mysqli_error($con));
                    $fr=mysqli_fetch_array($rr);

                    $dbip=$fr['camp_ip'];
                    $db_name=$fr['db_username'];
                    $db_password=$fr['db_password'];

    //.................................. Localhost FETCH DATA End ...................................//


//.................................................. DB Connection start ...................................//

$con = mysqli_connect("$dbip","$db_name","$db_password","asterisk");

//.................................................. DB Connection End  ...................................//


	 if(mysqli_query($con, "UPDATE `asterisk`.`vicidial_agent_log` SET `status` = 'TRA' WHERE  `vicidial_agent_log`.`event_time` LIKE '%$datenew%' AND  `vicidial_agent_log`.`campaign_id` ='$campaignnew' AND `vicidial_agent_log`.`lead_id` ='$leadidnew' AND `vicidial_agent_log`.`status` ='SUBMIT' ")) {
     
     echo '1';

    } else {
       echo "Error: " . $sql . "" . mysqli_error($con);
    }
 
    mysqli_close($con);

?>











