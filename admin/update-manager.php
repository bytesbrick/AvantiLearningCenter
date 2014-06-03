<?php
	session_start();
	if(isset($_POST["btnsave"]) && $_POST["btnsave"] != ""){
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();

		$dataToSave = array();
		$dataToWhere = array();		
		$dataToWhere["unique_id"] = $_POST['hdManagerid'];
		
		$dataToSave['fname'] = $_POST['txtManagerFName'];
		$dataToSave['lname'] = $_POST['txtManagerLName'];
		$dataToSave['center_manager_id'] = $_POST['txtManagerID'];
		$dataToSave['email_id'] = $_POST['txtemailid'];
		$dataToSave['phone'] = $_POST['txtPhone'];
		$dataToSave['city_id'] = $_POST['ddlcity'];
		$dataToSave['status'] = $_POST['ddlStatus'];
		$dataToSave['gender'] = $_POST['ddlGender'];
		$dataToSave['entry_date'] = "now()";
		
		$r = $db->update('avn_centermanager_master',$dataToSave, $dataToWhere);
		unset($dataToWhere);
		if(array_key_exists('response', $r)){
			if($r['response'] == "SUCCESS"){
				$dataToWhere = array();
				$dataToWhere["user_ref_id"] = $_POST['hdManagerid'];
				
				$dataToAdmin = array();
				$dataToAdmin['password'] = "AES_ENCRYPT('" . $_POST['textpassword'] . "', '" . ENCKEY . "')";
				$dataToAdmin['username'] = $_POST['txtemailid'];
				$dataToAdmin['gender'] = $_POST['ddlGender'];
				$dataToAdmin['firstname'] = $_POST['txtManagerFName'];
				$dataToAdmin['lastname'] = $_POST['txtManagerLName'];
				$dataToAdmin['entrydate'] = "now()";
				$dataToAdmin['status'] = $_POST['ddlStatus'];
				$dataToAdmin['usertype'] = $_POST['hdnmanager'];
				$dataToAdmin['userid'] = "uuid()";
				$dataToAdmin['emailid'] = $_POST['txtemailid'];
				
				$user = $db->update('ltf_admin_usermaster',$dataToAdmin, $dataToWhere);
					if($user["response"] == "SUCCESS"){
						$dataToLogin = array();
						$dataToLogin['password'] = "AES_ENCRYPT('" . $_POST['textpassword'] . "', '" . ENCKEY . "')";
						$dataToLogin['username'] = $_POST['txtemailid'];
						$dataToLogin['gender'] = $_POST['ddlGender'];
						$dataToLogin['firstname'] = $_POST['txtManagerFName'];
						$dataToLogin['lastname'] = $_POST['txtManagerLName'];
						$dataToLogin['entrydate'] = "now()";
						$dataToLogin['status'] = $_POST['ddlStatus'];
						$dataToLogin['user_type'] = $_POST['hdnmanager'];
						$dataToLogin['userid'] = "uuid()";
						$dataToLogin['emailid'] = $_POST['txtemailid'];
						
						$login = $db->update('avn_login_master',$dataToLogin, $dataToWhere);
					}
				
				unset($dataToLogin);
				unset($dataToWhere);
			}
			$url = "./manager.php";
			$_SESSION["resp"] = "up"; 
		}
		else{
			$url = "./manager.php";
			$_SESSION["resp"] = "invp";
		}
		unset($dataToemail);
		unset($manager);
		unset($dataToSave);
		unset($r);
		$db->close();
	}
	else{
		$url = "./manager.php";
		$_SESSION["resp"] = "err";
	}
	header('Location: ' . $url);
?>