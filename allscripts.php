<?php
$page = 'allscript';
include('config.php');
include('function/session.php');

?>
<input type="text" id="current_username" value="<?php echo $logged_in_user_name; ?>" hidden>
<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">


<head>

    <meta charset="utf-8" />
    <title>All Script | Zealous - Dialer CRM</title>
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

    .nav-tabs .nav-item.show .nav-link,
    .nav-tabs .nav-link.active {
        background-color: #ffffff;
    }

    .animated-btn {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .animated-btn:hover {
        background-color: #0056b3;
        transform: scale(1.05);
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
    }

    .animated-btn:active {
        transform: scale(0.98);
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

                    <div class="row">
                        <div class="col">
                            <h3 class="mb-4">Script Configuration</h3>

                        </div>

                        <div class="row">
                            <!-- Tabs -->
                            <ul class="nav nav-tabs" id="configTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="main-tab" data-bs-toggle="tab" data-bs-target="#main" type="button" role="tab">Main</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="script-tab" data-bs-toggle="tab" data-bs-target="#script" type="button" role="tab">Script</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="webform-tab" data-bs-toggle="tab" data-bs-target="#webform" type="button" role="tab">Webform</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="transfer-tab" data-bs-toggle="tab" data-bs-target="#transfer" type="button" role="tab">Transfer</button>
                                </li>
                            </ul>
                        </div>


                        <!-- Tab Contents -->
                        <div class="tab-content border p-4" id="configTabsContent" style="background-color:white;">

                            <!-- Main Tab -->
                            <div class="tab-pane fade show active" id="main" role="tabpanel">
                                <form class="row g-3" id="mainFieldsContainer">
                                    <div class="row g-3 main-group">
                                        <div class="col-md-2">
                                            <label class="form-label">Script ID</label>
                                            <input type="text" name="script_id[]" class="form-control">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Script Name</label>
                                            <input type="text" name="script_name[]" class="form-control">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Script Type</label>
                                            <input type="text" name="script_type[]" class="form-control">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Client Name</label>
                                            <input type="text" name="client_name[]" class="form-control">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Main Status</label>
                                            <input type="text" name="main_status[]" class="form-control">
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-success btn-sm me-1 add-main"><strong>＋</strong></button>
                                            <button type="button" class="btn btn-danger btn-sm remove-main"><strong>－</strong></button>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <!-- Script Tab -->
                            <div class="tab-pane fade" id="script" role="tabpanel">
                                <form class="row g-3" id="scriptFieldsContainer">
                                    <div class="row g-3 script-group">
                                        <div class="col-md-2">
                                            <label class="form-label">Tab Name</label>
                                            <input type="text" name="tab_name[]" class="form-control">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Section Name</label>
                                            <input type="text" name="section_name[]" class="form-control">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Button Name</label>
                                            <input type="text" name="button_name[]" class="form-control">
                                        </div>
                                        <div class="col-md-1">
                                            <label class="form-label">Button Color</label>
                                            <input type="color" name="button_color[]" class="form-control form-control-color">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Button Position</label>
                                            <input type="number" name="button_position[]" class="form-control">
                                        </div>
                                        <div class="col-md-3 d-flex align-items-end">
                                            <button type="button" class="btn btn-success btn-sm me-1 add-script"><strong>＋</strong></button>
                                            <button type="button" class="btn btn-danger btn-sm remove-script"><strong>－</strong></button>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <!-- Webform Tab -->
                           <div class="tab-pane fade" id="webform" role="tabpanel">
                                <form class="row g-3" id="webformFieldsContainer">
                                    <div class="row g-3 webform-group">
                                        <div class="col-md-2">
                                            <label class="form-label">Webform Name</label>
                                            <input type="text" name="webform_name[]" class="form-control">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Webform Color</label>
                                            <input type="color" name="webform_color[]" class="form-control form-control-color">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Client URL</label>
                                            <input type="url" name="client_url[]" class="form-control">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">API Key</label>
                                            <input type="text" name="api_key[]" class="form-control">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Method</label>
                                            <input type="text" name="method[]" class="form-control">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Header</label>
                                            <input type="text" name="header[]" class="form-control">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Auth Type</label>
                                            <input type="text" name="auth_type[]" class="form-control">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Webform Position</label>
                                            <input type="number" name="webform_position[]" class="form-control">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Webform Status</label>
                                            <select name="webform_status[]" class="form-select">
                                                <option>Active</option>
                                                <option>Inactive</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-success btn-sm me-1 add-webform"><strong>＋</strong></button>
                                            <button type="button" class="btn btn-danger btn-sm remove-webform"><strong>－</strong></button>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <!-- Transfer Tab -->
                          <div class="tab-pane fade" id="transfer" role="tabpanel">
                                    <form class="row g-3" id="transferFieldsContainer">
                                        <div class="row g-3 transfer-group">
                                            <div class="col-md-2">
                                                <label class="form-label">Transfer Name</label>
                                                <input type="text" name="transfer_name[]" class="form-control">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Transfer URL</label>
                                                <input type="url" name="transfer_url[]" class="form-control">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Transfer Position</label>
                                                <input type="number" name="transfer_position[]" class="form-control">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Transfer Zenba</label>
                                                <input type="text" name="transfer_zenba[]" class="form-control">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Transfer Status</label>
                                                <select name="transfer_status[]" class="form-select">
                                                    <option>Active</option>
                                                    <option>Inactive</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 d-flex align-items-end">
                                                <button type="button" class="btn btn-success btn-sm me-1 add-transfer"><strong>＋</strong></button>
                                                <button type="button" class="btn btn-danger btn-sm remove-transfer"><strong>－</strong></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                        </div>
                        <button class="animated-btn">Save</button>
                    </div>
                </div>
            </div>



            <?php include('template/footer.php'); ?>
        </div>
        <!-- end main content-->

    </div>

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
        // Add new main group
            $(document).on('click', '.add-main', function () {
                let group = $(this).closest('.main-group');
                let clone = group.clone();
                clone.find('input').val('');
                $('#mainFieldsContainer').append(clone);
            });

            // Remove main group
            $(document).on('click', '.remove-main', function () {
                if ($('.main-group').length > 1) {
                    $(this).closest('.main-group').remove();
                } else {
                    alert('At least one entry must remain.');
                }
            });
        // Add new script group
        $(document).on('click', '.add-script', function() {
            let group = $(this).closest('.script-group');
            let clone = group.clone();
            clone.find('input').val(''); // clear input values
            $('#scriptFieldsContainer').append(clone);
        });

        // Remove script group
        $(document).on('click', '.remove-script', function() {
            if ($('.script-group').length > 1) {
                $(this).closest('.script-group').remove();
            } else {
                alert('At least one row must remain.');
            }
        });

        // Add webform group
    $(document).on('click', '.add-webform', function () {
        let group = $(this).closest('.webform-group');
        let clone = group.clone();

        // Clear all inputs/selects
        clone.find('input, select').val('');
        $('#webformFieldsContainer').append(clone);
    });

    // Remove webform group
    $(document).on('click', '.remove-webform', function () {
        if ($('.webform-group').length > 1) {
            $(this).closest('.webform-group').remove();
        } else {
            alert('At least one entry must remain.');
        }
    });

     // Add transfer group
    $(document).on('click', '.add-transfer', function () {
        let group = $(this).closest('.transfer-group');
        let clone = group.clone();

        // Clear values in cloned inputs/selects
        clone.find('input, select').val('');
        $('#transferFieldsContainer').append(clone);
    });

    // Remove transfer group
    $(document).on('click', '.remove-transfer', function () {
        if ($('.transfer-group').length > 1) {
            $(this).closest('.transfer-group').remove();
        } else {
            alert('At least one transfer entry is required.');
        }
    });
    </script>


</body>


</html>