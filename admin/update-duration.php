<?php
	if(isset($_POST["btnUpdate"]))
	{
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$n = $_POST["txtdurationUp"];
		$cid = $_POST["hdCatID"];
		$r = $db->query("stored procedure","sp_admin_duration_chkData('".$_POST['txtdurationUp']."')");
		if($r["response"] != "ERROR" )
		{
			$total = $r[0]["total"];
			//echo $total;
			if($total == 0)
				{
					$r = $db->query("stored procedure", "sp_admin_duration_update('".$_POST['txtdurationUp']."','".$_POST['hdCatID']."')");
					$url ="./duration.php?resp=suc";
				}
			else
				{
					$url = './duration.php?resp=invEd';
				}
		}
		else
		{
			$url = './duration.php?resp=invUp';
		}
		unset($r);
		$db->close();
		header('Location: ' . $url);
	}
	else
	{
		header('Location: duration.php');
	}
?>