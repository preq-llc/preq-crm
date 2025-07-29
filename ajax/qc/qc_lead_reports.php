<?php

include '../../function/DB/pdo-db-59.php';
include '../../function/session.php';

date_default_timezone_set('America/New_York');
$today_from = date("Y-m-d");

$role=$_SESSION['role'];
$username = $_SESSION['username'];
$group = $_SESSION['group'];
$sth = $conn->prepare("SELECT * FROM `QC_Reports` WHERE `timestamp`>='$today_from 00:00:00' AND `timestamp`<='$today_from 23:59:59' AND QC_Audited='$username' AND final_status='WIP'");



$sth->execute();
$result = $sth->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($result);
?>