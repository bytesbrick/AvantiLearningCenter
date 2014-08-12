<?php

	$resp="";
	if(isset($_POST["uniqueid"]) && $_POST["uniqueid"] != "")
	{
		include_once("../includes/config.php");		
		include_once("../classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		
		$uniqueid = $_POST["uniqueid"];
		$page= $_POST["page"];
		$status= $_POST["status"];
		if(strpos($uniqueid, ",") === false){
			if(isset($status) && $status == 0)
				$newstatus = 1;
			if(isset($status) && $status == 1)
				$newstatus = 0;
			
			$dataToSave = array();
			$dataToSave['status'] = $newstatus;
			$datatowhere = array();
			$datatowhere['unique_id'] = $uniqueid;
			$r = $db->update("avn_centermanager_master",$dataToSave,$datatowhere);
			unset($r);
			unset($dataToSave);
			unset($datatowhere);
			
			$dataToSave = array();
			$dataToSave['status'] = $newstatus;
			
			$datatowhere = array();
			$datatowhere['user_ref_id'] = $uniqueid;
			$r = $db->update("avn_login_master",$dataToSave,$datatowhere);
			
			if($r["response"] == "SUCCESS")
				$resp = 1;
			else
				$resp = 2;
			unset($r);
			unset($dataToSave);
			unset($datatowhere); 
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
					$dataToSave['status'] = $newstatus;
					$datatowhere = array();
					$datatowhere['unique_id'] = $allUID[$i];
					$r = $db->update("avn_centermanager_master",$dataToSave,$datatowhere);
					unset($r);
					unset($dataToSave);
					unset($datatowhere);
					
					$dataToSave = array();
					$dataToSave['status'] = $newstatus;
					$datatowhere = array();
					$datatowhere['user_ref_id'] = $allUID[$i];
					$r = $db->update("avn_login_master",$dataToSave,$datatowhere);
					if($r["response"] == "SUCCESS")
						$resp = 3;
					else
						$resp = 4;
					unset($r);
					unset($dataToSave);
					unset($datatowhere);
				}
			}
		}
		$db->close();
	}
	else
		$resp = "0";
	echo $resp. "|#|" . $page . "|#|" . $_POST["rid"];;
?>