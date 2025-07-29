<?php
include '../../function/DB/pdo-db-59.php';
include '../../function/session.php';

$action = $_GET['action'];

if ($action == 'dnqselect') {
    try {
        // Prepare and execute query using PDO
        $stmt = $conn->prepare("SELECT `id`, `dnq`, `type` FROM `QC_DNQ`");
        $stmt->execute();

        // Fetch all results as associative array
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "statusCode" => 200,
            "data" => $data
        ]);
    } catch (PDOException $e) {
        echo json_encode([
            "statusCode" => 201,
            "message" => $e->getMessage()
        ]);
    }
}
?>
