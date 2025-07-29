    <?php

    include('../../config.php');
    include('../../session.php');
    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $username = $_SESSION['username'];
    if ($action == 'createvoipdetails') {
        function handleFileUploads($target_dir, $files)
        {
            $file_names = array();
            foreach ($files['tmp_name'] as $index => $tmp_name) {
                $target_file = $target_dir . basename($files['name'][$index]);
                $allowed_types = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'avif');
                $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                if (!in_array($file_type, $allowed_types)) {
                    die("Error: Invalid file type.");
                }

                if (move_uploaded_file($tmp_name, $target_file)) {
                    $file_names[] = basename($files['name'][$index]);
                } else {
                    echo "Error uploading file: " . $files['name'][$index];
                    exit;
                }
            }
            return $file_names;
        }

        $target_dir = '/srv/www/htdocs/Preq-new/ajax/voip/files/';
        $file_names = handleFileUploads($target_dir, $_FILES['files']);

        // Retrieve POST data
        $invoice_no = mysqli_real_escape_string($conn, $_POST['invoice_no'] ?? '');
        $voip_name_details = mysqli_real_escape_string($conn, $_POST['voip_name_details'] ?? '');
        $invoice_date = mysqli_real_escape_string($conn, $_POST['invoice_date'] ?? '');
        $amount_paid = floatval($_POST['amount_paid'] ?? 0);
        $uploaded_by = mysqli_real_escape_string($conn, $username);

        // Assuming $file_names is an array of uploaded file names
        $screenshots = implode(',', $file_names);

        $insert_invoice = $conn->prepare("INSERT INTO viop_invoice_details (invoice_no, invoice_date, amount, screen_shot, voip_name, uploaded_by)
                                  VALUES (?, ?, ?, ?, ?, ?)");
        if ($insert_invoice === false) {
            // Handle prepare error
            echo json_encode([
                'status' => 'error',
                'message' => 'Prepare failed: ' . $conn->error
            ]);
            exit;
        }

        $insert_invoice->bind_param("ssdsss", $invoice_no, $invoice_date, $amount_paid, $screenshots, $voip_name_details, $uploaded_by);

        if ($insert_invoice->execute()) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Data inserted successfully.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to insert data: ' . $insert_invoice->error
            ]);
        }

        $insert_invoice->close();
    } else if ($action == 'createpaid_details') {

        if (!isset($_FILES['files']) || empty($_FILES['files']['name'][0])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'No files uploaded.'
            ]);
            exit;
        }

        function handleFileUploads($target_dir, $files)
        {
            $file_names = array();
            foreach ($files['tmp_name'] as $index => $tmp_name) {
                $target_file = $target_dir . basename($files['name'][$index]);
                $allowed_types = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'avif');
                $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                if (!in_array($file_type, $allowed_types)) {
                    die("Error: Invalid file type.");
                }

                if (move_uploaded_file($tmp_name, $target_file)) {
                    $file_names[] = basename($files['name'][$index]);
                } else {
                    echo "Error uploading file: " . $files['name'][$index];
                    exit;
                }
            }
            return $file_names;
        }

        $target_dir = '/srv/www/htdocs/Preq-new/ajax/voip/files/';
        $file_names = handleFileUploads($target_dir, $_FILES['files']);

        // Get POST values
        $invoice_no = mysqli_real_escape_string($conn, $_POST['invoice_no'] ?? '');
        $invoice_date = mysqli_real_escape_string($conn, $_POST['invoice_date'] ?? '');
        $amount_paid = floatval($_POST['amount_paid'] ?? 0);
        $uploaded_by = mysqli_real_escape_string($conn, $username);
        $status = 'credited';

        // Get voip_name from viop_invoice_details
        $sql_voip = "SELECT voip_name FROM viop_invoice_details WHERE invoice_no = ?";
        $stmt_voip = $conn->prepare($sql_voip);
        $stmt_voip->bind_param("s", $invoice_no);
        $stmt_voip->execute();
        $stmt_voip->bind_result($voip_name_details);
        $stmt_voip->fetch();
        $stmt_voip->close();

        if (empty($voip_name_details)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'No matching VoIP name found for the invoice.'
            ]);
            exit;
        }

        // Get voip_id from voip_master
        $stmt = $conn->prepare("SELECT id FROM voip_master WHERE voip_name = ?");
        $stmt->bind_param("s", $voip_name_details);
        $stmt->execute();
        $stmt->bind_result($voip_id);
        $stmt->fetch();
        $stmt->close();

        if (empty($voip_id)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid VoIP name. No matching ID found.'
            ]);
            exit;
        }

        // Get previous balance
        $sql_balance = "SELECT balance_amount FROM voip_usage WHERE voip_name = ? ORDER BY id DESC LIMIT 1";
        $stmt_balance = $conn->prepare($sql_balance);
        $stmt_balance->bind_param("s", $voip_name_details);
        $stmt_balance->execute();
        $stmt_balance->bind_result($previous_balance);
        $stmt_balance->fetch();
        $stmt_balance->close();
        $previous_balance = $previous_balance ?? 0;

        $new_balance = $previous_balance + $amount_paid;

        // Insert into voip_usage
        $insert_usage = $conn->prepare("
            INSERT INTO voip_usage (
                voip_id, 
                voip_name, 
                entry_date, 
                previous_used, 
                amount_used, 
                credited_amount, 
                balance_amount, 
                status, 
                created_by
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $zero = 0.0;

        $insert_usage->bind_param(
            "issdddsss",
            $voip_id,
            $voip_name_details,
            $invoice_date,
            $previous_balance,
            $zero,                
            $amount_paid,
            $new_balance,
            $status,
            $uploaded_by
        );


        // Update voip_invoice_details with paid info
        $screenshots = implode(',', $file_names);
        $update_invoice = $conn->prepare("UPDATE viop_invoice_details 
                                      SET paid_amount = ?, paid_date = ?, paid_screenshot = ?, paid_updated_by = ?, status = 'Paid' 
                                      WHERE invoice_no = ?");
        $update_invoice->bind_param("dssss", $amount_paid, $invoice_date, $screenshots, $uploaded_by, $invoice_no);

        if ($insert_usage->execute() && $update_invoice->execute()) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Paid details and usage record inserted successfully.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to insert or update data: ' . $conn->error
            ]);
        }

        $insert_usage->close();
        $update_invoice->close();
    } elseif ($action == 'getdata') {
        $fromdatevalue = $_GET['fromdatevalue'];
        $todatevalue = $_GET['todatevalue'];
        $qcDispo_status = $_GET['qcDispo'];

        // Initialize $voip_name filter
        $voip_name = '';

        if (!empty($qcDispo_status)) {
            $voip_name = " AND voip_name = '$qcDispo_status'";
        }

        // Construct the SQL query
        $sqldataone = "SELECT * FROM `voip_usage` WHERE `entry_date` >= '$fromdatevalue' AND `entry_date` <= '$todatevalue' $voip_name AND `status`='debited'";

        // Perform the query
        $result = mysqli_query($conn, $sqldataone);
        if ($result) {
            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $response = [
                'status' => 'Ok',
                'message' => 'Data retrieved successfully.',
                'data' => $data
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Failed to retrieve data: ' . mysqli_error($conn)
            ];
        }

        echo json_encode($response);
    } elseif ($action == 'getdata_voip') {
        $fromdatevalue = $_GET['fromdatevalue'];
        $todatevalue = $_GET['todatevalue'];
        $qcDispo_status = $_GET['qcDispo'];

        // Initialize $voip_name filter
        $voip_name = '';

        if (!empty($qcDispo_status)) {
            $voip_name = " AND voip_name = '$qcDispo_status'";
        }

        // Construct the SQL query
        $sqldataone = "SELECT * FROM `viop_invoice_details` WHERE `paid_date` >= '$fromdatevalue' AND `paid_date` <= '$todatevalue' $voip_name";

        // Perform the query
        $result = mysqli_query($conn, $sqldataone);
        if ($result) {
            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $response = [
                'status' => 'Ok',
                'message' => 'Data retrieved successfully.',
                'data' => $data
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Failed to retrieve data: ' . mysqli_error($conn)
            ];
        }

        echo json_encode($response);
    } elseif ($action == 'getsumdata') {
        $fromdatevalue = $_GET['fromdatevalue'];
        $todatevalue = $_GET['todatevalue'];
        $qcDispo_status = $_GET['qcDispo'];

        // Initialize $voip_name filter
        $voip_name = '';

        if (!empty($qcDispo_status)) {
            $voip_name = " AND voip_name = '$qcDispo_status'";
        }

        // Construct the SQL query
        $sqldataone = "SELECT voip_name, SUM(`amount_used`) as total_payment
                   FROM `voip_usage`
                   WHERE `entry_date` >= '$fromdatevalue' AND `entry_date` <= '$todatevalue' $voip_name
                   GROUP BY voip_name";

        // echo $sqldataone;
        // Perform the query
        $result = mysqli_query($conn, $sqldataone);
        if ($result) {
            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $response = [
                'status' => 'Ok',
                'message' => 'Data retrieved successfully.',
                'data' => $data
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Failed to retrieve data: ' . mysqli_error($conn)
            ];
        }

        echo json_encode($response);
    } elseif ($action == 'usagedata') {

        // Sanitize input values
        $fromdatevalue = mysqli_real_escape_string($conn, $_GET['fromdatevalue']);
        $todatevalue = mysqli_real_escape_string($conn, $_GET['todatevalue']);
        $qcDispo_status = isset($_GET['qcDispo']) ? mysqli_real_escape_string($conn, $_GET['qcDispo']) : '';

        // Build VoIP name filter if provided
        $voip_name_filter = '';
        if (!empty($qcDispo_status)) {
            $voip_name_filter = " AND voip_name = '$qcDispo_status'";
        }

        // Flag to help client-side logic
        $sajith = empty($voip_name_filter) ? 'good' : 'bad';

        // SQL query with ordering to ensure latest record is last
        $sql = "SELECT `voip_name`, `did`, `entry_date`, `previous_used`, `amount_used`,`credited_amount`, `balance_amount`, `status`, `created_by`
            FROM `voip_usage`
            WHERE `entry_date` >= '$fromdatevalue' AND `entry_date` <= '$todatevalue' $voip_name_filter
            ORDER BY `entry_date` ASC, `id` ASC";

        $result = $conn->query($sql);

        if ($result) {
            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $response = [
                'status' => 'Ok',
                'message' => 'Data retrieved successfully.',
                'sajith' => $sajith,
                'data' => $data
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Failed to retrieve data: ' . mysqli_error($conn)
            ];
        }

        echo json_encode($response);
    }



    ?>







 
