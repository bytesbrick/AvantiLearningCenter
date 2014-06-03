<?php
	session_start();		
	if(isset($_POST["btnSave"]))
	{
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$chkcur = $db->query("query","SELECT MAX(unique_id) as maxid FROM avn_curriculum_master WHERE curriculum_slug = '" . trim($_POST['hdslug']) . "'");
		if(!array_key_exists("response", $chkcur)){
			if($chkcur[0]["maxid"] != "")
				$slug = $_POST['hdslug'] . "-" . ($chkcur[0]["maxid"] + 1);
			else
				$slug = $_POST['hdslug']; 
		}
		else
			$slug = $_POST['hdslug'];
		$dataToSave = array();
		$dataToSave["curriculum_name"] = $_POST['txtcurriculum'];
		$dataToSave["curriculum_slug"] = $slug;
		$dataToSave["curriculum_id"] = $_POST['txtcurriculumID'];
		$dataToSave["current_year"] = $_POST['ddlcurrentyear'];
		$dataToSave["next_year"] = $_POST['ddlnextyear'];
		$dataToSave["class"] = $_POST['txtclass'];
		$dataToSave["entry_date"] = "NOW()";
		$r = $db->insert("avn_curriculum_master", $dataToSave);
		if($r["response"] !== "ERROR" ){
			$rURL ="./curriculum.php";
			$_SESSION["resp"] = "suc";
		}
		else{
			$rURL = './curriculum.php';
			$_SESSION["resp"] = "invEd";
		}
		$db->close();
		unset($r);
	}
	else{
		$rURL = './curriculum.php';
		$_SESSION["resp"] = "errEd";
	}
	header('Location: ' . $rURL);
?>