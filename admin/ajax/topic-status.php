<?php
	$resp="";
	if(isset($_POST["topicid"]) && $_POST["topicid"] != "")
	{
		include_once("../includes/config.php");		
		include_once("../classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		
		$uniqueid = $_POST["resid"];
		$topicid = $_POST["topicid"];
		$status= $_POST["status"];
		$catgid = $_POST['catgid'];
		$chptid = $_POST["chptid"];
		$page = $_POST["page"];
		$currid = $_POST["currid"];
		if(strpos($topicid, ",") === false){
			if(isset($status) && $status == "statusactive")
				$newstatus = 0;
			if(isset($status) && $status == "statusinactive")
				$newstatus = 1;
			
			$dataToSave = array();
			$datatowhere = array();
			$dataToSave['status'] = $newstatus;
			$datatowhere['unique_id'] = $topicid;
			$r = $db->update("avn_topic_master",$dataToSave,$datatowhere);
			if($r["response"] == "SUCCESS")
				$resp = 1;
			else
				$resp = 2;
			unset($r);
			unset($datatowhere);
			unset($dataToSave);
		}
		else{
			$allUID = explode(",", $topicid);
			for($i = 0; $i < count($allUID); $i++){
				if($allUID[$i] != ""){
					if(isset($status) && $status == "statusactive")
						$newstatus = 0;
					if(isset($status) && $status == "statusinactive")
						$newstatus = 1;
						
					$dataToSave = array();
					$datatowhere = array();
					$dataToSave['status'] = $newstatus;
					$datatowhere['unique_id'] = $allUID[$i];
					
					$r = $db->update("avn_topic_master",$dataToSave,$datatowhere);
					if($r["response"] == "SUCCESS")
						$resp = 3;
					else
						$resp = 4;
					unset($r);
					unset($datatowhere);
					unset($dataToSave);
				}
			}
		}
		$db->close();
	}
	else
		$resp = 0;
	echo $resp . "|#|" . $currid . "|#|" . $chptid . "|#|" . $catgid . "|#|" . $page;
?>