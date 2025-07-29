<?php
	
  include 'db70.php';

	$fromdate=$_GET['fromdate'];
	$todate=$_GET['todate'];
	$campaign=$_GET['campaign'];


	if($campaign=='EDU_SBJ')
			{


	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE ( user='307937713' OR user='307937790') AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='240' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}

	if($campaign=='EDU_VET')
			{


	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE ( user='307937714' OR user='307937791') AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='240' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}

	if($campaign=='EDU_PEC')
			{


	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE ( user='307937715' OR user='307937792') AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='60' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}

		if($campaign=='TSE')
			{


	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE ( user='307937710' OR user='307937736') AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='120' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}

		if($campaign=='SSDI_2')
			{


	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE ( user='307937709' OR user='307937733' OR user='307937763' OR user='307937786' OR user='307937797') AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='120' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}



	if($campaign=='HOME_WAR')
			{


	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE ( user='307937716' OR user='307937762' OR user='307937793') AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='90' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}

	if($campaign=='EDU_AMP')
			{

	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE ( user='307937711' OR user='307937712' OR user='307937785') AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='120' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}

	if($campaign=='FE_PLC')
			{


	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE user='307937718' AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='120' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}

	if($campaign=='AUI_DMSI')
			{


	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE user='307937721' AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='120' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}

	if($campaign=='MED_SUPP')
			{


	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE ( user='307937719' OR user='307937794') AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='120' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}

	if($campaign=='SOLAR')
			{


	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE ( user='307937726' OR user='307937727') AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='120' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}

	if($campaign=='SSDI_1')
			{


	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE ( user='307937728' OR user='307937796') AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='90' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}

	if($campaign=='SSDI_5')
			{


	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE ( user='307937720' OR user='307937732' OR user='307937758' OR user='307937759' OR user='307937764' OR user='307937788' OR user='307937800') AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='120' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}

	if($campaign=='FTE_BR')
			{


	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE user='307937730' AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='120' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}

	if($campaign=='FTE_ACA')
			{


	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE (user='307937722' OR user='307937724' OR user='307937789') AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='90' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}

	if($campaign=='SSDI_4')
			{


	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE ( user='307937735' OR user='307937765' OR user='307937784' OR user='307937799') AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='120' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}
	if($campaign=='MED_V2')
			{


	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE user='307937738' AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='120' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}
	if($campaign=='MED_V5')
			{


	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE user='307937739' AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='120' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}

	if($campaign=='TUBS')
			{


	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE user='307937740' AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='120' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}

	if($campaign=='SSDI_3')
			{


	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE ( user='307937737' OR user='307937798') AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='120' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}

	if($campaign=='MED_V3')
			{


	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE user='307937742' AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='120' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}

	if($campaign=='MED_V16')
			{


	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE ( user='307937741' OR user='307937795') AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='120' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}

	if($campaign=='FE_MR_V8')
			{


	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE user='307937743' AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='120' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}

	if($campaign=='SSDI_IB')
			{


	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE ( user='307937767' OR user='307937752' OR user='307937770' OR user='307937771' OR user='307937772' OR user='307937773' OR user='307937777' OR user='307937787' OR user='307937801' OR user='307937805' OR user='307937806' OR user='307937807' OR user='3079378058' OR user='307937809' OR user='307937810' OR user='307937811') AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='120' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}


	if($campaign=='AUI_PLC')
			{


	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE user='307937782' AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='120' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}


		if($campaign=='MED_RE')
			{


	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE ( user='307937814' OR user='307937826' OR user='307937840' ) AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='120' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}


	if($campaign=='EDUPECSB')
			{


	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE user='307937837'  AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='60' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}


	if($campaign=='MEDRE_SB')
			{


	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE user='307937849'  AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='120' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}

	if($campaign=='EDULive')
			{


	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE user='307937858'  AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='60' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}

	if($campaign=='EDU_SB')
			{


	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE user='307937859'  AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='60' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}

	if($campaign=='SSDINEW')
			{


	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE (user='307937866' OR user='307937867' OR user='307937868')  AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='60' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}

	if($campaign=='OPTHA_A')
	{


	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE user='307937870' AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='80' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}
	
	if($campaign=='OPTHA_B')
	{


	$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE user='307937871' AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='80' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}
	
	if($campaign=='EDU_SB1')
	{
		$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE user='307937872'  AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='60' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}
	if($campaign=='SGSSD2')
	{
		$sth = $conn->prepare("SELECT extension,start_time,length_in_sec,filename,user,	location FROM `recording_log` WHERE user='307937873'  AND `start_time`>='$fromdate 00:00:00' AND `start_time`<='$todate 23:59:59' AND `length_in_sec`>='120' group by extension  ORDER BY `recording_log`.`start_time` DESC ");

	}

$sth->execute();
$result = $sth->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($result);

?>