<?php
// echo 'test';

include '../../config.php';
include $path.'function/session.php';
require_once '../../libs/SimpleXLSXGen.php';
use Shuchkin\SimpleXLSXGen;
$action=$_GET['action'];
$data = [];
$format = $_GET['format'];
// echo 'tet';
if ($action == 'getleadreport') {
    $fromdatevalue = $_GET['fromdatevalue'];
    $todatevalue = $_GET['todatevalue'];
    $slctcampvalue = $_GET['slctcampvalue'];
    $call_centervalue = $_GET['call_centervalue'];
    $agent_id = $_GET['agent_id'];

    if ($slctcampvalue !== "FTE_ALL") {
        // Get DB credentials for selected campaign
        $campaignQuery = "SELECT * FROM campaigns_details WHERE campaign_value='$slctcampvalue' AND status='ACTIVE'";
        $campaignResult = mysqli_query($conn, $campaignQuery) or die(mysqli_error($conn));
        $campaignData = mysqli_fetch_array($campaignResult);

        $servername = ($slctcampvalue === 'EDU_SB1' && $fromdatevalue !== $today_date) ? "192.168.200.231" : $campaignData['camp_ip'];

        $dbusername = $campaignData['db_username'];
        $dbpassword = $campaignData['db_password'];
        $database   = $campaignData['db_database'];

        // Filters


        if ($fromdatevalue != $today_date) {

                    $callcenter_query = $call_centervalue ? " AND val.user LIKE '%$call_centervalue%'" : '';
                    $agent_query = $agent_id ? " AND val.user ='$agent_id'" : '';

            $values = shell_exec("mysql -u $dbusername -p$dbpassword -h $servername -D $database -N -e \"
                SELECT 
                    val.status,
                    vs.status_name AS full_status,
                    COUNT(val.status) AS staus_cunt
                FROM vicidial_agent_log_archive AS val
                LEFT JOIN vicidial_statuses AS vs ON vs.status = val.status
                WHERE 
                    val.event_time BETWEEN '$fromdatevalue 00:00:00' AND '$todatevalue 23:59:59'
                    AND val.campaign_id = '$slctcampvalue'
                    $callcenter_query
                    $agent_query
                    AND val.status IS NOT NULL
                GROUP BY val.status\"");
        } else {

              $callcenter_query = $call_centervalue ? " AND val.user LIKE '%$call_centervalue%'" : '';
              $agent_query = $agent_id ? " AND val.user ='$agent_id'" : '';

            $values = shell_exec("mysql -u $dbusername -p$dbpassword -h $servername -D $database -N -e \"
                SELECT 
                    val.status,
                    vs.status_name AS full_status,
                    COUNT(val.status) AS staus_cunt
                FROM vicidial_agent_log AS val
                LEFT JOIN vicidial_statuses AS vs ON vs.status = val.status
                WHERE 
                    val.event_time BETWEEN '$fromdatevalue 00:00:00' AND '$todatevalue 23:59:59'
                    AND val.campaign_id = '$slctcampvalue'
                    $callcenter_query
                    $agent_query
                    AND val.status IS NOT NULL
                GROUP BY val.status\"");
        }

        if (!empty($values)) {
            $rows = explode("\n", trim($values));
            foreach ($rows as $row) {
                list($status, $full_status, $count) = explode("\t", $row);
                $data['data'][] = [
                    'status'      => $status,
                    'full_status' => $full_status,
                    'staus_cunt'  => $count
                ];
            }
        }

    } else {
        // Process FTE_ALL (multiple campaigns)
        $campains = ['EDU_SB', 'EDU_SB1'];
        $data = $result = [];

        $callcenter_query = $call_centervalue ? " AND user LIKE '%$call_centervalue%'" : '';
        $agent_query = $agent_id ? " AND user ='$agent_id'" : '';

        foreach ($campains as $comp) {
            $queryCamp = "SELECT * FROM campaigns_details WHERE campaign_value='$comp' AND status='ACTIVE'";
            $resultCamp = mysqli_query($conn, $queryCamp) or die(mysqli_error($conn));
            $campData = mysqli_fetch_array($resultCamp);

            $servername = ($comp === 'EDU_SB1' && $fromdatevalue !== $today_date) ? "192.168.200.231" : $campData['camp_ip'];
            $dbusername = $campData['db_username'];
            $dbpassword = $campData['db_password'];
            $database   = $campData['db_database'];

            $table = ($fromdatevalue !== $today_date) ? "vicidial_agent_log_archive" : "vicidial_agent_log";

            $query = "SELECT status, COUNT(status) AS status_count FROM $table
                      WHERE event_time BETWEEN '$fromdatevalue 00:00:00' AND '$todatevalue 23:59:59'
                      AND campaign_id = '$comp' $callcenter_query $agent_query AND status IS NOT NULL
                      GROUP BY status";

            $values = shell_exec("mysql -u $dbusername -p$dbpassword -h $servername -D $database -N -e \"$query\"");

            if (!empty($values)) {
                $rows = explode("\n", trim($values));
                foreach ($rows as $row) {
                    list($status, $count) = explode("\t", $row);
                    $data[$comp][$status] = ($data[$comp][$status] ?? 0) + $count;
                }
            }
        }

        // Merge and prepare final response
        foreach ($campains as $comp) {
            foreach ($data[$comp] as $status => $count) {
                $result[$status] = ($result[$status] ?? 0) + $count;
            }
        }

        foreach ($result as $status => $count) {
            $final_data['data'][] = [
                'status'     => $status,
                'staus_cunt' => $count
            ];
        }
    }
}
else if($action == 'getleadtotal')
{
    $fromdatevalue=$_GET['fromdatevalue'];
    $todatevalue=$_GET['todatevalue'];
    $slctcampvalue=$_GET['slctcampvalue'];
    $call_centervalue = $_GET['call_centervalue'];
    $agent_id =$_GET['agent_id'];

    if($slctcampvalue != 'FTE_ALL')
    {
        $ss="select * from campaigns_details where campaign_value='$slctcampvalue' AND status='ACTIVE'";
        $rr=mysqli_query($conn,$ss)or die(mysqli_error($conn));
        $fr=mysqli_fetch_array($rr);
    
        $dbip=$fr['camp_ip'];
        $db_name=$fr['db_username'];
        $db_password=$fr['db_password'];
        $db_database=$fr['db_database'];

        if($slctcampvalue == 'EDU_SB1')
        {
            if($fromdatevalue == $today_date)
            {
                $servername =  "$dbip";
    
            }
            else
            {
                $servername =  "192.168.200.231";
    
            }
        }
        else
        {
            $servername =  "$dbip";
        }
        $dbusername =  "$db_name";
        $dbpassword = "$db_password";
        $database = "$db_database";
        
        if($fromdatevalue != $today_date)
        {
            $agent_query = '';
            if($agent_id != '')
            {
                $agent_query = " AND vicidial_agent_log_archive.user  = '$agent_id'";
            }


                $callcenter_query = '';
            if($call_centervalue != '')
            {
                $callcenter_query = " AND vicidial_agent_log_archive.user  LIKE '%$call_centervalue%'";
            }



            $values = shell_exec("mysql -u $dbusername -p$dbpassword -h $servername -D $database -N -e \"SELECT count(status) as staus_cunt_view  FROM vicidial_agent_log_archive WHERE event_time>='$fromdatevalue 00:00:00' AND event_time<='$todatevalue 23:59:59' AND campaign_id='$slctcampvalue' $callcenter_query  $agent_query AND status IS NOT NULL\"");
        }
        else if($fromdatevalue == $today_date)
        {
            $callcenter_query = '';
            if($call_centervalue != '')
            {
                $callcenter_query = " AND vicidial_agent_log.user  LIKE '%$call_centervalue%'";
            }

            $agent_query = '';
            if($agent_id != '')
            {
                $agent_query = " AND vicidial_agent_log.user  = '$agent_id'";
            }



            $values = shell_exec("mysql -u $dbusername -p$dbpassword -h $servername -D $database -N -e \"SELECT count(status) as staus_cunt_view FROM vicidial_agent_log WHERE event_time>='$fromdatevalue 00:00:00' AND event_time<='$todatevalue 23:59:59' AND campaign_id='$slctcampvalue' $callcenter_query $agent_query AND status IS NOT NULL\"");
        }



        if (!empty($values)) {
            $rows = explode("\n", trim($values));
            // $data[$IP] = array();
            
            foreach ($rows as $row) {
                $cols = explode("\t", $row);
                $data['data'][] = array(
                    
                    'staus_cunt_view' => $cols[0],
                );
            }
        }
    }
    else
    {

        $campains = ['EDU_SB', 'EDU_SB1'];
        $data = array(); // Initialize an empty array to store the results
        foreach ($campains as $camp) 
        {
            $added_final_data = 0;

            $ss="select * from campaigns_details where campaign_value='$camp' AND status='ACTIVE'";
            $rr=mysqli_query($conn,$ss)or die(mysqli_error($conn));
            $fr=mysqli_fetch_array($rr);
        
            $dbip=$fr['camp_ip'];
            $db_name=$fr['db_username'];
            $db_password=$fr['db_password'];
            $db_database=$fr['db_database'];

            if($camp == 'EDU_SB1')
            {
                if($fromdatevalue == $today_date)
                {
                    $servername =  "$dbip";
        
                }
                else
                {
                    $servername =  "192.168.200.231";
        
                }
            }
            else
            {
                $servername =  "$dbip";
            }
            // echo $servername;
            $dbusername =  "$db_name";
            $dbpassword = "$db_password";
            $database = "$db_database";

            if ($fromdatevalue != $today_date) 
            {
                $callcenter_query = '';
                if($call_centervalue != '')
                {
                    $callcenter_query = " AND user  LIKE '%$call_centervalue%'";
                }

                   $agent_query = '';
                    if($agent_id != '')
                    {
                        $agent_query = " AND user  = '$agent_id'";
                    }


                $values = shell_exec("mysql -u $dbusername -p$dbpassword -h $servername -D $database -N -e \"SELECT count(status) as staus_cunt_view  FROM vicidial_agent_log_archive WHERE event_time>='$fromdatevalue 00:00:00' AND event_time<='$todatevalue 23:59:59' AND campaign_id='$camp' $callcenter_query $agent_query AND status IS NOT NULL\"");
            }
            if ($fromdatevalue == $today_date) 
            {

                $callcenter_query = '';
                if($call_centervalue != '')
                {
                    $callcenter_query = " AND user  LIKE '%$call_centervalue%'";
                }

                 $agent_query = '';
                    if($agent_id != '')
                    {
                        $agent_query = " AND user  = '$agent_id'";
                    }


                // echo 'test';
                $values = shell_exec("mysql -u $dbusername -p$dbpassword -h $servername -D $database -N -e \"SELECT count(status) as staus_cunt_view FROM vicidial_agent_log WHERE event_time>='$fromdatevalue 00:00:00' AND event_time<='$todatevalue 23:59:59' AND campaign_id='$camp' $callcenter_query $agent_query AND status IS NOT NULL\"");
            }
    
            if (!empty($values)) 
            {
                $rows = explode("\n", trim($values));
                              
                foreach ($rows as $row) 
                {
                    $cols = explode("\t", $row);
                    // $get_total_from_db = $cols[0];
                    $added_final_data += $cols[0];

                }
            }
            
            $get_count += $added_final_data;

        }
         // Add the data for each campaign separately
         $final_data['data'][] = array(
            'staus_cunt_view' => $get_count,
        );
        // $final_data['status'] = 'Ok';
    }
}

else if($action == 'getdisporeport')
{
    $dispView=$_GET['dispView'];
    $fromdatedispo=$_GET['fromdatedispo'];
    $todatedispo=$_GET['todatedispo'];
    $camp=$_GET['camp'];
    $call_center = $_GET['call_center'];
    $agent_id = $_GET['agent_id'];
    if($camp != 'FTE_ALL')
    {
            $ss="select * from campaigns_details where campaign_value='$camp' AND status='ACTIVE'";
            $rr=mysqli_query($conn,$ss)or die(mysqli_error($conn));
            $fr=mysqli_fetch_array($rr);
        
            $dbip=$fr['camp_ip'];
            $db_name=$fr['db_username'];
            $db_password=$fr['db_password'];
            $db_database=$fr['db_database'];

            if($camp == 'EDU_SB1')
            {
                if($fromdatedispo == $today_date)
                {
                    $servername =  "$dbip";
        
                }
                else
                {
                    $servername =  "192.168.200.231";
        
                }
            // echo $servername;

            }
            else
            {
                $servername =  "$dbip";
            }
            // echo $servername;
            $dbusername =  "$db_name";
            $dbpassword = "$db_password";
            $database = "$db_database";
           
            if($fromdatedispo != $today_date)
            {
                $callcenter_query = '';
                if($call_center != '')
                {
                    $callcenter_query = " AND vicidial_agent_log_archive.user  LIKE '%$call_center%'";
                }

                $agent_query = '';
                if($agent_id != '')
                {
                    $agent_query = " AND vicidial_agent_log_archive.user = '$agent_id'";
                }
            
            $values = shell_exec("mysql -u $dbusername -p$dbpassword -h $servername -D $database -N -e \"SELECT vicidial_agent_log_archive.agent_log_id,vicidial_agent_log_archive.lead_id,vicidial_users.full_name as user,vicidial_agent_log_archive.user as agent,vicidial_agent_log_archive.campaign_id,vicidial_agent_log_archive.status,vicidial_agent_log_archive.comments,vicidial_agent_log_archive.event_time,recording_log.filename FROM vicidial_agent_log_archive INNER JOIN recording_log ON vicidial_agent_log_archive.lead_id=recording_log.lead_id INNER JOIN vicidial_users ON vicidial_agent_log_archive.user=vicidial_users.user WHERE event_time>='$fromdatedispo 00:00:00' AND event_time<='$todatedispo 23:59:59' AND campaign_id='$camp' AND status='$dispView' $callcenter_query $agent_query group by vicidial_agent_log_archive.agent_log_id\"");
            }
            else if($fromdatedispo==$today_date)
            {
                $callcenter_query = '';
                if($call_center != '')
                {
                    $callcenter_query = " AND vicidial_agent_log.user  LIKE '%$call_center%'";
                }

                $agent_query = '';
                if($agent_id != '')
                {
                    $agent_query = " AND vicidial_agent_log.user = '$agent_id'";
                }

                $values = shell_exec("mysql -u $dbusername -p$dbpassword -h $servername -D $database -N -e \"SELECT vicidial_agent_log.agent_log_id,vicidial_agent_log.lead_id,vicidial_users.full_name as user,vicidial_agent_log.user as agent,vicidial_agent_log.campaign_id,vicidial_agent_log.status,vicidial_agent_log.comments,vicidial_agent_log.event_time,recording_log.filename FROM vicidial_agent_log INNER JOIN recording_log ON vicidial_agent_log.lead_id=recording_log.lead_id INNER JOIN vicidial_users ON vicidial_agent_log.user=vicidial_users.user WHERE event_time>='$fromdatedispo 00:00:00' AND event_time<='$todatedispo 23:59:59' AND campaign_id='$camp' AND status='$dispView' $callcenter_query $agent_query group by vicidial_agent_log.agent_log_id\"");
            }   

                                $lines = explode("\n", trim($values));
                                $data = [];

                                foreach ($lines as $line) {
                                    $fields = explode("\t", $line); 
                                    $data['data'][] = [
                                        'agent_log_id' => $fields[0],
                                        'lead_id'      => $fields[1],
                                        'user'         => $fields[2],
                                        'agent'        => $fields[3],
                                        'campaign_id'  => $fields[4],
                                        'status'       => $fields[5],
                                        'comments'     => $fields[6],
                                        'event_time'   => $fields[7],
                                        'filename'     => $fields[8],
                                    ];
                                }

    }
    else
    {
        $real_camps = ['EDU_SB1', 'EDU_SB'];
        $data = [];
       
            foreach ($real_camps as $org_camp) {
               
                $ss="select * from campaigns_details where campaign_value='$org_camp' AND status='ACTIVE'";
                $rr=mysqli_query($conn,$ss)or die(mysqli_error($conn));
                $fr=mysqli_fetch_array($rr);
            
                $dbip=$fr['camp_ip'];
                $db_name=$fr['db_username'];
                $db_password=$fr['db_password'];
                $db_database=$fr['db_database'];

                if($org_camp == 'EDU_SB1')
                {
                    if($fromdatedispo == $today_date)
                    {
                        $servername =  "$dbip";
            
                    }
                    else
                    {
                        $servername =  "192.168.200.231";
            
                    }
                }
                else
                {
                    $servername =  "$dbip";
                }
                // echo $servername;
                $dbusername =  "$db_name";
                $dbpassword = "$db_password";
                $database = "$db_database";
            
                if($fromdatedispo != $today_date)
                {
                    $callcenter_query = '';
                    if($call_center != '')
                    {
                        $callcenter_query = " AND vicidial_agent_log_archive.user  LIKE '%$call_center%'";
                    }

                    $agent_query = '';
                    if($agent_id != '')
                    {
                        $agent_query = " AND vicidial_agent_log.user = '$agent_id'";
                    }


                    $values = shell_exec("mysql -u $dbusername -p$dbpassword -h $servername -D $database -N -e \"SELECT vicidial_agent_log_archive.agent_log_id,vicidial_agent_log_archive.lead_id,vicidial_users.full_name as user,vicidial_agent_log_archive.user as agent,vicidial_agent_log_archive.campaign_id,vicidial_agent_log_archive.status,vicidial_agent_log_archive.comments,vicidial_agent_log_archive.event_time,recording_log.filename FROM vicidial_agent_log_archive INNER JOIN recording_log ON vicidial_agent_log_archive.lead_id=recording_log.lead_id INNER JOIN vicidial_users ON vicidial_agent_log_archive.user=vicidial_users.user WHERE event_time>='$fromdatedispo 00:00:00' AND event_time<='$todatedispo 23:59:59' AND campaign_id='$org_camp' AND status='$dispView' $callcenter_query $agent_query group by vicidial_agent_log_archive.agent_log_id\"");
                } 
                else if ($fromdatedispo == $today_date) 
                {
                    $callcenter_query = '';
                    if($call_center != '')
                    {
                        $callcenter_query = " AND vicidial_agent_log_archive.user  LIKE '%$call_center%'";
                    }


                    $agent_query = '';
                    if($agent_id != '')
                    {
                        $agent_query = " AND vicidial_agent_log.user = '$agent_id'";
                    }

                    
                    $values = shell_exec("mysql -u $dbusername -p$dbpassword -h $servername -D $database -N -e \"SELECT vicidial_agent_log.agent_log_id,vicidial_agent_log.lead_id,vicidial_users.full_name as user,vicidial_agent_log.user as agent,vicidial_agent_log.campaign_id,vicidial_agent_log.status,vicidial_agent_log.comments,vicidial_agent_log.event_time,recording_log.filename FROM vicidial_agent_log INNER JOIN recording_log ON vicidial_agent_log.lead_id=recording_log.lead_id INNER JOIN vicidial_users ON vicidial_agent_log.user=vicidial_users.user WHERE event_time>='$fromdatedispo 00:00:00' AND event_time<='$todatedispo 23:59:59' AND campaign_id='$org_camp' AND status='$dispView' $callcenter_query $agent_query group by vicidial_agent_log.agent_log_id\"");
                }
                if (!empty($values)) {
                   
                    $rows = explode("\n", trim($values));
                    
                    foreach ($rows as $row) {
                        $cols = explode("\t", $row);
                        $data['data'][] = array(
                            'agent_log_id' => $cols[0],
                            'lead_id' => $cols[1],
                            'user' => $cols[2],
                            'agent' => $cols[3],
                            'campaign_id' => $cols[4],
                            'status' => $cols[5],
                            'comments' => $cols[6],
                            'event_time' => $cols[7],
                            'filename' => $cols[8],
                        );
                    }
                }
            }
    }
}
else if($action == 'getDispoDetails')
{
    $leadid=$_GET['leadID'];
    $phoneno=$_GET['phoneno'];
    $campaign_id=$_GET['campaign_id'];
    
    $ss="select * from campaigns_details where campaign_value='$campaign_id' AND status='ACTIVE'";
    $rr=mysqli_query($conn,$ss)or die(mysqli_error($conn));
    $fr=mysqli_fetch_array($rr);

    $dbip=$fr['camp_ip'];
    $db_name=$fr['db_username'];
    $db_password=$fr['db_password'];
    $db_database=$fr['db_database'];

    $servername =  "$dbip";
    $dbusername =  "$db_name";
    $dbpassword = "$db_password";
    $database = "$db_database";
      $query = "SELECT 
    CASE WHEN first_name IS NULL OR first_name = '' THEN 'NULL' ELSE first_name END AS first_name, 
    CASE WHEN last_name IS NULL OR last_name = '' THEN 'NULL' ELSE last_name END AS last_name, 
    CASE WHEN address1 IS NULL OR address1 = '' THEN 'NULL' ELSE address1 END AS address1, 
    CASE WHEN city IS NULL OR city = '' THEN 'NULL' ELSE city END AS city, 
    CASE WHEN state IS NULL OR state = '' THEN 'NULL' ELSE state END AS state, 
    CASE WHEN postal_code IS NULL OR postal_code = '' THEN 'NULL' ELSE postal_code END AS postal_code, 
    CASE WHEN lead_id IS NULL OR lead_id = '' THEN 'NULL' ELSE lead_id END AS lead_id, 
    CASE WHEN phone_number IS NULL OR phone_number = '' THEN 'NULL' ELSE phone_number END AS phone_number, 
    CASE WHEN email IS NULL OR email = '' THEN 'NULL' ELSE email END AS email 
    FROM vicidial_list 
    WHERE lead_id = '$leadid' AND phone_number = '$phoneno'";

    $values = shell_exec("mysql -u $dbusername -p$dbpassword -h $servername -D $database -N -e \"$query\"");


    if (!empty($values)) {
        $rows = explode("\n", trim($values));
        // $data[$IP] = array();
        
        foreach ($rows as $row) {
            $cols = explode("\t", $row);
            $data['data'][] = array(

                'first_name' => $cols[0],
                'last_name' => $cols[1],
                'address1' => $cols[2],
                'city' => $cols[3],
                'state' => $cols[4],
                'postal_code' => $cols[5],
                'lead_id' => $cols[6],
                'phone_number' => $cols[7],
                'email' => $cols[8],
            );
        }
    }

}
else if($action == 'getDispoAudio')
{
    // $IP_ADDRESSES = array("192.168.200.70");
    $IP = '192.168.200.70';
    $DB_USER = "zeal";
    $DB_PASS = "4321";
    $DB_NAME = "asterisk";
    
    $data = array();
    
    $leadid=$_GET['leadID'];
    $phoneno=$_GET['phoneno'];
    $campaign_id=$_GET['campaign_id'];
    $dateTime=$_GET['dateTime'];
    $date = date('Y-m-d', strtotime($dateTime));

        // foreach ($IP_ADDRESSES as $IP) {
    
        
        $values = shell_exec("mysql -u $DB_USER -p$DB_PASS -h $IP -D $DB_NAME -N -e \"SELECT location FROM recording_log WHERE  filename LIKE '%$phoneno%' AND start_time LIKE '%$date%' \"");
    
        if (!empty($values)) {
            $rows = explode("\n", trim($values));
            // $data[$IP] = array();
            
            foreach ($rows as $row) {
                $cols = explode("\t", $row);
                $data['data'][] = array(
    
                    'location' => $cols[0],

                );
            }
        }
    // }
}
else if($action == 'getRecordingStatus')
{
    $leadid=$_GET['leadID'];
    $phoneno=$_GET['phoneno'];
    $campaign_id=$_GET['campaign_id'];
    $agentid=$_GET['agent'];
    $dateTime=$_GET['dateTime'];
    
    $date = date('Y-m-d', strtotime($dateTime));

    $ss="select * from campaigns_details where campaign_value='$campaign_id' AND status='ACTIVE'";
    $rr=mysqli_query($conn,$ss)or die(mysqli_error($conn));
    $fr=mysqli_fetch_array($rr);

    $dbip=$fr['camp_ip'];
    $db_name=$fr['db_username'];
    $db_password=$fr['db_password'];
    $db_database=$fr['db_database'];
    $showrecord=$fr['show_recordings'];

    if($logged_in_user_name != 'SHOW')
    {
        $servername =  "$dbip";
        $dbusername =  "$db_name";
        $dbpassword = "$db_password";
        $database = "$db_database";
    
    
        $recording_path = $fr['recordingpath'];
       
    
        $values = shell_exec("mysql -u $dbusername -p$dbpassword -h $servername -D $database -N -e \"SELECT location FROM recording_log WHERE  filename LIKE '%$phoneno%' AND user='$agentid' AND start_time LIKE '%$date%' AND channel LIKE '%LOCAL%'\"");
    
        if (!empty($values)) {
            $rows = explode("\n", trim($values));
            // $data[$IP] = array();
            
          foreach ($rows as $row) {
                $cols = explode("\t", $row);
                $data['data'][] = array(
                    'location' => $cols[0],
                    'recordingpath' =>  $recording_path,
                    'showrecord' =>  $showrecord,
                );
            }

        }
    }


}
else if ($action == 'extrashow') {
    // Get input parameters
    $fromdatevalue = $_GET['fromdatevalue'];
    $todatevalue = $_GET['todatevalue'];
    $slctcampvalue = $_GET['slctcampvalue'];
    $call_centervalue = $_GET['call_centervalue'];

    // Determine the correct table names based on the date
    $table = ($fromdatevalue == $today_date) ? 'vicidial_log' : 'vicidial_log_archive';
    $agent_log_table = ($fromdatevalue == $today_date) ? 'vicidial_agent_log' : 'vicidial_agent_log_archive';
    $closer_log_table = ($fromdatevalue == $today_date) ? 'vicidial_closer_log' : 'vicidial_closer_log_archive';

    // Fetch campaign database details
    $getDb = mysqli_query($conn, "SELECT * FROM campaigns_details WHERE campaign_value = '$slctcampvalue' AND status = 'ACTIVE'")
        or die("Error fetching campaign details: " . mysqli_error($conn));

    if (mysqli_num_rows($getDb) == 0) {
        die("No active campaign found for value: $slctcampvalue");
    }

    $fr = mysqli_fetch_assoc($getDb);
    $dbip = $fr['camp_ip'];
    $db_user = $fr['db_username'];
    $db_pass = $fr['db_password'];
    $db_name = $fr['db_database'];
    $voice_key = $fr['voice_key'];

    // Connect to the campaign-specific database
    $temcon = mysqli_connect($dbip, $db_user, $db_pass, $db_name);
    if (!$temcon) {
        die("Failed to connect to campaign database: " . mysqli_connect_error());
    }

    // SQL for duplicate phone number stats by list
    $duplicateSql = "
        WITH PhoneDuplicateCounts AS (
            SELECT list_id, phone_number, COUNT(*) AS duplicate_count
            FROM $table
            WHERE STR_TO_DATE(call_date, '%Y-%m-%d %H:%i:%s') 
                BETWEEN '$fromdatevalue 00:00:00' AND '$todatevalue 23:59:59'
                AND list_id NOT IN ('998', '999')
                AND campaign_id = '$slctcampvalue'
            GROUP BY list_id, phone_number
        )
        SELECT 
            vl.list_description, 
            vl.resets_today,
            ph.list_id, 
            MAX(ph.duplicate_count) AS highest_duplicate_count
        FROM PhoneDuplicateCounts ph
        LEFT JOIN vicidial_lists vl ON vl.list_id = ph.list_id
        GROUP BY ph.list_id
    ";

    // SQL for total dialed calls
    $dialSql = "
        SELECT COUNT(*) AS total_dial 
        FROM $table 
        WHERE call_date BETWEEN '$fromdatevalue 00:00:00' AND '$todatevalue 23:59:59' AND campaign_id = '$slctcampvalue'
    ";

    // SQL for total closer calls
    $clSql = "
        SELECT COUNT(*) AS total_clos_dial 
        FROM $closer_log_table 
        WHERE call_date BETWEEN '$fromdatevalue 00:00:00' AND '$todatevalue 23:59:59' AND campaign_id = '$slctcampvalue'
    ";

    // SQL for status breakdown per list (Transfer, Submit)
     $additonaldata = "
         SELECT 
            list_id, 
            COUNT(*) AS duplicate_count, 
            -- SUM(CASE WHEN status = 'TRA' THEN 1 ELSE 0 END) AS Transfer,
            SUM(CASE WHEN status = 'SUBMIT' THEN 1 ELSE 0 END) AS Submit
        FROM $table
        WHERE STR_TO_DATE(call_date, '%Y-%m-%d %H:%i:%s') 
            BETWEEN '$fromdatevalue 00:00:00' AND '$todatevalue 23:59:59'
            AND list_id NOT IN ('998', '999') 
            AND campaign_id = '$slctcampvalue'
        GROUP BY list_id
    ";

    // Execute queries
    $duplicateResult = mysqli_query($temcon, $duplicateSql);
    $dialResult = mysqli_query($temcon, $dialSql);
    $clsResult = mysqli_query($temcon, $clSql);
    $additionalResult = mysqli_query($temcon, $additonaldata);

    // Prepare response data
    $data = ['data' => []];

    while ($row = mysqli_fetch_assoc($duplicateResult)) {
        $data['data'][] = $row;
    }

    $totalDial = mysqli_fetch_assoc($dialResult)['total_dial'] ?? 0;
    $totalCloser = mysqli_fetch_assoc($clsResult)['total_clos_dial'] ?? 0;

    $data['total_dial'] = $totalDial + $totalCloser;

    while ($rowtwo = mysqli_fetch_assoc($additionalResult)) {
        $data['additionaldata'][] = $rowtwo;
    }
}

else if($action == 'getdipoList')
{
    $startDate=$_GET['startDate'];
    $endDate=$_GET['endDate'];
    $campaign=$_GET['campaign'];


   
    // echo $startDate;
    // echo $endDate;

    $table = ($startDate == $today_date) ? 'vicidial_log' : 'vicidial_log_archive';
    $log_table = ($startDate == $today_date) ? 'vicidial_closer_log' : 'vicidial_closer_log_archive';
    $getDb = mysqli_query($conn, "SELECT * FROM campaigns_details WHERE campaign_value='$campaign' AND status='ACTIVE'") 
    or die("Error fetching campaign details: " . mysqli_error($conn));

    if (mysqli_num_rows($getDb) == 0) {
        die("No active campaign found for value: $campaign");
    }

    $fr = mysqli_fetch_assoc($getDb);

    // Extract database credentials
    $dbip = $fr['camp_ip'];
    $db_name = $fr['db_username'];
    $db_password = $fr['db_password'];
    $db_database = $fr['db_database'];
    $voice_key = $fr['voice_key'];
    $campaign_inbound = $fr['inbound_camp'];


    // Connect to campaign database
    $temcon = mysqli_connect($dbip, $db_name, $db_password, $db_database);
    // echo $log_table;
    $sql = mysqli_query($temcon, "SELECT status, SUM(count) AS total_count, MAX(description) AS description
                                    FROM (
                                       
                                        SELECT status, COUNT(*) AS count, NULL AS description 
                                        FROM $log_table 
                                        WHERE call_date BETWEEN '$startDate 00:00:00' AND '$endDate 23:59:59' 
                                        AND campaign_id = '$campaign_inbound'
                                        GROUP BY status

                                        UNION ALL

                                        SELECT v.status, COUNT(*) AS count, vicidial_statuses.status_name AS description 
                                        FROM $table v
                                        LEFT JOIN vicidial_statuses ON vicidial_statuses.status = v.status 
                                        WHERE v.call_date BETWEEN '$startDate 00:00:00' AND '$endDate 23:59:59' 
                                        AND campaign_id = '$campaign'
                                        GROUP BY v.status, vicidial_statuses.status_name
                                    ) AS combined_counts
                                    GROUP BY status
                                    ");

                                    while($result = mysqli_fetch_assoc($sql))
                                    {
                                        $data['data'][] = $result;
                                    }
                                   

}
else if ($action == 'updateDispoDetails') {

    $slctcampvalue = $_GET['campaign_id'];
    $leadid        = $_GET['leadID'];
    $phonenumber   = $_GET['phoneno'];
    $newstatus     = $_GET['new_status'];

    // Get VICIdial server IP and DB credentials
    $ss = "SELECT * FROM campaigns_details WHERE campaign_value='$slctcampvalue' AND status='ACTIVE'";
    $rr = mysqli_query($conn, $ss) or die(mysqli_error($conn));
    $fr = mysqli_fetch_array($rr);

    if (!$fr) {
        echo json_encode(['status' => 'error', 'message' => 'Campaign not found or inactive']);
        exit;
    }

    $dbip        = $fr['camp_ip'];
    $db_name     = $fr['db_username'];
    $db_password = $fr['db_password'];
    $db_database = $fr['db_database'];

    // Connect to VICIdial DB
    $vicidial_conn = new mysqli($dbip, $db_name, $db_password, $db_database);
    if ($vicidial_conn->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'DB connection failed: ' . $vicidial_conn->connect_error]);
        exit;
    }

    // Sanitize variables
    $leadid      = $vicidial_conn->real_escape_string($leadid);
    $phonenumber = $vicidial_conn->real_escape_string($phonenumber);
    $campaign_id = $vicidial_conn->real_escape_string($slctcampvalue);
    $newstatus   = $vicidial_conn->real_escape_string($newstatus);

    // Update queries
    $queries = [
        "UPDATE vicidial_log SET status='$newstatus' WHERE lead_id='$leadid' AND campaign_id='$campaign_id' AND phone_number='$phonenumber'",
        "UPDATE vicidial_agent_log SET status='$newstatus' WHERE lead_id='$leadid' AND campaign_id='$campaign_id'",
        "UPDATE vicidial_list SET status='$newstatus' WHERE lead_id='$leadid' AND phone_number='$phonenumber'",
        "UPDATE vicidial_closer_log SET status='$newstatus' WHERE lead_id='$leadid' AND phone_number='$phonenumber' AND campaign_id='$campaign_id'"
    ];

    $success = true;
    foreach ($queries as $query) {
        if (!$vicidial_conn->query($query)) {
            $success = false;
            $error = $vicidial_conn->error;
            break;
        }
    }

    $vicidial_conn->close();

    if ($success) {
        $data = ['status' => 'success', 'message' => 'Disposition updated successfully'];
    } else {
        $data = ['status' => 'error', 'message' => 'Query failed: ' . $error];
    }
}

else if ($action == 'liveagent') {

    $selectedCampaign = $_GET['campaign_name'];

    // Get campaign DB details
    $sql = "SELECT * FROM campaigns_details 
            WHERE campaign_value = '$selectedCampaign' AND status = 'ACTIVE'";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result);

    $camp_ip     = $row['camp_ip'];
    $db_username = $row['db_username'];
    $db_password = $row['db_password'];
    $db_database = $row['db_database'];
    $voice_key   = $row['voice_key'];

    // Determine DB host
    if ($selectedCampaign == 'EDU_SB1') {
        $servername = ($fromdatevaluesview == $today_date) ? $camp_ip : "192.168.200.231";
    } else {
        $servername = $camp_ip;
    }

    // Connect to campaign-specific DB
    $camp_conn = mysqli_connect($servername, $db_username, $db_password, $db_database);
    if (!$camp_conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Query to fetch live agents (joined with full names)
    $liveAgentSql = "
        SELECT va.user as agent_id, vu.full_name as full_name
        FROM vicidial_agent_log AS va  
        LEFT JOIN vicidial_users AS vu ON vu.user = va.user
        WHERE va.campaign_id = '$selectedCampaign'
         GROUP BY va.user ";

    $liveAgentResult = mysqli_query($camp_conn, $liveAgentSql) or die(mysqli_error($camp_conn));

    $getresponse = [];
    while ($row = mysqli_fetch_assoc($liveAgentResult)) {
        $getresponse[] = $row;
    }

    $data['status'] = 'Ok';
    $data['data'] = $getresponse;

    mysqli_close($camp_conn);
}





header('Content-Type: application/json');
echo json_encode($data);

?>