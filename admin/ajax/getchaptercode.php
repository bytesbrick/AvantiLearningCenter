<?php
	$resp = "";
	if(isset($_POST["unique_id"]) && $_POST["unique_id"] != "")
	{
		include_once("../includes/config.php");		
		include_once("../classes/cor.mysql.class.php");
	
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$categoryid = $_POST["unique_id"];
		$r =$db->query("query","SELECT unique_id,prefix FROM ltf_category_master WHERE unique_id = " . $categoryid);
		$categoryprefix = $r[0]['prefix'];
		
		$chapter = $db->query("query","Select MAX(cm.unique_id) as totalchps FROM avn_chapter_master cm INNER JOIN ltf_category_master lcm ON lcm.unique_id = cm.category_id  WHERE lcm.unique_id = " . $categoryid);
		$newchp = $chapter[0]['totalchps'] + 1;
		$newtopicCode = "$categoryprefix".$newchp;
		
		if(!array_key_exists("response", $r)){
			if(!$chp["response"] == "ERROR"){
				$resp = $newtopicCode;
			}
		} 
		unset($r);
		$db->close();
	}
	else
		$resp = "Bad Parameter";
		echo $resp;
?>