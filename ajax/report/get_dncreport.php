<?php
chdir(__DIR__);
require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
require_once '../../libs/SimpleXLSXGen.php';
require_once '../../config.php'; // assumes $conn is initialized inside

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Shuchkin\SimpleXLSXGen;



date_default_timezone_set('Asia/Kolkata'); // Set IST

// Get current time in 24-hour format
$now = date('H:i'); // e.g. "14:35"
//echo "Current IST Time (24-hour): $now<br>";


$yesterday_iso = date('Y-m-d', strtotime('-1 day')); // e.g. "2025-07-08"

// Convert to U.S. date format (m/d/Y)
$today = date('Y-m-d', strtotime($yesterday_iso)); // e.g. "07/08/2025"

//echo "Yesterday's Date in U.S. Format (Kolkata Time): $today";

//echo $us_format;


//$today ="2025-07-03";
$from = $today;
$to = $today;

$saveDir = '/srv/www/htdocs/Preq-new/downloads/reports/';
if (!is_dir($saveDir)) mkdir($saveDir, 0775, true);
if (!is_writable($saveDir)) die("❌ Save directory not writable: $saveDir\n");


$emailTo = 'senthil@preqservices.com,support@preqservices.com';
$reportType = 'dnc_report';

// 1. Scheduled time fetch
$stmt = $conn->prepare("SELECT value FROM app_info WHERE `key` = 'dnc_report'");
$stmt->execute();
$stmt->bind_result($scheduledTime);
$stmt->fetch();
$stmt->close();

echo "🕒 Now: $now IST | Scheduled: $scheduledTime IST\n";

// 2. Skip if already sent
$stmt = $conn->prepare("SELECT COUNT(*) FROM email_logs WHERE type = ? AND DATE(send_time) = ?");
$stmt->bind_param("ss", $reportType, $today);
$stmt->execute();
$stmt->bind_result($alreadySent);
$stmt->fetch();
$stmt->close();

if ($alreadySent > 0) {
    echo "⏩ DNC Report already sent today.\n";
    exit;
}

// 3. Proceed only if scheduled time reached
$scheduledTime1 = trim($scheduledTime);
$scheduledTime2 = trim($scheduledTime);


// Add 5 minutes to scheduledTime2
$scheduledTime2Plus5 = date("H:i", strtotime($scheduledTime2 . " +4 minutes"));

if ($now >= $scheduledTime1 && $now <= $scheduledTime2Plus5) {
    // 4. Fetch campaigns
    $stmt = $conn->prepare("SELECT value FROM app_info WHERE `key` = 'dnc_report_campaigns'");
    $stmt->execute();
    $stmt->bind_result($campaignStrRaw);
    $stmt->fetch();
    $stmt->close();

    if (empty($campaignStrRaw)) {
        echo "⚠️ No campaigns configured in app_info.\n";
        exit;
    }

    $campaigns = array_map('trim', explode(',', $campaignStrRaw));
    $attachedFiles = [];
    $logMessages = [];

    foreach ($campaigns as $camp) {
        $real_camps = ($camp === 'FTE_ALL') ? ['EDU_SB1', 'EDU_SB'] : [$camp];
        $datas = [];

        foreach ($real_camps as $org_camp) {
            $stmt = $conn->prepare("SELECT * FROM campaigns_details WHERE campaign_value = ? AND status = 'ACTIVE'");
            $stmt->bind_param("s", $org_camp);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows === 0) continue;
            $fr = $result->fetch_assoc();
            $stmt->close();

            $dbip = $fr['camp_ip'];
            $db_user = $fr['db_username'];
            $db_pass = $fr['db_password'];
            $db_name = $fr['db_database'];
            $servername = ($org_camp === 'EDU_SB1' && $from !== $today) ? "192.168.200.231" : $dbip;
            $table = ($from === $today) ? 'vicidial_agent_log' : 'vicidial_agent_log_archive';

              $query = "
            SELECT 
                $table.agent_log_id,
                $table.lead_id,
                vu.full_name AS user,
                $table.user AS agent,
                $table.campaign_id,
                $table.status,
                $table.comments,
                $table.event_time,
                rl.filename 
            FROM 
                $table 
            INNER JOIN recording_log rl ON $table.lead_id = rl.lead_id 
            INNER JOIN vicidial_users vu ON $table.user = vu.user 
            WHERE 
                $table.event_time BETWEEN '$from 00:00:00' AND '$to 23:59:59'
                AND $table.campaign_id = '$org_camp'
                AND $table.status = 'DNC'
            GROUP BY $table.agent_log_id
        ";

            $cmd = sprintf(
                "mysql -u%s -p%s -h%s -D%s -N -e %s",
                escapeshellarg($db_user),
                escapeshellarg($db_pass),
                escapeshellarg($servername),
                escapeshellarg($db_name),
                escapeshellarg($query)
            );

            $values = shell_exec($cmd);
            if (!empty($values)) {
                $lines = explode("\n", trim($values));
                foreach ($lines as $line) {
                    $fields = explode("\t", $line);
                    $filename_field = $fields[8] ?? '';
                    $mobileno_parts = explode("_", $filename_field);

                    $datas[] = [
                        $fields[7] ?? '',
                        $mobileno_parts[1] ?? '',
                        $fields[5] ?? ''
                    ];
                }
            }
        }

        if (!empty($datas)) {
            array_unshift($datas, ['Date and Time', 'Phone Number', 'Status']);
            $filename = "DNC_REPORT_{$camp}_{$from}_to_{$to}.xlsx";
            $filePath = $saveDir . $filename;

            SimpleXLSXGen::fromArray($datas)->saveAs($filePath);
            $attachedFiles[] = $filePath;
            $logMessages[] = "✅ $camp: Report generated";
        } else {
            $logMessages[] = "❌ $camp: No data found";
        }
    }

// 5. Send Email
if (!empty($attachedFiles)) {

    // ⏱ Start execution timer
    $startTime = microtime(true);

    $mail = new PHPMailer(true);
    try {
        $mail->isMail();
        $mail->setFrom('support@preqservices.com', 'DNC Report');
        foreach (explode(',', $emailTo) as $email) {
            $email = trim($email);
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $mail->addAddress($email);
            } else {
                echo "⚠️ Invalid email: $email\n";
            }
        }

        $logoPath = '/srv/www/htdocs/Preq-new/assets/images/Preq_new_logo.png';
        if (file_exists($logoPath)) {
            $mail->AddEmbeddedImage($logoPath, 'preqlogo');
        }

            // Original campaign codes
            $campaigns = ['SHOW1', 'SHOW2', 'SHOW3', 'SHOW5', 'SHOW6'];

            // Define readable names for campaign codes
            $campaign_name_map = [
                'SHOW1' => 'SHOW1',
                'SHOW2' => 'SHOW2_RENEWAL',
                'SHOW3' => 'SHOW3_REACTIVATION',
                'SHOW5' => 'SHOW_CANCEL',
                'SHOW6' => 'SHOW6_WARM FRESH'

            ];


            // Convert campaign codes to readable names
            $readable_campaigns = [];
            foreach ($campaigns as $code) {
                $readable_campaigns[] = $campaign_name_map[$code] ?? htmlspecialchars($code);
            }

            // Generate readable campaign string
            $campaign_count = count($readable_campaigns);
            if ($campaign_count > 1) {
                $last = array_pop($readable_campaigns);
                $campaign_string = implode(', ', $readable_campaigns) . ' AND ' . $last;
            } else {
                $campaign_string = implode(', ', $readable_campaigns);
            }

            // Format report date
            $report_date = date('jS F Y', strtotime($yesterday_iso)); // Static date or use date('jS F Y') for dynamic

            // Set email subject
            $mail->Subject = "DNC Report - {$campaign_string} ({$report_date})";

            // Set HTML email body
            $mail->isHTML(true);
            $mail->Body = '
            <p>Hi Senthil,</p>
            <br>
            <br>
            <p>I have attached the DNC report for show campaigns.</p>
            <br>
            <br>
            <p><strong>PFA</strong></p>
            <br>
            <br>
            <p><strong>Best Regards,</strong><br>
            <strong>Prakash R</strong><br>
            <strong>Sr. Dialer Engineer</strong><br>
            <strong>Pre&apos;Q Services</strong></p>
            <img src="cid:preqlogo" alt="PreQ Logo" width="90" height="70"><br>
            <a href="http://www.preqservices.com">www.preqservices.com</a>
            <hr style="margin-top: 30px;">
            <p style="font-size: 11px; color: #555;">
            <em>*The contents of this email and any attachments are confidential and intended solely for the recipient. If you are not the intended recipient, please notify the sender immediately and delete this email.*</em>
            </p>';

        // Attach files
        foreach ($attachedFiles as $file) {
            $mail->addAttachment($file);
        }

        // Send the email
        $mail->send();
        // Log success
        $nowFull = date('Y-m-d H:i:s');
        $campList = implode(',', $campaigns);
        $stmt = $conn->prepare("INSERT INTO email_logs (type, campaigns, send_time, recipients, status, created_at) VALUES (?, ?, ?, ?, 'Sent', ?)");
        $stmt->bind_param("sssss", $reportType, $campList, $today, $emailTo, $nowFull);
        $stmt->execute();
        $stmt->close();

        echo "✅ Email sent to: $emailTo\n";

    } catch (Exception $e) {
    $errorMessage = $mail->ErrorInfo;
    echo "❌ Email Error: $errorMessage\n";

    $nowFull = date('Y-m-d H:i:s');
    $campList = implode(',', $campaigns);

    // Log failure to email_logs
    $stmt = $conn->prepare("INSERT INTO email_logs (type, campaigns, send_time, recipients, status, error_message, created_at) VALUES (?, ?, ?, ?, 'Failed', ?, ?)");
    $stmt->bind_param("ssssss", $reportType, $campList, $today, $emailTo, $errorMessage, $nowFull);
    $stmt->execute();
    $stmt->close();

    // Optional: send alert email to admin
    try {
        $alert = new PHPMailer(true);
        $alert->isMail();
        $alert->setFrom('support@preqservices.com', 'DNC Report Error');
        $alert->addAddress('support@preqservices.com');
        $alert->addAddress('senthil@preqservices.com'); // Add additional recipient

        $alert->Subject = "❌ DNC Report Email Failed - {$report_date}";
        $alert->isHTML(true);
        $alert->Body = "
            <p><strong>DNC Report sending failed.</strong></p>
            <p><strong>Error:</strong> $errorMessage</p>
            <p><strong>Campaigns:</strong> $campList</p>
            <p><strong>Scheduled Time:</strong> $scheduledTime</p>
            <p><strong>Date:</strong> $report_date</p>
            <hr>
            <p><em>This is an automated alert from the DNC Report system.</em></p>
        ";
        $alert->send();
        echo "📧 Failure alert email sent to admin.\n";
    } catch (Exception $e2) {
        echo "⚠️ Failed to send failure alert email: " . $e2->getMessage() . "\n";
    }

    }
    // Delete files
    foreach ($attachedFiles as $file) {
        if (file_exists($file)) unlink($file);
    }

    // ⏱ End execution timer and print
    $endTime = microtime(true);
    $executionTime = round($endTime - $startTime, 2); // seconds with 2 decimals
    echo "⏱ Execution Time: {$executionTime} seconds\n";

} else {
    echo "⚠️ No data files to send.\n";
}

} else {
    echo "⏳ Waiting for scheduled time ($scheduledTime). Current time: $now\n";
    exit;
}
