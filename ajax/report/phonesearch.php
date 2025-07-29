<?php
// Include session or necessary files here
$action = isset($_GET['action']) ? $_GET['action'] : '';
$response = []; // Initialize response array

if ($action === 'phonesearchlead') {
    // Validate the phone number from GET
    $phonenumber = isset($_GET['phonenumber']) ? trim($_GET['phonenumber']) : '';

    if (empty($phonenumber)) {
        echo json_encode(['status' => 'error', 'message' => 'Phone number is required']);
        exit;
    }

    // Database connection details for first database
    $servernametwo = "192.168.200.42";
    $dbusernametwo = "zeal";
    $dbpasswordtwo = "4321";
    $databasetwo = "zealousv2";

    // Establish first database connection
    $conn = new mysqli($servernametwo, $dbusernametwo, $dbpasswordtwo, $databasetwo);

    if ($conn->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to connect to the first database: ' . $conn->connect_error]);
        exit;
    }

    // Database connection details for second database
    $servernameone = "192.168.200.151";
    $dbusernameone = "zeal";
    $dbpasswordone = "4321";
    $databaseone = "asterisk";

    $connone = new mysqli($servernameone, $dbusernameone, $dbpasswordone, $databaseone);

    if ($connone->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to connect to the second database: ' . $connone->connect_error]);
        exit;
    }

    // Use prepared statement to prevent SQL injection
    $sql = "SELECT DISTINCT `id`, `phone_number`, `audio_link_url`, `agent_first_name`, `status`, `campid`, `leadid` 
            FROM `IVE_QC_Reports` 
            WHERE `phone_number` = ? ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $phonenumber);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $data = []; // Array to store results

        while ($row = $result->fetch_assoc()) {
            // Fetch user details from the second database
            $user_query = "SELECT `full_name`, `user_group` FROM `vicidial_users` WHERE `user` = ?";
            $user_stmt = $connone->prepare($user_query);
            $user_stmt->bind_param("s", $row['agent_first_name']);
            $user_stmt->execute();
            $user_result = $user_stmt->get_result();
            $user_details = $user_result->fetch_assoc();

            // Append user details to the row data
            $row['full_name'] = $user_details['full_name'] ?? null;
            $row['user_group'] = $user_details['user_group'] ?? null;

            $data[] = $row;

            // Close the user query statement
            $user_stmt->close();
        }

        // Check if data was found
        if (!empty($data)) {
            $response = ['status' => 'success', 'data' => $data];
        } else {
            $response = ['status' => 'error', 'message' => 'No records found'];
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Query execution failed: ' . $stmt->error];
    }

    // Close statements and database connections
    $stmt->close();
    $conn->close();
    $connone->close();
} else {
    $response = ['status' => 'error', 'message' => 'Invalid action'];
}

// Output JSON response
echo json_encode($response);
?>
