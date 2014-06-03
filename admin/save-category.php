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
		$chksub = $db->query("query","SELECT MAX(unique_id) as maxid FROM ltf_category_master WHERE category_slug = '" . trim($_POST['hdslug']) . "'");
		if(!array_key_exists("response", $chksub)){
			if($chksub[0]["maxid"] != "")
				$slug = $_POST['hdslug'] . "-" . ($chksub[0]["maxid"] + 1);
			else
				$slug = $_POST['hdslug'];
		} 
		else
			$slug = $_POST['hdslug'];
		$currid = $_POST['hdCurrID'];
		$userID = $_COOKIE["userID"];
		$txtcategory = $_POST['txtcategory'];
		$txtcategory = strtoupper($_POST['prefix']);
		$datatosave["entry_date"] = "NOW()";
		$datatosave = array();
		$datatosave["category_name"] = $_POST['txtcategory'];
		$datatosave["curriculum_id"] = $_POST['ddlcurriculum'];
		$datatosave["category_slug"] = $slug;
		$datatosave["prefix"] = $_POST['prefix'];
		$datatosave["entry_date"] = "NOW()";
		$r = $db->insert("ltf_category_master",$datatosave);
		
		if($r["response"] != "ERROR" )
		{
			$rURL ="./category.php?currid=" . $currid;
			$_SESSION["resp"] = "suc";
		}
		$db->close();
	}
	else
	{
		$rURL = "./category.php?currid=" . $currid;
		$_SESSION["resp"] = "err-add";
	}
	unset($r);
	header('Location: ' . $rURL);
?>