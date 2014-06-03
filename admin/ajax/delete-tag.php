<?php	
	$resp = "";
	if(isset($_POST["uniqueid"]) && $_POST["uniqueid"] != ""){
		include("../includes/config.php");		
		include("../classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$uId = $_POST["uniqueid"];
		$page = $_POST["page"];
		if(strpos($uId, ",") === false){
			$restag = array();
			$tagdlt = array();
			$restag['tags_id'] = $uId;
			$tagdlt['unique_id'] = $uId;
			
			$dltrestag = $db->delete("ltf_resources_tags",$restag);
			if($dltrestag["response"] == "SUCCESS"){
				$dlttag = $db->delete("ltf_tags_master",$tagdlt);
					if($dlttag["response"] == "SUCCESS")
						$resp = 1;
					else
						$resp = 2;
					unset($dlttag);
					unset($tagdlt);
			}
			else
				$resp = 3;
			unset($dltrestag);
			unset($restag);
		}
		else{
			$allUID = explode(",", $uId);
			for($i = 0; $i < count($allUID); $i++){
				if($allUID[$i] != ""){
					$restag = array();
					$tagdlt = array();
					$restag['tags_id'] = $allUID[$i];
					$tagdlt['unique_id'] = $allUID[$i];
					
					$dltrestag = $db->delete("ltf_resources_tags",$restag);
					if($dltrestag["response"] == "SUCCESS"){
						$dlttag = $db->delete("ltf_tags_master",$tagdlt);
							if($dlttag["response"] == "SUCCESS")
								$resp = 4;
							else
								$resp = 5;
							unset($dlttag);
							unset($tagdlt);
					}
					else
						$resp = 6;
					unset($dltrestag);
					unset($restag);
				}
			}
		}
		$db->close();
	}
	else
		$resp = 0;
		echo $resp. " |#| " . $page;
?>