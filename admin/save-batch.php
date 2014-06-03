<?php
	session_start();
	$projpath= "";
	$result = 0;
	if(isset($_POST["btnSave"]) && $_POST["btnSave"] != ""){
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();		
		$datatosave = array();
		$datatosave["batch_name"] = $_POST['txtbatchname'];
		$datatosave["batch_id"] = strtoupper($_POST['txtbatchid']);
		$datatosave["curriculum_id"] = $_POST['ddlcurriculum'];
		$datatosave["facilitator_id"] = $_POST['ddlfacilitator'];
		$datatosave["city_id"] = $_POST['ddlcity'];
		$datatosave["strength"] = $_POST['txtstrength'];
		$datatosave["learning_center"] = $_POST['ddlcenter'];
		$datatosave["entry_date"] = "NOW()";		
		$r = $db->insert("avn_batch_master",$datatosave);
		if($r["response"] != "ERROR"){
			$rURL ="./batch.php";
			$_SESSION["resp"] = "suc";
		}
		$db->close();
	}
	else{
		$rURL = './batch.php'; 
		$_SESSION["resp"] = "err-add";
	}
	unset($r);
	header('Location: ' . $rURL);
?> 