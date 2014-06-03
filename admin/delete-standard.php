<?php
	include("./includes/config.php");		
	include("./classes/cor.mysql.class.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
	$uId = $_GET["uId"];
	$r = $db->query("query","select standards_id from ltf_resources_standards where standards_id =".$uId);
	if($r["response"] != "ERROR" )
	{
		$URL = "./standard-delete.php?cid=".$uId;
	}
	else
	{	
		$n = $db->query("query","delete from ltf_standards_master where unique_id =".$uId);
		$URL = "./standard.php?resp=sucdt";
	}
	$db->close();
	header('Location: ' . $URL);
?>