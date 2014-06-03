<?php
	$resp="0";
	if(isset($_POST["uniqueid"]) && $_POST["uniqueid"] != "")
	{
		include_once("../includes/config.php");		
		include_once("../classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		
		$uniqueid = $_POST["uniqueid"];
		$status= $_POST["status"];
		$page = $_POST["page"];
		if(strpos($uniqueid, ",") === false){
			if(isset($status) && $status == "inactivestatus")
			$newstatus = 0;
			if(isset($status) && $status == "activestatus")
				$newstatus = 1;
			$dataToSave = array();
			$dataToSave['status'] = $newstatus;
			$datatowhere = array();
			$datatowhere['unique_id'] = $uniqueid;
			
			$r = $db->update("ltf_admin_usermaster",$dataToSave,$datatowhere);
			if($r["response"] == "SUCCESS")
				$resp = 1;
				else
				$resp = 2;
			unset($datatowhere);
			unset($r);
		}
		else{
			$allUID = explode(",", $uniqueid);
			for($i = 0; $i < count($allUID); $i++){
				if($allUID[$i] != ""){
					if(isset($status) && $status == "inactivestatus")
					$newstatus = 0;
				if(isset($status) && $status == "activestatus")
					$newstatus = 1;
				$dataToSave = array();
				$dataToSave['status'] = $newstatus;
				$datatowhere = array();
				$datatowhere['unique_id'] = $allUID[$i];
				
				$r = $db->update("ltf_admin_usermaster",$dataToSave,$datatowhere);
				if($r["response"] == "SUCCESS")
					$resp = 3;
				else
					$resp = 4;
				unset($datatowhere);
				unset($r);
				}
			}
		}
		$db->close();
	}
	echo $resp . "|#|" . $page;
?>