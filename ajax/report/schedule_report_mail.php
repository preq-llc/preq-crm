<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include '../../config.php';

$startDate = $_POST['startDate'] ?? '';
$endDate = $_POST['endDate'] ?? '';
$sendTime = $_POST['sendTime'] ?? '05:45';
$format = $_POST['format'] ?? 'xlsx';
$email_to = $_POST['email_to'] ?? '';
$campaign = $_POST['campaign'] ?? ''; // single campaign per request

if (!$startDate || !$endDate || !$sendTime || !$email_to || !$campaign) {
    echo "Missing required fields.";
    exit;
}

$stmt = $conn->prepare("INSERT INTO scheduled_emails (start_date, end_date, campaign, send_time, format, email_to, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')");
$stmt->bind_param("ssssss", $startDate, $endDate, $campaign, $sendTime, $format, $email_to);
$stmt->execute();

echo "Scheduled successfully for campaign: $campaign";
?>
