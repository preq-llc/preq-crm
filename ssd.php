<?php

$phoneuser=$_GET['phoneuser'];
$user=$_GET['phoneuser'];
$cmp = $_GET['campaign'];
$lsd = $_GET['lsd'];
$ldd = $_GET['ldd'];
$phn = $_GET['phn'];
$fn = $_GET['fn'];
$ln = $_GET['ln'];
$adr = $_GET['adr'];
$adr2 = $_GET['adr2'];
$adr3 = $_GET['adr3'];
$cty = $_GET['cty'];
 $st = $_GET['st'];
$zip = $_GET['zip'];
$mail = $_GET['mail'];
$rcid = $_GET['rcid'];
$rcfl = $_GET['rcfl'];
$cmt = $_GET['cmt'];
$source=$_GET['source'];

$ExecutiveId =$_GET['exid'];
date_default_timezone_set('America/New_York');
$Timestamp=date("y-m-d H:i:s");
$Times=date("H:i:s");
$usrgrp = $_GET['usrgrp'];
$province=$_GET['province'];
$ip=""; 

$date = $cmt;
$date1=date('Y/m/d', strtotime($date));
$datenew = str_replace('/', '-', $date1);
$day=date('d', strtotime($datenew));
$month=date('m', strtotime($datenew));
$year=date('y', strtotime($datenew));

if($mail!='')
{
    $final_mail=$mail;

}else
{
    $final_mail="".$fn."@gmail.com";
}

if($cmt!='')
{
    $final_cmt=$cmt;

}else
{
    $final_cmt="NA";
}


$conns = mysqli_connect("192.168.200.59","zeal","4321","FTE_ACA");
?>
<!-- saved from url=(0046)http://www.tmivaka.com/images/vaka.hs-new.html -->
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>SSD</title>
<style>
body {font-family: Arial;}

/* Style the tab */
.tab {
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
    margin-top:200px;
}


.tab button {
    background-color:#3c8dbc;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 6px 92px;
    transition: 0.3s;
    font-size: 13px;
    margin-left: 8px;
}

/* Change background color of buttons on hover */
.tab button:hover {
    background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
    background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
}
.tabcontent {
    display: none;
    padding: 6px 12px;
   
    border-top: none;
}

.orangeButton {
	background-color:#428bca;
	-moz-border-radius:6px;
	-webkit-border-radius:6px;
	border:1px solid #428bca;
	display:inline-block;
	cursor:pointer;
	color:#ffff;
	font-family:arial;
	font-size:11px;
	font-weight:bold;
	padding:3px 5px;
	text-decoration:none;
text-align: center;
display:block;
width: 100px;
vertical-align:middle;
white-space: nowrap;
}
.orangeButton:hover {
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #fb9e25), color-stop(1, #ffc477));
	background:-moz-linear-gradient(top, #fb9e25 5%, #ffc477 100%);
	background:-webkit-linear-gradient(top, #fb9e25 5%, #ffc477 100%);
	background:-o-linear-gradient(top, #fb9e25 5%, #ffc477 100%);
	background:-ms-linear-gradient(top, #fb9e25 5%, #ffc477 100%);
	background:linear-gradient(to bottom, #fb9e25 5%, #ffc477 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#fb9e25', endColorstr='#ffc477',GradientType=0);
	background-color:#fb9e25;
}
.orangeButton:active {
	position:relative;
	top:1px;
}
.orangeButton.visited {
background: red;
}
.tabcontent.active {
    display: block;
}
#fixedDiv
{
/*    display: none;*/
}
</style>
 

 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

   
</head>
<body>
<br><br>
      
   
  <div class="frm">
     <center style="    margin-left:122px;">
    
    
    <p id="htmlFrame" class="text-center" style="
 border: 2px solid #3498db;
        border: 2px solid rgb(52, 152, 219);
   
        overflow: auto;
        padding: 11px;
   
    box-shadow: rgba(0, 0, 0, 0.2) 5px 5px 15px 3px;
    border-radius: 25px;
    line-height: 1.5;
    font-size: 22px;
    position: fixed;
    text-align: center;
    font-family: Times New Roman;
    -webkit-text-stroke-width: thin;
    word-break:10px;

    word-spacing:2px;
    line-break: auto;
    color-interpolation: linearrgb;
    background-color: aliceblue;
    width: 80%;
    max-width: 114%;
    height: auto;
    margin: 14px 25px;
    text-overflow: ellipsis;
    overflow: hidden;
    margin-top: -10px;
    hyphens: auto;
  overflow-wrap: break-word;
   /*   margin-top: 86px;*/
    margin-left: -17px;">
</p>

 
 </center>

 </div>  

<!-- ============================================================================================================================================= -->
  <style>
        #htmlFrame {
            display: none;
        }
    </style>
<style>
  
  .custom-button{
    border-radius:8px;
    color:black;
    
      display: inline-block;
      background-color: #428bca;
    -moz-border-radius: 6px;
    -webkit-border-radius: 6px;
    border: 1px solid #428bca;
    display: inline-block;
    cursor: pointer;
    color: #ffff;
    font-family: arial;
    font-size: 11px;
    font-weight: bold;
    padding: 3px 5px;
    
  flex-direction: column;
  align-items: center;
  padding: 6px 14px;
  font-family: -apple-system, BlinkMacSystemFont, 'Roboto', sans-serif;
  border-radius: 6px;
  
   background-origin: border-box;
  box-shadow: 0px 0.5px 1.5px rgba(54, 122, 246, 0.25), inset 0px 0.8px 0px -0.25px rgba(255, 255, 255, 0.2);
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  border: none;
    
  outline: 0;
  
  
 
  } 
  
 
 .custom-button {
    margin:2px; 
   font-family: Arial, sans-serif;
   -webkit-border-radius: 20px;

}
.custom-button {
  
     width: 120px;
    height: 22px
px
;
}
 
.bg-red {
    background-color: red;
    color: white;
}

.bg-Blue {
  background: linear-gradient(180deg, #4B91F7 0%, #367AF6 100%);
    color: white;
}
 .frm{

    position: fixed;
    top: 35px;
    left: 0;
    right: 0;
     z-index:800;
     scroll-behavior: smooth;
      overflow: auto;
}

 
.frm3{
  position:relative;
    top: 0px;
    left: 0;
    right: 0;
    z-index:250;
    scroll-behavior: smooth;
    overflow: hidden;
}

.bj{

    top: 0px;
    left: 0px;
    right: 0px;
    position: sticky;
     z-index: 550;

}



 
</style>
<!-- ============================================= -->

</style>

<?php

 $stvalue=$fr['state']; //first state B1 // BUYER 5
$stvaluenew=$fr1['state']; // third state B2 // BUYER 7
$stvalueFE=$fr2['state'];  // second state B3 // BUYER 6
$stvalueFour=$fr3['state'];  // four state B4


?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body style="color: #000; background-color: #ffff; " class="style06">


     <div class="bj"  style="
   background-color: #fff;
    padding: 10px;
    border: 1px solid #fff;
    border-radius: 5px;
    margin-bottom: -26px;
    /*margin-top: 84px;*/
    height:216px;
    position: fixed;
    ">

    
   

    <tr> 

    <div id="fixedDiv" style=" position: fixed;margin-top: 302px;margin-left: -192px;z-index: 99;"> <td><a id="wbfromone" data-form="1" target="_blank" href="http://crm.goldensprucemartech.com/xfer/index.php?firstname=<?php echo $fn; ?>&lastname=<?php echo $ln; ?>&address=<?php echo $adr; ?>&city=<?php echo $cty; ?>&state=<?php echo $st; ?>&zip=<?php echo $zip; ?>&phone=<?php echo $phn; ?>&dob=<?php echo $final_cmt; ?>&email=<?php echo $final_mail; ?>&q1=yes&q2=yes&q3=yes&q4=yes&pub=SENT_PHARMACY_COOLER&trustedid=yes&leadtype=pharmacy&affid=10021&dev=0" class="orangeButton wbfromone"   style="background-color: rgb(46 153 177);color: white;border-color: rgb(66, 139, 202);margin-left: 300px;margin-bottom: 53px;width: 121px;height: 22px;font-family: system-ui;margin-top: -180px;">Webform 1</a></td></div>
    <div id="fixedDiv2" style=" position: fixed;margin-top: 302px;margin-left: -22px;z-index: 99;"> <td><a id="wbfromone" data-form="2" target="_blank" href="http://crm.goldensprucemartech.com/xfer/index.php?firstname=<?php echo $fn; ?>&lastname=<?php echo $ln; ?>&address=<?php echo $adr; ?>&city=<?php echo $cty; ?>&state=<?php echo $st; ?>&zip=<?php echo $zip; ?>&phone=<?php echo $phn; ?>&dob=<?php echo $final_cmt; ?>&email=<?php echo $final_mail; ?>&q1=yes&q2=yes&q3=yes&q4=yes&pub=SENT_PHARMACY_COOLER&trustedid=yes&leadtype=pharmacy&affid=10021&dev=0" class="orangeButton wbfromone"   style="background-color: rgb(46 153 177);color: white;border-color: rgb(66, 139, 202);margin-left: 300px;margin-bottom: 53px;width: 121px;height: 22px;font-family: system-ui;margin-top: -180px;">Webform 2</a></td></div>
    <div id="fixedDiv3" style=" position: fixed;margin-top: 302px;margin-left: 152px;z-index: 99;"> <td><a id="wbfromone" data-form="3" target="_blank" href="http://crm.goldensprucemartech.com/xfer/index.php?firstname=<?php echo $fn; ?>&lastname=<?php echo $ln; ?>&address=<?php echo $adr; ?>&city=<?php echo $cty; ?>&state=<?php echo $st; ?>&zip=<?php echo $zip; ?>&phone=<?php echo $phn; ?>&dob=<?php echo $final_cmt; ?>&email=<?php echo $final_mail; ?>&q1=yes&q2=yes&q3=yes&q4=yes&pub=SENT_PHARMACY_COOLER&trustedid=yes&leadtype=pharmacy&affid=10021&dev=0" class="orangeButton wbfromone" style="background-color: rgb(46 153 177);color: white;border-color: rgb(66, 139, 202);margin-left: 300px;margin-bottom: 53px;width: 121px;height: 22px;font-family: system-ui;margin-top: -180px;">Webform 3</a></td></div>


<?php { ?>

        <div id="fixedDiv" style=" position: fixed;margin-bottom: -302px;z-index: 9;">

        <td><button class="orangeButton transferBtn" id="transfer1" style="display:none;background-color:#428347;color:white;border-color:#428bca;margin-left: 300px;height: 30px;width: 125px;font-size: 12px;margin-top: 123px;">Transfer B</button></td></div>

            <?php } if($stvaluenew==$st){ ?>

<div id="fixedDiv" style=" position: fixed;margin-bottom: -302px">

        <!-- <td><button class="orangeButton" id="transfertwo" style="background-color:#428347;color:white;border-color:#428bca;margin-left: 462px;height: 30px;width: 125px;font-size: 12px;margin-top: 123px;">Transfer B3</button></td></div> -->


        <?php } if($stvalueFE==$st) 

        {  if($Times>='11:00:00') {?>

        <div id="fixedDiv" style="margin-bottom: -302px">

        <!-- <td><button class="orangeButton" id="transferthree" style="background-color:#428347;color:white;border-color:#428bca;margin-left: 628px;height: 30px;width: 125px;font-size: 12px;margin-top: -23px;">Transfer 6</button></td></div> -->

    <?php  } } if($stvalueFour==$st) 

        {  if($Times>='10:00:00') {?>

        <div id="fixedDiv" style=" position: fixed;margin-bottom: -302px">

        <!-- <td><button class="orangeButton" id="transferfour" style="background-color:#428347;color:white;border-color:#428bca;margin-left: 804px;height: 30px;width: 125px;font-size: 12px;margin-top: -23px;">Transfer 4</button></td></div> -->

    <?php  } } ?>
     



    <div id="fixedDiv" style=" position: fixed;"><td><button class="orangeButton duringCallBtns" data-btnname="xway" id="xway1" style="background-color: rgb(251, 158, 37);color: white;border-color: rgb(66, 139, 202);margin-left: 320px;margin-top: 92px;width: 103px;height: 29px;">LEAVE_3WAY</button></td>

    <td><button class="orangeButton duringCallBtns"  data-btnname="hangupxfer"  id="hangupxfer1" style="background-color: rgb(251, 158, 37);color: white;border-color: rgb(66, 139, 202);margin-left: 532px;margin-top: -29px;width: 129px;height: 29px;">HANGUP_XFER LINE</button></td>

    <td><button class="orangeButton duringCallBtns" data-btnname="hangupboth"   id="hangupboth1" style="background-color: rgb(251, 158, 37);color: white;border-color: rgb(66, 139, 202);margin-left: 756px;margin-top: -29px;width: 140px;height: 28px;">HANGUP_BOTH LINES</button></td></tr></div></div>
        


<script>
document.addEventListener('contextmenu', event => event.preventDefault());
</script>
<div id="Main" class="tabcontent active" style="font-size:14;background-color: aliceblue;font-family: system-ui;
    font-weight: 600;">
 
<tbody>
 

 
</p>

    <style>
    .scrollable {
        overflow-y: scroll;
    }
    </style>

    
<tbody>


 
</p>

    <style>
    .scrollable {
        overflow-y: scroll;
    }
    </style>
 
                        
</tr>
 
 
<!-- <?php include 'SSDINEWExtra.php'; ?> -->


</table>
</tbody></table>
</div>
<div id="Transfer" class="tabcontent" style="font-size:14;background-color: aliceblue;font-family: system-ui;
    font-weight: 600;">
 
<tbody>
</tr>

<table cellpadding="0" class="style41" cellspacing="0">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

 
</p>

    <style>
    .scrollable {
        overflow-y: scroll;
    }
    </style>

 
 <?php include 'SSDINEWExtra.php'; ?>
 

 
</table>
</tbody></table>
</div>
<div id="Form" class="tabcontent" style="font-size:14;background-color: aliceblue;font-family: system-ui;
    font-weight: 600;">
 
<tbody>
</tr>

</p>


 </tr>
 
<?php include 'SSDINEWExtra.php'; ?>



</table>
</tbody></table>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $('.duringCallBtns').hide();
    $('#xway').hide();
    $('#hanguptrans').hide();
     $('#hangupboth').hide();
     $('#hangupxfer').hide();


     $(".wbfromone").on("click",function(){

      $('.wbfromone').hide();
      $('.transferBtn').css('display', 'block');
      //   $('')
        var this_form_id = $(this).data('form');
        console.log(this_form_id);
        $('.transferBtn').html('Trasfer B'+this_form_id).attr('data-formid', this_form_id);


     });
     $('.transferBtn').click(function(){
        var this_formId = $(this).data('formid');

        var zenbaNum = '';

        if(this_formId == 1)
        {
            var zenbaNum = '1307937937';
        }
        else if(this_formId == 2)
        {
            var zenbaNum = '1307937938';

        }
        else if(this_formId == 3)
        {
            var zenbaNum = '1307937939';

        }

        if(zenbaNum == "")
        {
            alert('Zenba Not Found');
        }
        else
        {
            $.ajax({
                    url: "api.php?source=test&user=<?php echo $phoneuser; ?>&pass=<?php echo $phoneuser; ?>&agent_user=<?php echo $phoneuser; ?>&function=transfer_conference&value=DIAL_WITH_CUSTOMER&phone_number="+zenbaNum+"&cid_choice=CUSTOMER",
                    type: "POST",
                    data: {

                    },
                    success:function(data){
                        //success
                    }

                });
            $(this).css('display', 'none');
            $('.duringCallBtns').show();
        }
     });
     $('.duringCallBtns').click(function(){
        var api_link = '';
        var this_btn = $(this).data('btnname');
        console.log(this_btn);
        if(this_btn == 'xway')
        {
            var api_link = 'api.php?source=test&user=<?php echo $phoneuser; ?>&pass=<?php echo $phoneuser; ?>&agent_user=<?php echo $phoneuser; ?>&function=transfer_conference&value=LEAVE_3WAY_CALL';
        }
        else if(this_btn == 'hangupxfer')
        {
            var api_link = 'api.php?source=test&user=<?php echo $phoneuser; ?>&pass=<?php echo $phoneuser; ?>&agent_user=<?php echo $phoneuser; ?>&function=transfer_conference&value=HANGUP_XFER';
        }
        else if(this_btn == 'hangupboth')
        {
            var api_link = 'api.php?source=test&user=<?php echo $phoneuser; ?>&pass=<?php echo $phoneuser; ?>&agent_user=<?php echo $phoneuser; ?>&function=external_hangup&value=1';
        }

        if(api_link == '')
        {
            alert('Api Link Not Found');
        }
        else
        {
            console.log(api_link);
            $.ajax({
                url: api_link,
                type: "POST",
                data: {


                },


                success:function(data){

                //alert(data);
                }

            });
            $('.duringCallBtns').hide();
            $('.wbfromone').show();
        }
     })
     $("#wbfromfe").on("click",function(){

      $('#wbfromfe').hide();

     });

     $("#wbfromfe2").on("click",function(){

      $('#wbfromfe2').hide();

     });




//   $("#secbtnclick").on("click",function(){

//     var secprmt=$("#secfetchname").val();

//     if(secprmt!="")
//         {
//             var secprmtview=secprmt;

//             $("#plsfill").text("");

//         }else
//         {
//              $("#plsfill").text("please enter number...");
//             return false; 
//         }

//     $.ajax({
//             url: "fetch_prmtname.php",
//             type: "GET",
//             data: {

//                 secprmt:secprmtview,
//             },

//             beforeSend: function(){
//             // Show image container
//             $(".loader").show();
//             },

//             success:function(data){


//             var datasucess;
//             datasucess= JSON.parse(data);
//             console.log(datasucess);
//             var overallcountcount="";
//             var body="";
//             var bodyone="";
//             overallcountcount = datasucess.length ;
//                 if (datasucess.length === 0) {

//                     $("#emtysuccess").text("");
//                     $("#emtysuccess").text("TRANSFER TO ANY BUYER");

//                 }else{

//                 $.each( datasucess, function (index,user) {

//                     $("#success").text("");
//                     $("#success").text("TRANSFER ONLY  BUYER 2");

                
//                 });}


//             },

//             complete:function(data){
//             // Hide image container
//             $(".loader").hide();
//             }


//         });

    

//     });

  });
</script>
<style>
    .active-btn
    {
        background-color: #000;
    }
    .headingStyle
    {
            color: red;
            font-weight: bold;
    }
    </style>
</tbody></table>
<!-- <p style="padding-top:130px;">

Hello may I speak with Mr/Mrs_. <br /><br />
<span class="headingStyle">INTRO</span>: My name is _____ I am calling from Your Savings Advisor on a recorded line. How are you doing today? We want to let you know about a great pharmacy service available in your State for which you might be eligible for.<br /><br />
<span class="headingStyle">STATE</span>: So are you still at  ________? Is that right<br /><br />
<span class="headingStyle">PURPOSE</span>: We have a Pharmacy that provide prescription filling, refills, and convenient medication packaging options like blister packs. Shipped and delivered directly to your door step and in addition to that Our pharmacists conduct comprehensive medication reviews to optimize therapy, and as part of the medication review, They look for ways to help you save money on copays. <br /><br />
<span class="headingStyle">FULL NAME</span></span>: Your First name is ____& last name is___? Is that right<br /><br />
<span class="headingStyle">BIRTH YEAR</span>: Your DOB is _____? Is that right<br /><br />
<span class="headingStyle">MAINTENENCE</span>: Do you take more than 6 Maintenance Medication per day ? MUST BE YES<br /><br />
<span class="headingStyle">QUALIFY</span>: They Offer Medication Delivery, Medication Synchronization, Refill & Medication Reminders, Adherence Packaging, Convenience of not having to go to pharmacy. Does that sound interesting to you ? <span class="bg-warning">(Must be Yes)</span> <br /><br />
<span class="headingStyle">TRANSFER</span>: Please hold on while I transfer the call to our specialist who will help you get this set up. <br /><br />

<span class="headingStyle">WARM TRANSFER</span>: Hi this is AGENT NAME and I have an interested prospect

</p> -->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
<style>
    td{
        padding:8px;
    }
    tr{
        /* border-bottom:1px solid #000; */
    }
</style>
<table class="table table-striped table-hover pt-5" style="margin-top:135px;">
    <tbody>
        <tr>
            <th>Agent</th>
            <td> May I speak with [Customer’s Name]?</td>
        </tr>
        <tr>
            <th>Agent</th>
            <td> Hi, this is [Agent’s Name] from The National Disability. Based on the information you recently provided, you may qualify for Social Security disability benefits up to $2,600 per month.</td>
        </tr>
        <tr>
            <th>Agent</th>
            <td>Great good to speak with you, please note we are on a recorded line for quality and training benefits. (Not saying this on the recording is a FCC violation, which can lead to legal consequences)</td>
        </tr>
        <tr>
            <td colspan="2">I have some short questions to see if you may be eligible.</td>
        </tr>
   </tbody>
</table>
<h4>Qualifying Questions</h4>
<table class="table table-striped table-hover pt-5" style="padding-top:15px;">
    <tbody>
        <tr>
            <th>Agent</th>
            <td>Are you currently receiving Social Security, Social Security Disability or Supplemental Security Income? <span class="bg-warning">(Must be No)</span></td>
        </tr>
        <tr>
            <th>Agent</th>
            <td>Are you between the ages of 49 - 63? <span class="bg-warning">(Must be Yes)</span></td>
        </tr>
        <tr>
            <th>Agent</th>
            <td>Are you currently out of work due to a disability? <span class="bg-warning">(Must be Yes)</span></td>
        </tr>
        <tr>
            <th>Agent</th>
            <td>In the last 10 years, have you worked FULL-TIME at least 5 of those years? <span class="bg-warning">(Must be Yes)</span></td>
        </tr>
        <tr>
            <th>Agent</th>
            <td>Do you expect to be out of work for at least 12 months due to your disability? <span class="bg-warning">(Must be Yes)</span></td>
        </tr>
        <tr>
            <th>Agent</th>
            <td>Have you treated with a doctor, clinic or hospital within the last 12 months because of your disability? <span class="bg-warning">(Must be Yes)</span></td>
        </tr>
        <tr>
            <th>Agent</th>
            <td>Have you already filed a claim for disability? </td>
        </tr>
        <tr>
            <th>Agent</th>
            <td>Do you currently have a lawyer or advocate representing you with your social security claim?<span class="bg-warning">(Must be No)</span> </td>
        </tr>
        <tr>
            <th>Agent</th>
            <td>Are you US Citizen <span class="bg-warning">(Must be Yes)</span></td>
        </tr>        
    </tbody>
</table>
<h4>Initiate Transfer</h4>
<table class="table table-striped table-hover pt-5" style="padding-top:15px;">
    <tbody>
        <tr>
            <th>Agent</th>
            <td>Thank you for answering these questions! Please hold while we transfer you to a benefits specialist.</td>
        </tr>    
        <tr>
            <th>Agent</th>
            <td>Hi, this is [Agent’s Name]. I have [Customer’s Name] on the line. They are interested to know eligibility and to see about receiving benefits?</td>
        </tr>
        <tr>
            <td colspan='2'>Thank you, have a great day both of you.</td>
        </tr>   
    </tbody>
</table>  
</body></html>
<?php
?>