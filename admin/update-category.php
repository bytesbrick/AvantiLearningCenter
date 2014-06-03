<?php
	session_start();
	if(isset($_POST["hdstringCategory"]) && $_POST["hdstringCategory"] != "")
			$qryString = $_POST["hdstringCategory"];
		//$qryString .= $qryString == "" ? "?" : "&";
	if(isset($_POST["btnUpdate"]) && $_POST["btnUpdate"] != "")
	{
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$n = $_POST["txtcategoryUp"]; 
		$cid = $_POST["hdCatID"];
		$datatosave = array();
		$datatosave["category_name"] = $_POST['txtcategoryUp'];
		$datatosave["curriculum_id"] = $_POST['ddlcurriculum'];hdslug
		$datatosave["curriculum_slug"] = $_POST['hdslug'];
		$datatosave["prefix"] = strtoupper($_POST['prefix']);
		$datatosave["entry_date"] = "NOW()";
		$wheretoupdate = array();
		$wheretoupdate["unique_id"] = $cid;
		$r = $db->update("ltf_category_master",$datatosave,$wheretoupdate);
		if($r["response"] != "ERROR" ){	
			$url ="./category.php" . $qryString;
			$_SESSION["resp"] = "up";
		}
		else{
			$url = "./category.php" . $qryString;
			$_SESSION["resp"] = "invUp";
		}
		unset($r);
		$db->close();
		header('Location: ' .$url);
	}
	else{
		header("Location: category.php" . $qryString);
		$_SESSION["resp"] = "invEd";
	}
?>