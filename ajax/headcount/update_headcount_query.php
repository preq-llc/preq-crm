<?php
session_start();
include('../../config.php');
include('../../session.php');

header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

$action = $_POST['action'] ?? '';

if ($_POST['action'] === 'getcampaigndetails') {
    $entry_date = $_POST['entry_date'] ?? '';

    if (!$entry_date) {
        echo json_encode(["success" => false, "message" => "No date provided."]);
        exit;
    }

    $stmt = $conn->prepare("SELECT id, campaign_id, entry_date, headcount 
FROM campaign_summary 
WHERE DATE(entry_date) = ? 
  AND campaign_id IS NOT NULL 
  AND TRIM(campaign_id) != ''
");
    $stmt->bind_param("s", $entry_date);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    if (!empty($data)) {
        echo json_encode(["success" => true, "data" => $data]);
    } else {
        echo json_encode(["success" => false, "message" => "No data found for selected date."]);
    }

    $stmt->close();
    $conn->close();
    exit;
} else if ($action === 'updateheadcount') {
    $campaign_id = $_POST['campaign_id'] ?? '';
    $head_count = (int) $_POST['head_count'];
    $entry_date = $_POST['entry_date'] ?? ''; // ✅ Add this line
    echo $rowid = (int) $_POST['rowid'];
    if (!$campaign_id || !$entry_date || !is_numeric($head_count)) {
        echo json_encode(['success' => false, 'error' => 'Missing or invalid fields']);
        exit;
    }
    $query = "SELECT headcount FROM campaign_summary WHERE campaign_id = ? AND entry_date = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $campaign_id, $entry_date);
    $stmt->execute();
    $result = $stmt->get_result();
    $before_headcount = $result->fetch_assoc()['headcount'];
    $stmt->close();

    $updateSummary = $conn->prepare("UPDATE campaign_summary SET headcount = ? WHERE id = ?");
    $updateSummary->bind_param('ii', $head_count, $rowid);

    if ($updateSummary->execute()) {
        if ($updateSummary->affected_rows > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No rows affected. Possibly same value or no match.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to execute update: ' . $updateSummary->error]);
    }

    $ip = $_SERVER['REMOTE_ADDR'];
    $username = $_SESSION['username'];
    $browser = $_SERVER['HTTP_USER_AGENT'];
    $status = 'success';
    $timestamp = date('Y-m-d H:i:s');


    $ip = $_SERVER['REMOTE_ADDR'];
    $username = $_SESSION['username'];
    $browser = $_SERVER['HTTP_USER_AGENT'];
    $status = 'success';
    $timestamp = date('Y-m-d H:i:s');

    // JSON-encoded data to store in the 'data' column
    $logData = json_encode([
        'ip' => $ip,
        'username' => $username,
        'browser' => $browser,
        'campaign_name' => $campaign_id,
        'before_headcount' => $before_headcount,
        'new_headcount' => $head_count,
        'timestamp' => $timestamp,
        'status' => $status,
        'action' => 'Update'
    ]);


    $activity = 'HCupdated';


    $timestamp = date('Y-m-d H:i:s');


    $logQuery = "INSERT INTO activity_log (activity, data, timestamp) VALUES (?, ?, ?)";
    $logStmt = $conn->prepare($logQuery);

    if (!$logStmt) {
        echo json_encode(['success' => false, 'error' => 'Prepare failed for activity log: ' . $conn->error]);
        exit;
    }


    $logStmt->bind_param('sss', $activity, $logData, $timestamp);

    if ($logStmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Activity logged successfully.']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to insert activity log: ' . $logStmt->error]);
    }
}
