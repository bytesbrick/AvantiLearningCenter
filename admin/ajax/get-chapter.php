<?php
	$resp = "";
	if(isset($_POST["unique_id"]) && $_POST["unique_id"] != "")
	{
		include_once("../includes/config.php");		
		include_once("../classes/cor.mysql.class.php");
	
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$r =$db->query("query","Select unique_id,chapter_name,chapter_code from avn_chapter_master where unique_id = " . $_POST["unique_id"]);
		
		$chapterCode = $r[0]['chapter_code'];
		
		$topiccode = $db->query("query","Select MAX(tm.unique_id) as totaltopics from avn_topic_master tm INNER JOIN avn_chapter_master cm on cm.unique_id = tm.chapter_id  where tm.chapter_id = " . $_POST["unique_id"]);
		
		$newtopic = $topiccode[0]['totaltopics'] + 1;
	
		$newtopicCode = "$chapterCode.".$newtopic;
	
		if(!array_key_exists("response", $r)){
			if(!$r["response"] == "ERROR"){
				
			$resp = "";
				
				//if($resp == "")
				//	$resp = "<input type='text' name='txttopiccode' id='txttopiccode' class='textbox fl'  maxlength='10' value ='C" .$_POST["chapter_id"] . "." . $newtopiccode . "' />";
				//else
				//	$resp .= "<input type='text' name='txttopiccode' id='txttopiccode' class='textbox fl'  maxlength='10' value ='C" .$_POST["chapter_id"] . "." . $newtopiccode . "' />";
				
				$resp .= "|#|" . $chapterCode ."|#|" . $newtopicCode ;
			}
		} 
		else
			$resp = "Invalid chapter";
			unset($r);
			$db->close();
	}
	else
		$resp = "Bad Parameter";
	echo $resp;
?>