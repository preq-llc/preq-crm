<?php
session_start();
include('../../config.php');
include('../../session.php');

header('Content-Type: application/json');
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);


$action = $_POST['action'] ?? '';
$entry_date = $_POST['entry_date'] ?? '';

if ($action == "datewiseheadcount") {
    if (!$entry_date) {
        echo json_encode(['success' => false, 'error' => 'Missing date']);
        exit;
    }

    $entry_date = date('Y-m-d', strtotime($entry_date));

    $sql = "SELECT campaign_id, headcount, voip_usage 
            FROM campaign_summary 
            WHERE entry_date = ?
            ORDER BY campaign_id ASC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $entry_date);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'campaign_id' => $row['campaign_id'],
            'headcount' => (int)$row['headcount'],
            'voip_usage' => (float)$row['voip_usage']
        ];
    }

    if (count($data)) {
        echo json_encode(['success' => true, 'data' => $data]);
    } else {
        echo json_encode(['success' => false, 'error' => 'No data found']);
    }
} else if ($action = "campaignwiseheadcount") {
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    error_reporting(E_ALL);

    header('Content-Type: application/json');
    $response = ['status' => 'error', 'message' => 'Unknown error occurred.'];

    try {
        $campaign = $_POST['campaign'] ?? '';
        $month = $_POST['month'] ?? '';
        $year = $_POST['year'] ?? '';

        // Require at least one filter
        if (empty($campaign) && empty($month) && empty($year)) {
            echo json_encode(['status' => 'error', 'message' => 'Please select at least one filter.']);
            exit;
        }

        // If both month and year are selected, generate full date list
        if (!empty($month) && !empty($year)) {
            $date_start = "$year-$month-01";
            $date_end = date('Y-m-t', strtotime($date_start)); // last day of the month

            $params = [];
            $types = '';

            $query = "
            WITH RECURSIVE all_dates AS (
                SELECT DATE(?) AS date_val
                UNION ALL
                SELECT DATE_ADD(date_val, INTERVAL 1 DAY)
                FROM all_dates
                WHERE date_val < DATE(?)
            )
            SELECT
                all_dates.date_val AS date,
                DAYNAME(all_dates.date_val) AS day,
                COALESCE(cs.headcount, 0) AS headcount,
                COALESCE(cs.voip_usage, 0) AS voip_usage,
                ROUND(COALESCE(cs.voip_usage, 0) / NULLIF(COALESCE(cs.headcount, 0), 0), 2) AS average
            FROM all_dates
            LEFT JOIN campaign_summary cs
                ON cs.entry_date = all_dates.date_val
            ";

            $params[] = $date_start;
            $params[] = $date_end;
            $types .= 'ss';

            // Add campaign filter if exists
            if (!empty($campaign)) {
                $query .= " AND cs.campaign_id = ? ";
                $params[] = $campaign;
                $types .= 's';
            }

            $query .= " ORDER BY all_dates.date_val ASC";

            $stmt = $conn->prepare($query);
            if ($stmt === false) {
                throw new Exception('Failed to prepare statement: ' . $conn->error);
            }

            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $result = $stmt->get_result();

            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = [
                    'date' => $row['date'],
                    'day' => $row['day'],
                    'headcount' => (int)$row['headcount'],
                    'voip_usage' => (float)$row['voip_usage'],
                    'average' => (float)$row['average']
                ];
            }

        } else {
            // Fallback to your original query for cases without both month and year
            $conditions = [];
            $params = [];
            $types = '';

            if (!empty($campaign)) {
                $conditions[] = 'campaign_id = ?';
                $params[] = $campaign;
                $types .= 's';
            }
            if (!empty($month)) {
                $conditions[] = 'MONTH(entry_date) = ?';
                $params[] = (int)$month;
                $types .= 'i';
            }
            if (!empty($year)) {
                $conditions[] = 'YEAR(entry_date) = ?';
                $params[] = (int)$year;
                $types .= 'i';
            }

            $whereClause = $conditions ? 'WHERE ' . implode(' AND ', $conditions) : '';

            $query = "
                SELECT 
                    DATE(entry_date) AS date, 
                    DAYNAME(entry_date) AS day, 
                    headcount, 
                    voip_usage, 
                    ROUND(voip_usage / NULLIF(headcount, 0), 2) AS average
                FROM campaign_summary
                $whereClause
                ORDER BY entry_date ASC
            ";

            $stmt = $conn->prepare($query);
            if ($stmt === false) {
                throw new Exception('Failed to prepare statement: ' . $conn->error);
            }

            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            $result = $stmt->get_result();

            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = [
                    'date' => $row['date'],
                    'day' => $row['day'],
                    'headcount' => (int)$row['headcount'],
                    'voip_usage' => (float)$row['voip_usage'],
                    'average' => (float)$row['average']
                ];
            }
        }

        if (empty($data)) {
            $response = ['status' => 'empty', 'message' => 'No data found.'];
        } else {
            $response = ['status' => 'success', 'data' => $data];
        }
    } catch (Exception $e) {
        $response = ['status' => 'error', 'message' => 'Exception: ' . $e->getMessage()];
    }

    echo json_encode($response);
    exit;
}
