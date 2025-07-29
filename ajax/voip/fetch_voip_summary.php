<?php
include('../../config.php');
include('../../session.php');
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'voipcount_dashboard') {
        $start_date = !empty($_POST['start_date']) ? $_POST['start_date'] : date('Y-m-d');
        $end_date = !empty($_POST['end_date']) ? $_POST['end_date'] : date('Y-m-d');
        $voipIds = $_POST['voipIds'] ?? [];

        $start_date = date('Y-m-d', strtotime($start_date));
        $end_date = date('Y-m-d', strtotime($end_date));

        // Prepare query to handle multiple voip_ids
        if (!empty($voipIds) && is_array($voipIds)) {
            $placeholders = implode(',', array_fill(0, count($voipIds), '?'));
            $query = "SELECT voip_name, SUM(amount_used) AS amount_used 
                      FROM voip_usage 
                      WHERE entry_date BETWEEN ? AND ? AND (status = 'debited' OR status IS NULL) AND voip_id IN ($placeholders)
                      GROUP BY voip_name";
            $stmt = $conn->prepare($query);
            $params = array_merge([$start_date, $end_date], $voipIds);
            $stmt->bind_param(str_repeat('s', count($params)), ...$params);
        } else {
            $query = "SELECT voip_name, SUM(amount_used) AS amount_used 
                      FROM voip_usage 
                      WHERE entry_date BETWEEN ? AND ? AND (status = 'debited' OR status IS NULL)
                      GROUP BY voip_name";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $start_date, $end_date);
        }

        if (!$stmt) {
            echo json_encode(['status' => 'error', 'message' => 'Query preparation failed.']);
            exit;
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode(['status' => 'success', 'data' => $data]);
    }
}
else if ($_GET['action'] ===  'lastentrydate') {
    header('Content-Type: application/json');

    $query = "SELECT entry_date FROM voip_usage ORDER BY entry_date DESC LIMIT 1";
    $result = $conn->query($query);

    if ($result && $row = $result->fetch_assoc()) {
        echo json_encode([
            'status' => 'Ok',
            'entry_date' => $row['entry_date']
        ]);
    } else {
        echo json_encode([
            'status' => 'Error',
            'message' => 'No entry date found'
        ]);
    }
}
?>