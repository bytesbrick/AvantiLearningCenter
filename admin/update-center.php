<?php
	session_start();
	$projpath= "";
	$result = 0;
	if(isset($_POST["btnSave"]) && $_POST["btnSave"] != "")
	{
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();		
		$datatosave = array();
		$datatowhere = array();
		$datatowhere["unique_id"] = $_POST["hdncenterid"];
		$datatosave["center_name"] = $_POST['txtcenter'];
		$datatosave["city_id"] = $_POST['ddlcity'];
		$datatosave["entry_date"] = "NOW()";
		$r = $db->update("avn_learningcenter_master",$datatosave, $datatowhere);
		if($r["response"] != "ERROR"){
			$rURL ="./learning-center.php";
			$_SESSION["resp"] = "up";
		}
		$db->close();
	}
	else{
		$rURL = './learning-center.php';
		$_SESSION["resp"] = "invUp";
	}
	unset($r);
	header('Location: ' . $rURL);
?>