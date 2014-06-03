<?php
	$resp = "";
	$html = "";
	$tid = "";
	if(isset($_POST["search"]) && $_POST["search"] != ""){
		include_once("../includes/config.php");
		include_once("../classes/cor.mysql.class.php");

		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$r = $db->query("stored procedure", "sp_admin_search_tag('".trim($_POST["search"])."')");
		//print_r($r);
		if(!array_key_exists("response", $r)){
			$resp = 1;
			for($i=0;$i<count($r);$i++){
				if($html == ""){
					$html = $r[$i]["tag_name"];
				}else
					$html .= "##".$r[$i]["tag_name"];
			} 
		}
		unset($r);
		$db->close();
	}
	echo $resp . "#/#" . $html;
?>