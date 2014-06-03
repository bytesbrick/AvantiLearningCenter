<?php
	session_start();
	include("./includes/config.php");		
	include("./classes/cor.mysql.class.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
	if(isset($_POST["hdnqryStringTopic"]) && $_POST["hdnqryStringTopic"] != "")
		$qryString = $_POST["hdnqryStringTopic"];
		//$qryString .= $qryString == "" ? "?" : "&"; 
	
	if(isset($_POST["btnSave"]) && $_POST["btnSave"] != "")
	{		
		$dataToSave= array();
		$chktopic = $db->query("query","SELECT MAX(unique_id) as maxid FROM avn_topic_master WHERE topic_slug = '" . trim($_POST['hdslug']) . "'");
		if(!array_key_exists("response", $chktopic)){
			if($chktopic[0]["maxid"] != "")
				$slug = $_POST['hdslug'] . "-" . ($chktopic[0]["maxid"] + 1);
			else
				$slug = $_POST['hdslug'];
		}
		else
			$slug = $_POST['hdslug'];
		$chapter = $_POST['ddlchapter']; 
		$category = $_POST['ddlcategory'];
		$dataToSave['chapter_id'] = $chapter;
		$dataToSave['topic_name'] = $_POST['txttopic'];
		$dataToSave['topic_slug'] = $slug;
		$resources = $db->query("query","SELECT MAX(topic_priority) as maxpriority FROM avn_topic_master WHERE chapter_id = " . $chapter);
		if(!array_key_exists("response", $resources)){
			$forfirst = $resources[0]['maxpriority'];
			$fornext = $forfirst + 1;
		}
		else
			$fornext = 1;
		$dataToSave['topic_priority'] = $fornext;
		$dataToSave['topic_desc'] = $_POST['topicdesc'];
		$dataToSave['topic_code'] = $_POST['CodeTopic'];
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
		$rTagNm = trim($_POST['txttag']);
		$rGradeID = array();
		$rGradeID = $_POST['grade'];

		$dataToSave['classwork_hrs'] = $_POST['classwrkTime'];
		$dataforresource["entry_date"] = "NOW()";
		$dataToSave['homework_hrs'] = $_POST['homewrkTime'];
		$dataToSave['topic_image'] = $randFlName;
		
		$imgName2 = "";
		if(isset($_FILES["upload_file"]) && $_FILES["upload_file"]["name"] != "")
		{
			if(($_FILES["upload_file"]["type"] == "application/vnd.ms-powerpoint" || $_FILES["upload_file"]["type"] == "application/vnd.openxmlformats-officedocument.presentationml.presentation" || $_FILES["upload_file"]["type"] == "application/zip" || $_FILES["upload_file"]["type"] == "application/x-zip-compressed" || $_FILES["upload_file"]["type"] == "application/x-zip" || $_FILES["upload_file"]["type"] == "application/x-compressed" || $_FILES["upload_file"]["type"] =="application/pdf") && $_FILES["upload_file"]["size"] <= 2097152)
			{
				$randFlName2 = uniqid();
				switch($_FILES["upload_file"]["type"])
				{
					case "application/zip":
					case "application/x-zip-compressed":
					case "application/x-zip":
					case "application/x-compressed":
						$randFlName2 .= ".zip";
						break;
					case "application/pdf":
						$randFlName2 .= ".pdf";
						break;
					case "application/vnd.ms-powerpoint":
						$randFlName2 .= ".ppt";
						break;
					case "application/vnd.openxmlformats-officedocument.presentationml.presentation":
						$randFlName2 .= ".pptx";
						break;
				}
				move_uploaded_file($_FILES["upload_file"]["tmp_name"], "./images/upload-file/". $randFlName2);
				unlink("./images/upload-file/" . $imgName2 . "");
				$imgName2 = $randFlName2;
			}
			else
				$imgName2 = "1";
		}
		else
			$imgName2 = "0";
		$dataToSave['upload_file'] = $imgName2;
		$topic = $db->insert("avn_topic_master", $dataToSave);
		$l = $db->query("query","SELECT MAX(unique_id) as 'uid' FROM avn_topic_master");
		$uid = $l[0]["uid"];
	 
		foreach($rGradeID as $gval)
		{	
			$dataToSave = array();
			$dataToSave["topic_id"] = $uid;
			$dataToSave["grade_id"] = $gval;
			$gr = $db->insert("avn_topic_grades", $dataToSave);
		}
		unset($rGradeID);
		
		if($rTagNm != "")
		{
			$TagNm = explode(",", $rTagNm);
			foreach($TagNm as $tnmval)
			{
				$ts = $db->query("query", "select unique_id from ltf_tags_master where tag_name = '" . trim($tnmval) . "'");
				if(!array_key_exists("response", $ts))
				{
					$tid = $ts[0]["unique_id"];
					$dataToSave = array();
					$dataToSave["topic_id"] = $uid;
					$dataToSave["tags_id"] = $tid;
					
					$tsr = $db->insert("avn_topic_tags", $dataToSave);
				}
				else
				{
					$dataToSave = array();
					$dataToSave["tag_name"] = trim($tnmval);
					$dataToSave["entry_date"] = "NOW()";
					$ti = $db->insert("ltf_tags_master", $dataToSave);
					//if(!array_key_exists("response", $ti))
					//{
						$tm = $db->query("query", "select max(unique_id) as uid from ltf_tags_master");
						$tagid = $tm[0]["uid"];
						$dataToSave = array();
						$dataToSave["topic_id"] = $uid;
						$dataToSave["tags_id"] = $tagid;
						$tgr = $db->insert("avn_topic_tags", $dataToSave);
					//}
				}
			}
			unset($TagNm);
		} 
		if($r["response"] != "ERROR")
		{
			$rURL ="./topic.php". $qryString;
			$_SESSION["resp"] = "resp=suc";
		}
		else 
		{
			$rURL = "./topic.php". $qryString;
			$_SESSION["resp"] = "resp=invEd";
		}
	}
	else
	{
		$rURL = "./topic.php". $qryString;
		$_SESSION["resp"] = "resp=errEd";
	}
	unset($r);
	$db->close();
	header('Location: ' . $rURL); 
?>