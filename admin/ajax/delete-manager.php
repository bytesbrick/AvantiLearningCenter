<?php
	$resp="";
	if(isset($_POST["uId"]) && $_POST["uId"] != ""){
		include("../includes/config.php");		
		include("../classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$uId = $_POST["uId"];
		$page = $_POST["page"];
		
		if(strpos($uId, ",") === false){
			$dataToWhere = array();
			$dataToWhere['unique_id'] = $uId;
			$r = $db->delete("avn_centermanager_master",$dataToWhere);
			unset($dataToWhere);
			unset($r);
			
			$dataToWhere = array();
			$dataToWhere['user_ref_id'] = $uId;
			$r = $db->delete("avn_login_master",$dataToWhere);
			if($r["response"] == "SUCCESS"){
				$admin = $db->delete("ltf_admin_usermaster",$dataToWhere);
				if($admin["response"] == "SUCCESS")
					$resp = 1;
				else
					$resp = 2;
			}
			unset($admin);
			unset($dataToWhere);
			unset($r);
		}
		else{
			$allUID = explode(",", $uId);
			for($i = 0; $i < count($allUID); $i++){
				if($allUID[$i] != ""){
					$dataToWhere = array();
					$dataToWhere['unique_id'] = $allUID[$i];
					$r = $db->delete("avn_centermanager_master",$dataToWhere);
					unset($dataToWhere);
					unset($r);
					
					$dataToWhere = array();
					$dataToWhere['user_ref_id'] = $allUID[$i];
					$r = $db->delete("avn_login_master",$dataToWhere);
					unset($dataToWhere);
					unset($r);
					if($r["response"] == "SUCCESS"){
						$admin = $db->delete("ltf_admin_usermaster",$dataToWhere);
						if($admin["response"] == "SUCCESS")
							$resp = 3;
						else
							$resp = 4;
					}
					unset($admin);
					unset($dataToWhere);
					unset($r);
				}
			}
		}
		$db->close();
	}
	else
		$resp = 0;
		echo $resp . "|#|" . $page;
?>