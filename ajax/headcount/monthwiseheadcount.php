<?php
session_start();
include('../../config.php');
include('../../session.php');

header('Content-Type: application/json');
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);


$action = $_POST['action'] ?? '';
if ($action === "monthwiseheadcount") {
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    error_reporting(E_ALL);

    header('Content-Type: application/json');
    $response = ['status' => 'error', 'message' => 'Unknown error'];

    try {
        $month = (int)($_POST['month'] ?? 0);
        $year = (int)($_POST['year'] ?? 0);

        if (!$month || !$year) {
            echo json_encode(['status' => 'error', 'message' => 'Month and year are required.']);
            exit;
        }

        $query = "
            SELECT 
                campaign_id,
                SUM(headcount) AS headcount,
                ROUND(SUM(voip_usage), 2) AS voip_usage,
                ROUND(SUM(voip_usage) / NULLIF(SUM(headcount), 0), 2) AS average
            FROM campaign_summary
            WHERE MONTH(entry_date) = ? AND YEAR(entry_date) = ?
            GROUP BY campaign_id
            ORDER BY voip_usage DESC
        ";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('ii', $month, $year);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = [
                'campaign_id' => $row['campaign_id'],
                'headcount' => (int)$row['headcount'],
                'voip_usage' => (float)$row['voip_usage'],
                'average' => (float)$row['average']
            ];
        }

        if (empty($data)) {
            $response = ['status' => 'empty', 'message' => 'No data found for selected filters.'];
        } else {
            $response = ['status' => 'success', 'data' => $data];
        }
    } catch (Exception $e) {
        $response = ['status' => 'error', 'message' => 'Exception: ' . $e->getMessage()];
    }

    echo json_encode($response);
    exit;
}
