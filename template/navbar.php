
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
                        <?php
                            if($logged_in_user_role != "clientadmin" && $logged_in_user_role != "qcagent")
                            {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link menu-link <?php if($page == 'dashboard'){echo 'active';}?>" href="dashboard.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'dashboard'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarDashboards">
                                <i class="bx bxs-dashboard"></i> 
                                <span data-key="t-dashboards">Dashboards</span>
                            </a>
                        </li> <!-- end Dashboard Menu -->
                    <?php } ?>
                          <?php
                            if($logged_in_user_role == "clients" )
                            {
                        ?>
                         <li class="nav-item">
                            <a class="nav-link menu-link <?php if($page == 'leadreport'){echo 'active';}?>" href="lead-report.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'leadreport'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarDashboards" target="_blank">
                                <i class='bx bx-stats'></i>
                                <span data-key="t-dashboards">Lead Report</span>
                            </a>
                        </li>


                        <?php } ?>

                        <?php
                            if($logged_in_user_name == "SHOW" || $logged_in_user_role == "superadmin" )
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
                            if($logged_in_user_role == "admin" || $logged_in_user_role == "superadmin" || $logged_in_user_role == "teamleader" || $logged_in_user_role == "support" || $logged_in_user_role == "sourceclients" || $logged_in_user_role == "clients" )
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
                            if($logged_in_user_role == "admin" || $logged_in_user_role == "superadmin" || $logged_in_user_role == "teamleader" || $logged_in_user_role == "support" || $logged_in_user_role == "sourceclients")
                            {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link menu-link <?php if($page == 'leadreport'){echo 'active';}?>" href="lead-report.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'leadreport'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarDashboards" target="_blank">
                                <i class='bx bx-stats'></i>
                                <span data-key="t-dashboards">Lead Report</span>
                            </a>
                        </li>
                      
                        
                        <?php } ?>
                        
                        <?php
                            if($logged_in_user_role == 'superadmin')
                            {
                        ?>
                            <!-- <li class="nav-item">
                                <a class="nav-link menu-link <?php if($page == 'billing'){echo 'active';}?>" href="billing.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'billing'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarBilling">
                                    <i class='bx bx-dollar'></i>
                                    <span data-key="t-dashboards">Billing</span>
                                </a>
                            </li> -->

                            <li class="nav-item">
                                <a class="nav-link menu-link <?php if($page == 'voipentry' || $page == 'voippaid' || $page=='voipusage' || $page=='voipreport' ){echo 'active';}?>" href="javascript:void(0);" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'voipentry' || $page == 'voippaid' || $page=='voipusage' || $page=='voipreport' ){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarvoip">
                                    <i class='bx bxs-check-shield'></i>
                                    <span data-key="t-dashboards">Voip</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarvoip">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="voip-entry.php" class="nav-link" data-key="t-analytics"> Voip Usage Entry </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="voip-usage.php" class="nav-link" data-key="t-analytics">Voip Report</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="voip-paid.php" class="nav-link" data-key="t-analytics">Voip Invoice Detail</a>
                                        </li>
                                        
                                        <li class="nav-item">
                                            <a href="voip-report.php" class="nav-link" data-key="t-crm">Campaign Voip Entry</a>
                                        </li>
                                            <li class="nav-item">
                                            <a href="headcount_report.php" class="nav-link" data-key="t-crm">HC Report</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                                <li class="nav-item">
                                <a class="nav-link menu-link <?php if($page == 'userpanel' || $page=='adminpanel' ){echo 'active';}?>" href="javascript:void(0);" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'userpanel' || $page == 'adminpanel'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarvoip">
                                    <i class='bx bx-circle-three-quarter'></i>
                                    <span data-key="t-dashboards">Panel</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarvoip">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="user-panel.php" class="nav-link" data-key="t-analytics">Campaign Panel </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="admin-panel.php" class="nav-link" data-key="t-analytics">Admin Panel</a>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link menu-link <?php if($page == 'userpanel'){echo 'active';}?>" href="" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'userpanel'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarBilling">
                                    <i class='bx bx-circle-three-quarter'></i>
                                    <span data-key="t-dashboards"></span>
                                </a>
                            </li> 
                             <li class="nav-item">
                                <a class="nav-link menu-link <?php if($page == 'adminpanel'){echo 'active';}?>" href="" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'adminpanel'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarBilling">
                                    <i class='bx bx-cog'></i>
                                    <span data-key="t-dashboards"></span>
                                </a>
                            </li>  -->

                             <li class="nav-item">
                                <a class="nav-link menu-link <?php if($page == 'datacheck'){echo 'active';}?>" href="datacheck.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'datacheck'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarBilling">
                                     <i class='bx bx-data'></i>
                                    <span data-key="t-dashboards">Data Check</span>
                                </a>
                            </li> 
                             <!-- <li class="nav-item">
                                <a class="nav-link menu-link <?php if($page == 'report'){echo 'active';}?>" href="call-log-report.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'report'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarBilling">
                                    <i class='bx bx-box'></i>
                                    <span data-key="t-dashboards">Report</span>
                                </a>
                            </li>  -->
                            <li class="nav-item">
                                <a class="nav-link menu-link <?php if($page == 'allcamphrs'){echo 'active';}?>" href="all_reports.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'allcamphrs'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarBilling">
                                    <i class='bx bx-file'></i>
                                    <span data-key="t-dashboards">Log Reports</span>
                                </a>
                            </li> 
                            <!-- <li class="nav-item">
                                <a class="nav-link menu-link <?php if($page == 'headcount_report'){echo 'active';}?>" href="headcount_report.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'headcount_report'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarBilling">
                                    <i class='bx bx-box'></i>
                                    <span data-key="t-dashboards">HC Report</span>
                                </a>
                            </li>  -->
                           
                            <li class="nav-item">
                                <a class="nav-link menu-link <?php if($page == 'allcamphrs'){echo 'active';}?>" href="allcamp-hrs.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'allcamphrs'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarBilling">
                                    <i class='bx bx-time-five'></i>
                                    <span data-key="t-dashboards">All Campaign Hours</span>
                                </a>
                            </li> 
                            <li class="nav-item">
                                <a class="nav-link menu-link <?php if($page == 'agentwisedispo'){echo 'active';}?>" href="agentwise_dispo.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'agentwisedispo'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarBilling">
                                 <i class='bx bx-user-voice'></i>
                                    <span data-key="t-dashboards">Agent Wise Disposition</span>
                                </a>
                            </li> 
                             <li class="nav-item">
                                <a class="nav-link menu-link <?php if($page == 'hoursreport'){echo 'active';}?>" href="hours_report.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'hoursreport'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarBilling">
                                     <i class='bx bx-bar-chart-alt-2'></i>
                                    <span data-key="t-dashboards">Hourly Dashboard</span>
                                </a>
                            </li> 

                            <?php }?>
                             <?php
                                    if($logged_in_user_role == 'superadmin'|| $logged_in_user_group == 'ZD15' || $logged_in_user_group == 'ZD14')
                                    {
                                ?>

                              <li class="nav-item">
                                <a class="nav-link menu-link <?php if($page == 'aiqareport'){echo 'active';}?>" href="ai_qa_report.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'aiqareport'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarBilling">
                                    <i class='bx bx-stats'></i>
                                    <span data-key="t-dashboards">Ai Qa Report</span>
                                </a>
                            </li> 
                            
                              <?php }?>

                            <?php
                            if($logged_in_user_name == 'PREQ')
                            {
                            ?>
<!--                            
                            <li class="nav-item">
                                <a class="nav-link menu-link <?php if($page == 'voipentry'){echo 'active';}?>" href="voip-entry.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'voipentry'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarBilling">
                                    <i class='bx bxs-dashboard'></i>
                                    <span data-key="t-dashboards">Voip Entry</span>
                                </a>
                            </li>

                             <li class="nav-item">
                                <a class="nav-link menu-link <?php if($page == 'voippaid'){echo 'active';}?>" href="voip-paid.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'voippaid'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarBilling">
                                    <i class='bx bxs-dashboard'></i>
                                    <span data-key="t-dashboards">Voip Paid</span>
                                </a>
                            </li>

                             <li class="nav-item">
                                <a class="nav-link menu-link <?php if($page == 'voipusage'){echo 'active';}?>" href="voip-usage.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'voipusage'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarBilling">
                                    <i class='bx bxs-dashboard'></i>
                                    <span data-key="t-dashboards">Voip Usage</span>
                                </a>
                            </li> 
                            <li class="nav-item">
                                <a class="nav-link menu-link <?php if($page == 'voipreport'){echo 'active';}?>" href="voip-report.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'voipusage'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarBilling">
                                    <i class='bx bxs-dashboard'></i>
                                    <span data-key="t-dashboards">Voip Report</span>
                                </a>
                            </li>  -->
                             <!-- <li class="nav-item">
                                <a class="nav-link menu-link <?php if($page == 'agentwisedispo'){echo 'active';}?>" href="agentwise_dispo.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'agentwisedispo'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarBilling">
                                    <i class='bx bx-box'></i>
                                    <span data-key="t-dashboards">Agent Wise Dispo</span>
                                </a>
                            </li> 
                             <li class="nav-item">
                                <a class="nav-link menu-link <?php if($page == 'hoursreport'){echo 'active';}?>" href="hours_report.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'hoursreport'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarBilling">
                                    <i class='bx bx-box'></i>
                                    <span data-key="t-dashboards">Hours Report</span>
                                </a> -->
                            </li> 
                        <?php }?>
                      

                         <?php
                            if($logged_in_user_role == 'support' || $logged_in_user_role == "superadmin")
                            {
                        ?>
                         <li class="nav-item">
                            <a class="nav-link menu-link <?php if($page == 'qcdetails' || $page == 'qcreport'){echo 'active';}?>" href="javascript:void(0);" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'qcdetails' || $page == 'qcreport'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarQc">
                                <i class='bx bxs-check-shield'></i>
                                <span data-key="t-dashboards">Qc</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarQc">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="qc-details.php" class="nav-link" data-key="t-analytics"> QC Score Card Details </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="qc-report.php" class="nav-link" data-key="t-crm"> Agents SC / QC </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="qc-camp-details.php" class="nav-link" data-key="t-crm"> Campaign QC Details </a>
                                    </li>
                                </ul>
                                <?php
                                    if($logged_in_user_role == 'support' || $logged_in_user_role == 'superadmin' || $logged_in_user_group == 'ZD15' || $logged_in_user_group == 'ZD28' || $logged_in_user_group == 'ZD23' || $logged_in_user_group == 'ZD24')
                                    {
                                ?>
                                <ul class="nav nav-sm flex-column">
                                <!-- <li class="nav-item">
                                        <a href="qc-details-real.php" class="nav-link text-success" data-key="t-analytics"> QC Score Card Details</a>
                                    </li> -->
                                    <!-- <li class="nav-item">
                                        <a href="qc-report-real.php" class="nav-link  text-success" data-key="t-crm"> Agents SC / QC </a>
                                    </li> -->
                                    <!-- <li class="nav-item">
                                        <a href="qc-camp-details-real.php" class="nav-link text-success" data-key="t-crm"> Campaign QC Details </a>
                                    </li> -->
                                </ul>
                                <?php
                                    }
                                ?>
                            </div>
                        </li> <!-- end Dashboard Menu -->

                        <li class="nav-item">
                                <a class="nav-link menu-link <?php if($page == 'phonesearch'){echo 'active';}?>" href="phonesearch_v2.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'phonesearch'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarBilling">
                                    <i class='bx bxs-phone'></i>
                                    <span data-key="t-dashboards">PhoneSearch</span>
                                </a>
                            </li> 
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

                               <?php }?>
                     <!--          <li class="nav-item">
                                    <a class="nav-link menu-link <?php if($page == 'qc'){echo 'active';}?>" href="iverich_qc_report.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'qc'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarDashboards">
                                        <i class="bx bxs-dashboard"></i> 
                                        <span data-key="t-dashboards">QC Reports</span>
                                    </a>
                                </li> end Dashboard Menu  -->

                                <?php 
                                    if($logged_in_user_role == "clientadmin")
                                    {
                                        ?>

                                        <li class="nav-item">
                                            <a class="nav-link menu-link <?php if($page == 'dashboard'){echo 'active';}?>" href="pspmdashboard.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'dashboard'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarDashboards">
                                                <i class="bx bxs-dashboard"></i> 
                                                <span data-key="t-dashboards">Dashboards</span>
                                            </a>
                                        </li>

                                          <li class="nav-item">
                                            <a class="nav-link menu-link <?php if($page == 'zeafana'){echo 'active';}?>" href="Zeafana/index.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'zeafana'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarDashboards" target="_blank">
                                                <i class="bx bxs-dashboard"></i> 
                                                <span data-key="t-dashboards">Live Monitor </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link <?php if($page == 'livestats'){echo 'active';}?>" href="live-status.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'livestats'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarDashboards">
                                                <i class='bx bxs-phone-call'></i>
                                                <span data-key="t-dashboards">Live Status</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link <?php if($page == 'leadreport'){echo 'active';}?>" href="lead-report.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'leadreport'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarDashboards" target="_blank">
                                                <i class='bx bx-stats'></i>
                                                <span data-key="t-dashboards">Lead Report</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link <?php if($page == 'dialreport'){echo 'active';}?>" href="extrashow.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'dialreport'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarDashboards">
                                                <i class='bx bx-stats'></i>
                                                <span data-key="t-dashboards">Data Performance Report</span>
                                            </a>
                                        </li>
                                          <li class="nav-item">
                                                <a class="nav-link menu-link <?php if($page == 'userpanel'){echo 'active';}?>" href="user-panel.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'userpanel'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarBilling">
                                                    <i class='bx bx-circle-three-quarter'></i>
                                                    <span data-key="t-dashboards">Campaign Panel</span>
                                                </a>
                                            </li> 
                                          <!--   <li class="nav-item">
                                                <a class="nav-link menu-link <?php if($page == 'phonesearch'){echo 'active';}?>" href="phonesearch_v2.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'phonesearch'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarBilling">
                                                    <i class='bx bxs-phone'></i>
                                                    <span data-key="t-dashboards">Phone Number Search</span>
                                                </a>
                                             </li>  -->

                             <li class="nav-item">
                            <a class="nav-link menu-link <?php if($page == 'qcdetails' || $page == 'qcreport'){echo 'active';}?>" href="javascript:void(0);" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'qcdetails' || $page == 'qcreport'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarQc">
                                <i class='bx bxs-check-shield'></i>
                                <span data-key="t-dashboards">Qc</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarQc">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="qc-details.php" class="nav-link" data-key="t-analytics"> QC Score Card Details </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="qc-report.php" class="nav-link" data-key="t-crm"> Agents SC / QC </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="qc-camp-details.php" class="nav-link" data-key="t-crm"> Campaign QC Details </a>
                                    </li>
                                </ul>
                                <?php
                                    if($logged_in_user_role == 'support' || $logged_in_user_role == 'superadmin')
                                    {
                                ?>
                                <ul class="nav nav-sm flex-column">
                                <<!-- li class="nav-item">
                                        <a href="qc-details-real.php" class="nav-link text-success" data-key="t-analytics"> QC Score Card Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="qc-report-real.php" class="nav-link  text-success" data-key="t-crm"> Agents SC / QC </a>
                                    </li> -->
                                    <!-- <li class="nav-item">
                                        <a href="qc-camp-details-real.php" class="nav-link text-success" data-key="t-crm"> Campaign QC Details </a>
                                    </li> -->
                                </ul>
                                <?php
                                    }
                                ?>
                            </div>
                        </li> <!-- end Dashboard Menu -->



                                              <li class="nav-item">
                                                <a class="nav-link menu-link <?php if($page == 'allcamphrs'){echo 'active';}?>" href="all_reports.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'allcamphrs'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarBilling">
                                                    <i class='bx bx-box'></i>
                                                    <span data-key="t-dashboards">Log Reports</span>
                                                </a>
                                            </li> 
                                             <li class="nav-item">
                                                <a class="nav-link menu-link <?php if($page == 'allcamphrs'){echo 'active';}?>" href="allcamp-hrs.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'allcamphrs'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarBilling">
                                                    <i class='bx bx-box'></i>
                                                    <span data-key="t-dashboards">All Campaign Hours</span>
                                                </a>
                                            </li> 

                                        <?php
                                    }
                                ?>
                                    <?php 
                                        if($logged_in_user_role == "teamleader")
                                            
                                        {

                                    ?>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link <?php if($page == 'phonesearch'){echo 'active';}?>" href="phonesearch.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'phonesearch'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarBilling">
                                                <i class='bx bxs-phone'></i>
                                                <span data-key="t-dashboards">PhoneSearch</span>
                                            </a>
                                        </li> 

                                <?php
                                    }

                                ?>

                                 <?php 
                                        if($logged_in_user_role == "qcagent")
                                            
                                        {

                                    ?>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link <?php if($page == 'qcleaddetails'){echo 'active';}?>" href="qc-lead-details.php" data-bs-toggle="" role="button" aria-expanded="<?php if($page == 'qcleaddetails'){echo 'true';}else{echo 'false';}?>" aria-controls="sidebarBilling">
                                                <i class='bx bxs-phone'></i>
                                                <span data-key="t-dashboards">Qc Lead Details</span>
                                            </a>
                                        </li> 

                                <?php
                                    }
                                ?>
 



                        

                    </ul>
                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>