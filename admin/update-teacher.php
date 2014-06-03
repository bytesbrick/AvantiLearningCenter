<?php
	session_start();
	if(isset($_POST["btnsave"]) && $_POST["btnsave"] != ""){
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();

		$dataToSave = array();
		$dataToWhere = array();
		
		$dataToWhere["unique_id"] = $_POST['hdTeacherid'];
		$dataToSave['fname'] = $_POST['txtTeacherFName'];
		$dataToSave['lname'] = $_POST['txtTeacherLName'];
		$dataToSave['teacher_id'] = $_POST['txtTeacherID'];
		$dataToSave['email_id'] = $_POST['txtemailid'];
		$dataToSave['phone'] = $_POST['txtPhone'];
		$dataToSave['city_id'] = $_POST['ddlcity'];
		$dataToSave['gender'] = $_POST['ddlGender'];
		$dataToSave['entry_date'] = "now()";
		
		$r = $db->update('avn_teacher_master',$dataToSave, $dataToWhere);
		unset($r);
		unset($dataToSave);
		unset($dataToWhere);
		if(array_key_exists('response', $r)){
			if($r['response'] == "SUCCESS"){
				$dataToWhere = array();
				$dataToWhere["user_ref_id"] = $_POST['hdTeacherid'];
				
				$dataToLogin = array();
				$dataToLogin['password'] = "AES_ENCRYPT('" . $_POST['textpassword'] . "', '" . ENCKEY . "')";
				$dataToLogin['username'] = $_POST['txtemailid'];
				$dataToLogin['gender'] = $_POST['ddlGender'];
				$dataToLogin['status'] = $_POST['ddlStatus'];
				$dataToLogin['firstname'] = $_POST['txtTeacherFName'];
				$dataToLogin['lastname'] = $_POST['txtTeacherLName'];
				$dataToLogin['entrydate'] = "now()";
				$dataToLogin['usertype'] = $_POST['hdnteacher'];
				$dataToLogin['emailid'] = $_POST['txtemailid'];
		
				$admin = $db->update('ltf_admin_usermaster',$dataToLogin, $dataToWhere);
				unset($dataToWhere);
				unset($dataToLogin);
				
				if(array_key_exists("response",$admin)){					
					if($admin["response"] == "SUCCESS"){
						$dataToWhere = array();
						$dataToWhere["user_ref_id"] = $_POST['hdTeacherid'];
						
						$dataToLogin = array();
						$dataToLogin['password'] = "AES_ENCRYPT('" . $_POST['textpassword'] . "', '" . ENCKEY . "')";
						$dataToLogin['username'] = $_POST['txtemailid'];
						$dataToLogin['gender'] = $_POST['ddlGender'];
						$dataToLogin['status'] = $_POST['ddlStatus'];
						$dataToLogin['firstname'] = $_POST['txtTeacherFName'];
						$dataToLogin['lastname'] = $_POST['txtTeacherLName'];
						$dataToLogin['entrydate'] = "now()";
						$dataToLogin['user_type'] = $_POST['hdnteacher'];
						$dataToLogin['emailid'] = $_POST['txtemailid'];
						
						$admin = $db->update('avn_login_master', $dataToLogin, $dataToWhere);
						unset($dataToWhere);
						unset($dataToLogin);
						
					}
					
				}
			}
			$url = "./teacher.php";
			$_SESSION["resp"] = "up"; 
		}
		else{
			$url = "./teacher.php";
			$_SESSION["resp"] = "invp";
		}
		unset($teacher);
		unset($r);
		$db->close();
	}
	else{
		$url = "./teacher.php";
		$_SESSION["resp"] = "err";
	}
	header('Location: ' . $url);
?>