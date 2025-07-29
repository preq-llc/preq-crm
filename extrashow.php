<?php
    $page = 'dialreport';
    include('config.php');
    include('function/session.php');
    
?>
<input type="text" id="current_username" value="<?php echo $logged_in_user_name;?>" data-role="<?php echo $logged_in_user_role;?>" hidden>
<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">


<head>

    <meta charset="utf-8" />
    <title>Lead Report | <?php echo $site_name;?> - Dialer CRM</title>
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

</head>
<style>
    .counter-value
    {
        font-size: 30px;
    }
</style>
<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

<?php include('template/header.php');?>

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
        <?php include('template/navbar.php');?>
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
                                                <!-- <h4 class="fs-16 mb-1">Hello, <?php echo $logged_in_user_name;?>!</h4>
                                                <p class="text-muted mb-0">Get Current Lead Report on this Page.</p> -->
                                                <!-- <button class="btn d-block mt-3 btn-soft-danger" id="listViewExportTablebtn">Export List View</button> -->
                                                <!-- <button class="btn btn-primary" type="button" disabled>
                                                        <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                                                        Loading...
                                                </button> -->
                                                 <?php
                                                    if($logged_in_user_role == 'superadmin')
                                                    {
                                                        // echo ''
                                                        echo '<button class="btn d-block mt-3 btn-soft-danger" id="listViewExportTablebtn">Export Dispo Report</button>';
                                                    }
                                                 ?>
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
                                                                <input type="date" id="startDate" value="<?php echo $today_date;?>" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <div class="form-group">
                                                                <label for="">End date</label>
                                                                <input type="date" id="endDate" value="<?php echo $today_date;?>" class="form-control">
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
                                                                    // if ($logged_in_user_role == 'teamleader' || $logged_in_user_role == 'qc' || $logged_in_user_role == 'qcadmin') {
                                                                    //     if($logged_in_user_group == 'Unknown')
                                                                    //     {
                                                                    //         echo ' <option value="" selected>-- All Center --</option><option value="' . $logged_in_user_group . '">' . $logged_in_user_group . '</option>';
                                                                    //     }
                                                                    //     else
                                                                    //     {
                                                                    //         echo '<option value="' . $logged_in_user_group . '">' . $logged_in_user_group . '</option>';
                                                                    //     }
                                                                    // } else {
                                                                    //     // echo '
                                                                    //     //     <option value="">-- Choose Center --</option>
                                                                    //     //     <option value="EXI">EXIMIO</option>
                                                                    //     //     <option value="WIN">WINGSPAN</option>
                                                                    //     //     <option value="ZD">ZEALOUS</option>
                                                                    //     // ';
                                                                    // }
                                                                    // echo '<option value="" selected>-- Choose Center --</option>';

                                                                    // $single_callcenter = explode(",", $logged_in_user_group);
                                                                    // foreach ($single_callcenter as $center) {
                                                                    //     echo '<option value="' . trim($center) . '">' . trim($center) . '</option>';
                                                                    // }

                                                                
                                                                    // echo $single_callcenter;
                                                                    $single_callcenter = explode(",", $logged_in_user_group);
                                                                    // print_r($single_callcenter);
                                                                    if($logged_in_user_role == "teamleader" || $logged_in_user_role == "superadmin")
                                                                    {
                                                                        echo '<option value="" selected>-- ALL --</option>';
                                                                    }
                                                                        $centercount = 0;
                                                                        foreach ($single_callcenter as $center) {
                                                                            if($center)
                                                                            {
                                                                                echo '<option value="' . trim($center) . '">' . trim($center) . '</option>';
                                                                            }
                                                                            $centercount++;
                                                                        }
                                                                        if($centercount == 0)
                                                                        {
                                                                            echo '<option value="" selected>-- Choose Center --</option>';
                                                                        }
                                                                
                                                            
                                                                    
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button" class="btn btn-soft-success mt-3" id="getRecord"><i class="ri-add-circle-line align-middle me-1"></i>
                                                                Get Report
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
                                            <div class="col-5">
                                                <div class="col-xl-12 col-md-2 totalDialCard" data-dispo="" style="cursor:pointer;">
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
                                                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-3">TotalDial</p>
                                                                    <h4 class="fs-22 fw-bold ff-secondary mb-0"><span class="totaldial_count counter-value" data-target=""></span></h4>
                                                                    
                                                                </div>
                                                                <!-- <div class="flex-shrink-0 text-success">
                                                                    0
                                                                </div> -->
                                                            </div>
                                                            <!-- <small class="text-secondary">${arr.full_status}</small> -->
                                                        </div><!-- end card body -->
                                                    </div><!-- end card -->
                                                </div>
                                                <!-- <div class="col-xl-12 col-md-2 totalDialCard" data-dispo="" style="cursor:pointer;">
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
                                                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-3">DPH</p>
                                                                    <h4 class="fs-22 fw-bold ff-secondary mb-0"><span class="dph_count counter-value" data-target=""></span></h4>
                                                                    
                                                                </div>
                                                                <div class="flex-shrink-0 text-success">
                                                                    0
                                                                </div>
                                                            </div>
                                                          
                                                        </div>
                                                    </div>
                                                </div> -->
                                            </div>
                                            <div class="col-7">
                                                <div class="card">
                                                    <div class="card-header align-items-center d-flex">
                                                        <h4 class="card-title mb-0 flex-grow-1">DIAL ATTEMPT</h4>
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
                                                                        <th scope="col">List ID</th>
                                                                        <th scope="col">List Description</th>
                                                                        
                                                                        <th scope="col">Dialed Count</th>
                                                                        <th scope="col">Submit</th>
                                                                        <th scope="col">Highest Attempt</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="table_result">
                                                                    <tr>
                                                                        <td colspan="3" class="text-center">No Record Found</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table><!-- end table -->
                                                        </div>
                                                    </div>
                                                </div> <!-- .card-->
                                            </div>
                                        </div><!--end row-->
                                    </div>
                            </div>
                                </div>
                            </div> <!-- end .h-100-->
                        </div> <!-- end col -->
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                                
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
                        <th>Status</th>
                        <th>Description</th>
                        <th>Calls</th>
                    </tr>
                </thead>
                <tbody class="listViewTable">

                </tbody>
            </table>
            <?php include('template/footer.php');?>
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
              <div class="audioRec" id="wrapper">
                    <audio class="getthisaudio" preload="metadata" controls>
                        <source src="/"  type="audio/mpeg">
                    </audio>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary ">Save Changes</button> -->
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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
         $(document).ready(function(){
            var current_username = $("#current_username").val();
            var currentUserRole = $("#current_username").data('role');

            $.ajax({
                    url: 'ajax/report/dashboard.php?action=selectcamp',
                    type: 'get',
                    data: {
                        current_username:current_username
                    },
                    success: function(response)
                    {
                        console.log(response);
                        var data = JSON.parse(response);
                        if (data.status == 'Ok') {
                            
                            var record = data.data;
                            
                            $('#campaign').html('<option value="">-- Choose Campaign --</option>');
                            record.forEach(function(arr, idx){
                              
                                $('#campaign').append(`
                                    <option value="${arr.campaign}">${arr.display_name}</option>
                                `);
                            });
                        }
                    }
                });
                // var total_count;
            $('body').on('click','#getRecord', function(){

                $('.totaldial_count').html('');
              
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
                if(startDate == "")
                {
                    toastr.warning('Please Choose Start date!');
                    $('#startDate').focus();
                }
                else if(todatevalue == "")
                {
                    toastr.warning('Please Choose End date!');
                    $('#endDate').focus();
                }
                // else if(slctcampvalue == "")
                // {
                //     toastr.warning('Please Choose a Campaign!');
                //     $('#campaign').focus();
                // }
                else
                {
                    $.ajax({
                            url: 'ajax/report/leadreport.php?action=extrashow',
                            type: 'get',
                            data: {
                                fromdatevalue:fromdatevalue,
                                todatevalue:todatevalue,
                                slctcampvalue:slctcampvalue,
                                call_centervalue:call_centervalue
                            },
                            success: function(response)
                            {

                                console.log(response);
                                $('.totaldial_count').html(response.total_dial);
                                var dphcount = response.total_dial / response.Hrs;
                                $('.dph_count').html(dphcount.toFixed(2));

                                var mainData = response.data;
                                var extraData = response.additionaldata;

                                // Create a map for quick lookup by list_id from extraData
                                var extraMap = {};
                                extraData.forEach(function(item) {
                                    extraMap[item.list_id] = item;
                                });

                                $('.table_result').html('');
                                // $('.totaldial_count').html('');

                                mainData.map(function(arr, idx) {
                                    var listId = arr.list_id;
                                    var extra = extraMap[listId] || {}; // fallback if not found

                                    $('.table_result').append(`
                                        <tr>
                                            <td>${idx + 1}</td>
                                            <td>${listId}</td>
                                            <td>${arr.list_description || '-'}</td>
                                            <td>${extra.duplicate_count || 0}</td>
                                            <td>${extra.Submit || 0}</td>
                                            <td>${arr.resets_today || 0}</td>
                                        </tr>
                                    `);
                                });



                            }
                        });

                }
                
            });
            function handleTotalCount(fromdatevalue,todatevalue,slctcampvalue,total_count,call_centervalue) {
                $.ajax({
                        url: 'ajax/report/leadreport.php?action=getleadreport',
                        type: 'get',
                        data: {
                            fromdatevalue:fromdatevalue,
                            todatevalue:todatevalue,
                            slctcampvalue:slctcampvalue,
                            call_centervalue:call_centervalue
                        },
                        success: function(response)
                        {
                            console.log(response);
                            console.log(response.data);
                            $('#leadReportResult').html("");
                            $('.listViewTable').html("");
                            var record = response.data;
                            record.map(function(arr, idx){
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
                                                        <h4 class="fs-22 fw-bold ff-secondary mb-0"><span class="counter-value" data-target="${arr.staus_cunt}">${arr.staus_cunt}</span></h4>
                                                        
                                                    </div>
                                                    <div class="flex-shrink-0 text-success">
                                                        `+parseFloat((arr.staus_cunt)/(total_count)*100).toFixed(2)+`%
                                                    </div>
                                                </div>
                                                <small class="text-secondary">${arr.full_status}</small>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div>
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
            
            $('body').on('click', '.dispoStatsCard', function(){
                var dispView = $(this).data('dispo');
                var fromdatedispo = $('#startDate').val();
                var todatedispo = $('#endDate').val();
                var camp = $('#campaign').val();
                var call_center = $('#call_center').val();
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
                            fromdatedispo:fromdatedispo,
                            todatedispo:todatedispo,
                            dispView:dispView,
                            camp:camp,
                            call_center:call_center
                        },
                        success: function(response)
                        {
                            console.log(response);
                            var record = response.data;
                            $('.table_result').html("");
                            var sno = 1;
                            record.map(function(arr, idx){
                                if(arr.comments =="INBOUND"){
                                comment ="INBOUND";
                                }else {
                                    comment ="OUTBOUND";
                                }
                                if(currentUserRole == "teamleader" || currentUserRole == "admin" || currentUserRole == "superadmin" || currentUserRole == "qcadmin"|| currentUserRole == "support")
                                {
                                    var maskedNumber = arr.filename.slice(-10);
                                }
                                else
                                {
                                    var actualNum = arr.filename.slice(-10);
                                    var maskedNumber = actualNum.substr(0, 3) + 'XXXXXX' + actualNum.substr(8, 2); // Mask certain digits

                                }
                                if(arr.campaign_id == 'EDU_TEST')
                                {
                                    var camp_name = 'EDU_TRAINING';
                                }
                                else
                                {
                                    var camp_name = arr.campaign_id;
                                }
                                $('.table_result').append(`
                                    <tr>
                                        <td>${sno++}</td>
                                        <td>${arr.lead_id}</td>
                                        <td>${camp_name}</td>
                                        <td>${arr.agent}</td>
                                        <td>${arr.user}</td>
                                        <td>${maskedNumber}</td>
                                        <td>${comment}</td>
                                        <td>${arr.event_time}</td>
                                        <td style="cursor:pointer;" data-datetime="${arr.event_time}" data-agent="${arr.agent}" data-leadid="${arr.lead_id}" data-campaign_id="${arr.campaign_id}" data-phoneno="${arr.filename.slice(-10)}"  class="dispoBtn">${dispView}</td>
                                    </tr>
                                `);
                            });
                        }
                    });
            });
            $('body').on('click', '.dispoBtn', function(){
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
                            leadID:leadID,
                            campaign_id:campaign_id,
                            phoneno:phoneno
                        },
                        success: function(response)
                        {
                            console.log(response);
                            var record = response.data[0];
                            if(currentUserRole == "teamleader" || currentUserRole == "admin" || currentUserRole == "superadmin" || currentUserRole == "qcadmin")
                            {
                                var maskedNumber = record.phone_number;
                            }
                            else
                            {
                                var actualNum = record.phone_number;
                                var maskedNumber = actualNum.substr(0, 3) + 'XXXXXX' + actualNum.substr(8, 2); // Mask certain digits

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
                                    <td>${record.address1}</td>
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
                                    <td>${record.postal_code}</td>
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
            function getRecordingStatus(leadID, campaign_id, phoneno, dateTime, agent){
                $.ajax({
                        url: 'ajax/report/leadreport.php?action=getRecordingStatus',
                        type: 'get',
                        data: {
                            leadID:leadID,
                            campaign_id:campaign_id,
                            phoneno:phoneno,
                            dateTime:dateTime,
                            agent:agent
                        },
                        success: function(response)
                        {
                            // console.log(response);
                            // console.log(response.data[0]);
                            var record = response.data[0].location;
                            var recordingpath = response.data[0].recordingpath;
                            // console.log(record);

                            if(campaign_id == "EDU_SB" || campaign_id == "EDU_TEST")
                            {
                                var rootPath = 'rec183L';
                            }
                            else if(campaign_id == "EDU_SB1")
                            {
                                var rootPath = 'rec203';
                            }
                            else
                            {
                                var rootPath = recordingpath ;

                            }
                            // var audioPath = 
                            var parts = record.split('/');

                            // Get the last part which is the filename
                            var date = parts[parts.length - 2];
                            var filename = parts[parts.length - 1];

                            var audio = rootPath+'/'+date+'/'+filename;
                            console.log(audio);
                            var currentUserLoggedIN = '<?php echo $logged_in_user_name;?>';
                            if(currentUserLoggedIN != 'SHOW')
                            {
                                // $('.getthisaudio').html(`
                                //      <source src="`+ audio +`"  type="audio/mpeg">
                                // `);
                                $(".getthisaudio source").attr("src", audio);
                                $(".getthisaudio")[0].load(); // Reload the new source
                                
                            }
                            
                            // getRecordingStatus(leadID, campaign_id, phoneno, dateTime);
                        }

                    }).then(function(){
                        let audioElement = $(".getthisaudio")[0];
                                setTimeout(() => {
                                    if (isNaN(audioElement.duration) || audioElement.duration === Infinity) {
                                        console.log("Metadata not loaded, forcing reload...");
                                        audioElement.load();
                                    }
                                }, 1000);
                    });
            }
                $('body').on('click', '#export_excel', function(){

                    var startDate = $('#startDate').val();
                    var campaign_name = $('#campaign').val();

                    if(campaign_name == 'FTE_ALL')
                    {
                        var campaign_name = 'EDU_SB_ALL';
                    }

                    var fileName = campaign_name+' - '+startDate;
                        var table = document.getElementById('export_table');
                        var ws = XLSX.utils.table_to_sheet(table);
                        var wb = XLSX.utils.book_new();
                        XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
                        XLSX.writeFile(wb, fileName+'.xlsx');
                });
                $('body').on('click', '#listViewExportTablebtn', function(){

                    var startDate = $('#startDate').val();
                    var campaign = $('#campaign').val();
                    var endDate = $('#endDate').val();
                    console.log('clicked');
                    var thisBtn = $(this);
                    thisBtn.html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...').attr('disabled', true);
                    if(campaign == "")
                    {
                        toastr.warning('Please Choose Campaign PK bro!');
                        thisBtn.html('Export Dispo Status').attr('disabled', false);

                    }
                    else
                    {
                        $.ajax({
                            url: 'ajax/report/leadreport.php?action=getdipoList',
                            type: 'get',
                            data: {
                                startDate:startDate,
                                campaign:campaign,
                                endDate:endDate
                            },
                            success: function(response)
                            {
                                console.log(response);
                                $('.listViewTable').html("");
                                let totalDialCount = 0;
                                response.data.map(function(arr, idx){
                                    $('.listViewTable').append(`
                                        <tr>
                                            <td>${arr.status}</td>
                                            <td>${arr.description}</td>
                                            <td>${arr.total_count}</td>
                                        </tr>
                                    `);

                                    totalDialCount+=parseInt(arr.total_count);
                                });
                                
                                    $('.listViewTable').append(`
                                        <tr>
                                            <td colspan="2">Total Dial</td>
                                            <td>${totalDialCount}</td>
                                        </tr>
                                    `);
                                    // console.log(totalDialCount);
                                    
                                setTimeout(function() {
                                    var fileName = 'Dispo stats-' + campaign + '-' + startDate;
                                    var table = document.getElementById('listViewExportTable');
                                    var ws = XLSX.utils.table_to_sheet(table);
                                    var wb = XLSX.utils.book_new();
                                    XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
                                    XLSX.writeFile(wb, fileName + '.xlsx');
                                }, 500);
                                thisBtn.html('Export Dispo Status').attr('disabled', false);

                            }

                        });
                    }
                   

                    // if(campaign_name == 'FTE_ALL')
                    // {
                    //     var campaign_name = 'EDU_SB_ALL';
                    // }
                    // var fileName = campaign_name+' - '+startDate;
                    //     var table = document.getElementById('listViewExportTable');
                    //     var ws = XLSX.utils.table_to_sheet(table);
                    //     var wb = XLSX.utils.book_new();
                    //     XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
                    //     XLSX.writeFile(wb, fileName+'.xlsx');
                });
            
        });
        // $(function() {
        //                             $('audio').audioPlayer();
        //                     });
    </script>

</body>


</html>