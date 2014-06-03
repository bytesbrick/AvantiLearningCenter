<?php
$resp= "";
	if(isset($_POST["emailid"]) && isset($_POST["password"]))
	{
		include("../includes/config.php");		
		include("../classes/cor.mysql.class.php");

		$uName = $_POST["emailid"];
		$pwd = $_POST["password"];

		$db = new MySqlConnection(CONNSTRING);
		$db->open();

		$r = $db->query("stored procedure","sp_admin_login('".$_POST['emailid']."','".$_POST['password']."')");

		if($r["response"] != "ERROR" )
		{		
			setCookie("userID", $r[0]["userid"]);
			setCookie("cUserID", $r[0]["emailid"]);
			setCookie("cUserName", $r[0]["firstname"]);
			setCookie("cUserType", $r[0]["usertype"]);
			//$fURL = "./dashboard.php";
			$resp = 1;
		}
		else
			$resp = 2;
		//{
		//	$fURL = "./index.php?resp=inv";
		//}
		
		unset($r);
		$db->close();
	}
	else
		$resp = 0;
	echo $resp;
		//$fURL = "./login.php?resp=noinpt";
	//header('Location: ' . $fURL);	
?>