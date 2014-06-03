<?php
session_start();
	if(isset($_POST["btnupdate"]) && $_POST["btnupdate"] != ""){
		
		if(isset($_POST["hdstringuser"]) && $_POST["hdstringuser"] != "")
			$qryString = urldecode($_POST["hdstringuser"]);
		//$qryString .= $qryString == "" ? "?" : "&";
		
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();

		$dataToSave = array();
		$dataToWhere = array(); 
		$dataToSave['firstname'] = $_POST['txtFName'];
		$dataToSave['lastname'] = $_POST['txtLName'];
		$dataToSave['emailid'] = $_POST['txtEmailID'];
		$dataToSave['username'] = $_POST['txtUserName'];
		$dataToSave['gender'] = $_POST['ddlGender'];
		$dataToSave['status'] = $_POST['ddlStatus'];
		$dataToSave['user_type'] = $_POST['ddlTypeUser'];
		$dataToSave['entrydate'] = "NOW()";
		
		$dataToWhere['unique_id'] = $_POST['hdnuID'];
		$uid = $_POST['hdnuID'];
		
		$r = $db->update("avn_login_master",$dataToSave, $dataToWhere);
		if(isset($r["response"])){
			$url ="./lead-users.php" . $qryString;
			$_SESSION["resp"] = "up";
		}
		else{
			$url = './lead-users.php' . $qryString;
			$_SESSION["resp"] = "invUp";
		}
		
		unset($r);
		unset($dataToSave);
		unset($dataToWhere);
		$db->close();
		header('Location: ' . $url);
	}
	else
		header('Location: ./lead-users.php');
?>