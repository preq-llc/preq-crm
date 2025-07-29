<?php 
$page = 'zeafana';
include('../config.php'); 
include('../function/session.php');

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Graph</title>
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
   
            <div class="container-fluid pt-4 px-4">


            <!-- Chart Start -->

                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">Single Line Chart</h6>
                            <canvas id="line-chart"></canvas>
                        </div>
                    </div>
<!--                     <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">Agent Chart</h6>
                            <canvas id="salse-revenue"></canvas>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">Single Bar Chart</h6>
                            <canvas id="bar-chart"></canvas>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">Multiple Bar Chart</h6>
                            <canvas id="worldwide-sales"></canvas>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">Pie Chart</h6>
                            <canvas id="pie-chart"></canvas>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">Doughnut Chart</h6>
                            <canvas id="doughnut-chart"></canvas>
                        </div>
                    </div> -->
                </div>
    
            <!-- Chart End -->
 

            </div>


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

              
            // Manually trigger once on change
            $('#campaign').on('change', function () {
                const campaignVal = $(this).val();
                if (campaignVal) {
                    agentwisetiming(); // First immediate load
                }
            });

            // Auto-refresh chart every 10 seconds if campaign is selected
            setInterval(function () {
                const campaignVal = $('#campaign').val();
                if (campaignVal) {
                    agentwisetiming();
                }
            }, 10000); // 10000 ms = 10 sec
                  
           
        });
         //Show Agent timing chart  in the zeafana
        function agentwisetiming(){

                    var campaign = $('#campaign').val();

                    $.ajax({

                        url:'sofana_db/graph.php?action=agenttiming',
                        type:'POST',
                        data:{campaign:campaign},
                        success: function (response) {
                            var data = (response);
                            console.log(data);

                            const hours = data.map(item => item.hours);
                            const agentCounts = data.map(item => parseInt(item.agent_count));

                            // Destroy previous chart if needed
                            if (window.agentChart) {
                                window.agentChart.destroy();
                            }

                            const ctx = document.getElementById('line-chart').getContext('2d');

                            // Dynamically calculate X-axis stepSize
                            const maxTicks = 10; // target visible X-axis ticks
                            const stepSize = Math.ceil(hours.length / maxTicks);

                            window.agentChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: hours,
                                    datasets: [{
                                        label: 'Agent Count',
                                        data: agentCounts,
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        tension: 0.3,
                                        fill: false,
                                        pointRadius: 3,
                                        pointHoverRadius: 6,
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    scales: {
                                        x: {
                                            title: {
                                                display: true,
                                                text: 'Hour of Day'
                                            },
                                            ticks: {
                                                autoSkip: false,
                                                stepSize: stepSize
                                            }
                                        },
                                        y: {
                                            title: {
                                                display: true,
                                                text: 'Agent Count'
                                            },
                                            beginAtZero: true
                                        }
                                    },
                                    plugins: {
                                        legend: {
                                            display: false
                                        },
                                        tooltip: {
                                            mode: 'index',
                                            intersect: false
                                        }
                                    }
                                }
                            });
                        },

                        error:function(xhr,http,response){}

                    });
        }

               

    </script>
</body>

</html>