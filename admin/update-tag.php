<?php
	session_start();
	if(isset($_POST["btnUpdate"]) && $_POST["btnUpdate"] != "")
	{
		if(isset($_POST["hdstringTag"]) && $_POST["hdstringTag"] != "")
			$qryString = urldecode($_POST["hdstringTag"]);
		//$qryString .= $qryString == "" ? "?" : "&";
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();

		$dataToSave = array();
		$dataToWhere = array();
		$dataToWhere["unique_id"] = $_POST["hdCatID"];
		$dataToSave["tag_name"] = $_POST["txttagUp"];
		$r = $db->update("ltf_tags_master",$dataToSave,$dataToWhere);
		if($r["response"] != "ERROR" )
		{
			$url ="./tag.php" . $qryString;
			$_SESSION["resp"] == "up";
		}
		else
		{
			$url = "./tag.php" . $qryString;
			$_SESSION["resp"] = "invUp";
		}
		unset($r);
		$db->close();
		header('Location: ' . $url);
	}
	else
		header('Location: tag.php');
?>