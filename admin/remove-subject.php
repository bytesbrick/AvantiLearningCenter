<?php
	if(isset($_POST["btnContinue"]))
	{
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$cid = $_POST["hdCatID"];
		/*$s = $db->query("query","select unique_id from ltf_topic_master where category_id=".$cid);
		if(!array_key_exists("response", $s))
		{
			for($j=0; $j< count($s); $j++)
			{
				$tid = $s[$j]["unique_id"];
				$c = $db->query("query", "delete from ltf_resources_topic where topic_id =".$tid);
			}
		}
				$r = $db->query("query","delete from ltf_topic_master where category_id =".$cid);
		$rc = $db->query("query","delete from ltf_resources_category where category_id =".$cid);
		$n = $db->query("query","delete from ltf_category_master where unique_id =".$cid);*/
		$rc = $db->query("query","delete from ltf_resources_category where category_id =".$cid);
		$n = $db->query("query","delete from ltf_category_master where unique_id =".$cid);
		$URL = "./category.php?resp=sucdt";
		print_r($r);
	}
	else
	{
		$URL = './category.php?resp=errEd';
	}
	$db->close();
	header('Location: ' . $URL);
?>