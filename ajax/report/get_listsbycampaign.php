<?php
include '../../config.php';
include $path . 'function/session.php';

$action = $_GET['action'] ?? '';

if ($action === 'get_lists') {
    if (!isset($_GET['slctcampvalue']) || empty($_GET['slctcampvalue'])) {
        echo json_encode([]);
        exit;
    }

    $campaign = mysqli_real_escape_string($conn, $_GET['slctcampvalue']);

    // Get DB credentials from central campaign config table
    $sql = "SELECT * FROM campaigns_details WHERE campaign_value = '$campaign' AND status = 'ACTIVE'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);

    if (!$row) {
        echo json_encode([]);
        exit;
    }

    // Remote campaign DB connection
    $servername = $row['camp_ip'];
    $dbusername = $row['db_username'];
    $dbpassword = $row['db_password'];
    $database   = $row['db_database'];

    $camp_conn = new mysqli($servername, $dbusername, $dbpassword, $database);
    if ($camp_conn->connect_error) {
        echo json_encode([]);
        exit;
    }

    // Query the vicidial_lists table
   // $query = "SELECT list_id, list_name, campaign_id, list_description FROM vicidial_lists WHERE campaign_id = '$campaign'";
   // Optimized Query: using indexed fields, smaller scan with WHERE

 $query = "
   SELECT 
    vl.list_id,
    vl.list_name,
    vl.campaign_id,
    vl.list_description,
    MAX(vlog.called_count) AS max_called_count,
    COUNT(vlog.lead_id) AS lead_count,
    SUM(CASE WHEN vlog.status IN ('SUBMIT', 'TRA', 'DROPIN') THEN 1 ELSE 0 END) AS submit_count
FROM vicidial_lists vl
LEFT JOIN (
    SELECT lead_id, list_id, called_count, status
    FROM vicidial_list
) vlog ON vl.list_id = vlog.list_id
WHERE vl.campaign_id = '$campaign'
GROUP BY 
    vl.list_id,
    vl.list_name,
    vl.campaign_id,
    vl.list_description
    ";
// echo $query = "
//     SELECT 
//         vl.list_id, 
//         vl.list_name, 
//         vl.campaign_id, 
//         vl.list_description,
//         MAX(vlog.called_count) AS max_called_count,
//         SUM(CASE WHEN vlog.status IN ('SUBMIT', 'TRA', 'DROPIN') THEN 1 ELSE 0 END) AS submit_count
//     FROM vicidial_lists vl
//     LEFT JOIN (
//         SELECT list_id, called_count, status 
//         FROM vicidial_list 
//         WHERE status IN ('SUBMIT', 'TRA', 'DROPIN')
//     ) vlog ON vl.list_id = vlog.list_id
//     WHERE vl.campaign_id = '$campaign'
//     GROUP BY vl.list_id
// ";

$result = $camp_conn->query($query);
$data = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$camp_conn->close();

header('Content-Type: application/json');
echo json_encode($data);
exit;
}

