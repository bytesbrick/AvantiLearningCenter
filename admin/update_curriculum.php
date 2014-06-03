<?php
	if(isset($_POST["btnUpdate"]))
	{
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$txtcurriculum = $_POST["txtcurriculum"];
		$cid = $_POST["hdCatID"] . "<br />";
		
		$r = $db->query("stored procedure", "sp_avn_curriculum_update('".$txtcurriculum."','".$topic."','".$cid."')");
		//print_r($r);
			if($r["response"] == "ERROR" )
		{
			$url = './curriculum.php?resp=invUp';
		}
		else
		{
			$url ="./curriculum.php?resp=up";
		}
		unset($r);
		$db->close();
		header('Location: ' . $url);
	}
	else
	{
		header('Location: curriculum.php');
	}
?>