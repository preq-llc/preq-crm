<!-- ========== App Menu ========== -->
<?php
// Include the database connection file
include('../config.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Check if user role is set in the session
if (!isset($_SESSION['role'])) {
    die("User role not set in session.");
}

$logged_in_user_role = $_SESSION['role']; // Fixed the syntax error here



// Fetch user role and permissions from the database
$query = "SELECT * FROM `nav_bar` WHERE `user_role` = '$logged_in_user_role'";
$queryresult = $conn->query($query);


// Check if user data was found
if (!$queryresult || $queryresult->num_rows == 0) {
    die("User not found.");
}

$user = $queryresult->fetch_assoc();

// Define variables from the fetched data
$dashboard = $user['dashboard'];
$live_status = $user['live_status'];
$buyer_report = $user['buyer_report'];
$dial_report = $user['dial_report'];
$data_check = $user['data_check'];
$lead_report = $user['lead_report'];
$qc = $user['qc'];
$qc_score = $user['qc_score'];
$agents_sc = $user['agents_sc'];
$admin_panel = $user['admin_panel'];
$voip_entry = $user['voip_entry'];
$billing = $user['billing'];
$phonesearch = $user['phonesearch'];

// Determine the active page
// $page = basename($_SERVER['PHP_SELF'], ".php");

?>

<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-dark.png" alt="" height="17">
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-light.png" alt="" height="17">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">

                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                        <?php if ($dashboard == 'yes') { ?>

                        <li class="nav-item">
                            <a class="nav-link menu-link <?php if($page == 'dashboard'){echo 'active';}?>" href="dashboard.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'dashboard'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarDashboards">
                                <i class="bx bxs-dashboard"></i> 
                                <span data-key="t-dashboards">Dashboards</span>
                            </a>
                        </li> <!-- end Dashboard Menu -->
                        <?php } ?>
                          <?php
                            if($lead_report == "yes")
                            {
                        ?>
                         <li class="nav-item">
                            <a class="nav-link menu-link <?php if($page == 'leadreport'){echo 'active';}?>" href="lead-report.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'leadreport'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarDashboards">
                                <i class='bx bx-stats'></i>
                                <span data-key="t-dashboards">Lead Report</span>
                            </a>
                        </li>


                        <?php } ?>

                        <?php
                            if($dial_report == "yes")
                            {
                        ?>
                         <li class="nav-item">
                            <a class="nav-link menu-link <?php if($page == 'dialreport'){echo 'active';}?>" href="extrashow.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'dialreport'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarDashboards">
                                <i class='bx bx-stats'></i>
                                <span data-key="t-dashboards">Dial Report</span>
                            </a>
                        </li>


                        <?php } ?>

                        <?php
                            if($live_status == "yes")
                            {
                        ?>
                            <li class="nav-item">
                                <a class="nav-link menu-link <?php if($page == 'livestats'){echo 'active';}?>" href="live-status.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'livestats'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarDashboards">
                                    <i class='bx bxs-phone-call'></i>
                                    <span data-key="t-dashboards">Live Status</span>
                                </a>
                            </li>
                            <?php } ?>
                            <?php
                            if($buyer_report == "yes")
                            {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link menu-link <?php if($page == 'buyerreport'){echo 'active';}?>" href="buyer-report.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'buyerreport'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarDashboards">
                                <i class='bx bx-stats'></i>
                                <span data-key="t-dashboards">Buyer Report</span>
                            </a>
                        </li>
                        <?php } ?>
                        
                        <?php
                            if($admin_panel == 'yes')
                            {
                        ?>
                            <!-- <li class="nav-item">
                                <a class="nav-link menu-link <?php if($page == 'billing'){echo 'active';}?>" href="billing.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'billing'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarBilling">
                                    <i class='bx bx-dollar'></i>
                                    <span data-key="t-dashboards">Billing</span>
                                </a>
                            </li> -->
                             <li class="nav-item">
                                <a class="nav-link menu-link <?php if($page == 'adminpanel'){echo 'active';}?>" href="admin-panel.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'adminpanel'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarBilling">
                                    <i class='bx bx-cog'></i>
                                    <span data-key="t-dashboards">Admin Panel</span>
                                </a>
                            </li> 
                            <?php }?>
                            <?php
                            if($data_check == 'yes')
                            {
                        ?>
                             <li class="nav-item">
                                <a class="nav-link menu-link <?php if($page == 'datacheck'){echo 'active';}?>" href="datacheck.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'datacheck'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarBilling">
                                    <i class='bx bx-cog'></i>
                                    <span data-key="t-dashboards">Data Check</span>
                                </a>
                            </li> 
                            <?php }?>
                            <?php
                            if($admin_panel == 'yes')
                            {
                        ?>
                             <li class="nav-item">
                                <a class="nav-link menu-link <?php if($page == 'report'){echo 'active';}?>" href="call-log-report.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'report'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarBilling">
                                    <i class='bx bx-box'></i>
                                    <span data-key="t-dashboards">Report</span>
                                </a>
                            </li> 
                            
                            <li class="nav-item">
                                <a class="nav-link menu-link <?php if($page == 'allcamphrs'){echo 'active';}?>" href="all_reports.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'allcamphrs'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarBilling">
                                    <i class='bx bx-box'></i>
                                    <span data-key="t-dashboards">All Report</span>
                                </a>
                            </li> 
                        
                            <li class="nav-item">
                                <a class="nav-link menu-link <?php if($page == 'allcamphrs'){echo 'active';}?>" href="allcamp-hrs.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'allcamphrs'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarBilling">
                                    <i class='bx bx-box'></i>
                                    <span data-key="t-dashboards">AllCamp Hrs</span>
                                </a>
                            </li> 

                            <?php }?>

                         <?php
                            if($qc == 'yes')
                            {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link menu-link <?php if($page == 'qcdetails' || $page == 'qcreport' || $page=='qc'){echo 'active';}?>" href="javascript:void(0);" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'qcdetails' || $page == 'qcreport'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarQc">
                                <i class='bx bxs-check-shield'></i>
                                <span data-key="t-dashboards">Qc</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarQc">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="iverich_qc_report.php" class="nav-link" data-key="t-analytics"> QC Reports </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="qc-details.php" class="nav-link" data-key="t-analytics"> QC Score Card Details </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="qc-report.php" class="nav-link" data-key="t-crm"> Agents SC / QC </a>
                                    </li>
                                </ul>
                            </div>
                        </li> 
                        <?php }?>
                        <?php
                            if($phonesearch == 'yes')
                            {
                        ?>
                        <li class="nav-item">
                                <a class="nav-link menu-link <?php if($page == 'phonesearch'){echo 'active';}?>" href="phonesearch.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'phonesearch'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarBilling">
                                    <i class='bx bxs-phone'></i>
                                    <span data-key="t-dashboards">PhoneSearch</span>
                                </a>
                            </li> 
                            <?php }?>
                        <!-- end Dashboard Menu -->
        <!--                 <li class="nav-item">
                                <a class="nav-link menu-link <?php if($page == 'setting'){echo 'active';}?>" href="" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'setting'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarvoip">
                                    <i class='bx bx-cog'></i>
                                    <span data-key="t-dashboards">Setting</span>
                                </a>

                                <div class="collapse menu-dropdown" id="sidebarvoip">
                                <ul class="nav nav-sm flex-column">
                                 <li class="nav-item">
                                        <a href="admin-panel.php" class="nav-link" data-key="t-analytics">Admin Panel</a>
                                    </li> 
                                    <li class="nav-item">
                                        <a href="voip-entry.php" class="nav-link" data-key="t-crm">Voip Details</a>
                                    </li>
                                <li class="nav-item">
                                        <a href="voip-paid.php" class="nav-link" data-key="t-crm">Voip Paid Details</a>
                                    </li>

                               <li class="nav-item">
                                        <a href="voip-usage.php" class="nav-link" data-key="t-crm">Voip Usage Details</a>
                                    </li>
                                </ul>
                            </div>
                            </li> -->

                             
                     <!--          <li class="nav-item">
                                    <a class="nav-link menu-link <?php if($page == 'qc'){echo 'active';}?>" href="iverich_qc_report.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'qc'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarDashboards">
                                        <i class="bx bxs-dashboard"></i> 
                                        <span data-key="t-dashboards">QC Reports</span>
                                    </a>
                                </li> end Dashboard Menu  -->
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>