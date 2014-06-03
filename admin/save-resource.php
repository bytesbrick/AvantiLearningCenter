<?php
	session_start();
	if(isset($_POST["hdnqryStringResource"]) && $_POST["hdnqryStringResource"] != "")
			$qryString = urldecode($_POST["hdnqryStringResource"]);
		//$qryString .= $qryString == "" ? "?" : "&"; 
	
	if(isset($_POST["btnSave"]) && $_POST["btnSave"] != "")
	{
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$topic = $_POST['hdntp'];
		$resid = $_POST['hdnres'];
		$resourcesRS = $db->query("query","SELECT MAX(unique_id) as maxid FROM avn_resources_detail WHERE topic_id = " . $topic . " AND resource_slug = '" . trim($_POST['hdSlug']) . "'");
		if(!array_key_exists("response", $resourcesRS)){
			if($resourcesRS[0]["maxid"] != "")
				$slug = $_POST['hdSlug'] . "-" . ($resourcesRS[0]["maxid"] + 1);
			else
				$slug = $_POST['hdSlug'];
		}
		else
			$slug = $_POST['hdSlug'];
		$resources = $db->query("query","SELECT MAX(priority) as maxpriority FROM avn_resources_detail WHERE topic_id = " . $topic );
		$forfirst = $resources[0]['maxpriority'];
		$fornext = $forfirst + 1;
		$tp = $_POST['hdntp'];
		$intro = str_replace("\\","",$_POST["txtContentIntro"]);
		
		$datatosave = array(); 
		$datatosave['priority'] = $fornext;
		$datatosave['topic_id'] = $_POST['hdntp'];
		$datatosave['title'] = $_POST['resourcetitle'];
		$datatosave['resource_slug'] = $slug;
		$datatosave['text'] = htmlspecialchars_decode($intro);
		$datatosave['entry_date'] = "NOW()";
		$r = $db->insert("avn_resources_detail",$datatosave);
		if($r["response"] !== "ERROR"){
			$rURL ="./resource.php" . $qryString;
			$_SESSION["resp"] = "suc";
		}
		else{
			$rURL = "./resource.php" . $qryString;
			$_SESSION["resp"] = "invEd";
		}
		$db->close();
	}
	else{
		$rURL = "./resource.php" . $qryString;
		$_SESSION["resp"] = "errEd";
	}
	unset($r);
	header('Location: ' . $rURL);
?>