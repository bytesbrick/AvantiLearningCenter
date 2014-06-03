<?php
	session_start();
	if(isset($_POST["hdnqryStringResource"]) && $_POST["hdnqryStringResource"] != "")
			$qryString = urldecode($_POST["hdnqryStringResource"]);
		//$qryString .= $qryString == "" ? "?" : "&";
		
	if(isset($_POST["btnSave"]) && $_POST["btnSave"] != "")
	{
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$rid= $_POST['hdnresid'];
		$tpid= $_POST['hdntpid'];
		$id = $_POST['hdnuid'];
		$intro = str_replace("\\","",$_POST["txtintro"]);
		$status = $_POST["ddlstatus"];
		
		$datatosave = array();	
		$datatosave['topic_id'] = $_POST['hdntpid'];
		$datatosave['title'] = $_POST['resourcetitle'];
		$datatosave['resource_slug'] = $_POST['hdCurrentSlug']; 
		$datatosave['text'] =  htmlspecialchars_decode($intro);
		$datatosave['entry_date'] = "NOW()";
		$datatosave['status'] = $status;
		
		$datawhere = array();
		$datawhere['unique_id'] = $_POST['hdnuid'];
		
		$r = $db->update("avn_resources_detail",$datatosave,$datawhere);
		
		if($r["response"] !== "ERROR" ){
			$rURL ="./resource.php" . $qryString;
			$_SESSION["resp"] = "up";
		}
		else{
			$rURL ="./resource.php" . $qryString;
			$_SESSION["resp"] = "invEd";
		}
		$db->close();
	}
	else{
		$rURL ="./resource.php" . $qryString;
		$_SESSION["resp"] = "errEd"; 
	}
	unset($r);
	header('Location: ' . $rURL);
?>