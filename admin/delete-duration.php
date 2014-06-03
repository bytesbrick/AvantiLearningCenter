<?php
	include("./includes/config.php");		
	include("./classes/cor.mysql.class.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
	$uId = $_GET["uId"];
	$r = $db->query("query","select duration_id from ltf_resources_duration where duration_id =".$uId);
	if($r["response"] != "ERROR" )
	{
		$URL = "./duration-delete.php?cid=".$uId;
	}
	else
	{	
		$n = $db->query("query","delete from ltf_duration_master where unique_id =".$uId);
		$URL = "./duration.php?resp=sucdt";
	}
	$db->close();
	header('Location: ' . $URL);
?>