<?php
$res = [];

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action == "check") {
        $process_check = shell_exec("ps aux | grep '[z]enba.py'");
        $res['status'] = trim($process_check) ? 1 : 0;
    } elseif ($action == "run") {
        shell_exec("python /srv/www/htdocs/Preq-new/function/Zenba/cron/zenba.py > /dev/null 2>&1 &");
        $res['status'] = "Zenba Started";
    }
} else {
    $process_check = shell_exec("ps aux | grep '[z]enba.py'");
    if (trim($process_check)) {
        $res['status'] = "Zenba Running";
    } else {
        $res['status'] = "Zenba Stopped. Starting...";
        shell_exec("python /srv/www/htdocs/Preq-new/function/Zenba/cron/zenba.py > /dev/null 2>&1 &");
    }
}

header('Content-Type: application/json');
echo json_encode($res);
?>
