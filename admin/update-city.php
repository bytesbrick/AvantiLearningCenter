<?php
	session_start();
	$projpath= "";
	$result = 0;
	if(isset($_POST["btnSave"]) && $_POST["btnSave"] != "")
	{
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();	
		$datatosave = array();
		$datatosave["city_name"] = $_POST['txtcity'];
		$datatowhere = array();
		$datatowhere["unique_id"] = $_POST['hdncityid'];
		$datatosave["city_prefix"] = strtoupper($_POST['txtcityprefix']);
		$datatosave["entry_date"] = "NOW()";
		$r = $db->update("avn_city_master",$datatosave , $datatowhere);
		if($r["response"] != "ERROR"){
			$rURL ="./city.php";
			$_SESSION["resp"] = "up";
		}
		$db->close();
	}
	else{
		$rURL = './city.php';
			$_SESSION["resp"] = "err-add";
	}
	unset($r);
	header('Location: ' . $rURL);
?>