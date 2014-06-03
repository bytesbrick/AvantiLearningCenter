<?php
	$resp = "";
	if(isset($_POST["unique_id"]) && $_POST["unique_id"] != "")
	{
		include_once("../includes/config.php");		
		include_once("../classes/cor.mysql.class.php");
	
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$r =$db->query("query","Select unique_id,batch_name from avn_batch_master where learning_center = " . $_POST["unique_id"] . " ORDER BY batch_name");
		if(!array_key_exists("response", $r)){
			if(!$r["response"] == "ERROR"){
				$resp = "<option value=''>Select one</option>";
				for($i=0; $i< count($r); $i++)
					$resp .= "<option value='".$r[$i]["unique_id"]."'>" . $r[$i]["batch_name"] . "</option>";
				$resp .= "|#|" . $_POST["unique_id"];
			}
		} 
		else
			$resp .= "<option value=>No batches</option>";
			unset($r);
			$db->close();
	}
	else
		$resp = "Bad Parameter";
	echo $resp;
?>