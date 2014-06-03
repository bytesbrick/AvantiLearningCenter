<?php
	$projpath= "";
	if(isset($_POST["btnSave"]) && $_POST["btnSave"] != "")
	{
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();

		$userID = $_COOKIE["userID"];
		$txtduration = $_POST['txtduration'];
		$r = $db->query("stored procedure","sp_admin_duration_chkData('".$_POST['txtduration']."')");
		if($r["response"] != "ERROR" )
		{
			$total = $r[0]["total"];
			//echo $total;
			if($total == 0)
				{
					$r = $db->query("stored procedure", "sp_admin_duration_insert('".$_POST['txtduration']."')");
					$rURL ="./duration.php?resp=suc";
				}
			else
				{
					$rURL = './duration.php?resp=invEd';
				}
		}
	}
	else
	{
		$rURL = './duration.php?resp=errEd';
	}
	unset($r);
	$db->close();
	header('Location: ' . $rURL);
?>