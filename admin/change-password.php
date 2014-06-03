<?php
	error_reporting(0);
	session_start();
	if(isset($_POST["btnUpdate"]))
	{
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		include("./includes/checkLogin.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();

		$newpassword = trim($_POST['txtNewPassword']);
		$cnfpassword = trim($_POST['txtConfirmPassword']);
		$userID = $arrUserInfo['userid'];
		$userName = $arrUserInfo['emailid'];
		if ($cnfpassword == $newpassword){
			$r = $db->query("query","UPDATE ltf_admin_usermaster SET password = AES_ENCRYPT('" . $newpassword . "' , '" . ENCKEY . "') where userid = '" . $userID . "' and emailid = '" . $userName . "'");
			$rURL = "./password-change.php?resp=chps";
			
		}
		else
			$rURL = "./password-change.php?resp=ntChps";
		unset($r);
		$db->close();
	}
	else
		$rURL = './dashboard.php';
	header('Location: ' . $rURL);
?>