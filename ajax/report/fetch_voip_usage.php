<?php
session_start();
include('../../config.php');
include('../../session.php');

// Set content type to JSON
header('Content-Type: application/json');
$conn = new mysqli('localhost', 'zeal', '4321', 'zealousv2');

// Display errors for debugging (turn off in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$action = $_GET['action'] ?? '';
$conn = new mysqli('localhost', 'zeal', '4321', 'zealousv2');

// Check connection
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]);
    exit();
}
if (isset($_GET['action']) && $_GET['action'] === 'fetchvoipusage') {

    if (!isset($_GET['fromdatevalues']) || !isset($_GET['todatevalue'])) {
        echo json_encode(["status" => "error", "message" => "Missing date parameters."]);
        exit();
    }

    $fromdatevalues = $_GET['fromdatevalues'];
    $todatevalue = $_GET['todatevalue'];
    $stmt = $conn->prepare("SELECT SUM(amount_used) AS totalvoipusage FROM voip_usage WHERE entry_date BETWEEN ? AND ?");
    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "Failed to prepare statement: " . $conn->error]);
        exit();
    }

    $stmt->bind_param('ss', $fromdatevalues, $todatevalue);
    $stmt->execute();

    $result = $stmt->get_result();
    $response = [];

    if ($result && $row = $result->fetch_assoc()) {
        $response["voipUsage"] = (float)($row['totalvoipusage'] ?? 0);
    } else {
        $response["voipUsage"] = 0;
    }

    echo json_encode($response);
    $stmt->close();
    $conn->close();
} else if ($_GET['action'] === 'insertBatchSummary') {

    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (!empty($data['summaries'])) {

        // Combine TAX_IN and TAX_OB into TAX
        $taxSummary = [
            'campaign_id' => 'TAX',
            'calls' => 0,
            'am' => 0,
            'human' => 0,
            'totalAnswered' => 0,
            'answeredPercentage' => 0.0,
            'call_date' => '',
            'server_ip' => ''
        ];

        $filteredSummaries = [];

        $taxPartsFound = 0;

        foreach ($data['summaries'] as $summary) {
            if ($summary['campaign_id'] === 'TAX_IN' || $summary['campaign_id'] === 'TAX_OB') {
                // Merge TAX parts
                $taxSummary['calls'] += $summary['calls'];
                $taxSummary['am'] += $summary['am'];
                $taxSummary['human'] += $summary['human'];
                $taxSummary['totalAnswered'] += $summary['totalAnswered'];
                $taxSummary['answeredPercentage'] += $summary['answeredPercentage'];
                $taxPartsFound++;

                // Capture date and server_ip from the first one
                if (empty($taxSummary['call_date'])) {
                    $taxSummary['call_date'] = $summary['call_date'];
                    $taxSummary['server_ip'] = $summary['server_ip'];
                }
            } else {
                $filteredSummaries[] = $summary;
            }
        }

        if ($taxPartsFound > 0) {
            // Average percentage over how many parts found
            $taxSummary['answeredPercentage'] = round($taxSummary['answeredPercentage'] / $taxPartsFound, 2);
            $filteredSummaries[] = $taxSummary;
        }

        $conn->begin_transaction();

        try {
            $stmt = $conn->prepare("
                INSERT INTO campaign_summary (
                    campaign_id,
                    totalcalls,
                    am_audio,
                    human_answer,
                    aa_ha,
                    percentage,
                    entry_date,
                    server_ip
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE 
                    totalcalls = VALUES(totalcalls),
                    am_audio = VALUES(am_audio),
                    human_answer = VALUES(human_answer),
                    aa_ha = VALUES(aa_ha),
                    percentage = VALUES(percentage),
                    server_ip = VALUES(server_ip)
            ");

            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }

            foreach ($filteredSummaries as $summary) {
                $stmt->bind_param(
                    "siiiidss",
                    $summary['campaign_id'],
                    $summary['calls'],
                    $summary['am'],
                    $summary['human'],
                    $summary['totalAnswered'],
                    $summary['answeredPercentage'],
                    $summary['call_date'],
                    $summary['server_ip']
                );
                $stmt->execute();
            }

            $conn->commit();
            echo json_encode(["status" => "success", "message" => "Batch insert completed."]);
        } catch (Exception $e) {
            $conn->rollback();
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }

        $stmt->close();
        $conn->close();

    } else {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "No summary data provided."]);
    }

    exit;
}
 else if ($_GET['action'] === 'updatebatchsummary') {

    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (!empty($data['summaries'])) {
        $conn->begin_transaction();

        try {
            // Update total_hrs from input, headcount from campaigns_details table
            $stmt = $conn->prepare("
                UPDATE campaign_summary cs
                JOIN campaigns_details cd ON cs.campaign_id = cd.campaign_value
                SET cs.total_hrs = ?,
                    cs.headcount = cd.headcount
                WHERE DATE(cs.entry_date) = ? 
                  AND cs.campaign_id = ? 
                  AND cs.server_ip = ?
            ");

            if (!$stmt) {
                throw new Exception("Statement preparation failed: " . $conn->error);
            }

            foreach ($data['summaries'] as $summary) {

                error_log("Trying to update with: " . json_encode($summary));

                $stmt->bind_param(
                    "dsss",
                    $summary['hrs'],
                    $summary['event_time'],
                    $summary['campaign_id'],
                    $summary['server_ip']
                );

                $stmt->execute();

                if ($stmt->affected_rows === 0) {
                    error_log("No update for: " . json_encode($summary));
                } else {
                    error_log("Updated row for: " . json_encode($summary));
                }
            }

            $conn->commit();
            echo json_encode(["status" => "success", "message" => "Batch update completed."]);
        } catch (Exception $e) {
            $conn->rollback();
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }

        if (isset($stmt)) {
            $stmt->close();
        }
        $conn->close();
    } else {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "No summary data provided."]);
    }

    exit;
}
else if ($_GET['action'] === 'fetchvoipsummary') {



    if (!isset($_GET['fromdatevalues']) || !isset($_GET['todatevalue'])) {
        echo json_encode(["status" => "error", "message" => "Missing date parameters."]);
        exit();
    }

    $from = $_GET['fromdatevalues'];
    $to = $_GET['todatevalue'];


    $query = "
        SELECT 
    campaign_id, 
    totalcalls, 
    am_audio AS AM, 
    human_answer AS Human, 
    aa_ha, 
    percentage, 
    call_percentage, 
    voip_usage, 
    total_hrs, 
    entry_date,
    server_ip
FROM campaign_summary
WHERE entry_date BETWEEN ? AND ?
    ";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ss", $from, $to);
        $stmt->execute();
        $result = $stmt->get_result();

        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        echo json_encode($rows);

        $stmt->close();
    } else {

        echo json_encode(["status" => "error", "message" => "Prepare failed: " . $conn->error]);
    }

    $conn->close();
} else if ($_GET['action'] === 'updatedcall_voipusage') {



    $data = json_decode(file_get_contents('php://input'), true);


    if (isset($data['summaries']) && is_array($data['summaries'])) {
        $summaries = $data['summaries'];


        $query = "
            UPDATE campaign_summary 
            SET call_percentage = ?, voip_usage = ? 
            WHERE DATE(entry_date) = ? 
            AND campaign_id = ? 
            AND server_ip = ?
        ";


        if (!$stmt = $conn->prepare($query)) {
            echo json_encode(["status" => "error", "message" => "SQL prepare failed: " . $conn->error]);
            exit();
        }


        foreach ($summaries as $summary) {
            $callPercentage = $summary['callPercentage'];
            $userVoipUsage = $summary['userVoipUsage'];
            $entry_date = $summary['entry_date']; 
            $campaign_id = $summary['campaign_id'];
            $server_ip = $summary['server_ip'];

          
            if (!$stmt->bind_param("ddsss", $callPercentage, $userVoipUsage, $entry_date, $campaign_id, $server_ip)) {
                echo json_encode(["status" => "error", "message" => "Binding parameters failed: " . $conn->error]);
                exit();
            }

       
            if (!$stmt->execute()) {
                echo json_encode(["status" => "error", "message" => "Execute failed: " . $stmt->error]);
                exit();
            }
        }

        echo json_encode(["status" => "success", "message" => "Batch update successful"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid data format"]);
    }


    $stmt->close();
    $conn->close();
} else if ($_GET['action'] === 'voipreport_count') {
    $fromdatevalues = $_GET['fromdatevalues'] . ' 00:00:00';
    $todatevalue = $_GET['todatevalue'] . ' 23:59:59';
    $sql = "
       SELECT 
    SUM(totalcalls) AS total_call, 
    SUM(am_audio) AS total_AM, 
    SUM(human_answer) AS total_Human, 
    SUM(aa_ha) AS total_AAHA, 
    SUM(call_percentage) AS total_call_percentage, 
    SUM(voip_usage) AS total_voip_usage, 
    SUM(total_hrs) AS total_hours 
    FROM campaign_summary 
    WHERE entry_date BETWEEN ? AND ?
    ";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(["error" => "Prepare failed: " . $conn->error]);
        exit;
    }

    $stmt->bind_param("ss", $fromdatevalues, $todatevalue);
    $stmt->execute();
    $result = $stmt->get_result();
    $summary = $result->fetch_assoc();

    echo json_encode($summary);

    $stmt->close();
    $conn->close();
}
