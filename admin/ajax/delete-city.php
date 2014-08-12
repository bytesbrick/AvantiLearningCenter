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
			$selchp = $db->query("query","SELECT unique_id FROM avn_learning_centers WHERE category_id = " . $uId);
			if(!array_key_exists("response",$selchp)){
				$resp = 3;
				unset($selchp);
			}
			else{
				$where = array();
				$where["unique_id"] = $uId;
				$delcat = $db->delete("avn_city_master",$where);
				
				if($delcat["response"] == "SUCCESS")
					$resp = 1;
				else
					$resp = 2;
				unset($where);
			}
			
		} else {
			$allUID = explode(",", $uId);
			for($i = 0; $i < count($allUID); $i++){
				if($allUID[$i] != ""){
					$selchp = $db->query("query","SELECT unique_id FROM avn_learning_centers WHERE category_id = " . $uId);
					if(!array_key_exists("response",$selchp)){
						$resp = 5;
						unset($selchp);
					}
					else{
						$where = array();
						$where["unique_id"] = $allUID[$i];
						$delcat = $db->delete("avn_city_master",$where);
						
						if($delcat["response"] == "SUCCESS")
							$resp = 4;
						else
							$resp = 5;
						unset($where);
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