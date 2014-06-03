<?php
	include("./includes/config.php");		
	include("./classes/cor.mysql.class.php");
	
	$catgID = 0;
	if(isset($_GET["uId"]) && $_GET["uId"] != "")
	$catgID = intval($_GET["uId"]);
	if($catgID != 0){
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$sql = "DELETE FROM avn_resources_detail WHERE topic_id IN (SELECT DISTINCT unique_id FROM avn_topic_master WHERE chapter_id IN (SELECT DISTINCT unique_id FROM avn_chapter_master WHERE category_id  = " . $catgID ."))";
		$rs = $db->query("query", $sql);
		print_r($rs);
		//if(!$st["response"] == "ERROR" )
		//{
		//	$URL = "./category.php?resp=sucdt";
		//}
		//else{
		//	$URL = "./subject-delete.php?cid=".$uId;
		//}
		$db->close();
		//header('Location: ' . $URL);
	}
?>