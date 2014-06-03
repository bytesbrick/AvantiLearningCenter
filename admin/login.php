<?php
	if(isset($_POST["txtUserID"]) && isset($_POST["txtpassword"]))
	{
		include("./includes/config.php");
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();

		$r = $db->query("stored procedure","sp_admin_login('" . $_POST['txtUserID'] . "','" . $_POST['txtpassword'] . "', '" . ENCKEY . "')");
		if(!array_key_exists("response", $r))
		{
			if($r[0]["usertype"] == "Manager"){
				$cookieData = array();
				$cookieData["userid"] = $r[0]["userid"];
				$cookieData["firstname"] = $r[0]["firstname"];
				$cookieData["lastname"] = $r[0]["lastname"];
				$cookieData["emailid"] = $r[0]["emailid"];
				$cookieData["usertype"] = $r[0]["usertype"];
				$cookieData["user_ref_id"] = $r[0]["user_ref_id"];
			}
			elseif($r[0]["usertype"] == "Teacher"){
				$cookieData = array();
				$cookieData["userid"] = $r[0]["userid"];
				$cookieData["firstname"] = $r[0]["firstname"];
				$cookieData["lastname"] = $r[0]["lastname"];
				$cookieData["emailid"] = $r[0]["emailid"];
				$cookieData["usertype"] = $r[0]["usertype"];
				$cookieData["user_ref_id"] = $r[0]["user_ref_id"];
			}
			elseif($r[0]["usertype"] == "Administrator"){
				$cookieData = array();
				$cookieData["userid"] = $r[0]["userid"];
				$cookieData["firstname"] = $r[0]["firstname"];
				$cookieData["lastname"] = $r[0]["lastname"];
				$cookieData["emailid"] = $r[0]["emailid"];
				$cookieData["usertype"] = $r[0]["usertype"];
				$cookieData["user_ref_id"] = $r[0]["user_ref_id"];
			}
			$encCData = $db->_encrypt(serialize($cookieData), ENCKEY);
			setcookie("userInfo", $encCData, time() + (24 * 60 * 60), "/");
			$userInfo = $_COOKIE["userInfo"];
			
			$fURL = "./dashboard.php";
		}
		else
		{
			$fURL = "./index.php?resp=inv";
		}
		unset($r);
		$db->close();
	}
	else
		$fURL = "./login.php?resp=noinpt";
	header('Location: ' . $fURL);	
?>