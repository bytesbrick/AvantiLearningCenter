<?php
	session_start();
	if(isset($_POST["btnsave"]) && $_POST["btnsave"] != ""){
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();

		$dataToSave = array();
		$dataToSave['fname'] = $_POST['txtManagerFName'];
		$dataToSave['lname'] = $_POST['txtManagerLName'];
		$dataToSave['center_manager_id'] = $_POST['txtManagerID'];
		$dataToSave['email_id'] = $_POST['txtemailid'];
		$dataToSave['phone'] = $_POST['txtPhone'];
		$dataToSave['city_id'] = $_POST['ddlcity'];
		$dataToSave['gender'] = $_POST['ddlGender'];
		$dataToSave['entry_date'] = "now()";
		$dataToSave['status'] = $_POST['ddlStatus'];
		
		$r = $db->insert('avn_centermanager_master',$dataToSave);
		if(array_key_exists('response', $r)){
			if($r['response'] == "SUCCESS"){
				$sql = "SELECT MAX(unique_id) as NewManagerID FROM avn_centermanager_master";
				$maxISRs = $db->query("query", $sql);
				
				$dataToAdmin = array();
				$dataToAdmin['password'] = "AES_ENCRYPT('" . $_POST['textpassword'] . "', '" . ENCKEY . "')";
				$dataToAdmin['username'] = $_POST['txtemailid'];
				$dataToAdmin['gender'] = $_POST['ddlGender'];
				$dataToAdmin['status'] = $_POST['ddlStatus'];
				$dataToAdmin['firstname'] = $_POST['txtManagerFName'];
				$dataToAdmin['lastname'] = $_POST['txtManagerLName'];
				$dataToAdmin['entrydate'] = "now()";
				$dataToAdmin['usertype'] = $_POST['hdnmanager'];
				$dataToAdmin['userid'] = "uuid()";
				$dataToAdmin['emailid'] = $_POST['txtemailid'];
				$dataToAdmin['user_ref_id'] = $maxISRs[0]['NewManagerID'];
				$admin = $db->insert('ltf_admin_usermaster',$dataToAdmin);
				if(array_key_exists('response', $admin)){
					if($admin['response'] == "SUCCESS"){
						
						$dataToLogin = array();
						$dataToLogin['password'] = "AES_ENCRYPT('" . $_POST['textpassword'] . "', '" . ENCKEY . "')";
						$dataToLogin['username'] = $_POST['txtemailid'];
						$dataToLogin['gender'] = $_POST['ddlGender'];
						$dataToLogin['status'] = $_POST['ddlStatus'];
						$dataToLogin['firstname'] = $_POST['txtManagerFName'];
						$dataToLogin['lastname'] = $_POST['txtManagerLName'];
						$dataToLogin['entrydate'] = "now()";
						$dataToLogin['user_type'] = $_POST['hdnmanager'];
						$dataToLogin['userid'] = "uuid()";
						$dataToLogin['emailid'] = $_POST['txtemailid'];
						$dataToLogin['user_ref_id'] = $maxISRs[0]['NewManagerID'];
						
						$user = $db->insert('avn_login_master',$dataToLogin);
						unset($dataToLogin);
					}
				}
			}
			$url = "./manager.php";
			$_SESSION["resp"] = "succ"; 
		}
		else{
			$url = "./manager.php";
			$_SESSION["resp"] = "err";
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