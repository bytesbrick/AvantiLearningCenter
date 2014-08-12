<?php
	$resp = "";
	if(isset($_POST["unique_id"]) && $_POST["unique_id"] != "")
	{
		include_once("../includes/config.php");		
		include_once("../classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
			$r =$db->query("query","SELECT unique_id,chapter_name FROM avn_chapter_master WHERE category_id=" . $_POST["unique_id"]);
			if(!array_key_exists("response", $r)){
				if(!$r["response"] == "ERROR"){
				$resp = "";
					$resp .= "<option value='0'>Select Chapter</option>";
					for($i=0; $i< count($r); $i++)
					{
						if($resp == "")
							$resp .= "<option value='".$r[$i]["unique_id"]."'>" . $r[$i]["chapter_name"] . "</option>";
						else
							$resp .= "<option value='".$r[$i]["unique_id"]."'>" . $r[$i]["chapter_name"] . "</option>";
					}
				}
		 
			}
			else
			$resp .= "<option>No chapter</option>";
		unset($r);
		$db->close();
	}
	else
		$resp = "Bad Parameter";
	echo $resp . "|#|" . $_POST["unique_id"];
?>