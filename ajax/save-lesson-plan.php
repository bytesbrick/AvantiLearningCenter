<?php
	$resp="0";
	if(isset($_POST["uniqueid"]) && $_POST["uniqueid"] != ""){
		include("../includes/config.php");		
		include("../classes/cor.mysql.class.php");
		include_once("../includes/checklogin.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$uId = $_POST["uniqueid"];
		$userid = $arrUserInfo["userid"];
		$value = $_POST["value"];
		$batchid = $arrUserInfo["batch_id"];
		if(strpos($uId, ",") === false){
			if($_POST["value"] == 0){
				$seltopic = "SELECT topic_id FROM avn_user_topic_mapping WHERE topic_id = " . $uId;
				$seltopicRS = $db->query("query", $seltopic);
				if(!array_key_exists("response", $seltopicRS)){
					$topictodelte = array();
					$topictodelte["topic_id"] = $uId;
					$deltopic = $db->delete("avn_user_topic_mapping",$topictodelte);
					if($deltopic["response"] == "SUCCESS")
						$resp = 1;
					else
						$resp = 2;
					unset($deltopic);
					unset($seltopicRS);
				}
			}
			if($_POST["value"] == 1){
				$datatoSave = array();
				$datatoSave["topic_id"] = $uId;
				$datatoSave["userid"] = $userid;
				$datatoSave["entry_date"] = "now()";
				$intopic = $db->insert("avn_user_topic_mapping",$datatoSave);
				if($intopic["response"] == "SUCCESS")
					$resp = 1;
				else
					$resp = 2;
				unset($intopic);
				unset($datatoSave);
			}
		} else {
				$allUID = explode(",", $uId);
				for($i = 0; $i < count($allUID); $i++){
					if($_POST["value"] == 0){
						$seltopic = "SELECT topic_id FROM avn_user_topic_mapping WHERE topic_id = " .  $allUID[$i];
						$seltopicRS = $db->query("query", $seltopic);
						if(!array_key_exists("response", $seltopicRS)){
							$topictodelte = array();
							$topictodelte["topic_id"] =  $allUID[$i];
							$deltopic = $db->delete("avn_user_topic_mapping",$topictodelte);
							if($deltopic["response"] == "SUCCESS")
								$resp = 3;
							else
								$resp = 4;
							unset($deltopic);
							unset($seltopicRS);
						}
					}
					if($_POST["value"] == 1){
						$datatoSave = array();
						$datatoSave["topic_id"] =  $allUID[$i];
						$datatoSave["userid"] = $userid;
						$datatoSave["entry_date"] = "now()";
						$intopic = $db->insert("avn_user_topic_mapping",$datatoSave);
						if($intopic["response"] == "SUCCESS")
							$resp = 3;
						else
							$resp = 4;
						unset($intopic);
						unset($datatoSave);
					}
				}
			}
		$db->close();
	}
	else
		$resp = 0;
	echo $resp . "|#|" . $value;
?>