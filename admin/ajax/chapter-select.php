<?php
	$resp = "";
	if(isset($_POST["unique_id"]) && $_POST["unique_id"] != "")
	{
		include_once("../includes/config.php");		
		include_once("../classes/cor.mysql.class.php");
	
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		
		$r =$db->query("query","SELECT unique_id,chapter_name,chapter_code FROM avn_chapter_master WHERE category_id = " . $_POST["unique_id"]);
		$chapterCode = $r[0]['chapter_code'];
		
		$topiccode = $db->query("query","Select MAX(tm.unique_id) as totaltopics FROM avn_topic_master tm INNER JOIN avn_chapter_master cm ON cm.unique_id = tm.chapter_id  WHERE cm.category_id = " . $_POST["unique_id"]);
		
		$newtopic = $topiccode[0]['totaltopics'] + 1;
		
		$newtopicCode = "$chapterCode.".$newtopic;
		
		$chp =$db->query("query","SELECT unique_id,chapter_name,chapter_code FROM avn_chapter_master WHERE category_id = " . $_POST["unique_id"]);
		
		if(!array_key_exists("response", $r)){
			if(!$chp["response"] == "ERROR"){
				
			$resp = "";
				$resp .= "<option value=0>Select Chapter</option>";
				for($i=0; $i< count($chp); $i++)
				{
					if($resp == "")
						$resp .= "<option value='".$chp[$i]["unique_id"]."'>" . $chp[$i]["chapter_name"] . "</option>";
					else
						$resp .= "<option value='".$chp[$i]["unique_id"]."'>" . $chp[$i]["chapter_name"] . "</option>";
				}
				//$resp .= "|#|" . $chapterCode ."|#|" . $newtopicCode ;
			}
		} 
		else
			$resp .= "<option value=>No Chapters</option>"."|#|" . "No Chapter code"."|#|" . "No Topic code";
			unset($r);
			$db->close();
	}
	else
		$resp = "Bad Parameter";
		echo $resp;
?>