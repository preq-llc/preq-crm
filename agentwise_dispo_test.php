<?php
$page = 'agentwisedispo';
include('config.php');
include('function/session.php');

?>
<input type="text" id="current_username" value="<?php echo $logged_in_user_name; ?>" data-role="<?php echo $logged_in_user_role; ?>" hidden>
<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">


<head>

    <meta charset="utf-8" />
    <title>Agent Dispo Report | <?php echo $site_name; ?> - Dialer CRM</title>
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
                                    <h4 class="card-title mb-0 flex-grow-1">AGENT WISE DISPO REPORT</h4>
                                    <div class="flex-shrink-0">
                                        <button type="button" id="export_excel" class="btn btn-soft-info btn-sm">
                                            <i class="ri-file-list-3-line align-middle"></i> Download Report
                                        </button>
                                    </div>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <table id="export_table" class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                            <thead class="table_head text-muted table-light"></thead>

                                            <tbody class="table_result">
                                                <tr>
                                                    <td colspan="8" class="text-center">No Record Found</td>
                                                </tr>
                                            </tbody>
                                            <tfoot class="table_foot"></tfoot>
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

        <?php include('template/footer.php'); ?>
    </div>
    <!-- end main content-->

    </div>
    <table id="export_table_datewise" class="table table-bordered">
        <thead class="table_head2"></thead>
        <tbody class="table_result2"></tbody>
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


            $('body').on('click', '#getRecord', function() {
                var fromdatedispo = $('#startDate').val();
                var todatedispo = $('#endDate').val();
                var campaign_id = $('#campaign').val();
                var call_center = $('#call_center').val();
                $('.table_result').html(`
                    <tr>
                        <td colspan="8" class="text-center">
                        <img src="https://wpamelia.com/wp-content/uploads/2018/11/ezgif-2-6d0b072c3d3f.gif" width="300">
                        </td>
                    </tr>
                   
                `);

                $.ajax({
                    url: 'ajax/report/agentwise_dispo_query.php?action=getuserstatsDetails',
                    type: 'get',
                    data: {
                        fromdatedispo: fromdatedispo,
                        todatedispo: todatedispo,
                        campaign_id: campaign_id,
                    },
                    success: function(response) {
                        console.log(response);

                        // Build dynamic <thead>
                        let thead = `
                    <tr>
                        <th>#</th>
                        <th>Agent ID</th>
                        <th>Agent Group</th>
                        <th>Campaign</th>
                `;
                        response.statuses.forEach(status => {
                            thead += `<th>${status}</th>`;
                        });
                        thead += '</tr>';
                        $('.table_head').html(thead);

                        // Initialize status totals
                        let statusTotals = {};
                        response.statuses.forEach(status => {
                            statusTotals[status] = 0;
                        });

                        // Build rows
                        let tbody = '';
                        if (response.users.length > 0) {
                            response.users.forEach((row, index) => {
                                tbody += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${row.user}</td>
                    <td>${row.user_group}</td>
                    <td>${row.campaign_id}</td>
                `;
                                response.statuses.forEach(status => {
                                    let count = row.statuses[status] || 0;
                                    statusTotals[status] += parseInt(count);
                                    tbody += `<td>${count}</td>`;
                                });
                                tbody += '</tr>';
                            });
                        } else {
                            tbody = `
                                    <tr>
                                        <td colspan="${4 + response.statuses.length}" class="text-center text-danger">
                                            No records found
                                        </td>
                                    </tr>
                                `;
                        }

                        $('.table_result').html(tbody);

                        // Build <tfoot> with total row
                        let tfoot = `
                            <tr class="table-secondary fw-bold">
                                <td colspan="4" class="text-end">Total</td>
                        `;
                        response.statuses.forEach(status => {
                            tfoot += `<td>${statusTotals[status]}</td>`;
                        });
                        tfoot += '</tr>';
                        $('.table_foot').html(tfoot);
                    },
                    error: function(xhr) {
                        console.error('AJAX Error:', xhr.responseText);
                    }

                });

            });


            $('body').on('click', '#export_excel', function() {
                const startDate = $('#startDate').val();
                const endDate = $('#endDate').val();
                const campaign_name = $('#campaign').val();
                const call_center = $('#call_center').val();

                if (!startDate || !endDate) {
                    alert('Please select a date range');
                    return;
                }

                const start = new Date(startDate);
                const end = new Date(endDate);
                const allDates = [];

                while (start <= end) {
                    allDates.push(new Date(start).toISOString().slice(0, 10));
                    start.setDate(start.getDate() + 1);
                }

                const finalReport = [];
                const allStatusSet = new Set();
                let completedRequests = 0;
                $('.table_result2').html('<tr><td colspan="12">Loading data...</td></tr>');

                allDates.forEach(date => {
                    $.ajax({
                        url: 'ajax/report/agentwise_dispo_query.php?action=getuserstatsDetails',
                        type: 'get',
                        data: {
                            fromdatedispo: date,
                            todatedispo: date,
                            campaign_id: campaign_name,
                            call_center: call_center
                        },
                        success: function(response) {
                            if (response && response.users) {
                                // Collect all unique statuses
                                response.statuses.forEach(status => allStatusSet.add(status));

                                finalReport.push(...response.users.map(user => ({
                                    ...user,
                                    event_time: date
                                })));
                            }
                        },
                        complete: function() {
                            completedRequests++;
                            if (completedRequests === allDates.length) {
                                if (finalReport.length === 0) {
                                    $('.table_result2').html('<tr><td colspan="12">No data found</td></tr>');
                                    return;
                                }

                                // Now render table
                                const statusKeys = Array.from(allStatusSet).sort();

                                let thead = `
                        <tr>
                            <th>#</th>
                            <th>Agent ID</th>
                            <th>Agent Group</th>
                            <th>Campaign</th>`;
                                statusKeys.forEach(status => {
                                    thead += `<th>${status}</th>`;
                                });
                                thead += '</tr>';
                                $('.table_head2').html(thead);

                                renderFinalTable(finalReport, campaign_name, startDate, endDate, statusKeys);
                            }
                        }
                    });
                });
            });

            function renderFinalTable(report, campaign_name, startDate, endDate, statusKeys) {
                const grouped = {};
                report.forEach(row => {
                    const date = row.event_time;
                    if (!grouped[date]) grouped[date] = [];
                    grouped[date].push(row);
                });

                const dates = Object.keys(grouped).sort();
                $('.table_result2').html('');

                let rowCount = 1;
                const grandTotal = {};

                dates.forEach(date => {
                    const rows = grouped[date];
                    const subtotal = {};

                    $('.table_result2').append(`
                    <tr style="background:#e8f4fc; font-weight:bold; text-align:center;">
                        <td colspan="10">Date: ${date}</td>
                    </tr>
                `);

                    rows.forEach(row => {
                        let rowHtml = `
                            <tr>
                                <td>${rowCount++}</td>
                                <td>${row.user}</td>
                                <td>${row.user_group}</td>
                                <td>${row.campaign_id}</td>
                        `;

                        statusKeys.forEach(status => {
                            const value = parseInt(row.statuses?.[status] || 0);
                            rowHtml += `<td>${value}</td>`;
                            subtotal[status] = (subtotal[status] || 0) + value;
                            grandTotal[status] = (grandTotal[status] || 0) + value;
                        });

                        rowHtml += '</tr>';
                        $('.table_result2').append(rowHtml);
                    });

                    // Subtotal row
                    let subtotalRow = `<tr style="background:#FFF3CD; font-weight:bold;"><td colspan="4">Subtotal (${date})</td>`;
                    statusKeys.forEach(status => {
                        subtotalRow += `<td>${subtotal[status] || 0}</td>`;
                    });
                    subtotalRow += '</tr>';
                    $('.table_result2').append(subtotalRow);
                });

                // Grand total row
                let grandRow = `<tr style="background:#C8E6C9; font-weight:bold; color:#1B5E20;"><td colspan="4">Grand Total</td>`;
                statusKeys.forEach(status => {
                    grandRow += `<td>${grandTotal[status] || 0}</td>`;
                });
                grandRow += '</tr>';
                $('.table_result2').append(grandRow);

                // Total rows footer
                $('.table_result2').append(`
        <tr style="background:#D1C4E9; font-weight:bold;">
            <td colspan="${4 + statusKeys.length}">Total Rows: ${report.length}</td>
        </tr>
    `);

                // Export to Excel
                const fileName = `${campaign_name} - ${startDate} to ${endDate}`;
                const tableEl = document.getElementById('export_table_datewise');

                if (tableEl) {
                    const ws = XLSX.utils.table_to_sheet(tableEl);
                    const wb = XLSX.utils.book_new();
                    XLSX.utils.book_append_sheet(wb, ws, 'Datewise Report');
                    XLSX.writeFile(wb, `${fileName}.xlsx`);
                } else {
                    alert('Table not found for export');
                }
            }


            // $('#export_excel').on('click', function() {
            //     var table = document.getElementById('export_table');
            //     var rows = table.querySelectorAll('tr');
            //     var data = [];

            //     rows.forEach(row => {
            //         var rowData = [];
            //         row.querySelectorAll('th, td').forEach(cell => {
            //             let text = cell.innerText;

            //             // Optional: convert timestamp string to Date object
            //             if (/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/.test(text)) {
            //                 rowData.push(new Date(text)); // or keep as string if preferred
            //             } else {
            //                 rowData.push(text);
            //             }
            //         });
            //         data.push(rowData);
            //     });

            //     var ws = XLSX.utils.aoa_to_sheet(data);
            //     var wb = XLSX.utils.book_new();
            //     XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

            //     var startDate = $('#startDate').val();
            //     var campaign_name = $('#campaign').val();
            //     if (campaign_name === 'FTE_ALL') campaign_name = 'EDU_SB_ALL';
            //     var fileName = campaign_name + ' - ' + startDate;

            //     XLSX.writeFile(wb, fileName + '.xlsx');
            // });

        });
    </script>

</body>


</html>