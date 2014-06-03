<?php
	session_start();
	if(isset($_POST["btnsave"]) && $_POST["btnsave"] != ""){
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		
		$dataToSave = array();
		$dataToSave['fname'] = $_POST['txtStudentFName'];
		$dataToSave['lname'] = $_POST['txtStudentLName'];
		$dataToSave['student_id'] = $_POST['txtstudentID'];
		$dataToSave['batch_id'] = $_POST['ddlBatch'];
		$dataToSave['email_id'] = $_POST['txtEmailID'];
		$dataToSave['phone'] = $_POST['txtPhone'];
		$dataToSave['board'] = $_POST['txtboard'];
		$dataToSave['school'] = $_POST['txtschool'];
		$dataToSave['address'] = $_POST['textaddress'];
		$dataToSave['gender'] = $_POST['ddlGender'];
		$dataToSave['status'] = $_POST['ddlStatus'];
		$dataToSave['entry_date'] = "now()";

		$r = $db->insert('avn_student_master',$dataToSave);
		if(array_key_exists('response', $r)){
			if($r['response'] == "SUCCESS"){
				$sql = "SELECT MAX(unique_id) as NewStudentID FROM avn_student_master";
				$maxISRs = $db->query("query", $sql);
				
				$dataToLogin = array();
				$dataToLogin['password'] = "AES_ENCRYPT('" . $_POST['textpassword'] . "', '" . ENCKEY . "')";
				$dataToLogin['username'] = $_POST['txtEmailID'];
				$dataToLogin['gender'] = $_POST['ddlGender'];
				$dataToLogin['status'] = $_POST['ddlStatus'];
				$dataToLogin['firstname'] = $_POST['txtStudentFName'];
				$dataToLogin['lastname'] = $_POST['txtStudentLName'];
				$dataToLogin['entrydate'] = "now()";
				$dataToLogin['user_type'] = $_POST['hdnstudent'];
				$dataToLogin['userid'] = "uuid()";
				$dataToLogin['emailid'] = $_POST['txtEmailID'];
				$dataToLogin['user_ref_id'] = $maxISRs[0]['NewStudentID'];
				$user = $db->insert('avn_login_master',$dataToLogin);
				unset($dataToLogin);
			}
			$url = "./student.php";
			$_SESSION["resp"] = "succ"; 
		}
		else{
			$url = "./student.php";
			$_SESSION["resp"] = "err";
		}
		unset($user);
		unset($dataToSave);
		unset($r);
		$db->close();
	}
	else{
		$url = "./student.php";
		$_SESSION["resp"] = "err";
	}
	header('Location: ' . $url);
?>