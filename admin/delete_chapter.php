<?php
	include("./includes/config.php");		
	include("./classes/cor.mysql.class.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
	$uId = $_GET["uId"];
	$r = $db->query("query","select unique_id from avn_chapter_master where category_id =".$uId);
	if($r["response"] != "ERROR" )
	{
		$URL = "./delete-chapter.php?cid=".$uId;
	}
	else
	{	
		$n = $db->query("query","delete from ltf_category_master where unique_id =".$uId);
		$URL = "./chapter.php?resp=sucdt";
	}
	$db->close();
	header('Location: ' . $URL);
?>