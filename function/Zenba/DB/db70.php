<?php
	
$servername =  "192.168.200.70";
$dbusername =  "zeal";
$dbpassword = "4321";
$database = "asterisk";
$conn = new PDO("mysql:host=$servername;dbname=$database", $dbusername, $dbpassword);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$servername2 =  "192.168.200.71";
$dbusername2 =  "zeal";
$dbpassword2 = "4321";
$database2 = "asterisk";
$conn2 = new PDO("mysql:host=$servername2;dbname=$database2", $dbusername2, $dbpassword2);
$conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>