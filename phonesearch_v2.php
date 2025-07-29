<?php
    $page = 'phonesearch';
    include('config.php');
    include('function/session.php');
    
?>
<input type="text" id="current_username" value="<?php echo $logged_in_user_name;?>" data-role="<?php echo $logged_in_user_role;?>" hidden>
<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">


<head>

    <meta charset="utf-8" />
    <title>Phonesearch Report | <?php echo $site_name;?> - Dialer CRM</title>
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
                                                <!-- <h4 class="fs-16 mb-1">Hello, <?php echo $logged_in_user_name;?>!</h4>
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
                                                                <label for="">Phone Number</label>
                                                                <input type="text" id="phonenumber" value="" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <div class="form-group">
                                                                <label for="">Select Campaign</label>
                                                                <select name="" id="campaign" class="form-select">
                                                                    <option value="">-- Choose Campaign --</option>
                                                                   
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button" class="btn btn-soft-success mt-3" id="phonesearchdata"><i class="ri-add-circle-line align-middle me-1"></i>
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

                            </div> <!-- end .h-100-->
                        </div> <!-- end col -->
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">PhoneNumber Summary</h4>
                                        <div class="flex-shrink-0">
                                            <!-- <button type="button" id="export_excel" class="btn btn-soft-info btn-sm">
                                                <i class="ri-file-list-3-line align-middle"></i> Download Report
                                            </button> -->
                                        </div>
                                    </div><!-- end card header -->

                                    <div class="card-body">
                                        <div class="table-responsive table-card">
                                            <table id="export_table" class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                <thead class="text-muted table-light">
                                                    <tr>
                                                        <th scope="col">Sno</th>
                                                        <th scope="col">Lead ID</th>
                                                        <th scope="col">List ID</th>
                                                        <th scope="col">Campaign ID</th>
                                                        <th scope="col">Phone Num</th>
                                                        <th scope="col">Agent ID</th>
                                                        <th scope="col">Dispo</th>
                                                        <th scope="col">Call Length</th>
                                                        <th scope="col">Call Date</th> 
                                                    </tr>
                                                </thead>
                                                <tbody class="table_result_phonesearch">
                                                    <tr>
                                                        <td colspan="8" class="text-center">No Record Found</td>
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
            <!-- End Page-content -->
<!--             <table class="table d-none" id="listViewExportTable">
                <thead>
                    <tr>
                        <th>Dispo Status</th>
                        <th>Count</th>
                    </tr>
                </thead>
                <tbody class="listViewTable">

                </tbody>
            </table> -->
            <?php include('template/footer.php');?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->
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

    <!-- Lead Report init -->
    <script src="assets/js/pages/Live-Status-ecommerce.init.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>
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
    getDatatable();
    getcampaign();

});

function getcampaign(){

    var current_username = $("#current_username").val();
            $.ajax({
                    url: 'ajax/report/dashboard.php?action=selectcamp',
                    type: 'get',
                    data: {
                        current_username:current_username
                    },
                    success: function(response)
                    {
                        console.log(response);
                        var data = JSON.parse(response);
                        if (data.status == 'Ok') {
                            
                            var record = data.data;
                            
                            $('#campaign').html('<option value="">-- Choose Campaign --</option>');
                            record.forEach(function(arr, idx){
                              
                                $('#campaign').append(`
                                    <option value="${arr.campaign}">${arr.display_name}</option>
                                `);
                            });
                        }
                    }
                });
}



// Function to fetch and display data in the table
function getDatatable() {
    $('#phonesearchdata').on('click', function() {
        var phonenumber = $('#phonenumber').val();
        var campaign = $('#campaign').val();
         
 

        $('.table_result_phonesearch').html(`
            <tr>
                        <td colspan="8" class="text-center">
                            <img src="https://wpamelia.com/wp-content/uploads/2018/11/ezgif-2-6d0b072c3d3f.gif" width="300">
                        </td>
            </tr>
        `);

        if (!phonenumber) {
            toastr.warning('Please Enter Phonenumber!');
            $('#phonenumber').focus();
        } else {


      
            $.ajax({
                url: 'ajax/report/phonesearch_v2.php?action=phonesearchlead',
                type: 'GET',
                data: {
                    phonenumber: phonenumber,
                    campaign:campaign,

                },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                    displayQCData(data.data);
                   console.log(data.data);
                    } else {
                        console.log('Error: Data not retrieved successfully');
                    }
                }
            });
        }
    });
}



// Function to display QC data in the table
function displayQCData(qcdata) {
    console.log(qcdata);
    $('.table_result_phonesearch').empty(); // Clear existing table data
    var serialnumber = 1; // Initialize serial number

    qcdata.forEach(function(value) {
        var phonenumber = value.phone_number;
        
        // Append each row to the table
        $('.table_result_phonesearch').append(`
            <tr>
                <td>${serialnumber}</td>
                <td>${value.lead_id || ''}</td>
                <td>${value.list_id || ''}</td>
                <td>${phonenumber || ''}</td>
                <td>${value.campaign_id || ''}</td>
                <td>${value.user || ''}</td>
                <td>${value.status || ''}</td>
                <td>${value.length_in_sec || ''}</td>
                <td>${value.call_date || ''}</td>
            </tr>
        `);
        serialnumber++; // Increment serial number for the next row
    });
}

</script>



</body>


</html>