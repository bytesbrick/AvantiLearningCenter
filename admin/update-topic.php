<?php
	session_start();
	if(isset($_POST["btnUpdate"])){
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		
		if(isset($_POST["hdnqryStringTopic"]) && $_POST["hdnqryStringTopic"] != "")
			$qryString = $_POST["hdnqryStringTopic"];
		//$qryString .= $qryString == "" ? "?" : "&";
		
		$uid = $_POST["hdtpID"];
			
		$rTagNm = trim($_POST['txttag']);
		$rGradeID = array();
		$rcurriculumID= array();
		$rChapterID = $_POST['ddlchapter'];
		$rCategoryID = $_POST['ddlcategory'];
		$rcurriculumID= $_POST["curriculum"];
		$rGradeID = $_POST['grade'];
		
		$dataToSave = array(); 
		$wheretosave = array();
		$dataToSave['chapter_id'] = $_POST['ddlchapter'];
		$dataToSave['unique_id'] = $_POST['ddltopic'];
		$dataToSave['topic_desc'] = $_POST['topicdesc'];
		$dataToSave['topic_code'] = $_POST['txttopiccode'];
		$dataToSave['topic_slug'] = $_POST['hdCurrentSlug']; 
		$topicsel = $db->query("query","SELECT * from avn_topic_master where unique_id = " . $_POST['ddltopic']);
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
					unlink("./images/upload-image/" . $randFlName . "");
				}
				$dataToSave['topic_image'] = $randFlName;
			}
			else
				$dataToSave['topic_image'] = $_POST['hdnimage'];

		$imgName2 = "";
		if(isset($_FILES["upload_file"]) && $_FILES["upload_file"]["name"] != "")
		{
			if(($_FILES["upload_file"]["type"] == "application/pdf" || $_FILES["upload_file"]["type"] == "application/zip" || $_FILES["upload_file"]["type"] == "application/x-zip-compressed" || $_FILES["upload_file"]["type"] == "application/x-zip" || $_FILES["upload_file"]["type"] == "application/x-compressed" || $_FILES["upload_file"]["type"] =="application/vnd.ms-powerpoint" || $_FILES["upload_file"]["type"] == "application/vnd.openxmlformats-officedocument.presentationml.presentation") && $_FILES["upload_file"]["size"] <= 2097152)
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
				unlink("./images/upload-file/" . $randFlName2 . "");
				$imgName2 = $randFlName2;
			}
			else
				$imgName2 = "1";
		}
	
		$wheretosave['unique_id'] = $_POST["hdtpID"] ;
		$dataToSave["upload_file"] = $imgName2;
		$dataToSave["status"] = $_POST['status'];
		$dataToSave["chapter_id"] = $_POST['ddlchapter'];
		$dataToSave["classwork_hrs"] = $_POST['classwrkTime'];
		$dataToSave["homework_hrs"] = $_POST['homewrkTime'];
		
		$r = $db->update("avn_topic_master",$dataToSave,$wheretosave);
		$tg = $db->query("stored procedure","sp_admin_Rtag_delete('" . $_POST["hdtpID"] . "')");
		$tpgrade = $db->query("query","DELETE FROM avn_topic_grades WHERE topic_id = " . $_POST["hdtpID"]);

		foreach($rGradeID as $gval)
		{	
			$dataToSave = array();
			$dataToSave["topic_id"] = $_POST["hdtpID"]; 
			$dataToSave["grade_id"] = $gval;
			$t = $db->insert("avn_topic_grades", $dataToSave);
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
					$dataToSave["topic_id"] = $_POST["hdtpID"];
					$dataToSave["tags_id"] = $tid;
					
					$tsr = $db->insert("avn_topic_tags", $dataToSave);
				}
				else
				{
					$dataToSave = array();
					$dataToSave["tag_name"] = trim($tnmval);
					$dataToSave["entry_date"] = "NOW()";
					$ti = $db->insert("ltf_tags_master", $dataToSave);
					if(!array_key_exists("response", $ti))
					{
						$tm = $db->query("query", "select max(unique_id) as unique_id from ltf_tags_master");
						$tagid = $tm[0]["unique_id"];
						$dataToSave = array();
						$dataToSave["topic_id"] = $_POST["hdtpID"];
						$dataToSave["tags_id"] = $tagid;
						$tgr = $db->insert("avn_topic_tags", $dataToSave);
					}	
				}
			}
		}
		if($r["response"] !== "ERROR" ){
			$url ="./topic.php" . $qryString;
			$_SESSION["resp"] = "up";
		}
		else{
			$url = "./topic.php" . $qryString;
			$_SESSION["resp"] = "invUp";
		}
		unset($r);
		unset($dataToSave);
		unset($wheretosave);
		$db->close();
		header('Location: ' . $url);
	}
	else
		header('Location: topic.php');
?> 