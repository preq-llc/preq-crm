<?php 
$page = 'graph';
include('../config.php'); 
include('../function/session.php');

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Graphical Statistics</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <!-- <link href="img/favicon.ico" rel="icon"> -->

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


        <!-- Sidebar Start -->
        <?php include('template/sidebar.php'); ?>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
             <input type="text" id="current_username" value="<?php echo $logged_in_user_name; ?>" data-role="<?php echo $logged_in_user_role; ?> "hidden>
        <?php include('template/navbar.php'); ?>
            <!-- Navbar End -->


            <!-- Sale & Revenue Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-line fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Calls</p>
                                <h6 class="mb-0 totalcalls">0</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-bar fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Hours</p>
                                <h6 class="mb-0 totalhours">0.00</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-area fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Today Transfer</p>
                                <h6 class="mb-0 todaytra">0</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-pie fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Today Billable</p>
                                <h6 class="mb-0 todaybil">0</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sale & Revenue End -->


            <!-- Sales Chart Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Agent Performance Graph</h6>
                              
                            </div>
                            <canvas id="worldwide-sales"></canvas>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Data Performance</h6>  
                            </div>
                            <canvas id="salse-revenue"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sales Chart End -->


            <!-- Recent Sales Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Top 5 Performer</h6>
                       
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-white text-center">
                                    <th scope="col">S.no</th> 
                                    <th scope="col">Agent Id</th>
                                    <th scope="col">Agent Name</th>
                                    <th scope="col">Hours</th>
                                    <th scope="col">Total Calls</th>
                                    <th scope="col">Transfer</th>
                                    <th scope="col">Billable</th>
                                    <th scope="col">TPH</th>
                                    <th scope="col">BPH</th>
                                </tr>
                            </thead>
                            <tbody class="topperformer text-center">
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Recent Sales End -->


            <!-- Widgets Start -->
<!--             <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-md-6 col-xl-4">
                        <div class="h-100 bg-secondary rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="mb-0">Messages</h6>
                                <a href="">Show All</a>
                            </div>
                            <div class="d-flex align-items-center border-bottom py-3">
                                <img class="rounded-circle flex-shrink-0" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-0">Jhon Doe</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                    <span>Short message goes here...</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center border-bottom py-3">
                                <img class="rounded-circle flex-shrink-0" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-0">Jhon Doe</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                    <span>Short message goes here...</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center border-bottom py-3">
                                <img class="rounded-circle flex-shrink-0" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-0">Jhon Doe</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                    <span>Short message goes here...</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center pt-3">
                                <img class="rounded-circle flex-shrink-0" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-0">Jhon Doe</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                    <span>Short message goes here...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-xl-4">
                        <div class="h-100 bg-secondary rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Calender</h6>
                                <a href="">Show All</a>
                            </div>
                            <div id="calender"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-xl-4">
                        <div class="h-100 bg-secondary rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">To Do List</h6>
                                <a href="">Show All</a>
                            </div>
                            <div class="d-flex mb-2">
                                <input class="form-control bg-dark border-0" type="text" placeholder="Enter task">
                                <button type="button" class="btn btn-primary ms-2">Add</button>
                            </div>
                            <div class="d-flex align-items-center border-bottom py-2">
                                <input class="form-check-input m-0" type="checkbox">
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 align-items-center justify-content-between">
                                        <span>Short task goes here...</span>
                                        <button class="btn btn-sm"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center border-bottom py-2">
                                <input class="form-check-input m-0" type="checkbox">
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 align-items-center justify-content-between">
                                        <span>Short task goes here...</span>
                                        <button class="btn btn-sm"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center border-bottom py-2">
                                <input class="form-check-input m-0" type="checkbox" checked>
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 align-items-center justify-content-between">
                                        <span><del>Short task goes here...</del></span>
                                        <button class="btn btn-sm text-primary"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center border-bottom py-2">
                                <input class="form-check-input m-0" type="checkbox">
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 align-items-center justify-content-between">
                                        <span>Short task goes here...</span>
                                        <button class="btn btn-sm"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center pt-2">
                                <input class="form-check-input m-0" type="checkbox">
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 align-items-center justify-content-between">
                                        <span>Short task goes here...</span>
                                        <button class="btn btn-sm"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- Widgets End -->


            <!-- Footer Start -->
            <?php include('template/footer.php'); ?>
            <!-- Footer End -->
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
    <?php $rand =rand(10000,99999); ?>
    <script src="js/main.js?<?php echo $rand ?>"></script>
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
                    carddata();
                    contactratio();
                    topfiveperformer();
                }
            });

            // Auto-refresh chart every 10 seconds if campaign is selected
            setInterval(function () {
                const campaignVal = $('#campaign').val();
                if (campaignVal) {
                    agentwisetiming();
                    carddata();
                    contactratio();
                    topfiveperformer();
                }
            }, 60000); // 10000 ms = 10 sec
                  
           
        });
        //Show Agent timing chart  in the zeafana
        function agentwisetiming(){

                    var campaign = $('#campaign').val();

                    $.ajax({

                        url:'sofana_db/graph.php?action=agenttiming',
                        type:'POST',
                        data:{campaign:campaign},
                        success: function (response) {
                            console.log(response);
                                    const hours = response.map(row => row.hours);
                                    const agentCounts = response.map(row => parseInt(row.agent_count));
                                    const billables = response.map(row => parseInt(row.billable));
                                    const transfers = response.map(row => parseInt(row.transfer));

                                    console.log(hours);

                                    var ctx1 = $("#worldwide-sales").get(0).getContext("2d");
                                    if (window.myBarChart) window.myBarChart.destroy(); // optional cleanup

                                    window.myBarChart = new Chart(ctx1, {
                                        type: "line",
                                        data: {
                                            labels: hours,
                                            datasets: [
                                                {
                                                    label: "Agent Count",
                                                    data: agentCounts,
                                                   borderColor: "rgba(54, 162, 235, 1)",
                                                        backgroundColor: "rgba(54, 162, 235, 0.2)",
                                                        pointBackgroundColor: "rgba(54, 162, 235, 1)",
                                                        pointBorderColor: "#fff",
                                                        tension: 0.5,
                                                        fill: false,
                                                },
                                                {
                                                    label: "Billable",
                                                    data: billables,
                                                    borderColor: "rgba(255, 99, 132, 1)",           // Line color
                                                    backgroundColor: "rgba(255, 99, 132, 0.2)",     // Area fill (optional if fill: true)
                                                    pointBackgroundColor: "rgba(255, 99, 132, 1)",  // Dot color
                                                    pointBorderColor: "#fff",                       // Dot border color
                                                    tension: 0.5,
                                                    fill: false,
                                                                                                     
                                                },
                                                {
                                                    label: "Transfer",
                                                    data: transfers,
                                                    borderColor: "rgba(255, 206, 86, 1)",
                                                    backgroundColor: "rgba(255, 206, 86, 0.2)",
                                                    pointBackgroundColor: "rgba(255, 206, 86, 1)",
                                                    pointBorderColor: "#fff",
                                                    tension: 0.5,
                                                    fill: false,
                                                }
                                            ]
                                        },
                                        options: {
                                            responsive: true,
                                            scales: {
                                                x: {
                                                    title: {
                                                        display: true,
                                                        text: 'Hour of Day'
                                                    }
                                                },
                                                y: {
                                                    beginAtZero: true,
                                                    title: {
                                                        display: true,
                                                        text: 'Count'
                                                    }
                                                }
                                            }
                                        }
                                    });
                                },

                        error:function(xhr,http,response){}

                    });
        }

       //Show Crad Data  in the zeafana
        function carddata(){

             var campaign = $('#campaign').val();
              $('.totalcalls').text('');
              $('.totalhours').text('');
              $('.todaytra').text('');
              $('.todaybil').text('');

                        $.ajax({

                            url:'sofana_db/graph.php?action=carddata',
                            type:'POST',
                            data:{campaign:campaign},
                            success: function (response) {
                                var data = (response[0]);
                                console.log(data);

                                      $('.totalcalls').text(data.TotalCalls);
                                      $('.totalhours').text((data.Hrs / 3600).toFixed(2));
                                      $('.todaytra').text(data.transfer);
                                      $('.todaybil').text(data.billable);
                                                       
                         
                            },

                            error:function(xhr,http,response){}

                        });              
        }

        //Show contactratio  in the zeafana
        function contactratio(){

                    var campaign = $('#campaign').val();

                   $.ajax({
                            url: 'sofana_db/graph.php?action=contactratio',
                            type: 'POST',
                            data: { campaign: campaign },
                            dataType: 'json',
                            success: function (response) {
                          
                                    const data = response;

                                    console.log(response);

                                    const hours = data.map(row => row.hour);
                                    const contactRatios = data.map(row => {
                                        const connected = parseInt(row.agentCalls);
                                        const total = parseInt(row.totalCalls);
                                        return total > 0 ? ((connected / total) * 100).toFixed(2) : 0;
                                    });

                                    const answeringMachineRatios = data.map(row => {
                                        const machine = parseInt(row.answermachinecalls);
                                        const total = parseInt(row.totalCalls);
                                        return total > 0 ? ((machine / total) * 100).toFixed(2) : 0;
                                    });

                                    // Destroy previous chart if needed
                                    if (window.contactRatioChart) {
                                        window.contactRatioChart.destroy();
                                    }

                                    const ctx2 = $("#salse-revenue").get(0).getContext("2d");

                                    window.contactRatioChart = new Chart(ctx2, {
                                        type: "line",
                                        data: {
                                            labels: hours,
                                            datasets: [
                                                          {
                                                            label: "Contact Ratio (%)",
                                                            data: contactRatios,
                                                            borderColor: "rgba(75, 192, 192, 1)",       // Line color
                                                            backgroundColor: "rgba(75, 192, 192, 0.2)", // Fill under line
                                                            pointBackgroundColor: "rgba(75, 192, 192, 1)", // Dot color
                                                            pointBorderColor: "#fff", // Dot border color
                                                            tension: 0.4,
                                                            fill: false
                                                          },
                                                          {
                                                            label: "Answering Machine Ratio (%)",
                                                            data: answeringMachineRatios,
                                                            borderColor: "rgba(255, 99, 132, 1)",
                                                            backgroundColor: "rgba(255, 99, 132, 0.2)",
                                                            pointBackgroundColor: "rgba(255, 99, 132, 1)",
                                                            pointBorderColor: "#fff",
                                                            tension: 0.4,
                                                            fill: false
                                                          }
                                                        ]

                                        },
                                        options: {
                                            responsive: true,
                                            scales: {
                                                x: {
                                                    title: {
                                                        display: true,
                                                        text: "Hour of Day"
                                                    }
                                                },
                                                y: {
                                                    beginAtZero: true,
                                                    title: {
                                                        display: true,
                                                        text: "Ratio (%)"
                                                    },
                                                    suggestedMax: 25
                                                }
                                            },
                                            plugins: {
                                                tooltip: {
                                                    mode: "index",
                                                    intersect: false
                                                },
                                                legend: {
                                                    position: "top"
                                                }
                                            }
                                        }
                                    });
                                
                            },
                            error: function (xhr, status, error) {
                                console.error("AJAX Error:", error);
                            }
                        });

        }

        //Top 5 performer 

        function  topfiveperformer() {
                const campaign = $('#campaign').val();

                $.ajax({
                    url: 'sofana_db/graph.php?action=topfiveperformer',
                    type: 'POST',
                    data: { campaign },
                    dataType: 'json',
                    success: function (response) {
                        const performers = response;
                        let serialNumber = 1;

                        // Clear previous data
                        $('.topperformer').empty();

                        performers.forEach((performer, index) => {

                            var tph = (performer.transfer / performer.total_hours).toFixed(2);
                            var bph = (performer.billable / performer.total_hours).toFixed(2);

                            $('.topperformer').append(`
                                <tr>
                                    <th>${serialNumber}</th>
                                    <td>${performer.agent_id || ''}</td>
                                    <td>${performer.agent_name || ''}</td>
                                    <td>${performer.total_hours || 0}</td>
                                    <td>${performer.total_calls || 0}</td>
                                    <td>${performer.transfer || 0}</td>
                                    <td>${performer.billable || 0}</td>
                                    <td>${tph || 0}</td>
                                    <td>${bph || 0}</td>
                                </tr>
                            `);
                            serialNumber++;
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", error);
                    }
                });
        }





               

    </script>
</body>

</html>