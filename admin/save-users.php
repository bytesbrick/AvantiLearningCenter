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
		$dataToSave['password'] = $_POST['txtPassword'];
		$dataToSave['gender'] = $_POST['ddlGender'];
		$dataToSave['status'] = $_POST['ddlStatus'];
		$dataToSave['user_type'] = $_POST['ddlTypeUser'];
		$dataToSave['entrydate'] = "now()";
	
		$r = $db->insert('avn_login_master',$dataToSave);
		if(array_key_exists('response', $r)){
			$url = "./lead-users.php";
			$_SESSION["resp"] = "succ"; 
		}
		else{
			$url = "./add-users.php";
			$_SESSION["resp"] = "err";
		}
		unset($dataToSave);
		unset($r);
		$db->close();
	}
	else{
		$url = './add-users.php?resp=err';
		$_SESSION["resp"] = "resp=err";
	}
	header('Location: ' . $url);
?>