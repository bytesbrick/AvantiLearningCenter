<?php
	$resp = "";
	if(isset($_POST["uniqueid"]) && $_POST["uniqueid"] != ""){
		include("../includes/config.php");		
		include("../classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$uId = $_POST["uniqueid"];
		$catgid = $_POST["catgid"];
		$chptid = $_POST["chptid"];
		$page = $_POST["page"];
		$currid = $_POST["currid"];
		
		$wheretodelete  = array();
		$wheretodelete["unique_id"] = $uId;
		$selpr = $db->query("query","SELECT topic_priority FROM avn_topic_master WHERE unique_id = " . $uId);
		$priority = $selpr[0]["topic_priority"];
		$topic = $db->query("query","SELECT unique_id from ltf_resources_master where topic_id = " . $uId);
		$resid = $topic[0]['unique_id'];
		$wheretores = array();
		$wheretores["unique_id"]= $resid;		
		$wheretomap = array();
		$wheretomap["topic_id"]= $uId  ;
		$getres = $db->query("query","SELECT * FROM avn_resources_detail WHERE resource_id = " . $resid . " AND topic_id = " . $uId);
		if(!array_key_exists("response",$getres)){
			if(!$getres["response"] == "ERROR"){
				$resp = 2;
				unset($getres);
				unset($wheretores);
				unset($wheretomap);
				unset($topic);
			}
		}
		else{
			if(strpos($uId, ",") === false){
				$chngpr = $db->query("query","SELECT unique_id,topic_priority FROM avn_topic_master WHERE topic_priority > " . $priority . "  order by topic_priority ASC");
				if($chngpr["response"] != "ERROR"){
					for($i = 0; $i <count($chngpr); $i++){
						$dataToWhere =array();
						$dataToWhere['unique_id'] = $chngpr[$i]['unique_id'];
						$arrToUpdate = array();
						$arrToUpdate['topic_priority'] = intval($chngpr[$i]['topic_priority']) - 1;
						$insernewpr = $db->update("avn_topic_master", $arrToUpdate, $dataToWhere);
						unset($dataToWhere);
						unset($arrToUpdate);
					}
				}
				
					$resgrade = $db->delete("avn_topic_grades", $wheretomap);
					if($resgrade["response"] == "SUCCESS"){
						$restag = $db->delete("avn_topic_tags", $wheretomap);
						if($restag["response"] == "SUCCESS"){
							$t = $db->delete("avn_topic_master", $wheretodelete);
							if($t["response"] == "SUCCESS")
								$resp = 1;
							else
								$resp = 3;
							unset($t);
						}else
							$resp = 5;
						unset($restag);
					}else
						$resp = 6;
					unset($resgrade);
				
			}
			else{
				$allUID = explode(",", $uId);
				for($i = 0; $i < count($allUID); $i++){
					if($allUID[$i] != ""){
						$selpr = $db->query("query","SELECT topic_priority FROM avn_topic_master WHERE unique_id = " . $allUID[$i]);
						$priority = $selpr[$i]["topic_priority"];
						$chngpr = $db->query("query","SELECT unique_id,topic_priority FROM avn_topic_master WHERE topic_priority > " . $priority . "  order by topic_priority ASC");
						if($chngpr["response"] != "ERROR"){
							for($i = 0; $i <count($chngpr); $i++){
								$dataToWhere =array();
								$dataToWhere['unique_id'] = $chngpr[$i]['unique_id'];
								$dataToWhere['unique_id'] = $allUID[$i];
								$arrToUpdate = array();
								$arrToUpdate['topic_priority'] = intval($chngpr[$i]['topic_priority']) - 1;
								$insernewpr = $db->update("avn_topic_master", $arrToUpdate, $dataToWhere);
								unset($dataToWhere);
								unset($arrToUpdate);
							}
						} 
						$wheretodelete  = array();
						$wheretodelete["unique_id"] = $uId;
						$topic = $db->query("query","SELECT unique_id from ltf_resources_master where topic_id = " . $allUID[$i]);
						$resid = $topic[0]['unique_id'];
						$wheretores = array();
						$wheretores["unique_id"]= $resid;		
						$wheretomap = array();
						$wheretomap["topic_id"]= $uId;
						
						$getres = $db->query("query","SELECT * FROM avn_resources_detail WHERE resource_id = " . $resid . " AND topic_id = " . $allUID[$i]);
						if(!array_key_exists("response",$getres)){
							if(!$getres["response"] == "ERROR"){
								$resp = 8;
							}
							else
								$resp = 9;
							unset($getres);
						}
						else{
							$resgrade = $db->delete("avn_topic_grades", $wheretomap);
							if($resgrade["response"] == "SUCCESS"){
								$restag = $db->delete("avn_topic_tags", $wheretomap);
								if($restag["response"] == "SUCCESS"){
									$t = $db->delete("avn_topic_master", $wheretodelete);
									if($t["response"] == "SUCCESS")
										$resp = 10;
									else
										$resp = 3;
									unset($t);
								}else
									$resp = 5;
								unset($restag);
							}else
								$resp = 6;
							unset($resgrade);
						}
					}
				}
			}
		}
		$db->close();
	}
	else
		$resp = 0;
	echo $resp . "|#|" . $currid . "|#|" . $chptid . "|#|" . $catgid . "|#|" . $page;
?>