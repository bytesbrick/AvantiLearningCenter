<?php
	$resp ="";
	if(isset($_POST["uniqueid"]) && $_POST["uniqueid"]){
		
		include("../includes/config.php");		
		include("../classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$uid = $_POST["uniqueid"];
		$catgid = $_POST["catgid"];
		$page = $_POST["page"];
		$currid = $_POST["currid"];
		$seltopic = $db->query("query","SELECT unique_id FROM avn_topic_master WHERE chapter_id = " . $uid);
		
		if(!array_key_exists("response",$seltopic)){
			if(!$seltopic["response"] == "ERROR"){
				$resp = 3;
				unset($seltopic);
			}
		}
		else{
			if(strpos($uid, ",") === false){
				$where = array();
				$where["unique_id"] = $uid;
				$delchp = $db->delete("avn_chapter_master",$where);
				if($delchp["response"] == "SUCCESS")
					$resp = 1;
				else
					$resp = 2;
					unset($delchp);
					unset($where);
					
			} else {
				$allUID = explode(",", $uid);
				for($i = 0; $i < count($allUID); $i++){
					if($allUID[$i] != ""){
						$where = array();
						$where["unique_id"] = $allUID[$i];
						$delchp = $db->delete("avn_chapter_master",$where);
						if($delchp["response"] == "SUCCESS")
							$resp = 4;
						else
							$resp = 5;
						unset($delchp);
						unset($where);
					}					
				}
			}
		}
		$db->close();
	}
	else
		$resp = 0;
		echo $resp . "|#|" . $currid . "|#|" . $catgid . "|#|" . $page;
?>