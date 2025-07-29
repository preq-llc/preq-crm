<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO SECTION -->
    <div class="navbar-brand-box">
        <a href="index.html" class="logo logo-dark">
            <span class="logo-sm">
                <img src="assets/images/logo-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="assets/images/logo-dark.png" alt="" height="17">
            </span>
        </a>
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
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>

                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link menu-link <?= $page == 'dashboard' ? 'active' : '' ?>" href="dashboard.php">
                        <i class="bx bxs-dashboard"></i>
                        <span>Dashboards</span>
                    </a>
                </li>

                <!-- Live Status -->
                <?php if (in_array($logged_in_user_role, ['admin', 'superadmin', 'teamleader', 'support', 'sourceclients'])): ?>
                    <li class="nav-item">
                        <a class="nav-link menu-link <?= $page == 'livestats' ? 'active' : '' ?>" href="live-status.php">
                            <i class='bx bxs-phone-call'></i>
                            <span>Live Status</span>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Campaign Setting -->
                <?php if ($logged_in_user_role == 'superadmin'): ?>
                    <li class="nav-item">
                        <a class="nav-link menu-link <?= $page == 'userpanel' ? 'active' : '' ?>" href="user-panel.php">
                            <i class='bx bx-circle-three-quarter'></i>
                            <span>Campaign Setting</span>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Reports -->
                <?php if (in_array($logged_in_user_role, ['clients', 'admin', 'superadmin', 'teamleader', 'support', 'sourceclients'])): ?>
                    <li class="nav-item">
                        <a class="nav-link menu-link <?= in_array($page, ['leadreport', 'buyerreport', 'allcamphrs', 'dialreport']) ? 'active' : '' ?>" href="javascript:void(0);" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarReport">
                            <i class='bx bx-bar-chart-alt-2'></i>
                            <span>Reports</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarReport">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="lead-report.php" class="nav-link">Lead Report</a>
                                </li>
                                <?php if (in_array($logged_in_user_role, ['admin', 'superadmin', 'teamleader', 'support', 'sourceclients'])): ?>
                                    <li class="nav-item">
                                        <li class="nav-item">
                                        <a href="all_reports.php" class="nav-link">All Report</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="allcamp-hrs.php" class="nav-link">AllCamp Hrs</a>
                                    </li>
                                        <a href="buyer-report.php" class="nav-link">Buyer Report</a>
                                    </li>
                                    
                                    <?php if ($logged_in_user_name == 'SHOW' || $logged_in_user_role == 'superadmin'): ?>
                                        <li class="nav-item">
                                            <a href="extrashow.php" class="nav-link">Dial Report</a>
                                        </li>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <!-- QC Section -->
                <?php if (in_array($logged_in_user_role, ['superadmin', 'teamleader', 'support'])): ?>
                    <li class="nav-item">
                        <a class="nav-link menu-link <?= in_array($page, ['qcdetails', 'qcreport', 'qc']) ? 'active' : '' ?>" href="javascript:void(0);" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarQc">
                            <i class='bx bxs-check-shield'></i>
                            <span>QC</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarQc">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="iverich_qc_report.php" class="nav-link">QC Reports</a>
                                </li>
                                <li class="nav-item">
                                    <a href="qc-details.php" class="nav-link">QC Score Card Details</a>
                                </li>
                                <li class="nav-item">
                                    <a href="qc-report.php" class="nav-link">Agents SC / QC</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link <?= $page == 'phonesearch' ? 'active' : '' ?>" href="phonesearch.php">
                            <i class='bx bxs-phone'></i>
                            <span>PhoneSearch</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link <?= $page == 'adminpanel' ? 'active' : '' ?>" href="admin-panel.php">
                            <i class='bx bx-cog'></i>
                            <span>Admin Panel</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link <?= $page == 'datacheck' ? 'active' : '' ?>" href="datacheck.php">
                            <i class='bx bx-box'></i>
                            <span>Data Check</span>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- VoIP Section -->
                <?php if ($logged_in_user_name == 'PREQ'): ?>
                    <li class="nav-item">
                        <a class="nav-link menu-link <?= in_array($page, ['voipentry', 'voippaid', 'voipusage', 'voipreport']) ? 'active' : '' ?>" href="javascript:void(0);" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarVoip">
                            <i class='bx bxs-phone-call'></i>
                            <span>VoIP</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarVoip">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="voip-entry.php" class="nav-link">VoIP Entry</a>
                                </li>
                                <li class="nav-item">
                                    <a href="voip-paid.php" class="nav-link">VoIP Paid</a>
                                </li>
                                <li class="nav-item">
                                    <a href="voip-usage.php" class="nav-link">VoIP Usage</a>
                                </li>
                                <li class="nav-item">
                                    <a href="voip-report.php" class="nav-link">VoIP Report</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
    <div class="sidebar-background"></div>
</div>
