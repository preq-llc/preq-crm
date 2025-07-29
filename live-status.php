<?php
    $page = 'livestats';
    include('config.php');
    include('function/session.php');
    $webphone_id = "";
    $webphone_user = "";
    $webphone_pass = "";
    $wb_sql = mysqli_query($conn, "SELECT `webphone_id`, `webphone_user`, `webphone_pass` FROM `users` WHERE `username` = '$logged_in_user_name'");
    $wb_data = mysqli_fetch_assoc($wb_sql);
    if($wb_data['webphone_user'] != null)
    {
        $webphone_id = $wb_data['webphone_id'];
        $webphone_user = $wb_data['webphone_user'];
        $webphone_pass = $wb_data['webphone_pass'];
    }


?>
<input type="text" id="current_username" value="<?php echo $logged_in_user_name;?>" hidden>
<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">


<head>

    <meta charset="utf-8" />
    <title>Live Status | <?php echo $site_name;?> - Dialer CRM</title>
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
                                                <h4 class="fs-16 mb-1">Hello, <?php echo $logged_in_user_name;?>!</h4>
                                                <p class="text-muted mb-0">Get Current Live status on this Page.</p>
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
                                                        <div class="col-sm-auto d-none">
                                                            <div class="form-group">
                                                                <label for="">Start date</label>
                                                                <input type="date" id="startDate" value="<?php echo $today_date;?>" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-auto d-none">
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
                                                            <label for="">Call center</label>
                                                            <select name="call_center" id="call_center" class="form-select">
                                                               <?php
                                                                            if ($logged_in_user_role == 'clients') {
                                                                                // For clients, force-select their username as the only option
                                                                                echo '<option value="' . htmlspecialchars($logged_in_user_name) . '" selected>' . htmlspecialchars($logged_in_user_name) . '</option>';
                                                                            } else {
                                                                                // For non-clients, show the normal dropdown
                                                                                echo '<option value="" selected>-- Choose Center --</option>';
                                                                                $single_callcenter = explode(",", $logged_in_user_group);
                                                                                foreach ($single_callcenter as $center) {
                                                                                    echo '<option value="' . htmlspecialchars(trim($center)) . '">' . htmlspecialchars(trim($center)) . '</option>';
                                                                                }
                                                                            }
                                                                        ?>
                                                            </select>
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
                                        <div class="card">
                                            <div class="card-header border-0 align-items-center d-flex">
                                            <h4 class="card-title mb-0 flex-grow-1">Live Calls</h4>
                                        </div>

                                        <div class="card-body p-0 pb-2">
                                                <div class="table-responsive table-card mt-3" style="min-height: 500px;max-height: 500px;">
                                                    <table  id="export_table" class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                        <thead class="text-muted table-light">
                                                            <tr class="text-center">
                                                                <th scope="col">STATUS</th>
                                                                <th scope="col">CAMPAIGN</th>
                                                                <th scope="col">PHONE NUMBER</th>
                                                                <th scope="col">SERVER IP</th>
                                                                <th scope="col">DIALTIME</th>
                                                                <th scope="col">CALL TYPE</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="table_result_call_waiting" style="overflow-y: auto;">
                                                            <tr class="py-4">
                                                                <td colspan="6" class="text-center">No Calls Found</td>
                                                            </tr>
                                                        </tbody>
                                                    </table><!-- end table -->
                                                </div>
                                            </div><!-- end card body -->
                                        </div>
                                        
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-header border-0 align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">Active Calls</h4>
                                                <div>
                                                    <button type="button" class="btn btn-soft-secondary btn-sm" disabled>
                                                       Refresh Count: <span class="refreshCount">0</span>
                                                    </button>
                                                  <!--   <button type="button" class="btn btn-soft-secondary btn-sm">
                                                        1M
                                                    </button>
                                                    <button type="button" class="btn btn-soft-secondary btn-sm">
                                                        6M
                                                    </button>
                                                    <button type="button" class="btn btn-soft-primary btn-sm">
                                                        1Y
                                                    </button> -->
                                                </div>
                                            </div><!-- end card header -->
                                             <?php if ($logged_in_user_name == 'TAX') { ?>
                                                <div class="card-header p-0 border-0 bg-light-subtle">
                                                    <div class="row g-0 text-center">
                                                        <div class="col-6 col-sm-2">
                                                            <div class="p-3 border border-dashed border-start-0">
                                                                <h5 class="mb-1"><span class="counter-value" data-target="0" id="agentInCall">0</span>
                                                                    <!-- <span class="text-success ms-1 fs-12">49%<i class="ri-arrow-right-up-line ms-1 align-middle"></i></span> -->
                                                                </h5>
                                                                <p class="text-muted mb-0">Agent In call</p>
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-6 col-sm-2">
                                                            <div class="p-3 border border-dashed border-start-0">
                                                                <h5 class="mb-1"><span class="counter-value" data-target="0" id="agentWaiting">0</span>
                                                                    <!-- <span class="text-success ms-1 fs-12">60%<i class="ri-arrow-right-up-line ms-1 align-middle"></i></span> -->
                                                                </h5>
                                                                <p class="text-muted mb-0">Agent Waiting for the call</p>
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-6 col-sm-2">
                                                            <div class="p-3 border border-dashed border-start-0">
                                                                <h5 class="mb-1"><span class="counter-value" data-target="0" id="agentLoggedIn">0</span>
                                                                   
                                                                    <!-- <span class="text-success ms-1 fs-12">37%<i class="ri-arrow-right-up-line ms-1 align-middle"></i></span> -->
                                                                </h5>
                                                                <p class="text-muted mb-0">Agent Logged In</p>
                                                            </div>
                                                        </div>

                                                      
                                                        <div class="col-6 col-sm-2">
                                                            <div class="p-3 border border-dashed border-start-0">
                                                                <h5 class="mb-1"><span class="counter-value" data-target="0" id="transfervalue">0</span>
                                                                   
                                                                    <!-- <span class="text-success ms-1 fs-12">37%<i class="ri-arrow-right-up-line ms-1 align-middle"></i></span> -->
                                                                </h5>
                                                                <p class="text-muted mb-0">Transfer</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-sm-2">
                                                            <div class="p-3 border border-dashed border-start-0">
                                                                <h5 class="mb-1"><span class="counter-value" data-target="0" id="tphvalue">0</span>
                                                                   
                                                                    <!-- <span class="text-success ms-1 fs-12">37%<i class="ri-arrow-right-up-line ms-1 align-middle"></i></span> -->
                                                                </h5>
                                                                <p class="text-muted mb-0">TPH</p>
                                                            </div>
                                                        </div>

                                                         <div class="col-6 col-sm-2">
                                                            <div class="p-3 border border-dashed border-start-0">
                                                                <h5 class="mb-1"><span class="counter-value" data-target="0" id="totalquesvalue">0</span>
                                                                   
                                                                    <!-- <span class="text-success ms-1 fs-12">37%<i class="ri-arrow-right-up-line ms-1 align-middle"></i></span> -->
                                                                </h5>
                                                                <p class="text-muted mb-0">Total Calls Queue</p>
                                                            </div>
                                                        </div>
                                                       
                                                        <!--end col-->
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php if ($logged_in_user_name != 'TAX') { ?>
                                                <div class="card-header p-0 border-0 bg-light-subtle">
                                                    <div class="row g-0 text-center">
                                                        <div class="col-6 col-sm-4">
                                                            <div class="p-3 border border-dashed border-start-0">
                                                                <h5 class="mb-1"><span class="counter-value" data-target="0" id="agentInCall">0</span>
                                                                    <!-- <span class="text-success ms-1 fs-12">49%<i class="ri-arrow-right-up-line ms-1 align-middle"></i></span> -->
                                                                </h5>
                                                                <p class="text-muted mb-0">Agent In call</p>
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-6 col-sm-4">
                                                            <div class="p-3 border border-dashed border-start-0">
                                                                <h5 class="mb-1"><span class="counter-value" data-target="0" id="agentWaiting">0</span>
                                                                    <!-- <span class="text-success ms-1 fs-12">60%<i class="ri-arrow-right-up-line ms-1 align-middle"></i></span> -->
                                                                </h5>
                                                                <p class="text-muted mb-0">Agent Waiting for the call</p>
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-6 col-sm-4">
                                                            <div class="p-3 border border-dashed border-start-0 border-end-0">
                                                                <h5 class="mb-1"><span class="counter-value" data-target="0" id="agentLoggedIn">0</span>
                                                                   
                                                                    <!-- <span class="text-success ms-1 fs-12">37%<i class="ri-arrow-right-up-line ms-1 align-middle"></i></span> -->
                                                                </h5>
                                                                <p class="text-muted mb-0">Agent Logged In</p>
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <!-- end card header -->
                                            <div class="card-body p-0 pb-2">
                                                <div class="table-responsive table-card mt-5">
                                                    <table  id="export_table" class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                        <thead class="text-muted table-light">
                                                            <tr class="text-center">
                                                                <th scope="col">STATION</th>
                                                                <th scope="col">USER</th>
                                                                <th scope="col">NAME</th>
                                                                <th scope="col">PHONENUMBER</th>
                                                                <th scope="col">SESSIONID</th>
                                                                <th scope="col">LISTEN</th>
                                                                <th scope="col">MONITOR</th>
                                                                <th scope="col">CAMPAIGN</th>
                                                                <th scope="col">MM:SS</th>
                                                                <th scope="col">CALLS TODAY</th>
                                                               <?php if ($logged_in_user_name != 'TAX') { ?>

                                                                                <th scope="col">COMMENTS</th>
                                                                <?php } ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="table_result">
                                                            <tr class="py-4">
                                                                <td colspan="10" class="text-center">No Record Found</td>
                                                            </tr>
                                                        </tbody>
                                                    </table><!-- end table -->
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div>
                                </div>
                            </div> <!-- end .h-100-->
                        </div> <!-- end col -->
                    </div>
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php include('template/footer.php');?>
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
    <!-- <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Toggle right offcanvas</button> -->

        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">BARGE FOR : <span class="bargesession_id"></span></h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
        <div class="row usercanvasbody">
            <form id="bargeform" autocomplete="off" class="barge_form" action="#" method="GET" target="_blank">

                <div class="col-12 pt-1">
                    <label for="">User</label>
                    <!-- <input type="text" name="fake_user" style="display:none" autocomplete="off"> -->
                    <input type="text" class="form-control" name="user" value="<?php echo $webphone_user;?>" required autocomplete="new"   >
                    <input type="text" hidden class="form-control" name="source" value="test" >
                </div>
                <script>
                        // window.addEventListener('load', () => {
                        // const input = document.querySelector('input[name="user"]');
                        // if (input && input.defaultValue) {
                        //     input.value = input.defaultValue; // Restore PHP value
                        // }
                        // });
                        </script>
                <div class="col-12 pt-3">
                    <label for="">Password</label>
                    <input type="password" class="form-control" name="pass" value="<?php echo $webphone_pass;?>" required autocomplete="new" required>

                </div>
                
                <div class="col-12 pt-3">
                    <label for="">Function</label>
                    <input type="text" class="form-control" name="function" value="blind_monitor" >
                </div>
                <div class="col-12 pt-3">
                    <label for="">Phone ID <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="barge_phone" name="phone_login" required autocomplete="new" value="<?php echo $webphone_id;?>" >
                </div>
                <div class="col-12 pt-3">
                    <label for="">Session ID</label>
                    <input type="text" class="form-control" id="barge_session" name="session_id" value="">
                </div>
                <div class="col-12 pt-3">
                    <label for="">Server IP</label>
                    <input type="text" class="form-control" id="barge_server" name="server_ip" value="" >
                </div>
                <div class="col-12 pt-3">
                    <label for="">Stage</label>
                    <input type="text" class="form-control" name="stage" value="MONITOR" >
                </div>
                
                <!-- <div class="col-12 pt-3">
                    <label for="">Status</label>
                    <select name="" id="status" class="form-select">
                        <option value="ACTIVE">Active</option>
                        <option value="In-Active">Deactive</option>
                    </select>
                </div> -->
                <div class="col-12 pt-2">
                    <input type="submit" id="barge_listen" class="btn mt-4 btn-soft-primary" value="LISTEN">
                    
                </div>
                
            </form>
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
         $(document).ready(function(){
            var intervalId;
            var current_username = $("#current_username").val();
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
               
            $('body').on('change','#campaign', function(){


                clearInterval(intervalId);
              


                var totalcallqeues;
                var fromdatevalue = $('#startDate').val();
                var endDate = $('#endDate').val();
                var slctcampvalue = $('#campaign').val();
                var current_username = $("#current_username").val();
                var call_center = $('#call_center').val();

          
                var refreshCount = $('.refreshCount').html();
                // console.log(startDate);
                if(startDate == "")
                {
                    toastr.warning('Please Choose Start date!');
                    $('#startDate').focus();
                }
                else if(endDate == "")
                {
                    toastr.warning('Please Choose End date!');
                    $('#endDate').focus();
                }
                else if(slctcampvalue == "")
                {
                    toastr.warning('Please Choose a Campaign!');
                    $('#campaign').focus();
                }
                else
                {
                    intervalId = setInterval(() => {
                        refreshCount++;
                        autoreloadfunction(fromdatevalue, slctcampvalue, call_center, refreshCount);
                        autoreloadfunctionextradata(fromdatevalue, slctcampvalue, call_center);                        
                    }, 4000);
                }
                
            });
            $('body').on('change','#call_center', function(){
                clearInterval(intervalId);
                $('#campaign').trigger('change');
            });
            function autoreloadfunction(fromdatevalue, slctcampvalue, call_center, refreshCount)
            {

                  current_username = $("#current_username").val();

                    $.ajax({
                            url: 'ajax/report/liveagent.php?action=waitingcalls',
                            type: 'get',
                            data: {
                                fromdatevalue:fromdatevalue,
                                slctcampvalue:slctcampvalue,
                                call_center:call_center
                            },
                            success: function(data) {
                                // console.log(data);
                                var data = JSON.parse(data);
                                if(data.status == 'Ok')
                                {
                                    $('.table_result_call_waiting').html('');
                                    var record = data.calls_waiting;
                                    console.log(record);
                                    console.log(record.length);

                                    totalcallqeues = record.filter(arr => arr.status === 'LIVE').length;
                                    console.log('totalcallqeues : ', totalcallqeues);
                                    
                                    $('#totalquesvalue').html(totalcallqeues);

                                  
                                    if(record.length == 0)
                                    {
                                        $('.table_result_call_waiting').html(`
                                            <tr class="py-4">
                                                <td colspan="6" class="text-center">No Calls Found</td>
                                            </tr>
                                        `);
                                    }
                                    else
                                    {
                                        record.map(function(arr, idx){

                                        
                                            
                                            var calltype='';
                                            if(current_username=='TAX'){

                                                if(arr.campaign_id == 'TAX_OB'){

                                                calltype = 'OUTBOUND';
                                              }
                                              else{

                                                calltype = 'INBOUND';


                                              }



                                            }else{

                                                calltype = arr.call_type;


                                            }

                                            
                                              
                                            $('.table_result_call_waiting').append(`
                                                <tr class="text-center">
                                                    <td>${arr.status}</td>
                                                    <td>${arr.campaign_id}</td>
                                                    <td>${arr.phone_number}</td>
                                                    <td>${arr.server_ip}</td>
                                                    <td>${arr.call_time}</td>
                                                    <td>${calltype}</td>
                                                </tr>
                                            `);
                                     });
                                    }
                                     
                                }
                            }

                        });
                
                    $.ajax({
                            url: 'ajax/report/liveagent.php?action=all',
                            type: 'get',
                            data: {
                                fromdatevalue:fromdatevalue,
                                slctcampvalue:slctcampvalue,
                                call_center:call_center
                            },
                            success: function(response)
                            {
                                console.log(response);
                                var data = JSON.parse(response);
                                if(data.status == 'Ok')
                                {
                                    var record = data.data;
                                    $('.table_result').html("");
                                    var agentInCall = 0;
                                    var agentReady = 0;
                                    var agentLoggedIn = record.length;

                                    // var runningtime = 
                                    
                                    record.map(function(arr, idx){
                                        if(arr.status == "INCALL")
                                        {
                                            agentInCall++;
                                        }
                                        else
                                        {
                                            agentReady++;
                                        }
                                        if(arr.campaign_id == 'EDU_TEST')
                                        {
                                            var camp_name = 'EDU_TRAINING';
                                        }
                                        else
                                        {
                                            var camp_name = arr.campaign_id;
                                        }
                                        var arbtncl = "";
                                        if(arr.status == "INCALL")
                                        {
                                            arbtncl = "btn-soft-success";
                                        }
                                        else if(arr.status == "READY")
                                        {
                                            arbtncl = "btn-soft-secondary";

                                        }
                                        else if(arr.status == "PAUSED")
                                        {
                                            arbtncl = "btn-soft-warning";
                                        }
                                        else
                                        {
                                            arbtncl = "btn-soft-primary";
                                        }

                                        // var barge_form_url = "http://${data.campip}/vicidial/non_agent_api.php?source=test";
                                        //     $('.barge_form').attr('action', barge_form_url);
                                        
                                        let minutes = "00";
                                        let seconds = "00";

                                        const lastCallTime = new Date(arr.last_call_time);
                                        const lastUpdateTime = new Date(arr.last_update_time);

                                        const diffMs = lastUpdateTime - lastCallTime; // difference in milliseconds
                                        

                                        
                                        if (diffMs >= 0) {
                                                const diffSeconds = Math.floor(diffMs / 1000);
                                                minutes = Math.floor(diffSeconds / 60).toString().padStart(2, '0');
                                                seconds = (diffSeconds % 60).toString().padStart(2, '0');
                                        }

                                        $('.table_result').append(`
                                            <tr class="text-center">
                                                <td>${arr.extension}</td>
                                                <td>${arr.user}</td>
                                                <td class="text-start">${arr.full_name}</td>
                                                <td>${arr?.phone_number || ''}</td>
                                                <td>${arr.conf_exten}</td>
                                                <td><button class="btn btn-sm ${arbtncl}">${arr.status}</button></td>
                                                <td><button data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" data-campip="${data.campip}" data-serverip="${arr.server_ip}" data-session_id="${arr.conf_exten}" class="barge_btn btn-soft-dark btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-inbound" viewBox="0 0 16 16">
                                                <path d="M15.854.146a.5.5 0 0 1 0 .708L11.707 5H14.5a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 1 0v2.793L15.146.146a.5.5 0 0 1 .708 0m-12.2 1.182a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/>
                                                </svg> </button></td>
                                                <td>${camp_name}</td>
                                                <td>${minutes}:${seconds}</td>
                                                <td>${arr.calls_today}</td>
                                                <?php if ($logged_in_user_name != 'TAX') : ?>
                                                        <td>${arr.comments}</td>
                                                <?php endif; ?>
                                                
                                            </tr>
                                        `);

                                    });
                                    
                                    if(agentReady <= 24 && agentReady >= 5)
                                    {
                                        var readyColor = 'text-warning';
                                    }
                                    else if(agentReady <= 4 && agentReady >= 0)
                                    {
                                        var readyColor = 'text-danger';
                                    }
                                    else if(agentReady > 25)
                                    {
                                        var readyColor = 'text-success';
                                    }
                                    else
                                    {
                                        var readyColor = 'text-dark';
                                    }

                                    if(agentInCall <= 24 && agentInCall >= 5)
                                    {
                                        var callColor = 'text-warning';
                                    }
                                    else if(agentInCall <= 4 && agentInCall >= 0)
                                    {
                                        var callColor = 'text-danger';
                                    }
                                    else if(agentInCall > 25)
                                    {
                                        var callColor = 'text-success';
                                    }
                                    else
                                    {
                                        var callColor = 'text-dark';
                                    }


                                    if(agentLoggedIn <= 24 && agentLoggedIn >= 5)
                                    {
                                        var logColor = 'text-warning';
                                    }
                                    else if(agentLoggedIn <= 4 && agentLoggedIn >= 0)
                                    {
                                        var logColor = 'text-danger';
                                    }
                                    else if(agentLoggedIn > 25)
                                    {
                                        var logColor = 'text-success';
                                    }
                                    else
                                    {
                                        var logColor = 'text-dark';
                                    }

                                    $('#agentWaiting').html(agentReady).addClass(readyColor);
                                    $('#agentLoggedIn').html(agentLoggedIn).addClass(logColor);
                                    $('#agentInCall').html(agentInCall).addClass(callColor);
                                    $('.refreshCount').html(refreshCount);
                                }
                                
                            }
                        });
            }
            function autoreloadfunctionextradata(fromdatevalue, slctcampvalue, call_center)
            {

                $('#totalquesvalue').html(0);

                    $.ajax({
                            url: 'ajax/report/liveagent.php?action=extradatainlivecalls',
                            type: 'get',
                            data: {
                                fromdatevalue:fromdatevalue,
                                slctcampvalue:slctcampvalue,
                                call_center:call_center
                            },
                            success: function(data) {
                                // console.log(data);
                                var data = JSON.parse(data);
                                if(data.status == 'Ok')
                                {
                                 // console.log(data.tra_waiting);
                                    data.tra_waiting.forEach(function(row) {
                                    const totalHrs = (row.Hrs / 3600).toFixed(2);
                                    console.log(totalHrs);
                                    const transfer = Number(row.successtransfer) + Number(row.Transfer);
                                    const tph = totalHrs > 0 ? (transfer / totalHrs).toFixed(2) : '0.00';
                               
                                    // Example of appending to a table row (you can adapt to your UI)
                                    $('#transfervalue').html(transfer);
                                    $('#tphvalue').html(tph);
                                    
                                });

                                     
                                }
                            }

                        });

            }
            $('body').on('click', '.barge_btn', function(){
                    console.log('test');
                    
                    var campip = $(this).data('campip');
                    var session_id = $(this).data('session_id');
                    var server_ip = $(this).data('serverip');
                    // var server_ip = campip;
                    var public_domain = server_ip;
                    if(server_ip == "192.168.200.164")
                    {
                        var public_domain = "dial21.preqvoice.com"
                    }
                    else if(server_ip == "192.168.200.165")
                    {
                        var public_domain = "dial22.preqvoice.com"
                    }
                    else if(server_ip == "192.168.200.166")
                    {
                        var public_domain = "dial23.preqvoice.com"
                    }
                    else if(server_ip == "192.168.200.64")
                    {
                        var public_domain = "dial15.preqvoice.com"
                    }
                    var barge_form_url = "http://"+public_domain+"/vicidial/non_agent_api.php";
                    $('.barge_form').attr('action', barge_form_url);


                    // let cookies = {};
                    // document.cookie.split(';').forEach(cookie => {
                    //     let [key, value] = cookie.split('=');
                    //     cookies[key.trim()] = decodeURIComponent(value);
                    // });

                    // // Check if barge_phone exists
                    // if (cookies.barge_phone) {
                    //     console.log("barge_phone cookie found:", cookies.barge_phone);
                    //     var barge_phone_i = cookies.barge_phone;
                    // } 
                    // else
                    // {
                    //     var barge_phone_i = '';

                    // }

                    // $('#barge_phone').val(barge_phone_i);
                    $('#barge_session').val(session_id);
                    $('#barge_server').val(server_ip);
            });
            
                document.getElementById("bargeform").addEventListener("submit", function (e) {
                    let cookies = {};
                    document.cookie.split(';').forEach(cookie => {
                        let [key, value] = cookie.split('=');
                        cookies[key.trim()] = decodeURIComponent(value);
                    });
                    const bargePhoneInput = document.getElementById("barge_phone").value;

                    // Check if barge_phone exists
                    if (cookies.barge_phone) {
                        console.log("barge_phone cookie found:", cookies.barge_phone);
                    } 
                    else
                    {
                        document.cookie = `barge_phone=${encodeURIComponent(bargePhoneInput)}; path=/; max-age=86400`; // 1 day
                    }

                    

                });

                $('body').on('click', '#export_excel', function(){

                    var startDate = $('#startDate').val();
                    
                    var campaign_name = $('#campaign').val();

                    var fileName = campaign_name+' - '+startDate;
                        var table = document.getElementById('export_table');
                        var ws = XLSX.utils.table_to_sheet(table);
                        var wb = XLSX.utils.book_new();
                        XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
                        XLSX.writeFile(wb, fileName+'.xlsx');
                });
            // $('body').on('click', '#barge_listen', function(){

            //     var url = "http://"++"";
            // });

        });
    </script>

</body>


</html>