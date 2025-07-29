<?php
include '../../config.php';
include $path . 'function/session.php';

$action = $_GET['action'] ?? '';
$data = [];

if ($action === "dncreport") {
    // Get POST data
    $key = $_POST['key'] ?? '';
    $value = $_POST['value'] ?? '';

    if (!empty($key) && is_numeric($value)) {
        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("UPDATE app_info SET value = ? WHERE `key` = ?");
        $stmt->bind_param("ss", $value, $key);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Value updated']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update']);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
    }

    exit;
}
else if ($_GET['action'] == 'selectdncreport') {

    $key = 'dnc_report'; 

    $stmt = $conn->prepare("SELECT value FROM app_info WHERE `key` = ?");
    $stmt->bind_param("s", $key);
    $stmt->execute();
    $stmt->bind_result($value);

    if ($stmt->fetch()) {
        echo json_encode(["value" => $value]);
    } else {
        echo json_encode(["value" => ""]);
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>
