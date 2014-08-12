<?php
	session_start();
	$resp = "";
	if(isset($_POST["session"]) && $_POST["session"] != "")
	{
		include("../includes/config.php");		
		include("../classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();	
		$datatosave = array();
		$datatosave["other_name"] = $_POST['session'];
		$datatowhere = array();
		$datatowhere["unique_id"] = $_POST['uniqueid'];
		$datatosave["duration"] = strtoupper($_POST['duration']);
		$datatosave["entry_date"] = "NOW()";
		$r = $db->update("avn_other_session_master",$datatosave , $datatowhere);
		$resp = 1;
		unset($r);
		$db->close();
	}	
	else
		$resp = 0;
	echo $resp . "|#|" . $_POST["page"];
?>