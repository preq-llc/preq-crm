<?php
include('../../config.php');

if(isset($_GET['action']) == 'check')
{
    $files_datas = json_decode($_POST['files']);
    $batch = $_POST['batch'];
    $res = [];
    $flag = 0;
    $datetime = date('Y-m-d');
    $last_batch_no = $batch;

    $res['batch'] = $last_batch_no;
    foreach ($files_datas as $row) {
        if (isset($row->Telephone)) {
            $clean_number = preg_replace('/\D/', '', $row->Telephone);

            if (strlen($clean_number) === 10) {
                
                $sql = mysqli_query($conn, "SELECT count as lastcount, phone_no FROM `duplicate_check` WHERE `phone_no` = '$clean_number' AND `date` = '$datetime' ORDER BY id desc");
                if ($get = mysqli_fetch_assoc($sql)) {
                    // $max_s = mysqli_query($conn, "SELECT MAX(count) as lastcount, phone_no FROM `duplicate_check` WHERE `phone_no` = '$clean_number' AND `date` = '$datetime'")
                    
                    $phone_no = $get['phone_no'] ?: $clean_number; // fallback to clean_number
                    $count = (int)$get['lastcount'];

                    if ($count >= 3) {
                        $res['reached_3'][] = $phone_no;
                    } 

                    $newcount = $count + 1;
                    mysqli_query($conn, "INSERT INTO `duplicate_check` (`phone_no`, `batch`, `count`, `date`) VALUES ('$clean_number', $last_batch_no, $newcount, '$datetime')");

                    $res['available'][] = [
                        "phone_no" => $phone_no,
                        "count" => $newcount
                    ];
                } 
                else 
                {
                        mysqli_query($conn, "INSERT INTO `duplicate_check` (`phone_no`, `batch`, `count`, `date`) VALUES ('$clean_number', $last_batch_no, 1, '$datetime')");
                        $res['new'][] = $clean_number;
                        // $res['new'][] = [
                        //     "phone_no" => $clean_number
                        // ];
                        $flag = 1;
                }
            } else {
                $res['invalidnumbers'][] = $row->Telephone;
                $res['error'] = 'Invalid Number Found!';
            }
        }
    }

    if ($flag === 1) {
        $res['status'] = 'Ok';
        $res['remarks'] = 'Number(s) processed.';
    } else {
        $res['status'] = 'Error';
        $res['remarks'] = 'No valid numbers processed.';
    }

    header('Content-Type: application/json');
    echo json_encode($res);
}
else if($_GET['action'] == 'download')
{
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="phone_data.csv"');

    // Open output stream
    $output = fopen('php://output', 'w');

    // Output CSV header
    fputcsv($output, ['Phone Number', 'Count']);

    // Output each row
    foreach ($res['data'] as $row) {
        fputcsv($output, [$row['phone_no'], $row['count']]);
    }

    fclose($output);
    exit;
}
else
{
     $res['status'] = 'No Access';
     $res['remarks'] = 'Invalid endpoint';
    header('Content-Type: application/json');
    echo json_encode($res);
}

?>
