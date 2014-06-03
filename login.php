<?php
	include("./includes/config.php");		
	if(isset($_POST["txtemailid"]) && isset($_POST["txtpassword"]))
	{
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		//$r = $db->query("stored procedure","sp_avn_login('".$_POST['txtemailid']."','".$_POST['txtpassword']."', '" . ENCKEY . "')");
		$email= "SELECT emailid FROM avn_login_master WHERE status = 1 AND emailid = '" . $_POST['txtemailid'] . " '";
		$emailRS = $db->query("query", $email);
		if(!array_key_exists("response", $emailRS)){
			$emailID = $emailRS[0]["emailid"];
			$password = "SELECT * FROM avn_login_master WHERE status = 1 AND emailid = '" . $emailID . "' AND password = AES_ENCRYPT('" . $_POST['txtpassword'] . "', '" . ENCKEY . "')";
			$r = $db->query("query", $password);
			if(!array_key_exists("response", $r)){
				$hdnurl =  __WEBROOT__ . "/lesson-plan/";
				if($r["response"] != "ERROR"){		
					if($r[0]["user_type"] == "Student"){
						$sql = "SELECT abm.batch_id, acm.curriculum_slug FROM avn_student_master asm INNER JOIN avn_batch_master abm ON asm.batch_id = abm.unique_id INNER JOIN avn_curriculum_master acm ON abm.curriculum_id = acm.unique_id WHERE asm.unique_id = " . $r[0]["user_ref_id"];
						$bcInfo = $db->query("query",$sql);						
						$cookieData = array();
						$cookieData["userid"] = $r[0]["userid"];
						$cookieData["emailid"] = $r[0]["emailid"];
						$cookieData["firstname"] = $r[0]["firstname"];
						$cookieData["lastname"] = $r[0]["lastname"];
						$cookieData["user_type"] = $r[0]["user_type"];
						$cookieData["user_ref_id"] = $r[0]["user_ref_id"];
						$cookieData["batch_id"] = $bcInfo[0]["batch_id"];
						$cookieData["curriculum_slug"] = $bcInfo[0]["curriculum_slug"];
						unset($bcInfo);
						$fURL = $hdnurl;
						
					}elseif($r[0]["user_type"] == "Teacher"){
						
						$sql = "SELECT acm.lname,acm.fname,acm.email_id,acm.city_id,acm.teacher_id FROM avn_teacher_master acm INNER JOIN avn_city_master cty ON cty.unique_id = acm.city_id WHERE acm.unique_id = " . $r[0]["user_ref_id"];
						$bcInfo = $db->query("query",$sql);
						$cookieData = array();
						$cookieData["userid"] = $r[0]["userid"];
						$cookieData["emailid"] = $r[0]["emailid"];
						$cookieData["firstname"] = $r[0]["firstname"];
						$cookieData["lastname"] = $r[0]["lastname"];
						$cookieData["user_type"] = $r[0]["user_type"];
						$cookieData["user_ref_id"] = $r[0]["user_ref_id"];
						$cookieData["teacher_id"] = $bcInfo[0]["teacher_id"];
						unset($bcInfo);
						
					}elseif($r[0]["user_type"] == "Manager"){
						
						$sql = "SELECT acm.lname,acm.fname,acm.email_id,acm.city_id,acm.center_manager_id FROM avn_centermanager_master acm INNER JOIN avn_city_master cty ON cty.unique_id = acm.city_id WHERE acm.unique_id = " . $r[0]["user_ref_id"];
						$bcInfo = $db->query("query",$sql);
						$cookieData = array();
						$cookieData["userid"] = $r[0]["userid"];
						$cookieData["emailid"] = $r[0]["emailid"];
						$cookieData["firstname"] = $r[0]["firstname"];
						$cookieData["lastname"] = $r[0]["lastname"];
						$cookieData["user_type"] = $r[0]["user_type"];
						$cookieData["user_ref_id"] = $r[0]["user_ref_id"];
						$cookieData["manager_id"] = $bcInfo[0]["center_manager_id"];
						unset($bcInfo);
					}
					$encCData = $db->_encrypt(serialize($cookieData), ENCKEY);
					setcookie("userInfo", $encCData, time() + (24 * 60 * 60), "/");
					$fURL = __WEBROOT__ . "/page-redirect/";
				}
			}else
				$fURL = __WEBROOT__ . "/?resp=invpassword";
			unset($r);
		}
		else
			$fURL = __WEBROOT__ . "/?resp=invemail";
		unset($emailRS);
		//else{
		//	$fURL = __WEBROOT__ . "/?resp=inv";
		//}
		$db->close();
	}
	else
		$fURL = __WEBROOT__ . "/?resp=inv";
	header('Location: ' . $fURL);
?>