$(document).ready(function(){


	$("#btnsubmit").on("click",function(){
        var refreshCount = $('#refreshCount span').html();
        refreshCount++;
		 fromdate=$("#fromdate").val();
		 todate=$("#todate").val();
		 campaign=$("#slctcamp").val();

		 if(fromdate!='' && todate!='' && campaign!='')
		 {
		 	fromdate=fromdate;
		 	todate=todate;
		 	campaign=campaign;

		 	getvaluezeanba(fromdate,todate,campaign);
		 }
         $('#refreshCount span').html(refreshCount);
	});
            setInterval(function(){
                $('#btnsubmit').trigger('click');
            }, 1000);
	});


	function getvaluezeanba(fromdate,todate,campaign)
	{
		$.ajax({
url: "DB/zenba_repo.php",
type: "GET",
data: {

	fromdate:fromdate,
	todate:todate,
	campaign:campaign,


},

success:function(data){

var datasucess;
datasucess= JSON.parse(data);
console.log(datasucess);
var overallcountcount="";
var overallcountcount1="";
var body="";
var body1="";

overallcountcount = datasucess.length ;

$.each( datasucess, function (index,user) {

	phonenum="";

	phonenum=user.extension;

	
  $.ajax({
url: "DB/threefetchviewnew.php",
type: "GET",
data: {

    fromdate:fromdate,
	todate:todate,
	campaign:campaign,
	phonenum:phonenum,



},

success:function(data){

var datasucess1;
datasucess1= JSON.parse(data);
console.log(datasucess1);
overallcountcount1 = datasucess.length ;

$.each( datasucess1, function (index,usernew) {

  userview="";
  leadidnew="";
  campaignnew="";
  datenew="";

  userview=usernew.user;
  leadidnew=usernew.lead_id;
  campaignnew=usernew.campaign_id;
  datenew=usernew.call_date.slice(0,10);


    body1+= ' <tr">'+
'<td>'+usernew.campaign_id+'</td>'+
'<td>'+usernew.user+'</td>'+
'<td>'+usernew.callerid+'</td>'+
'<td>'+usernew.call_date+'</td>'+
'<td>'+usernew.lead_id+'</td>'+
'</tr>'


 	$.ajax({
                    type: "POST",
                    url: "DB/updateview.php",
                    data: {
                        userview:userview,
                        leadidnew:leadidnew,
                        campaignnew:campaignnew,
                        datenew:datenew,
                        
                    },
                    cache: false,
                    success: function(data) {
                       	
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr);
                    }
                });



});

$("#dispoalldata").html("");
$("#dispoalldata").html(body1);
$("#totaltransfer").text("");
$("#totaltransfer").text(overallcountcount1);


},

});

});

},

});
	}

