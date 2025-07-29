<?php
    include('../../../config.php');

    $today_date = date('Y-m-d');
    $fromdate = $today_date;
    $todate = $today_date;


    $sql = mysqli_query($conn, "SELECT * FROM `campaigns_details` WHERE `status` = 'ACTIVE' ORDER BY `id` DESC");

    while ($row = mysqli_fetch_assoc($sql)) {
        $campaign = urlencode($row['campaign_value']);
         function http_get($url, $params) {
                $url .= '?' . http_build_query($params);
                $context = stream_context_create([
                    'http' => [
                        'method' => "GET",
                        'timeout' => 10
                    ],
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false
                    ]
                ]);
                return file_get_contents($url, false, $context);
            }


    function http_post($url, $data) {
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            )
        );
        $context = stream_context_create($options);
        return file_get_contents($url, false, $context);
    }
        // echo $campaign;
        // === 1. Get user extension list ===
        $url1 = "http://localhost/Preq-zenba/DB/zenba_repo.php";
        $response1 = http_get($url1, array(
            'fromdate' => $fromdate,
            'todate' => $todate,
            'campaign' => $campaign
        ));
        echo "1";
        print_r($response1);
        $datasuccess = json_decode($response1, true);
        if (!$datasuccess) {
            die("Failed to decode JSON from zenba_repo.php");
        }

        foreach ($datasuccess as $user) {
            $phonenum = isset($user['extension']) ? $user['extension'] : '';

            // === 2. Get call records for this extension ===
            $url2 = "http://localhost/Preq-zenba/DB/threefetchviewnew.php";
            $response2 = http_get($url2, array(
                'fromdate' => $fromdate,
                'todate' => $todate,
                'campaign' => $campaign,
                'phonenum' => $phonenum
            ));

            $datasuccess1 = json_decode($response2, true);
            if (!$datasuccess1) continue;

            foreach ($datasuccess1 as $usernew) {
                $userview    = isset($usernew['user']) ? $usernew['user'] : '';
                $leadidnew   = isset($usernew['lead_id']) ? $usernew['lead_id'] : '';
                $campaignnew = isset($usernew['campaign_id']) ? $usernew['campaign_id'] : '';
                $datenew     = isset($usernew['call_date']) ? substr($usernew['call_date'], 0, 10) : '';

                // === 3. Update view via POST ===
                $url3 = "http://localhost/Preq-zenba/DB/updateview.php";
                http_post($url3, array(
                    'userview' => $userview,
                    'leadidnew' => $leadidnew,
                    'campaignnew' => $campaignnew,
                    'datenew' => $datenew
                ));
            }
        }

        echo "Executed: ".$campaign. "<br />";

    }
   echo 'Process Done.';
?>