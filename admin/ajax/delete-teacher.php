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
			$r = $db->delete("avn_teacher_master",$dataToWhere);
			if($r["response"] == "SUCCESS"){
				$dataToWherelogin = array();
				$dataToWherelogin['user_ref_id'] = $uId;
				$login = $db->delete("avn_login_master",$dataToWherelogin);
				
				if($login["response"] == "SUCCESS"){
					$dataToWhereadmin = array();
					$dataToWhereadmin["user_ref_id"] = $uId;
					$loginadmin = $db->delete("ltf_admin_usermaster",$dataToWhereadmin);
					if($loginadmin["response"] == "SUCCESS")
						$resp = 1;
					else
						$resp = 2;
					unset($loginadmin);
					unset($dataToWhereadmin);
				}
				unset($login);
				unset($dataToWherelogin);
			}
			unset($r);
			unset($dataToWhere);
		}
		else{
			$allUID = explode(",", $uId);
			for($i = 0; $i < count($allUID); $i++){
				if($allUID[$i] != ""){
					$dataToWhere = array();
					$dataToWhere['unique_id'] = $allUID[$i];
					$r = $db->delete("avn_teacher_master",$dataToWhere);
					if($r["response"] == "SUCCESS"){
						$dataToWherelogin = array();
						$dataToWherelogin['user_ref_id'] = $allUID[$i];
						$login = $db->delete("avn_login_master",$dataToWherelogin);
						
						if($login["response"] == "SUCCESS"){
							$dataToWhereadmin = array();
							$dataToWhereadmin["user_ref_id"] = $uId;
							$loginadmin = $db->delete("ltf_admin_usermaster",$dataToWhereadmin);
							if($loginadmin["response"] == "SUCCESS")
								$resp = 3;
							else
								$resp = 4;						
							unset($loginadmin);
							unset($dataToWhereadmin);
						}
						unset($dataToWherelogin);
						unset($login);
					}
					unset($r);
					unset($dataToWhere);
				}
			}
		}
		$db->close();
	}
	else
		$resp = 0;
	echo $resp . "|#|" . $page . "|#|" . $uId;
?>