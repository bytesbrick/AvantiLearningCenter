<?php
	include_once("../includes/config.php");
	include_once("../classes/cor.mysql.class.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
	
	$resp = "";
	$html = "";
	
	if(isset($_POST["search"]) && $_POST["search"] != ""){
		
		$r = $db->query("stored procedure", "sp_avn_search_text('".strtolower($_POST["search"])."')");
		if(!array_key_exists("response", $r)){
			$resp = 1;
			for($i=0;$i<count($r);$i++){
				if($html == ""){
					$html = substr(strtolower($r[$i]["Title"]),0,25);
				}else
					$html .= "##".substr(strtolower($r[$i]["Title"]),0,25);
			} 
		}
		unset($r);
		
	}
	if(isset($_POST["searchTopic"]) && $_POST["searchTopic"] != ""){
		
		$r = $db->query("stored procedure", "sp_avn_search_text_topic('".strtolower($_POST["searchTopic"])."')");
	
		if(!array_key_exists("response", $r)){
			$resp = 1;
			for($i=0;$i<count($r);$i++){
				if($html == ""){
					$html = substr(strtolower($r[$i]["Title"]),0,25);
				}else
					$html .= "##".substr(strtolower($r[$i]["Title"]),0,25);
			} 
		}
		unset($r);
		
	}
	$db->close();
	echo $resp . "#/#" . $html;
?>