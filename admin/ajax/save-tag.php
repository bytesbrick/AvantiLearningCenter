<?php
	session_start();
	$resp ="";
	if(isset($_POST["txttag"]) && $_POST["txttag"] != "")
	{
		include("../includes/config.php");		
		include("../classes/cor.mysql.class.php");
		include("../includes/checkLogin.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$txttag = $_POST['txttag'];
		
		$tag = array();
		$tag['tag_name'] = $txttag;
		
		$r = $db->insert("ltf_tags_master",$tag);
		if($r["response"] == "SUCCESS")
			$resp = 1;
		else
			$resp = 2;
		unset($r);
		$db->close();	
	}
	else
		$resp = 0;
	echo $resp . "|#|" . $_POST["page"];	
?>