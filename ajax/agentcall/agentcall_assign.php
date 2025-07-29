<?php
include '../../function/DB/pdo-db-59.php';
include '../../function/session.php';

$action = $_GET['action'] ?? '';

if ($action === 'getagent_status') {
    try {
        $stmt = $conn->prepare("SELECT DISTINCT status FROM QC_Reports WHERE status IS NOT NULL AND status != ''");
        $stmt->execute();
        $statuses = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'status' => 'success',
            'data' => $statuses
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Query failed: ' . $e->getMessage()
        ]);
    }
    exit;
}

if ($action === 'get_qc_report') {
    $from       = $_POST['from_date'] ?? '';
    $to         = $_POST['to_date'] ?? '';
    $campaign   = $_POST['campaign'] ?? '';
    $callCenter = $_POST['call_center'] ?? '';
    $agent      = $_POST['agent_id'] ?? '';
    $status     = $_POST['agent_status'] ?? '';

    try {
        $query = "SELECT id, first_name, last_name, phone_number, agent_username, status, campid, timestamp 
                  FROM QC_Reports 
                  WHERE 1=1";
        $params = [];

        if (!empty($from)) {
            $query .= " AND timestamp >= ?";
            $params[] = $from . ' 00:00:00';
        }

        if (!empty($to)) {
            $query .= " AND timestamp <= ?";
            $params[] = $to . ' 23:59:59';
        }

        if (!empty($campaign)) {
            $query .= " AND campid = ?";
            $params[] = $campaign;
        }

        // if (!empty($agent)) {
        //     $query .= " AND agent_username = ?";
        //     $params[] = $agent;
        // }

        if (!empty($status)) {
            $query .= " AND status = ?";
            $params[] = $status;
        }

        $stmt = $conn->prepare($query);
        $stmt->execute($params);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'status' => 'success',
            'data' => $results
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Query failed: ' . $e->getMessage()
        ]);
    }
    exit;
}

if ($_GET['action'] === 'reset_status') {
    $agent_name = $_POST['agent_name'];
    $ids = $_POST['ids']; // should be an array of integers

    if (!empty($ids) && is_array($ids)) {
        try {
         
            // Create placeholders for ID array
            $placeholders = implode(',', array_fill(0, count($ids), '?'));

            // Build the SQL query
            $sql = "UPDATE QC_Reports SET QC_Audited = ?, final_status = 'WIP' WHERE id IN ($placeholders)";
            $stmt = $conn->prepare($sql);

            // Bind parameters (agent_name first, then IDs)
            $params = array_merge([$agent_name], $ids);

            if ($stmt->execute($params)) {
                echo 'success';
            } else {
                echo 'query_error';
            }

        } catch (PDOException $e) {
            echo 'pdo_error: ' . $e->getMessage();
        }
    } else {
        echo 'no_ids';
    }
    exit;
}


?>
