<?php



$dbusername= '192.168.200.59';
$dbpassword= 'zeal';
$servername= '4321';
$database= 'phonenumber_check';

$connnew = mysqli_connect($dbusername, $dbpassword, $servername, $database);
// $conn = mysqli_connect('localhost', 'root', '', 'zealous');

if(!$connnew)
{
    echo 'Mysql Error :'.mysqli_connect_error();
}

    date_default_timezone_set('America/New_York');

    $today_date = date('Y-m-d');
    $today_dateTime = date('Y-m-d H:i:s');
?>