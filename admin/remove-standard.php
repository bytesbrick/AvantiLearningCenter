<?php
	if(isset($_POST["btnContinue"]))
	{
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$cid = $_POST["hdCatID"];
		$r = $db->query("query","delete from ltf_resources_standards where standards_id =".$cid);
		$n = $db->query("query","delete from ltf_standards_master where unique_id =".$cid);
		$URL = "./standard.php?resp=sucdt";
	}
	else
	{
		$URL = './standard.php?resp=errEd';
	}
	$db->close();
	header('Location: ' . $URL);
?>