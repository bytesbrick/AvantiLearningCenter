<?php
	$resp = "";
	if(isset($_POST["uniqueid"]) && $_POST["uniqueid"] != ""){
		
		include_once("../includes/config.php");		
		include_once("../classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		
		$uId = $_POST["uniqueid"];
		$topic = $_POST['topic_id'];
		$resid = $_POST["res_id"];
		$catgid = $_POST['catg_id'];
		$chptid = $_POST["chap_id"];
		$page = $_POST["page"];
		$currid = $_POST["currid"];
		if(strpos($uId, ",") === false){
			$dataToWhere =array();
			$dataToWhere['unique_id']= $uId;
			$newpr = "";
			$selpr = $db->query("query","SELECT topic_id,content_type,priority FROM avn_resources_detail WHERE unique_id = " . $uId);
			$resid = $selpr[0]["topic_id"];
			$content = $selpr[0]["content_type"];
			$priority = $selpr[0]["priority"];
			$type = "";
			if(isset($content) && $content == "spot"){
				$type = 1;
			}
			if(isset($content) && $content == "concept"){ 
				$type = 2;
			}
			$dltQ = $db->query("query","SELECT * FROM avn_question_master WHERE topic_id = " . $topic . " AND type = " . $type);
			if(!array_key_exists("response",$dltQ)){
				$resp = 1;
				unset($dltQ);
			}else{
				$chngpr = $db->query("query","SELECT unique_id,resource_id,content_type,priority FROM avn_resources_detail WHERE priority > " . $priority . " AND topic_id = " . $topic . "  order by priority ASC");
				if($chngpr["response"] != "ERROR"){
					for($i = 0; $i <count($chngpr); $i++){
						$dataToWhere =array();
						$dataToWhere['unique_id'] = $chngpr[$i]['unique_id'];
						$dataToWhere['topic_id'] = $topic;
						$arrToUpdate = array();
						$arrToUpdate['priority'] = intval($chngpr[$i]['priority']) - 1;
						$insernewpr = $db->update("avn_resources_detail", $arrToUpdate, $dataToWhere);
						unset($dataToWhere);
						unset($arrToUpdate);
					}
				}
				$dataToWhere =array();
				$dataToWhere['unique_id'] = $uId;
				$res = $db->delete("avn_resources_detail",$dataToWhere);
				unset($dataToWhere);
				if($res["response"] == "SUCCESS")
					$resp = 3;
				else
					$resp = 4;
				unset($res);
				unset($selpr);
			}
		}
		else{
			$allUID = explode(",", $uId);
			$type = "";
			$newpr = "";
			for($i = 0; $i < count($allUID); $i++){
				if($allUID[$i] != ""){
					$selpr = $db->query("query","SELECT topic_id,content_type,priority FROM avn_resources_detail WHERE unique_id = " . $allUID[$i]);
					$pr = $selpr[$i]["priority"];
					$resid = $selpr[$i]["topic_id"];
					$content = $selpr[$i]["content_type"];
					$priority = $selpr[$i]["priority"];
					if(isset($content) && $content == "spot"){
						$type = 1;
					}
					if(isset($content) && $content == "concept"){
						$type = 2;
					}
					$dltQ = $db->query("query","SELECT unique_id FROM avn_question_master WHERE topic_id = " . $topic . " AND type = " . $type);
					if(!array_key_exists("response",$dltQ)){
						$resp = 5;
						unset($dltQ);
					}else{
						$chngpr = $db->query("query","SELECT unique_id,topic_id,content_type,priority FROM avn_resources_detail WHERE priority > " . $priority);
						if($chngpr["response"] != "ERROR"){
							for($r = 0;$r < count($chngpr); $r++){
								$dataToWhere =array();
								$dataToWhere['unique_id'] = $chngpr[$r]['unique_id'];
								$dataToWhere['topic_id'] = $topic;
								$arrToUpdate = array();
								$arrToUpdate['priority'] = intval($chngpr[$r]['priority']) - 1;
								$insernewpr = $db->update("avn_resources_detail", $arrToUpdate, $dataToWhere);
								unset($dataToWhere);
								unset($arrToUpdate);
							}
							unset($chngpr);
						}
						$dataToWhere =array();
						$dataToWhere['unique_id'] = $allUID[$i];
						$res = $db->delete("avn_resources_detail",$dataToWhere);
						unset($dataToWhere);
						if($res["response"] == "SUCCESS")
							$resp = 6;
						else
							$resp = 7;
						unset($res);
					}
				}
			}
		}
		$db->close();
	}
	else
		$resp = 0;
	echo $resp . "|#|" . $currid . "|#|" . $topic . "|#|" . $catgid . "|#|" . $chptid . "|#|" . $page . "|#|" . $uId;
?>