<?php
session_start();
include('../../config.php');
include('../../session.php');

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$action = $_GET['action'] ?? '';
$fromdatevalues = $_GET['fromdatevalues'] ?? '';
$todatevalue = $_GET['todatevalue'] ?? '';
$fetchipvalue = $_GET['fetchipvalue'] ?? '';

// Connect to the main database to get campaign details
$main_conn = new mysqli('localhost', 'zeal', '4321', 'zealousv2');

if ($main_conn->connect_error) {
    echo json_encode(['error' => 'Main DB Connection failed: ' . $main_conn->connect_error]);
    exit;
}

// Use prepared statement to prevent SQL injection
$stmt = $main_conn->prepare("SELECT camp_ip, db_username, db_password, db_database FROM campaigns_details WHERE status = 'active' AND camp_ip = ? GROUP BY camp_ip");
$stmt->bind_param('s', $fetchipvalue);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $finalResults = [];

    while ($row = $result->fetch_assoc()) {
        $camp_ip = $row['camp_ip'];
        $dbusername = $row['db_username'];
        $dbpassword = $row['db_password'];
        $dbdatabase = $row['db_database'];

        $fromdatevalues = $_GET['fromdatevalues'] . ' 00:00:00';
        $todatevalue = $_GET['todatevalue'] . ' 23:59:59';
        
        try {
            $pdo = new PDO("mysql:host=$camp_ip;dbname=$dbdatabase", $dbusername, $dbpassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
            if ($action == 'view') {
                $query = "
                    SELECT 
                        campaign_id,
                        COUNT(campaign_id) AS calls,
                        SUM(CASE WHEN status IN ('PU', 'PDROP', 'AA', 'AL', 'AM') THEN 1 ELSE 0 END) AS AM,
                        SUM(CASE WHEN user != 'VDAD' THEN 1 ELSE 0 END) AS Human,
                        call_date
                    FROM vicidial_log_archive
                    WHERE call_date BETWEEN :from AND :to 
                    GROUP BY campaign_id
                ";
            } elseif ($action == 'all') {
                $query = "
                    SELECT 
                        campaign_id,
                        COUNT(campaign_id) AS calls,
                        SUM(CASE WHEN status IN ('PU', 'PDROP', 'AA', 'AL', 'AM') THEN 1 ELSE 0 END) AS AM,
                        SUM(CASE WHEN user != 'VDAD' THEN 1 ELSE 0 END) AS Human,
                        call_date
                    FROM vicidial_log
                    WHERE call_date BETWEEN :from AND :to 
                    GROUP BY campaign_id
                ";
            } else {
                echo json_encode(['error' => 'Invalid action']);
                exit;
            }
        
            $sth = $pdo->prepare($query);
            $sth->execute([
                ':from' => $fromdatevalues,
                ':to' => $todatevalue
            ]);
        
            $campaignResult = $sth->fetchAll(PDO::FETCH_ASSOC);
        
            foreach ($campaignResult as &$rowResult) {
                $rowResult['server_ip'] = $camp_ip;
            }
        
            $finalResults = array_merge($finalResults, $campaignResult);
        
        } catch (PDOException $e) {
            $finalResults[] = ['campaign_id' => $camp_ip, 'error' => $e->getMessage()];
        }
        
    }

    echo json_encode($finalResults);
} else {
    echo json_encode(['error' => 'No active campaigns found.']);
}
?>
