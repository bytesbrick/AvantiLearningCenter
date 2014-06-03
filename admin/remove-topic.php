<?php
	if(isset($_POST["btnContinue"]))
	{
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$cid = $_POST["hdCatID"];
		$r = $db->query("query","delete from ltf_resources_topic where topic_id =".$cid);
		$n = $db->query("query","delete from ltf_topic_master where unique_id =".$cid);
		$URL = "./topic.php?resp=sucdt";
//		print_r($n);
	}
	else
	{
		$URL = './topic.php?resp=errEd';
	}
	$db->close();
	header('Location: ' . $URL);
?>