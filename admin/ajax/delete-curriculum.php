<?php
	$resp = "";
	if(isset($_POST["uniqueid"]) && $_POST["uniqueid"] !=""){
		
		include("../includes/config.php");		
		include("../classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		
		$uId = $_POST["uniqueid"];
		$page = $_POST["page"];
		if(strpos($uId, ",") === false){
			$wheretodelete  = array();
			$rescur = array();
			$wheretodelete["unique_id"] = $uId;
			$rescur['curriculum_id'] = $uId;
			
			$rescurriculum = $db->delete("avn_resources_curriculum",$rescur);
			if($rescurriculum["response"] == "SUCCESS"){
				$st = $db->delete("avn_curriculum_master",$wheretodelete);
				if($st["response"] == "SUCCESS"){
					$resp = 1;
				}else{
					$resp = 2;
					unset($st);
					unset($wheretodelete);
				}
			}else
				$resp = 3;
				unset($rescurriculum);
				unset($rescur);
		}
		else{
			$allUID = explode(",", $uId);
			for($i = 0; $i < count($allUID); $i++){
				if($allUID[$i] != ""){
					$wheretodelete  = array();
					$rescur = array();
					$wheretodelete["unique_id"] = $allUID[$i];
					$rescur['curriculum_id'] = $allUID[$i];
					
					$rescurriculum = $db->delete("avn_resources_curriculum",$rescur);
					if($rescurriculum["response"] == "SUCCESS"){
						$st = $db->delete("avn_curriculum_master",$wheretodelete);
						if($st["response"] == "SUCCESS")
							$resp = 3;
						else
							$resp = 4;
						unset($st);
						unset($wheretodelete);
						unset($rescurriculum);
					}else
						$resp = 6;
						unset($rescurriculum);
						unset($rescur);
				}
			}
		}
		$db->close();
	}
	else
		$resp = 0;
	echo $resp . "|#|" . $page;
?>