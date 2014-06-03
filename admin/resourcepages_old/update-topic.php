<?php
	if(isset($_POST["btnUpdate"])){
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		
		$dataToSave = array();
		$wheretosave = array();
		$dataToSave['chapter_id'] = $_POST['ddlchapter'];
		$dataToSave['unique_id'] = $_POST['ddltopic'];
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

		$wheretosave['unique_id'] = $_POST["hdCatID"] ;
		
		$r = $db->update("avn_topic_master",$dataToSave,$wheretosave);
		//print_r($r);
		if($r["response"] !== "ERROR" )
			$url ="./topic.php?resp=up";
			
		else
			$url = './topic.php?resp=invUp';
			
		unset($r);
		unset($dataToSave);
		unset($wheretosave);
		$db->close();
		header('Location: ' . $url);
	}
	else
		header('Location: topic.php');
?>