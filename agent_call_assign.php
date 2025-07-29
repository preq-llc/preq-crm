<?php
$page = 'agentcall_assigne';
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
    <title>Agent Call Assigning | <?php echo $site_name; ?> - Dialer CRM</title>
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

                                                             
                                                                ?>
                                                            </select>
                                                        </div>
                                                           <div class="col-sm-auto">
                                                            <label for="">Status</label>

                                                            <select name="" id="agent_status" class="form-select">
                                                                <option value="" selected>-- ALL --</option>
                                                            
                                                              
                                                            </select>
                                                        </div>
                                                              <div class="col-sm-auto">
                                                            <label for="">Agent Name</label>

                                                            <select name="" id="agent_name" class="form-select">
                                                                <option value="" selected>-- ALL --</option>
                                                            
                                                              
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="col-auto">
                                                            <button type="button" class="btn btn-soft-success mt-3" id="getRecord"><i class="ri-add-circle-line align-middle me-1"></i>
                                                                Get Lead
                                                            </button>
                                                        </div>
                                                       <div class="col-auto">
                                                            <button type="button" class="btn btn-soft-info mt-3" id="updatedRecord">
                                                                <i class="ri-add-circle-line align-middle me-2"></i>
                                                                Updated
                                                            </button>
                                                        </div>
                                                    </div>
                                                  
                                                </form>
                                            </div>
                                        </div>
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
                                    <h4 class="card-title mb-0 flex-grow-1">AGENT CALL ASSIGN</h4>
                                   
                                    <div class="flex-shrink-0">
                                        
                                        <button type="button" id="export_excel" class="btn btn-soft-info btn-sm">
                                            <i class="ri-file-list-3-line align-middle"></i> Download Report
                                        </button>
                                    </div>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                           <!-- Report Table -->
                                        <table id="export_table" class="table table-hover table-borderless table-centered align-middle table-nowrap mb-0">
                                            <thead class="text-muted table-light">
                                                <tr>
                                                    <th><input type="checkbox" id="select_all" /></th>
                                                    <th>Sno</th>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Phone No</th>
                                                    <th>Agent Name</th>
                                                    <th>Status</th>
                                                    <th>Campaign Name</th>
                                                    <th>Created Date/Time</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table_result"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- .card-->
                        </div> <!-- .col-->
                    </div>
                </div>
            </div>
            <!-- container-fluid -->
        </div>
  
        <?php include('template/footer.php'); ?>
    </div>
    <!-- end main content-->

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
          
           $.ajax({
                url: 'ajax/agentcall/agent_username.php?action=getagent_username',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        let agents = response.data;
                        agents.forEach(function(agent) {
                            $('#agent_name').append(`<option value="${agent.emp_id}">${agent.emp_id}</option>`);
                        });
                    } else {
                        alert('Failed to load agents: ' + response.message);
                    }
                },
                error: function () {
                    alert('AJAX error loading agents.');
                }
            });
           // Load agent statuses into dropdown
            $.ajax({
                url: 'ajax/agentcall/agentcall_assign.php?action=getagent_status',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        let statuses = response.data;
                        statuses.forEach(function (item) {
                            $('#agent_status').append(`<option value="${item.status}">${item.status}</option>`);
                        });
                    } else {
                        alert('Failed to load statuses: ' + response.message);
                    }
                },
                error: function () {
                    alert('AJAX error loading statuses.');
                }
            });

                    // Get QC Report
            $('body').on('click', '#getRecord', function () {
                var fromdatevalue = $('#startDate').val();
                var todatevalue = $('#endDate').val();
                var slctcampvalue = $('#campaign').val();
                var call_centervalue = $('#call_center').val();
                var agent_id = $('#agent_name').val();
                var agent_status = $('#agent_status').val();

                $.ajax({
                    url: 'ajax/agentcall/agentcall_assign.php?action=get_qc_report',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        from_date: fromdatevalue,
                        to_date: todatevalue,
                        campaign: slctcampvalue,
                        call_center: call_centervalue,
                        agent_id: agent_id,
                        agent_status: agent_status
                    },
                    success: function (response) {
                        let rows = '';
                        $('.table_result').empty();

                        if (response.status === 'success' && response.data.length > 0) {
                            response.data.forEach(function (record, index) {
                                rows += `
                                    <tr>
                                        <td><input type="checkbox" class="row_checkbox" value="${record.id}" /></td>
                                        <td>${index + 1}</td>
                                        <td>${record.first_name}</td>
                                        <td>${record.last_name}</td>
                                        <td>${record.phone_number}</td>
                                        <td>${record.agent_username}</td>
                                        <td>${record.status}</td>
                                        <td>${record.campid}</td>
                                        <td>${record.timestamp}</td>
                                    </tr>`;
                            });
                        } else {
                            rows = `<tr><td colspan="9" class="text-center">No Record Found</td></tr>`;
                        }

                        $('.table_result').append(rows);
                    },
                    error: function () {
                        alert('AJAX request failed.');
                    }
                });
            });

            // Select/Deselect All
            $('#select_all').on('click', function () {
                $('.row_checkbox').prop('checked', this.checked);
            });

            // Reset Status Button Click
            $('#updatedRecord').on('click', function () {
                var selectedIds = [];
                $('.row_checkbox:checked').each(function () {
                    selectedIds.push($(this).val());
                });

                var agentName = $('#agent_name').val();
                if (!agentName) {
                    alert('Please select an agent name.');
                    return;
                }

                if (selectedIds.length === 0) {
                    alert('Please select at least one record.');
                    return;
                }

                    $.ajax({
                        url: 'ajax/agentcall/agentcall_assign.php?action=reset_status',
                        type: 'POST',
                        data: {
                            agent_name: agentName,
                            ids: selectedIds
                        },
                        success: function (response) {
                            console.log(response);
                            if (response === 'success') {
                                alert('Status updated successfully.');
                                $('#getRecord').click(); // Refresh the table
                            } else {
                                alert('Update failed: ' + response);
                            }
                        },
                        error: function () {
                            alert('AJAX error occurred.');
                        }
                    });
                });



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

        
           });
    
    </script>

</body>


</html>