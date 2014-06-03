<?php
	if(isset($_POST["btnContinue"]))
	{
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$cid = $_POST["hdgrade"];
		
		$r = $db->query("query","delete from ltf_resources_grade_level where grade_level_id = " . $cid);
		print_r($r);
		//$n = $db->query("query","delete from ltf_grade_level_master where unique_id =".$cid);
		//$URL = "./grade.php?resp=sucdt";
	}
	else
	{
		$URL = './grade.php?resp=errEd';
	}
	$db->close();
	//header('Location: ' . $URL);
?>