<?php

	$resp="";
	if(isset($_POST["uniqueid"]) && $_POST["uniqueid"] != "")
	{
		include_once("../includes/config.php");		
		include_once("../classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		
		$uniqueid = $_POST["uniqueid"];
		$catgid = $_POST["catgid"];
		$chptid = $_POST["chptid"];
		$topicid = $_POST["tpid"];
		$testtype = $_POST["type"];
		$page = $_POST["page"];
		$action = $_POST["action"];
		$currid = $_POST["currid"];
		$sel= $db->query("query","SELECT unique_id, priority FROM avn_question_master WHERE unique_id = " . $uniqueid . " AND topic_id = " . $topicid . " AND type = " . $testtype . " order by priority ASC");
		if(!array_key_exists("response", $sel)){
			$priority = $sel[0]['priority'];
			$newPriority = 0;
			if(isset($_POST["action"]) && $_POST["action"] == 'up'){
				$newPriority = ($priority - 1);
			} else if(isset($_POST["action"]) && $_POST["action"] == 'down'){
				$newPriority = ($priority + 1);
			} 
			
			$sql = "SELECT unique_id FROM avn_question_master WHERE priority = " . $newPriority . " AND topic_id  = " . $topicid . " AND type = " . $testtype;
				$LastUID = $db->query("query", $sql);
				
				if(!array_key_exists("response", $LastUID)){
					$lastUID = $LastUID[0]['unique_id'];
					
					$dataToSave = array();
					$dataToSave["priority"] = $newPriority;
					$where = array();
					$where["unique_id"] = $uniqueid;
					$up = $db->update("avn_question_master", $dataToSave, $where);
					//print_r($up);
					unset($dataToSave);
					unset($where);
					
					$dataToSave = array();
					$dataToSave["priority"] = $priority;
					$where = array();
					$where["unique_id"] = $lastUID;
					$up = $db->update("avn_question_master", $dataToSave, $where);
					//print_r($up);
					unset($dataToSave);
					unset($where);
				} else {
					$dataToSave = array();
					$dataToSave["priority"] = $newPriority;
					$where = array();
					$where["unique_id"] = $uniqueid;
					$up = $db->update("avn_question_master", $dataToSave, $where);
					unset($dataToSave);
					unset($where);
				}
		}
		$resp = 1;
		unset($r);
		$db->close();
	}
	else
		$resp = 0;
	echo $resp. "|#|" . $currid . "|#|" . $topicid . "|#|" . $catgid . "|#|" . $chptid . "|#|" . $page;
?>