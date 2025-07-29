<?php
// Sanitize input
$campip      = $_POST['campip'] ?? '';
$session_id  = $_POST['session_id'] ?? '';
$server_ip   = $_POST['server_ip'] ?? '';
$source      = $_POST['source'] ?? 'test';
$phone_login = $_POST['phone_login'] ?? '';
$pass        = $_POST['pass'] ?? '';

// Build the remote API URL
$url = "http://$campip/vicidial/non_agent_api.php";
$params = http_build_query([
    'user'        => $phone_login,
    'source'      => $source,
    'pass'        => $pass,
    'function'    => 'blind_monitor',
    'phone_login' => $phone_login,
    'session_id'  => $session_id,
    'server_ip'   => $server_ip,
    'stage'       => 'MONITOR'
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

// Optional: skip SSL verification if Vicidial uses a self-signed cert (for HTTPS only)
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    http_response_code(500);
    echo "CURL Error: " . curl_error($ch);
} else {
    echo $response;
}

curl_close($ch);
