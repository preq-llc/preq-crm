<?php
$page = 'voipusage';
include('config.php');
include('function/session.php');

?>
<input type="text" id="current_username" value="<?php echo $logged_in_user_name; ?>" hidden>
<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">


<head>

    <meta charset="utf-8" />
    <title>Voip Usage | Zealous - Dialer CRM</title>
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


                                        <div class="row">
                                            <div class="col-xl-4 col-md-6">
                                                <!-- card -->
                                                <div class="card card-animate">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-grow-1 overflow-hidden">
                                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">

                                                                    Amount Paid</p>
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
                                                                    <span class="counter-value" id="amount_paid" data-target="0">0</span>
                                                                </h4>
                                                                <!-- <a href="#" class="text-decoration-underline text-muted">Total Agents</a> -->
                                                            </div>
                                                            <div class="avatar-sm flex-shrink-0">
                                                                <span class="avatar-title bg-warning-subtle rounded fs-3">
                                                                    <i class="bx bx-phone-call text-warning"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div><!-- end card body -->
                                                </div><!-- end card -->
                                            </div><!-- end col -->

                                            <div class="col-xl-4 col-md-6">
                                                <!-- card -->
                                                <div class="card card-animate">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-grow-1 overflow-hidden">
                                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                                    Amount Usage
                                                                </p>
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
                                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="0" id="amount_usage">0</span></h4>
                                                                <!-- <a href="#" class="text-decoration-underline text-muted">Currently Active Agents</a> -->
                                                            </div>
                                                            <div class="avatar-sm flex-shrink-0">
                                                                <span class="avatar-title bg-info-subtle rounded fs-3">
                                                                    <i class="bx bx-phone-call text-success"></i>

                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div><!-- end card body -->
                                                </div><!-- end card -->
                                            </div><!-- end col -->

                                            <div class="col-xl-4 col-md-6">
                                                <!-- card -->
                                                <div class="card card-animate">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-grow-1 overflow-hidden">
                                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                                    Balance Amount
                                                                </p>
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
                                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="0" id="balance_data">0</span>
                                                                </h4>
                                                                <!-- <a href="#" class="text-decoration-underline text-muted">Total Hours</a> -->
                                                            </div>
                                                            <div class="avatar-sm flex-shrink-0">
                                                                <span class="avatar-title bg-info-subtle rounded fs-3">
                                                                    <i class="bx bx-phone-call text-info"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div><!-- end card body -->
                                                </div><!-- end card -->
                                            </div><!-- end col -->
                                        </div>
                                        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                            <div class="flex-grow-1">

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
                                                                <input type="date" id="startdate" value="<?php echo $today_date; ?>" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <div class="form-group">
                                                                <label for="">End date</label>
                                                                <input type="date" id="enddate" value="<?php echo $today_date; ?>" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <div class="form-group">
                                                                <label for="">Voip</label>
                                                                <select name="" id="voip_list" class="form-select">
                                                                    <option value="">-- Choose --</option>

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button" class="btn btn-soft-success mt-3" id="usage_data"><i class="ri-add-circle-line align-middle me-1"></i>
                                                                Get Voip Details
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

                        <div class="row">

                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Voip Usage Details</h4>
                                        <div class="flex-shrink-0">
                                            <button type="button" id="export_pdf_one" class="btn btn-soft-info btn-sm" onclick="convert_pdf()">
                                                <i class="ri-file-list-3-line align-middle"></i> Download Report
                                            </button>
                                        </div>
                                    </div><!-- end card header -->

                                    <div class="card-body">
                                        <div class="table-responsive table-card">
                                            <table id="pdfcontainer" class="table table-borderless table-centered align-middle table-nowrap mb-0 table-image">
                                                <thead class="text-muted table-light">
                                                    <tr>
                                                        <th scope="col">Sno</th>
                                                        <th scope="col">Voip</th>
                                                        <th scope="col">Date</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col">DID</th>
                                                        <th scope="col">Balance Amount</th>
                                                        <th scope="col">Person</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table_voip_usage">
                                                    <tr>
                                                        <td colspan="11" class="text-center">No Record Found</td>
                                                    </tr>
                                                </tbody>
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
        loadVoIPDropdownsvoip_list();

        function loadVoIPDropdownsvoip_list() {
            $.ajax({
                url: 'ajax/voip/add_voip_query.php?action=voipapend',
                method: 'POST',
                dataType: 'json',
                success: function(data) {
                    const addDropdown = $('#voip_list');
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
        $('body').on('click', '#usage_data', function() {
            var fromdatevalue = $('#startdate').val();
            var todatevalue = $('#enddate').val();
            var qcDispo = $('#voip_list').val();

            $('#amount_paid').text('0');
            $('#amount_usage').text('0');
            $('#balance_data').text('0');

            $('.table_voip_usage').html(`
        <tr>
            <td colspan="9" class="text-center">Loading...</td>
        </tr>
    `);

            if (fromdatevalue === "") {
                toastr.warning('Please Choose Start date!');
                $('#startdate').focus();
            } else if (todatevalue === "") {
                toastr.warning('Please Choose End date!');
                $('#enddate').focus();
            } else {
                $.ajax({
                    url: 'ajax/voip/voip-create.php?action=usagedata',
                    type: 'get',
                    data: {
                        fromdatevalue: fromdatevalue,
                        todatevalue: todatevalue,
                        qcDispo: qcDispo
                    },
                    success: function(response) {
                        var data = JSON.parse(response);

                        if (data.status === 'Ok') {
                            var records = data.data;
                            $('.table_voip_usage').html('');
                            let totalSumCredited = 0;
                            let totalSumDebited = 0;

                            $.each(records, function(index, record) {
                                var statusBadge = '';
                                var transition = '';

                                if (record.status === 'debited') {
                                    statusBadge = `<span class="badge bg-danger">${record.status}</span>`;
                                    let debited = parseFloat(record.amount_used);
                                    transition = `<i class="bx bx-minus-circle" style="color:red"></i> $${debited}`;
                                    totalSumDebited += debited;
                                } else {
                                    statusBadge = `<span class="badge bg-success">${record.status}</span>`;
                                    let credited = parseFloat(record.credited_amount);
                                    transition = `<i class="bx bx-plus-circle" style="color:green"></i> $${credited}`;
                                    totalSumCredited += credited;
                                }

                                let balance = parseFloat(record.balance_amount).toFixed(2);
                                let balanceDisplay = balance < 0 ?
                                    `-$${Math.abs(balance)}` :
                                    `$${balance}`;

                                $('.table_voip_usage').append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${record.voip_name}</td>
                                <td>${record.entry_date}</td>
                                <td>${statusBadge}</td>
                                <td>${transition}</td>
                                <td>
                                <i class="bx bx-minus-circle" style="color:red"></i>
                                ${record.did !== undefined && record.did !== null ? record.did : 'N/A'}
                                </td>
                                <td>${balanceDisplay}</td>
                                <td>${record.created_by}</td>
                            </tr>
                        `);
                            });

                            $('#amount_paid').text(`$${totalSumCredited.toFixed(2)}`);
                            $('#amount_usage').text(`$${totalSumDebited.toFixed(2)}`);

                            // ✅ Display current balance
                            if (data.sajith === 'good') {
                                $('#balance_data').text('$0.00');
                            } else if (data.sajith === 'bad') {
                                if (records.length > 0) {
                                    let lastBalance = parseFloat(records[records.length - 1].balance_amount).toFixed(2);
                                    let balanceDisplay = lastBalance < 0 ?
                                        `-$${Math.abs(lastBalance)}` :
                                        `$${lastBalance}`;
                                    $('#balance_data').text(balanceDisplay);
                                } else {
                                    $('#balance_data').text('$0.00');
                                }
                            }

                        } else {
                            $('.table_voip_usage').html(`
                        <tr>
                            <td colspan="9" class="text-center">No Records Found</td>
                        </tr>
                    `);
                            $('#balance_data').text('$0.00');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        toastr.error('Failed to fetch data. Please try again later.');
                    }
                });
            }
        });



        $('body').on('click', '#export_excel', function() {
            var startDate = $('#startDate').val();
            var fileName = 'voip_report' + ' - ' + startDate;
            var table = document.getElementById('export_table');
            var ws = XLSX.utils.table_to_sheet(table);
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
            XLSX.writeFile(wb, fileName + '.xlsx');
        });
    </script>
</body>


</html>