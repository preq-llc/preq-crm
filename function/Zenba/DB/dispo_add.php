

<?php

$Dialed_Camp=$_GET['Dialed_Camp'];

$servername =  "192.168.200.61";
$dbusername =  'zeal';
$dbpassword = '4321';
$database = "asterisk";
$conn = new PDO("mysql:host=$servername;dbname=$database", $dbusername, $dbpassword);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


date_default_timezone_set('America/New_York');
$today_from = date("Y-m-d");
$today_to = date("Y-m-d");

	$sth = $conn->prepare("SELECT * FROM `vicidial_campaign_statuses` where `campaign_id`='$Dialed_Camp'");
	

$sth->execute();
$result = $sth->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($result);


?>