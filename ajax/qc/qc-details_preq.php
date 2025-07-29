<?php
// echo 'test';

// include '../../function/DB/pdo-db-59.php';
include '../../function/DB/pdo-db-42.php';
include $path.'function/session.php';
$action=$_GET['action'];
$data = [];
$slctcampvalue = 'NONE';
if($action == 'getqcdetails')
{
    $fromdatevalue=$_GET['fromdatevalue'];
    $todatevalue=$_GET['todatevalue'];
    $slctcampvalue=$_GET['slctcampvalue'];
    $call_center=$_GET['call_center'];
    $phone_number=$_GET['phone_number'];
    $qcDispo=$_GET['qcDispo'];
    
    $campaign_query = '';

    if($slctcampvalue != "")
    {
        $campaign_query = " AND campid='$slctcampvalue'";
    }

    $callCenter_query = '';
    if($call_center != '')
    {
        $callCenter_query = " AND agent_first_name LIKE '%$call_center%' ";
    }

    $qcDispo_query = '';
    if($qcDispo != '')
    {
        $qcDispo_query = " AND QC_dispo LIKE '%$qcDispo%' ";
    }

    $phone_number_query = '';
    if($phone_number != '')
    {
        $phone_number_query = " AND phone_number LIKE '%$phone_number%' ";
    }

    if($slctcampvalue != 'FTE_ALL')
    {

      
        $sth = $conn->prepare("SELECT * FROM `IVE_QC_Reports` WHERE `QC_dispo`!='' AND `timestamp`>='$fromdatevalue 00:00:00' AND `timestamp`<='$todatevalue 23:59:59'");
    }
    // else
    // {
    //     $getresponse = [];
    //     $campaigns = ['SSDI', 'Auto'];

    //     foreach($campaigns as $camp)
    //     {
        
    //         echo $sth = $conn->prepare("SELECT * FROM `IVE_QC_Reports` WHERE `QC_dispo`!='' AND `timestamp`>='$fromdatevalue 00:00:00' AND `timestamp`<='$todatevalue 23:59:59' AND camp='$camp' $phone_number_query $callCenter_query $qcDispo_query");
            
    //         $sth->execute();
    //         $getresult = $sth->fetchAll(PDO::FETCH_ASSOC);
    //         $getresponse = array_merge($getresponse, $getresult);
    //     }
        
    // }

    $result['status'] = "Ok";
}
else if($action == 'scorecard')
{
    $fromdatevalue=$_GET['fromdatevalue'];
    $todatevalue=$_GET['todatevalue'];
    $slctcampvalue=$_GET['slctcampvalue'];
    $call_center=$_GET['call_center'];

    $campaign_query = '';
    
    if($slctcampvalue != "")
    {
        $campaign_query = " AND campid='$slctcampvalue'";
    }

    $callCenter_query = '';
    if($call_center != '')
    {
        $callCenter_query = " AND agent_first_name LIKE '%$call_center%' ";
    }

    if($slctcampvalue != 'FTE_ALL')
    {
        $sth = $conn->prepare("SELECT campid,count(id) as total_call,agent_first_name,sum(case when IVE_QC_Reports.QC_dispo = 'QC' then 1 else 0 end) AS QC,count(QC_dispo) as score_card FROM `IVE_QC_Reports` WHERE `timestamp`>='$fromdatevalue 00:00:00' AND `timestamp`<='$todatevalue 23:59:59' $campaign_query $callCenter_query  GROUP by agent_first_name order by camp ASC");
    }
    // else
    // {
    //     $getresponse = [];
    //     $campaigns = ['SSDI', 'Auto'];

    //     foreach($campaigns as $camp)
    //     {
    //         $sth = $conn->prepare("SELECT camp,count(id) as total_call,agent_username,sum(case when IVE_QC_Reports.QC_dispo = 'QC' then 1 else 0 end) AS QC,count(QC_dispo) as score_card FROM `IVE_QC_Reports` WHERE `timestamp`>='$fromdatevalue 00:00:00' AND `timestamp`<='$todatevalue 23:59:59' AND camp='$camp' $callCenter_query  GROUP by agent_username order by camp ASC");
            
    //         $sth->execute();
    //         $getresult = $sth->fetchAll(PDO::FETCH_ASSOC);
    //         $getresponse = array_merge($getresponse, $getresult);
    //     }
    // }

    $result['status'] = "Ok";

}
else if($action == 'getqcDispoDetails')
{
    $commands=$_GET['QcComments'];
    // echo $QcComments;
    // $commands=$_GET['commands'];

	if($commands!='')
	{
		$commandsviews=$commands;
	}
	else
	{
		$commandsviews='0';
	}


	$sth = $conn->prepare("SELECT * FROM `QC_DNQ` WHERE `id` IN ($commandsviews)");
    $result['status'] = 'Ok';
}
if($slctcampvalue == 'FTE_ALL')
{

    $result['data'] = $getresponse;

}
else
{
    $sth->execute();
    $data = $sth->fetchAll(PDO::FETCH_ASSOC);
    $result['data'] = $data;
}

echo json_encode($result);
?>