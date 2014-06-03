<?php
	$resp="";
	if(isset($_POST["uniqueid"]) && $_POST["uniqueid"] != "")
	{
		include_once("../includes/config.php");		
		include_once("../classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		
		$uniqueid = $_POST["uniqueid"];
		$catgid = $_POST['catgid'];
		$chptid = $_POST["chptid"];
		$page = $_POST["page"];
		$action = $_POST["action"];
		$currid = $_POST["currid"];
		$sel= $db->query("query","SELECT unique_id, topic_priority FROM avn_topic_master WHERE unique_id = " . $uniqueid . " AND chapter_id = " . $chptid . " order by topic_priority ASC");
		
		if(!array_key_exists("response", $sel)){
			$priority = $sel[0]['topic_priority'];
			$newPriority = 0;
			if(isset($_POST["action"]) && $_POST["action"] == 'up'){
				$newPriority = ($priority - 1);
			} else if(isset($_POST["action"]) && $_POST["action"] == 'down'){
				$newPriority = ($priority + 1);
			}
			$sql = "SELECT unique_id FROM avn_topic_master WHERE topic_priority = " . $newPriority . " AND chapter_id = " . $chptid;
				$LastUID = $db->query("query", $sql);
				if(!array_key_exists("response", $LastUID)){
					$lastUID = $LastUID[0]['unique_id'];
					
					$dataToSave = array();
					$dataToSave["topic_priority"] = $newPriority;
					$where = array();
					$where["unique_id"] = $uniqueid;
					$up = $db->update("avn_topic_master", $dataToSave, $where);
					unset($dataToSave);
					unset($where);
					
					$dataToSave = array();
					$dataToSave["topic_priority"] = $priority;
					$where = array();
					$where["unique_id"] = $lastUID;
					$up = $db->update("avn_topic_master", $dataToSave, $where);
					unset($dataToSave);
					unset($where);
				} else {
					$dataToSave = array();
					$dataToSave["topic_priority"] = $newPriority;
					$where = array();
					$where["unique_id"] = $uniqueid;
					$up = $db->update("avn_topic_master", $dataToSave, $where);
					unset($dataToSave);
					unset($where);
				}
			$resp = 1;
		}		
		unset($r);
		$db->close();
	}
	else
		$resp = 0;
	echo $resp. "|#|" . $currid . "|#|" . $chptid . "|#|" . $catgid . "|#|" . $page;
?>