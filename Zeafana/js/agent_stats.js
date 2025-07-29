$(document).ready(function(){



$("#btn_clk").on("click",function(){

 var search=$("#search_value").val();
 var call_center=$("#call_center").val();

 if(search!='' && call_center=='')
 {
 	searchvalue=search;
 	overall(searchvalue);
 }
 else if(search!='' && call_center!='')
 {
    searchvalues=search;
    call_centervalues=call_center;

    overall_fetch_value(searchvalues,call_centervalues);

 }

});


 setInterval(function(){
        $('#btn_clk').trigger('click');
    }, 3000);


});

function overall(searchvalue)
{

	 $.ajax({
url: "sofana_db/statsfetch.php?action=campaign",
type: "GET",
data: {

	searchvalue:searchvalue

},

success:function(data){
var datasucess;
datasucess= JSON.parse(data);
console.log(datasucess);
var overallcountcount="";
var body="";
overallcountcount = datasucess.length ;
var totalhours=0;
var succtransfer=0;
var transfe=0;
var totalcalsre=0;
var totalcalsre_cl=0;
var totalhours_cl=0;
var succtransfer_cl=0;
var transfe_cl=0;
var totalcalsre_win=0;
var totalhours_win=0;
var succtransfer_win=0;
var transfe_win=0;
var totalcalsre_exi=0;
var totalhours_exi=0;
var succtransfer_exi=0;
var transfe_exi=0;
var totalcalsre_vez=0;
var totalhours_vez=0;
var succtransfer_vez=0;
var transfe_vez=0;
var contactss="";


$.each( datasucess, function (index,user) {

	totalcalsre=parseFloat(totalcalsre)+parseFloat(user.Totalcalls);
	totalhours=parseFloat(totalhours)+parseFloat(user.Hrs/3600);
succtransfer = parseInt(succtransfer)+parseInt(user.successtransfer);
transfe = parseInt(transfe)+parseInt(user.Transfer);
contactss=parseInt(user.contact);

if(user.users=='B2C')
{
     totalcalsre_cl=parseFloat(totalcalsre_cl)+parseFloat(user.Totalcalls);
       totalhours_cl=parseFloat(totalhours_cl)+parseFloat(user.Hrs/3600);
succtransfer_cl = parseInt(succtransfer_cl)+parseInt(user.successtransfer);
transfe_cl = parseInt(transfe_cl)+parseInt(user.Transfer);  
}
if(user.users=='WIN')
{
     totalcalsre_win=parseFloat(totalcalsre_win)+parseFloat(user.Totalcalls);
       totalhours_win=parseFloat(totalhours_win)+parseFloat(user.Hrs/3600);
succtransfer_win = parseInt(succtransfer_win)+parseInt(user.successtransfer);
transfe_win = parseInt(transfe_win)+parseInt(user.Transfer);  
}

if(user.users=='EXI')
{
     totalcalsre_exi=parseFloat(totalcalsre_exi)+parseFloat(user.Totalcalls);
       totalhours_exi=parseFloat(totalhours_exi)+parseFloat(user.Hrs/3600);
succtransfer_exi = parseInt(succtransfer_exi)+parseInt(user.successtransfer);
transfe_exi = parseInt(transfe_exi)+parseInt(user.Transfer);  
}

if(user.users=='VEZ')
{
     totalcalsre_vez=parseFloat(totalcalsre_vez)+parseFloat(user.Totalcalls);
       totalhours_vez=parseFloat(totalhours_vez)+parseFloat(user.Hrs/3600);
succtransfer_vez = parseInt(succtransfer_vez)+parseInt(user.successtransfer);
transfe_vez = parseInt(transfe_vez)+parseInt(user.Transfer);  
}

	
});

$(".billable").text("");
$(".billable").text(transfe);
$(".submit_view").text("");
$(".submit_view").text(succtransfer);
$(".hoursob").text("");
$(".hoursob").text(parseFloat(totalhours).toFixed(2));
$(".callsview").text("");
$(".callsview").text(totalcalsre);
$(".tphview").text("");
$(".tphview").text(parseFloat(transfe/totalhours).toFixed(2));
$(".sphview").text("");
$(".sphview").text(parseFloat(succtransfer/totalhours).toFixed(2));
$(".spcview").text("");
$(".spcview").text(parseFloat(transfe/totalcalsre).toFixed(4));
$(".tpcview").text("");
$(".tpcview").text(parseFloat(succtransfer/totalcalsre).toFixed(4));
$(".b_cl_center").text();
$(".b_cl_center").text(succtransfer_cl);
$(".b_tph_center").text();
$(".b_tph_center").text(parseFloat(succtransfer_cl/totalhours_cl).toFixed(2));
$(".win_cl_center").text();
$(".win_cl_center").text(succtransfer_win);
$(".win_tph_center").text();
$(".win_tph_center").text(parseFloat(succtransfer_win/totalhours_win).toFixed(2));
$(".exi_cl_center").text();
$(".exi_cl_center").text(succtransfer_exi);
$(".exi_tph_center").text();
$(".exi_tph_center").text(parseFloat(succtransfer_exi/totalhours_exi).toFixed(2));
$(".vez_cl_center").text();
$(".vez_cl_center").text(succtransfer_vez);
$(".vez_tph_center").text();
$(".vez_tph_center").text(parseFloat(succtransfer_vez/totalhours_vez).toFixed(2));
$(".b_sale_center").text();
$(".b_sale_center").text(transfe_cl);
$(".b_sale_tph_center").text();
$(".b_sale_tph_center").text(parseFloat(transfe_cl/totalhours_cl).toFixed(2));
$(".win_sale_center").text();
$(".win_sale_center").text(transfe_win);
$(".win_sale_tph_center").text();
$(".win_sale_tph_center").text(parseFloat(transfe_win/totalhours_win).toFixed(2));
$(".exi_sale_center").text();
$(".exi_sale_center").text(transfe_exi);
$(".exi_sale_tph_center").text();
$(".exi_sale_tph_center").text(parseFloat(transfe_exi/totalhours_exi).toFixed(2));
$(".vez_sale_center").text();
$(".vez_sale_center").text(transfe_vez);
$(".vez_sale_tph_center").text();
$(".vez_sale_tph_center").text(parseFloat(transfe_vez/totalhours_vez).toFixed(2));





},
});
}

function overall_fetch_value(searchvalues,call_centervalues)
{
     $.ajax({
url: "sofana_db/statsfetch.php?action=call_center",
type: "GET",
data: {

    searchvalues:searchvalues,
    call_centervalues:call_centervalues

},

success:function(data){

var overallcountcount="";
var body="";
var totalhours=0;
var succtransfer=0;
var transfe=0;
var totalcalsre=0;
var totalcalsre_cl=0;
var totalhours_cl=0;
var succtransfer_cl=0;
var transfe_cl=0;
var totalcalsre_win=0;
var totalhours_win=0;
var succtransfer_win=0;
var transfe_win=0;
var totalcalsre_exi=0;
var totalhours_exi=0;
var succtransfer_exi=0;
var transfe_exi=0;
var totalcalsre_vez=0;
var totalhours_vez=0;
var succtransfer_vez=0;
var transfe_vez=0;
var contactss=0;

$.each(data, function(ip, values) {
$.each(values, function (index,user) {

    totalcalsre=parseFloat(totalcalsre)+parseFloat(user.Totalcalls);
    totalhours=parseFloat(totalhours)+parseFloat(user.Hrs/3600);
succtransfer = parseInt(succtransfer)+parseInt(user.successtransfer);
transfe = parseInt(transfe)+parseInt(user.Transfer);
contactss=parseInt(contactss)+parseInt(user.contact);



    
});
});

$(".billable").text("");
$(".billable").text(transfe);
$(".submit_view").text("");
$(".submit_view").text(succtransfer);
$(".hoursob").text("");
$(".hoursob").text(parseFloat(totalhours).toFixed(2));
$(".callsview").text("");
$(".callsview").text(totalcalsre);
$(".tphview").text("");
$(".tphview").text(parseFloat(transfe/totalhours).toFixed(2));
$(".sphview").text("");
$(".sphview").text(parseFloat(succtransfer/totalhours).toFixed(2));
$(".spcview").text("");
$(".spcview").text(parseFloat(transfe/totalcalsre).toFixed(4));
$(".tpcview").text("");
$(".tpcview").text(parseFloat(succtransfer/totalcalsre).toFixed(4));
$(".b_cl_center").text();
$(".b_cl_center").text(succtransfer_cl);
$(".b_tph_center").text();
$(".b_tph_center").text(parseFloat(succtransfer_cl/totalhours_cl).toFixed(2));
$(".win_cl_center").text();
$(".win_cl_center").text(succtransfer_win);
$(".win_tph_center").text();
$(".win_tph_center").text(parseFloat(succtransfer_win/totalhours_win).toFixed(2));
$(".exi_cl_center").text();
$(".exi_cl_center").text(succtransfer_exi);
$(".exi_tph_center").text();
$(".exi_tph_center").text(parseFloat(succtransfer_exi/totalhours_exi).toFixed(2));
$(".vez_cl_center").text();
$(".vez_cl_center").text(succtransfer_vez);
$(".vez_tph_center").text();
$(".vez_tph_center").text(parseFloat(succtransfer_vez/totalhours_vez).toFixed(2));
$(".b_sale_center").text();
$(".b_sale_center").text(transfe_cl);
$(".b_sale_tph_center").text();
$(".b_sale_tph_center").text(parseFloat(transfe_cl/totalhours_cl).toFixed(2));
$(".win_sale_center").text();
$(".win_sale_center").text(transfe_win);
$(".win_sale_tph_center").text();
$(".win_sale_tph_center").text(parseFloat(transfe_win/totalhours_win).toFixed(2));
$(".exi_sale_center").text();
$(".exi_sale_center").text(transfe_exi);
$(".exi_sale_tph_center").text();
$(".exi_sale_tph_center").text(parseFloat(transfe_exi/totalhours_exi).toFixed(2));
$(".vez_sale_center").text();
$(".vez_sale_center").text(transfe_vez);
$(".vez_sale_tph_center").text();
$(".vez_sale_tph_center").text(parseFloat(transfe_vez/totalhours_vez).toFixed(2));


overall_fetch_values_new(searchvalues,totalhours,totalcalsre,contactss);

},
});
}

function overall_fetch_values_new(searchvalues,totalhours,totalcalsre,contactss)
{

    $.ajax({
url: "sofana_db/statsfetch.php?action=dph_contact",
type: "GET",
data: {

    searchvalues:searchvalues
   

},


success:function(data){

var overallcountcount="";
var body="";
var total_calls=0;
var wait_average="";
var drop_calls=0;
var userstatus=0;
var ansmac=0;

$.each(data, function(ip, values) {
$.each( values, function (index,user) {

total_calls=parseInt(total_calls)+parseInt(user.calls_today);
ansmac=parseInt(ansmac)+parseInt(user.ansmac_view);
drop_calls=parseInt(drop_calls)+parseInt(user.view_drops);


// total_calls=user.calls_today


});
});

overall_contact=parseFloat((contactss/total_calls)*100)+parseFloat(10);

$(".dph_value").text("");
$(".dph_value").text(parseFloat(total_calls/totalhours).toFixed(2));
$(".abandon_value").text("");
$(".abandon_value").text(parseFloat((drop_calls/contactss)*100).toFixed(2)+"%");
$(".contact_value").text("");
$(".contact_value").text(parseFloat(overall_contact).toFixed(2)+"%");


// alert(overall_contact);

},

});
}