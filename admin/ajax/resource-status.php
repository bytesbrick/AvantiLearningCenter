<?php
	$resp="0";
	if(isset($_POST["resid"]) && $_POST["resid"] != "")
	{
		include_once("../includes/config.php");		
		include_once("../classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$uniqueid = $_POST["resid"];
		$topicid = $_POST["topic_id"];
		$status= $_POST["status"];
		$catgid = $_POST['catg_id'];
		$chptid = $_POST["chap_id"];
		$page = $_POST["page"];
		$currid = $_POST["currid"];
		if(strpos($uniqueid, ",") === false){
			if(isset($status) && $status == "activestatus")
				$newstatus = 1;
			if(isset($status) && $status == "inactivestatus")
				$newstatus = 0;
			
			$dataToSave = array();
			$dataToSave['status'] = $newstatus;
			
			$datatowhere = array();
			$datatowhere['unique_id'] = $uniqueid;
			
			$r = $db->update("avn_resources_detail",$dataToSave,$datatowhere);
			if($r["response"] == "SUCCESS")
				$resp = 1;
			else
				$resp = 2;
			unset($r);
		}
		else{ 
			$allUID = explode(",", $uniqueid);
			for($i = 0; $i < count($allUID); $i++){
				if($allUID[$i] != ""){
					if(isset($status) && $status == "activestatus")
						$newstatus = 1;
					if(isset($status) && $status == "inactivestatus")
						$newstatus = 0;								
					$dataToSave = array();
					$datatowhere = array();
					$dataToSave['status'] = $newstatus;
					$datatowhere['unique_id'] = $allUID[$i];
					$r = $db->update("avn_resources_detail",$dataToSave,$datatowhere);
					if($r["response"] == "SUCCESS")
						$resp = 3;
					else
						$resp = 4;
					unset($r);
				}
			}
		}
		$db->close();
	}
	echo $resp . "|#|" . $currid . "|#|" . $topicid . "|#|" . $catgid . "|#|" . $chptid . "|#|" . $page;
?>