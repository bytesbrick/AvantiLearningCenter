<?php	
	if(isset($_POST["btnUpdate"])){
		
		include_once("./includes/config.php");
		include("./classes/cor.mysql.class.php");
		include_once("./includes/checklogin.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		
		$newpassword = trim($_POST['txtNewPassword']);
		$cnfpassword = trim($_POST['txtConfirmPassword']);
		$emailID = $arrUserInfo['emailid'];
		$userid = $arrUserInfo['userid'];
		$ruid = $arrUserInfo['user_ref_id'];
		
		$curpassword = $_POST['txtCurrentPassword'];
		$selcurpassword = "SELECT AES_DECRYPT(password, '" . ENCKEY . "') FROM avn_login_master WHERE user_ref_id = " . $ruid . " AND emailid= '" . $emailID . "'";
		$selcurpasswordRS = $db->query("query", $selcurpassword);
		$userCpaddword = $selcurpasswordRS[0]["AES_DECRYPT(password, '" . ENCKEY . "')"];
		if($userCpaddword == $curpassword){
			if ($cnfpassword == $newpassword){
				$datatosave = array();
				$datatowhere = array();
				$datatowhere["userid"] = $userid;
				$datatowhere["emailid"]  = $emailID;
				$datatosave["password"] = "AES_ENCRYPT('" . $_POST['txtConfirmPassword'] . "', '" . ENCKEY . "')";
				$datatowhere["user_ref_id"] = $ruid;
				$r =$db->update("avn_login_master", $datatosave, $datatowhere);
				if($r['response'] == 'SUCCESS')
					$rURL = __WEBROOT__ . "/password/?resp=chps";
				else
					$rURL = __WEBROOT__ . "/password/?resp=ntChps";
				unset($r);
			}
			else{
				$rURL = __WEBROOT__ . "/password/?resp=ntChps";
			}
		}
		else{
			$rURL = __WEBROOT__ . "/password/?resp=wrngpswrd";
		}
		
		$db->close();
	}
	else
		$rURL = __WEBROOT__ . "/password/?resp=nChps";
	header('Location: ' . $rURL);
?>