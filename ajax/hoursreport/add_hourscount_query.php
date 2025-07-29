<?php
session_start();
include('../../config.php');
include('../../session.php');

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$action = $_POST['action'] ?? '';
$username = $_SESSION['username'] ?? '';
$status = $_POST['status'] ?? 'active';

if ($action === "campaign_name") {
    if ($status === 'both') {
        $query = "SELECT id, campaign_value FROM campaigns_details";
        $stmt = $conn->prepare($query);
    } else {
        $query = "SELECT id, campaign_value FROM campaigns_details WHERE status = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $status);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $campaignOptions = [];

    while ($row = $result->fetch_assoc()) {
        $campaignOptions[] = [
            'id' => $row['id'],
            'name' => $row['campaign_value']
        ];
    }

    echo json_encode($campaignOptions);
    exit;
}
