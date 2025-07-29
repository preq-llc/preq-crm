<?php
include 'session.php';
include 'header.php';
// include 'top-bar.php';
include 'side-bar.php';
include 'db-con.php';

$role=$_SESSION['role'];
$campaign_name=$_SESSION['user_camp'];
$username = $_SESSION['emp_id'];
$group = $_SESSION['group'];

date_default_timezone_set('America/New_York');
$today_from = date("Y-m-d 00:00:00");
$today_to = date("Y-m-d 23:59:59");

$forms=date("Y-m-d");

?>
<?php
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
 
  
  
  ?>
<style type="text/css">
 
.card {
 background: #fff;
    border-radius: 2px;
    display: inline-block;
    height: 102px;
    margin: 1rem;
    position: relative;
    width: 158px;
}

.card-1 {
  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
  transition: all 0.3s cubic-bezier(.25,.8,.25,1);
}

.card-1:hover {
  box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
}
.viewget
{
      font-size: 18px;
    font-weight: bold;
    color: #798981 !important;

}
.viewnumget
{
  font-size: 23px;
    font-weight: bold;

}

.chart {
  display: grid;
  grid-template-rows: repeat(100, 1fr);
  grid-column-gap: 10px;
  width: 100%;
  max-width: 100%;
  height: 180px;
  max-height: 1000px;
  border-bottom: 5px solid black;
}

.bar {
  grid-row-end: 102;
  position: relative;
  background: #055b97;
  border-radius: 5px 5px 0 0;
  
}

.bar-percent {
  position: relative;
  top: -20px;
  text-align: center;
}

.bar-name {
  position: relative;
  bottom: 60%;
  padding-top: 20px;
  text-align: center;font-size: 14px;
  color: #ffffff;
}


.chart2 {
  display: grid;
  grid-template-rows: repeat(100, 1fr);
  grid-column-gap: 10px;
  width: 100%;
  max-width: 100%;
  height: 300px;
  max-height: 1000px;
  border-bottom: 5px solid black;
}

.bar2 {
  grid-row-end: 102;
  position: relative;
  background: #00b0f0;
  border-radius: 5px 5px 0 0;
}

.bar-percent2 {
  position: relative;
  top: -20px;
  text-align: center;
}

.bar-name2 {
  position: relative;
  bottom: -99%;
  padding-top: 20px;
  text-align: center;font-size: 11px;
}


  .loader{

    display: none;
  }

  audio {
        background:linear-gradient(to top left, cyan, hotpink, gold);
        margin-top:20px;
        margin-left:20px;
      }
      
      audio:hover {
        -webkit-box-shadow: 0px 0px 9px 5px rgba(5,4,5,1);
        -moz-box-shadow: 0px 0px 9px 5px rgba(5,4,5,1);
        box-shadow: 0px 0px 9px 5px rgba(5,4,5,1);
      }
      
      .styleit audio::-webkit-media-controls-panel {
        background:linear-gradient(to top left, cyan, hotpink, gold);
      }

   
.modal-dialog {
    width: 1200px;
    margin: 30px auto;
}



</style>
 
<script src="qc_js_data1/qc_lead_reports.js" type="text/javascript"></script>
<script src="qc_js_data1/request.js" type="text/javascript"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
     <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
     <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
     <script type="text/javascript">
       $("#lead_reports").css("background-color", "#4b646f");
     </script>

  <div class="content-wrapper">
  <div class="row">
    
  <section class="content">

     <div class="col-md-12"  style="
    margin-left: 13px;
    width: 1641px;
">
       
       <section class="content">

          <div class="row">
          <div class="col-md-4">
            <input type="hidden" id="username"  class="form-control" value="<?php echo $username; ?>" />
         
          <div class="box box-warning">
         <div class="box-body">
          
         <div class="box box-header" style="
    border-top: 3px solid #ffffff;
">
      <span class="badge bg-yellow" id="fechidall"></span> Agent Lead
      <br/><br/> 
         <div class="form-group col-md-6">
           <ul class="list-group list-group-unbordered">
         
           <li class="list-group-item">
                      <i class="fa fa-user margin-r-5 text-yellow"></i>First Name
                    </li>
           <li class="list-group-item">
                      <i class="fa fa-user-plus margin-r-5 text-yellow"></i>Last Name
                    </li>
         
          <li class="list-group-item">
                      <i class="fa fa-mail-forward  margin-r-5 text-green"></i>Lead ID
                    </li>

                    <li class="list-group-item">
                      <i class="fa fa-phone  margin-r-5 text-blue"></i>Phone
                    </li>

                    <li class="list-group-item">
                      <i class="fa fa-user margin-r-5 text-yellow"></i>Timestamp
                    </li>

                    <li class="list-group-item">
                      <i class="fa fa-user margin-r-5 text-yellow"></i>campaign
                    </li>

                     </ul>
           </div>
            <div class="form-group col-md-5">
           <ul class="list-group list-group-unbordered">
           
           <li class="list-group-item">
                      <i class=" margin-r-5 text-green"><img src="loading2.gif" class="loader" height="100px" style="
    margin-left: 25px;
    height: 26px;
    margin-top: -2px;
"></i><span class="  pull-left col-md-2-pull-out " id="firstname"><?php echo $fname; ?></span>
                    </li>
           <li class="list-group-item">
                      <i class=" margin-r-5 text-green"><img src="loading2.gif" class="loader" height="100px" style="
    margin-left: 25px;
    height: 26px;
    margin-top: -2px;
"></i><span class=" pull-left col-md-2-pull-out " id="lastname"><?php echo $lname; ?></span>
                    </li>
         
         
          
        
           <li class="list-group-item">
                      <i class=" margin-r-5 text-green"><img src="loading2.gif" class="loader" height="100px" style="
    margin-left: 25px;
    height: 26px;
    margin-top: -2px;
"></i><span class="badge bg-yellow pull-left col-md-2-pull-out " id="listid"><?php echo $leadid; ?></span>
                    </li>

                     <li class="list-group-item">
                      <i class=" margin-r-5 text-green"><img src="loading2.gif" class="loader" height="100px" style="
    margin-left: 25px;
    height: 26px;
    margin-top: -2px;
"></i><span class="badge bg-green pull-left col-md-2-pull-out " id="phonenumber"><?php echo $phone; ?></span>
                    </li>


                    <li class="list-group-item">
                      <i class=" margin-r-5 text-green"><img src="loading2.gif" class="loader" height="100px" style="
    margin-left: 25px;
    height: 26px;
    margin-top: -2px;
"></i><span class="badge bg-green pull-left col-md-2-pull-out " id="timestamps"><?php echo $time; ?></span>
                    </li>

                     <i class=" margin-r-5 text-green"><img src="loading2.gif" class="loader" height="100px" style="
    margin-left: 25px;
    height: 26px;
    margin-top: -2px;
"></i><span class="badge bg-green pull-left col-md-2-pull-out " id="campaigns" style="margin-top: 16px;"><?php echo $camp; ?></span>
                    </li>
            
           </ul>
           </div>
         <div class="col-md-12">    
         <div class="row">
                <div class="form-group col-md-12">
                <label for="exampleInputEmail1">Lead Recording <?php
                if($camp == 'EDU_SB')
                {
                  // $modifiedAudio = str_replace('rec183', 'rec183L', $audio);
                  $modifiedAudio = $audio;

                  // echo $modifiedAudio;
                }
                else
                {
                  $modifiedAudio = $audio;
                }
                // echo $audio;
                // $audio = ' https://zealousvoice.com/zealous/rec183/2024-06-14/20240614-094236_7542490249-all.mp3';
                  
                ?></label>
        <div id='audiovalue'>
            <audio  style="width: 95%; margin-top: 10px; margin-right: 25px; margin-left: 25px;" controls >
            
        <source  src="<?php echo $modifiedAudio; ?>" type="audio/mp3"> 

      </audio>

    </div>

  
           
                  </div>
          </div>
        </div>
                </div>
        </div>
        </div>
      </div>

 
       <div class="col-md-8">
          <div class="box box-warning">
         <div class="box-body">
          
          <form>


<!-- ----------------------------------------------------------------------- -->
  <input type="checkbox" id="num1" name="programming1" value="1">
  <label for="vehicle1"><span>1)&nbsp</span> The agent interrupted the prospect when they were speaking (Mark Off)</label><br>
  <!-- ----------------------------------------------------------------- -->
  <input type="checkbox" id="num2" name="programming1" value="2">
  <label for="vehicle2"><span>2)&nbsp</span> Dead air (meaning absolutely no prompts being played) for longer than 10 seconds on the call.(Mark Off)</label><br>
  <input type="checkbox" id="num3" name="programming1" value="3">
  <label for="vehicle3"><span>3)&nbsp</span>he agent interrupted the inbound agent's intro with the warm handoff prompt.(Mark Off)</label><br>
  <input type="checkbox" id="num4" name="programming1" value="4">
  <label for="vehicle1"><span>4)&nbsp</span>The agent used banters or other prompts to manipulate a change in a DNQ answer.(If not, QC Reject)</label><br>
  <input type="checkbox" id="num5" name="programming1" value="5">
  <label for="vehicle2"><span>5)&nbsp</span>The agent played all mandatory prompts (If not, QC Rejec)</label><br>
  <input type="checkbox" id="num6" name="programming1" value="6">
  <label for="vehicle3"><span>6)&nbsp</span>The agent gave false information or false promises to the prospect (If not, QC Reject)</label><br>
  <input type="checkbox" id="num7" name="programming1" value="7">
  <label for="vehicle1"><span>7)&nbsp</span>The agent did not play the opt out prompt or the call recorded prompt again if another person came on the line, or a callback was made(If not, QC Reject)</label><br>
  <input type="checkbox" id="num8" name="programming1" value="8">
  <label for="vehicle3"><span>8)&nbsp</span>The agent DNC'd the prospect if requested/needed (If not, QC Reject)</label><br>
  <input type="checkbox" id="num9" name="programming1" value="9">
  <label for="vehicle1"><span>9)&nbsp</span>The agent transferred a qualified prospect (no child/non-English speaker/answering machine, etc) (If not, QC Reject)</label><br>
  <input type="checkbox" id="num10" name="programming1" value="10">
  <label for="vehicle2" ><span>10)&nbsp</span>The lead stated they were not interested during the transfer portion of the script, but the lead forced the transfer (If yes, QC Reject)</label><br>
  <input type="checkbox" id="num11" name="programming1" value="11">
  <label for="vehicle3"><span>11)&nbsp</span>The agent played prompts after inbound has fully taken over the call (If yes, QC Reject)</label><br>
  <input type="checkbox" id="num12" name="programming1" value="12">
  <label for="vehicle3" style="margin-left: 17px;
    margin-top: -46px;"> <span>12)&nbsp</span>The agent did not address a concern or question that the prospect asked and continued with the call, or the agent played more than 3 rebuttals to overpush the lead.
     (If yes, QC Reject)</label><br>
  <input type="checkbox" id="num13" name="programming1" value="13">
  <label for="vehicle3"><span>13)&nbsp</span>General markoff reasons</label><br>
  <input type="checkbox" id="num14" name="programming1" value="14">
  <label for="vehicle3"><span>14)&nbsp</span>3rd party information was gathered (If yes, QC Reject)</label><br>
   <input type="checkbox" id="num15" name="programming1" value="15">
  <label for="vehicle3"><span>15)&nbsp</span>General QC Rejection *agent must ask lead reviewer before using (If not, QC Reject)</label><br>
    <input type="checkbox" id="num16" name="programming1" value="16">
  <label for="vehicle3"><span>16)&nbsp</span>The agent updated the form page correctly (If not, QC Reject)</label><br>
   <input type="checkbox" id="num16" name="programming1" value="52">
  <label for="vehicle3"><span>17(A)&nbsp</span>The agent not reconfirming mandatory prompt/question.</label><br>
   
  
      </form>
        
        </div>
      </div>
    </div>
  </div>

<div class="row">
  <div class="col-md-4">
          <div class="box box-warning">
         <div class="box-body">
          
         <div class="box box-header" style="
    border-top: 3px solid #ffffff;
">
     
      <br/>
         <div class="form-group col-md-12">

           <div class="modal-header">
    
          <h4 class="modal-title" style="font-weight: bold;font-size: 16px;">Qc Feed Back</h4>
        </div>

          
          
         <div class="box box-header" style="
    border-top: 3px solid #ffffff;
">

<textarea  id="feedback" name="w3review" rows="4" cols="60">
 
  </textarea>




 </div>

           </div>
           
          

             <div class="form-group col-md-12">

                   <div class="modal-header">
         
          <h4 class="modal-title" style="font-weight: bold;font-size: 16px;margin-top: -30px;">Dispo Change</h4>
        </div>

  <label class="radio-inline">
      <input type="radio" name="optradio" value="DNC" required>DNC
    </label>
    <label class="radio-inline">
      <input type="radio" name="optradio" value="QC" required>QC
    </label>
    <label class="radio-inline">
      <input type="radio" name="optradio" value="Submit" required>Submit
    </label>
   

           </div>
        
                </div>
        </div>
        </div>
      </div>

       <div class="col-md-8">
          <div class="box box-warning">
         <div class="box-body">
          
          <form>

 
  <input type="checkbox" id="num17" name="programming1" value="17">
  <label for="vehicle3"><span>17)&nbsp</span>Medicare/Medicaid (DNQ)</label><br>
  <input type="checkbox" id="num18" name="programming1" value="18">
  <label for="vehicle3"><span>18)&nbsp</span>NO MEDICARE (DNQ)</label><br>
  <input type="checkbox" id="num19" name="programming1" value="19">
  <label for="vehicle3"><span>19)&nbsp</span>OUT OF WORK (DNQ)</label><br>
  <input type="checkbox" id="num20" name="programming1" value="20">
  <label for="vehicle3"><span>20)&nbsp</span>PHYSICIAN CARE (DNQ)</label><br>
  <input type="checkbox" id="num21" name="programming1" value="21">
  <label for="vehicle3"><span>21)&nbsp</span>PROSPECT CURRENTLY ENROLLED IN SCHOOL (DNQ)</label><br>
  <input type="checkbox" id="num22" name="programming1" value="22">
  <label for="vehicle3"><span>22)&nbsp</span>REBUTTAL ENROLLED (DNQ)</label><br>
  <input type="checkbox" id="num23" name="programming1" value="23">
  <label for="vehicle3"><span>23)&nbsp</span>SOCIAL SECURITY TAXES (DNQ)</label><br>
  <input type="checkbox" id="num24" name="programming1" value="24">
  <label for="vehicle3"><span>24)&nbsp</span>SS BENEFITS (DNQ)</label><br>
  <input type="checkbox" id="num25" name="programming1" value="25">
  <label for="vehicle3"><span>25)&nbsp</span>SS BENEFITS 24 MONTHS (DNQ)</label><br>
  <input type="checkbox" id="num26" name="programming1" value="26">
  <label for="vehicle3"><span>26)&nbsp</span>TESTIFIED JUDGE (DNQ)</label><br>
  <input type="checkbox" id="num27" name="programming1" value="27">
  <label for="vehicle3"><span>27)&nbsp</span>US CITIZEN (DNQ)</label><br>
  <input type="checkbox" id="num28" name="programming1" value="28">
  <label for="vehicle3"><span>28)&nbsp</span>WORK CREDITS (DNQ)</label><br>
   <input type="checkbox" id="num29" name="programming1" value="29">
  <label for="vehicle3"><span>29)&nbsp</span>WORKED 5 OF THE LAST 10 YEARS (DNQ)</label><br>
   <input type="checkbox" id="num30" name="programming1" value="30">
  <label for="vehicle3"><span>30)&nbsp</span>YEAR GRAD/G.E.D (DNQ)</label><br>
 
   
      </form>
        
        </div>
      </div>
    </div>
</div>

<div class="row">
   <div class="col-md-4">
          <div class="box box-warning" style="height: 563px;" >
 <div class="card">
  <div class="card-header">
    
  </div>
  <div class="card-body col-md-8">
    <h5 class="card-title">FeedBack</h5>
    <div class="col-md-8">
   <table id="data-table" class="table table-bordered table-responsive{-sm|-md|-lg|-xl} hover multiple-select-row nowrap text-cente col-md-8">
    <thead>
        <tr>

            <th>QC Feedback</th>
            <th>QC comments</th>
            <th>QC dispo</th>
            
             
        </tr>
    </thead>
    <tbody id="overallfetchdata_views">
    </tbody>
</table>
    </div>

  </div>
</div>


     </div>
   </div>

       <div class="col-md-8">
          <div class="box box-warning">
         <div class="box-body">
          
          <form>


<!-- ----------------------------------------------------------------------- -->
  <input type="checkbox" id="num31" name="programming1" value="31">
  <label for="vehicle1"><span>31)&nbsp</span>1 YEAR OUT OF WORK (DNQ)</label><br>
  <!-- ----------------------------------------------------------------- -->
  <input type="checkbox" id="num32" name="programming1" value="32">
  <label for="vehicle2"><span>32)&nbsp</span>12 MONTHS (DNQ)</label><br>
  <input type="checkbox" id="num33" name="programming1" value="33">
  <label for="vehicle3"><span>33)&nbsp</span>AGE(DNQ)</label><br>
  <input type="checkbox" id="num34" name="programming1" value="34">
  <label for="vehicle1"><span>34)&nbsp</span>AOI (DNQ)</label><br>
  <input type="checkbox" id="num35" name="programming1" value="35">
  <label for="vehicle2"><span>35)&nbsp</span>BENEFITS (DNQ)</label><br>
  <input type="checkbox" id="num36" name="programming1" value="36">
  <label for="vehicle3"><span>36)&nbsp</span>BIRTH YEAR (DNQ)</label><br>
  <input type="checkbox" id="num37" name="programming1" value="37">
  <label for="vehicle1" ><span>37)&nbsp</span>BIRTHDATE (DNQ)</label><br>
  <input type="checkbox" id="num38" name="programming1" value="38">
  <label for="vehicle2"><span>38)&nbsp</span>CITIZEN (DNQ)</label><br>
  <input type="checkbox" id="num39" name="programming1" value="39">
  <label for="vehicle3"><span>39)&nbsp</span>DISABILITY/OUT OF WORK (DNQ)</label><br>
  <input type="checkbox" id="num40" name="programming1" value="40">
  <label for="vehicle1"><span>40)&nbsp</span>EMAIL (DNQ)</label><br>
  <input type="checkbox" id="num41" name="programming1" value="41">
  <label for="vehicle2" ><span>41)&nbsp</span>EMPLOYED (DNQ)</label><br>
  <input type="checkbox" id="num42" name="programming1" value="42">
  <label for="vehicle3"><span>42)&nbsp</span>FT JOB 5 OF LAST 10 YEARS (DNQ)</label><br>
  <input type="checkbox" id="num43" name="programming1" value="43">
  <label for="vehicle3"><span>43)&nbsp</span>FT JOB IN 5 YEARS (DNQ)</label><br>
  <input type="checkbox" id="num44" name="programming1" value="44">
  <label for="vehicle3"><span>44)&nbsp</span>HOMEOWNER (DNQ)</label><br>
  <input type="checkbox" id="num45" name="programming1" value="45">
  <label for="vehicle3"><span>45)&nbsp</span>IF NO TO Medicare/Medicaid (DNQ)</label><br>
   <input type="checkbox" id="num46" name="programming1" value="46">
  <label for="vehicle3"><span>46)&nbsp</span>INCOME (DNQ)</label><br>
    <input type="checkbox" id="num47" name="programming1" value="47">
  <label for="vehicle3"><span>47)&nbsp</span>LAWYER (DNQ)</label><br>
   <input type="checkbox" id="num48" name="programming1" value="48">
  <label for="vehicle3"><span>48)&nbsp</span>LESS THAN 1 YEAR (DNQ)</label><br>
   <input type="checkbox" id="num49" name="programming1" value="49">
  <label for="vehicle3"><span>49)&nbsp</span>MEDICAL CONDITION (DNQ)</label><br>
   <input type="checkbox" id="num50" name="programming1" value="50">
  <label for="vehicle3"><span>50)&nbsp</span>MEDICAL PROVIDER (DNQ)</label><br>
  <input type="checkbox" id="num51" name="programming1" value="51">
  <label for="vehicle3"><span>51)&nbsp</span>Medicare Parts A & B (DNQ)</label><br>
   <input type="checkbox" id="num51" name="programming1" value="53">
  <label for="vehicle3"><span>52)&nbsp</span>Highest Level of Education (DNQ)</label><br>
   <input type="checkbox" id="num51" name="programming1" value="54">
  <label for="vehicle3"><span>53)&nbsp</span>Do Plan on Further Education (DNQ)</label><br>
  

  <input type="checkbox" id="num51" name="programming1" value="58">
  <label for="vehicle3"><span>54)&nbsp</span>The agent used an irrelevant rebuttal (If yes, QC Reject)</label><br>
  <input type="checkbox" id="num51" name="programming1" value="59">
  <label for="vehicle3"><span>55)&nbsp</span>FURTHER EDUCATION (DNQ)</label><br>
  <input type="checkbox" id="num51" name="programming1" value="60">
  <label for="vehicle3"><span>56)&nbsp</span>The agent played the "Good Candidate" Prompt (If not, Mark off)</label><br>
  <input type="checkbox" id="num51" name="programming1" value="61">
  <label for="vehicle3"><span>57)&nbsp</span>The agent did not play the rebuttal completely(QC Reject)</label><br>
  
      </form>
        
        </div>
      </div>
    </div>
</div>

 
        <div class="form-group col-md-6">
        </div>
       <div class="form-group col-md-2">
 
 
 
   <center> 
 <?php
         
          $connn=mysqli_connect("192.168.200.59","zeal","4321","Agent_calls_FAPI");
          $qq1="SELECT * FROM `QC_Reports` WHERE `phone_number` ='$phone' AND timestamp='$time'"; 
            $row221=mysqli_query($connn,$qq1) or die(mysqli_error($connn));
            $result221 = mysqli_fetch_array($row221);

            $final_status=$result221['final_status'];

            if($final_status=='WIP')
            {

          ?>
                 <button id="qc_feedbacks" value="submit" class="btn btn-primary form-control clk" type="button" style="margin-top: 8px;">Submit</button>
                <?php } else
                { ?>
                   <button   class="btn btn-danger form-control clk" type="button" style="margin-top: 8px;">FeedBack</button>
               <?php }  ?>
 </center>
 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



  <script src="qc_js_data/request.js"></script>  
 
<div>
 
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
}
include 'footer.php';
 ?>


