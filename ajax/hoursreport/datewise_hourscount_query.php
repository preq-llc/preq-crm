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

if ($action == "datewisehourscount") {
    if (!$entry_date) {
        echo json_encode(['success' => false, 'error' => 'Missing date']);
        exit;
    }

    $entry_date = date('Y-m-d', strtotime($entry_date));

    $sql = "SELECT campaign_id, total_hrs, voip_usage 
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
            'hours' => (float)$row['total_hrs'],
            'voip_usage' => (float)$row['voip_usage']
        ];
    }

    if (count($data)) {
        echo json_encode(['success' => true, 'data' => $data]);
    } else {
        echo json_encode(['success' => false, 'error' => 'No data found']);
    }
} else if ($action = "campaignwisehourscount") {
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

        $params = [];
        $types = '';
        $campaignFilter = '';
        if (!empty($campaign)) {
            $campaignFilter = 'AND cs.campaign_id = ?';
            $params[] = $campaign;
            $types .= 's';
        }

        // If both month and year are selected, generate full date list using recursive CTE
        if (!empty($month) && !empty($year)) {
            $start_date = "$year-$month-01";
            $end_date = date('Y-m-t', strtotime($start_date));

            $sql = "
                WITH RECURSIVE dates AS (
                    SELECT DATE(?) AS date
                    UNION ALL
                    SELECT DATE_ADD(date, INTERVAL 1 DAY)
                    FROM dates
                    WHERE date < DATE(?)
                )
                SELECT 
                    d.date,
                    DAYNAME(d.date) AS day,
                    COALESCE(cs.total_hrs, 0) AS total_hrs,
                    COALESCE(cs.voip_usage, 0) AS voip_usage,
                    ROUND(COALESCE(cs.voip_usage, 0) / NULLIF(COALESCE(cs.total_hrs, 0), 0), 2) AS average
                FROM dates d
                LEFT JOIN campaign_summary cs
                    ON cs.entry_date = d.date
                    $campaignFilter
                ORDER BY d.date ASC
            ";

            $stmt = $conn->prepare($sql);

            if (!empty($campaign)) {
                $stmt->bind_param("sss", $start_date, $end_date, ...$params);
            } else {
                $stmt->bind_param("ss", $start_date, $end_date);
            }
        } else {
            // Fallback to standard query without date expansion
            $conditions = [];
            if (!empty($campaign)) {
                $conditions[] = 'campaign_id = ?';
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

            $sql = "
                SELECT 
                    DATE(entry_date) AS date,
                    DAYNAME(entry_date) AS day,
                    total_hrs,
                    voip_usage,
                    ROUND(voip_usage / NULLIF(total_hrs, 0), 2) AS average
                FROM campaign_summary
                $whereClause
                ORDER BY entry_date ASC
            ";

            $stmt = $conn->prepare($sql);
            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = [
                'date' => $row['date'],
                'day' => $row['day'],
                'hours' => (float)($row['total_hrs'] ?? 0),
                'voip_usage' => (float)($row['voip_usage'] ?? 0),
                'average' => (float)($row['average'] ?? 0)
            ];
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
