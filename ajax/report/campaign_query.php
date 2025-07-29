<?php
session_start();
include('../../config.php');
include('../../session.php');

header('Content-Type: application/json'); // <-- Important for proper response type

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$action = $_POST['action'] ?? '';
$username = $_SESSION['username'];
if ($action ="getcampaign") {
    $query = "SELECT id, camp_ip FROM campaigns_details WHERE `status` ='ACTIVE' GROUP BY camp_ip ORDER BY camp_ip ASC";
    $result = mysqli_query($conn, $query);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            'id' => $row['id'],
            'name' => $row['camp_ip'] // Renaming for frontend clarity
        ];
    }

    echo json_encode($data);
    exit;
}

?>