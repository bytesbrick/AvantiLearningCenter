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
		$sql = "SELECT city_prefix FROM avn_city_master WHERE unique_id = " . $_POST['ddlcity'];
		$r = $db->query("query",$sql);
		$cPref = "";
		if(!array_key_exists("response", $r)){
			$cPref = $r[0]["city_prefix"];
		}
		$sql = "SELECT COUNT(unique_id) as CenterCount FROM avn_learningcenter_master WHERE city_id = " . $_POST['ddlcity'];
		$r = $db->query("query",$sql);
		$cCount = 0;
		if(!array_key_exists("response", $r)){
			$cCount = $r[0]["CenterCount"];
			$cCount++;
		}
		if($cPref != ""){
			$datatosave = array();
			$cCode = $cCount < 10 ? $cPref . "0" . $cCount : $cPref . $cCount;
			$datatosave["center_code"] = $cCode;
			$datatosave["center_name"] = $_POST['txtcenter'];
			$datatosave["city_id"] = $_POST['ddlcity'];
			$datatosave["entry_date"] = "NOW()";
			
			$r = $db->insert("avn_learningcenter_master",$datatosave);
			//print_r($r);
			if($r["response"] != "ERROR"){
				$rURL ="./learning-center.php";
				$_SESSION["resp"] = "suc";
			}
		}
		
		$db->close();
	}
	else{
		$rURL = './learning-center.php';
		$_SESSION["resp"] = "err-add";
	}
	unset($r);
	header('Location: ' . $rURL);
?>