<?php
	$resp = "";
	
	if(isset($_POST["uniqueid"]) && $_POST["uniqueid"] != "")
	{
		include("../includes/config.php");		
		include("../classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$uId = $_POST["uniqueid"];
		$page = $_POST["page"];
		if(strpos($uId, ",") === false){
			$datatodelete = array();
			$datatomaster = array();
			$datatodelete['grade_level_id'] = $uId;
			$datatomaster['unique_id'] = $uId;
			
			$r = $db->delete("ltf_resources_grade_level",$datatodelete);
			if($r["response"] == "SUCCESS"){
				$n = $db->delete("ltf_grade_level_master",$datatomaster);
				if($n["response"] == "SUCCESS")
					$resp = 1;
				else
					$resp = 2;
				unset($n);
				unset($datatomaster);
			}else
				$resp = 3;
			unset($r);
			unset($datatodelete);
		}
		else{
			$allUID = explode(",", $uId);
			for($i = 0; $i < count($allUID); $i++){
				if($allUID[$i] != ""){
					$datatodelete = array();
					$datatomaster = array();
					$datatodelete['grade_level_id'] = $allUID[$i];
					$datatomaster['unique_id'] = $allUID[$i];
					
					$r = $db->delete("ltf_resources_grade_level",$datatodelete);
					if($r["response"] == "SUCCESS"){
						$n = $db->delete("ltf_grade_level_master",$datatomaster);
						if($n["response"] == "SUCCESS")
							$resp = 4;
						else
							$resp = 5;
						unset($n);
						unset($datatomaster);
					}else
						$resp = 6;
					unset($r);
					unset($datatodelete);
				}
			}
		}
		$db->close();
	}
	else
		$resp = 0;
		echo $resp . "|#|" . $page . "|#|" . $uId;
?>