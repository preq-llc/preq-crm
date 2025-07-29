<?php
    $page = 'datacheck';
    include('config.php');
    include('59config.php');
    include('function/session.php');
    if($logged_in_user_role != 'superadmin')
    {
        header('Location: 404.php');
    }
?>  
<input type="text" id="current_username" data-role="<?php echo $logged_in_user_role;?>" value="<?php echo $logged_in_user_name;?>" hidden>
<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">


<head>

    <meta charset="utf-8" />
    <title>Datacheck | <?php echo $site_name;?> - Dialer CRM</title>
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
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

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
                                             <p class="text-muted mb-0">Get Current Data on this Page.</p>  
                                            
                                               
                                            </div>
                                            
                                            <div class="mt-3 mt-lg-0">
                                                <form action="javascript:void(0);">
                                                    <div class="row g-3 mb-0 align-items-center">
                                                         <div class="col-sm-auto">
                                                            <label for="">File</label>
                                                            <input type="file"class="form-control" id="filedata" name="filedata">
                                                        </div> 
                                                         <div class="col-sm-auto">
                                                          <label for="">Date</label>
                                                            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                                                    <i class="fa fa-calendar"></i>&nbsp;
                                                                    <span></span> <i class="fa fa-caret-down"></i>
                                                            </div>

                                                        </div>
                                                    <!--     <div class="col-sm-auto">
                                                            <div class="form-group">
                                                                <label for="">End date</label>
                                                                <input type="date" id="endDate" value="<?php echo $today_date;?>" class="form-control">
                                                            </div>
                                                        </div> --> 
                                                        <div class="col-sm-auto">
                                                            <div class="form-group">
                                                                <label for="">Campaign</label>
                                                                <select name="" id="campaign" class="form-select">
                                                                    <option value="">-- Choose Campaign --</option>
                                                                    <?php
                                                                        $sql = mysqli_query($conn, "SELECT name_display,campaign_value FROM `campaigns_details` WHERE status = 'Active'");
                                                                        while($getCamp = mysqli_fetch_assoc($sql))
                                                                        {
                                                                            echo '<option value="'.$getCamp['campaign_value'].'">'.$getCamp['name_display'].'</option>';
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>

                                                        </div>
                                                         <div class="col-sm-auto">
                                                            <div class="form-group">
                                                                <label for="">Dispo</label>
                                                                <select name="" id="Dispo" class="form-select" multiple>
                                                                    <option value="">-- Choose Dispo --</option>
                                                                    <?php
                                                                        $sql = mysqli_query($connnew, "SELECT DISTINCT dispo FROM `phonenumber_check` WHERE 1");
                                                                        while($getdispo = mysqli_fetch_assoc($sql))
                                                                        {
                                                                            echo '<option value="'.$getdispo['dispo'].'">'.$getdispo['dispo'].'</option>';
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            
                                                        </div>
                                                        
                                                        <div class="col-auto">
                                                            <button type="button" class="btn btn-soft-success mt-3" id="getDatas"><i class="ri-add-circle-line align-middle me-1"></i>
                                                                Get Data
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
                                        <h4 class="card-title mb-0 flex-grow-1">Campaign Data</h4>
                                        <div class="flex-shrink-0">
                                            <button type="button" id="export_excel" class="btn btn-soft-info btn-sm">
                                                <i class="ri-file-list-3-line align-middle"></i> Download Report
                                            </button>
                                        </div>
                                    </div><!-- end card header -->

                                    <div class="card-body">
                                        <div class="table-responsive table-card">
                                            <table id="export_table" class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                <thead class="text-muted table-light">
                                                    <tr>
                                                        <th scope="col">Sno</th>
                                                        <th scope="col">PhoneNumber</th>
                                                        <th scope="col">Column2</th>
                                                        <th scope="col">Column3</th>
                                                        <th scope="col">Column4</th>
                                                        <th scope="col">Column5</th>
                                                        <th scope="col">Column6</th>
                                                        <th scope="col">Column7</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table_result">
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

            <?php include('template/footer.php');?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Static Backdrop -->
<!-- Default Modals -->


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

    <!-- Billing init -->
    <script src="assets/js/pages/Live-Status-ecommerce.init.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script> -->
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script> -->
    <script src="assets/js/xlsx.full.min.js"></script>
    <script src="assets/js/toastr.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
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
            var current_username = $("#current_username").val();
            var currentUserRole = $("#current_username").data('role');

            var jsonData;
          $('body').on('click', '#getDatas', function () {
                var fileInput = $('#filedata')[0];
                var datafile = fileInput.files.length > 0 ? fileInput.files[0] : null;

                 var datevalue = $('#reportrange').text().trim();
                 // alert(datevalue);

                var dates = datevalue.split(" - "); 

                    // Function to convert date format
                    function convertToDate(dateStr) {
                        let dateObj = new Date(dateStr);
                        let year = dateObj.getFullYear();
                        let month = ('0' + (dateObj.getMonth() + 1)).slice(-2); // Month starts from 0
                        let day = ('0' + dateObj.getDate()).slice(-2);
                        return `${year}-${month}-${day}`;
                    }

                    // Convert both dates
                    var fromdatevalue = convertToDate(dates[0]); 
                    var todatevalue = convertToDate(dates[1]); 

                // alert(fromdatevalue);
                // alert(todatevalue);

                var slctcampvalue = $('#campaign').val();
                var slctdispo = $('#Dispo').val();
                
                // $('#getDatas').hide();

                // Calculate date difference in days
                // var timeDiff = todatevalue.getTime() - fromdatevalue.getTime();
                // var dayDiff = timeDiff / (1000 * 60 * 60 * 24)+ 1;;

                // console.log("Date difference: " + dayDiff);
                
                // Validate inputs
                if (!datafile) return showWarning('Please select a file!');
                // if (!fromdatevalue) return showWarning('Please Choose Start date!');
                // if (!todatevalue) return showWarning('Please Choose End date!');
                if (!slctcampvalue) return showWarning('Please Choose Campaign!');
                if (!slctdispo) return showWarning('Please Choose Dispo!');
                
                // if (dayDiff > 14) return showWarning('The selected date range is more than 14 days.');
                // if (dayDiff < 14) return showWarning('The selected date range is less than 14 days.');

                // Format dates for submission (YYYY-MM-DD HH:MM:SS)
                // var formattedFromDate = formatDate(fromdatevalue) + "00:00:00";
                // var formattedToDate = formatDate(todatevalue) + "23:59:59";

                $('.table_result').html(`
                    <tr>
                        <td colspan="8" class="text-center">
                            <img src="https://wpamelia.com/wp-content/uploads/2018/11/ezgif-2-6d0b072c3d3f.gif" width="300">
                        </td>
                    </tr>
                `);

                var formData = new FormData();
                formData.append('filedata', datafile);
                formData.append('fromdatevalue', fromdatevalue);
                formData.append('todatevalue', todatevalue);
                formData.append('slctcampvalue', slctcampvalue);
                formData.append('slctdispo', slctdispo);

                $.ajax({
                    url: 'ajax/datacheck/datacheck.php?action=datacheck',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        console.log(response);
                        var data = JSON.parse(response);

                        $('#getDatas').show();
                        $('#filedata').val('');

                        if (data.file_url) {
                            var fileUrl = 'https://preqvoice.com/Preq-new/' + data.file_url;
                            var fileName = data.file_url.split('/').pop();

                            var link = document.createElement('a');
                            link.href = fileUrl;
                            link.download = fileName;
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        }

                        $('.table_result').html(`<tr><td colspan="8" class="text-center"></td></tr>`);
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', error);
                        $('#getDatas').show();
                    }
                });
            });

            // Function to format date as YYYY-MM-DD
            function formatDate(date) {
                var yyyy = date.getFullYear();
                var mm = String(date.getMonth() + 1).padStart(2, '0'); // Months start from 0
                var dd = String(date.getDate()).padStart(2, '0');
                return `${yyyy}-${mm}-${dd}`;
            }

            // Function to show Toastr warning
            function showWarning(message) {
                toastr.warning(message);
                $('#getDatas').show();
            }


            
            $('body').on('click', '#export_excel', function(){

                var startDate = $('#startDate').val();
                var campaign_name = $('#campaign').val();

                if(campaign_name == 'FTE_ALL')
                {
                    var campaign_name = 'EDU_SB_ALL';
                }

                var fileName = campaign_name+' - '+startDate;
                    var table = document.getElementById('export_table');
                    var ws = XLSX.utils.table_to_sheet(table);
                    var wb = XLSX.utils.book_new();
                    XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
                    XLSX.writeFile(wb, fileName+'.xlsx');
            });
        });
    </script>
<script>
$(function() {

    var start = moment().subtract(1, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Last 2 Days': [moment().subtract(2, 'days')],
           'Last 14 Days': [moment().subtract(14, 'days'), moment()],
        }
    }, cb);

    cb(start, end);

});
</script>

</body>


</html>