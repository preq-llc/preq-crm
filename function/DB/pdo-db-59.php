<?php
	
    $servername =  "192.168.200.59";
    $dbusername =  "zeal";
    $dbpassword = "4321";
    $database = "Agent_calls_FAPI";
    $conn = new PDO("mysql:host=$servername;dbname=$database", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>