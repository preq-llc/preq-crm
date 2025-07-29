<?php
	
    $servername =  "192.168.200.42";
    $dbusername =  "zeal";
    $dbpassword = "4321";
    $database = "zealousv2";
    $conn = new PDO("mysql:host=$servername;dbname=$database", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>