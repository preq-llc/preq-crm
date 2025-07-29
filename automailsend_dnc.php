<?php
$page = 'automaticmail';
include('config.php');
include('function/session.php');

?>
<input type="text" id="current_username" value="<?php echo $logged_in_user_name; ?>" data-role="<?php echo $logged_in_user_role; ?>" hidden>
<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">


<head>

    <meta charset="utf-8" />
    <title>Automatic Mail Sending | <?php echo $site_name; ?> - Dialer CRM</title>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

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
                                    <div class="row justify-content-center mb-4">
                                        <div class="col-lg-10">
                                            <div class=" p-4 ">
                                                <form action="javascript:void(0);">
                                                    <div class="row g-4 align-items-end justify-content-center">
                                                        <div class="col-md-2 col-sm-6">
                                                            <label for="startDate" class="form-label">Start Date</label>
                                                            <input type="date" id="startDate" class="form-control" value="<?= date('Y-m-d'); ?>" />
                                                        </div>
                                                        <div class="col-md-2 col-sm-6">
                                                            <label for="endDate" class="form-label">End Date</label>
                                                            <input type="date" id="endDate" class="form-control" value="<?= date('Y-m-d'); ?>" />
                                                        </div>

                                                        <div class="col-md-3 col-sm-6">
                                                            <label for="campaign" class="form-label">Campaign</label>
                                                            <select id="campaign" name="campaign[]" class="form-select" multiple required>
                                                                <option value="">-- Choose Campaign --</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2 col-sm-6">
                                                            <label for="sendTime" class="form-label">Send Time</label>
                                                            <input type="time" id="sendTime" class="form-control" />
                                                        </div>
                                                        <div class="col-md-3 col-sm-6">
                                                            <button type="button" class="btn btn-success w-100" id="getlead_btn">
                                                                <i class="bi bi-clipboard-data me-1"></i> Schedule DNC Report
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- Get Lead Button -->
                                        </div>
                                    </div>

                                    <!--end col-->
                                </div>

                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="d-flex flex-column h-100">
                                            <div class="row" id="leadReportResult">
                                            </div><!--end row-->
                                        </div>
                                    </div>

                                </div> <!-- end .h-100-->
                            </div> <!-- end col -->
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
            $(document).ready(function() {
                var current_username = $("#current_username").val();
                var currentUserRole = $("#current_username").data('role');

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
                // var total_count
            });

            $('#getlead_btn').on('click', function() {
                // const startDate = $('#startDate').val();
                // const endDate = $('#endDate').val();

                var campaigns = ["SHOW1", "SHOW2", "SHOW3", "SHOW5"]; // use array here
                const format = 'xlsx';
                const email_to = 'support@zealousservices.com,support@preqservices.com,arun@cloverdesigngroup.com';

                if (!startDate || !endDate || !campaigns.length) {
                    alert("Please fill all fields.");
                    return;
                }

         
                $.ajax({
                    url: 'ajax/report/aupdatevalue_dnc.php?action=selectdncreport',
                    type: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        const sendTime = response.value; // Set sendTime inside callback

                        // Now that sendTime is available, make the second AJAX call
                        $.post('ajax/report/get_dncreport.php', {
                            campaign: campaigns.join(','), // Convert array to comma-separated string
                            sendTime: sendTime,
                            format: format,
                            email_to: email_to
                        }, function(res) {
                            console.log(res);
                            alert(res);
                        });
                    },
                    error: function() {
                        alert('Failed to fetch sendTime value.');
                    }
                });
            });



        </script>



</body>


</html>