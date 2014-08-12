<?php
	session_start();
	if(isset($_POST["txtgrade"]) && $_POST["txtgrade"] != ""){
		include("../includes/config.php");		
		include("../classes/cor.mysql.class.php");
		include("../includes/checkLogin.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$txtgrade = $_POST['txtgrade'];
		$dataToSave = array();
		$dataToWhere = array();
		$dataToWhere["unique_id"] = $_POST['uniqueid'];
		$dataToSave["grade_name"] = $txtgrade;
		$dataToSave["entry_date"] = "NOW()";
		$update = $db->update("ltf_grade_level_master", $dataToSave, $dataToWhere);
		if($update["response"] == "SUCCESS")
			$resp = 1;
		else
			$resp = 2;
		unset($update);
		$db->close();
	}
	else
		$resp = 0;
	echo $resp . "|#|" . $_POST["page"];
?>