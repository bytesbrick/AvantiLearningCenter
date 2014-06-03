<?php
	include("./includes/config.php");		
	include("./classes/cor.mysql.class.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
	$uId = $_GET["uId"];
	$wheretodelete  = array();
	$wheretodelete["unique_id"] = $uId;
	
	$wheretores = array();
	$wheretores["topic_id"]= $uId;
	
	//$res = $db->query("query","select topic_id from ltf_resources_master where topic_id=".$uId);
	//print_r($res);
	$st = $db->delete("avn_topic_master",$wheretodelete);
	//print_r($st);
	if($st["response"] !== "ERROR" )
	{
		$URL = "./topic.php?resp=sucdt";
	}
	else{
		$URL = "./delete-topic.php?cid=".$uId;
	}
	
	$db->close();
	header('Location: ' . $URL);
?>