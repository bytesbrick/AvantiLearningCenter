<?php	
	if(isset($_POST["btnUpdate"])){
	    if(isset($_COOKIE["cUserName"]))
			$UserName = $_COOKIE["cUserName"];
		include_once("./includes/config.php");
		include_once("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$newpassword = trim($_POST['txtNewPassword']);
		$cnfpassword = trim($_POST['txtConfirmPassword']);
		$userID = $_COOKIE['userID'];
		$userName = $_COOKIE['cUserID'];
		if ($cnfpassword == $newpassword){
			$r = $db->query("query","update avn_login_master set password = '" . $newpassword . "' where userid = '" . $userID . "' and emailid = '" . $userName . "'");
			$rURL = __WEBROOT__ . "/change-password/?resp=chps";
		}
		else{
			$rURL = __WEBROOT__ . "/change-password/?resp=ntChps";
		}
		$db->close();
	}
	else
		$rURL = __WEBROOT__ . "/change-password/?resp=nChps";
	header('Location: ' . $rURL);
?>