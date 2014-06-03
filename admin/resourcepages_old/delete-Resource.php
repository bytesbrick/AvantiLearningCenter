<?php
	include("./includes/config.php");		
	include("./classes/cor.mysql.class.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
	$uId = $_GET["uId"];
	$dataToWhere =array();
	$dataToWhere['resource_id']= $uId;
	
	$datatoResid = array();
	$datatoResid['unique_id']=$uId;
	$datatovideo = array();
	$datatovideo['video_id']=$uId;
	
	$qt = $db->delete("avn_question_master",$datatovideo);
	$vt = $db->delete("avn_video_master",$datatovideo);
	$sb = $db->delete("ltf_resources_tags",$dataToWhere);
	$t = $db->delete("ltf_resources_topic",$dataToWhere);
	$g = $db->delete("ltf_resources_grade_level",$dataToWhere);
	$cur = $db->delete("ltf_resources_grade_level",$dataToWhere);
	$r = $db->delete("avn_resources_curriculum",$dataToWhere);
	$res = $db->delete("ltf_resources_master",$datatoResid);
	
	if($st["response"] !== "ERROR" )
	{
		$URL = "./resourse.php?resp=sucdt";
	}
	else{
		$URL = "./resourse.php?resp=Erdt";
	}
	
	$db->close();
	header('Location: ' . $URL);
?>