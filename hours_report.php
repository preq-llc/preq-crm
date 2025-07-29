<?php
$page = 'hoursreport';
include('config.php');
include('function/session.php');

?>
<input type="text" id="current_username" value="<?php echo $logged_in_user_name; ?>" data-role="<?php echo $logged_in_user_role; ?>" hidden>
<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">


<head>

    <meta charset="utf-8" />
    <title>Hours Report | <?php echo $site_name; ?> - Dialer CRM</title>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script> -->


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
                                                <button class="btn d-block mt-3 btn-soft-danger" id="listViewExportTablebtn">Export List View</button>
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
                                                                <input type="date" id="startDate" value="<?php echo $today_date; ?>" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <div class="form-group">
                                                                <label for="">End date</label>
                                                                <input type="date" id="endDate" value="<?php echo $today_date; ?>" class="form-control">
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

                                                            <div class="dropdown">
                                                                <button class="form-control text-start dropdown-toggle" type="button" id="callCenterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    Select Call Center(s)
                                                                </button>
                                                                <ul class="dropdown-menu p-2" aria-labelledby="callCenterDropdown" style="max-height: 200px; overflow-y: auto;">
                                                                    <?php
                                                                    $single_callcenter = explode(",", $logged_in_user_group);

                                                                    if ($logged_in_user_role == "teamleader" || $logged_in_user_role == "superadmin") {
                                                                        echo '<li><div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" id="center_all" value="all">
                                                                        <label class="form-check-label" for="center_all">-- ALL --</label>
                                                                    </div></li>';
                                                                    }

                                                                    $centercount = 0;
                                                                    foreach ($single_callcenter as $center) {
                                                                        if ($center) {
                                                                            $center_trimmed = trim($center);
                                                                            echo '<li><div class="form-check">
                                                                        <input class="form-check-input center-option" type="checkbox" name="call_center[]" value="' . $center_trimmed . '" id="center_' . $centercount . '">
                                                                        <label class="form-check-label" for="center_' . $centercount . '">' . $center_trimmed . '</label>
                                                                    </div></li>';

                                                                            $centercount++;
                                                                        }
                                                                    }

                                                                    if ($centercount == 0) {
                                                                        echo '<li><span class="text-muted">-- No Centers Found --</span></li>';
                                                                    }
                                                                    ?>
                                                                </ul>
                                                            </div>
                                                        </div>

                                                        <div class="col-auto">
                                                            <button type="button" class="btn btn-soft-success mt-3" id="getRecord"><i class="ri-add-circle-line align-middle me-1"></i>
                                                                Get Hour
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
                                            <div class="row" id="hoursReportResult">
                                            </div><!--end row-->
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="barchart_graph" style="display: none;">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Hourly Chart</h5>

                                                <div class="mb-4">
                                                    <canvas id="hoursBarChart" height="500" width="1200"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Hourly Graph</h5>
                                                <div>
                                                    <canvas id="hoursGraph" height="600" width="1200"></canvas>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div> <!-- end .h-100-->
                        </div> <!-- end col -->
                    </div>



                    <!-- <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">AGENT PERFORMANCE SUMMARY</h4>
                                    <div class="flex-shrink-0">
                                        <button type="button" id="export_excel" class="btn btn-soft-info btn-sm">
                                            <i class="ri-file-list-3-line align-middle"></i> Download Report
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <table id="export_table" class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                            <thead class="text-muted table-light">
                                                <tr>
                                                    <th scope="col">Sno</th>
                                                    <th scope="col">Lead ID</th>
                                                    <th scope="col">Campaign ID</th>
                                                    <th scope="col">Agent ID</th>
                                                    <th scope="col">Agent Name</th>
                                                    <th scope="col">Created Date/Time</th>
                                                  
                                                </tr>
                                            </thead>
                                            <tbody class="table_result">
                                                <tr>
                                                    <td colspan="8" class="text-center">No Record Found</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div> -->
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
    <!-- Offcanvas -->
    <div class="offcanvas offcanvas-end w-75" tabindex="-1" id="hourlyOffcanvas" aria-labelledby="hourlyOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="hourlyOffcanvasLabel">Hourly List Info</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>SNo</th>
                        <th>List ID</th>
                        <th>Campaign ID</th>
                        <th>List Name</th>
                        <th>List Description</th>
                        <th>Status Count</th>
                        <th>Transfer</th>
                    </tr>
                </thead>
                <tbody id="hourlyModalBody">
                    <tr>
                        <td colspan="3" class="text-center">Loading...</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-end">Total</th>
                        <th id="totalStatusCount">0</th>
                        <th id="totalSuccessTransfer">0</th>
                    </tr>
                </tfoot>

            </table>
        </div>
    </div>
    <table class="table d-none" id="listViewExportTable">
        <thead>
            <tr>
                <th>hours</th>
                <th>total count</th>
                <th>total hours</th>
                <th>TPH</th>
            </tr>
        </thead>
        <tbody class="listViewTable">

        </tbody>
    </table>
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
            const $allCheckbox = $('#center_all');
            const $centerOptions = $('.center-option');

            $allCheckbox.on('change', function() {
                $centerOptions.prop('checked', $(this).is(':checked'));
            });

            $centerOptions.on('change', function() {
                const total = $centerOptions.length;
                const checked = $centerOptions.filter(':checked').length;
                $allCheckbox.prop('checked', total === checked);
            });
            // var total_count;
            $('body').on('click', '#getRecord', function() {
                const fromdatevalue = $('#startDate').val();
                const todatevalue = $('#endDate').val();
                const slctcampvalue = $('#campaign').val();

                // Get selected call centers
                const call_centervalue = $('.center-option:checked').map(function() {
                    return $(this).val();
                }).get(); // Returns an array

                console.log(call_centervalue); // Debug output

                // Display default message before AJAX
                $('.table_result').html(`
                <tr>
                    <td colspan="8" class="text-center">No Record Found</td>
                </tr>
                    `);

                // Validation
                if (!fromdatevalue) {
                    toastr.warning('Please Choose Start date!');
                    $('#startDate').focus();
                    return;
                }

                if (!todatevalue) {
                    toastr.warning('Please Choose End date!');
                    $('#endDate').focus();
                    return;
                }

                // Call your data fetch function
                handleTotalCount(fromdatevalue, todatevalue, slctcampvalue, call_centervalue);
            });

            let hoursChart = null; // Define chart reference globally or outside the function

            function handleTotalCount(fromdatevalue, todatevalue, slctcampvalue, centers) {
                $.ajax({
                    url: 'ajax/report/hours_query.php?action=gethoursreport',
                    type: 'GET',
                    dataType: 'json', // Ensure response is parsed as JSON
                    data: {
                        fromdatevalue,
                        todatevalue,
                        slctcampvalue,
                        call_centervalue: centers.join(',') // Join array into comma-separated string
                    },
                    success: function(response) {
                        console.log(response);
                        $('#hoursReportResult').html("");
                        $('.listViewTable').html("");

                        const record = response.data || [];

                        if (record.length === 0) {
                            $('#hoursReportResult').html("<p>No data available</p>");
                            $('#barchart_graph').hide();
                            return;
                        }

                        record.forEach(arr => {
                            let rawTotalHours = arr.totalhours / 3600;
                            let totalHours = rawTotalHours.toFixed(2);

                            // Avoid division by zero
                            let didcount = rawTotalHours > 0 ? (arr.hours_cunt / rawTotalHours).toFixed(2) : "0.00";

                            $('#hoursReportResult').append(`
                                <div class="col-xl-2 col-md-2 hoursStatsCard" data-bs-toggle="offcanvas" data-bs-target="#hourlyOffcanvas" aria-controls="hourlyOffcanvas" data-hours="${arr.full_hours}" data-campaignid="${arr.campaignid}" style="cursor:pointer;">
                                    <div class="card card-animate overflow-hidden">
                                        <div class="card-body" style="z-index:1;">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <h4 class="fs-22 fw-bold ff-secondary mb-1">${arr.hours_cunt}</h4>
                                                </div>
                                                <div class="flex-shrink-0 text-success">
                                                    Hours: ${totalHours}<br>
                                                    TPH: ${didcount}
                                                </div>
                                            </div>
                                            <small class="text-secondary">${arr.full_hours}</small>
                                        </div>
                                    </div>
                                </div>
                            `);

                            $('.listViewTable').append(`
                                <tr>
                                    <td>${arr.hours}</td>
                                    <td>${arr.hours_cunt}</td>
                                    <td>${totalHours} hrs</td>
                                    <td>${didcount} hrs</td>
                                </tr>
                            `);
                        });

                        // Total Count Card
                        $('#hoursReportResult').append(`
                            <div class="col-xl-2 col-md-2">
                                <div class="card card-animate overflow-hidden">
                                    <div class="card-body" style="z-index:1;">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-3">Total Count</p>
                                                <h4 class="fs-22 fw-bold ff-secondary mb-0">${response.total_count}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);

                        $('.listViewTable').append(`
                            <tr>
                                <td><b>Total</b></td>
                                <td><b>${response.total_count}</b></td>
                                <td></td>
                                <td></td>
                            </tr>
                        `);

                        $('#barchart_graph').show(); // Show the chart if you hide it when no data
                        // Prepare labels and data
                        const labels = record.map(arr => {
                            const rawHours = arr.totalhours / 3600;
                            const didCount = rawHours > 0 ? (arr.hours_cunt / rawHours).toFixed(2) : "0.00";
                            return `${arr.hours} (${didCount})`;
                        });

                        const data = record.map(arr => arr.hours_cunt);
                        const didCounts = record.map(arr => {
                            const rawTotalHours = arr.totalhours / 3600;
                            return rawTotalHours !== 0 ? parseFloat((arr.hours_cunt / rawTotalHours).toFixed(2)) : 0;
                        });

                        // Helper function to draw rounded rect for tooltip box
                        function roundRect(ctx, x, y, width, height, radius, fill, stroke) {
                            if (typeof stroke === 'undefined') {
                                stroke = true;
                            }
                            if (typeof radius === 'undefined') {
                                radius = 5;
                            }
                            if (typeof radius === 'number') {
                                radius = {
                                    tl: radius,
                                    tr: radius,
                                    br: radius,
                                    bl: radius
                                };
                            } else {
                                const defaultRadius = {
                                    tl: 0,
                                    tr: 0,
                                    br: 0,
                                    bl: 0
                                };
                                for (let side in defaultRadius) {
                                    radius[side] = radius[side] || defaultRadius[side];
                                }
                            }
                            ctx.beginPath();
                            ctx.moveTo(x + radius.tl, y);
                            ctx.lineTo(x + width - radius.tr, y);
                            ctx.quadraticCurveTo(x + width, y, x + width, y + radius.tr);
                            ctx.lineTo(x + width, y + height - radius.br);
                            ctx.quadraticCurveTo(x + width, y + height, x + width - radius.br, y + height);
                            ctx.lineTo(x + radius.bl, y + height);
                            ctx.quadraticCurveTo(x, y + height, x, y + height - radius.bl);
                            ctx.lineTo(x, y + radius.tl);
                            ctx.quadraticCurveTo(x, y, x + radius.tl, y);
                            ctx.closePath();
                            if (fill) {
                                ctx.fill();
                            }
                            if (stroke) {
                                ctx.stroke();
                            }
                        }

                        // Static tooltip plugin
                        const staticTooltipPlugin = {
                            id: 'staticTooltip',
                            afterDatasetsDraw(chart) {
                                const {
                                    ctx
                                } = chart;
                                chart.data.datasets.forEach((dataset, datasetIndex) => {
                                    const meta = chart.getDatasetMeta(datasetIndex);
                                    meta.data.forEach((point, index) => {
                                        const value = dataset.data[index];
                                        // Access the custom property tphData here
                                        const tph = dataset.tphData ? dataset.tphData[index] : 0;
                                        const text = `Count: ${value} | TPH: ${tph}`;

                                        ctx.save();

                                        // Reduced font size to fit better
                                        ctx.font = '11px sans-serif';
                                        ctx.textBaseline = 'middle';
                                        ctx.textAlign = 'center';

                                        // Tooltip dimensions
                                        const textWidth = ctx.measureText(text).width;
                                        const paddingX = 6; // tighter horizontal padding
                                        const paddingY = 2; // tighter vertical padding
                                        const rectWidth = textWidth + paddingX * 2;
                                        const rectHeight = 18; // reduced height

                                        // Arrow settings
                                        const arrowHeight = 6;
                                        const spacing = 0; // no gap between box and arrow

                                        // Tooltip box coordinates (adjust upward if needed)
                                        let rectX = point.x - rectWidth / 2;
                                        let rectY = point.y - rectHeight - arrowHeight - spacing;

                                        // Prevent box from going out of canvas top
                                        if (rectY < 0) {
                                            rectY = point.y + arrowHeight + spacing;
                                        }

                                        // Draw tooltip box
                                        ctx.fillStyle = 'rgba(78, 115, 223, 0.85)';
                                        ctx.shadowColor = 'rgba(0, 0, 0, 0.3)';
                                        ctx.shadowBlur = 4;
                                        ctx.shadowOffsetX = 1;
                                        ctx.shadowOffsetY = 1;
                                        const radius = 5;
                                        roundRect(ctx, rectX, rectY, rectWidth, rectHeight, radius, true, false);

                                        // Arrow coordinates
                                        const arrowX = point.x;
                                        const arrowY = (rectY < point.y) ? rectY + rectHeight : rectY; // arrow points up or down

                                        // Draw arrow (dark, matches box)
                                        ctx.fillStyle = '#000';
                                        ctx.shadowColor = 'rgba(0, 0, 0, 0.3)';
                                        ctx.shadowBlur = 3;
                                        ctx.shadowOffsetX = 1;
                                        ctx.shadowOffsetY = 1;

                                        ctx.beginPath();
                                        if (rectY < point.y) {
                                            // arrow pointing down
                                            ctx.moveTo(arrowX - 6, arrowY);
                                            ctx.lineTo(arrowX + 6, arrowY);
                                            ctx.lineTo(arrowX, arrowY + arrowHeight);
                                        } else {
                                            // arrow pointing up
                                            ctx.moveTo(arrowX - 6, arrowY);
                                            ctx.lineTo(arrowX + 6, arrowY);
                                            ctx.lineTo(arrowX, arrowY - arrowHeight);
                                        }
                                        ctx.closePath();
                                        ctx.fill();

                                        // Draw text
                                        ctx.fillStyle = '#fff';
                                        ctx.fillText(text, point.x, rectY + rectHeight / 2);

                                        ctx.restore();
                                    });
                                });
                            }
                        };

                        // Destroy old charts if they exist
                        if (window.hoursChart) {
                            window.hoursChart.destroy();
                            window.hoursChart = null;
                        }
                        if (window.hoursGraphChart) {
                            window.hoursGraphChart.destroy();
                            window.hoursGraphChart = null;
                        }

                        // Register plugin
                        Chart.register(staticTooltipPlugin);

                        // Bar Chart
                        const ctx1 = document.getElementById('hoursBarChart').getContext('2d');
                        window.hoursChart = new Chart(ctx1, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Hour Count',
                                    data: data,
                                    // Attach didCounts here as tphData
                                    tphData: didCounts,
                                    backgroundColor: [
                                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                                        '#9966FF', '#FF9F40', '#00C49F', '#FF6F91',
                                        '#845EC2', '#2C73D2', '#0081CF', '#B39CD0'
                                    ],
                                    borderColor: '#fff',
                                    borderWidth: 1,
                                    borderRadius: 5,
                                    hoverBackgroundColor: '#111'
                                }]
                            },
                            options: {
                                responsive: true,
                                animation: {
                                    duration: 800,
                                    easing: 'easeOutBounce'
                                },
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    tooltip: {
                                        enabled: false
                                    }, // Disable default tooltip
                                    staticTooltip: {}
                                },
                                scales: {
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Hours Time',
                                            color: '#444',
                                            font: {
                                                weight: 'bold'
                                            }
                                        }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Transfers / TPH',
                                            color: '#444',
                                            font: {
                                                weight: 'bold'
                                            }
                                        }
                                    }
                                }
                            }
                        });

                        // Line Chart
                        const ctx2 = document.getElementById('hoursGraph').getContext('2d');
                        window.hoursGraphChart = new Chart(ctx2, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Hour Count',
                                    data: data,
                                    // Attach didCounts here as tphData as well
                                    tphData: didCounts,
                                    backgroundColor: 'rgba(78, 115, 223, 0.05)',
                                    borderColor: '#4e73df',
                                    borderWidth: 2,
                                    pointBackgroundColor: '#1cc88a',
                                    tension: 0.4,
                                    fill: true
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    tooltip: {
                                        enabled: false
                                    }, // Disable default tooltip
                                    staticTooltip: {}
                                },
                                scales: {
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Hours Time',
                                            font: {
                                                weight: 'bold'
                                            },
                                            color: '#666'
                                        }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Transfers / TPH',
                                            font: {
                                                weight: 'bold'
                                            },
                                            color: '#666'
                                        }
                                    }
                                }
                            }
                        });

                    }
                });
            }

            $(document).on("click", ".hoursStatsCard", function() {
                let hourRange = $(this).data("hours"); // e.g., "01:00 PM - 02:00 PM"
                let campaignId = $(this).data("campaignid"); // campaign ID
                var call_centervalue = $('#call_center').val();
                let fromDate = $('#startDate').val(); // Only fromDate is used

                let startHour = convertTo24(hourRange.split(" - ")[0]);

                $.ajax({
                    url: "ajax/report/hours_query.php",
                    method: "POST",
                    dataType: "json",
                    data: {
                        action: "getHourlyListData",
                        campaign_id: campaignId,
                        call_centervalue: call_centervalue,
                        selected_date: fromDate,
                        hour: startHour
                    },
                    success: function(data) {
                        let body = '';
                        let totalStatusCount = 0;
                        let totalSuccessTransfer = 0;

                        if (data.length > 0) {
                            data.forEach((row, index) => {
                                totalStatusCount += parseInt(row.total_count);
                                totalSuccessTransfer += parseInt(row.successtransfer);

                                body += `<tr>
                                    <td>${index + 1}</td>
                                    <td>${row.list_id}</td>
                                    <td>${row.campaign_id}</td>
                                    <td>${row.list_name}</td>
                                    <td>${row.list_description}</td>
                                    <td>${row.total_count}</td>
                                    <td>${row.successtransfer}</td>
                                </tr>`;
                            });
                        } else {
                            body = `<tr><td colspan="7" class="text-center">No records found</td></tr>`;
                        }

                        $("#hourlyModalBody").html(body);
                        $("#totalStatusCount").text(totalStatusCount);
                        $("#totalSuccessTransfer").text(totalSuccessTransfer);
                    }

                });
            });

            function convertTo24(time12h) {
                const [time, modifier] = time12h.split(" ");
                let [hour] = time.split(":");
                hour = parseInt(hour);
                if (modifier === "PM" && hour !== 12) hour += 12;
                if (modifier === "AM" && hour === 12) hour = 0;
                return hour;
            }

            $('#export_excel').on('click', function() {
                var table = document.getElementById('export_table');
                var rows = table.querySelectorAll('tr');
                var data = [];

                rows.forEach(row => {
                    var rowData = [];
                    row.querySelectorAll('th, td').forEach(cell => {
                        let text = cell.innerText;

                        // Optional: convert timestamp string to Date object
                        if (/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/.test(text)) {
                            rowData.push(new Date(text)); // or keep as string if preferred
                        } else {
                            rowData.push(text);
                        }
                    });
                    data.push(rowData);
                });

                var ws = XLSX.utils.aoa_to_sheet(data);
                var wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
                var startDate = $('#startDate').val();
                var campaign_name = $('#campaign').val();
                if (campaign_name === 'FTE_ALL') campaign_name = 'EDU_SB_ALL';
                var fileName = campaign_name + ' - ' + startDate;
                XLSX.writeFile(wb, fileName + '.xlsx');
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
        // $(function() {
        //                             $('audio').audioPlayer();
        //                     });
    </script>

</body>


</html>