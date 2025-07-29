<?php
session_start();
include('../../config.php');
include('../../session.php');

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connect to the main database to get campaign details
$main_conn = new mysqli('localhost', 'zeal', '4321', 'zealousv2');

if ($main_conn->connect_error) {
    echo json_encode(['error' => 'Main DB Connection failed: ' . $main_conn->connect_error]);
    exit;
}

// Capture action and date values
$action = $_GET['action'] ?? '';
$fromdatevalues = $_GET['fromdatevalues'] ?? '';
$todatevalue = $_GET['todatevalue'] ?? '';
$fetchipvalue = $_GET['fetchipvalue'] ?? '';

// Fetch active campaigns grouped by camp_ip
$sql = "SELECT camp_ip, db_username, db_password, db_database FROM campaigns_details WHERE status = 'active' and camp_ip='$fetchipvalue' GROUP BY camp_ip";
$result = $main_conn->query($sql);

if ($result->num_rows > 0) {
    $finalResults = [];

    while ($row = $result->fetch_assoc()) {
        $camp_ip = $row['camp_ip'];
        $dbusername = $row['db_username'];
        $dbpassword = $row['db_password'];
        $dbdatabase = $row['db_database'];
        $fromdatevalues = $_GET['fromdatevalues'] . ' 00:00:00';
        $todatevalue = $_GET['todatevalue'] . ' 23:59:59';
        try {
            // Connect using PDO to each campaign server
            $connPDO = new PDO("mysql:host=$camp_ip;dbname=$dbdatabase", $dbusername, $dbpassword);
            $connPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare query based on action
            if ($action == 'view' || $action == 'all') {
                $query = "SELECT 
                            val.campaign_id AS camp,
                            val.user AS users,
                            val.status AS status,
                            COUNT(val.talk_sec) AS Totalcalls,
                            SUM(val.pause_sec) AS pause_sec,
                            SUM(val.talk_sec + val.wait_sec + val.dispo_sec) AS Hrs,
                             val.event_time
                        FROM 
                            vicidial_agent_log_archive val
                        INNER JOIN 
                            vicidial_users vu ON val.user = vu.user
                        WHERE 
                            val.event_time >= :fromdate
                            AND val.event_time <= :todate
                            AND (vu.user_level = '1' OR vu.user_level = '7')
                            AND val.status IS NOT NULL
                        GROUP BY 
                            val.campaign_id";

                $sth = $connPDO->prepare($query);
                $sth->execute([
                    ':fromdate' => $fromdatevalues,
                    ':todate'   => $todatevalue
                ]);

                $campaignData = $sth->fetchAll(PDO::FETCH_ASSOC);

                // Add server_ip to every record (optional for identifying which server data came from)
                foreach ($campaignData as &$record) {
                    $record['server_ip'] = $camp_ip;
                }

                $finalResults = array_merge($finalResults, $campaignData);
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid action specified"]);
                exit;
            }

        } catch (PDOException $e) {
            $finalResults[] = [
                'server_ip' => $camp_ip,
                'error' => 'Connection failed: ' . $e->getMessage()
            ];
        }
    }

    // Output final combined JSON
    echo json_encode($finalResults);

} else {
    echo json_encode(['error' => 'No active campaigns found']);
}
?>
