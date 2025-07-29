<?php
$page = 'voippaid';
include('config.php');
include('function/session.php');

?>
<input type="text" id="current_username" value="<?php echo $logged_in_user_name; ?>" hidden>
<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">


<head>

    <meta charset="utf-8" />
    <title>Voip Paid | Zealous - Dialer CRM</title>
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
                                        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                            <div class="flex-grow-1">
                                                <button class="btn btn-soft-primary" data-bs-toggle="offcanvas" id="createVoipBtn" data-bs-target="#campControlCanvas">
                                                    <i class="ri-add-circle-line align-middle me-1"></i>Create Invoice</button>
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
                                                                <input type="date" id="fdate" value="<?php echo $today_date; ?>" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <div class="form-group">
                                                                <label for="">End date</label>
                                                                <input type="date" id="tdate" value="<?php echo $today_date; ?>" class="form-control">
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
                                                            <button type="button" class="btn btn-soft-success mt-3" id="submit"><i class="ri-add-circle-line align-middle me-1"></i>
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
                                        <h4 class="card-title mb-0 flex-grow-1">Voip Paid Details</h4>
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
                                                        <th scope="col">Invoice No</th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col">Image</th>
                                                        <th scope="col">Invoice Date</th>
                                                        <th scope="col">Voip Name</th>
                                                         <th scope="col">Paid Date</th>
                                                        <th scope="col">Paid Amount</th>
                                                        <th scope="col">Paid Screenshot</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Uploaded By</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="data_table">
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

    <div class="offcanvas offcanvas-end" id="campControlCanvas" style="width: 90vw; max-width: 900px;">
        <div class="offcanvas-body">
            <div class="offcanvas-header">
                <h2 class="offcanvas-title campcanvasheading text-center">Invoice and Paid Details</h2>

                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>

            <div class="row">
                <!-- Invoice Details Column -->
                <div class="col-md-6">
                    <h3>Invoice details</h3>

                    <div class="mb-3">
                        <label for="invoice_no" class="form-label">Invoice No</label>
                        <input type="text" class="form-control" id="invoice_no">
                    </div>

                    <div class="mb-3">
                        <label for="voip_name_details" class="form-label">Voip Name</label>
                        <select id="voip_name_details" class="form-select">
                            <option value="">--Choose--</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="invoice_date" class="form-label">Invoice Date</label>
                        <input type="date" class="form-control" id="invoice_date">
                    </div>

                    <div class="mb-3">
                        <label for="Amount_paid" class="form-label">Amount</label>
                        <input type="text" class="form-control" id="Amount_paid">
                    </div>

                    <div class="mb-3">
                        <label for="file_upload" class="form-label">Choose File</label>
                        <input type="file" class="form-control" id="file_upload" multiple>
                    </div>

                    <button class="btn btn-secondary" type="button" id="create_voip_details">Upload</button>
                </div>

                <!-- Paid Details Column -->
                <div class="col-md-6">
                    <h3>Paid details</h3>

                    <div class="mb-3">
                        <label for="invoice_no_paid" class="form-label">Invoice No</label>
                        <input type="text" class="form-control" id="invoice_no_paid">
                    </div>
                    <div class="mb-3">
                        <label for="invoice_date_paid" class="form-label">Invoice Paid Date</label>
                        <input type="date" class="form-control" id="invoice_date_paid">
                    </div>

                    <div class="mb-3">
                        <label for="Amount_paid_details" class="form-label">Amount Paid</label>
                        <input type="text" class="form-control" id="Amount_paid_details">
                    </div>

                    <div class="mb-3">
                        <label for="file_upload__paid" class="form-label">Choose File</label>
                        <input type="file" class="form-control" id="file_upload_paid" multiple>
                    </div>

                    <button class="btn btn-secondary" type="button" id="create_voip_details_paid">Upload</button>
                </div>
            </div>
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
        $(document).ready(function() {
            loadVoIPDropdownsvoip_list();
            loadVoIPDropdownsvoip_listside();

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


            function loadVoIPDropdownsvoip_listside() {
                $.ajax({
                    url: 'ajax/voip/add_voip_query.php?action=voipapend',
                    method: 'POST',
                    dataType: 'json',
                    success: function(data) {
                        const addDropdown = $('#voip_name_details');
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
            $('#create_voip_details').on('click', function() {

                var voip_name_details = $('#voip_name_details').val();
                var amount_paid = $('#Amount_paid').val();
                //alert(amount_paid);
                var invoice_date = $('#invoice_date').val();
                var file_upload = $('#file_upload').val();
                var invoice_no = $('#invoice_no').val();
                if (invoice_no === '') {
                    toastr.warning('Please Enter an invoice_no');
                    $('#invoice_no').focus();
                } else if (voip_name_details === '') {
                    toastr.warning('Please choose a VoIP detail');
                    $('#voip_name_details').focus();
                } else if (invoice_date === '') {
                    toastr.warning('Please choose an invoice date');
                    $('#invoice_date').focus();
                } else if (amount_paid === '') {
                    toastr.warning('Please Enter an amount_paid');
                    $('#Amount_paid').focus();
                } else {
                    var formData = new FormData();
                    var fileInput = $("#file_upload")[0].files;

                    for (var i = 0; i < fileInput.length; i++) {
                        console.log("File Name: " + fileInput[i].name);
                        console.log("File Size: " + fileInput[i].size + " bytes");
                        console.log("File Type: " + fileInput[i].type);

                        formData.append('files[]', fileInput[i]);
                    }
                    formData.append('invoice_no', invoice_no);
                    formData.append('voip_name_details', voip_name_details);
                    formData.append('invoice_date', invoice_date);
                    formData.append('amount_paid', amount_paid);

                    $.ajax({
                        type: 'POST',
                        url: 'ajax/voip/voip-create.php?action=createvoipdetails',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            try {
                                var res = JSON.parse(response); // ensure the response is parsed
                                if (res.status === 'success') {
                                    toastr.success(res.message || 'Success').css('margin-top', '50px');
                                    $('#voip_name_details').val('');
                                    $('#invoice_date').val('');
                                    $('#Amount_paid').val('');
                                    $('#file_upload').val('');
                                    $('#invoice_no').val('');
                                } else {
                                    toastr.error(res.message || 'Something went wrong.').css('margin-top', '50px');
                                }
                            } catch (e) {
                                toastr.error('Unexpected response from server.').css('margin-top', '50px');
                                console.error('Response parse error:', e, response);
                            }
                        }

                    });
                }
            });
            $('#create_voip_details_paid').on('click', function() {
                //alert("sdfsdf");
                var invoice_no = $('#invoice_no_paid').val();
                var amount_paid = $('#Amount_paid_details').val();
                var invoice_date = $('#invoice_date_paid').val();
                var file_upload = $('#file_upload_paid').val();
                if (invoice_no === '') {
                    toastr.warning('Please Enter a invoice_no');
                    $('#invoice_no_paid').focus();
                } else if (invoice_date === '') {
                    toastr.warning('Please choose an invoice date');
                    $('#invoice_date_paid').focus();
                } else if (amount_paid === '') {
                    toastr.warning('Please Enter an amount_paid');
                    $('#Amount_paid_details').focus();
                } else {
                    var formData = new FormData();
                    var fileInput = $("#file_upload_paid")[0].files;

                    for (var i = 0; i < fileInput.length; i++) {
                        console.log("File Name: " + fileInput[i].name);
                        console.log("File Size: " + fileInput[i].size + " bytes");
                        console.log("File Type: " + fileInput[i].type);
                        formData.append('files[]', fileInput[i]);
                    }
                    formData.append('invoice_no', invoice_no);
                    formData.append('invoice_date', invoice_date);
                    formData.append('amount_paid', amount_paid);

                    $.ajax({
                        type: 'POST',
                        url: 'ajax/voip/voip-create.php?action=createpaid_details',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            try {
                                var res = JSON.parse(response); // ensure the response is parsed
                                if (res.status === 'success') {
                                    toastr.success(res.message || 'Success').css('margin-top', '50px');
                                    $('#invoice_date_paid').val('');
                                    $('#Amount_paid_details').val('');
                                    $('#file_upload_paid').val('');
                                    $('#invoice_no_paid').val('');
                                } else {
                                    toastr.error(res.message || 'Something went wrong.').css('margin-top', '50px');
                                }
                            } catch (e) {
                                toastr.error('Unexpected response from server.').css('margin-top', '50px');
                                console.error('Response parse error:', e, response);
                            }
                        }

                    });
                }
            });
        });


        $('body').on('click', '#submit', function() {
            var fromdatevalue = $('#fdate').val();
            var todatevalue = $('#tdate').val();
            var qcDispo = $('#voip_list').val();

            $('#data_table').html(`
                <tr>
                    <td colspan="11" class="text-center">Loading...</td>
                </tr>
            `);

            if (fromdatevalue === "") {
                toastr.warning('Please Choose Start date!');
                $('#fdate').focus();
            } else if (todatevalue === "") {
                toastr.warning('Please Choose End date!');
                $('#tdate').focus();
            } else {
                $.ajax({
                    url: 'ajax/voip/voip-create.php?action=getdata_voip',
                    type: 'get',
                    data: {
                        fromdatevalue: fromdatevalue,
                        todatevalue: todatevalue,
                        qcDispo: qcDispo
                    },
                    success: function(response) {
                        try {
                            var data = JSON.parse(response);
                            if (data.status === 'Ok') {
                                var records = data.data;
                                $('#data_table').html('');
                                    $.each(records, function(index, record) {
                                        let screenShotHtml = '';
                                        let paidScreenShotHtml = '';

                                        // Handle screen_shot column
                                        if (record.screen_shot) {
                                            let shots = record.screen_shot.split(',');
                                            shots.forEach(function(url) {
                                                var trimmedUrl = url.trim();
                                                var encodedUrl = encodeURIComponent(trimmedUrl);
                                                var fileExt = trimmedUrl.split('.').pop().toLowerCase();

                                                if (fileExt === 'pdf') {
                                                    screenShotHtml += `
                                                        <a href="ajax/voip/files/${encodedUrl}" target="_blank" style="margin-right: 5px;">
                                                            📄 PDF
                                                        </a>`;
                                                } else {
                                                    screenShotHtml += `
                                                        <a href="ajax/voip/files/${encodedUrl}" target="_blank">
                                                            <img src="ajax/voip/files/${encodedUrl}" 
                                                                alt="Image" 
                                                                style="width: 100px; height: auto; margin-right: 5px;" 
                                                                onerror="this.style.display='none'; console.warn('Image failed to load:', this.src);">
                                                        </a>`;
                                                }
                                            });
                                        } else {
                                            screenShotHtml = 'No screenshot';
                                        }

                                        // Handle paid_screenshot column
                                        if (record.paid_screenshot) {
                                            let shots = record.paid_screenshot.split(',');
                                            shots.forEach(function(url) {
                                                var trimmedUrl = url.trim();
                                                var encodedUrl = encodeURIComponent(trimmedUrl);
                                                var fileExt = trimmedUrl.split('.').pop().toLowerCase();

                                                if (fileExt === 'pdf') {
                                                    paidScreenShotHtml += `
                                                        <a href="ajax/voip/files/${encodedUrl}" target="_blank" style="margin-right: 5px;">
                                                            📄 PDF
                                                        </a>`;
                                                } else {
                                                    paidScreenShotHtml += `
                                                        <a href="ajax/voip/files/${encodedUrl}" target="_blank">
                                                            <img src="ajax/voip/files/${encodedUrl}" 
                                                                alt="Image" 
                                                                style="width: 100px; height: auto; margin-right: 5px;" 
                                                                onerror="this.style.display='none'; console.warn('Image failed to load:', this.src);">
                                                        </a>`;
                                                }
                                            });
                                        } else {
                                            paidScreenShotHtml = 'No screenshot';
                                        }

                                        $('#data_table').append(`
                                            <tr>
                                                <td>${index + 1}</td>
                                                <td>${record.invoice_no || ''}</td>
                                                <td>${record.amount || ''}</td>
                                                <td>${screenShotHtml}</td>
                                                <td>${record.invoice_date || ''}</td>
                                                <td>${record.voip_name || ''}</td>
                                                <td>${record.paid_date || ''}</td>
                                                <td>${record.paid_amount || ''}</td>
                                                <td>${paidScreenShotHtml}</td>
                                               <td>
                                                    <span class="badge ${record.status === 'Paid' ? 'bg-success' : 'bg-secondary'}">
                                                        ${record.status || ''}
                                                    </span>
                                                </td>
                                                <td>${record.uploaded_by || ''}</td>
                                            </tr>
                                        `);
                                    });

                            } else {
                                $('#data_table').html(`
                            <tr>
                                <td colspan="11" class="text-center">No Records Found</td>
                            </tr>
                        `);
                            }
                        } catch (e) {
                            console.error('JSON Parse Error:', e);
                            toastr.error('Unexpected response format. Please contact support.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
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

        function convert_pdf(filename) {
            var element = document.getElementById("pdfcontainer");

            var options = {
                margin: [0, 0, 1, 0], //[top, leaft, bottom, right]
                filename: filename + ".pdf",
                image: {
                    type: "jpeg",
                    quality: 1
                },
                pagebreak: {
                    avoid: "tr",
                    mode: "css",
                    before: "#nextpage1"
                },
                html2canvas: {
                    scale: 5,
                    useCORS: true,
                    dpi: 192,
                    letterRendering: true
                },
                jsPDF: {
                    unit: "in",
                    format: "a3",
                    orientation: "portrait"
                },
            };

            // Generate PDF
            html2pdf()
                .from(element)
                .set(options)
                .save();
        }
    </script>
</body>


</html>