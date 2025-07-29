<?php
$page = 'aiqareport';
include('config.php');
include('function/session.php');

$fromdate  = isset($_GET['fromdate'])  ? trim($_GET['fromdate'])  : $today_date;
$todate    = isset($_GET['todate'])    ? trim($_GET['todate'])    : $today_date;
$campaign  = isset($_GET['campaign'])  ? trim($_GET['campaign'])  : '';
$agent     = isset($_GET['agent'])     ? trim($_GET['agent'])     : '';


?>
<input type="text" id="current_username" value="<?php echo $logged_in_user_name; ?>" data-role="<?php echo $logged_in_user_role; ?>" hidden>
<input type="text" id="campaign_id_get" value="<?php echo $campaign; ?>" hidden>
<!doctype html>
<input type="text" id="agent_id_get" value="<?php echo $agent; ?>" hidden>
<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">


<head>

    <meta charset="utf-8" />
    <title>Ai QA Report | <?php echo $site_name; ?> - Dialer CRM</title>
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

    .clicked-row {
    background-color: #dcf6e9 !important;
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
                                                 <h4 class="fs-16 mb-1">Hello, <?php echo $logged_in_user_name; ?>!</h4>
                                                <p class="text-muted mb-0">Get Current Ai QA Report on this Page.</p> 
                                                <!-- <button class="btn d-block mt-3 btn-soft-danger" id="listViewExportTablebtn">Export List View</button> -->
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
                                                                <input type="date" id="startDate" value="<?php echo $fromdate ?>" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <div class="form-group">
                                                                <label for="">End date</label>
                                                                <input type="date" id="endDate" value="<?php echo $todate ?>" class="form-control">
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
                                                         <div class="col-sm-auto" style="display: grid">
                                                            <label for="">Agent Name</label>

                                                            <select name="" id="agent_name" class="form-select js-example-basic-multiples">
                                                              
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
                                    <h4 class="card-title mb-0 flex-grow-1">QA Report</h4>
                                    <div class="flex-shrink-0">
                                        
                                        <button type="button" id="export_excel" class="btn btn-soft-info btn-sm">
                                            <i class="ri-file-list-3-line align-middle"></i> Download Report
                                        </button>
                                    </div>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <table id="export_table" class="table table-hover table-borderless table-centered align-middle table-nowrap mb-0">
                                            <thead class="text-muted table-light">
                                                <tr>
                                                    <th scope="col">Sno</th>
                                                    <th scope="col">Lead ID</th>
                                                    <th scope="col">Campaign ID</th>
                                                    <th scope="col">Agent ID</th>
                                                    <th scope="col">Agent Name</th>
                                                    <th scope="col">Phone Num</th>
                                                    <th scope="col">Call DISPO</th>
                                                    <th scope="col">Ai Score</th>
                                                    <th scope="col">Ai DISPO</th>
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
        <?php include('template/footer.php'); ?>
    </div>
    <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Static Backdrop -->
    <!-- Default Modals -->
    <!-- <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#myModal">Standard Modal</button> -->


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
    <div class="offcanvas offcanvas-end" id="demo" style="width: 50%;" tabindex="-1" aria-labelledby="demoLabel">
          <div class="offcanvas-header">
            <h3 class="offcanvas-title" id="demoLabel">Recording Details</h3>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>

          <div class="offcanvas-body">
            <!-- Audio Player and Info -->
            <div class="row text-center">
              <div class="col-12 py-3">
                <div class="row">
                  <!-- Customer Details Table -->
                  <div class="col-6 details_table">
                    <table class="table table-striped table-hover">
                      <thead>
                        <tr class="text-center">
                          <th>Customer Name</th>
                          <th>Lead Id</th>
                          <th>Agent Name</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- Populated dynamically by JS -->
                      </tbody>
                    </table>
                  </div>

                  <!-- Sentiment Table -->
                  <div class="col-6 spandetails">
                    <table class="table table-striped table-hover">
                      <thead>
                        <tr class="text-center">
                          <th>Tone</th>
                          <th>Agreement</th>
                          <th>Polarity</th>
                          <th>Subjectivity</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- Populated dynamically by JS -->
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <!-- Audio Player -->
              <div class="col-12 py-3">
                <div class="audio_player">
                  <audio controls class="w-100">
                    <source src="" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio>
                </div>
              </div>

              <!-- Sentiment Badges -->
              <div class="col-12 py-3">
                <!-- Populated dynamically by JS -->
              </div>
            </div>

            <!-- Transcript Table -->
            <style>
              .transcript_table {
                max-height: 600px;
                overflow-y: auto;
              }
            </style>
            <div class="col-12 transcript_table">
              <table class="table table-borderless table-striped table-hover">
                <thead>
                  <tr class="text-center">
                    <th>Start</th>
                    <!-- <th>Person</th> -->
                    <th>Transcript Data</th>
                    <th>End</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Populated dynamically by JS -->
                </tbody>
              </table>
            </div>
          </div>
    </div>


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
         $('.js-example-basic-multiples').select2();
            var current_username = $("#current_username").val();
            var currentUserRole = $("#current_username").data('role');
            var campaign = $('#campaign_id_get').val();
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
                          
                             let selected = (arr.campaign === campaign) ? 'selected' : '';
                            $('#campaign').append(`
                                    <option value="${arr.campaign}" ${selected}>${arr.display_name}</option>
                                `);

                            $('#campaign').trigger('change');
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
                var agent_id = $('#agent_name').val();
                // console.log(call_centervalue);
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
                else if(slctcampvalue == "")
                {
                    toastr.warning('Please Choose a Campaign!');
                    $('#campaign').focus();
                }
                else {

                $.ajax({
                    url: 'ajax/report/ai_qa_report.php?action=getcount',
                    type: 'get',
                    data: {
                        fromdatevalue: fromdatevalue,
                        todatevalue: todatevalue,
                        slctcampvalue: slctcampvalue,
                        call_centervalue: call_centervalue,
                        agent_id:agent_id
                    },
                    success: function(response) {
                        console.log(response);
                        console.log(response.data);
                        $('#leadReportResult').html("");
                       
                        var record = response
                        // selectstatus = record;

                       record.forEach(function(arr, idx) {
                        $('#leadReportResult').append(`
                            <div class="col-xl-2 col-md-2 dispoStatsCard" data-dispo="${arr.status}" style="cursor:pointer;">
                                <div class="card card-animate overflow-hidden">
                                    <div class="position-absolute start-0" style="z-index: 0;">
                                        <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120">
                                            <style>
                                                .s0 { opacity: .05; fill: var(--vz-secondary); }
                                            </style>
                                            <path class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z"></path>
                                        </svg>
                                    </div>
                                    <div class="card-body" style="z-index:1;">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-3">${arr.name}</p>
                                                <h4 class="fs-22 fw-bold ff-secondary mb-0">
                                                    <span class="counter-value" data-sta="${arr.status}" data-target="${arr.count}">${arr.count}</span>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);

                        $('.js-example-basic-multiple').append(`
                            <option data-dispo="${arr.status}" value="${arr.status}">${arr.name}</option>
                        `);
                    });

                    }
                });
                   

                }
            });

            //table appending report

            $('body').on('click', '.dispoStatsCard', function() {
                current_username = $("#current_username").val();
                var dispView = $(this).data('dispo');
                var fromdatedispo = $('#startDate').val();
                var todatedispo = $('#endDate').val();
                var camp = $('#campaign').val();
                var call_center = $('#call_center').val();
                var agent_id = $('#agent_name').val();

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
                    url: 'ajax/report/ai_qa_report.php?action=getdisporeport',
                    type: 'get',
                    data: {
                        fromdatedispo: fromdatedispo,
                        todatedispo: todatedispo,
                        dispView: dispView,
                        camp: camp,
                        call_center: call_center,
                        agent_id:agent_id,
                    },
                    success: function(response) {


                        var record = response;

                        $('.table_result').html("");
                        var sno = 1;
                        record.map(function(arr, idx) {
                            var aistatus = arr.ai_status
                            var aistatusnew = aistatus ? `${aistatus.charAt(0).toUpperCase()}${aistatus.slice(1)}` : 'Pending';
                            var transcriptJson = arr.ai_response ? JSON.stringify(arr.ai_response).replace(/"/g, '&quot;') : '{}';

                            
                            $('.table_result').append(`
                                    <tr>
                                        <td>${sno++}</td>
                                        <td>${arr.leadid}</td>
                                        <td>${arr.campid}</td>
                                        <td>${arr.agent_id}</td>
                                        <td>${arr.firstname}</td>
                                        <td>${arr.phone_number}</td>
                                        <td>${arr.status}</td>
                                        <td>${arr.ai_score}</td> 
                                        <td style="cursor:pointer;" class="dispobtn text-primary" data-agent="${arr.agent_id}" data-leadid="${arr.leadid}" data-cusfirstname = "${arr.cus_first_name}" data-cuslastname="${arr.cus_last_name}" data-transcript = "${transcriptJson}" data-audio="${arr.audio}" data-bs-toggle="offcanvas" data-bs-target="#demo" data-id=${arr.id}>${aistatusnew}</td>
                                          
                                    </tr>
                                `);

                                const clickedIds = JSON.parse(localStorage.getItem('clickedIds')) || [];
                                clickedIds.forEach(function (id) {
                                  
                                $(`.dispobtn[data-id="${id}"]`).closest('tr').addClass('clicked-row');
                                    });
                        

                        });
                    }
                });
            });

            //off canvas transcript appending 
             $('body').on('click', '.dispobtn', function () {

                        const clickedId = $(this).data('id').toString(); // use data-id
                        const $row = $(this).closest('tr');

                        console.log($row);

                        let clickedIds = JSON.parse(localStorage.getItem('clickedIds')) || [];

                        if (!clickedIds.includes(clickedId)) {
                            clickedIds.push(clickedId);
                            localStorage.setItem('clickedIds', JSON.stringify(clickedIds));
                        }

                        $row.addClass('clicked-row');

  
                    const audioUrl = $(this).data('audio');
                    const agent = $(this).data('agent');
                    const leadid = $(this).data('leadid');
                    const customerName = $(this).data('cusfirstname') + ' ' + $(this).data('cuslastname');

                    // alert();
                    $('.details_table tbody').empty();

              

                 

                    // Try parsing transcript JSON safely
                    let transcriptData = "";
                    try {
                        var test_ar = $(this).attr('data-transcript');
                        transcriptDatas = JSON.parse(test_ar);
                        transcriptData = JSON.parse(transcriptDatas);
                        // console.log(JSON.parse(transcriptData))

                    } catch (e) {
                        console.error('Invalid transcript JSON:', e);
                    }

                    // alert(transcriptData);
                     console.log(transcriptData);

                    // Fallbacks if missing
                    const sentiment = transcriptData.sentiment;
                    console.log(sentiment);
                    const segments = transcriptData.detailed_segments;


                        

                        const $detailsBody = $('.details_table tbody');
                        $detailsBody.empty().append(`
                            <tr>
                                <td class="text-center">${customerName}</td>
                                <td class="text-center">${leadid}</td>
                                <td class="text-center">${agent}</td>
                            </tr>
                        `);


                    // Update audio player
                    $('.audio_player audio').attr('src', audioUrl).get(0).load();

                    // Update badges (tone, agreement, polarity, subjectivity)
                    const badgesHTML = `<tr>

                                            <td class="text-center"> <span class="badge bg-primary">${sentiment.tone || 'NA'}</span> </td>
                                            <td class="text-center"> <span class="badge bg-secondary">${sentiment.agreement || 'NA'}</span> </td>
                                            <td class="text-center"> <span class="badge bg-warning">${(sentiment.polarity ?? 0).toFixed(2)}</span> </td>
                                            <td class="text-center"> <span class="badge bg-danger">${(sentiment.subjectivity ?? 0).toFixed(2)}</span> </td>

                                        </tr>                      
                    `;
                    $('.spandetails tbody').html(badgesHTML);

                    // Clear previous transcript and append new rows
                    const $tbody = $('.transcript_table tbody');
                    $tbody.empty();

                    function formatTime(seconds) {

                        const mins = Math.floor(seconds / 60);
                        const secs = Math.floor(seconds % 60).toString().padStart(2, '0');
                        return `${mins}:${secs}`;
                    }


                 segments.forEach(seg => {
                    const startFormatted = formatTime(seg.start);  // e.g., "1:05"
                    const endFormatted = formatTime(seg.end);      // e.g., "1:30"

                    $tbody.append(`
                        <tr>
                            <td class="audio_start_time">${startFormatted}</td>
                            
                            <td class="audio_text">${seg.text}</td>
                            <td class="audio_end_time">${endFormatted}</td>
                        </tr>
                    `);
                });

                    // Show offcanvas
                    const demoOffcanvas = new bootstrap.Offcanvas(document.getElementById('demo'));
                    demoOffcanvas.show();
            });

         
           //agent name function
            $('body').on('change', '#campaign', function () {
                var startDate     = $('#startDate').val();
                var endDate       = $('#endDate').val();
                var campaign_name = $('#campaign').val();
                var call_center   = $('#call_center').val();
                var agent_id      = $('#agent_id_get').val();

                $.ajax({
                    url: "ajax/report/leadreport.php?action=liveagent",
                    type: "GET",
                    data: {
                        startDate: startDate,
                        endDate: endDate,
                        campaign_name: campaign_name,
                        call_center: call_center
                    },
                    success: function (response) {
                        try {
                            var data = response;
                            console.log(data);

                            if (data.status === 'Ok') {
                                var record = data.data || [];

                                 console.log(record);

                                // Clear and repopulate agent list
                                $('#agent_name').html('<option value="">-- Choose Agent Id --</option>');

                                record.forEach(function (arr) {
                                    let selected = (arr.agent_id === agent_id) ? 'selected' : '';
                                    $('#agent_name').append(`
                                        <option value="${arr.agent_id}" ${selected}>${arr.full_name}</option>
                                    `);


                                });
                                
                            } else {
                                $('#agent_name').html('<option value="">-- No Agents Found --</option>');
                            }

                        } catch (e) {
                            console.error("JSON Parse Error:", e);
                            $('#agent_name').html('<option value="">-- Invalid Response --</option>');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", error);
                        $('#agent_name').html('<option value="">-- Request Failed --</option>');
                    }
                });
            });




        });
    </script>

</body>


</html>