<?php
	session_start();
	if(isset($_POST["btnUpdate"]) && $_POST["btnUpdate"]!= ""){
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		
		if(isset($_POST["hdstringcurriculum"]) && $_POST["hdstringcurriculum"] != "")
			$qryString = $_POST["hdstringcurriculum"];
		//$qryString .= $qryString == "" ? "?" : "&";
		$dataToSave = array();
		$dataTowhere = array();
		$dataTowhere["unique_id"] = $_POST['hdCurrID'];
		$dataToSave["curriculum_name"] = $_POST['txtcurriculum'];
		$dataToSave["curriculum_slug"] = $_POST['hdCurrentSlug'];
		$dataToSave["curriculum_id"] = $_POST['txtcurriculumID'];
		$dataToSave["current_year"] = $_POST['ddlcurrentyear'];
		$dataToSave["next_year"] = $_POST['ddlnextyear'];
		$dataToSave["class"] = $_POST['txtclass'];
		$dataToSave["entry_date"] = "NOW()";
		$r = $db->update("avn_curriculum_master",$dataToSave,$dataTowhere);
		if($r["response"] == "SUCCESS"){
			$url = "./curriculum.php" . $qryString;
			$_SESSION["resp"] = "up";
		}
		else{
			$url = "./curriculum.php" . $qryString;
			$_SESSION["resp"] = "errEd";
		}
		unset($r);
		unset($dataToSave);
		unset($dataTowhere);
		$db->close();
		header('Location: ' . $url);
	}
	else
		header('Location: curriculum.php');
?>