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

		$userID = $_COOKIE["userID"];
		$txtgrade = $_POST['txtgrade'];
		$r = $db->query("stored procedure","sp_admin_grade_chkData('".$_POST['txtgrade']."')");
		if($r["response"] != "ERROR" )
		{
			$total = $r[0]["total"];
			//echo $total;
			if($total == 0)
				{
					$r = $db->query("stored procedure", "sp_admin_grade_insert('".$_POST['txtgrade']."')");
					$rURL ="./grade.php";
					$_SESSION["resp"] = "suc";
				}
			else
				{
					$rURL = './grade.php';
					$_SESSION["resp"] = "invEd";
				}
		}
	}
	else
	{
		$rURL = './grade.php';
		$_SESSION["resp"] = "errEd";
	}
	unset($r);
	$db->close();
	header('Location: ' . $rURL);
?>