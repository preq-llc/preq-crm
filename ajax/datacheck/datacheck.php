<?php
include '../../config.php';
include '../../59config.php';
include $path . 'function/session.php';

session_start();
// set_time_limit(600);
ini_set('max_execution_time', '0');
ini_set('memory_limit', '512M');

$user = $_SESSION['username'] ?? 'Unknown User';
$action = $_GET['action'] ?? '';

if ($action == 'datacheck') {
    if (!isset($_FILES['filedata'])) {
        echo json_encode(['status' => 'error', 'message' => 'No file uploaded.']);
        exit;
    }

    // Get uploaded file details
    $datafiless = $_FILES['filedata']['name'];  
    $datafile = $_FILES['filedata']['tmp_name'];
    $currentdate  = $_POST['todatevalue'];
    $before14days = $_POST['fromdatevalue'];
    $slctcampvalue = $_POST['slctcampvalue'];
    $slctdispo = $_POST['slctdispo'];

    // Format dispo list for SQL IN clause
    $dispoArray = explode(',', $slctdispo);
    $escapedDispoArray = array_map(function ($dispo) use ($connnew) {
        return "'" . mysqli_real_escape_string($connnew, trim($dispo)) . "'";
    }, $dispoArray);
    $fullDnc = implode(',', $escapedDispoArray); // 'DNC','NI','SUBMIT'

    // File handling setup
    $dateTime = date('YmdHis');
    $dir = "/srv/www/htdocs/Preq-new/assets/listfilters/";
    $logDir = "/srv/www/htdocs/Preq-new/assets/logs/";

    // Test folder permission by creating a temporary file
    if (!is_dir($dir) || !is_writable($dir) || !is_writable($logDir)) {
        echo json_encode(['status' => 'error', 'message' => "Error: Directory is not writable. Check permissions."]);
        exit;
    }

    $filename = "filtered_data_$dateTime.csv";
    $filepath = $dir . $filename; 
    $exe_path = 'assets/listfilters/' . $filename;

    $output = fopen($filepath, 'w');
    if (!$output) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to create CSV file.']);
        exit;
    }

    // Log File Setup
    $logfilename = "$slctcampvalue.$dateTime.json";
    $logfilepath = $logDir . $logfilename;

    $res = ['passednumbers' => [], 'removednumbers' => []];

    if (($handle = fopen($datafile, 'r')) !== FALSE) {
        $header = fgetcsv($handle);
        
        if (!$header || empty($header)) {
            echo json_encode(['status' => 'error', 'message' => 'CSV file has no valid header.']);
            exit;
        }

        fputcsv($output, $header); // Write header

        date_default_timezone_set("America/New_York");

        $currentdateWithHrs = $currentdate . ' 23:59:59';
        $before14dateWithHrs = $before14days . ' 00:00:00';

        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (count($row) != count($header)) {
                continue; // Skip invalid rows
            }

            $record = array_combine($header, $row);
            $values = array_values($record);
            $phoneNumber = mysqli_real_escape_string($connnew, trim($values[0]));

            // Use prepared statement to prevent SQL injection
            $sql = $connnew->prepare("
                SELECT phone_number FROM phonenumber_check 
                WHERE phone_number = ? 
                AND campaign_id = ? 
                AND (
                    dispo IN ($fullDnc) 
                    AND (dispo NOT IN ('NI') OR (dispo = 'NI' AND date BETWEEN ? AND ?))
                ) 
                ORDER BY id DESC
            ");
            $sql->bind_param("ssss", $phoneNumber, $slctcampvalue, $before14dateWithHrs, $currentdateWithHrs);
            $sql->execute();
            $result = $sql->get_result();

            if ($result->num_rows == 0) { // No match found, allow number
                fputcsv($output, $values);
                $res['passednumbers'][] = $phoneNumber;
            } else {
                $res['removednumbers'][] = $phoneNumber;
            }
            $sql->close();
        }

        // Insert log into database using prepared statement
        $insertQuery = $conn->prepare("
            INSERT INTO `phonenumbercheck_log` (`file_name`, `fromdate`, `todate`, `camp_id`, `dispo`, `user`) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $insertQuery->bind_param("ssssss", $datafiless, $before14days, $currentdate, $slctcampvalue, $slctdispo, $user);
        if (!$insertQuery->execute()) {
            echo json_encode(['status' => 'error', 'message' => 'Database insert failed: ' . $conn->error]);
            exit;
        }
        $insertQuery->close();

        fclose($handle);
        fclose($output);
        $connnew->close();
    }

    $passedCount = count($res['passednumbers']);
    $removedCount = count($res['removednumbers']);

    file_put_contents($logfilepath, json_encode($res, JSON_PRETTY_PRINT));

    echo json_encode([
        'removed_count' => $removedCount,
        'passed_count' => $passedCount,
        'status' => 'success',
        'file_url' => $exe_path,
        'log_file' => 'assets/logs/' . $logfilename
    ]);
    exit;
}
?>
