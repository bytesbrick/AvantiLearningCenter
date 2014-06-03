<?php
	session_start();
	if(isset($_POST["btnsave"]) && $_POST["btnsave"] != ""){
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		
		$dataToSave = array();
		$dataToSave['userid'] = "uuid()";
		$dataToSave['username'] = $_POST['txtUserName'];
		$dataToSave['firstname'] = $_POST['txtFName'];
		$dataToSave['lastname'] = $_POST['txtLName'];
		$dataToSave['emailid'] = $_POST['txtEmailID'];
		$dataToSave['password'] = "AES_ENCRYPT('" . $_POST["txtPassword"] . "', '" . ENCKEY ."')";
		$dataToSave['gender'] = $_POST['ddlGender'];
		$dataToSave['status'] = $_POST['ddlStatus'];
		$dataToSave['usertype'] = $_POST['ddlTypeUser'];
		$dataToSave['entrydate'] = "now()";
		
		$r = $db->insert('ltf_admin_usermaster',$dataToSave);
		if(array_key_exists('response', $r)){
			$url = "./editor.php";
			$_SESSION["resp"] = "succ"; 
		}
		else{
			$url = "./add-editor.php";
			$_SESSION["resp"] = "err";
		}
	}
	else{
		$url = './add-editor.php';
		$_SESSION["resp"] = "errEd";
	}
	
	unset($dataToSave);
	unset($r);
	$db->close();
	header('Location: ' . $url);
?>