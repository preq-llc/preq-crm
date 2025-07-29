<?php
session_start();
include('../../config.php');
include('../../session.php');

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$action = $_GET['action'] ?? ($_POST['action'] ?? '');

if ($action == 'getvoipusagedetails') {
    $startDate = $_GET['startDate'] ?? null;
    $endDate = $_GET['endDate'] ?? null;

    $query = "SELECT id, voip_name, entry_date, amount_used FROM voip_usage";
    $params = [];
    $types = '';

    if ($startDate && $endDate) {
        $query .= " WHERE entry_date BETWEEN ? AND ?";
        $params = [$startDate, $endDate];
        $types = 'ss';
    } elseif ($startDate) {
        $query .= " WHERE entry_date >= ?";
        $params = [$startDate];
        $types = 's';
    } elseif ($endDate) {
        $query .= " WHERE entry_date <= ?";
        $params = [$endDate];
        $types = 's';
    }

    $query .= " ORDER BY id ASC";

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare statement']);
        exit;
    }

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode(['status' => 'success', 'data' => $data]);
    $stmt->close();
    exit;
}
else if ($action == 'update_voip_usage') {
    $id = $_POST['id'] ?? null;
    $field = $_POST['field'] ?? null;
    $value = $_POST['value'] ?? null;

    $allowedFields = ['voip_name', 'amount_used', 'entry_date'];

    if ($id && in_array($field, $allowedFields)) {
        $stmt = $conn->prepare("UPDATE voip_usage SET `$field` = ? WHERE id = ?");
        $stmt->bind_param("si", $value, $id);  // "si" = string, integer

        if ($stmt) {
            if ($stmt->execute()) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Execution failed']);
            }
            $stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Query preparation failed']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
    }
    exit;
}
?>
