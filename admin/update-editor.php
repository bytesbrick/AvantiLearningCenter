<?php
	session_start();
	include("./includes/config.php");		
	include("./classes/cor.mysql.class.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
	
	if(isset($_POST["hdnqryStringEditor"]) && $_POST["hdnqryStringEditor"] != "")
			$qryString = urldecode($_POST["hdnqryStringEditor"]);
		//$qryString .= $qryString == "" ? "?" : "&";
	
	if(isset($_POST["btnupdate"]) && $_POST["btnupdate"] != ""){

		$dataToSave = array();
		$dataToWhere = array();
		$dataToSave['firstname'] = $_POST['txtFName'];
		$dataToSave['lastname'] = $_POST['txtLName'];
		$dataToSave['emailid'] = $_POST['txtEmailID'];
		$dataToSave['username'] = $_POST['txtUserName'];
		$dataToSave['gender'] = $_POST['ddlGender'];
		$dataToSave['status'] = $_POST['ddlStatus'];
		$dataToSave['password'] = "AES_ENCRYPT('" . $_POST["txtPassword"] . "', '" . ENCKEY ."')";
		$dataToSave['usertype'] = $_POST['ddlTypeUser'];
		$dataToSave['entrydate'] = "NOW()";
			
		$dataToWhere['unique_id'] = $_POST['hdnuID'];
		$uid = $_POST['hdnuID'];

		$r = $db->update("ltf_admin_usermaster",$dataToSave, $dataToWhere);
		
		if(isset($r["response"])){
			$url ="./editor.php" . $qryString;
			$_SESSION["resp"] = "up";
		}
		else{
			$url = "./editor.php" . $qryString;
			$_SESSION["resp"] = "invUp";
		}
		
		unset($r);
		unset($dataToSave);
		unset($dataToWhere);
		$db->close();
		header('Location: ' . $url);
	}
	else
		header('Location: ./editor.php');
?>