<?php
	$resp = "";
	if(isset($_POST["chapter_code"]) && $_POST["chapter_code"] != "")
	
	{
		include_once("../includes/config.php");		
		include_once("../classes/cor.mysql.class.php");
	
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		
		$r =$db->query("query","Select COUNT(unique_id) as tm.totaltopics from avn_topic_master tm INNER JOIN avn_chapter_master cm on cm.unique_id = tm.chapter_id  where chapter_id = " . $_POST["chapter_id"]);
		
		$newtopiccode = $r[0]['totaltopics'] + 1;
		
		if(!array_key_exists("response", $r)){
			if(!$r["response"] == "ERROR"){
				
			$resp = "";
				for($i=0; $i< count($r); $i++)
				{
					if($resp == "")
						$resp = "<input type='text' name='txttopiccode' id='txttopiccode' class='textbox fl'  maxlength='10' value ='C" .$_POST["chapter_id"] . "." . $newtopiccode . "' />";
					else
						$resp .= "<input type='text' name='txttopiccode' id='txttopiccode' class='textbox fl'  maxlength='10' value ='C" .$_POST["chapter_id"] . "." . $newtopiccode . "' />";
				}
				$resp .= "|#|" . $newtopiccode;
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