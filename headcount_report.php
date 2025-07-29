<?php
$page = 'headcount_report';
include('config.php');
include('function/session.php');

?>
<input type="text" id="current_username" value="<?php echo $logged_in_user_name; ?>" hidden>
<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">


<head>

    <meta charset="utf-8" />
    <title>Voip Head Count | Zealous - Dialer CRM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Dialer CRM" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- jsvectormap css -->
    <link href="assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css"/> -->
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> -->
    <link rel="stylesheet" href="assets/css/toastr.min.css">


    <!-- html2canvas library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- jsPDF library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.js" integrity="sha512-Bw9Zj8x4giJb3OmlMiMaGbNrFr0ERD2f9jL3en5FmcTXLhkI+fKyXVeyGyxKMIl1RfgcCBDprJJt4JvlglEb3A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

</head>
<style>
    .counter-value {
        font-size: 30px;
    }

    .bg-primary {
        --vz-bg-opacity: 1;
        background-color: rgb(190 161 106) !important
    }

    .fw-bold {
        font-weight: bolder;
        font-size: large;
    }

    h5 {
        color: #ffffff !important;
    }

    .mb-3 {
        margin-bottom: 0 !important;
    }
</style>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php include('template/header.php'); ?>

        <!-- removeNotificationModal -->
        <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mt-2 text-center">
                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                            <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                <h4>Are you sure ?</h4>
                                <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                            </div>
                        </div>
                        <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                            <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
                        </div>
                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <?php include('template/navbar.php'); ?>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->

        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    <!-- <div class="col-lg-12 text-center my-4">
                        <span class="alert alert-warning w-100">This Page Under Construction!</span>
                    </div> -->

                    <div class="row">
                        <div class="col">

                            <div class="h-100">
                                <div class="row mb-3 pb-1">
                                    <div class="col-12">


                                        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                            <div class="flex-grow-1">
                                                <!-- Place this where you want the dropdown -->
                                            </div>
                                        </div><!-- end card header -->

                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->

                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="d-flex flex-column h-100">
                                            <div class="row" id="leadReportResult">

                                            </div><!--end row-->
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end .h-100-->
                        </div> <!-- end col -->

                        <div class="row ">

                            <!-- Report Type Selector -->
                            <div class="d-flex justify-content-end mb-3">
                                <select id="reportSelect" class="form-control w-auto">
                                    <option value="">-- Select Report --</option>
                                    <option value="hours">Hours Report</option>
                                    <option value="headcount">Head Count Report</option>
                                </select>
                            </div>
                            <div id="headcount_report_container" class="row" style="display: none;">
                                <h4>Head Count Report</h4>

                                <div class="row w-100"> <!-- Wrap all three columns in a single row -->

                                    <!-- Date Wise VoIP Details -->
                                    <div id="headcount_datewise_container" class="col-xl-4 mb-4">
                                        <div class="card border border-primary">
                                            <div class="p-2 px-3 mb-3 rounded-2" style="background: linear-gradient(to right, #38454a, #5a6b72); color: white;">
                                                <h5 class="mb-0">DATE WISE VOIP DETAILS</h5>
                                                <div class="d-flex justify-content-end">
                                                    <img src="assets/images/downloadicon.png" style="height: 30px; width: 40px;margin-top:-20px" id="datewise_excel" />
                                                </div>
                                            </div>
                                            <div class="card-header bg-primary text-white text-center">
                                                <input type="date" id="voipDatePicker" class="form-control form-control-sm w-auto mx-auto mt-2" style="background-color: white; color: black; border: none;" />
                                            </div>
                                            <div class="card-body p-2">
                                                <div class="card text-white mb-3" style="background-color: #38454a; border-radius: 0.5rem;">
                                                    <div class="card-body d-flex justify-content-between px-2">
                                                        <div class="text-center">
                                                            <strong class="text-info">Total Voip Usage </strong><br />
                                                            <span data-field="todays_usage" class="text-white fw-bold">$0.00</span>
                                                        </div>
                                                        <div class="text-center">
                                                            <strong class="text-info">Total Head Count</strong><br />
                                                            <span data-field="total_headcount" class="text-white fw-bold">0</span>
                                                        </div>
                                                        <div class="text-center">
                                                            <strong class="text-info">Average Cost</strong><br />
                                                            <span class="text-warning fw-bold" data-field="average_cost">$0.00</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <table class="table table-bordered table-sm text-center" id="date_wisevoip_table">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Campaign</th>
                                                            <th>Head Count</th>
                                                            <th>Total VOIP</th>
                                                            <th>Average</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="voip_summary_table_body">
                                                        <tr>
                                                            <td colspan="4">No data</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Campaign Wise VoIP Details -->
                                    <div id="headcount_campaignwise_container" class="col-xl-4 mb-4">
                                        <div class="p-2 px-3 mb-3 rounded-2" style="background: linear-gradient(to right, #38454a, #5a6b72); color: white;">
                                            <h5 class="mb-0">CAMPAIGN WISE VOIP DETAILS</h5>
                                            <div class="d-flex justify-content-end">
                                                <img src="assets/images/downloadicon.png" style="height: 30px; width: 40px;margin-top:-20px" id="campaignwise_excel" />
                                            </div>
                                        </div>
                                        <div class="card border border-primary">
                                            <div class="card-header bg-primary text-white text-center">
                                                <div class="d-flex justify-content-center align-items-center gap-2 mt-2">
                                                    <select id="campaignDropdown" class="form-select w-auto">
                                                        <option value="aaa">--Choose Campaign--</option>
                                                    </select>
                                                    <div class="form-check d-flex align-items-center">
                                                        <input type="checkbox" id="statusToggle" class="form-check-input" style="transform: scale(1.5);" checked />
                                                        <label class="form-check-label ms-2" for="statusToggle" style="color: #ffffff;">Active</label>
                                                    </div>
                                                    <div>
                                                        <select id="monthDropdown" class="form-select form-select-sm" style="width: auto; display: inline-block;"></select>
                                                        <select id="yearDropdown" class="form-select form-select-sm" style="width: auto; display: inline-block;"></select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body p-2">
                                                <div class="card text-white mb-3" style="background-color: #38454a; border-radius: 0.5rem;">
                                                    <div class="card-body d-flex justify-content-between px-2">
                                                        <div class="text-center">
                                                            <strong class="text-info">Total Voip Usage</strong><br />
                                                            <span class="text-white fw-bold" id="currentUsage">$0.00</span>
                                                        </div>
                                                        <div class="text-center">
                                                            <strong class="text-info">Total Head Count</strong><br />
                                                            <span class="text-white fw-bold" id="total_headcount_campaign">0</span>
                                                        </div>
                                                        <div class="text-center">
                                                            <strong class="text-info">Average Cost</strong><br />
                                                            <span id="averageCost" class="text-warning fw-bold">$0.00</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <table class="table table-bordered table-sm mt-3 text-center" id="campaignwise_table">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Day</th>
                                                            <th>Head Count</th>
                                                            <th>Total VOIP</th>
                                                            <th>Average</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="voipSummaryBody">
                                                        <tr>
                                                            <td colspan="5">Select campaign and date to load data</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Monthly Wise VoIP Details -->
                                    <div id="headcount_monthlywise_container" class="col-xl-4 mb-4">
                                        <div class="p-2 px-3 mb-3 rounded-2" style="background: linear-gradient(to right, #38454a, #5a6b72); color: white;">
                                            <h5 class="mb-0">MONTHLY WISE VOIP DETAILS</h5>
                                            <div class="d-flex justify-content-end">
                                                <img src="assets/images/downloadicon.png" style="height: 30px; width: 40px;margin-top:-20px" id="monthlywise_excel" />
                                            </div>
                                        </div>
                                        <div class="card border border-primary">
                                            <div class="card-header bg-primary text-white text-center">
                                                <div>
                                                    <select id="monthDropdownmonthly" class="form-select form-select-sm" style="width: auto; display: inline-block;"></select>
                                                    <select id="yearDropdownmonthly" class="form-select form-select-sm" style="width: auto; display: inline-block;"></select>
                                                </div>
                                            </div>
                                            <div class="card-body p-2">
                                                <div class="card text-white mb-3" style="background-color: #38454a; border-radius: 0.5rem;">
                                                    <div class="card-body d-flex justify-content-between px-2">
                                                        <div class="text-center">
                                                            <strong class="text-info">Total Voip Usage</strong><br />
                                                            <span class="text-white fw-bold text-center" id="currentUsagemonthly">$0.00</span>
                                                        </div>
                                                        <div class="text-center">
                                                            <strong class="text-info">Total Head Count</strong><br />
                                                            <span class="text-white fw-bold text-center" id="total_headcount_monthly">0</span>
                                                        </div>
                                                        <div class="text-center">
                                                            <strong class="text-info">Average Cost</strong><br />
                                                            <span id="averageCostmonthly" class="text-warning fw-bold">$0.00</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <table class="table table-bordered table-sm mt-3 text-center" id="monthlywise_table">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Campaign</th>
                                                            <th>Head Count</th>
                                                            <th>VOIP</th>
                                                            <th>Avg. VOIP</th>
                                                            <th>%</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="voipSummaryBodymonthly">
                                                        <tr>
                                                            <td colspan="5">Select month and year to load data</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div> <!-- end row -->
                            </div>

                            <div id="hours_report_container" class="row" style="display: none;">
                                <h4>Hours Report</h4>

                                <div class="row w-100">
                                    <!-- Date Wise -->
                                    <div id="hours_datewise_container" class="col-xl-4 mb-4">
                                        <div class="card border border-primary">
                                            <div class="p-2 px-3 mb-3 rounded-2" style="background: linear-gradient(to right, #38454a, #5a6b72); color: white;">
                                                <h5 class="mb-0">DATE WISE VOIP DETAILS</h5>
                                                <div class="d-flex justify-content-end">
                                                    <img src="assets/images/downloadicon.png" style="height: 30px; width: 40px; margin-top: -20px;" id="datewise_excel_hours" />
                                                </div>
                                            </div>
                                            <div class="card-header bg-primary text-white text-center">
                                                <input type="date" id="voipDatePicker_hours" class="form-control form-control-sm w-auto mx-auto mt-2"
                                                    style="background-color: white; color: black; border: none;" />
                                            </div>
                                            <div class="card-body p-2">
                                                <div class="card text-white mb-3" style="background-color: #38454a; border-radius: 0.5rem;">
                                                    <div class="card-body d-flex justify-content-between px-2">
                                                        <div class="text-center">
                                                            <strong class="text-info">Total Voip Usage</strong><br>
                                                            <span data-field="todays_usage_hours" class="text-white fw-bold">$0.00</span>
                                                        </div>
                                                        <div class="text-center">
                                                            <strong class="text-info">Total Hours Count</strong><br>
                                                            <span data-field="total_hourscount_hours" class="text-white fw-bold">$0.00</span>
                                                        </div>
                                                        <div class="text-center">
                                                            <strong class="text-info">Average Cost</strong><br>
                                                            <span class="text-warning fw-bold" data-field="average_cost_hours">$0.00</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <table class="table table-bordered table-sm text-center" id="date_wisevoip_table_hours">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Campaign</th>
                                                            <th>Total Hours</th>
                                                            <th>Total VOIP</th>
                                                            <th>Average</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="voip_summary_table_body_hours">
                                                        <tr>
                                                            <td colspan="4">No data</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Campaign Wise -->
                                    <div id="hours_campaignwise_container" class="col-xl-4 mb-4">
                                        <div class="p-2 px-3 mb-3 rounded-2" style="background: linear-gradient(to right, #38454a, #5a6b72); color: white;">
                                            <h5 class="mb-0">CAMPAIGN WISE VOIP DETAILS</h5>
                                            <div class="d-flex justify-content-end">
                                                <img src="assets/images/downloadicon.png" style="height: 30px; width: 40px; margin-top: -20px;" id="campaignwise_excel_hours" />
                                            </div>
                                        </div>
                                        <div class="card border border-primary">
                                            <div class="card-header bg-primary text-white text-center">
                                                <div class="d-flex justify-content-center align-items-center gap-2 mt-2">
                                                    <select id="campaignDropdown_hours" class="form-select w-auto">
                                                        <option value="aaa">--Choose Campaign--</option>
                                                    </select>

                                                    <div class="form-check d-flex align-items-center">
                                                        <input type="checkbox" id="statusToggle_hours" class="form-check-input" style="transform: scale(1.5);" checked />
                                                        <label class="form-check-label ms-2" for="statusToggle_hours" style="color: #ffffff;">Active</label>
                                                    </div>

                                                    <div>
                                                        <select id="monthDropdown_hours" class="form-select form-select-sm" style="width: auto; display: inline-block;"></select>
                                                        <select id="yearDropdown_hours" class="form-select form-select-sm" style="width: auto; display: inline-block;"></select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body p-2">
                                                <div class="card text-white mb-3" style="background-color: #38454a; border-radius: 0.5rem;">
                                                    <div class="card-body d-flex justify-content-between px-2">
                                                        <div class="text-center">
                                                            <strong class="text-info">Total Voip Usage</strong><br>
                                                            <span class="text-white fw-bold" id="currentUsage_hours">$0.00</span>
                                                        </div>
                                                        <div class="text-center">
                                                            <strong class="text-info">Total Hours Count</strong><br>
                                                            <span class="text-white fw-bold" id="total_hourscount_campaign_hours">$0.00</span>
                                                        </div>
                                                        <div class="text-center">
                                                            <strong class="text-info">Average Cost</strong><br>
                                                            <span id="averageCost_hours" class="text-warning fw-bold">$0.00</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <table class="table table-bordered table-sm mt-3 text-center" id="campaignwise_table_hours">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Day</th>
                                                            <th>Total Hours</th>
                                                            <th>Total VOIP</th>
                                                            <th>Average</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="voipSummaryBody_hours">
                                                        <tr>
                                                            <td colspan="5">Select campaign and date to load data</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Monthly Wise -->
                                    <div id="hours_monthlywise_container" class="col-xl-4 mb-4">
                                        <div class="p-2 px-3 mb-3 rounded-2" style="background: linear-gradient(to right, #38454a, #5a6b72); color: white;">
                                            <h5 class="mb-0">MONTHLY WISE VOIP DETAILS</h5>
                                            <div class="d-flex justify-content-end">
                                                <img src="assets/images/downloadicon.png" style="height: 30px; width: 40px; margin-top: -20px;" id="monthlywise_excel_hours" />
                                            </div>
                                        </div>
                                        <div class="card border border-primary">
                                            <div class="card-header bg-primary text-white text-center">
                                                <div>
                                                    <select id="monthDropdownmonthly_hours" class="form-select form-select-sm" style="width: auto; display: inline-block;"></select>
                                                    <select id="yearDropdownmonthly_hours" class="form-select form-select-sm" style="width: auto; display: inline-block;"></select>
                                                </div>
                                            </div>
                                            <div class="card-body p-2">
                                                <div class="card text-white mb-3" style="background-color: #38454a; border-radius: 0.5rem;">
                                                    <div class="card-body d-flex justify-content-between px-2">
                                                        <div class="text-center">
                                                            <strong class="text-info">Total Voip Usage</strong><br>
                                                            <span class="text-white fw-bold text-center" id="currentUsagemonthly_hours">$0.00</span>
                                                        </div>
                                                        <div class="text-center">
                                                            <strong class="text-info">Total Hours Count</strong><br>
                                                            <span class="text-white fw-bold text-center" id="total_hourscount_monthly_hours">$0.00</span>
                                                        </div>
                                                        <div class="text-center">
                                                            <strong class="text-info">Average Cost</strong><br>
                                                            <span id="averageCostmonthly_hours" class="text-warning fw-bold">$0.00</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <table class="table table-bordered table-sm mt-3 text-center" id="monthlywise_table_hours">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Campaign</th>
                                                            <th>Total Hours</th>
                                                            <th>VOIP</th>
                                                            <th>Avg. VOIP</th>
                                                            <th>%</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="voipSummaryBodymonthly_hours">
                                                        <tr>
                                                            <td colspan="5">Select month and year to load data</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- container-fluid -->
            </div>



            <?php include('template/footer.php'); ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <!-- <div class="customizer-setting d-none d-md-block">
        <div class="btn-info rounded-pill shadow-lg btn btn-icon btn-lg p-2" data-bs-toggle="offcanvas" data-bs-target="#theme-settings-offcanvas" aria-controls="theme-settings-offcanvas">
            <i class='mdi mdi-spin mdi-cog-outline fs-22'></i>
        </div>
    </div> -->

    <!-- JAVASCRIPT -->
    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="assets/js/plugins.js"></script>

    <!-- apexcharts -->
    <script src="assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- Vector map-->
    <script src="assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
    <script src="assets/libs/jsvectormap/maps/world-merc.js"></script>

    <!--Swiper slider js-->
    <script src="assets/libs/swiper/swiper-bundle.min.js"></script>

    <!-- Live Status init -->
    <script src="assets/js/pages/Live Status-ecommerce.init.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script> -->
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script> -->
    <script src="assets/js/xlsx.full.min.js"></script>
    <script src="assets/js/toastr.min.js"></script>
    <script src="assets/js/autologout.js"></script>







    <script>
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"

        }
    </script>

    <script>
        // On page load, show headcount and hide hours
        window.addEventListener('DOMContentLoaded', () => {
            document.getElementById("headcount_report_container").style.display = "block";
            document.getElementById("hours_report_container").style.display = "none";
        });

        document.getElementById("reportSelect").addEventListener("change", function() {
            const selected = this.value;
            const hoursContainer = document.getElementById("hours_report_container");
            const headcountContainer = document.getElementById("headcount_report_container");

            if (selected === "hours") {
                hoursContainer.style.display = "block";
                headcountContainer.style.display = "none";
            } else if (selected === "headcount") {
                hoursContainer.style.display = "none";
                headcountContainer.style.display = "block";
            } else {
                hoursContainer.style.display = "none";
                headcountContainer.style.display = "none";
            }
        });

        // Populate dropdowns on page load
        populateMonthYearDropdown_Main();
        populateMonthYearDropdown_Secondary();
        monthwisefetchVoipSummary();
        // Campaign-wise Dropdowns Initialization
        function populateMonthYearDropdown_Main() {
            const monthDropdown = document.getElementById('monthDropdown');
            const yearDropdown = document.getElementById('yearDropdown');
            const now = new Date();
            const currentMonth = now.getMonth();
            const currentYear = now.getFullYear();
            const months = [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];

            if (monthDropdown) {
                monthDropdown.innerHTML = "";
                months.forEach((month, index) => {
                    const option = document.createElement("option");
                    option.value = String(index + 1).padStart(2, '0');
                    option.text = month;
                    if (index === currentMonth) option.selected = true;
                    monthDropdown.appendChild(option);
                });
            }

            if (yearDropdown) {
                yearDropdown.innerHTML = "";
                for (let y = currentYear - 5; y <= currentYear + 5; y++) {
                    const option = document.createElement("option");
                    option.value = y;
                    option.text = y;
                    if (y === currentYear) option.selected = true;
                    yearDropdown.appendChild(option);
                }
            }
        }

        // Month-wise Dropdowns Initialization
        function populateMonthYearDropdown_Secondary() {
            const monthDropdown = document.getElementById('monthDropdownmonthly');
            const yearDropdown = document.getElementById('yearDropdownmonthly');
            const now = new Date();
            const currentMonth = now.getMonth();
            const currentYear = now.getFullYear();
            const months = [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];

            if (monthDropdown) {
                monthDropdown.innerHTML = "";
                months.forEach((month, index) => {
                    const option = document.createElement("option");
                    option.value = String(index + 1).padStart(2, '0');
                    option.text = month;
                    if (index === currentMonth) option.selected = true;
                    monthDropdown.appendChild(option);
                });
            }

            if (yearDropdown) {
                yearDropdown.innerHTML = "";
                for (let y = currentYear - 5; y <= currentYear + 5; y++) {
                    const option = document.createElement("option");
                    option.value = y;
                    option.text = y;
                    if (y === currentYear) option.selected = true;
                    yearDropdown.appendChild(option);
                }
            }
        }

        // Month-wise VOIP Summary (Group by Campaign)
        function monthwisefetchVoipSummary() {
            const month = $('#monthDropdownmonthly').val();
            const year = $('#yearDropdownmonthly').val();

            if (!month || !year) return;

            $.ajax({
                url: 'ajax/headcount/monthwiseheadcount.php',
                type: 'POST',
                data: {
                    action: 'monthwiseheadcount',
                    month,
                    year
                },
                dataType: 'json',
                success: function(response) {
                    const tbody = $('#voipSummaryBodymonthly');
                    tbody.empty();

                    if (response.status === 'success' && response.data.length > 0) {
                        // Apply campaign filtering
                        const filteredData = response.data.filter(row => {
                            const idRaw = row.campaign_id;
                            const id = idRaw ? idRaw.toString().trim().toUpperCase() : '';
                            return (
                                id &&
                                id !== '0' &&
                                idRaw !== 0 &&
                                !id.endsWith('_IN') &&
                                !['DUMMY', 'TEST', 'UNKNOWN'].includes(id)
                            );
                        });

                        if (filteredData.length === 0) {
                            tbody.html('<tr><td colspan="5">No valid campaign data found after filtering.</td></tr>');
                            $('#currentUsagemonthly').text('$0.00');
                            $('#averageCostmonthly').text('$0.00');
                            $('#total_headcount_monthly').text('0');
                            return;
                        }

                        let totalVOIP = 0;
                        let totalHeadcount = 0;

                        filteredData.forEach(row => {
                            totalVOIP += row.voip_usage;
                            totalHeadcount += row.headcount;
                        });

                        filteredData.forEach(row => {
                            const percent = totalVOIP ? ((row.voip_usage / totalVOIP) * 100).toFixed(2) : '0.00';
                            tbody.append(`
                        <tr>
                            <td>${row.campaign_id || 'N/A'}</td>
                            <td>${row.headcount}</td>
                            <td>$${row.voip_usage.toFixed(2)}</td>
                            <td>$${row.average.toFixed(2)}</td>
                            <td>${percent}%</td>
                        </tr>
                    `);
                        });

                        const avgCost = totalHeadcount > 0 ? (totalVOIP / totalHeadcount).toFixed(2) : '0.00';
                        $('#currentUsagemonthly').text(`$${totalVOIP.toFixed(2)}`);
                        $('#averageCostmonthly').text(`$${avgCost}`);
                        $('#total_headcount_monthly').text(`${totalHeadcount}`);
                    } else {
                        tbody.html(`<tr><td colspan="5">${response.message || 'No data found.'}</td></tr>`);
                        $('#currentUsagemonthly').text('$0.00');
                        $('#averageCostmonthly').text('$0.00');
                        $('#total_headcount_monthly').text('0');
                    }
                },
                error: function() {
                    $('#voipSummaryBodymonthly').html('<tr><td colspan="5">Error loading data.</td></tr>');
                    $('#currentUsagemonthly').text('$0.00');
                    $('#averageCostmonthly').text('$0.00');
                    $('#total_headcount_monthly').text('0');
                }
            });
        }

        // Campaign-wise VOIP Summary (Group by Date)
        function campaignfetchVoipSummary() {
            const campaign = $('#campaignDropdown').val();
            const month = $('#monthDropdown').val();
            const year = $('#yearDropdown').val();

            if (!campaign && !month && !year) {
                alert('Please select at least one filter (campaign, month, or year).');
                return;
            }

            $.ajax({
                url: 'ajax/headcount/datewise_headcount_query.php?action=campaignwiseheadcount',
                type: 'POST',
                data: {
                    campaign,
                    month,
                    year
                },
                dataType: 'json',
                success: function(response) {
                    const tbody = $('#voipSummaryBody');
                    tbody.empty();

                    let totalVoipUsage = 0;
                    let totalHeadcount = 0;

                    if (response.status === 'success' && response.data.length > 0) {
                        response.data.forEach(item => {
                            tbody.append(`
                        <tr>
                            <td>${item.date}</td>
                            <td>${item.day}</td>
                            <td>${item.headcount}</td>
                            <td>${item.voip_usage}</td>
                            <td>${item.average}</td>
                        </tr>
                    `);
                            totalVoipUsage += parseFloat(item.voip_usage);
                            totalHeadcount += parseInt(item.headcount);
                        });

                        const averageCost = (totalHeadcount > 0) ? (totalVoipUsage / totalHeadcount).toFixed(2) : 0;
                        $('#currentUsage').text(`$${totalVoipUsage.toFixed(2)}`);
                        $('#averageCost').text(`$${averageCost}`);
                        $('#total_headcount_campaign').text(`${totalHeadcount}`);

                    } else {
                        const msg = response.message || 'No data available.';
                        tbody.html(`<tr><td colspan="5">${msg}</td></tr>`);
                        $('#currentUsage').text('$0.00');
                        $('#averageCost').text('0.00');
                        $('#total_headcount_campaign').text('0.00');
                    }
                },
                error: function(xhr) {
                    const errorMessage = xhr.responseJSON?.message || 'An error occurred while loading the data.';
                    $('#voipSummaryBody').html(`<tr><td colspan="5">${errorMessage}</td></tr>`);
                    $('#currentUsage').text('$0.00');
                    $('#averageCost').text('0.00');
                    $('#total_headcount_campaign').text('0.00');
                }
            });
        }


        // Bind onchange events
        $('#monthDropdownmonthly, #yearDropdownmonthly').on('change', monthwisefetchVoipSummary);
        $('#campaignDropdown, #monthDropdown, #yearDropdown').on('change', campaignfetchVoipSummary);


        loadVoIPDropdowns2();

        $('#statusToggle').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('label[for="statusToggle"]').text(isChecked ? 'Active' : 'INActive');
            loadVoIPDropdowns2();
        });

        function loadVoIPDropdowns2() {
            const status = $('#statusToggle').is(':checked') ? 'active' : 'both';

            $.ajax({
                url: 'ajax/headcount/add_headcount_query.php',
                method: 'POST',
                data: {
                    action: 'campaign_name',
                    status: status
                },
                dataType: 'json',
                success: function(data) {
                    const dropdown = $('#campaignDropdown');
                    dropdown.empty().append('<option value="fff">--Choose Campaign--</option><option value="">All</option>');
                    data.forEach(function(item) {
                        dropdown.append(`<option value="${item.name}">${item.name}</option>`);
                    });
                },
                error: function() {
                    toastr.error('Failed to load campaign list.');
                }
            });
        }

        $('#voipDatePicker').on('change', function() {
            const selectedDate = $(this).val();
            if (!selectedDate) return;

            const formattedDate = new Date(selectedDate).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });

            $.ajax({
                url: 'ajax/headcount/datewise_headcount_query.php',
                method: 'POST',
                data: {
                    action: 'datewiseheadcount',
                    entry_date: selectedDate
                },
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        const campaigns = res.data;

                        // Filter invalid campaign IDs
                        const filtered = campaigns.filter(row => {
                            const idRaw = row.campaign_id;
                            const id = idRaw ? idRaw.toString().trim().toUpperCase() : '';
                            return (
                                id &&
                                id !== '0' &&
                                idRaw !== 0 &&
                                !id.endsWith('_IN') &&
                                !['DUMMY', 'TEST', 'UNKNOWN'].includes(id)
                            );
                        });

                        if (filtered.length === 0) {
                            $('.voip_summary_table_body').html('<tr><td colspan="4">No valid data after filtering.</td></tr>');
                            $('[data-field="todays_usage"]').text('$0.00');
                            $('[data-field="total_headcount"]').text('0');
                            $('[data-field="average_cost"]').text('$0.00');
                            return;
                        }

                        let totalUsage = 0;
                        let totalHeadcount = 0;

                        const rows = filtered.map(row => {
                            const avg = row.headcount > 0 ? (row.voip_usage / row.headcount).toFixed(2) : '0.00';
                            totalUsage += parseFloat(row.voip_usage);
                            totalHeadcount += parseInt(row.headcount);
                            return `<tr>
                        <td>${row.campaign_id}</td>
                        <td>${row.headcount}</td>
                        <td>$${parseFloat(row.voip_usage).toFixed(2)}</td>
                        <td>$${avg}</td>
                    </tr>`;
                        });

                        const overallAvg = totalHeadcount > 0 ? (totalUsage / totalHeadcount).toFixed(2) : '0.00';

                        $('.voip_summary_table_body').html(rows.join(''));
                        $('[data-field="todays_usage"]').text(`$${totalUsage.toFixed(2)}`);
                        $('[data-field="total_headcount"]').text(totalHeadcount);
                        $('[data-field="average_cost"]').text(`$${overallAvg}`);
                    } else {
                        $('.voip_summary_table_body').html('<tr><td colspan="4">No data</td></tr>');
                        $('[data-field="todays_usage"]').text('$0.00');
                        $('[data-field="total_headcount"]').text('0');
                        $('[data-field="average_cost"]').text('$0.00');
                    }
                },
                error: function() {
                    alert('Failed to fetch data.');
                }
            });
        });

        $('body').on('click', '#datewiseexcel', function() {
            var fileName = 'datewise_voip_report';
            var table = document.getElementById('date_wisevoip_table');
            var ws = XLSX.utils.table_to_sheet(table);
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
            XLSX.writeFile(wb, fileName + '.xlsx');
        });
        $('body').on('click', '#campaignwise_excel', function() {
            var fileName = 'campaign_voip_report';
            var table = document.getElementById('campaignwise_table');
            var ws = XLSX.utils.table_to_sheet(table);
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
            XLSX.writeFile(wb, fileName + '.xlsx');
        });
        $('body').on('click', '#monthlywise_excel', function() {
            var fileName = 'monthlywise_voip_report';
            var table = document.getElementById('monthlywise_table');
            var ws = XLSX.utils.table_to_sheet(table);
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
            XLSX.writeFile(wb, fileName + '.xlsx');
        });
        // Populate dropdowns on page load
        populateMonthYearDropdown_Main__hours();
        populateMonthYearDropdown_Secondary_hours();
        monthwisefetchVoipSummary__hours();
        // Campaign-wise Dropdowns Initialization
        function populateMonthYearDropdown_Main__hours() {
            const monthDropdown = document.getElementById('monthDropdown_hours');
            const yearDropdown = document.getElementById('yearDropdown_hours');
            const now = new Date();
            const currentMonth = now.getMonth();
            const currentYear = now.getFullYear();
            const months = [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];

            if (monthDropdown) {
                monthDropdown.innerHTML = "";
                months.forEach((month, index) => {
                    const option = document.createElement("option");
                    option.value = String(index + 1).padStart(2, '0');
                    option.text = month;
                    if (index === currentMonth) option.selected = true;
                    monthDropdown.appendChild(option);
                });
            }

            if (yearDropdown) {
                yearDropdown.innerHTML = "";
                for (let y = currentYear - 5; y <= currentYear + 5; y++) {
                    const option = document.createElement("option");
                    option.value = y;
                    option.text = y;
                    if (y === currentYear) option.selected = true;
                    yearDropdown.appendChild(option);
                }
            }
        }

        // Month-wise Dropdowns Initialization
        function populateMonthYearDropdown_Secondary_hours() {
            const monthDropdown = document.getElementById('monthDropdownmonthly_hours');
            const yearDropdown = document.getElementById('yearDropdownmonthly_hours');
            const now = new Date();
            const currentMonth = now.getMonth();
            const currentYear = now.getFullYear();
            const months = [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];

            if (monthDropdown) {
                monthDropdown.innerHTML = "";
                months.forEach((month, index) => {
                    const option = document.createElement("option");
                    option.value = String(index + 1).padStart(2, '0');
                    option.text = month;
                    if (index === currentMonth) option.selected = true;
                    monthDropdown.appendChild(option);
                });
            }

            if (yearDropdown) {
                yearDropdown.innerHTML = "";
                for (let y = currentYear - 5; y <= currentYear + 5; y++) {
                    const option = document.createElement("option");
                    option.value = y;
                    option.text = y;
                    if (y === currentYear) option.selected = true;
                    yearDropdown.appendChild(option);
                }
            }
        }

        // Month-wise VOIP Summary (Group by Campaign) — with filter
        function monthwisefetchVoipSummary__hours() {
            const month = $('#monthDropdownmonthly_hours').val();
            const year = $('#yearDropdownmonthly_hours').val();

            if (!month || !year) return;

            $.ajax({
                url: 'ajax/hoursreport/monthwisehourscount.php',
                type: 'POST',
                data: {
                    action: 'monthwisehourscount',
                    month,
                    year
                },
                dataType: 'json',
                success: function(response) {
                    const tbody = $('#voipSummaryBodymonthly_hours');
                    tbody.empty();

                    if (response.status === 'success' && response.data.length > 0) {
                        // Apply filtering
                        const filteredData = response.data.filter(row => {
                            const idRaw = row.campaign_id;
                            const id = idRaw ? idRaw.toString().trim().toUpperCase() : '';
                            return (
                                id &&
                                id !== '0' &&
                                idRaw !== 0 &&
                                !id.endsWith('_IN') &&
                                !['DUMMY', 'TEST', 'UNKNOWN'].includes(id)
                            );
                        });

                        if (filteredData.length === 0) {
                            tbody.html('<tr><td colspan="5">No valid campaign data found after filtering.</td></tr>');
                            $('#currentUsagemonthly_hours').text('$0.00');
                            $('#averageCostmonthly_hours').text('$0.00');
                            $('#total_hourscount_monthly_hours').text('0.00');
                            return;
                        }

                        let totalVOIP = 0;
                        let totalhours = 0;

                        filteredData.forEach(row => {
                            totalVOIP += parseFloat(row.voip_usage);
                            totalhours += parseFloat(row.hours);
                        });

                        filteredData.forEach(row => {
                            const percent = totalVOIP ? ((row.voip_usage / totalVOIP) * 100).toFixed(2) : '0.00';
                            tbody.append(`
                                <tr>
                                    <td>${row.campaign_id || 'N/A'}</td>
                                    <td>${parseFloat(row.hours).toFixed(2)}</td>
                                    <td>$${parseFloat(row.voip_usage).toFixed(2)}</td>
                                    <td>$${parseFloat(row.average).toFixed(2)}</td>
                                    <td>${percent}%</td>
                                </tr>
                            `);
                        });
                        const avgCost = totalhours > 0 ? (totalVOIP / totalhours).toFixed(2) : '0.00';
                        $('#currentUsagemonthly_hours').text(`$${totalVOIP.toFixed(2)}`);
                        $('#averageCostmonthly_hours').text(`$${avgCost}`);
                        $('#total_hourscount_monthly_hours').text(`${totalhours.toFixed(2)}`);
                    } else {
                        tbody.html(`<tr><td colspan="5">${response.message || 'No data found.'}</td></tr>`);
                        $('#currentUsagemonthly_hours').text('$0.00');
                        $('#averageCostmonthly_hours').text('$0.00');
                        $('#total_hourscount_monthly_hours').text('0.00');
                    }
                },
                error: function() {
                    $('#voipSummaryBodymonthly_hours').html('<tr><td colspan="5">Error loading data.</td></tr>');
                    $('#currentUsagemonthly_hours').text('$0.00');
                    $('#averageCostmonthly_hours').text('$0.00');
                    $('#total_hourscount_monthly_hours').text('0.00');
                }
            });
        }


        // Campaign-wise VOIP Summary (Group by Date)
        function campaignfetchVoipSummary_hours() {
            const campaign = $('#campaignDropdown_hours').val();
            const month = $('#monthDropdown_hours').val();
            const year = $('#yearDropdown_hours').val();

            if (!campaign && !month && !year) {
                alert('Please select at least one filter (campaign, month, or year).');
                return;
            }

            $.ajax({
                url: 'ajax/hoursreport/datewise_hourscount_query.php?action=campaignwisehourscount',
                type: 'POST',
                data: {
                    campaign,
                    month,
                    year
                },
                dataType: 'json',
                success: function(response) {
                    const tbody = $('#voipSummaryBody_hours');
                    tbody.empty();

                    let totalVoipUsage = 0;
                    let totalhours = 0;

                    if (response.status === 'success' && response.data.length > 0) {
                        response.data.forEach(item => {
                            tbody.append(`
                        <tr>
                            <td>${item.date}</td>
                            <td>${item.day}</td>
                            <td>${item.hours}</td>
                            <td>${item.voip_usage}</td>
                            <td>${item.average}</td>
                        </tr>
                    `);
                            totalVoipUsage += parseFloat(item.voip_usage);
                            totalhours += parseFloat(item.hours);
                        });


                        const averageCost = (totalhours > 0) ? (totalVoipUsage / totalhours).toFixed(2) : '0.00';


                        $('#currentUsage_hours').text(`$${totalVoipUsage.toFixed(2)}`);
                        $('#averageCost_hours').text(`$${averageCost}`);
                        $('#total_hourscount_campaign_hours').text(`${totalhours.toFixed(2)}`);


                    } else {
                        const msg = response.message || 'No data available.';
                        tbody.html(`<tr><td colspan="5">${msg}</td></tr>`);
                        $('#currentUsage_hours').text('$0.00');
                        $('#averageCost_hours').text('0.00');
                        $('#total_hourscount_campaign_hours').text('0.00');
                    }
                },
                error: function(xhr) {
                    const errorMessage = xhr.responseJSON?.message || 'An error occurred while loading the data.';
                    $('#voipSummaryBody_hours').html(`<tr><td colspan="5">${errorMessage}</td></tr>`);
                    $('#currentUsage_hours').text('$0.00');
                    $('#averageCost_hours').text('0.00');
                    $('#total_hourscount_campaign_hours').text('0.00');
                }
            });
        }

        // Bind onchange events
        $('#monthDropdownmonthly_hours, #yearDropdownmonthly_hours').on('change', monthwisefetchVoipSummary__hours);
        $('#campaignDropdown_hours, #monthDropdown_hours, #yearDropdown_hours').on('change', campaignfetchVoipSummary_hours);


        loadVoIPDropdowns_hours();

        $('#statusToggle_hours').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('label[for="statusToggle_hours"]').text(isChecked ? 'Active' : 'INActive');
            loadVoIPDropdowns_hours();
        });

        function loadVoIPDropdowns_hours() {
            const status = $('#statusToggle_hours').is(':checked') ? 'active' : 'both';

            $.ajax({
                url: 'ajax/hoursreport/add_hourscount_query.php',
                method: 'POST',
                data: {
                    action: 'campaign_name',
                    status: status
                },
                dataType: 'json',
                success: function(data) {
                    const dropdown = $('#campaignDropdown_hours');
                    dropdown.empty().append('<option value="fff">--Choose Campaign--</option><option value="">All</option>');
                    data.forEach(function(item) {
                        dropdown.append(`<option value="${item.name}">${item.name}</option>`);
                    });
                },
                error: function() {
                    toastr.error('Failed to load campaign list.');
                }
            });
        }

        $('#voipDatePicker_hours').on('change', function() {
            const selectedDate = $(this).val();
            if (!selectedDate) return;

            const formattedDate = new Date(selectedDate).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });

            $.ajax({
                url: 'ajax/hoursreport/datewise_hourscount_query.php',
                method: 'POST',
                data: {
                    action: 'datewisehourscount',
                    entry_date: selectedDate
                },
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        const campaigns = res.data;

                        // Filter invalid campaign IDs
                        const filtered = campaigns.filter(row => {
                            const idRaw = row.campaign_id;
                            const id = idRaw ? idRaw.toString().trim().toUpperCase() : '';
                            return (
                                id &&
                                id !== '0' &&
                                idRaw !== 0 &&
                                !id.endsWith('_IN') &&
                                !['DUMMY', 'TEST', 'UNKNOWN'].includes(id)
                            );
                        });

                        if (filtered.length === 0) {
                            $('.voip_summary_table_body_hours').html('<tr><td colspan="4">No valid data after filtering.</td></tr>');
                            $('[data-field="todays_usage_hours"]').text('$0.00');
                            $('[data-field="total_hourscount_hours"]').text('0');
                            $('[data-field="average_cost_hours"]').text('$0.00');
                            return;
                        }

                        let totalUsage = 0;
                        let totalhours = 0;

                        const rows = filtered.map(row => {
                            const avg = row.hours > 0 ? (row.voip_usage / row.hours).toFixed(2) : '0.00';
                            totalUsage += parseFloat(row.voip_usage);
                            totalhours += parseFloat(row.hours);
                            return `<tr>
                                <td>${row.campaign_id}</td>
                                <td>$${parseFloat(row.hours).toFixed(2)}</td>
                                <td>$${parseFloat(row.voip_usage).toFixed(2)}</td>
                                <td>$${avg}</td>
                            </tr>`;
                        });

                        const overallAvg = totalhours > 0 ? (totalUsage / totalhours).toFixed(2) : '0.00';

                        // Populate the table and update summary values
                        $('.voip_summary_table_body_hours').html(rows.join(''));
                        $('[data-field="todays_usage_hours"]').text(`$${totalUsage.toFixed(2)}`);
                        $('[data-field="total_hourscount_hours"]').text(`$${totalhours.toFixed(2)}`); // ✅ no .toFixed(2) here
                        $('[data-field="average_cost_hours"]').text(`$${overallAvg}`);

                    } else {
                        $('.voip_summary_table_body_hours').html('<tr><td colspan="4">No data</td></tr>');
                        $('[data-field="todays_usage_hours"]').text('$0.00');
                        $('[data-field="total_hourscount_hours"]').text('0');
                        $('[data-field="average_cost_hours"]').text('$0.00');
                    }
                },
                error: function() {
                    alert('Failed to fetch data.');
                }
            });
        });

        $('body').on('click', '#datewiseexcel_hours', function() {
            var fileName = 'datewise_voip_report';
            var table = document.getElementById('date_wisevoip_table_hours');
            var ws = XLSX.utils.table_to_sheet(table);
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
            XLSX.writeFile(wb, fileName + '.xlsx');
        });
        $('body').on('click', '#campaignwise_excel_hours', function() {
            var fileName = 'campaign_voip_report';
            var table = document.getElementById('campaignwise_table_hours');
            var ws = XLSX.utils.table_to_sheet(table);
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
            XLSX.writeFile(wb, fileName + '.xlsx');
        });
        $('body').on('click', '#monthlywise_excel_hours', function() {
            var fileName = 'monthlywise_voip_report';
            var table = document.getElementById('monthlywise_table_hours');
            var ws = XLSX.utils.table_to_sheet(table);
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
            XLSX.writeFile(wb, fileName + '.xlsx');
        });
    </script>
</body>


</html>