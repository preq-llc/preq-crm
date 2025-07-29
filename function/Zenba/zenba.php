<?php
$page = 'zenba';
include '../../config.php';
include '../session.php';

$role=$_SESSION['role'];
// $campaign_name=$_SESSION['user_camp'];
$username = $_SESSION['emp_id'];
$group = $_SESSION['group'];

date_default_timezone_set('America/New_York');
$today_from = date("Y-m-d 00:00:00");
$today_to = date("Y-m-d 23:59:59");

$forms=date("Y-m-d");

// include('../template/header.php');
// include('../template/navbar.php');
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js_camp/campfetch.js" type="text/javascript"></script>
<script src="JS/zenba.js" type="text/javascript"></script>
<div class="content-wrapper mt-5">
    <!-- <div class="header bg-dark text-white py-4">
      <h4>Zenba Running...</h4>
    </div> -->
    <div class="row">

        <section class="content mt-5">
            <div class="col-md-12">
                <div class="box box-success" >
                    <input type="hidden" id="username" class="form-control" value="<?php echo $username; ?>" />
                    <!--<center><h2 >FILTER : <?php echo $campaign; ?></h2></center>-->
                    <div class="box-header row">
                        <div class="form-group col-md-2">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">From</label>
                            <input type="Date" id="fromdate" class="form-control" value="<?php echo $forms; ?>" />
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">To</label>
                            <input type="date" id="todate" class="form-control" value="<?php echo $forms; ?>" />
                        </div>


                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Campaign Name</label>
                            <select class="form-control" value="" id="slctcamp" name="campaign">
                                <option value="">ALL</option>
                                <option value="FTE_ALL">EDU_SB_ALL</option>
                                <option selected value="EDU_SB">EDU_SB</option>
                                <option value="EDULive">EDULive</option>
                                <option value="EDU_SB1">EDU_SB1</option>
                            </select>
                        </div>

                        <div class="form-group col-md-3">

                            <button id="btnsubmit" style="display: none;" value="submit" class="btn btn-primary form-control" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
            </Select>
            


            <section class="content container">
            <div id="refreshCount" class="my-4" data-count="0">
                Refresh Count : <span>0</span>
            </div>
                <!-- agent summary-->
                <div id="screen" class="col-md-6">
                    <div class="box box-info" style="background: #dfdfdf;">
                        <center><span class="viewget">Zenba</span></center>
                        <div class="box-header">

                            <div class="table-responsive">

                                <table id="example" class="table table-bordered table-striped1">
                                    <thead>
                                        <tr>
                                            <th>campaign ID</th>
                                            <th>User</th>
                                            <th>Phone Num</th>
                                            <th>Date/Time</th>
                                            <th>Lead ID</th>

                                        </tr>

                                    </thead>

                                    <tbody id="dispoalldata">
                                        <tr>
                                        </tr>
                                    </tbody>

                                </table>

                            </div>

                        </div>
                    </div>
                </div>



    </div>
</div>
</div>
</div>


</section>
</div>
</div>
</div>
<?php 

// include '../teamplate/footer.php';

 ?>
