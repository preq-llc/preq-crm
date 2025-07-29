<?php
header('Content-Type: application/json');

include '../../function/DB/pdo-db-42.php';
include $path . 'function/session.php';

$action = $_GET['action'] ?? '';

if ($action === 'getagent_username') {
    try {
        $stmt = $conn->prepare("SELECT emp_id FROM users WHERE role = 'qcagent' AND status = 'active'");
        $stmt->execute();
        $agents = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'status' => 'success',
            'data' => $agents
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Query failed: ' . $e->getMessage()
        ]);
    }
    exit;
}

