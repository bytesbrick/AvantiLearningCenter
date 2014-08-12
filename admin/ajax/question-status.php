<?php
	$resp="";
	if(isset($_POST["uniqueid"]) && $_POST["uniqueid"] != "")
	{
		include_once("../includes/config.php");		
		include_once("../classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		
		$uniqueid = $_POST["uniqueid"];
		$topicid = $_POST["topic_id"];
		$chptid = $_POST["chptid"];
		$catgid = $_POST["catgid"];
		$status= $_POST["status"];
		$qtype= $_POST["qtype"];
		$page= $_POST["page"];
		$currid= $_POST["currid"];
		if(strpos($uniqueid, ",") === false){
			if(isset($status) && $status == 0)
				$newstatus = 1;
			if(isset($status) && $status == 1)
				$newstatus = 0;
			$dataToSave = array();
			$dataToWhere["unique_id"] = $uniqueid ;
			$dataToSave["status"] = $newstatus;
			//$r = $db->query("query","UPDATE avn_question_master SET status = " . $newstatus . " WHERE unique_id = " . $uniqueid . " AND type = " . $qtype);
			$r = $db->update("avn_question_master",$dataToSave,$dataToWhere);
			if($r["response"] == "SUCCESS")
				$resp = 1;
			else
				$resp = 2;
			unset($r);
			unset($dataToSave);
			unset($dataToWhere);
		}
		else{
			$allUID = explode(",", $uniqueid);
			for($i = 0; $i < count($allUID); $i++){
				if($allUID[$i] != ""){
					if(isset($status) && $status == 0)
						$newstatus = 1;
					if(isset($status) && $status == 1)
						$newstatus = 0;
					$dataToSave = array();
					$dataToWhere["unique_id"] = $allUID[$i];
					$dataToSave["status"] = $newstatus;
					//$r = $db->query("query","UPDATE avn_question_master SET status = " . $newstatus . " WHERE unique_id = " . $allUID[$i] . " AND type = " . $qtype);
					$r = $db->update("avn_question_master",$dataToSave,$dataToWhere);
					if($r["response"] == "SUCCESS")
						$resp = 3;
					else
						$resp = 4;
					unset($r);
					unset($dataToSave);
					unset($dataToWhere);
				}
			}
		}
		$db->close(); 
	}
	else
		$resp = 0;
	echo $resp. "|#|" . $currid . "|#|" . $topicid  . "|#|" . $catgid . "|#|" . $chptid . "|#|" . $page . "|#|" . $_POST["rid"];
?>