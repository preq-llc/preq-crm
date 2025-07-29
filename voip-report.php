<?php
$page = 'voipreport';
include('config.php');
include('function/session.php');
?>
<input type="text" id="current_username" value="<?php echo $logged_in_user_name; ?>" hidden>
<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>Voip Report | Zealous - Dialer CRM</title>
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
    <!-- html2canvas library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- jsPDF library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.js" integrity="sha512-Bw9Zj8x4giJb3OmlMiMaGbNrFr0ERD2f9jL3en5FmcTXLhkI+fKyXVeyGyxKMIl1RfgcCBDprJJt4JvlglEb3A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

    <style>
        .loadingimage {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.7);
            /* Optional: slight background overlay */
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>


</head>

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
                                            <h4 class="fs-16 mb-1">Welcome Back, <?php echo $logged_in_user_name;?>!</h4>
                                            <p class="text-muted mb-0">Voip report details</p>
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
                                                                <input type="date" id="fromdatefetch" value="<?php echo $today_date; ?>" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <div class="form-group">
                                                                <label for="">End date</label>
                                                                <input type="date" id="todatefetch" value="<?php echo $today_date; ?>" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <div class="form-group">
                                                                <label for="">Campaign Name</label>
                                                                <select name="" class="form-select" id="fetchcampip">
                                                                    <option value="">-- Choose --</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button" class="btn btn-soft-success mt-3" id="btnsfetchd"><i class="ri-add-circle-line align-middle me-1"></i>
                                                                Get Voip Reports
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
                                    <h4 class="card-title mb-0 flex-grow-1">Voip Report Details</h4>
                                    <div class="flex-shrink-0">
                                        <button type="button" id="voipreport_exportbtn" class="btn btn-soft-info btn-sm">
                                            <i class="ri-file-list-3-line align-middle"></i> Download Report
                                        </button>
                                    </div>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <table id="voipreport_table" class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                            <thead class="text-muted table-light">
                                                <tr>
                                                    <th scope="col">Campaign ID</th>
                                                    <th scope="col">Total Calls</th>
                                                    <th scope="col">AM Auto</th>
                                                    <th scope="col">Human Answer</th>
                                                    <th scope="col">AA & HA</th>
                                                    <th scope="col">Percentage %</th>
                                                    <th scope="col">Call %</th>
                                                    <th scope="col">Voip Usage</th>
                                                    <th scope="col">Total Hrs</th>
                                                </tr>
                                            </thead>
                                            <tbody id="fetchalldata">
                                                <div id="loader" class="loadingimage" style="display: none;">
                                                    <img src="assets/images/loading_img/Animation - 1745953004503.gif" alt="Loading..." />
                                                </div>


                                                <tr>
                                                    <td colspan="8" class="text-center">No Record Found</td>
                                                </tr>
                                            </tbody>
                                            <tfoot id="totalFooter" class="text-muted table-light">
                                                    <tr>
                                                        <th>Total</th>
                                                        <th id="totalCallsFooter"></th>
                                                        <th id="totalAMFooter"></th>
                                                        <th id="totalHumanFooter"></th>
                                                        <th id="totalAAHA"></th>
                                                        <th id="totalPercentage"></th>
                                                        <th id="totalCalls"></th>
                                                        <th id="voipusage"></th>
                                                    </tr>
                                                </tfoot>
                                        </table>

                                    </div>
                                </div>
                            </div> <!-- .card-->
                        </div> <!-- .col-->

                    </div>

                    <div class="row">
                        <div class="col">

                            <div class="h-100">
                                <div class="row mb-3 pb-1">
                                    <div class="col-12">
                                        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                            <div class="flex-grow-1">
                                            </div>
                                        </div><!-- end card header -->
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </div> <!-- end .h-100-->
                        </div> <!-- end col -->
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
    <!-- jQuery (required before Chosen) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Chosen CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">

    <!-- Chosen JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
    <!--voip report js -->
    <script src="assets/js/voipreports.js?66666777798888"></script>
   <!-- <script src="assets/js/hrsfetchview.js?888845555"></script> -->
    <!-- <script src="assets/js/voipusage_summary.js?55345535"></script> -->
    <!-- <script src="assets/js/voipreport_count.js?23523523"></script> -->
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
            //default loading funtion 
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

            $('body').on('click', '#voipreport_exportbtn', function() {
                const table = document.getElementById('voipreport_table');

                if (!table) {
                    alert("Table not found!");
                    return;
                }

                // Optional: check if the table has any data rows
                const rows = table.querySelectorAll("tbody tr");
                if (rows.length === 0) {
                    alert("No data to export!");
                    return;
                }

                const startDate = $('#fromdatefetch').val() || new Date().toISOString().split('T')[0];
                const fileName = 'voip_report - ' + startDate;

                const ws = XLSX.utils.table_to_sheet(table);
                const wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

                XLSX.writeFile(wb, fileName + '.xlsx');
            });



        });

        $(document).ready(function() {


        })

        $("#fetchcamp").change(function() {
            var selectedCountry = $("#fetchcamp option:selected").text();

            if (selectedCountry == 'NPDC9 - REV MORTGAGE_NPDC') {

                $("#transfertextchange").text("");
                $("#transfertextchange").text("Manual connected");
                $("#tphchangetxt").text("");
                $("#tphchangetxt").text("MPH");
                $("#transferchangetxt").text("");
                $("#transferchangetxt").text("Manual connected");
                $("#changetphtxt").text("");
                $("#changetphtxt").text("MPH");
            }

            if (selectedCountry != 'NPDC9 - REV MORTGAGE_NPDC') {

                $("#transfertextchange").text("");
                $("#transfertextchange").text("Transfer connected");
                $("#tphchangetxt").text("");
                $("#tphchangetxt").text("TPH");
                $("#transferchangetxt").text("");
                $("#transferchangetxt").text("Transfer connected");
                $("#changetphtxt").text("");
                $("#changetphtxt").text("TPH");
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#fetchcamp").chosen();
        });
        // setInterval(function () {
        // $('#btnsfetchd').trigger('click');
        // }, 1500); 

    </script>

</body>


</html>