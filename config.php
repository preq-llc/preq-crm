<?php

$conn = mysqli_connect('localhost', 'zeal', '4321', 'zealousv2');
// $conn = mysqli_connect('localhost', 'root', '', 'zealous');

if(!$conn)
{
    echo 'Mysql Error :'.mysqli_connect_error();
}

$inf_sql = mysqli_query($conn, "SELECT * FROM app_info");
$get_info = mysqli_fetch_assoc($inf_sql);

if($get_info['key'] == 'site_name')
{
    $site_name = $get_info['value'];
}
if($get_info['key'] == 'site_url')
{
    $path = $get_info['value'];
}
if($get_info['key'] == 'site_domain')
{
    $site_domain = $get_info['value'];
}
    //Path
    // $site_name = 'PreQ';
    // $path = "/Preq-new/";
    // Change time Zone
    date_default_timezone_set('America/New_York');

    $today_date = date('Y-m-d');
    $today_dateTime = date('Y-m-d H:i:s');
?>