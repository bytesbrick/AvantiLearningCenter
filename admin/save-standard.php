<?php
	$projpath= "";
	$result = 0;
	if(isset($_POST["btnSave"]) && $_POST["btnSave"] != "")
	{
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();

		$userID = $_COOKIE["userID"];
		$txtstandard = $_POST['txtstandard'];
		$r = $db->query("stored procedure","sp_admin_standards_chkData('".$_POST['txtstandard']."')");
		if($r["response"] != "ERROR" )
		{
			$total = $r[0]["total"];
			echo $total;
			if($total == 0)
				{
					$r = $db->query("stored procedure", "sp_admin_standards_insert('".$_POST['txtstandard']."')");
					$rURL ="./standard.php?resp=suc";
				}
			else
				{
					$rURL = './standard.php?resp=invEd';
				}
		}
	}
	else
	{
		$rURL = './standard.php?resp=errEd';
	}
	unset($r);
	$db->close();
	header('Location: ' . $rURL);
?>