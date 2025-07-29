<?php
include '../../function/DB/pdo-db-59.php';
include '../../function/session.php';

date_default_timezone_set('America/New_York');
$today_from = date("Y-m-d H:i:s");

// Safely get POST values
$firstname          = $_POST['firstname'];
$lastname           = $_POST['lastname'];
$listid             = $_POST['listid'];
$phonenumber        = $_POST['phonenumber'];
$timestamps         = $_POST['timestamps'];
$campaigns          = $_POST['campaigns'];
$feedback_commends  = $_POST['feedback_commends'];
$command            = $_POST['programming'];
$disp_command       = $_POST['disp_command'];
$username           = $_POST['username'];

try {
    $sql = "UPDATE QC_Reports 
            SET QC_Audited = :username, 
                QC_dispo = :disp_command, 
                QC_update_timestamp = :update_time, 
                QC_comments = :command, 
                validation_status = :feedback, 
                final_status = 'Done' 
            WHERE leadid = :listid 
              AND camp = :camp 
              AND timestamp = :timestamp";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':username'     => $username,
        ':disp_command' => $disp_command,
        ':update_time'  => $today_from,
        ':command'      => $command,
        ':feedback'     => $feedback_commends,
        ':listid'       => $listid,
        ':camp'         => $campaigns,
        ':timestamp'    => $timestamps
    ]);

    echo json_encode(["statusCode" => 200]);
} catch (PDOException $e) {
    echo json_encode(["statusCode" => 201, "error" => $e->getMessage()]);
}
?>
