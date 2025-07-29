<?php
    $page = 'leadreport';
    include('config.php');
    include('function/session.php');
    
?>
<input type="text" id="current_username" value="<?php echo $logged_in_user_name;?>" data-role="<?php echo $logged_in_user_role;?>" hidden>
<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">


<head>

    <meta charset="utf-8" />
    <title>Qc Report | <?php echo $site_name;?> - Dialer CRM</title>
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
                                                                <label for="">Source</label>
                                                                <select name="" id="source" class="form-select">
                                                                    <option value="">-- Choose Source --</option>
                                                                    <option value="IVEIN">Inbound</option>
                                                                    <option value="IVE360">Outbound</option>
                                                                </select>
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
                                                                    echo '<option value="" selected>-- Choose Center --</option>';

                                                                    $single_callcenter = explode(",", $logged_in_user_group);
                                                                    foreach ($single_callcenter as $center) {
                                                                        echo '<option value="' . trim($center) . '">' . trim($center) . '</option>';
                                                                    }
                                                                    
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button" class="btn btn-soft-success mt-3" id="getRecordsss"><i class="ri-add-circle-line align-middle me-1"></i>
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
                                        <h4 class="card-title mb-0 flex-grow-1">QC</h4>
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
                                                        <th scope="col">Campaign ID</th>
                                                        <th scope="col">Agent ID</th>
                                                        <th scope="col">Agent Name</th>
                                                        <th scope="col">Call Center</th>
                                                        <th scope="col">Phone Num</th>
                                                        <th scope="col">Dispo</th>
                                                        <th scope="col">Qc Dispo</th>
                                               
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody class="table_result_qc">
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
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header">
    <h5 id="offcanvasRightLabel">Recording Details</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
<div class="offcanvas-body recorddatashow">
  <table class="table">
    <tbody>
      <tr>
        <th>First Name</th>
        <td><input type="text" class="form-control" id="firstname" disabled>
            <input type="text" class="form-control" id="leadid" hidden>
            <input type="text" class="form-control" id="campaigndata" hidden>
            <input type="text" class="form-control" id="client" hidden></td>
      </tr>
      <tr>
        <th>Last Name</th>
        <td><input type="text" class="form-control" id="lastname" disabled></td>
      </tr>
      <tr>
        <th>Address</th>
        <td><input type="text" class="form-control" id="address" disabled></td>
      </tr>
      <tr>
        <th>City</th>
        <td><input type="text" class="form-control" id="city" disabled></td>
      </tr>
      <tr>
        <th>State</th>
        <td><input type="text" class="form-control" id="state" disabled></td>
      </tr>
      <tr>
        <th>Zip</th>
        <td><input type="text" class="form-control" id="zipcode" disabled></td>
      </tr>
      <tr>
        <th>Email</th>
        <td><input type="email" class="form-control" id="email" disabled></td>
      </tr>
      <tr>
        <th>Phone Number</th>
        <td><input type="tel" class="form-control" id="phone" disabled></td>
      </tr>
       <tr>
        <th>Qc Status</th>
        <td><select class="form-control qcstatus">
                  <option vlaue="">Select</option>
                  <option vlaue="Approved">Approved</option>
                  <option vlaue="Rejected" >Rejected</option>
           </select>
        </td>
      </tr>
        <tr>
        <th>Qc Comments</th>
        <td>
            <textarea class="form-control qccomments"></textarea>
        </td>
      </tr>
    </tbody>
  </table>
  <div class="mb-3 audioRecshow" style="width:320px"></div>

   <div class="mb-5 p-4">
       <button type="submit" class="btn btn-info submitdata" style="float:right">Submit</button>
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
$(document).ready(function() {
    var current_username = $("#current_username").val();
    var currentUserRole = $("#current_username").data('role');

    // Fetch campaigns on page load
    fetchCampaigns(current_username);

    // Initialize functions
    getDatatable();
    storeData();
});

// Function to fetch campaigns
function fetchCampaigns(current_username) {
    $.ajax({
        url: 'ajax/report/dashboard.php?action=selectcamp',
        type: 'GET',
        data: {
            current_username: current_username
        },
        success: function(response) {
            console.log(response);
            var data = JSON.parse(response);
            if (data.status === 'Ok') {
                var record = data.data;
                $('#campaign').html('<option value="">-- Choose Campaign --</option>');
                record.forEach(function(arr) {
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
    $('#getRecordsss').on('click', function() {
        var fromdatevalue = $('#startDate').val();
        var todatevalue = $('#endDate').val();
        var slctcampvalue = $('#campaign').val();
        var source = $('#source').val();
        var call_centervalue = $('#call_center').val();

        $('.table_result_qc').html(`
            <tr>
                <td colspan="8" class="text-center">No Record Found</td>
            </tr>
        `);

        if (!fromdatevalue) {
            toastr.warning('Please Choose Start date!');
            $('#startDate').focus();
        } else if (!todatevalue) {
            toastr.warning('Please Choose End date!');
            $('#endDate').focus();
        } else {
            $.ajax({
                url: 'ajax/report/iverichqcreport.php?action=getqcleads',
                type: 'GET',
                data: {
                    fromdatevalue: fromdatevalue,
                    todatevalue: todatevalue,
                    source:source,
                    slctcampvalue: slctcampvalue,
                    call_centervalue: call_centervalue
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        displayQCData(data.data);
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
    $('.table_result_qc').empty();
    var serialnumber = 1;


    qcdata.forEach(function(value) {
        var phonenumber = value.phone_number;
        var callcenter = value.agent.slice(0, 3);
        var qcstatuss = value.qc_status;
        var qcstatusstwo = value.qc_status;
        var qccommentss = value.qc_comments;
        var stausbutton;
        var qcstatusbutton;
   

    


        if (qcstatusstwo === 'Rejected') {
            qcstatusbutton = `<td>
                <button class="btn btn-danger btn-sm">
                    QC Rejected
                </button>
            </td>`;
        } else if (qcstatusstwo === 'Approved') {
            qcstatusbutton = `<td>
                <button class="btn btn-success btn-sm">
                    QC Approved
                </button>
            </td>`;
        } else if (qcstatusstwo === null || qcstatusstwo === '') {
            qcstatusbutton = `<td>
                <button class="btn btn-info btn-sm">
                    No QC Status
                </button>
            </td>`;
        }






        if (qcstatuss != null) {
            stausbutton = `
                <td class="recorddata" 
                            onclick="recordingdata(this)" 
                            data-leadid="${value.lead_id}" 
                            data-ph="${phonenumber}" 
                            data-campaign="${value.campaign_id}" 
                            data-client="${value.client}"
                            data-file="${value.location}" 
                            data-qcstatus="${qcstatuss}" 
                            data-qccom="${qccommentss}" 
                            data-bs-toggle="offcanvas" 
                            data-bs-target="#offcanvasRight" 
                            aria-controls="offcanvasRight">
                        ${value.status}
               
                </td>`;
        } else {
            stausbutton = `
                <td onclick="recordingdata(this)" 
                    data-leadid="${value.lead_id}" 
                    data-ph="${phonenumber}" 
                    data-campaign="${value.campaign_id}"
                    data-client="${value.client}"
                    data-file="${value.location}" 
                    class="recorddata" 
                    data-bs-toggle="offcanvas" 
                    data-bs-target="#offcanvasRight" 
                    aria-controls="offcanvasRight">
                    ${value.status}
                </td>`;
        }

        $('.table_result_qc').append(`
            <tr>
                <td>${serialnumber}</td>
                <td>${value.lead_id}</td>
                <td>${value.campaign_id}</td>
                <td>${value.agent}</td>
                <td>${value.full_name}</td>
                 <td>${callcenter}</td>
                <td>${phonenumber}</td>
                    ${stausbutton}
                    ${qcstatusbutton}
            </tr>
        `);
        serialnumber++;
    });
}

// Function to handle recording data retrieval
function recordingdata(element) {
    var leadid = $(element).data('leadid');
    var phonenumber = $(element).data('ph');
    var campaign = $(element).data('campaign');
    var client = $(element).data('client');
    var filenameaudio = $(element).data('file');
    var qcstatusdata = $(element).data('qcstatus') || '';
    var qccommentdata = $(element).data('qccom') || '';

    $.ajax({
        url: 'ajax/report/iverichqcreport.php?action=getrecorddata',
        type: 'POST',
        data: {
            leadid: leadid,
            phonenumber: phonenumber,
            campaign: campaign,
            client:client,
        },
        success: function(response) {
            var data = JSON.parse(response);
            console.log(data);
            var details = data.data[0];
            if (data.status === 'success') {
                displayRecordDetails(details, qcstatusdata, qccommentdata, filenameaudio,campaign);
            }
        }
    });
}

// Function to display record details and audio
function displayRecordDetails(details, qcstatusdata, qccommentdata, filenameaudio, campaign) {
    
    // Now, show the new data
    $('#leadid').val(details.lead_id);
    $('#campaigndata').val(campaign);
    $('#firstname').val(details.first_name);
    $('#lastname').val(details.last_name);
    $('#address').val(details.address1);
    $('#city').val(details.city);
    $('#state').val(details.state);
    $('#zipcode').val(details.postal_code);
    $('#email').val(details.email);
    $('#phone').val(details.phone_number);

    $('.qcstatus').val(qcstatusdata);
    $('.qccomments').val(qccommentdata);

    // Display the new audio file
    $('.audioRecshow').html(`
        <audio controls style="width: 95%; margin-top: 10px; margin-right: 25px; margin-left: 25px;">
            <source src="${filenameaudio}">
        </audio>
    `);
}


// Function to store the submitted data
function storeData() {
    $('.submitdata').on('click', function() {

            qcstatus = $('.qcstatus').val();

            if (qcstatus === '') {
                toastr.warning('QC status is empty');
                return;  
            }

        var formData = {
            leadid: $('#leadid').val(),
            campaign: $('#campaigndata').val(),
            phone: $('#phone').val(),
            qcstatus:qcstatus,
            qccomments: $('.qccomments').val()
        };

        $.ajax({
            url: 'ajax/report/iverichqcreport.php?action=insertdata',
            type: 'POST',
            data: formData,
            success: function(response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    resetForm();
                    $('#offcanvasRight').offcanvas('hide');
                     toastr.success('Data Updated successfully');



                }
            }
        });
    });
}

// // Function to reset the form
function resetForm() {
    $('.qcstatus').val('');
    $('.qccomments').val('');
}
</script>



</body>


</html>