<?php
	$curPage = $_GET["page"];
	if(($curPage == "") || ($curPage == 0))
	$curPage=1;
	$recPerpage = 25;
	$countWhereClause = "";
	$selectWhereClause = "";
	$pagerotate="";

	$r = $db->query("query","select * from ltf_resources_master");
	$totalRecords = count($r);
	$recArr = $r;
	$recCount = $recArr[0];
	mysql_free_result($totalRecords);
	$noOfpage = ceil($recCount/$recPerpage);
	$limitStart = ($curPage - 1) * $recPerpage;
	$limitEnd = $recPerpage;
?>