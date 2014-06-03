<?php
	if(isset($_POST["btnContinue"]))
	{
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$cid = $_POST["hdCatID"];
		$r = $db->query("query","delete from ltf_resources_duration where duration_id =".$cid);
		$n = $db->query("query","delete from ltf_duration_master where unique_id =".$cid);
		$URL = "./duration.php?resp=sucdt";
	}
	else
	{
		$URL = './duration.php?resp=errEd';
	}
	$db->close();
	header('Location: ' . $URL);
?>