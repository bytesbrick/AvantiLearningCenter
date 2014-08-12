<?php
	$resp="";
	if(isset($_POST["uniqueid"]) && $_POST["uniqueid"] != ""){
		include("../includes/config.php");		
		include("../classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$uId = $_POST["uniqueid"];
		$page = $_POST["page"];
			if(strpos($uId, ",") === false){
				$where = array();
				$where["unique_id"] = $uId;
				$delcat = $db->delete("avn_other_session_master",$where);
				print_r($delcat);
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
						$delcat = $db->delete("avn_other_session_master",$where);
						unset($where);
						if($delcat["response"] == "SUCCESS")
							$resp = 4;
						else
							$resp = 5;
					}					
				}
			}
		$db->close();
	}
	else
		$resp = 0;
		echo $resp . "|#|" . $page;
?>