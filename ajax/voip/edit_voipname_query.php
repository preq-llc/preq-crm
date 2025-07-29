<?php
session_start();
include('../../config.php');
include('../../session.php');

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$action = $_POST['action'] ?? '';

if ($action === 'get_campaign') {
    $query = "SELECT id, voip_name, extension_name FROM voip_master";
    $result = mysqli_query($conn, $query);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    echo json_encode($data);
} else if ($action === 'update_voip') {
    error_log(print_r($_POST, true));

    $id = $_POST['id'];
    $field = $_POST['field'];
    $value = $_POST['value'];
    $allowedFields = ['voip_name', 'extension_name'];
    if (!in_array($field, $allowedFields)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid field']);
        exit;
    }
    $id = mysqli_real_escape_string($conn, $id);
    $value = mysqli_real_escape_string($conn, $value);
    $query = "UPDATE voip_master SET $field = '$value' WHERE id = '$id'";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['success' => 'Update successful']);
    } else {

        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . mysqli_error($conn)]);
    }
}






?>
