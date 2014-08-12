<?php
	$resp = "";
	if(isset($_POST["uniqueid"]) && $_POST["uniqueid"] !=""){
		
		include("../includes/config.php");		
		include("../classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		
		$uId = $_POST["uniqueid"];
		$page = $_POST["page"];
		$rid = $_POST["rid"];
		if(strpos($uId, ",") === false){
			$wheretodelete  = array();
			$wheretodelete["unique_id"] = $uId;
			
			$rescurriculum = $db->query("query","SELECT unique_id FROM ltf_category_master WHERE curriculum_id = " . $uId);
			if(!array_key_exists("response", $rescurriculum))
				$resp = 5;
			else{
				$st = $db->delete("avn_curriculum_master",$wheretodelete);
				if($st["response"] == "SUCCESS"){
					$resp = 1;
				}else{
					$resp = 2;
					unset($st);
					unset($wheretodelete);
				}
				unset($rescurriculum);
				unset($rescur);
			}
		}
		else{
			$allUID = explode(",", $uId);
			for($i = 0; $i < count($allUID); $i++){
				if($allUID[$i] != ""){
					$wheretodelete  = array();
					$wheretodelete["unique_id"] = $allUID[$i];
					
					$rescurriculum = $db->query("query","SELECT unique_id FROM ltf_category_master WHERE curriculum_id = " . $allUID[$i]);
					if(!array_key_exists("response", $rescurriculum))
						$resp = 6;
					else{
						$st = $db->delete("avn_curriculum_master",$wheretodelete);
						if($st["response"] == "SUCCESS")
							$resp = 3;
						else
							$resp = 4;
						unset($st);
						unset($wheretodelete);
						unset($rescurriculum);
					}
				}
			}
		}
		$db->close();
	}
	else
		$resp = 0;
	echo $resp . "|#|" . $page . "|#|" . $uId;
?>