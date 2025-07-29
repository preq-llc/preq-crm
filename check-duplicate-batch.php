<?php
    $page = 'checkduplicate';
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
                                                        <!-- <div class="col-sm-auto d-none">
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
                                                        </div> -->
                                                        <div class="col-sm-auto">
                                                            <div class="form-group">
                                                                <label for="">Batch</label>
                                                                <select name="" class="form-control" id="batch">
                                                                    <option value="">--Choose--</option>
                                                                    <option value="1">Batch 1</option>
                                                                    <option value="2">Batch 2</option>
                                                                    <option value="3">Batch 3</option>
                                                                    <option value="4">Batch 4</option>
                                                                    <option value="5">Batch 5</option>
                                                                    <option value="6">Batch 6</option>
                                                                    <option value="7">Batch 7</option>
                                                                    <option value="8">Batch 8</option>
                                                                    <option value="9">Batch 9</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <div class="form-group">
                                                                <label for="">Upload File <i>(csv)</i></label>
                                                                <input type="file" name="" id="csv_file" class="form-control" accept=".csv">
                                                                
                                                            </div>
                                                        </div>
                                                       
                                                        <!--end col-->
                                                        <div class="col-auto">
                                                            <button type="button" class="btn btn-soft-success mt-3" id="submit"> Submit</button>
                                                        </div>
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
                                   <div class="card">
                                        <div class="text-center card-body">
                                            <div class="loading_tab d-none">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/b/b1/Loading_icon.gif" alt="loading" class="" width="300">
                                            </div>
                                            <div class="result_tab  d-none">
                                                <div class="row">
                                                    <!-- <div class="col-lg-8">
                                                        <table class="table table-borderless">
                                                            <thead>
                                                                <tr>
                                                                    <th>Sno</th>
                                                                    <th>Total No</th>
                                                                    <th>Batch No</th>
                                                                    <th>Count</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div> -->
                                                    <div class="col-lg-12">
                                                        <table class="table table-borderless">
                                                            <thead>
                                                                <tr>
                                                                    <th>Total Numbers</th>
                                                                    <th>Batch No</th>
                                                                    <th>Duplicate No</th>
                                                                    <th>Exist 3</th>
                                                                    <th>New Numbers</th>
                                                                    <th>invalid Numbers</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="table_result">
                                                                    
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    
                                                </div>
                                               
                                            </div>
                                        </div>
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
    <script src="assets/js/papaparse.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script> -->
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
            
           $('#submit').on('click', function() {
                var batch = $('#batch').val();
                var file = $('#csv_file')[0].files[0];
                // console.log(file);
                $('.loading_tab').removeClass('d-none');
                $('.result_tab').addClass('d-none');
                if(batch == "")
                {
                    toastr.error('Choose Batch');
                }
                else if(file == null)
                {
                    toastr.error('Choose File');

                }
                else
                {
                    Papa.parse(file, {
                        header: true,
                        skipEmptyLines: true,
                        complete: function(results) {
                            console.log("Finished:", results.data);
                            var arr_data = JSON.stringify(results.data);
                            $.ajax({
                                url: 'ajax/datacheck/check-duplicate-number-query.php?action=check',
                                method: 'post',
                                data: {
                                    files:arr_data,
                                    batch:batch
                                },
                                success: function(response)
                                {
                                    $('.loading_tab').addClass('d-none');

                                    $('.result_tab').removeClass('d-none');
                                    
                                    console.log(results.data.length);
                                    var total_count = results.data.length;
                                    $('.table_result').html(`
                                        <tr>
                                            <td>${total_count}</td>
                                            <td>${response.batch}</td>
                                            <td>${response.available ? response.available.length : 0}</td>
                                            <td>${response.reached_3 ? response.reached_3.length : 0}</td>
                                            <td>${response.new ? response.new.length : 0}</td>
                                            <td>${response.invalidnumbers ? response.invalidnumbers.length : 0}</td>
                                        </tr>
                                    `);
                                    exportCSV(response)
                                    
                                    // console.log(response);
                                    
                                }


                            })
                            
                        },
                        error: function(err) {
                            console.error("Error parsing CSV:", err);
                        }
                    });
                }
               
            });

                function exportCSV(response) {
                    var batch = $('#batch').val();
                    const wb = XLSX.utils.book_new();

                    // Add "available" sheet if data exists
                    if (response.available && response.available.length > 0) {
                        const availableSheet = XLSX.utils.json_to_sheet(response.available);
                        XLSX.utils.book_append_sheet(wb, availableSheet, "available");
                    }

                    // Add "invalidnumbers" sheet only if it's an array with values
                    if (Array.isArray(response.invalidnumbers) && response.invalidnumbers.length > 0) {
                        const invalidArr = response.invalidnumbers.map(num => ({ phone_no: num }));
                        const invalidSheet = XLSX.utils.json_to_sheet(invalidArr);
                        XLSX.utils.book_append_sheet(wb, invalidSheet, "invalidnumbers");
                    }

                    // Optional: Add other dynamic sheets like "new" or "reached_3"
                    if (Array.isArray(response.new) && response.new.length > 0) {
                        const newSheet = XLSX.utils.json_to_sheet(response.new.map(num => ({ phone_no: num })));
                        XLSX.utils.book_append_sheet(wb, newSheet, "new");
                    }

                    if (Array.isArray(response.reached_3) && response.reached_3.length > 0) {
                        const reachedSheet = XLSX.utils.json_to_sheet(response.reached_3.map(num => ({ phone_no: num })));
                        XLSX.utils.book_append_sheet(wb, reachedSheet, "reached_3");
                    }

                    // Export as Excel
                    XLSX.writeFile(wb, batch+".xlsx");
                }
        });
    </script>

</body>


</html>