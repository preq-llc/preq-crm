<?php
// Include configuration file
include('../../config.php');
include('../../session.php');
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);


$action = isset($_POST['action']) ? $_POST['action'] : '';
$username = $_SESSION['username'];
//  create usage entry  query
if ($action == "usagecreate") {

    $voip_id = $_POST['voip_id'] ?? null;
    $entry_date = $_POST['entry_date'] ?? null;
    $amount_used = $_POST['amount_used'] ?? null;
    $username = $_SESSION['username'] ?? 'system'; // Adjust as needed

    if (empty($voip_id) || empty($entry_date) || empty($amount_used)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit;
    }

    $entry_date = date('Y-m-d', strtotime($entry_date));

    // Check for duplicate credited entry
    $check_stmt = $conn->prepare("SELECT id FROM voip_usage WHERE voip_id = ? AND entry_date = ? AND status = 'credited'");
    $check_stmt->bind_param("is", $voip_id, $entry_date);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        // VoIP exists, proceed with normal usage record insertion
        $stmt_name = $conn->prepare("SELECT voip_name FROM voip_master WHERE id = ?");
        $stmt_name->bind_param("i", $voip_id);
        $stmt_name->execute();
        $stmt_name->bind_result($voip_name);
        $stmt_name->fetch();
        $stmt_name->close();

        if (empty($voip_name)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid VoIP ID.']);
            exit;
        }

        $status = 'debited';

        // Get previous balance
        $stmt_balance = $conn->prepare("SELECT balance_amount FROM voip_usage WHERE voip_name = ? ORDER BY id DESC LIMIT 1");
        $stmt_balance->bind_param("s", $voip_name);
        $stmt_balance->execute();
        $stmt_balance->bind_result($previous_balance);
        $stmt_balance->fetch();
        $stmt_balance->close();

        $previous_balance = $previous_balance ?? 0;
        $balance_amount = $previous_balance - $amount_used;

        // Insert usage record
        $stmt = $conn->prepare("INSERT INTO voip_usage (
        voip_id, voip_name, entry_date, amount_used, previous_used, balance_amount, status, created_by
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "issdddss",
            $voip_id,
            $voip_name,
            $entry_date,
            $amount_used,
            $previous_balance,
            $balance_amount,
            $status,
            $username
        );

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Usage added successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database insert failed: ' . $stmt->error]);
        }

        $stmt->close();
    } else {
        // VoIP does not exist, special case handling
        $stmt_name = $conn->prepare("SELECT voip_name FROM voip_master WHERE id = ?");
        $stmt_name->bind_param("i", $voip_id);
        $stmt_name->execute();
        $stmt_name->bind_result($voip_name);
        $stmt_name->fetch();
        $stmt_name->close();

        if (empty($voip_name)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid VoIP ID.']);
            exit;
        }

        $status = 'debited';

        if ($voip_id == 29) {
            // Special case: VoIP ID 29 consumes from VoIP ID 3
            $sql = "SELECT balance_amount, id FROM voip_usage WHERE voip_id = 2 ORDER BY id DESC LIMIT 1";
            $stmt_balance = $conn->prepare($sql);
            $stmt_balance->execute();
            $stmt_balance->bind_result($balance_amount, $voip3_id);
            $stmt_balance->fetch();
            $stmt_balance->close();

            $balance_amount = $balance_amount ?? 0;
            $total_amount = $balance_amount - $amount_used;

            // Update the latest record for voip_id = 3 with new balance and log amount used (as 'did' field?)
            $update_sql = "UPDATE voip_usage SET balance_amount = ?, did = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ddi", $total_amount, $amount_used, $voip3_id);

            if ($update_stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Balance updated for VoIP ID 3.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Balance update failed: ' . $update_stmt->error]);
            }

            $update_stmt->close();
        } else {
            // Normal handling for non-existent voip_id
            $stmt_balance = $conn->prepare("SELECT balance_amount FROM voip_usage WHERE voip_name = ? ORDER BY id DESC LIMIT 1");
            $stmt_balance->bind_param("s", $voip_name);
            $stmt_balance->execute();
            $stmt_balance->bind_result($previous_balance);
            $stmt_balance->fetch();
            $stmt_balance->close();

            $previous_balance = $previous_balance ?? 0;
            $balance_amount = $previous_balance - $amount_used;

            $stmt = $conn->prepare("INSERT INTO voip_usage (
            voip_id, voip_name, entry_date, amount_used, previous_used, balance_amount, status, created_by
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt->bind_param(
                "issdddss",
                $voip_id,
                $voip_name,
                $entry_date,
                $amount_used,
                $previous_balance,
                $balance_amount,
                $status,
                $username
            );

            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Usage added successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Database insert failed: ' . $stmt->error]);
            }

            $stmt->close();
        }

        $check_stmt->close();
    }
}
//  elseif ($_POST['action'] === 'getdata_voipusage') {
//     $start_date = !empty($_POST['start_date']) ? $_POST['start_date'] : date('Y-m-d');
//     $end_date = !empty($_POST['end_date']) ? $_POST['end_date'] : date('Y-m-d');
//     $voip_ids = $_POST['voip_ids'] ?? [];

//     $start_date = date('Y-m-d', strtotime($start_date));
//     $end_date = date('Y-m-d', strtotime($end_date));

//     // Prepare query to handle multiple voip_ids
//     if (!empty($voip_ids) && is_array($voip_ids)) {
//         $escaped_ids = array_map(function ($id) use ($conn) {
//             return "'" . $conn->real_escape_string($id) . "'";
//         }, $voip_ids);

//         $placeholders = implode(',', $escaped_ids);

//         $query = "SELECT voip_id, voip_name, entry_date, amount_used, created_by, created_at 
//               FROM voip_usage 
//               WHERE entry_date BETWEEN ? AND ? 
//               AND (status = 'debited' OR status IS NULL)
//               AND voip_id IN ($placeholders)
//               ORDER BY created_at DESC";

//         $stmt = $conn->prepare($query);
//         $stmt->bind_param("ss", $start_date, $end_date);
//     }

//     $check_stmt->close();

//     // Get VoIP name
//     $stmt_name = $conn->prepare("SELECT voip_name FROM voip_master WHERE id = ?");
//     $stmt_name->bind_param("i", $voip_id);
//     $stmt_name->execute();
//     $stmt_name->bind_result($voip_name);
//     $stmt_name->fetch();
//     $stmt_name->close();

//     if (!$voip_name) {
//         echo json_encode(['status' => 'error', 'message' => 'Invalid VoIP ID.']);
//         exit;
//     }

//     $status = 'debited';

//     // Get previous balance
//     $sql = "SELECT balance_amount FROM voip_usage WHERE voip_name = ? ORDER BY id DESC LIMIT 1";
//     $stmt_balance = $conn->prepare($sql);
//     $stmt_balance->bind_param("s", $voip_name);
//     $stmt_balance->execute();
//     $stmt_balance->bind_result($previous_balance);
//     $stmt_balance->fetch();
//     $stmt_balance->close();

//     $previous_balance = $previous_balance ?? 0;
//     $balance_amount = $previous_balance - $amount_used;

//     // Final insert with all required fields
//     $stmt = $conn->prepare("INSERT INTO voip_usage (voip_id, voip_name, entry_date, amount_used, previous_used, balance_amount, status, created_by)
//                             VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
//     $stmt->bind_param("isssddss", $voip_id, $voip_name, $entry_date, $amount_used, $previous_balance, $balance_amount, $status, $username);

//     if ($stmt->execute()) {
//         echo json_encode(['status' => 'success', 'message' => 'Usage added successfully.']);
//     } else {
//         echo json_encode(['status' => 'error', 'message' => 'Database insert failed: ' . $stmt->error]);
//     }

//     $stmt->close();
// } 
elseif ($_POST['action'] === 'getdata_voipusage') {
    $start_date = !empty($_POST['start_date']) ? $_POST['start_date'] : date('Y-m-d');
    $end_date = !empty($_POST['end_date']) ? $_POST['end_date'] : date('Y-m-d');
    $voip_ids = $_POST['voip_ids'] ?? [];

    $start_date = date('Y-m-d', strtotime($start_date));
    $end_date = date('Y-m-d', strtotime($end_date));

    // Prepare query to handle multiple voip_ids
    if (!empty($voip_ids) && is_array($voip_ids)) {
        $escaped_ids = array_map(function ($id) use ($conn) {
            return "'" . $conn->real_escape_string($id) . "'";
        }, $voip_ids);

        $placeholders = implode(',', $escaped_ids);

        $query = "SELECT voip_id, voip_name, entry_date, amount_used, created_by, created_at 
              FROM voip_usage 
              WHERE entry_date BETWEEN ? AND ? 
              AND (status = 'debited' OR status IS NULL)
              AND voip_id IN ($placeholders)
              ORDER BY created_at DESC";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $start_date, $end_date);
    } else {
        $query = "SELECT voip_id, voip_name, entry_date, amount_used, created_by, created_at 
              FROM voip_usage 
              WHERE entry_date BETWEEN ? AND ? 
              AND (status = 'debited' OR status IS NULL)
              ORDER BY created_at DESC";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $start_date, $end_date);
    }

    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Query preparation failed.']);
        exit;
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $data = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    echo json_encode($data);
}
