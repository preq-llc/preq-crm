<?php
    include '../session.php';
    $username = $_SESSION['emp_id'];
    date_default_timezone_set('Asia/Kolkata');
    $dateTime = date('Y-m-d H:i:s');
    $conn = mysqli_connect("192.168.200.59", "zeal", "4321", "Agent_calls_FAPI");

    // if(!$conn)
    // {
    //     die('error : '. mysqli_connect_error());
    // }
    $action = $_GET['action'];

    if($action == "get_lead")
    {
        // echo '1';
        $lead_id = $_GET['lead_id'];

        $sql = mysqli_query($conn, "SELECT * FROM `QC_Reports` WHERE leadid = '$lead_id'");
        while($get_lead = mysqli_fetch_assoc($sql))
        {
            $res['data'][] = $get_lead;
        }

        $res['status'] = 'Ok';
    }
    else if($action == "update_lead")
    {
        $lead_id = $_GET['lead_id'];
        $agent_username = $_GET['agent_username'];
        $camp = $_GET['camp'];
        $QC_Audited = $_GET['QC_Audited'];
        $qc_comment = $_GET['qc_comment'];

        if($qc_comment == "")
        {
            $qc_status = "NULL";
        }
        else
        {
            $qc_status = "'$qc_comment'";
        }
        $flag = 0;

        // echo "(mysqli_query(1, TEST `QC_Reports` SET `QC_comments`=$qc_status WHERE agent_username = $agent_username AND camp = $camp AND leadid = $lead_id AND QC_Audited = $QC_Audited))";
        mysqli_query($conn, "UPDATE `QC_Reports` SET `QC_comments`=$qc_status WHERE agent_username = '$agent_username' AND camp = '$camp' AND leadid = '$lead_id' AND QC_Audited = '$QC_Audited'");
        mysqli_query($conn, "INSERT INTO `lead_update_log`(`lead_id`, `qc_comment`, `updated_by`, `timestamp`) VALUES ('$lead_id', $qc_status,'$username', '$dateTime')");
        $res['status'] = 'Ok';
    }   

    echo json_encode($res);
?>