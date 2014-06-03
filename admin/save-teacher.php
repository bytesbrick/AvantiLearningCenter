<?php
	session_start();
	if(isset($_POST["btnsave"]) && $_POST["btnsave"] != ""){
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();

		$dataToSave = array();
		$dataToSave['fname'] = $_POST['txtTeacherFName'];
		$dataToSave['lname'] = $_POST['txtTeacherLName'];
		$dataToSave['teacher_id'] = $_POST['txtTeacherID'];
		$dataToSave['email_id'] = $_POST['txtemailid'];
		$dataToSave['phone'] = $_POST['txtPhone'];
		$dataToSave['city_id'] = $_POST['ddlcity'];
		$dataToSave['gender'] = $_POST['ddlGender'];
		$dataToLogin['status'] = $_POST['ddlStatus'];
		$dataToSave['entry_date'] = "now()";
		
		$teacher = $db->insert('avn_teacher_master',$dataToSave);
		unset($dataToSave);
		if(array_key_exists('response', $teacher)){
			if($teacher['response'] == "SUCCESS"){
				$sql = "SELECT MAX(unique_id) as NewTeacherID FROM avn_teacher_master";
				$maxISRs = $db->query("query", $sql);
				
				$dataToLogin = array();
				$dataToLogin['password'] = "AES_ENCRYPT('" . $_POST['textpassword'] . "', '" . ENCKEY . "')";
				$dataToLogin['username'] = $_POST['txtemailid'];
				$dataToLogin['gender'] = $_POST['ddlGender'];
				$dataToLogin['firstname'] = $_POST['txtTeacherFName'];
				$dataToLogin['lastname'] = $_POST['txtTeacherLName'];
				$dataToLogin['entrydate'] = "now()";
				$dataToLogin['status'] = $_POST['ddlStatus'];
				$dataToLogin['usertype'] = $_POST['hdnteacher'];
				$dataToLogin['userid'] = "uuid()";
				$dataToLogin['emailid'] = $_POST['txtemailid'];
				$dataToLogin['user_ref_id'] = $maxISRs[0]['NewTeacherID'];
				
				$admin = $db->insert('ltf_admin_usermaster',$dataToLogin);
				unset($dataToLogin);
				
				if(array_key_exists("response",$admin)){
					if($admin["response"] == "SUCCESS"){
						
						$dataToAdmin = array();
						$dataToAdmin['password'] = "AES_ENCRYPT('" . $_POST['textpassword'] . "', '" . ENCKEY . "')";
						$dataToAdmin['username'] = $_POST['txtemailid'];
						$dataToAdmin['gender'] = $_POST['ddlGender'];
						$dataToAdmin['firstname'] = $_POST['txtTeacherFName'];
						$dataToAdmin['lastname'] = $_POST['txtTeacherLName'];
						$dataToAdmin['entrydate'] = "now()";
						$dataToAdmin['status'] = $_POST['ddlStatus'];
						$dataToAdmin['user_type'] = $_POST['hdnteacher'];
						$dataToAdmin['userid'] = "uuid()";
						$dataToAdmin['emailid'] = $_POST['txtemailid'];
						$dataToAdmin['user_ref_id'] = $maxISRs[0]['NewTeacherID'];
						
						$user = $db->insert('avn_login_master',$dataToAdmin);
						unset($dataToAdmin);
						
						$url = "./teacher.php";
						$_SESSION["resp"] = "succ";
					}
				}
			}
		}
		else{
			$url = "./teacher.php";
			$_SESSION["resp"] = "err";
		}
		unset($dataToemail);
		unset($teacher);
		unset($dataToSave);
		unset($r);
		$db->close();
	}
	else{
		$url = "./teacher.php";
		$_SESSION["resp"] = "err";
	}
	header('Location: ' . $url);
?>