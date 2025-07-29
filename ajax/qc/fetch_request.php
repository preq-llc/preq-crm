<?php
try {
    // Include database connection and session
    include '../../function/DB/pdo-db-59.php';
    include '../../function/session.php';

    // Fetch input parameters
    $fromDate = $_GET['fromdatevalue'];
    $toDate = $_GET['todatevalue'];
    $selectedCampaign = $_GET['slctcampvalue'];

    // Fetch session details
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    $group = $_SESSION['group'];

    // Check if there's an existing WIP record for the user
    $checkWipQuery = "
        SELECT id 
        FROM QC_Reports 
        WHERE timestamp BETWEEN :from AND :to 
          AND camp = :camp 
          AND QC_Audited = :auditor 
          AND final_status = 'WIP'
    ";
    $stmt = $conn->prepare($checkWipQuery);
    $stmt->execute([
        ':from' => "$fromDate 00:00:00",
        ':to' => "$toDate 23:59:59",
        ':camp' => $selectedCampaign,
        ':auditor' => $username
    ]);
    $existingWip = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingWip) {
        $res['status'] = 'HaveOne';
    } else {
        // Fetch a random unaudited record
         $randomQuery = "
            SELECT *, (
                SELECT agent_username 
                FROM QC_Reports 
                WHERE timestamp BETWEEN :from AND :to 
                  AND camp = :camp 
                ORDER BY RAND() 
                LIMIT 1
            ) AS random_agent_username
            FROM QC_Reports 
            WHERE timestamp BETWEEN :from AND :to 
              AND camp = :camp 
              AND final_status IS NULL 
              AND QC_Audited IS NULL 
            ORDER BY RAND() 
            LIMIT 1
        ";
        $stmtAuto = $conn->prepare($randomQuery);
        $stmtAuto->execute([
            ':from' => "$fromDate 00:00:00",
            ':to' => "$toDate 23:59:59",
            ':camp' => $selectedCampaign
        ]);
        $record = $stmtAuto->fetch(PDO::FETCH_ASSOC);

       

        if ($record) {
            // Lock the record as WIP for the current user

            $updateQuery = "
                UPDATE QC_Reports 
                SET final_status = 'WIP', QC_Audited = :auditor 
                WHERE phone_number = :phone 
                  AND timestamp = :timestamp 
                  AND camp = :camp 
                  AND agent_username = :agent
            ";
            $stmtUpdate = $conn->prepare($updateQuery);
            $stmtUpdate->execute([
                ':auditor' => $username,
                ':phone' => $record['phone_number'],
                ':timestamp' => $record['timestamp'],
                ':camp' => $record['camp'],
                ':agent' => $record['agent_username']
            ]);

            $res['status'] = 'Ok';
        } else {
            $res['status'] = 'NoRecords';
        }
    }

    echo json_encode($res);

} catch (PDOException $e) {
    echo json_encode([
        'status' => 'Error',
        'message' => $e->getMessage()
    ]);
}
?>
