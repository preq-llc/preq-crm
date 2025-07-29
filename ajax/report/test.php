<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

$fromdatevaluesview = '2024-04-17';
$todatevaluesview = '2024-04-17';
$slctcampvalueview = 'EDU_SB';
$voice_key = 'NULL';

// Database connection parameters
$servername = '192.168.200.181';
$database = 'asterisk';
$dbusername = 'zeal';
$dbpassword = '4321';

try {
    // Create a PDO connection
    $con = new PDO("mysql:host=$servername;dbname=$database", $dbusername, $dbpassword);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sth = $con->prepare("SELECT vicidial_agent_log_archive.campaign_id as camp,vicidial_agent_log_archive.user as users ,vicidial_agent_log_archive.event_time,count(vicidial_agent_log_archive.talk_sec) as Totalcalls,sum((vicidial_agent_log_archive.talk_sec)+(vicidial_agent_log_archive.wait_sec)+(vicidial_agent_log_archive.dispo_sec)+(vicidial_agent_log_archive.dead_sec)) as Hrs,sum(case when  vicidial_agent_log_archive.status = 'TRA' || vicidial_agent_log_archive.status = 'TRADS'   then 1 else 0 end) AS Transfer,sum(case when vicidial_agent_log_archive.status = 'SUBMIT' || vicidial_agent_log_archive.status = 'SUBDS' || vicidial_agent_log_archive.status = 'TRA'  || vicidial_agent_log_archive.status = 'TRADS' || vicidial_agent_log_archive.status = 'EDGEDS' || vicidial_agent_log_archive.status = 'DROPIN' then 1 else 0 end) AS successtransfer from vicidial_agent_log_archive INNER JOIN vicidial_users ON vicidial_agent_log_archive.user=vicidial_users.user where vicidial_agent_log_archive.event_time>= '$fromdatevaluesview 00:00:00' AND vicidial_agent_log_archive.event_time <= '$todatevaluesview 23:59:59' AND vicidial_agent_log_archive.campaign_id='$slctcampvalueview'  AND wait_sec<65000 AND talk_sec<65000 AND dispo_sec<65000 AND (vicidial_users.user_level='1' OR vicidial_users.user_level='7') AND vicidial_agent_log_archive.status != 'NULL' GROUP BY vicidial_agent_log_archive.user order by vicidial_agent_log_archive.campaign_id ASC");

    // Execute the query
    $sth->execute();

    // Fetch all results as associative array
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);

    // Output the result as JSON
    echo json_encode($result);
} catch (PDOException $e) {
    // Handle database connection or query errors
    echo "Error: " . $e->getMessage();
}
?>
