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
if ($action == "create") {
    $voip_name = $_POST['voip_name'] ?? '';
    $extension_name = $_POST['extension_name'] ?? '';

    if (!empty($voip_name)) {
        // Check if voip_name already exists
        $checkStmt = $conn->prepare("SELECT id FROM voip_master WHERE voip_name = ?");
        $checkStmt->bind_param("s", $voip_name);
        $checkStmt->execute();
        $checkStmt->store_result();
    
        if ($checkStmt->num_rows > 0) {
            echo json_encode(['status' => 'error', 'message' => 'VoIP name already exists.']);
            $checkStmt->close();
            exit;
        }
        $checkStmt->close();
    
        // Proceed with insert
        $stmt = $conn->prepare("INSERT INTO voip_master (voip_name, extension_name, created_by) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $voip_name, $extension_name, $username);
    
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'VoIP entry added successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database insert failed.']);
        }
    
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'VoIP name is required.']);
    }
    exit;
    
} else if ($action = "voipapend") {
    $query = "SELECT id, voip_name FROM voip_master ORDER BY voip_name ASC";
    $result = $conn->query($query);

    $voipOptions = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $voipOptions[] = [
                'id' => $row['id'],
                'name' => $row['voip_name']
            ];
        }
    }

    echo json_encode($voipOptions);
} 
