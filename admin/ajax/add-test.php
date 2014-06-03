<?php
	include("../includes/config.php");		
	include("../classes/cor.mysql.class.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
	$resp = "";
	$topic = $_POST['topicid'];
	$action = $_POST['action'];
	$latesttopic = $db->query("query","SELECT MAX(priority) as pr FROM avn_resources_detail WHERE topic_id = " . $topic);
	if(!array_key_exists("response", $latesttopic))
		$newaddedtopic = $latesttopic[0]['pr'] +1;
	else
		$newaddedtopic = 1;
	
	if(isset($_POST['action']) && $_POST['action'] != ""){
		
		if(!array_key_exists("response", $latestresource)){
			$newaddedresource = $latestresource[0]['unique_id'];
			if(isset($action) && $action == 'spottest'){
				$dataToSave = array();
				$dataToSave["content_type"] = 'spot';
				$dataToSave["title"] = 'Spot Test';
				$dataToSave["topic_id"] = $topic;
				$dataToSave["priority"] = $newaddedtopic;
				$dataToSave["resource_slug"] = "spot-test-".$topic; 
				$dataToSave["entry_date"] = 'NOW()';
				$newResource = $db->insert("avn_resources_detail",$dataToSave);
				unset($dataToSave);
				$resp = 1;
			}
			if(isset($action) && $action == 'concepttest'){
				$dataToSave = array();
				$dataToSave["content_type"] = 'concept';
				$dataToSave["title"] = 'Concept Test';
				$dataToSave["topic_id"] = $topic;
				$dataToSave["priority"] = $newaddedtopic;
				$dataToSave["resource_slug"] = "concept-test-".$topic;
				$dataToSave["entry_date"] = 'NOW()';
				$newResource = $db->insert("avn_resources_detail",$dataToSave);
				unset($dataToSave);
				$resp = 1;
			}
			$db->close();
			
		}
	}
	else
		$resp = 0;
		echo $resp;
?> 