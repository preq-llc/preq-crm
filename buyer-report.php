<?php
    $page = 'buyerreport';
    include('config.php');
    include('function/session.php');
    include('function/DB/db-70.php');
    
?>
<input type="text" id="current_username" value="<?php echo $logged_in_user_name;?>" data-role="<?php echo $logged_in_user_role;?>" hidden>
<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">


<head>

    <meta charset="utf-8" />
    <title>Buyer Report | <?php echo $site_name;?> - Dialer CRM</title>
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
                                                                <label for="">Start date</label>
                                                                <input type="date" id="startDate" value="<?php echo $today_date;?>" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <div class="form-group">
                                                                <label for="">End date</label>
                                                                <input type="date" id="endDate" value="<?php echo $today_date;?>" class="form-control">
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
                                                        <div class="col-sm-auto d-none">
                                                            <label for="">Call Center</label>

                                                            <select name="" id="call_center" class="form-select">
                                                                <?php
                                                                    // if ($logged_in_user_role == 'teamleader' || $logged_in_user_role == 'qc' || $logged_in_user_role == 'qcadmin') {
                                                                    //     if($logged_in_user_group == 'Unknown')
                                                                    //     {
                                                                    //         echo ' <option value="" selected>-- All Center --</option><option value="' . $logged_in_user_group . '">' . $logged_in_user_group . '</option>';
                                                                    //     }
                                                                    //     else
                                                                    //     {
                                                                    //         echo '<option value="' . $logged_in_user_group . '">' . $logged_in_user_group . '</option>';
                                                                    //     }
                                                                    // } else {
                                                                    //     // echo '
                                                                    //     //     <option value="">-- Choose Center --</option>
                                                                    //     //     <option value="EXI">EXIMIO</option>
                                                                    //     //     <option value="WIN">WINGSPAN</option>
                                                                    //     //     <option value="ZD">ZEALOUS</option>
                                                                    //     // ';
                                                                    // }
                                                                    // echo '<option value="" selected>-- Choose Center --</option>';

                                                                    // $single_callcenter = explode(",", $logged_in_user_group);
                                                                    // foreach ($single_callcenter as $center) {
                                                                    //     echo '<option value="' . trim($center) . '">' . trim($center) . '</option>';
                                                                    // }
                                                                    
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <div class="form-group">
                                                                <label for="">Buyer</label>
                                                                <!-- echo '<option value="" selected>-- Choose Center --</option>';
                                                                    $single_callcenter = explode(",", $logged_in_user_group);
                                                                    foreach ($single_callcenter as $center) {
                                                                        echo '<option value="' . trim($center) . '">' . trim($center) . '</option>';
                                                                    } -->
                                                                 <select name="" id="buyer_id" class="form-select">
                                                                    <?php
                                                                        // $sql = mysqli_query($conn, "SELECT buyer_id FROM `campaigns_details` WHERE ")
                                                                    ?>
                                                                    <!-- <option value="307937937,307937938,307937939,307937940">-- All Buyer --</option>
                                                                    <option value="307937937">Buyer 1</option>
                                                                    <option value="307937938">Buyer 2</option>
                                                                    <option value="307937939">Buyer 3</option>
                                                                    <option value="307937940">Buyer 4</option> -->
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button" class="btn btn-soft-success mt-3" id="getRecord"><i class="ri-add-circle-line align-middle me-1"></i>
                                                                Get Report
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
                                        <h4 class="card-title mb-0 flex-grow-1">AGENT PERFORMANCE SUMMARY</h4>
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
                                                        <th scope="col">Campaign</th>
                                                        <th scope="col">Agent ID</th>
                                                        <th scope="col">Agent Name</th>
                                                        <th scope="col">Phone</th>
                                                        <th scope="col">Start time</th>
                                                        <th scope="col">End time</th>
                                                        <th scope="col">Call Length (sec)</th>
                                                        <th scope="col">Buyer ID</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table_result">
                                                    <tr>
                                                        <td colspan="9" class="text-center">No Record Found</td>
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
            <table class="table d-none" id="listViewExportTable">
                <thead>
                    <tr>
                        <th>Dispo Status</th>
                        <th>Count</th>
                    </tr>
                </thead>
                <tbody class="listViewTable">

                </tbody>
            </table>
            <?php include('template/footer.php');?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Static Backdrop -->
<!-- Default Modals -->
<!-- <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#myModal">Standard Modal</button> -->
<div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Dispo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <div class="modal-body">
              <table class="table table-bordered table-striped">
                    <tbody class="dispoAgentDetails">
                        
                    </tbody>
              </table>
              <div class="audioRec">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary ">Save Changes</button> -->
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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
                                    <option value="${arr.campaign}" data-buyerid="${arr.buyer_id}">${arr.display_name}</option>
                                `);
                            });
                        }
                    }
                });
                $('body').on('change', '#campaign', function() {
                    var this_buyerID = $(this).find('option:selected').data('buyerid');
                    // console.log(this_buyerID);
                    if (this_buyerID) {
                        var arr_buyerID = this_buyerID.toString().split(',');  // Convert to string and split
                        console.log(arr_buyerID);
                    } else {
                        console.log('No buyer ID found');
                    }
                    var html;
                    var count = 1;
                    $('#buyer_id').html('<option data-name="all" value="'+this_buyerID+'">-- All Buyers --</option>');
                    arr_buyerID.forEach(buyer => {
                        console.log(buyer);
                        html += '<option data-name="buyer '+ count +'" value="'+ buyer +'">buyer '+ count++ +'</option>';
                        
                    });
                   
                    $('#buyer_id').append(html);
                });

                // var total_count;
            $('body').on('click','#getRecord', function(){
              
                var fromdatevalue = $('#startDate').val();
                var todatevalue = $('#endDate').val();
                var slctcampvalue = $('#campaign').val();
                // var call_centervalue = $('#call_center').val();
                var buyer_id = $('#buyer_id').val();
                var arr_buyerID = buyer_id.split(',');
                console.log(arr_buyerID);
                var buyerName = $('#buyer_id').find('option:selected').text();
                console.log(buyerName);
                
                $('.table_result').html(`
                    <tr>
                        <td colspan="8" class="text-center">No Record Found</td>
                    </tr>
                `);
                if(startDate == "")
                {
                    toastr.warning('Please Choose Start date!');
                    $('#startDate').focus();
                }
                else if(todatevalue == "")
                {
                    toastr.warning('Please Choose End date!');
                    $('#endDate').focus();
                }
                // else if(slctcampvalue == "")
                // {
                //     toastr.warning('Please Choose a Campaign!');
                //     $('#campaign').focus();
                // }
                else
                {
                    $.ajax({
                            url: 'ajax/report/buyerreport.php?action=getbuyerreport',
                            type: 'get',
                            data: {
                                fromdatevalue:fromdatevalue,
                                todatevalue:todatevalue,
                                slctcampvalue:slctcampvalue,
                                buyer_id:buyer_id
                                // call_centervalue:call_centervalue
                            },
                            success: function(response)
                            {
                                console.log(response);
                                // var data = JSON.parse(response);
                                if(response.status == 'Ok')
                                {
                                    console.log('tests');
                                    var record = response.data;
                                    if(record.length < 0)
                                    {
                                        console.log('not');
                                    }
                                    else
                                    {
                                        console.log(record);
                                        var sno = 1;
                                        $('.table_result').html('');
                                        var buyerNameDb = buyerName;
                                        
                                        
                                        $.each(record, function(idx, arr){
                                            if(buyerName == '-- All Buyers --')
                                            {
                                                buyerNameDb = arr.buyername;
                                            }
                                            console.log(idx);
                                            
                                            if(sno < 10)
                                            {
                                                $('.table_result').append(`
                                                <tr>
                                                    <td>${sno++}</td>
                                                    <td>${arr.camp}</td>
                                                    <td>Test</td>
                                                    <td>Test</td>
                                                    <td>${arr.extension.slice(0, -4) + 'XXXX'}</td>
                                                    <td>${arr.start_time}</td>
                                                    <td>${arr.end_time}</td>
                                                    <td>${arr.length_in_sec}</td>
                                                    <td>${buyerNameDb}</td>
                                                </tr>
                                            `);
                                            }
                                            
                                        });
                                    }
                                   
                                }
                                // if(Array.isArray(response))
                                // {
                                //     var total_count = response.data[0].staus_cunt_view;
                                // }
                                // else
                                // {
                                //     // var data = JSON.parse(response);
                                //     // console.log(data);
                                //     var total_count = response.data[0].staus_cunt_view;
                                //     // console.log('no array');

                                // }
                                
                                // console.log(total_count);
                                // handleTotalCount(fromdatevalue,todatevalue,slctcampvalue,total_count,call_centervalue);

                            }
                        });

                }
                
            });
            
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
            $('body').on('click', '#listViewExportTablebtn', function(){

            var startDate = $('#startDate').val();
            var campaign_name = $('#campaign').val();

            if(campaign_name == 'FTE_ALL')
            {
                var campaign_name = 'EDU_SB_ALL';
            }
            var fileName = campaign_name+' - '+startDate;
                var table = document.getElementById('listViewExportTable');
                var ws = XLSX.utils.table_to_sheet(table);
                var wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
                XLSX.writeFile(wb, fileName+'.xlsx');
            });
            
        });
    </script>

</body>


</html>