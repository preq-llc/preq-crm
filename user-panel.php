<?php
    $page = 'userpanel';
    include('config.php');
    include('function/session.php');
    
?>
<input type="text" id="current_username" value="<?php echo $logged_in_user_name;?>" hidden>
<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">


<head>

    <meta charset="utf-8" />
    <title>User Panel | <?php echo $site_name;?> - Dialer CRM</title>
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
                        <div class="col-xxl-12">
                            <h5 class="mb-3">User Panel</h5>
                            <div class="card" style="min-height: 500px;">
                                <div class="card-body">
                                    <!-- <p class="text-muted">Use <code>custom-verti-nav-pills</code> class to create custom vertical tabs.</p> -->
                                    <div class="row">
                                        <div class="col-lg-1">
                                            <div class="nav nav-pills flex-column nav-pills-tab custom-verti-nav-pills text-center" role="tablist" aria-orientation="vertical" style="position: fixed;">
                                                <!-- <a class="nav-link active show" id="custom-v-pills-home-tab" data-bs-toggle="pill" href="#custom-v-pills-home" role="tab" aria-controls="custom-v-pills-home" aria-selected="false" tabindex="-1">
                                                    <i class="ri-user-4-line d-block fs-20 mb-1"></i>
                                                    Users
                                                </a> -->
                                                <!-- <a class="nav-link" id="custom-v-pills-profile-tab" data-bs-toggle="pill" href="#custom-v-pills-profile" role="tab" aria-controls="custom-v-pills-profile" aria-selected="false" tabindex="-1">
                                                    <i class="ri-key-2-line d-block fs-20 mb-1"></i>
                                                    Permission
                                                </a> -->
                                                <a class="nav-link active" id="custom-v-pills-campaign-tab" data-bs-toggle="pill" href="#custom-v-pills-campaign" role="tab" aria-controls="custom-v-pills-campaign" aria-selected="true">
                                                <i class='bx bx-server d-block fs-20 mb-1'></i>
                                                    Campaign
                                                </a>
                                                <!-- <a class="nav-link" id="custom-v-pills-voip-tab" data-bs-toggle="pill" href="#custom-v-pills-voip" role="tab" aria-controls="custom-v-pills-voip" aria-selected="true">
                                                    <i class="ri-mail-line d-block fs-20 mb-1"></i>
                                                    Voip
                                                </a> -->
                                                <!-- <a class="nav-link" id="custom-v-pills-settings-tab" data-bs-toggle="pill" href="#custom-v-pills-settings" role="tab" aria-controls="custom-v-pills-settings" aria-selected="true">
                                                    <i class="ri-tools-line d-block fs-20 mb-1"></i>
                                                    Settings
                                                </a> -->
                                                <!-- <a class="nav-link" id="custom-v-pills-activity-tab" data-bs-toggle="pill" href="#custom-v-pills-activity" role="tab" aria-controls="custom-v-pills-activity" aria-selected="true">
                                                    <i class="ri-history-line d-block fs-20 mb-1"></i>
                                                    Activity
                                                </a> -->
                                            </div>
                                        </div> <!-- end col-->
                                        <div class="col-lg-11">
                                            <div class="tab-content text-muted mt-3 mt-lg-0">
                                                <div class="tab-pane fade" id="custom-v-pills-home" role="tabpanel" aria-labelledby="custom-v-pills-home-tab">
                                                    <div class="col-12 text-end">
                                                        <!-- <button class="btn btn-soft-success" id="createNewUserBtn" type="button" data-bs-toggle="offcanvas" data-bs-target="#userControlCanvas">
                                                            <i class="ri-add-circle-line align-middle me-1"></i>
                                                            Create New User
                                                        </button> -->
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
                                                                    $sno=1;
                                                                    $usr = mysqli_query($conn, "SELECT * FROM users ORDER BY status ASC");
                                                                    while($geu = mysqli_fetch_assoc($usr))
                                                                    {

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
                                                                while($get_camps = mysqli_fetch_assoc($cmp))
                                                                {
                                                                    // print_r($get_camps)
                                                                    echo '<option value="'.$get_camps["campaign"].'">'.$get_camps["campaign"].'</option>';
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
                                                <div class="tab-pane fade active show" id="custom-v-pills-campaign" role="tabpanel" aria-labelledby="custom-v-pills-campaign-tab">
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
                                                        <!-- <div class="py-3 text-end col-12">
                                                            <button class="btn btn-soft-primary" data-bs-toggle="offcanvas" id="createCampCanvasBtn" data-bs-target="#campControlCanvas">
                                                            <i class="ri-add-circle-line align-middle me-1"></i>Create Campaign</button> 
                                                            <select name="" class="form-select-sm">
                                                                <option value="" selected disabled>Status</option>
                                                                <option value="Y">Active</option>
                                                                <option value="N">Deactive</option>
                                                            </select>
                                                        </div> -->
                                                    <table class="table table-bordereless table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <!-- <th>#</th> -->
                                                                <th>Sno</th>
                                                                <th>Campaign ID</th>
                                                                <th>Campaign Name</th>
                                                                <th>Dial Method</th>
                                                                <th>Level</th>
                                                                <th>Dial Status</th>
                                                                <th>Status</th> 
                                                            </tr>
                                                        </thead>
                                                        <tbody class="campaign_body">
                                                           
                                                        </tbody>
                                                    </table>
                                                    <!-- </div> -->
                                                </div>
                                                <!--end tab-pane-->
                                                <div class="tab-pane fade" id="custom-v-pills-voip" role="tabpanel" aria-labelledby="custom-v-pills-voip-tab">

                                                 <div class="d-flex mb-4">
                                                        <div class="py-3 d-flex gap-3 col-4">  
                                                            <div class="form-group flex-grow-1">  
                                                                <label>Campaign Name</label>
                                                                <select name="campaign1" class="form-select" id="fetchcampip">  
                                                                    <option value="">-- Choose --</option>
                                                                </select>
                                                            </div>
                                                            
                                                            <div class="form-group flex-grow-1">  
                                                                <label>Status</label> 
                                                                <select name="status" class="form-select statusvoip" id="">  
                                                                    <option value="">-- Choose --</option>
                                                                    <option value="Y">Active</option>
                                                                    <option value="N">Deactive</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group flex-grow-1 mt-4">  
                                                                <button class="btn btn-primary voipsubmit">Submit</button>
                                                            </div>
                                                        </div>
                                                </div>


                                                     <table class="table table-bordereless table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th><input type="checkbox" id="totalcheckbox"></th>
                                                                <th>Sno</th>
                                                                <th>Carrier ID</th>
                                                                <th>Carrier Name</th>
                                                                <th>Server Ip</th>
                                                                <th>User Group</th>
                                                                <th>Status</th> 
                                                            </tr>
                                                        </thead>
                                                        <tbody class="voip_body">
                                                           
                                                        </tbody>
                                                    </table>
                                              
                                                </div>
                                                <!--end tab-pane-->
                                                <div class="tab-pane fade" id="custom-v-pills-activity" role="tabpanel" aria-labelledby="custom-v-pills-activity-tab">
                                                    <div class="col-12 py-3 text-end">
                                                        Current Time: <?php echo date('Y-m-d h:i A', strtotime($today_dateTime));?>
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
                                                                    while($activ = mysqli_fetch_assoc($act))
                                                                    {
                                                                    
                                                                ?>
                                                                <tr>
                                                                        <td><?php echo $activ['activity'];?></td>
                                                                        <td style="background: whitesmoke !important;font-family: monospace;"><?php echo $activ['data'];?></td>
                                                                        <td><?php echo date('Y-m-d h:i A', strtotime($activ['timestamp']));?></td>
                                                                </tr>
                                                                <?php };?>
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

            <?php include('template/footer.php');?>
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
                            while($get_role = mysqli_fetch_assoc($usr))
                            {
                                echo '<option value="'.$get_role["role"].'">'.$get_role["role"].'</option>';
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
            <h1 class="offcanvas-title campcanvasheading">Modify Campaign</h1>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <div class="row campcanvasbody">
                <div class="col-12 pt-3">
                    <label for="">Campaign ID</label>
                    <input type="text" class="form-control" name="" id="camp_id" disabled>
                </div>
                <div class="col-12 pt-3">
                    <label for="">Campaign Name</label>
                    <input type="text" class="form-control" name="" id="camp_name" disabled>
                </div>
                <div class="col-12 pt-3">
                    <label for="">auto_dial_level</label>
                    <select name="" class="form-select" id="dial_level">
                        <option value="">-- Choose --</option>
                        <option value="1">1</option>
                        <option value="1.5">1.5</option>
                        <option value="2">2</option>
                        <option value="2.5">2.5</option>
                        <option value="3">3</option>
                        <option value="3.5">3.5</option>
                        <option value="4">4</option>
                        <option value="4.5">4.5</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </div>
                <div class="col-12 pt-3">
                    <label for="">dial_prefix</label>
                    <input type="text" class="form-control" name="" id="dial_prefix">
                </div>
                <div class="col-12 pt-3">
                    <label for="">Status</label>
                    <select name="" id="statustwo" class="form-select">
                        <option value="Y">Online</option>
                        <option value="N">Offline</option>          
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
                    <button class="btn mt-4 btn-soft-primary" id="updatcamp">Save Campaign</button>
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
        document.querySelectorAll('.camp_td').forEach(td => {
            td.addEventListener('click', function (e) {
                // Prevent double toggle when clicking directly on the checkbox
                if (e.target.tagName.toLowerCase() !== 'input') {
                const checkbox = this.querySelector('.camp_selected');
                checkbox.checked = !checkbox.checked;
                }
            });
        });
        $(document).ready(function(){

            var input = document.getElementById('camp_ip');
            // var tagify = new Tagify(input);

                var current_username = $("#current_username").val();
                $.ajax({
                    url: 'ajax/admin/userPanel.php?action=getCampaign',
                    type: 'get',
                    data: {
                        current_username:current_username
                    },
                    success: function(response)
                    {
                        console.log(response);
                        var data = JSON.parse(response);
                        if(data.status == 'Ok')
                        {
                            var record = data.data;
                            console.log(record);
                            var sno = 1;
                            record.map(function(arr, idx){
                                if(arr.active == 'Y')
                                {
                                    var color = 'success';
                                    var statuss = 'Online';
                                }
                                else
                                {
                                    var color = 'danger';
                                    var statuss = 'Offline';
                                    
                                }
                                $('.campaign_body').append(`
                                  <tr data-rowid="${arr.campaign_id}" data-campaignname="${arr.campaign_name}" data-diallevel="${arr.auto_dial_level}" data-dialprefix="${arr.dial_prefix}" data-status="${arr.active}">
                                        
                                        <td>${sno++}</td>
                                        <td><p class="trigerCanvasEdit text-primary" style="cursor:pointer;" data-bs-toggle="offcanvas" data-bs-target="#campControlCanvas">${arr.campaign_id}</p></td>
                                        <td>${arr.campaign_name}</td>
                                        <td>${arr.dial_method}</td>
                                        <td>${arr.auto_dial_level}</td>
                                        <td>${arr.dial_statuses}</td>
                                        <td><span class="badge bg-${color}">${statuss}</span></td>
                                    </tr>
                                `);
                            });
                        }
                        else
                        {

                        }
                    }
                });

                $('body').on('click', '.trigerCanvasEdit', function(){
                    var this_campaign = $(this).closest('tr').data('rowid');
                    var campaignname = $(this).closest('tr').data('campaignname');
                    var diallevel = $(this).closest('tr').data('diallevel');
                    var dialprefix = $(this).closest('tr').data('dialprefix');
                    var status = $(this).closest('tr').data('status');

                    

                    $('#camp_id').val(this_campaign);
                    $('#camp_name').val(campaignname);
                    $('#dial_level').val(diallevel);
                    $('#dial_prefix').val(dialprefix);
                    $('#statustwo').val(status);

                  })


                $('#updatcamp').on('click',function(){

                    var campaign_id = $('#camp_id').val();
                   
                    var dial_level =  $('#dial_level').val();

                    var dial_prefix = $('#dial_prefix').val();
                 
                    var status_two =  $('#statustwo').val();




                    $.ajax({
                        type:'POST',
                        url:'ajax/admin/userPanel.php?action=updateCampaign',
                        data:{

                            campaign_id:campaign_id,
                            dial_level:dial_level,
                            dial_prefix:dial_prefix,
                            status_two:status_two,


                        },

                        success:function(response){

                        console.log(response);
                        var data = JSON.parse(response);
                        if(data.status == 'Ok'){



                            toastr.success('Update Successfully');



                        }else{


                            toastr.warning('Not Updated');



                        }



                        },
                        error:function(error,xhr){

                        }


                    });


                });
        });
        loadVoIPDropdowns();
        function loadVoIPDropdowns() {
                $.ajax({
                    url: 'ajax/report/campaign_query.php?action=getcampaign',
                    method: 'POST',
                    dataType: 'json',
                    success: function(data) {
                        const addDropdown = $('#fetchcampip');
                        addDropdown.empty().append('<option value="">--Choose--</option>');

                        data.forEach(function(item) {
                            const option = `<option value="${item.name}">${item.name}</option>`;
                            addDropdown.append(option);
                        });
                    },
                    error: function() {
                        toastr.error('Failed to load VoIP list.');
                    }
                });
            }


        $(document).ready(function(){



       
         
          //table data show based on ip
         $('#fetchcampip').on('change',function(){

         var server_ip = $(this).val();

            $.ajax({
                    url: 'ajax/admin/userPanel.php?action=voipshow',
                    type: 'POST',
                    data: {
                        server_ip:server_ip
                    },
                    success: function(response)
                    {
                        console.log(response);
                        var data = JSON.parse(response);
                        if(data.status == 'Ok')
                        {
                            $('.voip_body').empty();
                            var record = data.data;
                            console.log(record);
                            var sno = 1;
                            record.map(function(arr, idx){
                                if(arr.active == 'Y')
                                {
                                    var color = 'success';
                                    var statuss = 'Online';
                                }
                                else
                                {
                                    var color = 'danger';
                                    var statuss = 'Offline';
                                    
                                }
                                $('.voip_body').append(`
                                  <tr>
                                        <td><input type="checkbox" class="checkboxvoip" data-carrierid="${arr.carrier_id}" data-status="${arr.active}"></td>
                                        <td>${sno++}</td>
                                        <td>${arr.carrier_id}</td>
                                        <td>${arr.carrier_name}</td>
                                        <td>${arr.server_ip}</td>
                                        <td>${arr.user_group}</td>
                                        <td><span class="badge bg-${color}">${statuss}</span></td>
                                    </tr>
                                `);
                            });
                        }
                        else
                        {

                        }
                    }
                });


            //checkbox select

            $('#totalcheckbox').on('change', function() {
                    if ($(this).is(':checked')) {
                        // When main checkbox is checked
                        $('.checkboxvoip').prop('checked', true);
                    } else {
                        // When main checkbox is unchecked
                        $('.checkboxvoip').prop('checked', false);
                    }
            });


         });


         //update the data voip in db
        $('.voipsubmit').on('click', function() {
            // Get selected status
            var statusvoip = $('.statusvoip').val().trim();
            var server_ip = $('#fetchcampip').val().trim();
            // Validate status selection
            if (!statusvoip) {
                toastr.warning('Please select a status');
                return false; // Exit the function
            }

            if (!server_ip) {
                toastr.warning('Please select a server_ip');
                return false; // Exit the function
            }
            
            // Collect selected carrier IDs
            var selectedCarriers = [];
            $('.checkboxvoip:checked').each(function() {
                var carrier_id = $(this).data('carrierid');
                if (carrier_id) {
                    selectedCarriers.push(carrier_id);
                }
            });
            
            // Validate at least one checkbox is selected
            if (selectedCarriers.length === 0) {
                toastr.warning('Please select at least one carrier');
                return false;
            }
            
            // Prepare data for AJAX request
            var postData = {
                status: statusvoip,
                carriers: selectedCarriers,
                server_ip:server_ip
            };
            
            // Show loading indicator
            // toastr.info('Processing...', '', {timeOut: 0});
            
            // AJAX submission
            $.ajax({
                url: 'ajax/admin/userPanel.php?action=voipupdate',
                type: 'POST',
                dataType: 'json',
                data: postData,
                success: function(response) {

                   console.log(response);
                    toastr.clear(); // Clear loading indicator
                    if (response.status='success') {
                        toastr.success(response.message);
                       // window.location.reload();
                        $('.checkboxvoip:checked').each(function() {
                            var currentClass = $(this).closest('tr').find('span').html();
                            if(currentClass == 'Online')
                            {
                               var newclassClr = "bg-danger";
                               var oldclassClr = "bg-success";
                               var clsTxt = "Offline";
                            }
                            else
                            {
                                var newclassClr = "bg-success";
                                var oldclassClr = "bg-danger";
                                var clsTxt = "Online";
                                
                            }
                            $(this).closest('tr').find('span').html(clsTxt).removeClass(oldclassClr).addClass(newclassClr);
                        });
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    toastr.clear();
                    toastr.error('Error: ' + error);
                }
            });
        });


                

        });
    </script>

</body>


</html>
