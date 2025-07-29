<?php
    $page = 'Qc Audit';
    include('config.php');
    include('function/session.php');

    date_default_timezone_set('America/New_York');
    $today_from = date("Y-m-d 00:00:00");
    $today_to = date("Y-m-d 23:59:59");

    $forms=date("Y-m-d");

    $role=$_SESSION['role'];
    $username = $_SESSION['username'];
    $group = $_SESSION['group'];


    $action=$_GET['action'];

    if($action=='showleads')
    {
      $fname=$_GET['fname'];
      $lname=$_GET['lname'];
      $user=$_GET['user'];
      $camp=$_GET['camp'];
      $time=$_GET['time'];
      $leadid=$_GET['leadid'];
      $phone=$_GET['phone'];
      $audio=$_GET['audio'];

    }
    $connn=mysqli_connect("192.168.200.59","zeal","4321","Agent_calls_FAPI");
    $qq1="SELECT * FROM `QC_Reports` WHERE `phone_number` ='$phone' AND timestamp='$time'"; 
    $row221=mysqli_query($connn,$qq1) or die(mysqli_error($connn));
    $result221 = mysqli_fetch_array($row221);
    $final_status=$result221['final_status'];


?>
<input type="text" id="current_username" value="<?php echo $logged_in_user_name;?>" data-role="<?php echo $logged_in_user_role;?>" hidden>
<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">


<head>

    <meta charset="utf-8" />
    <title>Qc Audit | <?php echo $site_name;?> - Dialer CRM</title>
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
                                                <?php 

                                                    if($final_status=='WIP')
                                                        { ?>

                                                            <button id="qc_feedbacks" value="submit" class="btn btn-primary clk"style="margin-top: 8px;float:right">Submit</button>
                                                <?php } ?>
               
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
                                                <div class="col-6">
                                                    <div class="card">
                                                        <div class="card-header align-items-center d-flex">
                                                        <h4 class="card-title mb-0 flex-grow-1">Calls Details</h4>
                                                        </div>
                                                        <div class="card-body">

                                                                    <div class="table-responsive table-card">
                                                                        <table id="export_table" class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                                            <thead class="text-muted table-light">
                                                                                <tr>
                                                                        
                                                                                    <th scope="col" >First Name</th>
                                                                                    <th scope="col">Last Name</th>
                                                                                    <th scope="col">Phone Number</th>
                                                                                    <th scope="col">Campaign</th>
                                                                                    <th scope="col">lead ID</th>
                                                                                    <th scope="col">timestamp</th>

                                                                                </tr>

                                                                            </thead>
                                                                            <tbody class="table_result">
                                                                                <tr>
                                                                                   <td id="firstname"><?php echo $fname ?></td>
                                                                                   <td id="lastname"><?php echo  $lname ?></td>
                                                                                   <td id="phonenumber"><?php echo $phone ?></td>
                                                                                   <td id="campaigns"><?php echo $camp ?></td>
                                                                                   <td id="listid"><?php echo $leadid ?></td>
                                                                                   <td id="timestamps"><?php echo $time ?></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table><!-- end table -->
                                                                    </div>
                                                            
                                                        </div>
                                                    </div>

                                                      <div class="card">
                                                        <div class="card-header align-items-center d-flex">
                                                        <h4 class="card-title mb-0 flex-grow-1">Calls Recording</h4>
                                                        </div>
                                                        <div class="card-body">

                                                                    <div class="table-responsive table-card">
                                                                        <table id="export_table" class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                                            <thead class="text-muted table-light">
                                                                                <tr>
                                                                                    <th scope="col">Lead Recording</th>
                                                                                </tr>

                                                                            </thead>
                                                                            <tbody class="table_result">
                                                                                <tr>
                                                                                    <td>
                                                                                            <audio  style="width: 90%;" controls >
                    
                                                                                            <source  src="<?php echo $audio; ?>" type="audio/mp3"> 

                                                                                          </audio>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table><!-- end table -->
                                                                    </div>
                                                            
                                                        </div>
                                                      </div>

                                                      <div class="card">
                                                        <div class="card-header align-items-center d-flex">
                                                        <h4 class="card-title mb-0 flex-grow-1">QC Feedback</h4>
                                                        </div>
                                                        <div class="card-body">

                                                                    <div class="table-responsive table-card">
                                                                        <table id="ai_table" class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                                            <thead class="text-muted text-center table-light">
                                                                                <tr>
                                                                        
                                                                                    <th rowspan="4" scope="col">Transcript</th>
                                                                                    <th colspan="4" scope="col">AI Analysis</th>
                                                                                    
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>polarity</th>
                                                                                    <th>subjectivity</th>
                                                                                    <th>tone</th>
                                                                                    <th>agreement</th>
                                                                                </tr>

                                                                            </thead>
                                                                            <tbody class="aitable_result text-center">
                                                                                <tr>
                                                                                    <td>
                                                                                        <textarea class="form-control" id="transcript" name="w3review" rows="" cols="50"></textarea>
                                                                                         
                                                                                    </td>
                                                                                    <td>
                                                                                         <span class="badge bg-danger">2.32</span>
                                                                                    </td>
                                                                                    <td>
                                                                                         <span class="badge bg-success">4.62</span>
                                                                                    </td>
                                                                                    <td>
                                                                                         <span class="badge bg-primary">neutral</span>
                                                                                    </td>
                                                                                            <td>
                                                                                         <span class="badge bg-dark">agreement</span>
                                                                                    </td>                                                                                
                                                                                </tr>
                                                                            </tbody>
                                                                        </table><!-- end table -->
                                                                        <table id="export_table" class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                                            <thead class="text-muted table-light">
                                                                                <tr>
                                                                        
                                                                                    <th scope="col">QC Feed Back</th>
                                                                                    <th scope="col">Dispoation</th>
                                                                                </tr>

                                                                            </thead>
                                                                            <tbody class="table_result">
                                                                                <tr>
                                                                                    <td>
                                                                                        <textarea class="form-control" id="feedback" name="w3review" rows="" cols="50"></textarea>
                                                                                         
                                                                                    </td>
                                                                                    <td>
                                                                                          <label><input type="radio" name="optradio" value="DNC" required> DNC</label><br>
                                                                                          <label><input type="radio" name="optradio" value="QC" required> QC</label><br>
                                                                                          <label><input type="radio" name="optradio" value="Submit" required> Submit</label><br>
                                                                                          <label><input type="radio" name="optradio" value="QcDnc" required> QcDnc</label>
                                                                                    </td>
                                                                                                                                                                            
                                                                                </tr>
                                                                            </tbody>
                                                                        </table><!-- end table -->
                                                                    </div>
                                                            
                                                        </div>
                                                      </div>
                                                


                                                </div>
                                                <div class="col-6">
                                                    <div class="card">
                                                        <div class="card-header align-items-center d-flex">
                                                        <h4 class="card-title mb-0 flex-grow-1">Qc Feedback</h4>
                                                        </div>
                                                        <div class="card-body" style="max-height: 550px;overflow:auto;">

                                                            <nav>
                                                              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Mark Off</a>
                                                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">QC Reject</a>
                                                                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">DNQ</a>
                                                              </div>
                                                            </nav>

                                                             <div class="tab-content" id="nav-tabContent">
                                                              <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                                                  

                                                              </div>
                                                              <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                                                  

                                                              </div>
                                                              <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                                                  
                                                              </div>
                                                            </div>
                                                        

                                                            
                                                        </div>
                                                    </div>    


                                                    
                                                </div>
                                            </div><!--end row-->
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end .h-100-->
                        </div> <!-- end col -->
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                                
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
                        <th>Status</th>
                        <th>Description</th>
                        <th>Calls</th>
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
              <div class="audioRec" id="wrapper">
                    <audio class="getthisaudio" preload="metadata" controls>
                        <source src="/"  type="audio/mpeg">
                    </audio>
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
$(document).ready(function () {
    const currentUsername = $("#current_username").val();
    const currentUserRole = $("#current_username").data('role');

    // Load DNQ Data and Populate Tabs
    $.ajax({
        url: 'ajax/qc/qcdnqdata.php?action=dnqselect',
        type: 'GET',
        success: function (response) {
            const parsed = JSON.parse(response);
            const dnqItems = parsed.data;

            // Clear old DNQ content
            $('#nav-home, #nav-profile, #nav-contact').empty();

            dnqItems.forEach(function (item) {
                const checkboxHtml = `
                    <div class="form-check mt-4">
                        <span>${item.id}:</span>
                        <input class="form-check-input dnq-check" data-type="${item.type}" type="checkbox" name="dnq[]" value="${item.id}" id="dnq_${item.id}">
                        <label class="form-check-label text-wrap" for="dnq_${item.id}">${item.dnq}</label>
                    </div>
                `;

                if (item.type === 'Mark Off') {
                    $('#nav-home').append(checkboxHtml);
                } else if (item.type === 'QC Reject') {
                    $('#nav-profile').append(checkboxHtml);
                } else if (item.type === 'Dnq') {
                    $('#nav-contact').append(checkboxHtml);
                }
            });

            // Handle hiding of "Submit" radio option
            $('body').on('change', '.dnq-check', function () {
                const selectedTypes = $('.dnq-check:checked').map(function () {
                    return $(this).data('type');
                }).get();

                if (selectedTypes.includes('QC Reject') || selectedTypes.includes('Dnq')) {
                    $('input[type=radio][value=Submit]').closest('label, .form-check, td').hide();
                } else {
                    $('input[type=radio][value=Submit]').closest('label, .form-check, td').show();
                }
            });
        },
        error: function (xhr, status, error) {
            console.error('Error loading DNQ data:', error);
        }
    });

    // Submit QC Feedback
    $("#qc_feedbacks").on("click", function () {
        const dataPayload = {
            firstname: $("#firstname").text(),
            lastname: $("#lastname").text(),
            listid: $("#listid").text(),
            phonenumber: $("#phonenumber").text(),
            timestamps: $("#timestamps").text(),
            campaigns: $("#campaigns").text(),
            feedback_commends: $("#feedback").val(),
            programming: $("input[name='dnq[]']:checked").map(function () {
                return this.value;
            }).get().join(','),
            disp_command: $("input[name='optradio']:checked").val(),
            username: $("#current_username").val()
        };

        // AJAX to submit QC feedback
        $.ajax({
            url: "ajax/qc/qcinsertedalldata.php",
            type: "POST",
            data: dataPayload,
            success: function (response) {
                const result = JSON.parse(response);
                if (result.statusCode == 200) {
                    window.location.href = 'qc-lead-details.php';
                } else {
                    alert("Error occurred while saving data.");
                }
            }
        });
    });
});
</script>


</body>


</html>