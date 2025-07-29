<?php
    $page = 'billing';
    include('config.php');
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
    <title>Billing | <?php echo $site_name;?> - Dialer CRM</title>
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
                            <div class="card">
                                <div class="card-head">
                                    <h5 class="card-title p-3">Excel Reports</h5>

                                </div>
                                <div class="card-body">
                                <table class="table table-borderless table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Report Type</th>
                                        <th scope="col">Report Link</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Call Log Report</td>
                                        <td class="thishtmltext">
                                            <p>https://preqvoice.com/Preq-new/ajax/report/<code>call-log-query</code>.php?action=calLog&startDate=<span><input type="date" class="datechange" value="<?php date('Y-m-d');?>"></span>&endDate=<span><input type="date" class="datechange" value="<?php date('Y-m-d');?>"></span>&campaign=<span><select class="datechange" data-value="true"><option value="">Choose</option><option value="SHOW1">SHOW1</option><option value="SHOW2">SHOW2</option><option value="SHOW3">SHOW3</option><option value="SHOW5">SHOW5</option></select></span></p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                                </div>
                            </div>
                            
                            <div class="row">
                                <!-- <div class="col-10 thishtmltext">
                                    
                                </div> -->
                                <!-- <div class="col-2">
                                    <button>get call report</button>
                                </div> -->
                            </div>
                            
                            <span></span>
                            <!-- <div class="alert alert-primary" role="alert">
                               Page Under Construction
                            </div> -->
                            
                                </div>
                            </div> <!-- end .h-100-->
                        </div> <!-- end col -->
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
<div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">QC Dispo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <table class="table table-striped">
                            <tbody class="dispoAgentDetails">
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="col-6 qcCommentSection">
                            
                    </div>
                    <div class="col-12 py-3">
                        <div class="audioRec">

                        </div>
                    </div>
                    <div class="col-12 py-3 qcDispoTable d-none">
                        <h4 class="card-title mb-0 flex-grow-1 pb-4">Score Card Details</h4>
                        <table id="" class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                <thead class="text-muted table-light">
                                <th class="col">ID</th>
                                <th class="col">Title</th>
                            </thead>
                            <tbody class="qcdispoResult">

                            </tbody>
                        </table>
                    </div>
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

    <!-- Billing init -->
    <script src="assets/js/pages/Live-Status-ecommerce.init.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script> -->
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script> -->
    <script src="assets/js/xlsx.full.min.js"></script>
    <script src="assets/js/toastr.min.js"></script>
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
            // $.ajax({
            //         url: 'ajax/report/dashboard.php?action=selectcamp',
            //         type: 'get',
            //         data: {
            //             current_username:current_username
            //         },
            //         success: function(response)
            //         {
            //             console.log(response);
            //             var data = JSON.parse(response);
            //             if (data.status == 'Ok') {
                            
            //                 var record = data.data;
                            
            //                 $('#campaign').html('<option value="">-- Choose Campaign --</option>');
            //                 record.forEach(function(arr, idx){
                              
            //                     $('#campaign').append(`
            //                         <option value="${arr.campaign}">${arr.display_name}</option>
            //                     `);
            //                 });
            //             }
            //         }
            //     });
                var jsonData;
            $('body').on('click','#getRecord', function(){
              
                var fromdatevalue = $('#startDate').val();
                var todatevalue = $('#endDate').val();
                var slctcampvalue = $('#campaign').val();
                
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
                else
                {
                    $.ajax({
                            url: 'ajax/billing/billing.php?action=getBilling',
                            type: 'get',
                            data: {
                                fromdatevalue:fromdatevalue,
                                todatevalue:todatevalue,
                                slctcampvalue:slctcampvalue
                            },
                            success: function(response)
                            {
                                console.log(response);
                                var data = JSON.parse(response);
                                console.log(data);
                                if(data.status == 'Ok')
                                {
                                    var sno = 0;
                                    var record = data.data;
                                    // jsonData = record;
                                    // $('.table_result').html('');
                                    // record.map(function(arr, idx){
                                    //     if(arr.QC_dispo == 'QC')
                                    //     {
                                    //         var qcDispoClr = 'btn-soft-danger';
                                    //     }
                                    //     else
                                    //     {
                                    //         var qcDispoClr = 'btn-soft-primary';
                                    //     }

                                    //     if(currentUserRole == "sourceclients")
                                    //     {
                                    //         var maskedNumber = arr.phone_number;
                                    //     }
                                    //     else
                                    //     {
                                    //         var maskedNumber = arr.phone_number.substr(0, 3) + 'XXXXXX' + arr.phone_number.substr(8, 2); // Mask certain digits

                                    //     }
                                    //     // $('#phone_number').text(maskedNumber);

                                    //     $('.table_result').append(`
                                    //         <tr>
                                    //             <td>${sno+1}</td>
                                    //             <td>${arr.first_name}</td>
                                    //             <td>${arr.last_name}</td>
                                    //             <td>${maskedNumber}</td>
                                    //             <td>${arr.agent_username}</td>
                                    //             <td>${arr.camp}</td>
                                    //             <td>${arr.leadid}</td>
                                    //             <td><button class="btn `+qcDispoClr+` qcsubmitBtn" data-qccomment="${arr.QC_comments}" data-jsonrecord="${sno}">${arr.QC_dispo}</button></td>
                                    //             <td>${arr.QC_Audited}</td>
                                    //             <td>${arr.old_dispo}</td>
                                    //             <td>${arr.QC_update_timestamp}</td>
                                    //         </tr>
                                            
                                    //     `);
                                    //     sno++;
                                    // });
                                    // console.log(data.data);
                                }
                                else
                                {
                                    
                                }
                            }
                        });

                }
                
            });
            
            $('body').on('click', '#export_excel', function(){

                var startDate = $('#startDate').val();
                var campaign_name = $('#campaign').val();

                alert(campaign_name);

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
           $(document).ready(function(){
                                        $('body').on('change', '.datechange', function(){
                                            var value = $(this).val();
                                            
                                            if($(this).data('value'))
                                            {
                                                $(this).closest('span').html(value);
                                                var existLink = $('.thishtmltext').text();
                                                $('.thishtmltext').html(`<a href="`+existLink+`">`+existLink+`</a>`);
                                            }
                                            else
                                            {
                                                $(this).closest('span').html(value);
                                            }
                                        })
                                        // console.log('html', $('.thishtmltext').html());
                                        // console.log('text', $('.thishtmltext').text());
                                        // ;
                                        // $('.thishtmltext').text();
            });                         
    </script>
</body>


</html>