<?php
	$userInfo = $_COOKIE["userInfo"];	
	if($userInfo == "")
	{
		$redPath = "./index.php?resp=loginexp";
		header("Location: " . $redPath);
	} else {
		$db = new MySqlConnection(CONNSTRING);
		$cookieData = $db->_decrypt($userInfo, ENCKEY);
		$arrUserInfo = array();
		$arrUserInfo = unserialize($cookieData);
		//print_r($arrUserInfo);
	}
?>