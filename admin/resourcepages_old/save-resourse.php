<?php
	error_reporting(0);
	ini_set("post_max_size", "15M");
	ini_set('upload_max_filesize', '15M');
	if(isset($_POST["btnSave"]) && $_POST["btnSave"] != "")
	{
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		
		$userID = $_COOKIE["userID"];
		$txttitle = $_POST['txttitle'];
		$txtintro =  $_POST['txtintro'];
		$prereading = $_POST['prereading'];
		$txtFlds =$_POST['txtFlds'];
		$rstatus = $_POST['status'];
		$txtVideoFlds = $_POST['txtVideoFlds'];
		$rchapter = $_POST['ddlchapter'];
		$rtopic = $_POST['ddltopic'];
		$rcategory = $_POST['ddlcategory'];
		$rcurriculumID= array();
		$rGradeID = array();
		$rcurriculumID= $_POST["curriculum"];
		$rGradeID = $_POST['grade'];
		$rclasswork = $_POST['classwrkTime'];
		$rhomework = $_POST['homewrkTime'];
		$rTagNm = trim($_POST['txttag']);

		$imgName1 = "";
		if(isset($_FILES["image1"]) && $_FILES["image1"]["name"] != "")
		{
			if(($_FILES["image1"]["type"] == "image/jpeg" || $_FILES["image1"]["type"] == "image/gif" || $_FILES["image1"]["type"] == "image/png" || $_FILES["image1"]["type"] == "image/jpg" || $_FILES["image1"]["type"] == "image/pjpeg") && $_FILES["image1"]["size"] <= 2097152)
			{
				$randFlName = uniqid();
				switch($_FILES["image1"]["type"])
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
				move_uploaded_file($_FILES["image1"]["tmp_name"], "./images/upload-image/". $randFlName);
				unlink("./images/upload-image/" . $imgName1 . "");
				$imgName1 = $randFlName;
			}
			else
				$imgName1 = "1";
		}
		
		$imgName2 = "";
		if(isset($_FILES["upload_file"]) && $_FILES["upload_file"]["name"] != "")
		{
			if(($_FILES["upload_file"]["type"] == "application/pdf" || $_FILES["upload_file"]["type"] == "application/zip" || $_FILES["upload_file"]["type"] == "application/x-zip-compressed" || $_FILES["upload_file"]["type"] == "application/x-zip" || $_FILES["upload_file"]["type"] == "application/x-compressed" || $_FILES["upload_file"]["type"] == "application/ppt") && $_FILES["upload_file"]["size"] <= 2097152)
			
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
					case "application/ppt":
						$randFlName2 .= ".ppt";
						break;
						
				
				}
				move_uploaded_file($_FILES["upload_file"]["tmp_name"], "./images/upload-file/". $randFlName2);
				unlink("./images/upload-file/" . $imgName2 . "");
				$imgName2 = $randFlName2;
			}
			else
				$imgName2 = "1";
		}
		
		if($imgName1 !="" && $imgName1 !="1")
		{
			//if($hactive == 1)
			//{
			//	$ha = $db->query("query", "update ltf_resources_master set  hactive = 0");
			//}
				
				$dataforfield = array();
				$dataforfield["resource_title"] = $txttitle;
				$dataforfield["resource_desc"] = $txtintro;
				$dataforfield["what_to_love"] = $prereading;
				$dataforfield["entry_date"]= "NOW()";
				$dataforfield["resource_pic"] = $imgName1;
				//$dataforfield["upload_file"] = $imgName2;
				$dataforfield["ractive"] = $rstatus;
				$dataforfield["topic_id"] = $rtopic;
				$dataforfield["chapter_id"] = $rchapter;
				$dataforfield["category_id"] = $rcategory;
				$dataforfield["classwork_hrs"] = $rclasswork;
				$dataforfield["homework_hrs"] = $rhomework;
				
				$r = $db->insert("ltf_resources_master", $dataforfield);
				
				unset($dataforfield);

			  if(array_key_exists("response", $r))
			{
				$k = $db->query("query","select MAX(unique_id) as uid FROM ltf_resources_master");
				
				for($i=0;$i<count($_POST["txtFlds"]);$i++){
					
					if(isset($_POST["txtFlds"]) && $_POST["txtFlds"]!=""){
						
					$dataforfield = array();
					$dataforfield['question_id'] = $k[0]['uid'];
					$dataforfield['question_name'] = strip_tags($_POST["txtFlds"][$i]);			
					$option = $db->insert("avn_question_master",$dataforfield);
					unset($dataforfield);
					}
				}
				
				$l = $db->query("query","select MAX(unique_id) as uid FROM ltf_resources_master");
				
				for($i=0;$i<count($_POST["txtVideoFlds"]);$i++){
					
					if(isset($_POST["txtVideoFlds"]) && $_POST["txtVideoFlds"]!=""){
					
						$dataforvideofield = array();
						$dataforvideofield['video_id'] = $l[0]['uid'];
						$dataforvideofield['video_url'] = str_replace("\\","",$_POST["txtVideoFlds"][$i]);
						$optionvideo = $db->insert("avn_video_master",$dataforvideofield);
						unset($dataforvideofield);
					}
					
				}
					$uid = $l[0]["uid"];
					
					//$uid = $r[0]["uid"];
						
						$dataToSave = array();
						$dataToSave["resource_id"] = $uid;
						$dataToSave["chapter_id"] = $rChapterID;
						$arc = $db->insert("avn_resources_chapter", $dataToSave);
					
					unset($rChapterID);
				
					foreach($rcurriculumID as $gval)
					{	
						$dataToSave = array();
						$dataToSave["resource_id"] = $uid;
						$dataToSave["curriculum_id"] = $gval;
						$rc = $db->insert("avn_resources_curriculum", $dataToSave);
					}
					
					unset($rcurriculumID);
					
					$uid = $l[0]["uid"];
					foreach($rGradeID as $gval)
					{	
						$dataToSave = array();
						$dataToSave["resource_id"] = $uid;
						$dataToSave["grade_level_id"] = $gval;
						$gr = $db->insert("ltf_resources_grade_level", $dataToSave);
						
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
								$dataToSave["resource_id"] = $uid;
								$dataToSave["tags_id"] = $tid;
								$tsr = $db->insert("ltf_resources_tags", $dataToSave);
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
									$dataToSave["resource_id"] = $uid;
									$dataToSave["tags_id"] = $tagid;
									$tgr = $db->insert("ltf_resources_tags", $dataToSave);
								//}
							}
						}
						unset($TagNm);
					}
					$url = './resourse.php?resp=suc';
			}
		}
		else
		{
			if($hactive == 1)
			{
				$ha = $db->query("query", "update ltf_resources_master set  hactive = 0");
			}
			$r = $db->query("stored procedure", "sp_admin_resourse_insert_new('".$txttitle."','".$txtintro."','".$prereading."','".$imgName1."','".$txtFlds."','".$txtVideoFlds."','".$rstatus."','".$rChapterID."')");
			
			  if(!array_key_exists("response", $r))
			{
				$k = $db->query("query","select MAX(unique_id) as uid FROM ltf_resources_master");
				for($i=0;$i<count($_POST["txtFlds"]);$i++){
					if(isset($_POST["txtFlds"]) && $_POST["txtFlds"]!=""){
					$dataforfield = array();
					$dataforfield['question_id'] = $k[0]['uid'];
					$dataforfield['question_name'] = strip_tags($_POST["txtFlds"][$i]);			
					$option = $db->insert("avn_question_master",$dataforfield);
					unset($dataforfield);
					}
				}
				
				$l = $db->query("query","select MAX(unique_id) as uid FROM ltf_resources_master");
				for($i=0;$i<count($_POST["txtVideoFlds"]);$i++){
					if(isset($_POST["txtVideoFlds"]) && $_POST["txtVideoFlds"]!=""){
						$dataforvideofield = array();
						$dataforvideofield['video_id'] = $l[0]['uid'];
						$dataforvideofield['video_url'] = strip_tags($_POST["txtVideoFlds"][$i]);			
						$option = $db->insert("avn_video_master",$dataforvideofield);
						//echo $dataforvideofield['video_url'];
						unset($dataforvideofield);
					}
				}
					$uid = $r[0]["uid"];
						
						$dataToSave = array();
						$dataToSave["resource_id"] = $uid;
						$dataToSave["chapter_id"] = $rChapterID;
						$arc = $db->insert("avn_resources_chapter", $dataToSave);
					
					unset($rChapterID);
					
					foreach($rTopic as $tval)
					{	
						$dataToSave = array();
						$dataToSave["resource_id"] = $uid;
						$dataToSave["topic_id"] = $tval;
						$t = $db->insert("ltf_resources_topic", $dataToSave);
					}
					unset($rTopic);
					foreach($rcurriculumID as $gval)
					{	
						$dataToSave = array();
						$dataToSave["resource_id"] = $uid;
						$dataToSave["curriculum_id"] = $gval;
						$rc = $db->insert("avn_resources_curriculum", $dataToSave);
						
					}
					unset($rcurriculumID);
				
					foreach($rGradeID as $gval)
					{	
						$dataToSave = array();
						$dataToSave["resource_id"] = $uid;
						$dataToSave["grade_level_id"] = $gval;
						$gr = $db->insert("ltf_resources_grade_level", $dataToSave);
					
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
								$dataToSave["resource_id"] = $uid;
								$dataToSave["tags_id"] = $tid;
								$tsr = $db->insert("ltf_resources_tags", $dataToSave);
							}
							else
							{
								$dataToSave = array();
								$dataToSave["tag_name"] = trim($tnmval);
								$dataToSave["entry_date"] = "NOW()";
								$ti = $db->insert("ltf_tags_master", $dataToSave);
								if(!array_key_exists("response", $ti))
								{
									$tm = $db->query("query", "select max(unique_id) as uid from ltf_tags_master");
									$tagid = $tm[0]["uid"];
									$dataToSave = array();
									$dataToSave["resource_id"] = $uid;
									$dataToSave["tags_id"] = $tagid;
									$tgr = $db->insert("ltf_resources_tags", $dataToSave);
								}
							}
						}
					}
					unset($TagNm);
					
			}
		}
		$db->close();
	}
	$url = './resourse.php?resp=suc';
	unset($r);
	header('Location: ' . $url);
?>