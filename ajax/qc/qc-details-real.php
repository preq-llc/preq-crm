<?php
// echo 'test';
include '../../function/DB/pdo-db-59.php';
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
    $escapeTest = "AND agent_last_name != 'LOCAL'";
    $selectQuery = "*";
    
    if ($slctcampvalue != "") 
    {
        if ($slctcampvalue == "EDU_TEST") 
        {
            $escapeTest = "AND agent_last_name = 'LOCAL'"; 
            $selectQuery = "*, agent_first_name AS agent_username";
        } 
        else 
        {
            $campaign_query = "AND camp = '$slctcampvalue'";
        }
    }
    
    $callCenter_query = '';
    if($call_center != '')
    {
        $callCenter_query = " AND agent_username LIKE '%$call_center%' ";
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
        // echo $escapeTest;
        $sth = $conn->prepare("SELECT $selectQuery FROM `QC_Reports` WHERE `QC_dispo`!='' AND `timestamp`>='$fromdatevalue 00:00:00' AND `timestamp`<='$todatevalue 23:59:59' $phone_number_query $campaign_query $callCenter_query $qcDispo_query $escapeTest");
    }
    else
    {
        $getresponse = [];
        $campaigns = ['EDU_SB', 'EDU_SB1'];

        foreach($campaigns as $camp)
        {
        
            $sth = $conn->prepare("SELECT * FROM `QC_Reports` WHERE `QC_dispo`!='' AND `timestamp`>='$fromdatevalue 00:00:00' AND `timestamp`<='$todatevalue 23:59:59' AND camp='$camp' AND agent_last_name != 'LOCAL' $phone_number_query $callCenter_query $qcDispo_query");
            
            $sth->execute();
            $getresult = $sth->fetchAll(PDO::FETCH_ASSOC);
            $getresponse = array_merge($getresponse, $getresult);
        }
        
    }

    $result['status'] = "Ok";
}
else if($action == 'scorecard')
{
    $fromdatevalue=$_GET['fromdatevalue'];
    $todatevalue=$_GET['todatevalue'];
    $slctcampvalue=$_GET['slctcampvalue'];
    $call_center=$_GET['call_center'];

    $campaign_query = '';
    $escapeTest = "AND agent_last_name != 'LOCAL'";
    $groupByQuery = "GROUP by agent_username";
    $selectQuery = "agent_username, camp";

    if($slctcampvalue != "")
    {
        if($slctcampvalue == "EDU_TEST")
        {
            $escapeTest = "AND agent_last_name = 'LOCAL'";
            $groupByQuery = "GROUP by agent_first_name";
            $selectQuery = "agent_first_name AS agent_username, 'EDU_TEST' as camp";
        }
        else
        {
            $campaign_query = " AND camp='$slctcampvalue'";
        }
    }

    $callCenter_query = '';
    if($call_center != '')
    {
        $callCenter_query = " AND agent_username LIKE '%$call_center%' ";
    }




    if($slctcampvalue != 'FTE_ALL')
    {
        $sth = $conn->prepare("SELECT count(id) as total_call,$selectQuery,sum(case when QC_Reports.QC_dispo = 'QC' then 1 else 0 end) AS QC,count(QC_dispo) as score_card FROM `QC_Reports` WHERE `timestamp`>='$fromdatevalue 00:00:00' AND `timestamp`<='$todatevalue 23:59:59' $campaign_query $callCenter_query $escapeTest $groupByQuery order by camp ASC");
    }
    else
    {
        $getresponse = [];
        $campaigns = ['EDU_SB', 'EDU_SB1'];

        foreach($campaigns as $camp)
        {
            $sth = $conn->prepare("SELECT camp,count(id) as total_call,agent_username,sum(case when QC_Reports.QC_dispo = 'QC' then 1 else 0 end) AS QC,count(QC_dispo) as score_card FROM `QC_Reports` WHERE `timestamp`>='$fromdatevalue 00:00:00' AND `timestamp`<='$todatevalue 23:59:59' AND camp='$camp' AND agent_last_name != 'LOCAL' $callCenter_query GROUP by agent_username order by camp ASC");
            
            $sth->execute();
            $getresult = $sth->fetchAll(PDO::FETCH_ASSOC);
            $getresponse = array_merge($getresponse, $getresult);
        }
    }

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
else if($action == 'getcampqcdetails')
{
    $fromdatevalue=$_GET['fromdatevalue'];
    $todatevalue=$_GET['todatevalue'];

    $sth = $conn->prepare("SELECT camp,count(QC_dispo) as score_card,sum(case when QC_Reports.QC_dispo = 'QC' then 1 else 0 end) AS QC,count(id) as total_calls FROM `QC_Reports` WHERE `timestamp`>='$fromdatevalue 00:00:00' AND `timestamp`<='$todatevalue 23:59:59' group by camp");

	$sth2 = $conn->prepare("SELECT QC_Audited,count(QC_dispo) as score_card,sum(case when QC_Reports.QC_dispo = 'QC' then 1 else 0 end) AS QC, audio_link_url FROM `QC_Reports` WHERE `timestamp`>='$fromdatevalue 00:00:00' AND `timestamp`<='$todatevalue 23:59:59' AND QC_Audited!='' group by `QC_Audited`");

    $sth2->execute();
    $data2 = $sth2->fetchAll(PDO::FETCH_ASSOC);
    $result['agent'] = $data2;
    $result['status'] = 'Ok';
}
else if($action == 'getQccommentsCount')
{
	// $sth2 = $conn->prepare("SELECT * FROM `QC_Reports` WHERE `timestamp`>='2024-07-17 00:00:00' AND `timestamp`<='2024-07-17 23:59:59' AND QC_Audited!='' group by `QC_Audited`");
    // $sth2->execute();
    // $data2 = $sth2->fetchAll(PDO::FETCH_ASSOC);
    // $result['agent'] = $data2;
    // $result['status'] = 'Ok';
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