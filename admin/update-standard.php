<?php
	if(isset($_POST["btnUpdate"]))
	{
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$n = $_POST["txtstandardUp"];
		$cid = $_POST["hdCatID"];
		$r = $db->query("stored procedure","sp_admin_standards_chkData('".$_POST['txtstandardUp']."')");
		if($r["response"] != "ERROR" )
		{
			$total = $r[0]["total"];
			//echo $total;
			if($total == 0)
				{
					$r = $db->query("stored procedure", "sp_admin_standards_update('".$_POST['txtstandardUp']."','".$_POST['hdCatID']."')");
					$url ="./standard.php?resp=suc";
				}
			else
				{
					$url = './standard.php?resp=invEd';
				}
		}
		else
		{
			$url = './standard.php?resp=invUp';
		}
		unset($r);
		$db->close();
		header('Location: ' . $url);
	}
	else
	{
		header('Location: standard.php');
	}
?>