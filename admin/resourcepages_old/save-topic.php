<?php
	include("./includes/config.php");		
	include("./classes/cor.mysql.class.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
	$projpath= "";
	$result = 0;
	if(isset($_POST["btnSave"]) && $_POST["btnSave"] != "")
	{
		$userID = $_COOKIE["userID"];
		$txttopic = $_POST['txttopic'];
		
		$dataToSave= array();
		
		$dataToSave['chapter_id'] =  $_POST['ddlchapter'];
		$dataToSave['topic_name'] = $_POST['txttopic'];
		$dataToSave['topic_desc'] = $_POST['topicdesc'];
		
		$randFlName = "";
			if(isset($_FILES["topicimage"]) && $_FILES["topicimage"]["name"] != "")
			{
				
				if(($_FILES["topicimage"]["type"] == "image/jpeg" || $_FILES["topicimage"]["type"] == "image/gif" || $_FILES["topicimage"]["type"] == "image/png" || $_FILES["topicimage"]["type"] == "image/jpg" || $_FILES["topicimage"]["type"] == "image/pjpeg") && $_FILES["topicimage"]["size"] <= 2097152)
				{
					$randFlName =  uniqid();
					switch($_FILES["topicimage"]["type"])
					{
						case "image/gif":
							$randFlName .= ".gif";
							break;
						case "image/jpeg":
						case "image/pjpeg":
						case "image/jpg":
							$randFlName .= ".jpg";
							break;
						case "image/png":
							$randFlName .= ".png";
							break;
						default:
							$randFlName .= ".png";
							break;
					}
					move_uploaded_file($_FILES["topicimage"]["tmp_name"], "./images/upload-image/". $randFlName);
				}
			}
		$dataToSave['topic_image'] = $randFlName;
		$r = $db->insert(avn_topic_master,$dataToSave);
		if($r["response"] !== "ERROR" )
		{
		
			$rURL ="./topic.php?resp=suc";
		}
		else
		{
			$rURL = './topic.php?resp=invEd';
		}
	}
	else
	{
		$rURL = './topic.php?resp=errEd';
	}
	unset($r);
	$db->close();
	header('Location: ' . $rURL);
?>