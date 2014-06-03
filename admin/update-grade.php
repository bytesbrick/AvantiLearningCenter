<?php
	session_start();
	if(isset($_POST["btnUpdate"]))
	{
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		if(isset($_POST["hdnqryStringGrade"]) && $_POST["hdnqryStringGrade"] != "")
			$qryString = urldecode($_POST["hdnqryStringGrade"]);
		//$qryString .= $qryString == "" ? "?" : "&";
		
		$datatosave = array();
		$datatosave["grade_name"] = $_POST["txtgradeUp"];
		$datatowhere = array();
		$datatowhere["unique_id"] = $_POST["hdCatID"];
		$r = $db->update("ltf_grade_level_master",$datatosave,$datatowhere);
		if($r["response"] != "ERROR" )
		{
			$url ="./grade.php".$qryString;
			$_SESSION["resp"] = "up";
		}
		else{
			$url = './grade.php'.$qryString;
			$_SESSION["resp"] = "invEd";
		}
		unset($r);
		$db->close();
		header('Location: ' . $url);
	}
	else
		$url = './grade.php';
?>