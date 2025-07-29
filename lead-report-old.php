<?php
$page = 'leadreport';
include('config.php');
include('function/session.php');

?>
<input type="text" id="current_username" value="<?php echo $logged_in_user_name; ?>" data-role="<?php echo $logged_in_user_role; ?>" hidden>
<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">


<head>

    <meta charset="utf-8" />
    <title>Lead Report | <?php echo $site_name; ?> - Dialer CRM</title>
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
    <link rel="stylesheet" href="assets/css/audioplayer.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>
<style>
    .counter-value {
        font-size: 30px;
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
                                                <!-- <h4 class="fs-16 mb-1">Hello, <?php echo $logged_in_user_name; ?>!</h4>
                                                <p class="text-muted mb-0">Get Current Lead Report on this Page.</p> -->
                                                <button class="btn d-block mt-3 btn-soft-danger" id="listViewExportTablebtn">Export List View</button>
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
                                                                <label for="">Campaign</label>
                                                                <select name="" id="campaign" class="form-select">
                                                                    <option value="">-- Choose Campaign --</option>

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <label for="">Call Center</label>

                                                            <select name="" id="call_center" class="form-select">
                                                                <?php
                                                                // echo $single_callcenter;
                                                                $single_callcenter = explode(",", $logged_in_user_group);
                                                                // print_r($single_callcenter);
                                                                if ($logged_in_user_role == "teamleader" || $logged_in_user_role == "superadmin") {
                                                                    echo '<option value="" selected>-- ALL --</option>';
                                                                }
                                                                $centercount = 0;
                                                                foreach ($single_callcenter as $center) {
                                                                    if ($center) {
                                                                        echo '<option value="' . trim($center) . '">' . trim($center) . '</option>';
                                                                    }
                                                                    $centercount++;
                                                                }
                                                                if ($centercount == 0) {
                                                                    echo '<option value="" selected>-- Choose Center --</option>';
                                                                }

                                                                // if ($logged_in_user_group == 'ZD25' || $logged_in_user_group == 'ZD26') {

                                                                // echo '<option value="' . $logged_in_user_group . '">' . $logged_in_user_group . '</option>';

                                                                // } else {
                                                                // echo '

                                                                // ';
                                                                // }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button" class="btn btn-soft-success mt-3" id="getRecord"><i class="ri-add-circle-line align-middle me-1"></i>
                                                                Get Lead
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
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">AGENT PERFORMANCE SUMMARY</h4>
                                    <?php 
                                            if($logged_in_user_name == "PREQ")
                                            {
                                                
                                        ?>
                                        <div class="flex-shrink-0">
                                            <select name="" id="type_dl" class="form-select form-sm">
                                                <option value="date" selected>Date Wise</option>
                                                <option value="dispo">Dispo Wise</option>
                                            </select>
                                        </div>
                                    <div class="flex-shrink-0">
                                        <style>
                                            .select2.select2-container
                                            {
                                                width: 300px !important;
                                            }
                                        </style>
                                        
                                        
                                            <select class="js-example-basic-multiple" name="dispos[]" multiple="multiple" width="200" placeholder="test">
                                                <option value="" disabled>Choose Dispo to download</option>
                                            </select>
                                       
                                    </div>
                                     <?php }?>
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
                                                    <th scope="col">Lead ID</th>
                                                    <th scope="col">Campaign ID</th>
                                                    <th scope="col">Agent ID</th>
                                                    <th scope="col">Agent Name</th>
                                                    <th scope="col">Phone Num</th>
                                                    <th scope="col">INBOUND/OUTBOUND</th>
                                                    <th scope="col">Created Date/Time</th>
                                                    <th scope="col">DISPO</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table_result">
                                                <tr>
                                                    <td colspan="8" class="text-center">No Record Found</td>
                                                </tr>
                                            </tbody>
                                        </table><!-- end table -->
                                    </div>
                                </div>
                            </div> <!-- .card-->
                        </div> <!-- .col-->
                    </div>
                </div>
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        <table class="table d-none" id="listViewExportTable">
            <thead>
                <tr>
                    <th>Dispo Status</th>
                    <th>Count</th>
                </tr>
            </thead>
            <tbody class="listViewTable">

            </tbody>
        </table>
        <table class="table d-none" id="listViewDispo">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Description</th>
                    <th>Count</th>
                </tr>
            </thead>
            <tbody class="listViewTable">

            </tbody>
        </table>
        <table id="export_table_download" class="table table-borderless table-centered align-middle table-nowrap mb-0 d-none">
            <thead class="text-muted table-light">
                <tr>
                    <th scope="col">Sno</th>
                    <th scope="col">Lead ID</th>
                    <th scope="col">Campaign ID</th>
                    <th scope="col">Agent ID</th>
                    <th scope="col">Agent Name</th>
                    <th scope="col">Phone Num</th>
                    <th scope="col">INBOUND/OUTBOUND</th>
                    <th scope="col">Created Date/Time</th>
                    <th scope="col">DISPO</th>
                </tr>
            </thead>
            <tbody class="table_result_download">
               
            </tbody>
    </table>
        <?php include('template/footer.php'); ?>
    </div>
    <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Static Backdrop -->
    <!-- Default Modals -->
    <!-- <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#myModal">Standard Modal</button> -->
    <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Dispo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped">
                        <tbody class="dispoAgentDetails">

                        </tbody>
                    </table>
                    <center>
                        <div class="audioRec" id="wrapper">

                        </div>
                    </center>    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary ">Save Changes</button> -->
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

        <div id="myModaltwo" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Dispo Change</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped">
                        <tbody class="dispochangedetails">

                        </tbody>
                    </table>   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary updatedispo">Update</button>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
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

    <!-- Lead Report init -->
    <script src="assets/js/pages/Live-Status-ecommerce.init.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script> -->
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script> -->
    <script src="assets/js/xlsx.full.min.js"></script>
    <script src="assets/js/toastr.min.js"></script>
    <script src="assets/js/autologout.js"></script>
    <script src="assets/js/audioplayer.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
         $('.js-example-basic-multiple').select2();
            var current_username = $("#current_username").val();
            var currentUserRole = $("#current_username").data('role');
            var selectstatus;
            $.ajax({
                url: 'ajax/report/dashboard.php?action=selectcamp',
                type: 'get',
                data: {
                    current_username: current_username
                },
                success: function(response) {
                    console.log(response);
                    var data = JSON.parse(response);
                    if (data.status == 'Ok') {

                        var record = data.data;

                        $('#campaign').html('<option value="">-- Choose Campaign --</option>');
                        record.forEach(function(arr, idx) {

                            $('#campaign').append(`
                                    <option value="${arr.campaign}">${arr.display_name}</option>
                                `);
                        });
                    }
                }
            });
            // var total_count;
            $('body').on('click', '#getRecord', function() {

                var fromdatevalue = $('#startDate').val();
                var todatevalue = $('#endDate').val();
                var slctcampvalue = $('#campaign').val();
                var call_centervalue = $('#call_center').val();
                console.log(call_centervalue);
                $('.table_result').html(`
                    <tr>
                        <td colspan="8" class="text-center">No Record Found</td>
                    </tr>
                `);
                if (startDate == "") {
                    toastr.warning('Please Choose Start date!');
                    $('#startDate').focus();
                } else if (todatevalue == "") {
                    toastr.warning('Please Choose End date!');
                    $('#endDate').focus();
                }
                // else if(slctcampvalue == "")
                // {
                //     toastr.warning('Please Choose a Campaign!');
                //     $('#campaign').focus();
                // }
                else {
                    $.ajax({
                        url: 'ajax/report/leadreport.php?action=getleadtotal',
                        type: 'get',
                        data: {
                            fromdatevalue: fromdatevalue,
                            todatevalue: todatevalue,
                            slctcampvalue: slctcampvalue,
                            call_centervalue: call_centervalue
                        },
                        success: function(response) {
                            console.log(response);
                            if (Array.isArray(response)) {
                                var total_count = response.data[0].staus_cunt_view;
                            } else {
                                // var data = JSON.parse(response);
                                // console.log(data);
                                var total_count = response.data[0].staus_cunt_view;
                                // console.log('no array');

                            }

                            console.log(total_count);
                            handleTotalCount(fromdatevalue, todatevalue, slctcampvalue, total_count, call_centervalue);

                        }
                    });

                }

            });

            function handleTotalCount(fromdatevalue, todatevalue, slctcampvalue, total_count, call_centervalue) {
                $.ajax({
                    url: 'ajax/report/leadreport.php?action=getleadreport',
                    type: 'get',
                    data: {
                        fromdatevalue: fromdatevalue,
                        todatevalue: todatevalue,
                        slctcampvalue: slctcampvalue,
                        call_centervalue: call_centervalue
                    },
                    success: function(response) {
                        console.log(response);
                        console.log(response.data);
                        $('#leadReportResult').html("");
                        $('.listViewTable').html("");
                        var record = response.data;
                        selectstatus = record;

                        record.map(function(arr, idx) {
                            $('#leadReportResult').append(`
                                    <div class="col-xl-2 col-md-2 dispoStatsCard" data-dispo="${arr.status}" style="cursor:pointer;">
                                        <div class="card card-animate overflow-hidden">
                                            <div class="position-absolute start-0" style="z-index: 0;">
                                                <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120">
                                                    <style>
                                                        .s0 {
                                                            opacity: .05;
                                                            fill: var(--vz-secondary)
                                                        }
                                                    </style>
                                                    <path id="Shape 8" class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z"></path>
                                                </svg>
                                            </div>
                                            <div class="card-body" style="z-index:1 ;">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-3">${arr.status}</p>
                                                        <h4 class="fs-22 fw-bold ff-secondary mb-0"><span class="counter-value" data-sta = "${arr.status}"data-target="${arr.staus_cunt}">${arr.staus_cunt}</span></h4>
                                                        
                                                    </div>
                                                    <div class="flex-shrink-0 text-success">
                                                        ` + parseFloat((arr.staus_cunt) / (total_count) * 100).toFixed(2) + `%
                                                    </div>
                                                </div>
                                                <small class="text-secondary">${arr.full_status}</small>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div>
                                `);
                                $('.js-example-basic-multiple').append(`
                                    <option data-dispo="${arr.status}" value="${arr.status}">${arr.status}</option>
                                `);
                            $('.listViewTable').append(`
                                <tr>
                                    <td>${arr.status}</td>
                                    <td>${arr.staus_cunt}</td>
                                </tr>
                            `);

                        });

                        $('#leadReportResult').append(`
                                <div class="col-xl-4 col-md-4">
                                    <div class="card card-animate overflow-hidden">
                                        <div class="position-absolute start-0" style="z-index: 0;">
                                            <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120">
                                                <style>
                                                    .s0 {
                                                        opacity: .05;
                                                        fill: var(--vz-secondary)
                                                    }
                                                </style>
                                                <path id="Shape 8" class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z"></path>
                                            </svg>
                                        </div>
                                        <div class="card-body" style="z-index:1 ;">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-3">Total Count</p>
                                                    <h4 class="fs-22 fw-bold ff-secondary mb-0"><span class="counter-value" data-target="${total_count}">${total_count}</span></h4>
                                                </div>
                                                <!-- <div class="flex-shrink-0">
                                                    10
                                                </div> -->
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div>
                            `);

                        $('.listViewTable').append(`
                                <tr>
                                    <td>Total</td>
                                    <td>${total_count}</td>
                                </tr>
                            `);
                    }
                });
            }

            $('body').on('click', '.dispoStatsCard', function() {
                var dispView = $(this).data('dispo');
                var fromdatedispo = $('#startDate').val();
                var todatedispo = $('#endDate').val();
                var camp = $('#campaign').val();
                var call_center = $('#call_center').val();

                $('.js-example-basic-multiple option[value="' + dispView + '"]').prop('selected', true);
                $('.js-example-basic-multiple').trigger('change');
                $('.table_result').html(`
                    <tr>
                        <td colspan="8" class="text-center">
                        <img src="https://wpamelia.com/wp-content/uploads/2018/11/ezgif-2-6d0b072c3d3f.gif" width="300">
                        </td>
                    </tr>
                   
                `);

                $.ajax({
                    url: 'ajax/report/leadreport.php?action=getdisporeport',
                    type: 'get',
                    data: {
                        fromdatedispo: fromdatedispo,
                        todatedispo: todatedispo,
                        dispView: dispView,
                        camp: camp,
                        call_center: call_center
                    },
                    success: function(response) {
                        console.log(response);
                        var record = response.data;
                        $('.table_result').html("");
                        var sno = 1;
                        record.map(function(arr, idx) {
                            if (arr.comments == "INBOUND") {
                                comment = "INBOUND";
                            } else {
                                comment = "OUTBOUND";
                            }
                            if (currentUserRole == "teamleader" || currentUserRole == "admin" || currentUserRole == "superadmin" || currentUserRole == "qcadmin" || currentUserRole == "support" || currentUserRole === "clientadmin") {
                                var maskedNumber = arr.filename.slice(-10);
                            } else {
                                var actualNum = arr.filename.slice(-10);
                                var maskedNumber = actualNum.substr(0, 3) + 'XXXXXX' + actualNum.substr(8, 2); // Mask certain digits

                            }
                            if (arr.campaign_id == 'EDU_TEST') {
                                var camp_name = 'EDU_TRAINING';
                            } else {
                                var camp_name = arr.campaign_id;
                            }
                            $('.table_result').append(`
                                    <tr>
                                        <td>${sno++}</td>
                                        <td>${arr.lead_id}</td>
                                        <td>${camp_name}</td>
                                        <td>${arr.agent}</td>
                                        <td>${arr.user}</td>
                                        <td style="cursor:pointer;" data-datetime="${arr.event_time}" data-agent="${arr.agent}" data-leadid="${arr.lead_id}" data-campaign_id="${arr.campaign_id}" data-phoneno="${arr.filename.slice(-10)}"  data-dispo="${dispView}" class="dispoBtnchange">${maskedNumber}</td>
                                        <td>${comment}</td>
                                        <td>${arr.event_time}</td>
                                        <td style="cursor:pointer;" data-datetime="${arr.event_time}" data-agent="${arr.agent}" data-leadid="${arr.lead_id}" data-campaign_id="${arr.campaign_id}" data-phoneno="${arr.filename.slice(-10)}"  data-dispo="${dispView}" class="dispoBtn">${dispView}</td>
                                    </tr>
                                `);

                                // $('.table_result_download').append(`
                                //     <tr>
                                //         <td>${sno++}</td>
                                //         <td>${arr.lead_id}</td>
                                //         <td>${camp_name}</td>
                                //         <td>${arr.agent}</td>
                                //         <td>${arr.user}</td>
                                //         <td style="cursor:pointer;" data-datetime="${arr.event_time}" data-agent="${arr.agent}" data-leadid="${arr.lead_id}" data-campaign_id="${arr.campaign_id}" data-phoneno="${arr.filename.slice(-10)}"  data-dispo="${dispView}" class="dispoBtnchange">${maskedNumber}</td>
                                //         <td>${comment}</td>
                                //         <td>${arr.event_time}</td>
                                //         <td style="cursor:pointer;" data-datetime="${arr.event_time}" data-agent="${arr.agent}" data-leadid="${arr.lead_id}" data-campaign_id="${arr.campaign_id}" data-phoneno="${arr.filename.slice(-10)}"  data-dispo="${dispView}" class="dispoBtn">${dispView}</td>
                                //     </tr>
                                // `);
                        });
                    }
                });
            });
            $('body').on('click', '.dispoBtn', function() {
                var leadID = $(this).data('leadid');
                var phoneno = $(this).data('phoneno');
                var campaign_id = $(this).data('campaign_id');
                var dateTime = $(this).data('datetime');
                var agent = $(this).data('agent');
                $('#myModal').modal('show');
                $.ajax({
                    url: 'ajax/report/leadreport.php?action=getDispoDetails',
                    type: 'get',
                    data: {
                        leadID: leadID,
                        campaign_id: campaign_id,
                        phoneno: phoneno
                    },
                    success: function(response) {
                        console.log(response);
                        var record = response.data[0];

                        // Mask phone number
                        var maskedNumber;
                        if (
                            currentUserRole === "teamleader" || currentUserRole === "admin" || currentUserRole === "superadmin" || currentUserRole === "qcadmin" || currentUserRole === "clientadmin"
                        ) {
                            maskedNumber = record.phone_number; // Full number shown
                        } else {
                            var actualNum = record.phone_number;
                            maskedNumber = actualNum.substr(0, 3) + 'XXXXXX' + actualNum.substr(-2); // Show first 3 and last 2 digits
                           // maskedNumber=actualNum;
                        }

                        // Mask address and postal code
                        var maskedAddress, maskedPostal;

                        if (currentUserRole === "clientadmin") {
                            var addressmain = record.address1 || "";
                            var postalcode = record.postal_code || "";

                            var visible_address = addressmain.substring(0, 5);
                            //maskedAddress =  "XXXXX";
                            maskedAddress =  visible_address;

                            //var visible_postal = postalcode.slice(-2);
                            //var hidden_part = "X".repeat(Math.max(0, postalcode.length - 2));
                            //maskedPostal = hidden_part + visible_postal;
                            maskedPostal =postalcode;
                        } else {
                            maskedAddress = record.address1;
                            maskedPostal = record.postal_code;
                        }
                        $('.dispoAgentDetails').html(`
                                <tr>
                                    <th>First Name</th>
                                    <td>${record.first_name}</td>
                                </tr>
                                <tr>
                                    <th>Last Name</th>
                                    <td>${record.last_name}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>${maskedAddress}</td>
                                </tr>
                                <tr>
                                    <th>City</th>
                                    <td>${record.city}</td>
                                </tr>
                                <tr>
                                    <th>State</th>
                                    <td>${record.state}</td>
                                </tr>
                                <tr>
                                    <th>Zip</th>
                                    <td>${maskedPostal}</td>
                                </tr>
                                <tr>
                                    <th>Lead ID</th>
                                    <td>${record.lead_id}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>${maskedNumber}</td>
                                </tr>

                                
                            `);
                        getRecordingStatus(leadID, campaign_id, phoneno, dateTime, agent);
                    }

                });

            });

            // function getDispoAudio(leadID, campaign_id, phoneno, dateTime, agent){
            //     $.ajax({
            //             url: 'ajax/report/leadreport.php?action=getDispoAudio',
            //             type: 'get',
            //             data: {
            //                 leadID:leadID,
            //                 campaign_id:campaign_id,
            //                 phoneno:phoneno,
            //                 dateTime:dateTime
            //             },
            //             success: function(response)
            //             {
            //                 console.log(response);
            //                 getRecordingStatus(leadID, campaign_id, phoneno, dateTime, agent);
            //             }

            //         });
            // }
            function getRecordingStatus(leadID, campaign_id, phoneno, dateTime, agent) {
                $.ajax({
                    url: 'ajax/report/leadreport.php?action=getRecordingStatus',
                    type: 'get',
                    data: {
                        leadID: leadID,
                        campaign_id: campaign_id,
                        phoneno: phoneno,
                        dateTime: dateTime,
                        agent: agent
                    },
                    success: function(response) {
                        console.log('currentresponse', response);
                        // console.log(response.data[0]);
                        var record = response.data[0].location;
                        var recordingpath = response.data[0].recordingpath;
                        var showrecord = response.data[0].showrecord;
                        // console.log(record);

                        if (campaign_id == "EDU_SB" || campaign_id == "EDU_TEST") {
                            var rootPath = 'rec183L';
                        } else if (campaign_id == "EDU_SB1") {
                            var rootPath = 'rec203';
                        } else {
                            var rootPath = recordingpath;

                        }
                        // var audioPath = 
                        var parts = record.split('/');

                        // Get the last part which is the filename
                        var date = parts[parts.length - 2];
                        var filename = parts[parts.length - 1];

                        var audio = rootPath + '/' + date + '/' + filename;
                        // console.log(audio);
                        var currentUserLoggedIN = '<?php echo $logged_in_user_name; ?>';
                        console.log('currentuserrole', currentUserRole);

                        if (currentUserLoggedIN != 'SHOW' && currentUserLoggedIN != 'PSPM') {

                            if (showrecord == 1 || currentUserRole == 'superadmin' || currentUserRole == 'teamleader' || currentUserLoggedIN == 'ZD15' || currentUserRole == 'clientadmin') {

                                $('.audioRec').html(`
                                        <audio class="getthisaudio" preload="metadata" controls>
                                            <source src="` + audio + `"  type="audio/mpeg">
                                        </audio>
                                    `);
                                // $(".getthisaudio source").attr("src", audio);
                                $(".getthisaudio")[0].load(); // Reload the new source
                            }


                        }


                        // getRecordingStatus(leadID, campaign_id, phoneno, dateTime);
                    }

                }).then(function() {
                    let audioElement = $(".getthisaudio")[0];
                    setTimeout(() => {
                        if (isNaN(audioElement.duration) || audioElement.duration === Infinity) {
                            console.log("Metadata not loaded, forcing reload...");
                            audioElement.load();
                        }
                    }, 1000);
                });
            }
            // $('body').on('click', '#export_excel', function () {
            //     var startDate = $('#startDate').val();
            //     var campaign_name = $('#campaign').val();

            //     if (campaign_name == 'FTE_ALL') {
            //         campaign_name = 'EDU_SB_ALL';
            //     }

            //     var fileName = campaign_name + ' - ' + startDate;
            //     var table = document.getElementById('export_table');

            //     // Convert table to worksheet
            //     var ws = XLSX.utils.table_to_sheet(table);

            //     // Format 8th column (index 7 = column H) as 'YYYY-MM-DD HH:mm:ss'
            //     var range = XLSX.utils.decode_range(ws['!ref']);
            //     for (var row = range.s.r + 1; row <= range.e.r; ++row) { // Skip header
            //         var cellAddress = { c: 7, r: row }; // 8th column = index 7
            //         var cellRef = XLSX.utils.encode_cell(cellAddress);
            //         var cell = ws[cellRef];

            //         if (cell && cell.v) {
            //             let raw = cell.v;
            //             let dateObj;

            //             if (!isNaN(raw)) {
            //                 // If raw is numeric, assume it's epoch seconds
            //                 dateObj = new Date(parseInt(raw) * 1000);
            //             } else {
            //                 // Otherwise, try to parse as a date string
            //                 dateObj = new Date(raw);
            //             }

            //             if (!isNaN(dateObj)) {
            //                 let formatted =
            //                     dateObj.getFullYear() + '-' +
            //                     String(dateObj.getMonth() + 1).padStart(2, '0') + '-' +
            //                     String(dateObj.getDate()).padStart(2, '0') + ' ' +
            //                     String(dateObj.getHours()).padStart(2, '0') + ':' +
            //                     String(dateObj.getMinutes()).padStart(2, '0') + ':' +
            //                     String(dateObj.getSeconds()).padStart(2, '0');

            //                 cell.v = formatted;
            //                 cell.t = 's'; // Mark as string
            //             }
            //         }
            //     }

            //     var wb = XLSX.utils.book_new();
            //     XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
            //     XLSX.writeFile(wb, fileName + '.xlsx');
            // });
            $('#export_excel').on('click', function() {

                var multi_dispo = $('.js-example-basic-multiple').val();
                var type_of_report = $('#type_dl').val();
                var fromdatedispo = $('#startDate').val();
                var todatedispo = $('#endDate').val();
                var camp = $('#campaign').val();
                var call_center = $('#call_center').val();
               var all_dl_report = [];

                    const promises = multi_dispo.map(function(dispo) {
                        return $.ajax({
                            url: 'ajax/report/leadreport.php?action=getdisporeport',
                            type: 'get',
                            data: {
                                fromdatedispo,
                                todatedispo,
                                dispo,
                                camp,
                                call_center
                            }
                        }).then(function(response) {
                            if (response && response.data) {
                                all_dl_report = all_dl_report.concat(response.data);
                            }
                        });
                    });

                    Promise.all(promises).then(function() {
                        console.log('All dispo reports fetched');
                        let grouped = {};

                        // Group by either date or dispo
                        all_dl_report.forEach(arr => {
                            let groupKey = type_of_report === "Date"
                                ? arr.event_time.split(" ")[0]  // Only the date part
                                : arr.status;                  // Disposition value

                            if (!grouped[groupKey]) grouped[groupKey] = [];
                            grouped[groupKey].push(arr);
                        });

                        $('.table_result_download').html("");
                        let sno = 1;

                        Object.keys(grouped).forEach(groupKey => {
                            // Add header row for new date/dispo group
                            $('.table_result_download').append(`
                                <tr><td colspan="9" style="background:#f0f0f0; font-weight:bold;">
                                    ${type_of_report === "Date" ? 'Date: ' : 'Dispo: '}${groupKey}
                                </td></tr>
                            `);

                            grouped[groupKey].forEach(arr => {
                                const comment = arr.comments === "INBOUND" ? "INBOUND" : "OUTBOUND";
                                const maskedNumber = (
                                    currentUserRole === "teamleader" || currentUserRole === "admin" || 
                                    currentUserRole === "superadmin" || currentUserRole === "qcadmin" || 
                                    currentUserRole === "support" || currentUserRole === "clientadmin"
                                )
                                    ? arr.filename.slice(-10)
                                    : arr.filename.slice(-10).substr(0, 3) + 'XXXXXX' + arr.filename.slice(-10).substr(8, 2);

                                const camp_name = arr.campaign_id === 'EDU_TEST' ? 'EDU_TRAINING' : arr.campaign_id;

                                $('.table_result_download').append(`
                                    <tr>
                                        <td>${sno++}</td>
                                        <td>${arr.lead_id}</td>
                                        <td>${camp_name}</td>
                                        <td>${arr.agent}</td>
                                        <td>${arr.user}</td>
                                        <td style="cursor:pointer;" data-datetime="${arr.event_time}" data-agent="${arr.agent}" data-leadid="${arr.lead_id}" data-campaign_id="${arr.campaign_id}" data-phoneno="${arr.filename.slice(-10)}" data-dispo="${arr.status}" class="dispoBtnchange">${maskedNumber}</td>
                                        <td>${comment}</td>
                                        <td>${arr.event_time}</td>
                                        <td style="cursor:pointer;" data-datetime="${arr.event_time}" data-agent="${arr.agent}" data-leadid="${arr.lead_id}" data-campaign_id="${arr.campaign_id}" data-phoneno="${arr.filename.slice(-10)}" data-dispo="${arr.status}" class="dispoBtn">${arr.status}</td>
                                    </tr>
                                `);
                            });
                        });
                    });


                // var table = document.getElementById('export_table');
                // var rows = table.querySelectorAll('tr');
                // var data = [];

                // rows.forEach(row => {
                //     var rowData = [];
                //     row.querySelectorAll('th, td').forEach(cell => {
                //         let text = cell.innerText;

                //         // Optional: convert timestamp string to Date object
                //         if (/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/.test(text)) {
                //             rowData.push(new Date(text)); // or keep as string if preferred
                //         } else {
                //             rowData.push(text);
                //         }
                //     });
                //     data.push(rowData);
                // });

                // var ws = XLSX.utils.aoa_to_sheet(data);
                // var wb = XLSX.utils.book_new();
                // XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

                // var startDate = $('#startDate').val();
                // var campaign_name = $('#campaign').val();
                // if (campaign_name === 'FTE_ALL') campaign_name = 'EDU_SB_ALL';
                // var fileName = campaign_name + ' - ' + startDate;

                // XLSX.writeFile(wb, fileName + '.xlsx');
            });

            // $('body').on('click', '#export_excel', function(){

            //     var startDate = $('#startDate').val();
            //     var campaign_name = $('#campaign').val();

            //     if(campaign_name == 'FTE_ALL')
            //     {
            //         var campaign_name = 'EDU_SB_ALL';
            //     }

            //     var fileName = campaign_name+' - '+startDate;
            //         var table = document.getElementById('export_table');
            //         var ws = XLSX.utils.table_to_sheet(table);
            //         var wb = XLSX.utils.book_new();
            //         XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
            //         XLSX.writeFile(wb, fileName+'.xlsx');
            // });
            $('body').on('click', '#listViewExportTablebtn', function() {

                var startDate = $('#startDate').val();
                var campaign_name = $('#campaign').val();

                if (campaign_name == 'FTE_ALL') {
                    var campaign_name = 'EDU_SB_ALL';
                }
                var fileName = campaign_name + ' - ' + startDate;
                var table = document.getElementById('listViewExportTable');
                var ws = XLSX.utils.table_to_sheet(table);
                var wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
                XLSX.writeFile(wb, fileName + '.xlsx');
            });

            if(currentUserRole =='clientadmin'){

                $('body').on('click', '.dispoBtnchange', function() {
                var leadID = $(this).data('leadid');
                var phoneno = $(this).data('phoneno');
                var campaign_id = $(this).data('campaign_id');
                var dateTime = $(this).data('datetime');
                var agent = $(this).data('agent');
                var dispView = $(this).data('dispo');
                // console.log('status',selectstatus);
               
          

                 let statusSelect = `<select id="new_status" class="form-control">`;
                 statusSelect +=`<option value="">Select Any Status</option>`;

                    selectstatus.forEach(arr => {
                        statusSelect += `<option value="${arr.status}">${arr.status}</option>`;
                    });

                    statusSelect += `</select>`;

                                        
               


                

                $('#myModaltwo').modal('show');


                        $('.dispochangedetails').html(`
                                <tr>
                                    <th>Lead Id</th>
                                    <td>${leadID}</td>
                                </tr>
                                <tr>
                                    <th>Phone Number</th>
                                    <td>${phoneno}</td>
                                </tr>
                                <tr>
                                    <th>Campaign Id</th>
                                    <td>${campaign_id}</td>
                                </tr>
                                 <tr>
                                    <th>Current Status</th>
                                    <td>${dispView}</td>
                                 </tr>

                                <tr>
                                    <th>Status</th>
                                    <td>${statusSelect}</td>
                                 </tr> `);

                        $('body').on('click', '.updatedispo', function() {


                            
                            var new_status = $('#new_status').val();

                                 // console.log('sajith',new_status);



                            $.ajax({
                                                url: 'ajax/report/leadreport.php?action=updateDispoDetails',
                                                type: 'get',
                                                data: {
                                                    leadID: leadID,
                                                    campaign_id: campaign_id,
                                                    phoneno: phoneno,
                                                    new_status:new_status
                                                },
                                                success: function(response) {
                                                    // console.log(response);
                                                     if(response.status='success'){


                                                        toastr.success('Disposition updated successfully');
                                                        $('#myModaltwo').modal('hide')
                                                         location.reload(); 

                                                        // $('.dispoBtnchange[data-leadid="' + leadID + '"]').closest('tr').remove();


                                                       // Get current count for the status
                                                    // var newcount = $('#leadReportResult .counter-value [data-sta="' + new_status + '"]').text().trim();

                                                    // alert(newcount);
                                                    // var addcount = parseInt(newcount); // fallback to 0 if not a number

                                                    // // Increment and update the count
                                                    // $('.counter-value [data-sta="' + new_status + '"]').text(addcount + 1);

                                                      // console.log($('#leadReportResult').html());




                                                        


                                                     }



                                                }

                                });




                        });





            });

            }


        });
        // $(function() {
        //                             $('audio').audioPlayer();
        //                     });
    </script>

</body>


</html>