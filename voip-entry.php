<?php
$page = 'voipentry';
include('config.php');
include('function/session.php');

?>
<input type="text" id="current_username" value="<?php echo $logged_in_user_name; ?>" hidden>
<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">


<head>

    <meta charset="utf-8" />
    <title>Voip Entry | Zealous - Dialer CRM</title>
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
    #voipTable td[contenteditable="true"] {
        background-color: #fff8dc;
        cursor: text;
    }

    #voipusageTable td[contenteditable="true"] {
        background-color: #fff8dc;
        cursor: text;
    }

    .counter-value {
        font-size: 30px;
    }

    .text-info1 {
        --vz-text-opacity: 1;
        color: rgb(204 81 233) !important;
    }

    .update-headcount-btn {
        background-color: #bea169;
        color: white;
        border: none;
    }

    .update-headcount-btn:hover {
        background-color: #a78e56;
    }

    .custom-btn {
        background-color: #bea16a;
        color: white;
        border-color: #bea16a;
    }

    .custom-btn:hover {
        background-color: #9e8f55;
        /* Darker shade on hover */
    }

    #voipTable_headcount td[contenteditable="true"] {
        background-color: #fff8dc;
        cursor: text;
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
                                                <h4 class="fs-16 mb-1">Welcome Back, <?php echo $logged_in_user_name; ?>!</h4>
                                                <p class="text-muted mb-0">Enter Voip name and usage amount</p>
                                                <button class="btn btn-soft-primary" data-bs-toggle="offcanvas" id="createVoipBtn" data-bs-target="#campControlCanvas">
                                                    <i class="ri-add-circle-line align-middle me-1"></i>Daily Voip Usage </button>

                                                <!-- Edit Button -->
                                                <button class="btn btn-soft-secondary editVoipBtn"
                                                    data-id="1"
                                                    data-voip="OldVoipName"
                                                    data-extension="Extension123">
                                                    <i class="ri-add-circle-line align-middle me-1"></i>Edit Voip Name
                                                </button>
                                                <button class="btn btn-soft-info editVoipusageBtn"
                                                    data-id="1"
                                                    data-voip="OldVoipName"
                                                    data-extension="Extension123">
                                                    <i class="ri-add-circle-line align-middle me-1"></i>Edit VoIP Usage
                                                </button>
                                                <button class="btn btn-soft-warning" data-bs-toggle="offcanvas" id="createVoipBtn" data-bs-target="#campControlCanvasheadcount">
                                                    <i class="ri-add-circle-line align-middle me-1"></i>Daily Campaign Head Count</button>
                                                <label id="lastdateentry" class="text-primary fw-semibold me-2">
                                                    <i class="ri-calendar-line me-1"></i> Last Entry Date:
                                                </label>

                                            </div>


                                            <div class="mt-3 mt-lg-0">
                                                <form action="javascript:void(0);">
                                                    <div class="row g-3 mb-0 align-items-center">
                                                        <!-- <div class="col-sm-auto">
                                                            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                                                <i class="fa fa-calendar"></i>&nbsp;
                                                                <span></span> <i class="fa fa-caret-down"></i>
                                                            </div>
                                                        </div> -->
                                                        <div class="col-sm-auto">
                                                            <div class="form-group">
                                                                <label for="">Start date</label>
                                                                <input type="date" id="startDate" value="<?php echo $today_date; ?>" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <div class="form-group">
                                                                <label for="">End date</label>
                                                                <input type="date" id="endDate" value="<?php echo $today_date; ?>" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <div class="form-group">
                                                                <label for="voipDropdownBtn">VoIP</label>
                                                                <div class="dropdown" id="fliterdropdownvoip_name_wrapper">
                                                                    <button
                                                                        class="form-select "
                                                                        type="button"
                                                                        id="voipDropdownBtn"
                                                                        data-bs-toggle="dropdown"
                                                                        aria-expanded="false">
                                                                        -- Choose --
                                                                    </button>
                                                                    <ul
                                                                        class="dropdown-menu p-2"
                                                                        id="fliterdropdownvoip_name"
                                                                        style="width: 250px; max-height: 300px; overflow-y: auto;">
                                                                        <!-- Checkboxes will be injected here -->
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-auto">
                                                            <button type="button" class="btn btn-soft-success mt-3" id="getRecord"><i class="ri-add-circle-line align-middle me-1"></i>
                                                                Get Voip Details
                                                            </button>
                                                        </div>
                                                        <!--end col-->
                                                        <!-- <div class="col-auto">
                                                            <button type="button" class="btn btn-soft-info btn-icon waves-effect waves-light layout-rightside-btn"><i class="ri-pulse-line"></i></button>
                                                        </div> -->
                                                        <!--end col-->


                                                    </div>
                                                    <!--end row-->


                                                </form>
                                            </div>

                                        </div><!-- end card header -->

                                        <div class="row" id="voip-dashboard">

                                        </div>
                                    </div>
                                </div>


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
                    </div>
                    <div class="row">

                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Voip Details</h4>
                                    <div class="flex-shrink-0">
                                        <button type="button" id="export_excel" class="btn btn-soft-info btn-sm">
                                            <i class="ri-file-list-3-line align-middle"></i> Download Report
                                        </button>
                                    </div>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <table id="export_table" class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                            <thead class="text-muted table-light">
                                                <tr>
                                                    <th scope="col">Sno</th>
                                                    <th scope="col">Voip Name</th>
                                                    <th scope="col">Entry Date</th>
                                                    <th scope="col">Usage Amount</th>
                                                    <th scope="col">Created_by</th>
                                                    <th scope="col">Timestamp</th>

                                                </tr>
                                            </thead>
                                            <tbody class="table_result">
                                                <tr>
                                                    <td colspan="11" class="text-center">No Record Found</td>
                                                </tr>
                                            </tbody>
                                        </table><!-- end table -->
                                    </div>
                                </div>
                            </div> <!-- .card-->
                        </div> <!-- .col-->
                    </div>

                    <div class="row">
                        <div class="col">

                            <div class="h-100">
                                <div class="row mb-3 pb-1">
                                    <div class="col-12">
                                        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                            <div class="flex-grow-1">
                                            </div>
                                        </div><!-- end card header -->
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </div> <!-- end .h-100-->
                        </div> <!-- end col -->
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

    <div class="offcanvas offcanvas-end" id="campControlCanvas">
        <div class="offcanvas-header">
            <h2 class="offcanvas-title campcanvasheading">Usage Entry</h2>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <div class="row ">
                <div class="col-12 pt-3">
                    <label for="">Voip Name</label>
                    <select name="" class=" col-12 form-control" id="adddropdownvoip_name">
                        <option value="">--Choose--</option>
                    </select>
                </div>
                <div class="col-12 pt-3">
                    <label for="">Date</label>
                    <input type="date" class="form-control" name="" id="entry_date">
                </div>
                <div class="col-12 pt-3">
                    <label for="">Used Voip Amount $</label>
                    <input type="number" class="form-control" name="" id="amount_used_normal">
                </div>

                <div class="col-12 pt-2">
                    <button class="btn mt-4 btn-soft-secondary" id="add_usage_btn" data-campaction="create">Add Usage</button>
                    <!-- <button class="btn mt-4 btn-soft-primary d-none" id="updateUser">Update User</button> -->
                </div>
            </div>

            <div class="offcanvas-header mt-4">
                <h2 class="offcanvas-title campcanvasheading">Add Voip</h2>
            </div>


            <div class="col-12 pt-3 ">
                <label for="">Voip Name</label>

                <input type="text" class="form-control" name="" id="voip_name">
            </div>
            <div class="col-12 pt-3 ">
                <label for="">Extension Name</label>

                <input type="text" class="form-control" name="" id="extension_name">
            </div>
            <div class="col-12 pt-2">
                <button class="btn mt-4 btn-soft-secondary" id="add_voip_btn" data-campaction="create">Add Voip</button>
            </div>

        </div>
    </div>
    <!-- <select name="" class=" col-12 form-control" id="add_campaignname">
                        <option value="">--Choose--</option>
                    </select> -->
    <div class="offcanvas offcanvas-end w-75" tabindex="-1" id="campControlCanvasheadcount">
        <div class="offcanvas-header">
            <h2 class="offcanvas-title campcanvasheading">Add Head Count</h2>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>

        <!-- Row for Start Date, End Date, and Get Data -->
        <div class="offcanvas-body">
            <div class="row g-3 align-items-end">

                <div class="col-md-4">
                    <label for="endDate" class="form-label">Select Date</label>
                    <input type="date" id="selectdate__headcount" value="<?php echo $today_date; ?>" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="voipDropdownBtn" class="form-label">Get Data</label>
                    <div class="dropdown">
                        <button
                            class="btn custom-btn w-100"
                            type="button"
                            id="getdataheadcount"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Get Campaign
                        </button>
                    </div>
                </div>
            </div>

            <!-- Form Section -->

            <table class="table table-bordered" id="voipTable_headcount" style="display:none">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Campaign Name</th>
                        <th>Entry Date</th>
                        <th>Head Count</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>


        </div>
    </div>

    <!-- Offcanvas (Full Width) -->
    <div class="offcanvas offcanvas-end w-75" tabindex="-1" id="editVoipOffcanvas" aria-labelledby="editVoipLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="editVoipLabel">Edit VoIP Entries</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <table class="table table-bordered" id="voipTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>VoIP Name</th>
                        <th>Extension Name</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Populated dynamically -->
                </tbody>
            </table>
        </div>
    </div>
    <!-- VoIP Usage Offcanvas -->
    <div class="offcanvas offcanvas-end w-75" tabindex="-1" id="voipusageOffcanvas" aria-labelledby="voipusageLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="voipusageLabel">VoIP Usage Entries</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <table class="table table-bordered" id="voipusageTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>VoIP Name</th>
                        <th>Entry Date</th>
                        <th>Amount Used</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Filled dynamically -->
                </tbody>
            </table>
        </div>
    </div>


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
        $(document).ready(function() {
            //default loading funtion 
            loadVoIPDropdowns();
            loadvoipgetrecord();
            loadVoIPDropdowns1();
            $.ajax({
                url: 'ajax/voip/fetch_voip_summary.php?action=lastentrydate',
                type: 'GET',
                dataType: 'json', // Important: tell jQuery to expect JSON
                success: function(data) {
                    console.log("Parsed JSON:", data);

                    if (data.status === 'Ok') {
                        $('#lastdateentry').html(`<i class="ri-calendar-line me-1"></i> Last Entry Date: <span class="text-dark">${data.entry_date}</span>`);
                    } else {
                        $('#lastdateentry').html(`<i class="ri-error-warning-line text-danger me-1"></i> No entry date found`);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", error);
                    $('#lastdateentry').html(`<i class="ri-error-warning-line text-danger me-1"></i> Failed to load date`);
                }
            });



            // Fetch and populate table
            $('#getdataheadcount').on('click', function() {
                const entryDate = $('#selectdate__headcount').val();

                if (!entryDate) {
                    alert("Please select a date.");
                    return;
                }

                $.ajax({
                    url: 'ajax/headcount/update_headcount_query.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'getcampaigndetails',
                        entry_date: entryDate
                    },
                    success: function(response) {
                        const tbody = $('#voipTable_headcount tbody');
                        tbody.empty();

                        if (response.success) {
                            response.data.forEach((row, index) => {
                                const html = `
                            <tr>
                                <td>${row.id}</td>
                                <td>${row.campaign_id}</td>
                                  <td>${row.entry_date}</td>
                                <td contenteditable="true" data-field="headcount" class="headcountbg">${row.headcount}</td>
                              
                            </tr>
                        `;
                                tbody.append(html);
                            });

                            $('#voipTable_headcount').show();
                        } else {
                            alert(response.message);
                            $('#voipTable_headcount').hide();
                        }
                    },
                    error: function() {
                        alert("Error retrieving data.");
                        $('#voipTable_headcount').hide();
                    }
                });
            });



            $(document).on('blur', '[contenteditable="true"][data-field="headcount"]', function() {
                const $cell = $(this);
                const newValue = $cell.text().trim();
                //alert(newValue);
                // Validate it's a number
                if (!/^\d+$/.test(newValue)) {
                    alert("Only numeric values allowed for Head Count.");
                    $cell.text(''); // Clear invalid input
                    return;
                }

                const $row = $cell.closest('tr');
                const rowid = $row.find('td:eq(0)').text().trim();
                //alert(rowid);
                const campaignId = $row.find('td:eq(1)').text().trim();
                const entryDate = $row.find('td:eq(3)').text().trim();

                // Send update to backend
                $.ajax({
                    url: 'ajax/headcount/update_headcount_query.php',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'updateheadcount',
                        rowid: rowid,
                        campaign_id: campaignId,
                        head_count: newValue,
                        entry_date: entryDate
                    },
                    success: function(response) {
                        if (response.success) {
                            const messageSpan = $('<span class="edit-message ms-2 text-success fw-bold">✅</span>');
                            $cell.siblings('.edit-message').remove();
                            $cell.after(messageSpan);
                            setTimeout(() => {
                                messageSpan.remove();
                            }, 1000);
                        } else {
                            alert(response.error || "Update failed.");
                        }
                    },
                    error: function() {
                        // alert("Error updating headcount.");
                    }
                });
            });



            function loadVoIPDropdowns1() {
                $.ajax({
                    url: 'ajax/voip/add_voip_query.php?action=voipapend',
                    method: 'POST',
                    dataType: 'json',
                    success: function(data) {
                        const addDropdown = $('#adddropdownvoip_name');
                        addDropdown.empty(); // Clear the dropdown once

                        // Add default and fixed options
                        addDropdown.append('<option value="">--Choose--</option>');
                        addDropdown.append('<option value="29">DID</option>');

                        // Append options from AJAX data
                        data.forEach(function(item) {
                            const option = `<option value="${item.id}">${item.name}</option>`;
                            addDropdown.append(option);
                        });
                    },
                    error: function() {
                        toastr.error('Failed to load VoIP list.');
                    }
                });
            }

            // Function to populate the dropdown with VoIP options
            function loadVoIPDropdowns() {
                $.ajax({
                    url: 'ajax/voip/add_voip_query.php?action=voipapend',
                    method: 'POST',
                    dataType: 'json',
                    success: function(data) {
                        const filterDropdown = $('#fliterdropdownvoip_name'); // UL element
                        filterDropdown.empty();

                        // Add a 'Select All' checkbox
                        const selectAllItem = `
                <li>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="selectAllVoips">
                        <label class="form-check-label" for="selectAllVoips">
                            Select All
                        </label>
                    </div>
                </li>
            `;
                        filterDropdown.append(selectAllItem);

                        // Loop through the data and add checkboxes for each VoIP
                        data.forEach(function(item) {
                            const checkboxItem = `
                    <li>
                        <div class="form-check">
                            <input class="form-check-input voip-checkbox" type="checkbox" 
                                value="${item.id}" id="voip_${item.id}">
                            <label class="form-check-label" for="voip_${item.id}">
                                ${item.name}
                            </label>
                        </div>
                    </li>
                `;
                            filterDropdown.append(checkboxItem);
                        });

                        // Toggle "Select All" checkboxes when clicked
                        $('#selectAllVoips').change(function() {
                            $('.voip-checkbox').prop('checked', $(this).prop('checked'));
                        });
                    },
                    error: function() {
                        toastr.error('Failed to load VoIP list.');
                    }
                });
            }


            // add voip name 
            $('#add_voip_btn').on('click', function(e) {
                e.preventDefault();

                var voip_name = $('#voip_name').val().trim();

                var extension_name = $('#extension_name').val().trim();

                if (voip_name === '' || extension_name === '') {
                    toastr.error('Please enter a VoIP name and Extension');
                    return;
                }

                $.ajax({
                    url: 'ajax/voip/add_voip_query.php',
                    type: 'POST',
                    data: {
                        voip_name: voip_name,
                        extension_name: extension_name,
                        action: 'create'
                    },
                    success: function(response) {
                        console.log("Raw response:", response);
                        try {
                            let res = typeof response === 'object' ? response : JSON.parse(response);
                            if (res.status === 'success') {
                                toastr.success(res.message || 'VoIP added successfully!');
                                $('#voip_name').val('');
                                $('#extension_name').val('');
                                loadVoIPDropdowns1();
                            } else {
                                toastr.error(res.message || 'Something went wrong.');
                                $('#voip_name').val('');
                                $('#extension_name').val('');
                            }
                        } catch (e) {
                            toastr.error('Unexpected response from server.');
                            console.error("Parsing error:", e);
                        }
                    }

                });
            });
            // usage entry
            $('#add_usage_btn').on('click', function(e) {
                e.preventDefault();
                const voipId = $('#adddropdownvoip_name').val();
                const entryDate = $('#entry_date').val();
                const amountUsed = $('#amount_used_normal').val();

                if (!voipId || !entryDate || !amountUsed) {
                    toastr.error('Please fill all the fields.');
                    return;
                }

                $.ajax({
                    url: 'ajax/voip/usage_entry_query.php',
                    method: 'POST',
                    data: {
                        voip_id: voipId,
                        entry_date: entryDate,
                        amount_used: amountUsed,
                        action: 'usagecreate'
                    },
                    success: function(response) {
                        console.log(response);

                        try {
                            const res = JSON.parse(response);
                            if (res.status === 'success') {
                                toastr.success(res.message);
                                $('#entry_date').val('');
                                $('#amount_used_normal').val('');
                                $('#adddropdownvoip_name').val('');
                                loadVoIPDropdowns();
                            } else {
                                toastr.error(res.message);
                                $('#entry_date').val('');
                                $('#amount_used_normal').val('');
                                $('#adddropdownvoip_name').val('');
                            }
                        } catch (err) {
                            toastr.error('Unexpected response from server.');
                        }
                    },
                    error: function() {
                        toastr.error('Failed to send request.');
                    }
                });
            });
        });

        // Click event for "Get Voip Details" button
        $('#getRecord').on('click', function() {
            fetchVoipSummary();
            fetchVoipDetails();
        });
        // Initial load (optional usage)
        function loadvoipgetrecord() {
            fetchVoipSummary();
            fetchVoipDetails();
        }

        // Function to fetch selected VoIP IDs from the checkboxes
        function getSelectedVoipIds() {
            const selected = [];
            $('.voip-checkbox:checked').each(function() {
                selected.push($(this).val());
            });
            return selected;
        }

        // Function to fetch the VoIP summary data
        function fetchVoipSummary() {
            const startDate = $('#startDate').val();
            const endDate = $('#endDate').val();
            const voipIds = getSelectedVoipIds(); // Get selected VoIP IDs

            if (!startDate || !endDate) {
                toastr.error('Please select valid start and end dates.');
                return;
            }

            $.post('ajax/voip/fetch_voip_summary.php', {
                action: 'voipcount_dashboard',
                start_date: startDate,
                end_date: endDate,
                voipIds: voipIds // Send the array of selected VoIP IDs
            }, function(response) {
                const res = typeof response === 'string' ? JSON.parse(response) : response;

                if (res.status !== 'success' || !Array.isArray(res.data)) {
                    toastr.error('No data found for the selected filters.');
                    $('#voip-dashboard').html('<div class="col-12 text-center text-muted">No data available</div>');
                    return;
                }

                let total = 0;
                let cardsHtml = '';

                res.data.forEach((item) => {
                    const voipName = item.voip_name || 'Unknown';
                    const amountUsed = parseFloat(item.amount_used) || 0;
                    total += amountUsed;

                    cardsHtml += `
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card card-animate h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">${voipName}</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                    <span class="counter-value" data-target="${amountUsed}">${amountUsed.toFixed(2)}</span>
                                </h4>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-warning-subtle rounded fs-3">
                                    <i class="bx bx-phone-call text-warning"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
                });

                // Append total card
                cardsHtml += `
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card card-animate h-100">
                <div class="card-body">
                    <p class="text-uppercase fw-medium text-muted mb-0">Total</p>
                    <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                        <span class="counter-value" data-target="${total}">${total.toFixed(2)}</span>
                    </h4>
                </div>
            </div>
        </div>`;

                $('#voip-dashboard').html(cardsHtml);

            }).fail(function(xhr, status, error) {
                console.error(`Error: ${status} - ${error}`);
                toastr.error('Failed to fetch VoIP summary.');
            });
        }

        // Function to fetch VoIP details
        function fetchVoipDetails() {
            const startDate = $('#startDate').val();
            const endDate = $('#endDate').val();
            const voipIds = getSelectedVoipIds(); // Fetch multiple selected values

            if (!startDate || !endDate) {
                toastr.error('Please select valid start and end dates.');
                return;
            }

            $.ajax({
                url: 'ajax/voip/usage_entry_query.php',
                method: 'POST',
                data: {
                    action: 'getdata_voipusage',
                    start_date: startDate,
                    end_date: endDate,
                    voip_ids: voipIds // Send the array of selected VoIP IDs
                },
                dataType: 'json',
                success: function(data) {
                    const $tableBody = $('.table_result');
                    $tableBody.empty();

                    if (data.length === 0) {
                        $tableBody.append('<tr><td colspan="7" class="text-center">No Record Found</td></tr>');
                        return;
                    }

                    data.forEach((row, index) => {
                        const newRow = `
                <tr>
                    <td>${index + 1}</td>
                    <td>${row.voip_name}</td>
                    <td>${row.entry_date}</td>
                    <td>${row.amount_used}</td>
                    <td>${row.created_by}</td>
                    <td>${row.created_at}</td>
                </tr>`;
                        $tableBody.append(newRow);
                    });
                },
                error: function() {
                    toastr.error('Failed to fetch data.');
                }
            });
        }

        $('body').on('click', '#export_excel', function() {

            var startDate = $('#startDate').val();
            var fileName = 'voip_report' + ' - ' + startDate;
            var table = document.getElementById('export_table');
            var ws = XLSX.utils.table_to_sheet(table);
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
            XLSX.writeFile(wb, fileName + '.xlsx');
        });

        $(document).on('click', '.editVoipBtn', function() {
            $.ajax({
                url: 'ajax/voip/edit_voipname_query.php',
                type: 'POST',
                data: {
                    action: 'get_campaign'
                },
                dataType: 'json',
                success: function(data) {
                    let html = '';
                    data.forEach(row => {
                        html += `
                <tr>
                    <td>${row.id}</td>
                    <td data-id="${row.id}">${row.voip_name}</td>
                    <td contenteditable="true" data-id="${row.id}" data-field="extension_name">${row.extension_name}</td>
                </tr>`;
                    });
                    $('#voipTable tbody').html(html);

                    // Show the offcanvas (full width)
                    const offcanvas = new bootstrap.Offcanvas(document.getElementById('editVoipOffcanvas'));
                    offcanvas.show();
                },
                error: function() {
                    alert('Error fetching data.');
                }
            });
        });

        // Add event listener for changes in editable cells
        $(document).on('input', '[contenteditable="true"]', function() {
            const columnName = $(this).data('field');
            const message = `${columnName} Edited`;
            const messageSpan = $('<span class="edit-message">✅</span>');
            $(this).siblings('.edit-message').remove();
            $(this).after(messageSpan);
            setTimeout(() => {
                messageSpan.remove();
            }, 1000);
        });

        // Inline edit save on blur
        $(document).on('blur', '#voipTable td[contenteditable="true"]', function() {
            const id = $(this).data('id');
            const field = $(this).data('field');
            const value = $(this).text();

            $.ajax({
                url: 'ajax/voip/edit_voipname_query.php',
                type: 'POST',
                data: {
                    action: 'update_voip',
                    id: id,
                    field: field,
                    value: value
                },
                success: function(response) {
                    const res = JSON.parse(response);
                    if (res.success) {
                        alert('Update successful!');
                    } else {
                        alert('Error: ' + res.error);
                    }
                },
                error: function() {
                    alert('Error updating data.');
                }
            });
        });
        // On editVoipusageBtn click
        $(document).on('click', '.editVoipusageBtn', function() {
            const startDate = $('#startDate').val();
            const endDate = $('#endDate').val();

            $('#voipusageTable tbody').html('<tr><td colspan="4">Loading...</td></tr>');
            const voipusageOffcanvas = new bootstrap.Offcanvas(document.getElementById('voipusageOffcanvas'));
            voipusageOffcanvas.show();

            $.ajax({
                url: 'ajax/voip/edit_voipusage.php',
                method: 'GET',
                dataType: 'json',
                data: {
                    action: 'getvoipusagedetails',
                    startDate: startDate,
                    endDate: endDate
                },
                success: function(response) {
                    if (response.status === 'success' && Array.isArray(response.data)) {
                        const rows = response.data.map(row => `
                            <tr>
                                <td>${row.id}</td>
                                <td data-id="${row.id}" data-field="voip_name">${row.voip_name}</td>
                                <td data-id="${row.id}" data-field="entry_date">${row.entry_date}</td>
                                <td contenteditable="true" class="editable" data-id="${row.id}" data-field="amount_used">
                                    ${row.amount_used}
                                </td>
                            </tr>`).join('');
                        $('#voipusageTable tbody').html(rows);
                    } else {
                        $('#voipusageTable tbody').html('<tr><td colspan="4">No records found.</td></tr>');
                    }
                },
                error: function() {
                    $('#voipusageTable tbody').html('<tr><td colspan="4">Error loading data.</td></tr>');
                }
            });
        });
        $(document).on('input', '[contenteditable="true"]', function() {
            const columnName = $(this).data('field');
            const message = `${columnName} Edited`;

            const messageSpan = $('<span class="edit-message">✅</span>');

            $(this).siblings('.edit-message').remove();
            $(this).after(messageSpan);

            setTimeout(() => {
                messageSpan.remove();
            }, 1000);
        });
        $(document).on('blur', '#voipusageTable td[contenteditable="true"]', function() {
            const id = $(this).data('id');
            const field = $(this).data('field');
            const newValue = $(this).text().trim();

            if (!id || !field) return;

            $.ajax({
                url: 'ajax/voip/edit_voipusage.php?action=update_voip_usage',
                method: 'POST',
                dataType: 'json',
                data: {
                    id,
                    field,
                    value: newValue
                },
                success: function(response) {
                    if (response.status !== 'success') {
                        alert('Update failed: ' + (response.message || 'Unknown error'));
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error);
                }
            });
        });
    </script>
</body>


</html>