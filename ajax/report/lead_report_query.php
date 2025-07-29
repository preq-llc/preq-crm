
<?php
// echo 'test';

include '../../config.php';
include $path.'function/session.php';
require_once '../../libs/SimpleXLSXGen.php';
use Shuchkin\SimpleXLSXGen;
$action=$_GET['action'];
$data = [];
$format = $_GET['format'];
if($format == 'xlsx')
{
  

    $dispView = $_GET['dispView'];
    $fromdatedispo = $_GET['fromdatedispo'];
    $todatedispo = $_GET['todatedispo'];
    $camp = $_GET['camp'];
    $today_date = date('Y-m-d');
    $datas = [];

    $real_camps = ($camp == 'FTE_ALL') ? ['EDU_SB1', 'EDU_SB'] : [$camp];

    foreach ($real_camps as $org_camp) {
        $ss = "SELECT * FROM campaigns_details WHERE campaign_value='$org_camp' AND status='ACTIVE'";
        $rr = mysqli_query($conn, $ss) or die(mysqli_error($conn));
        $fr = mysqli_fetch_array($rr);

        $dbip = $fr['camp_ip'];
        $db_name = $fr['db_username'];
        $db_password = $fr['db_password'];
        $db_database = $fr['db_database'];

        $servername = ($org_camp == 'EDU_SB1' && $fromdatedispo != $today_date) ? "192.168.200.231" : $dbip;
        $database = $db_database;

        $callcenter_query = '';
        if (!empty($call_center)) {
            $user_field = ($fromdatedispo == $today_date) ? 'vicidial_agent_log.user' : 'vicidial_agent_log_archive.user';
            $callcenter_query = " AND $user_field LIKE '%$call_center%'";
        }

        $table = ($fromdatedispo == $today_date) ? 'vicidial_agent_log' : 'vicidial_agent_log_archive';

        $query = "
            SELECT 
                $table.agent_log_id,
                $table.lead_id,
                vicidial_users.full_name AS user,
                $table.user AS agent,
                $table.campaign_id,
                $table.status,
                $table.comments,
                $table.event_time,
                recording_log.filename 
            FROM 
                $table 
                INNER JOIN recording_log ON $table.lead_id = recording_log.lead_id 
                INNER JOIN vicidial_users ON $table.user = vicidial_users.user 
            WHERE 
                event_time >= '$fromdatedispo 00:00:00' 
                AND event_time <= '$todatedispo 23:59:59' 
                AND campaign_id = '$org_camp' 
                AND status = '$dispView' 
                $callcenter_query 
            GROUP BY $table.agent_log_id
        ";

        $values = shell_exec("mysql -u $db_name -p$db_password -h $servername -D $database -N -e \"$query\"");

        if (!empty($values)) {
            $lines = explode("\n", trim($values));

            foreach ($lines as $line) {
                $fields = explode("\t", $line);
                $filename_field = $fields[8] ?? '';
                $mobileno_parts = explode("_", $filename_field);

                $datas[] = [
                    $fields[7] ?? '',                   // Date and Time
                    $mobileno_parts[1] ?? '',           // Phone Number from filename
                    $fields[5] ?? ''                    // Status
                ];
            }
        }
    }

    // print_r($datas);

    if (!empty($datas)) {
        // Add heading row
        array_unshift($datas, ['Date and Time', 'Phone Number', 'Status']);

        // Choose filename
        switch ($camp) {
            case 'SHOW1': $filename = 'SHOW1_DNC_REPORT_' . $fromdatedispo; break;
            case 'SHOW2': $filename = 'SHOW2_RENEWAL_DNC_REPORT_' . $fromdatedispo; break;
            case 'SHOW3': $filename = 'SHOW3_REACTIVATION_DNC_REPORT_' . $fromdatedispo; break;
            case 'SHOW5': $filename = 'SHOW_CANCEL_DNC_REPORT_' . $fromdatedispo; break;
            default: $filename = 'DNC_REPORT_' . $fromdatedispo; break;
        }

        SimpleXLSXGen::fromArray($datas)->downloadAs("$filename.xlsx");
     
    } else {
        echo "No data found.";
    }
}
else if($format == 'csv')
{
    $dispView = $_GET['dispView'];
    $fromdatedispo = $_GET['fromdatedispo'];
    $todatedispo = $_GET['todatedispo'];
    $camp = $_GET['camp'];
    $today_date = date('Y-m-d');
    $data = [];

    $real_camps = ($camp == 'FTE_ALL') ? ['EDU_SB1', 'EDU_SB'] : [$camp];

    foreach ($real_camps as $org_camp) {
        $ss = "SELECT * FROM campaigns_details WHERE campaign_value='$org_camp' AND status='ACTIVE'";
        $rr = mysqli_query($conn, $ss) or die(mysqli_error($conn));
        $fr = mysqli_fetch_array($rr);

        $dbip = $fr['camp_ip'];
        $db_name = $fr['db_username'];
        $db_password = $fr['db_password'];
        $db_database = $fr['db_database'];

        if ($org_camp == 'EDU_SB1' && $fromdatedispo != $today_date) {
            $servername = "192.168.200.231";
        } else {
            $servername = $dbip;
        }

        $dbusername = $db_name;
        $dbpassword = $db_password;
        $database = $db_database;

        $callcenter_query = '';
        if (!empty($call_center)) {
            $user_field = ($fromdatedispo == $today_date) ? 'vicidial_agent_log.user' : 'vicidial_agent_log_archive.user';
            $callcenter_query = " AND $user_field LIKE '%$call_center%'";
        }

        $table = ($fromdatedispo == $today_date) ? 'vicidial_agent_log' : 'vicidial_agent_log_archive';

        $query = "
            SELECT 
                $table.agent_log_id,
                $table.lead_id,
                vicidial_users.full_name AS user,
                $table.user AS agent,
                $table.campaign_id,
                $table.status,
                $table.comments,
                $table.event_time,
                recording_log.filename 
            FROM 
                $table 
                INNER JOIN recording_log ON $table.lead_id = recording_log.lead_id 
                INNER JOIN vicidial_users ON $table.user = vicidial_users.user 
            WHERE 
                event_time >= '$fromdatedispo 00:00:00' 
                AND event_time <= '$todatedispo 23:59:59' 
                AND campaign_id = '$org_camp' 
                AND status = '$dispView' 
                $callcenter_query 
            GROUP BY $table.agent_log_id
        ";

        $values = shell_exec("mysql -u $dbusername -p$dbpassword -h $servername -D $database -N -e \"$query\"");

        if (!empty($values)) {
            $lines = explode("\n", trim($values));

            foreach ($lines as $line) {
                $fields = explode("\t", $line);

                $filename_field = $fields[8] ?? '';
                $mobileno_parts = explode("_", $filename_field);

                $data[] = [
                    'event_time' => $fields[7] ?? '',
                    'status'     => $fields[5] ?? '',
                    'filename'   => $mobileno_parts[1] ?? $filename_field
                ];
            }
        }
    }

    // If we have data, generate the CSV
    if (!empty($data)) {
        // Choose filename
        switch ($camp) {
            case 'SHOW1':
                $filename = 'SHOW1_DNC_REPORT_' . $fromdatedispo;
                break;
            case 'SHOW2':
                $filename = 'SHOW2_RENEWAL_DNC_REPORT_' . $fromdatedispo;
                break;
            case 'SHOW3':
                $filename = 'SHOW3_REACTIVATION_DNC_REPORT_' . $fromdatedispo;
                break;
            case 'SHOW5':
                $filename = 'SHOW_CANCEL_DNC_REPORT_' . $fromdatedispo;
                break;
            default:
                $filename = 'DNC_REPORT_' . $fromdatedispo;
                break;
        }

        // Send headers
        header('Content-Type: text/csv');
        header("Content-Disposition: attachment; filename={$filename}.csv");
        header('Pragma: no-cache');
        header('Expires: 0');

        // Output the CSV
        $output = fopen('php://output', 'w');
        fputcsv($output, ['Date and Time', 'Phonenumber', 'Status']);

        foreach ($data as $row) {
            fputcsv($output, [$row['event_time'], $row['filename'], $row['status']]);
        }

        fclose($output);
        exit;
    } else {
        echo "No data found.";
    }
}
?>