<?php
    $page = 'dashboard';
    include('function/session.php');
    include('config.php');
    
?>
<input type="text" id="current_username" value="<?php echo $logged_in_user_name;?>" hidden>
<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">


<head>

    <meta charset="utf-8" />
    <title>Dashboard | <?php echo $site_name;?> - Dialer CRM</title>
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
        <?php include('template/navbar_v2.php');?>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col">

                            <div class="h-100">
                                <div class="row mb-3 pb-1">
                                    <div class="col-12">
                                        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                            <div class="flex-grow-1">
                                                <h4 class="fs-16 mb-1">Welcome Back, <?php echo $logged_in_user_name;?>!</h4>
                                                <p class="text-muted mb-0">Here's what's happening with Dialer
                                                    today.</p>
                                                    
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
                                                                <!-- <label for="">Start date</label> -->
                                                                <input type="date" id="startDate" value="<?php echo $today_date;?>" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <div class="form-group">
                                                                <!-- <label for="">End date</label> -->
                                                                <input type="date" id="endDate" value="<?php echo $today_date;?>" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <div class="form-group">
                                                                <select name="" id="campaign" class="form-select">
                                                                    <option value="">-- Choose Campaign --</option>
                                                                   
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <select name="" id="call_center" class="form-select">
                                                                            <!-- <option value="">-- Choose Center --</option>
                                                                            <option value="MAL">MAL</option>
                                                                            <option value="MED">MED</option> -->
                                                                <?php
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
                                                                    
                                                                    // if ($logged_in_user_group == 'ZD25' || $logged_in_user_group == 'ZD26') {
                                                                       
                                                                        // echo '<option value="' . $logged_in_user_group . '">' . $logged_in_user_group . '</option>';
                                                                        
                                                                    // } else {
                                                                        // echo '
                                                                           
                                                                        // ';
                                                                    // }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-auto">
                                                            <button type="button" class="btn btn-soft-success" id="getRecord"><i class="ri-add-circle-line align-middle me-1"></i>
                                                                Get Record
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
                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                            AGENT</p>
                                                    </div>
                                                    <!-- <div class="flex-shrink-0">
                                                        <h5 class="text-success fs-14 mb-0">
                                                            <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                                            +16.24 %
                                                        </h5>
                                                    </div> -->
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                            <!-- $ -->
                                                            <span class="counter-value" id="total_agent" data-target="0">0</span>
                                                        </h4>
                                                        <!-- <a href="#" class="text-decoration-underline text-muted">Total Agents</a> -->
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-warning-subtle rounded fs-3">
                                                        <i class="bx bx-user-circle text-warning"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->

                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                        ACTIVE AGENT</p>
                                                    </div>
                                                    <!-- <div class="flex-shrink-0">
                                                        <h5 class="text-danger fs-14 mb-0">
                                                            <i class="ri-arrow-right-down-line fs-13 align-middle"></i>
                                                            -3.57 %
                                                        </h5>
                                                    </div> -->
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="0" id="active_agent">0</span></h4>
                                                        <!-- <a href="#" class="text-decoration-underline text-muted">Currently Active Agents</a> -->
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-info-subtle rounded fs-3">
                                                            <i class='bx bxs-user-voice text-success'></i>

                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->

                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                        HOURS</p>
                                                    </div>
                                                    <!-- <div class="flex-shrink-0">
                                                        <h5 class="text-success fs-14 mb-0">
                                                            <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                                            +29.08 %
                                                        </h5>
                                                    </div> -->
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="0" id="total_hrs">0</span>
                                                        </h4>
                                                        <!-- <a href="#" class="text-decoration-underline text-muted">Total Hours</a> -->
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-info-subtle rounded fs-3">
                                                            <i class="bx bx-time text-info"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->

                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                        TOTAL CALLS</p>
                                                    </div>
                                                    <!-- <div class="flex-shrink-0">
                                                        <h5 class="text-muted fs-14 mb-0">
                                                            +0.00 %
                                                        </h5>
                                                    </div> -->
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="0" id="total_calls">0</span>
                                                        </h4>
                                                        <!-- <a href="#" class="text-decoration-underline text-muted">Total Calls</a> -->
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-danger-subtle rounded fs-3">
                                                            <i class="bx bx-headphone text-danger"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->
                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                        TRANSFER</p>
                                                    </div>
                                                    <!-- <div class="flex-shrink-0">
                                                        <h5 class="text-success fs-14 mb-0">
                                                            <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                                            +16.24 %
                                                        </h5>
                                                    </div> -->
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="0" id="total_transfer">0</span>
                                                        </h4>
                                                        <!-- <a href="#" class="text-decoration-underline text-muted">Total Transfer</a> -->
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-danger-subtle rounded fs-3">
                                                            <i class="bx bx-transfer text-danger"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->
                                    
                                     <?php 

                                     if($logged_in_user_name != 'PSPM'){

                                        ?>
                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                        Billable</p>
                                                    </div>
                                                    <!-- <div class="flex-shrink-0">
                                                        <h5 class="text-danger fs-14 mb-0">
                                                            <i class="ri-arrow-right-down-line fs-13 align-middle"></i>
                                                            -3.57 %
                                                        </h5>
                                                    </div> -->
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="0" id="total_billable">0</span></h4>
                                                        <!-- <a href="#" class="text-decoration-underline text-muted">Billable Count</a> -->
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-success-subtle rounded fs-3">
                                                            <i class="bx bx-dollar-circle text-success"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->
                                    <?php } ?>
                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                        TPH</p>
                                                    </div>
                                                    <!-- <div class="flex-shrink-0">
                                                        <h5 class="text-success fs-14 mb-0">
                                                            <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                                            +29.08 %
                                                        </h5>
                                                    </div> -->
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="0" id="tph_percent">0</span>
                                                        </h4>
                                                        <!-- <a href="#" class="text-decoration-underline text-muted">TPH %</a> -->
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-primary-subtle rounded fs-3">
                                                            <i class='bx bx-receipt text-primary'></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->
                                     
                                     <?php 

                                     if($logged_in_user_name != 'PSPM'){

                                        ?>
                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                        BPH</p>
                                                    </div>
                                                    <!-- <div class="flex-shrink-0">
                                                        <h5 class="text-muted fs-14 mb-0">
                                                            +0.00 %
                                                        </h5>
                                                    </div> -->
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="0" id="bph_percent">0</span>
                                                        </h4>
                                                        <!-- <a href="#" class="text-decoration-underline text-muted">BPH %</a> -->
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        
                                                        <span class="avatar-title bg-warning-subtle rounded fs-3">
                                                            <i class='bx bx-purchase-tag-alt text-warning'></i>
                                                        </span>
                                                        
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->
                                   <?php } ?>
                                </div> <!-- end row-->

                                <div class="row">
                                <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-header align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">AGENT SUMMARY</h4>
                                                <div class="flex-shrink-0">
                                                        
                                                        <select class="form-select form-select-sm" id="report_type" aria-label=".form-select-sm example">
                                                            <option value="agent">Agent wise</option>
                                                            <?php
                                                            if($logged_in_user_role == "superadmin")
                                                            {   

                                                        ?>
                                                            <option value="callcenter">Call Center</option>
                                                             <?php
                                                            
                                                            }
                                                        ?>
                                                            <!-- <option value="subcallcenter">Sub Call Center</option> -->
                                                        </select>
                                                       
                                                </div>
                                                <div class="flex-shrink-0">
                                                
                                                    <button type="button" id="export_excel" class="btn btn-soft-info btn-sm">
                                                        <i class="ri-file-list-3-line align-middle"></i> Download Report
                                                    </button>
                                                </div>
                                            </div><!-- end card header -->

                                            <div class="card-body">
                                                <div class="table-responsive table-card">
                                                    <table  id="export_table" class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                        <thead class="text-muted table-light tablehead">
                                            <tr>
                                                <th scope="col">Campaign Name</th>
                                                <th scope="col">Agent ID</th>
                                                <th scope="col">Agent Name</th>
                                                <th scope="col">Total Hours</th>
                                                <th scope="col">Total Calls</th>
                                                <th scope="col">Transfer</th>
                                                
                                                <?php if($logged_in_user_name != 'PSPM'): ?>
                                                    <th scope="col">Billable</th>
                                                <?php endif; ?>
                                                
                                                <th scope="col">TPH</th>
                                                
                                                <?php if($logged_in_user_name != 'PSPM'): ?>
                                                    <th scope="col">BPH</th>
                                                    <th scope="col">SPC</th>
                                                <?php endif; ?>
                                            </tr>
                                                        </thead>
                                                        <tbody class="table_result">
                                                            <tr>
                                                                <td colspan="8" class="text-center">NO Record Found</td>
                                                            </tr>
                                                        </tbody>
                                                    </table><!-- end table -->
                                                </div>
                                            </div>
                                        </div> <!-- .card-->
                                    </div> <!-- .col-->
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

    <!-- Dashboard init -->
    <script src="assets/js/pages/dashboard-ecommerce.init.js"></script>

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
                var overAllRecord;
                var qcRecord;
                $('body').on('click','#getRecord', function(){
                // var dateText = $('#reportrange span').html();

                // var dates = dateText.split(' - ');

                // var startDate = moment(dates[0], 'MMMM D, YYYY').format('YYYY-MM-DD');
                // var endDate = moment(dates[1], 'MMMM D, YYYY').format('YYYY-MM-DD');

                var startDate = $('#startDate').val();
                var endDate = $('#endDate').val();
                var campaign_name = $('#campaign').val();
                var call_center = $('#call_center').val();
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
                else if(campaign_name == "")
                {
                    toastr.warning('Please Choose a Campaign!');
                    $('#campaign').focus();
                }
                else
                {
                    $.ajax({
                            url: 'ajax/report/dashboard.php?action=report',
                            type: 'get',
                            data: {
                                startDate:startDate,
                                endDate:endDate,
                                campaign_name:campaign_name,
                                call_center:call_center
                            },
                            success: function(response)
                            {
                                console.log(response);

                                var data = JSON.parse(response);
                                console.log(data);

                                if (data.status == 'Ok') {
                                    
                                    // var record = data.data;
                                    overAllRecord = data;
                                    $('#report_type').val('agent').change();

                                    // agentWise();
                                    $.ajax({
                                        url: 'ajax/qc/qc-details.php?action=scorecard',
                                        type: 'get',
                                        data: {
                                            fromdatevalue:startDate,
                                            todatevalue:endDate,
                                            slctcampvalue:campaign_name,
                                            call_center:call_center
                                        },
                                        success: function(response)
                                        {
                                            console.log(response);
                                            var data = JSON.parse(response);
                                            console.log(data);

                                            if (data.status == 'Ok') {
                                                qcRecord = data.data;
                                            }
                                        }
                                    });
                                }

                                else
                                {
                                    toastr.error('Error FOund!');

                                }
                            }
                        }).then(function(){
                        $.ajax({
                            url: "ajax/report/dashboard.php?action=liveagent",
                            type: "GET",
                            data: {
                                startDate:startDate,
                                endDate:endDate,
                                campaign_name:campaign_name,
                                call_center:call_center
                            },
                            success: function(response){
                                console.log(response);
                                var data = JSON.parse(response);

                                if(data.status == 'Ok')
                                {
                                    var activeCount = data.data.length;
                                    // $('#active_agent')
                                    $('#active_agent').attr('data-target', activeCount).html(activeCount);

                                }
                            }
                        });
                    })
                }
                
            });
                function agentWise(){
                console.log(overAllRecord);

                var record = overAllRecord.data;
                var total_agent = record.length;
                var total_calls = 0;
                var Hrs = 0;
                var Transfer = 0;
                var successtransfer = 0;
                var realHr = 0;
                $('.table_result').html("");
                record.forEach(function(arr, idx){
                    realHr += parseInt(arr.Hrs);
                    total_calls += parseInt(arr.Totalcalls);
                    Hrs += parseFloat(arr.Hrs/3600);
                    Transfer += parseInt(arr.Transfer);
                    successtransfer += parseInt(arr.successtransfer);
                    if(arr.camp == 'EDU_TEST')
                    {
                        var camp_name = 'EDU_TRAINING';
                    }
                    else
                    {
                        var camp_name = arr.camp;
                    }

                    current_username = $("#current_username").val();
                        if(current_username == 'PSPM'){

                    // alert();

                        $('.table_result').append(`
                        <tr>
                            <td>${camp_name}</td>
                            <td>${arr.users}</td>
                            <td>${arr.username}</td>
                            <td>${parseFloat(arr.Hrs/3600).toFixed(2)}</td>
                            <td>${arr.Totalcalls}</td>
                            <td>${arr.successtransfer}</td>
                            <td>${parseFloat((arr.successtransfer)/parseFloat(arr.Hrs/3600)).toFixed(2)}</td>
                        </tr>
                    `);


                }
                else{

                    $('.table_result').append(`
                    <tr>
                        <td>${camp_name}</td>
                        <td>${arr.users}</td>
                        <td>${arr.username}</td>
                        <td>${parseFloat(arr.Hrs/3600).toFixed(2)}</td>
                        <td>${arr.Totalcalls}</td>
                        <td>${arr.successtransfer}</td>
                        <td>${arr.Transfer}</td>
                        <td>${parseFloat((arr.successtransfer)/parseFloat(arr.Hrs/3600)).toFixed(2)}</td>
                        <td>${parseFloat((arr.Transfer)/parseFloat(arr.Hrs/3600)).toFixed(2)}</td>
                        <td>${((arr.Transfer)/(arr.Totalcalls)).toFixed(2)}</td>
                    </tr>
                `);


                }

                
            });
            console.log(realHr);
            // var hours = Math.floor(Hrs / 3600);
            // var minutes = Math.floor((Hrs % 3600) / 60);
            var hr_with_min = Hrs.toFixed(2);
            var tph_percent = (parseFloat(successtransfer) / parseFloat(hr_with_min)).toFixed(2);

            var bph_precent = parseFloat(Transfer/hr_with_min).toFixed(2);

            $('#total_calls').attr('data-target', total_calls).html(total_calls);
            $('#total_hrs').attr('data-target', hr_with_min).html(hr_with_min);
            $('#total_transfer').attr('data-target', successtransfer).html(successtransfer);
            $('#total_agent').attr('data-target', total_agent).html(total_agent);
            $('#tph_percent').attr('data-target', tph_percent).html(tph_percent);
            $('#bph_percent').attr('data-target', bph_precent).html(bph_precent);
            $('#total_billable').attr('data-target', Transfer).html(Transfer);
            // console.log(total_calls);
        }

            function callCenterWise(){
                console.log(qcRecord);
                
                var record = overAllRecord.data;
                console.log(record);
                
                const result = {};
                record.forEach(entry => {
                const centerCode = entry.users.slice(0, 4); // First 4 letters as dynamic center
                if (!result[centerCode]) {
                    result[centerCode] = {
                    total_calls: 0,
                    Hrs: 0,
                    Transfer: 0,
                    successtransfer: 0,
                    center: centerCode // you can replace with actual name if needed
                    };
                }

                result[centerCode].total_calls += parseInt(entry.Totalcalls);
                result[centerCode].Hrs += parseFloat(entry.Hrs) / 3600;
                result[centerCode].Transfer += parseInt(entry.Transfer);
                result[centerCode].successtransfer += parseInt(entry.successtransfer);
                });
                console.log(result);
                
                $('.table_result').html("");
                $.each(result, function(idx, arr){
                    // console.log(arr);
                    
                    if(arr)
                    {
                        $('.table_result').append(`
                        <tr>
                                <td>${arr.center}</td>
                                <td>${arr.Hrs.toFixed(2)}</td>
                                <td>${arr.total_calls}</td>
                                <td>${arr.successtransfer}</td>
                                <td>${arr.Transfer}</td>
                                <td>${parseFloat((arr.successtransfer)/parseFloat(arr.Hrs)).toFixed(2)}</td>
                                <td>${parseFloat((arr.Transfer)/parseFloat(arr.Hrs)).toFixed(2)}</td>
                                <td>${((arr.Transfer)/(arr.total_calls)).toFixed(2)}</td>
                            </tr>
                        `);
                    }
                    
                });

                
                // let totals = qcRecord.reduce((acc, record) => {
                //     let callCenter = record.agent_username.slice(0, 2);

                //     let total_calls = parseInt(record.total_call);
                //     let Qc = parseInt(record.QC); // Convert seconds to hours
                //     let score_card = parseInt(record.score_card);
                //     // let qcpercent = parseInt(record.score_card);
                //     // let qc_rejected = parseFloat((record.QC/record.score_card)*100).toFixed(2)
                //     if (!acc[callCenter]) {
                //         acc[callCenter] = {
                //             total_calls: 0,
                //             Qc: 0,
                //             score_card: 0
                //         };
                //     }

                //     acc[callCenter].total_calls += total_calls;
                //     acc[callCenter].Qc += Qc;
                //     acc[callCenter].score_card += score_card;
                //     // acc[callCenter].qc_rejected += parseFloat(qc_rejected);

                //     return acc;
                // }, {});
                // // console.log(totals); 
                // console.log(totals);
                
                // let sortedKeys = Object.keys(totals).sort();
                // $.each(sortedKeys, function(index, key) {
                //     console.log(key + ": ", totals[key]);
                // });
                // $.each(sortedKeys, function(index, key) {
                //     let arr = totals[key];
                //     console.log(arr);
                //     console.log(key);
                //     var thisKey = '';
                //     if(key == 'EX')
                //     {
                //         thisKey = 'EXIMIO';
                //     }
                //     else if(key == 'WI')
                //     {
                //         thisKey = 'WINGSPAN';
                //     }
                //     else if(key == 'ZD')
                //     {
                //         thisKey = 'ZEALOUS';
                //     }
                //     $('.'+thisKey+'SC').html(arr.score_card);
                //     $('.'+thisKey+'QC').html(arr.Qc);
                //     $('.'+thisKey+'QCP').html(parseFloat((arr.Qc/arr.score_card)*100).toFixed(2)+'%');
                   
                // });

            }

            // function subCallCenter(){
                
            //     var records = overAllRecord.data;
            //     var total_agent = records.length;
            //     var total_calls = 0;
            //     var Hrs = 0;
            //     var Transfer = 0;
            //     var successtransfer = 0;
            //     var above300 = 0;
            //     var billable = 0;

            //     var extotal_calls = 0;
            //     var exHrs = 0;
            //     var exTransfer = 0;
            //     var exsuccesstransfer = 0;
            //     var exabove300 = 0;
            //     var exbillable = 0;

            //     var witotal_calls = 0;
            //     var wiHrs = 0;
            //     var wiTransfer = 0;
            //     var wisuccesstransfer = 0;
            //     var wiabove300 = 0;
            //     var wibillable = 0;

            //     $('.table_result').html("");

            //     console.log(records);
            //     let uniqueCallCenters = [...new Set(records.map(function(arr) {
            //         var agent_id = arr.agent_id;
            //         var callCenter = agent_id.slice(0, 4);
            //         return callCenter;
            //     }))];
            //     console.log(uniqueCallCenters);
            //     uniqueCallCenters.forEach(function(value){
            //         console.log(value);
            //     });

            //     // records = record;

            //     let totals = records.reduce((acc, record) => {
            //         let callCenter = record.agent_id.slice(0, 4);

            //         let total_calls = parseInt(record.total_calls);
            //         let Hrs = parseFloat(record.total_hrs / 3600); // Convert seconds to hours
            //         let billable = parseInt(record.billable);
            //         let transfer = parseInt(record.transfer);
            //         let above300 = parseInt(record.above_300);

            //         if (!acc[callCenter]) {
            //             acc[callCenter] = {
            //                 total_calls: 0,
            //                 Hrs: 0,
            //                 billable: 0,
            //                 transfer: 0,
            //                 above300: 0
            //             };
            //         }

            //         acc[callCenter].total_calls += total_calls;
            //         acc[callCenter].Hrs += Hrs;
            //         acc[callCenter].billable += billable;
            //         acc[callCenter].transfer += transfer;
            //         acc[callCenter].above300 += above300;

            //         return acc;
            //     }, {});
            //     // console.log(totals); 
            //     let sortedKeys = Object.keys(totals).sort();
            //     $.each(sortedKeys, function(index, key) {
            //         console.log(key + ": ", totals[key]);
            //     });
            //     console.log(sortedKeys);
            //     $('.table_result').html("");
            //     $.each(sortedKeys, function(index, key) {
            //         let arr = totals[key];
            //         if(key == 'EXI0')
            //         {
            //             key = 'EXIMIO'
            //         }
            //         else if(key == 'WIN0')
            //         {
            //             key = 'WINGSPAN';
            //         }

            //         $('.table_result').append(`
            //             <tr>
            //                 <td>${key}</td>
            //                 <td>${parseFloat(arr.Hrs).toFixed(2)}</td>
            //                 <td>${arr.total_calls}</td>
            //                 <td>${arr.transfer}</td>
            //                 <td>${arr.billable}</td>
            //                 <td>${parseFloat((arr.transfer) / parseFloat(arr.Hrs)).toFixed(2)}</td>
            //                 <td>${parseFloat((arr.billable) / parseFloat(arr.Hrs)).toFixed(2)}</td>
            //                 <td class="${key}SC"></td>
            //                 <td class="${key}QC"></td>
            //                 <td class="${key}QCP"></td>
            //             </tr>
            //         `);
            //     });

                 
            //     let qctotals = qcRecord.reduce((acc, record) => {
            //         let callCenter = record.agent_username.slice(0, 4);

            //         let total_calls = parseInt(record.total_call);
            //         let Qc = parseInt(record.QC); // Convert seconds to hours
            //         let score_card = parseInt(record.score_card);
            //         // let qcpercent = parseInt(record.score_card);
            //         // let qc_rejected = parseFloat((record.QC/record.score_card)*100).toFixed(2)
            //         if (!acc[callCenter]) {
            //             acc[callCenter] = {
            //                 total_calls: 0,
            //                 Qc: 0,
            //                 score_card: 0
            //             };
            //         }

            //         acc[callCenter].total_calls += total_calls;
            //         acc[callCenter].Qc += Qc;
            //         acc[callCenter].score_card += score_card;
            //         // acc[callCenter].qc_rejected += parseFloat(qc_rejected);

            //         return acc;
            //     }, {});
            //     // console.log(totals); 
            //     console.log(totals);
                
            //     let qcsortedKeys = Object.keys(qctotals).sort();
            //     $.each(qcsortedKeys, function(index, key) {
            //         console.log(key + ": ", qctotals[key]);
            //     });
            //     $.each(qcsortedKeys, function(index, key) {
            //         let arr = qctotals[key];
            //         console.log(arr);
            //         console.log(key);
            //         if(key == 'EXI0')
            //         {
            //             key = 'EXIMIO'
            //         }
            //         else if(key == 'WIN0')
            //         {
            //             key = 'WINGSPAN';
            //         }
            //         $('.'+key+'SC').html(arr.score_card);
            //         $('.'+key+'QC').html(arr.Qc);
            //         $('.'+key+'QCP').html(parseFloat((arr.Qc/arr.score_card)*100).toFixed(2)+'%');
                   
            //     });
            // }
                var changeType;
            $('body').on('change', '#report_type', function(){
                var type = $(this).val();
                changeType = type;
                if(type == 'agent')
                {
                    $('.tablehead').html(`
                       <tr>
                            <th scope="col">Campaign Name</th>
                            <th scope="col">Agent ID</th>
                            <th scope="col">Agent Name</th>
                            <th scope="col">Total Hours</th>
                            <th scope="col">Total Calls</th>
                            <th scope="col">Transfer</th>
                            <?php if($current_username == 'PSPM'): ?>
                                <th scope="col">Billable</th>
                            <?php endif; ?>
                            <th scope="col">TPH</th>
                            <?php if($current_username == 'PSPM'): ?>
                                <th scope="col">BPH</th>
                                <th scope="col">SPC</th>
                            <?php endif; ?>
                        </tr>
                                            `);
                    agentWise();

                }
                else if(type == 'callcenter')
                {
                    $('.tablehead').html(`
                        <tr>
                            <th>Call Center</th>
                            <th>Total Hours</th>
                            <th>Total Calls</th>
                            <th>Transfer</th>
                            <th>Billable</th>
                            <th>TPH</th>
                            <th>BPH</th>
                            <th>SPC</th>
                        </tr>
                    `);
                    callCenterWise();

                }
                else if(type == 'subcallcenter')
                {
                    subCallCenter();
                    $('.tablehead').html(`
                    <tr>
                        <th>Call Center</th>
                        <th>Total Hours</th>
                        <th>Total Calls</th>
                        <th>Transfer</th>
                        <th>Billable</th>
                        <th>TPH</th>
                        <th>BPH</th>
                        <th>CT</th>
                        <th>CTPH</th>
                        <th>Scorecard</th>
                        <th>QC</th>
                        <th>QC%</th>
                    </tr>
                `);
                }
            });
           

            $('body').on('click', '#export_excel', function(){
                // var dateText = $('#reportrange span').html();

                // var dates = dateText.split(' - ');

                // var startDate = moment(dates[0], 'MMMM D, YYYY').format('YYYY-MM-DD');
                var startDate = $('#startDate').val();
                // var endDate = $('#endDate').val();
                var campaign_name = $('#campaign').val();

                var fileName = campaign_name+' - '+startDate;
                    var table = document.getElementById('export_table');
                    var ws = XLSX.utils.table_to_sheet(table);
                    var wb = XLSX.utils.book_new();
                    XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
                    XLSX.writeFile(wb, fileName+'.xlsx');
            });


        });
    </script>

<!-- <script type="text/javascript">

        var start = moment();
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            // 'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            // 'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            // 'This Month': [moment().startOf('month'), moment().endOf('month')],
            // 'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);
</script> -->
</body>


</html>