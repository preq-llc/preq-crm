<?php
$page = 'adminpanel';
include('config.php');
include('function/session.php');
if ($logged_in_user_role == 'superadmin') {
} else {
    header("Location: dashboard.php");
    exit;
}

?>
<input type="text" id="current_username" value="<?php echo $logged_in_user_name; ?>" hidden>
<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">


<head>

    <meta charset="utf-8" />
    <title>Admin Panel | <?php echo $site_name; ?> - Dialer CRM</title>
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.9.6/tagify.min.css" rel="stylesheet" />
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
                        <div class="col-xxl-12">
                            <h5 class="mb-3">Admin Panel</h5>
                            <div class="card" style="min-height: 500px;">
                                <div class="card-body">
                                    <!-- <p class="text-muted">Use <code>custom-verti-nav-pills</code> class to create custom vertical tabs.</p> -->
                                    <div class="row">
                                        <div class="col-lg-1">
                                            <div class="nav nav-pills flex-column nav-pills-tab custom-verti-nav-pills text-center" role="tablist" aria-orientation="vertical" style="position: fixed;">
                                                <a class="nav-link active show" id="custom-v-pills-home-tab" data-bs-toggle="pill" href="#custom-v-pills-home" role="tab" aria-controls="custom-v-pills-home" aria-selected="false" tabindex="-1">
                                                    <i class="ri-user-4-line d-block fs-20 mb-1"></i>
                                                    User
                                                </a>
                                                <a class="nav-link" id="custom-v-pills-profile-tab" data-bs-toggle="pill" href="#custom-v-pills-profile" role="tab" aria-controls="custom-v-pills-profile" aria-selected="false" tabindex="-1">
                                                    <i class="ri-key-2-line d-block fs-20 mb-1"></i>
                                                    Permission
                                                </a>
                                                <a class="nav-link" id="custom-v-pills-campaign-tab" data-bs-toggle="pill" href="#custom-v-pills-campaign" role="tab" aria-controls="custom-v-pills-campaign" aria-selected="true">
                                                    <i class='bx bx-server d-block fs-20 mb-1'></i>
                                                    Campaign
                                                </a>
                                                <a class="nav-link" id="custom-v-pills-messages-tab" data-bs-toggle="pill" href="#custom-v-pills-messages" role="tab" aria-controls="custom-v-pills-messages" aria-selected="true">
                                                    <i class="ri-mail-line d-block fs-20 mb-1"></i>
                                                    Zenba
                                                </a>
                                                <a class="nav-link" id="custom-v-pills-settings-tab" data-bs-toggle="pill" href="#custom-v-pills-settings" role="tab" aria-controls="custom-v-pills-settings" aria-selected="true">
                                                    <i class="ri-tools-line d-block fs-20 mb-1"></i>
                                                    Settings
                                                </a>
                                                <a class="nav-link" id="custom-v-pills-activity-tab" data-bs-toggle="pill" href="#custom-v-pills-activity" role="tab" aria-controls="custom-v-pills-activity" aria-selected="true">
                                                    <i class="ri-history-line d-block fs-20 mb-1"></i>
                                                    Activity
                                                </a>
                                            </div>
                                        </div> <!-- end col-->
                                        <div class="col-lg-11">
                                            <div class="tab-content text-muted mt-3 mt-lg-0">
                                                <div class="tab-pane fade active show" id="custom-v-pills-home" role="tabpanel" aria-labelledby="custom-v-pills-home-tab">
                                                    <div class="col-12 text-end">
                                                        <button class="btn btn-soft-success" id="createNewUserBtn" type="button" data-bs-toggle="offcanvas" data-bs-target="#userControlCanvas">
                                                            <i class="ri-add-circle-line align-middle me-1"></i>
                                                            Create New User
                                                        </button>
                                                    </div>
                                                    <div class="header py-3">
                                                        <h3>List User</h3>
                                                    </div>
                                                    <div class="">
                                                        <table class="table table-borderless table-centered ">
                                                            <thead>
                                                                <tr>
                                                                    <th>Sno</th>
                                                                    <th>Username</th>
                                                                    <!-- <th>Password</th> -->
                                                                    <th>role</th>
                                                                    <th>group</th>
                                                                    <th>status</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $sno = 1;
                                                                $usr = mysqli_query($conn, "SELECT * FROM users ORDER BY status ASC");
                                                                while ($geu = mysqli_fetch_assoc($usr)) {

                                                                ?>
                                                                    <tr>
                                                                        <td><?php echo $sno++; ?></td>
                                                                        <td><?php echo $geu['username']; ?></td>

                                                                        <td><?php echo $geu['role']; ?></td>
                                                                        <td><?php echo $geu['group']; ?></td>
                                                                        <td><?php echo $geu['status']; ?></td>
                                                                        <td><button class="btn btn-sm btn-soft-danger updateUserBtn" data-camp="<?php echo $geu['campaign_name']; ?>" data-bs-toggle="offcanvas" data-bs-target="#userControlCanvas">Edit</button></td>

                                                                    </tr>
                                                                <?php
                                                                }

                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <!--end tab-pane-->
                                                <div class="tab-pane fade" id="custom-v-pills-profile" role="tabpanel" aria-labelledby="custom-v-pills-profile-tab">
                                                    <div class="col-12">
                                                        <select name="" id="ChooseCampForPermission" class="form-select">
                                                            <option value="">-- Choose Campaign --</option>
                                                            <?php
                                                            $cmp = mysqli_query($conn, "SELECT `campaign` FROM `allow_camps`");
                                                            while ($get_camps = mysqli_fetch_assoc($cmp)) {
                                                                echo '<option value="' . $get_camps["campaign"] . '">' . $get_camps["campaign"] . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                        <div class="table-responsive mt-5">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>UserName</th>
                                                                        <th>Permission</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="userAccessCampaignResult">

                                                                </tbody>

                                                            </table>
                                                            <div class="col-12 text-end">
                                                                <button class="btn btn-soft-success updatePermissionBtn">Update Permission</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end tab-pane-->
                                                <div class="tab-pane fade" id="custom-v-pills-campaign" role="tabpanel" aria-labelledby="custom-v-pills-campaign-tab">
                                                    <!-- <div class="d-flex mb-4">
                                                        Working on it (campaign)
                                                    </div>
                                                    <div class="d-flex">
                                                       upcoming feature <br />
                                                                create campaign <br />
                                                                list camp <br />
                                                                update camp, cluster <br />
                                                    </div> -->
                                                    <!-- <div class="d-flex mb-4"> -->
                                                    <div class="py-3 text-end col-12">
                                                        <button class="btn btn-soft-primary" data-bs-toggle="offcanvas" id="createCampCanvasBtn" data-bs-target="#campControlCanvas">
                                                            <i class="ri-add-circle-line align-middle me-1"></i>Create Campaign</button>
                                                    </div>
                                                    <table class="table table-bordered table-stiped">
                                                        <thead>
                                                            <tr>
                                                                <th>Sno</th>
                                                                <th>Campaign Name</th>
                                                                <th>Zenba Number</th>
                                                                <th>camp ip</th>
                                                                <th>status</th>
                                                                <th>action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $cmCOunt = 1;
                                                            $cmp = mysqli_query($conn, "SELECT * FROM campaigns_details ORDER BY status ASC");
                                                            while ($campDet = mysqli_fetch_assoc($cmp)) {
                                                            ?>
                                                                <tr data-rowid="<?php echo $campDet['id']; ?>">
                                                                    <td><?php echo $cmCOunt++; ?></td>
                                                                    <td><?php echo $campDet['campaign_value']; ?></td>
                                                                    <td><?php echo $campDet['zenba_number']; ?></td>
                                                                    <td><?php echo $campDet['camp_ip']; ?></td>
                                                                    <td><span class="badge bg-primary"></span><?php echo $campDet['status']; ?></td>
                                                                    <td>
                                                                        <button class="trigerCanvasEdit btn btn-sm btn-soft-success" data-bs-toggle="offcanvas" data-bs-target="#campControlCanvas">Edit</button>
                                                                    </td>
                                                                </tr>

                                                            <?php
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                    <!-- </div> -->
                                                </div>
                                                <!--end tab-pane-->
                                                <div class="tab-pane fade" id="custom-v-pills-messages" role="tabpanel" aria-labelledby="custom-v-pills-messages-tab">
                                                    <div class="col-12 text-end">
                                                        <button class="btn btn-soft-success" id="createNewUserBtn" type="button" data-bs-toggle="offcanvas" data-bs-target="#userControlCanvas">
                                                            <i class="ri-add-circle-line align-middle me-1"></i>
                                                            Zenba Control
                                                        </button>
                                                    </div>
                                                    <div class="header py-3">
                                                        <h3>List of Running Zenbas</h3>
                                                    </div>
                                                    <div class="">
                                                        <?php

                                                        ?>
                                                        <!-- <div class="accordion" id="accordionExample">
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="headingOne">
                                                                    <button class="accordion-button" style="display:flow;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                        Accordion Item #1

                                                                        <span class="badge bg-success" style=" float:right;">Running</span>
                                                                    </button>
                                                                </h2>
                                                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                                    <div class="accordion-body">
                                                                        <div class="div">
                                                                            <button class="btn btn-sm btn-primary">Add User</button>
                                                                        </div>
                                                                        <table class="table table-borderless table-striped table-sm">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <th>243434544</th>
                                                                                    <td>60</td>
                                                                                    <td>
                                                                                        <button class="btn btn-sm btn-success">R</button>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>2434345454</th>
                                                                                    <td>120</td>
                                                                                    <td>
                                                                                        <button class="btn btn-sm btn-warning">P</button>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> -->

                                                    </div>
                                                </div>
                                                <!--end tab-pane-->
                                                <div class="tab-pane fade" id="custom-v-pills-activity" role="tabpanel" aria-labelledby="custom-v-pills-activity-tab">
                                                    <div class="col-12 py-3 text-end">
                                                        Current Time: <?php echo date('Y-m-d h:i A', strtotime($today_dateTime)); ?>
                                                    </div>
                                                    <div class="d-flex mb-4">
                                                        <table class="table table-bordered table-striped">
                                                            <thead>
                                                                <th>Event</th>
                                                                <th>Activity</th>
                                                                <th>timestamp</th>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $act = mysqli_query($conn, "SELECT * FROM activity_log ORDER BY timestamp DESC LIMIT 50");
                                                                while ($activ = mysqli_fetch_assoc($act)) {

                                                                ?>
                                                                    <tr>
                                                                        <td><?php echo $activ['activity']; ?></td>
                                                                        <td style="background: whitesmoke !important;font-family: monospace;"><?php echo $activ['data']; ?></td>
                                                                        <td><?php echo date('Y-m-d h:i A', strtotime($activ['timestamp'])); ?></td>
                                                                    </tr>
                                                                <?php }; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <!--end tab-pane-->
                                            </div>
                                        </div> <!-- end col-->
                                    </div> <!-- end row-->
                                </div><!-- end card-body -->
                            </div>
                            <!--end card-->
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

    <div class="offcanvas offcanvas-end" id="userControlCanvas">
        <div class="offcanvas-header">
            <h1 class="offcanvas-title usercanvasheading">Create User</h1>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <div class="row usercanvasbody">
                <div class="col-12 pt-3">
                    <label for="">Username</label>
                    <input type="text" class="form-control" name="" id="username">
                </div>
                <div class="col-12 pt-3">
                    <label for="">Password</label>
                    <input type="text" class="form-control" name="" id="password">
                </div>
                <div class="col-12 pt-3">
                    <label for="">Role</label>
                    <select name="" id="role" class="form-select">
                        <option value="">-- choose role --</option>
                        <?php
                        // <option value=""></option>
                        $usr = mysqli_query($conn, "SELECT * FROM `users` WHERE role != 'superadmin' GROUP BY `role`");
                        while ($get_role = mysqli_fetch_assoc($usr)) {
                            echo '<option value="' . $get_role["role"] . '">' . $get_role["role"] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-12 pt-3">
                    <label for="">Campaign Name</label>
                    <input type="text" class="form-control" name="" id="campaignName">
                </div>
                <div class="col-12 pt-3">
                    <label for="">Group / Call Center</label>
                    <input type="text" class="form-control" name="" id="group">
                </div>
                <div class="col-12 pt-3">
                    <label for="">Status</label>
                    <select name="" id="status2" class="col-12 form-control">
                        <option value="ACTIVE">Active</option>
                        <option value="In-Active">Deactive</option>
                    </select>
                </div>
                <!-- <div class="col-12 pt-3">
                    <label for="">Status</label>
                    <select name="" id="status" class="form-select">
                        <option value="ACTIVE">Active</option>
                        <option value="In-Active">Deactive</option>
                    </select>
                </div> -->
                <div class="col-12 pt-2">
                    <button class="btn mt-4 btn-soft-primary" id="updateUser" data-useraction="create">Create User</button>
                    <!-- <button class="btn mt-4 btn-soft-primary d-none" id="updateUser">Update User</button> -->
                </div>
            </div>
            <!-- <button class="btn btn-secondary" type="button">Create New User</button> -->
        </div>
    </div>

    <div class="offcanvas offcanvas-end" id="campControlCanvas">
        <div class="offcanvas-header">
            <h1 class="offcanvas-title campcanvasheading">Create Campaign</h1>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <div class="row campcanvasbody">
                <div class="col-12 pt-3">
                    <label for="">Campaign Name</label>
                    <input type="text" class="form-control" name="" id="camp_name">
                </div>
                <div class="col-12 pt-3">
                    <label for="">Zenba Number</label>
                    <input type="text" class="form-control" name="" id="zenba_no">
                </div>
                <div class="col-12 pt-3">
                    <label for="">Zenba IP</label>
                    <input type="text" class="form-control" name="" id="zenba_ip">
                </div>
                <div class="col-12 pt-3">
                    <label for="">Zenba DB</label>
                    <input type="text" class="form-control" name="" id="zenba_db">
                </div>
                <div class="col-12 pt-3">
                    <label for="">Zenba Username</label>
                    <input type="text" class="form-control" name="" id="zenba_username">
                </div>
                <div class="col-12 pt-3">
                    <label for="">Zenba Password</label>
                    <input type="text" class="form-control" name="" id="zenba_pass">
                </div>
                <div class="col-12 pt-3">
                    <label for="">Campaign Cluster IP</label>
                    <input type="text" class="form-control" name="" id="camp_ip">
                </div>
                <div class="col-12 pt-3">
                    <label for="">Campaign Cluster DB</label>
                    <input type="text" class="form-control" name="" id="camp_db">
                </div>
                <div class="col-12 pt-3">
                    <label for="">Campaign Cluster Username</label>
                    <input type="text" class="form-control" name="" id="camp_user">
                </div>
                <div class="col-12 pt-3">
                    <label for="">Campaign Cluster Password</label>
                    <input type="text" class="form-control" name="" id="camp_pass">
                </div>
                <div class="col-12 pt-3">
                    <label for="">Status</label>
                    <select name="" id="status2" class="col-12 form-control">
                        <option value="ACTIVE">Active</option>
                        <option value="In-Active">Deactive</option>
                    </select>
                </div>
                <!-- <div class="col-12 pt-3">
                    <label for="">Status</label>
                    <select name="" id="status" class="form-select">
                        <option value="ACTIVE">Active</option>
                        <option value="In-Active">Deactive</option>
                    </select>
                </div> -->
                <div class="col-12 pt-2">
                    <button class="btn mt-4 btn-soft-primary" id="updatcamp" data-campaction="create">Create Campaign</button>
                    <!-- <button class="btn mt-4 btn-soft-primary d-none" id="updateUser">Update User</button> -->
                </div>
            </div>
            <!-- <button class="btn btn-secondary" type="button">Create New User</button> -->
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

    <!-- Admin Panel init -->
    <script src="assets/js/pages/Live-Status-ecommerce.init.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script> -->
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.9.6/tagify.min.js"></script>
    <script src="assets/js/xlsx.full.min.js"></script>
    <script src="assets/js/toastr.min.js"></script>
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

            var input = document.getElementById('camp_ip');
            var tagify = new Tagify(input);

            var current_username = $("#current_username").val();
            $('body').on('change', '#ChooseCampForPermission', function() {
                var campaign = $(this).val();
                $.ajax({
                    url: 'ajax/admin/adminPanel.php?action=getCampPermission',
                    type: 'get',
                    data: {
                        campaign: campaign
                    },
                    success: function(response) {
                        console.log(response);
                        var data = JSON.parse(response);
                        if (data.status == 'Ok') {
                            var record = data.data;
                            var columns = Object.keys(record[0]);
                            $('.userAccessCampaignResult').html("");
                            record.map(function(arr) {
                                columns.map(function(getvalue) {
                                    console.log(getvalue);
                                    if (getvalue != 'campaign' && getvalue != 'display_name' && getvalue != 'timestamp' && getvalue != 'status' && getvalue != 'id') {
                                        var checkStatus = '';
                                        if (arr[getvalue] == "ACCEPT") {
                                            var checkStatus = 'Checked';
                                        }
                                        $('.userAccessCampaignResult').append(`
                                            <tr data-campaign="${campaign}" data-user="${getvalue}">
                                                <td>${getvalue}</td>
                                                <td><input class="form-check-input checkBoxforAccess" type="checkbox" role="switch" ${checkStatus}></td>
                                            </tr>
                                        `)
                                    }
                                });
                            });

                        } else {

                        }
                    }
                });
            });

            $('body').on('click', '.updateUserBtn', function() {
                $('.usercanvasheading').html('Update User');
                $('#updateUser').html('Update User');
                $('#updateUser').data('useraction', 'update');
                $('#username').val($(this).closest('tr').find('td').eq(1).html());
                $('#password').val($(this).closest('tr').find('td').eq(2).html());
                $('#role').val($(this).closest('tr').find('td').eq(3).html());
                $('#campaignName').val($(this).data('camp'));
                $('#group').val($(this).closest('tr').find('td').eq(4).html());
                $('#status2').val($(this).closest('tr').find('td').eq(5).html());
                $(this).val('useraction');
                // $('#createNewUserBtn').trigger('click');
            });
            $('body').on('click', '#createNewUserBtn', function() {
                $('.usercanvasheading').html('Create User');
                $('#updateUser').html('Create User');
                $('#updateUser').data('useraction', 'create');
                $('#username').val("");
                $('#password').val("");
                $('#role').val("");
                $('#campaignName').val("");
                $('#group').val("");
                $('#status2').val("");
            });
            $('body').on('click', '#updateUser', function() {
                var username = $('#username').val();
                var password = $('#password').val();
                var role = $('#role').val();
                var campaignName = $('#campaignName').val();
                var group = $('#group').val();
                var status = $('#status2').val();
                var userAction = $(this).data('useraction');
                if (username == "") {
                    toastr.warning('Empty field!', 'Enter Username!');
                    $('#username').focus();
                } else if (password == "") {
                    toastr.warning('Empty field!', 'Enter password!');
                    $('#password').focus();
                } else if (role == "") {
                    toastr.warning('Empty field!', 'Choose role!');
                    $('#role').focus();
                } else if (campaignName == "") {
                    toastr.warning('Empty field!', 'Enter campaignName!');
                    $('#campaignName').focus();
                } else if (group == "") {
                    toastr.warning('Empty field!', 'Enter group!');
                    $('#group').focus();
                } else {
                    $.ajax({
                        url: 'ajax/admin/adminPanel.php?action=userupdate',
                        type: 'get',
                        data: {
                            username: username,
                            password: password,
                            role: role,
                            campaignName: campaignName,
                            group: group,
                            userAction: userAction,
                            status: status
                        },
                        success: function(response) {
                            var data = JSON.parse(response);
                            if (data.status == 'Ok') {
                                if (userAction == 'create') {
                                    var msg = 'New User Created!';
                                } else {
                                    var msg = 'User Updated!';
                                }
                                toastr.success(msg);

                                location.reload();
                            } else {

                            }
                        }
                    });
                }

            });

            // $('body').on('click','#campControlCanvas', function(){
            //     $('#updatcamp').data('campaction', 'create');
            //     $('#campcanvasheading').html('Campaign Update');
            // });
            $('body').on('click', '.trigerCanvasEdit', function() {
                console.log('test update');
                $('#updatcamp').data('campaction', 'update').html('Update Campaign');

                $('.campcanvasheading').html('Campaign Update');
                var rowid = $(this).closest('tr').data('rowid');
                $.ajax({
                    url: 'ajax/admin/adminPanel.php?action=getCampaign',
                    type: 'get',
                    data: {
                        rowid: rowid
                    },
                    success: function(response) {
                        console.log(response);
                        var data = JSON.parse(response);
                        if (data.status == 'Ok') {
                            var record = data.data;

                            $('#camp_ip').val(record[0].camp_ip);
                            $('#camp_name').val(record[0].campaign_value);
                            $('#zenba_no').val(record[0].zenba_number);
                            $('#zenba_ip').val(record[0].zenba_ip);
                            $('#zenba_db').val(record[0].zenba_db);
                            $('#zenba_username').val(record[0].zenba_username);
                            $('#zenba_pass').val(record[0].zenba_password);
                            $('#camp_db').val(record[0].camp_db);
                            $('#camp_user').val(record[0].db_username);
                            $('#camp_pass').val(record[0].db_password);
                            $('#status2').val(record[0].status);
                            $('#updatcamp').attr('data-campaction', 'update');
                            // if(userAction == 'create')
                            // {
                            //     var msg = 'New Campaign Created!';
                            // }
                            // else
                            // {
                            //     var msg = 'Campaign Updated!';
                            // }
                            // toastr.success();

                            // location.reload();
                        } else {

                        }
                    }
                });

            });
            $('body').on('click', '.updatePermissionBtn', function() {

                var CheckBoxUser = [];
                var CheckBoxCamp = [];

                $('.checkBoxforAccess').map(function() {
                    var checkStast = $(this).prop('checked');

                    if (checkStast == true) {
                        var getcampid = $(this).closest('tr').data('campaign');
                        var getuser = $(this).closest('tr').data('user');

                        CheckBoxCamp.push(getcampid);
                        CheckBoxUser.push(getuser);
                    }
                });

                var checkBoxUserArr = JSON.stringify(CheckBoxUser);
                var CheckBoxCampArr = JSON.stringify(CheckBoxCamp);

                var fd = new FormData();

                fd.append('checkBoxUsers', checkBoxUserArr);
                fd.append('checkBoxCamps', CheckBoxCampArr);

                $.ajax({
                    url: 'ajax/admin/adminPanel.php?action=permissionUpdate',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.status == 'Ok') {
                            toastr.success('Permission Updated!');
                        } else {
                            toastr.error('Error Found!');

                        }
                    }
                });

            });

            $('body').on('click', '#updatcamp', function() {

                var camp_ip = $('#camp_ip').val();
                var camp_name = $('#camp_name').val();
                var zenba_no = $('#zenba_no').val();
                var zenba_ip = $('#zenba_ip').val();
                var zenba_db = $('#zenba_db').val();
                var zenba_username = $('#zenba_username').val();
                var zenba_pass = $('#zenba_pass').val();
                var camp_db = $('#camp_db').val();
                var camp_user = $('#camp_user').val();
                var camp_pass = $('#camp_pass').val();
                var status2 = $('#status2').val();
                var campaction = $(this).data('campaction');
                // console.log(campaction

                // );
                // var data = JSON.parse(camp_ip);
                //     console.log(data.length);
                if (camp_name == '') {
                    toastr.warning('Enter Campaign Name');
                } else if (camp_ip == '') {
                    toastr.warning('Enter Campaign IP');
                } else if (camp_db == '') {
                    toastr.warning('Enter Campaign DB Name');

                } else if (camp_user == '') {
                    toastr.warning('Enter Campaign DB USername');

                } else if (camp_pass == '') {
                    toastr.warning('Enter Campaign DB Password');

                } else {

                    // var data = JSON.parse(camp_ip);
                    // console.log(data.length);
                    // console.log(data);

                    // var clusterIpArray = [];
                    // data.map(function(arr, idx){
                    //     clusterIpArray.push(arr.value);
                    // });
                    // console.log(clusterIpArray);

                    $.ajax({
                        // url: 'ajax/admin/a dminPanel.php?action=createCamp',
                        type: 'get',
                        data: {
                            camp_ip: camp_ip,
                            camp_name: camp_name,
                            zenba_no: zenba_no,
                            zenba_ip: zenba_ip,
                            zenba_db: zenba_db,
                            zenba_username: zenba_username,
                            zenba_pass: zenba_pass,
                            camp_db: camp_db,
                            camp_user: camp_user,
                            camp_pass: camp_pass,
                            status2: status2,
                            campaction: campaction
                        },
                        success: function(response) {
                            var data = JSON.parse(response);
                            if (data.status == 'Ok') {
                                // if(userAction == 'create')
                                // {
                                //     var msg = 'New User Created!';
                                // }
                                // else
                                // {
                                //     var msg = 'User Updated!';
                                // }
                                // toastr.success(msg);

                                // location.reload();
                            } else {

                            }
                        }
                    });
                }






            });
        });
    </script>

</body>


</html>