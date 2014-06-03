<?php
	$resp = "";
	if(isset($_POST['type']) && $_POST['type'] != ""){
		include("../includes/config.php");		
		include("../classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		
		$uid = $_POST["uniqueid"];
		$resid = $_POST['resid'];
		$catgid = $_POST['catgid'];
		$chptid = $_POST['chptid'];
		$resid = $_POST['resid'];
		$topicid = $_POST['topicid'];
		$testtype = $_POST['type'];
		$page = $_POST["page"];
		$currid = $_POST["currid"];
		$newpr = "";
		$selpr = $db->query("query","SELECT priority FROM avn_question_master WHERE unique_id = " . $uid . " AND type = " . $testtype);
		
		$chngpr = $db->query("query","SELECT unique_id,priority FROM avn_question_master WHERE priority > " . $selpr[0]['priority'] . " AND resource_id = " . $resid . " AND type = " . $testtype . "  order by priority ASC");
	
		if($chngpr["response"] !== "ERROR"){
			for($i = 0; $i <count($chngpr); $i++){
				$newpr =  $chngpr[$i]['priority'] - 1;
				$insernewpr = $db->query("query","UPDATE avn_question_master set priority = " . $newpr . " WHERE unique_id = " . $chngpr[$i]['unique_id'] . " AND resource_id = " . $resid . " AND type = " . $testtype);
			}
		}
		if(strpos($uid, ",") === false){
			$whereDel  = array();
			$whereDel["test_id"] = $uid;
			$st = $db->delete("user_test_answer",$whereDel);
			if($st["response"] == "SUCCESS"){
				$whereqes  = array();
				$whereqes["unique_id"] = $uid;
				$qm = $db->delete("avn_question_master",$whereqes);
				if($qm["response"] == "SUCCESS")
					$resp = 1;
				else
					$resp = 2;
				unset($qm);
				unset($whereDel);
				unset($whereqes);
			}
		}
		else{
			$newpr = "";
			$allUID = explode(",", $uid);
			for($i = 0; $i < count($allUID); $i++){
				if($allUID[$i] != ""){
					//$selpr = $db->query("query","SELECT priority FROM avn_question_master WHERE unique_id = " . $allUID[$i] . " AND type = " . $testtype);
					$chngpr = $db->query("query","SELECT unique_id,priority FROM avn_question_master WHERE unique_id > " . $allUID[$i] . " AND resource_id = " . $resid . " AND type = " . $testtype . "  order by priority ASC");
					$whereDel  = array();
					$whereDel["test_id"] = $allUID[$i];
					$st = $db->delete("user_test_answer",$whereDel);
					if($st["response"] == "SUCCESS"){
						$whereqes  = array();
						$whereqes["unique_id"] = $allUID[$i];
						
						for($r = 0;$r < count($chngpr); $r++){
							$dataToWhere =array();
							$dataToWhere['unique_id'] = $chngpr[$r]['unique_id'];
							$arrToUpdate = array();
							$arrToUpdate['priority'] = intval($chngpr[$r]['priority']) - 1;
							$insernewpr = $db->update("avn_question_master", $arrToUpdate, $dataToWhere);
							unset($dataToWhere);
							unset($arrToUpdate);
						}
						unset($chngpr);
						$qm = $db->delete("avn_question_master",$whereqes);
						if($qm["response"] == "SUCCESS")
							$resp = 3;
						else
							$resp = 4;
						unset($qm);
						unset($whereDel);
						unset($whereqes);
					}
					else{
						$whereqes  = array();
						$whereqes["unique_id"] = $allUID[$i];
						$qm = $db->delete("avn_question_master",$whereqes);
						if($qm["response"] == "SUCCESS")
							$resp = 3;
						else
							$resp = 5;
						unset($qm);
						unset($whereDel);
						unset($whereqes);
					}
				}
			}
		}
		$db->close();
	}
	else 
		$resp = 0;
	echo $resp. "|#|" . $currid . "|#|" . $topicid . "|#|" . $resid . "|#|" . $catgid . "|#|" . $chptid . "|#|" .$page;
?>