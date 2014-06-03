<?php
	$resp="";
	if(isset($_POST["uniqueid"]) && $_POST["uniqueid"] != ""){
		include("../includes/config.php");		
		include("../classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$uId = $_POST["uniqueid"];
		$page = $_POST["page"];
		$selchp = $db->query("query","SELECT unique_id FROM avn_chapter_master WHERE category_id = " . $uId);
		if(!array_key_exists("response",$selchp)){
			$resp = 3;
		}
		else{
			if(strpos($uId, ",") === false){
				$where = array();
				$where["unique_id"] = $uId;
				$delcat = $db->delete("ltf_category_master",$where);
				unset($where);
				if($delcat["response"] == "SUCCESS")
					$resp = 1;
				else
					$resp = 2;
			} else {
				$allUID = explode(",", $uId);
				for($i = 0; $i < count($allUID); $i++){
					if($allUID[$i] != ""){
						$where = array();
						$where["unique_id"] = $allUID[$i];
						$delcat = $db->delete("ltf_category_master",$where);
						unset($where);
						if($delcat["response"] == "SUCCESS")
							$resp = 4;
						else
							$resp = 5;
					}					
				}
			}
		}
		$db->close();
	}
	else
		$resp = 0;
		echo $resp . "|#|" . $_POST["currid"] . "|#|" . $page;
?>