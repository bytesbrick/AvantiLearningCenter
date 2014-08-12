<?php
	session_start();
	$resp = "";
	if(isset($_POST["session"]) && $_POST["session"] != "" && isset($_POST["duration"]) && $_POST["duration"] != "")
	{
		include("../includes/config.php");		
		include("../classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();		
		$datatosave = array();
		$datatosave["other_name"] = $_POST['session'];
		$datatosave["duration"] = $_POST['duration'];
		$datatosave["entry_date"] = "NOW()";
		$r = $db->insert("avn_other_session_master",$datatosave);
		$resp = 1;
		unset($r);
		$db->close();
	}
	else
		$resp = 0;
	echo $resp . "|#|" . $_POST["page"];
	
?>