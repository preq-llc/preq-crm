<?php
include '../../config.php';
include $path . 'function/session.php';

$action = $_GET['action'];

if ($action == "getuserstatsDetails") {
  $agent = $_GET['agent'];
  $startDate = $_GET['startDate'];
  $endDate = $_GET['endDate'];
  $campaign = $_GET['campaign_id'];

  // Get DB credentials
  $ss = "SELECT * FROM campaigns_details WHERE campaign_value='$campaign' AND status='ACTIVE'";
  $rr = mysqli_query($conn, $ss) or die(mysqli_error($conn));
  $fr = mysqli_fetch_array($rr);

  $dbip = $fr['camp_ip'];
  $db_name = $fr['db_username'];
  $db_password = $fr['db_password'];
  $db_database = $fr['db_database'];

  $servername = $dbip;
  $dbusername = $db_name;
  $dbpassword = $db_password;
  $database = $db_database;

   $startDateTime = $startDate . " 00:00:00";
    $endDateTime = $endDate . " 23:59:59";
    $today = date('Y-m-d');

    if ($startDate === $today && $endDate === $today) {
        $table = "vicidial_agent_log";
    } else {
        $table = "vicidial_agent_log_archive";
    }
    // echo $dbusername;
    $query = "SELECT t.status,vs.status_name, COUNT(*) AS total 
            FROM $table AS t
            LEFT JOIN vicidial_statuses AS vs ON vs.status = t.status
            WHERE t.event_time BETWEEN '$startDateTime' AND '$endDateTime'
              AND t.user = '$agent'
              AND t.campaign_id = '$campaign'
            GROUP BY t.status;
            ";
   $values = shell_exec("mysql -u $dbusername -p$dbpassword -h $servername -D $database -N -e \"$query\"");


    $data = [];

    if (!empty($values)) {
        $rows = explode("\n", trim($values));
        foreach ($rows as $row) {
            $cols = explode("\t", $row);
            $data['stats'][] = [
                'status' => $cols[0],
                'statusname' => $cols[1],
                'count' => (int)$cols[2]
            ];
        }
    } else {
        $data['stats'] = [];
    }

    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}
