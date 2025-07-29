<?php 
$page = 'zeafana';
include('../config.php'); 
include('../function/session.php');

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>


<style type="text/css">
    h5, .h5 {
    font-size: 7.25rem;
}
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- <script src="js/agent_stats.js"></script> -->

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

         <?php include('template/sidebar.php'); ?>



        <!-- Content Start -->
        <div class="content pe-4 pb-3">
            <!-- Navbar Start -->
            <input type="text" id="current_username" value="<?php echo $logged_in_user_name; ?>" data-role="<?php echo $logged_in_user_role; ?> "hidden>
            <?php include('template/navbar.php'); ?>
            <!-- Sales Chart Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">

                      <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">Transfer</h6>
                            <div class="owl-carousel testimonial-carousel">
                                <div class="testimonial-item text-center">
                                    
                                    <h5 class="mb-1 transfer" >0</h5>
                                    <p></p>
                                    <p class="mb-0"></p>
                                    
                                </div>


                              
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">Billable</h6>
                            <div class="owl-carousel testimonial-carousel">
                                <div class="testimonial-item text-center">
                                    
                                    <h5 class="mb-1 billable" >0</h5>
                                    <p></p>
                                    <p class="mb-0"></p>
                                </div>
                              
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-12 col-xl-3">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">Hours</h6>
                            <div class="owl-carousel testimonial-carousel">
                                <div class="testimonial-item text-center">
                                    
                                    <h5 class="mb-1 hours">0</h5>
                                    <p></p>
                                    <p class="mb-0"></p>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                     <div class="col-sm-12 col-xl-3">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">Calls</h6>
                            <div class="owl-carousel testimonial-carousel">
                                <div class="testimonial-item text-center">
                                    
                                    <h5 class="mb-1 calls">0</h5>
                                    <p></p>
                                    <p class="mb-0"></p>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                    


                    <div class="col-sm-12 col-xl-3">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">TPH</h6>
                            <div class="owl-carousel testimonial-carousel">
                                <div class="testimonial-item text-center">
                                    
                                    <h5 class="mb-1 tphview">0</h5>
                                    <p></p>
                                    <p class="mb-0"></p>
                                </div>
                              
                            </div>
                        </div>
                    </div>

                    

                    <div class="col-sm-12 col-xl-3">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">BPH</h6>
                            <div class="owl-carousel testimonial-carousel">
                                <div class="testimonial-item text-center">
                                    
                                    <h5 class="mb-1 bphview">0</h5>
                                    <p></p>
                                    <p class="mb-0"></p>
                                </div>
                              
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-xl-3">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">Aca Transfer</h6>
                            <div class="owl-carousel testimonial-carousel">
                                <div class="testimonial-item text-center">
                                    
                                    <h5 class="mb-1 acatra" style="color: #00ff4d;">0</h5>
                                    <p></p>
                                    <p class="mb-0"></p>
                                </div>
                              
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-xl-3">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">Aca Billable</h6>
                            <div class="owl-carousel testimonial-carousel">
                                <div class="testimonial-item text-center">
                                    
                                    <h5 class="mb-1 acabill" style="color: #00ff4d;">0</h5>
                                    <p></p>
                                    <p class="mb-0"></p>
                                </div>
                              
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-12 col-xl-3">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">Medds Transfer</h6>
                            <div class="owl-carousel testimonial-carousel">
                                <div class="testimonial-item text-center">
                                    
                                    <h5 class="mb-1 meddstra" style="color: #00ff4d;">0</h5>
                                    <p></p>
                                    <p class="mb-0"></p>
                                </div>
                              
                            </div>
                        </div>
                    </div>

                        <div class="col-sm-12 col-xl-3">
                            <div class="bg-secondary rounded h-100 p-4">
                                <h6 class="mb-4">Medds Billable</h6>
                                <div class="owl-carousel testimonial-carousel">
                                    <div class="testimonial-item text-center">
                                        
                                        <h5 class="mb-1 meddsbill" style="color: #00ff4d;">0</h5>
                                        <p></p>
                                        <p class="mb-0"></p>
                                    </div>
                                  
                                </div>
                            </div>
                    </div>

                  
                    
                  
                   
                </div>
            </div>
            <!-- Sales Chart End -->

            <?php include('template/footer.php'); ?>



           
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script>
        
        $(document).ready(function(){
            var current_username = $("#current_username").val();
            var currentUserRole = $("#current_username").data('role');
           
            var selectstatus;
            $.ajax({
                url: '../ajax/report/dashboard.php?action=selectcamp',
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
                          
                             let selected = (arr.campaign === campaign) ? 'selected' : '';
                            $('#campaign').append(`
                                    <option value="${arr.campaign}" ${selected}>${arr.display_name}</option>
                                `);

                            // $('#campaign').trigger('change');
                        });
                    }
                }
            });

              //Show data in the zeafana
               
        // Function to fetch and update campaign stats
            function updateCampaignStats() {
                var campaign = $('#campaign').val();
                
                if (campaign !== '') {
                    $.ajax({
                        url: 'sofana_db/dashboard.php?action=statusdata',
                        type: 'POST',
                        data: { campaign: campaign },
                        success: function(response) {
                            var firstRecord = response;

                            let hrs = parseFloat(firstRecord.Hrs) || 0;
                            let transfer = parseFloat(firstRecord.transfer) || 0;
                            let billable = parseFloat(firstRecord.billable) || 0;

                            let hours = hrs > 0 ? (hrs / 3600).toFixed(2) : '0.00';
                            let tphPercent = hrs > 0 ? (transfer / (hrs / 3600)).toFixed(2) : '0.00';
                            let bphPercent = hrs > 0 ? (billable / (hrs / 3600)).toFixed(2) : '0.00';

                            $('.transfer').text(firstRecord.transfer);
                            $('.billable').text(firstRecord.billable);
                            $('.hours').text(hours);
                            $('.calls').text(firstRecord.Totalcalls);
                            $('.tphview').text(tphPercent);
                            $('.bphview').text(bphPercent);
                            $('.acatra').text(firstRecord.acatransfer);
                            $('.acabill').text('0');
                            $('.meddstra').text(firstRecord.medtransfer);
                            $('.meddsbill').text('0');
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching status data:', error);
                        }
                    });
                }
            }

            // Set up the change event handler
            $('body').on('change', function() {
                var campaign = $('#campaign').val();

                // Reset all display values
                $('.transfer').text('0');
                $('.billable').text('0');
                $('.hours').text('0.00');
                $('.calls').text('0');
                $('.tphview').text('0.00');
                $('.bphview').text('0.00');
                $('.acatra').text('0');
                $('.acabill').text('0');
                $('.meddstra').text('0');
                $('.meddsbill').text('0');

                if (campaign !== '') {
                    setTimeout(updateCampaignStats, 300);
                }
            });

            // Set up polling every 3 seconds (only runs when campaign has value)
            var pollInterval = setInterval(function() {
                if ($('#campaign').val() !== '') {
                    updateCampaignStats();
                }
            }, 60000); // 3000ms = 3 seconds

            // Optional: Clear interval when needed (e.g., when leaving the page)
            $(window).on('beforeunload', function() {
                clearInterval(pollInterval);
            });






        });
    </script>
</body>

</html>