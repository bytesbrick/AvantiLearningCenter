<?php
	$resp = "";
	if(isset($_POST["unique_id"]) && $_POST["unique_id"] != "")
	
	{
		include_once("../includes/config.php");		
		include_once("../classes/cor.mysql.class.php");
	
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$r =$db->query("query","Select unique_id,topic_name from avn_topic_master where chapter_id = " . $_POST["unique_id"]);
		
		if(!array_key_exists("response", $r)){
			if(!$r["response"] == "ERROR"){
				
			$resp = "";
				for($i=0; $i< count($r); $i++)
				{
					if($resp == "")
						$resp = "<option value='".$r[$i]["unique_id"]."'>" . $r[$i]["topic_name"] . "</option>";
					else
						$resp .= "<option value='".$r[$i]["unique_id"]."'>" . $r[$i]["topic_name"] . "</option>";
				}
				$resp .= "|#|" . $_POST["unique_id"];
			}
		} 
		else
			//$resp = "Invalid Topic";
			$resp .= "<option value=>No Topics</option>";
			unset($r);
			$db->close();
	}
	else
		$resp = "Bad Parameter";
	echo $resp;
?>