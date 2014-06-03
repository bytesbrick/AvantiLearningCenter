<?php
	$resp = "";
	if(isset($_GET["categoryid"]) && $_GET["categoryid"] != "")
	{
		$sID = $_GET["cid"];
		include_once("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$sql ="Select uniqueid,chapter_name from avn_chapter_master where category_id = ".$sID;
		if(!array_key_exists("response", $r)){
			if(!$r["response"] == "ERROR"){
				
			$resp = "";
				for($i=0; $i< count($r); $i++){
				if($resp == "")
					$resp = "<li>" . $arr["chapter_name"] . "</li>";
				else
					$resp .= "<li>" . $arr["chapter_name"] . "</li>";
				}
			}
		}
		else
			$resp = "Invalid chapter";
		mysql_free_result($rs);
		mysql_close($objCon);
	}
	else
		$resp = "Bad Parameter";
	echo $resp;
?>