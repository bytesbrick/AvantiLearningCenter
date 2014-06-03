<?php
	session_start();
	include("./includes/config.php");		
	include("./classes/cor.mysql.class.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
	
	if(isset($_POST["btnSave"]) && $_POST["btnSave"] != "")
	{
		$userID = $_COOKIE["userID"];
		$txttag = $_POST['txttag'];
		
		$tag = array();
		$tag['tag_name'] = $txttag;
		
		$r = $db->insert("ltf_tags_master",$tag);
		
		if($r["response"] != "ERROR" )
		{
			$rURL ="./tag.php";
			$_SESSION["resp"] = "suc";
		}
		else
		{
			$rURL = './tag.php';
			$_SESSION["resp"] = "invEd";
		}
	}
	else
	{
		$rURL = './tag.php';
		$_SESSION["resp"] = "errEd";
	}
	unset($r);
	$db->close();
	header('Location: ' . $rURL);
?>