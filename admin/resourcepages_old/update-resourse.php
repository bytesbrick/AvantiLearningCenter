<?php
	if(isset($_POST["btnUpdate"]))
	{
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$userID = $_COOKIE["userID"];
		$uid = $_POST["hdUidID"];
		$txttitle = $_POST['txttitle'];
		$txtintro =  $_POST['txtintro'];
		$prereading = $_POST['prereading'];
		$txtFlds = $_POST['txtFlds'];
		$rstatus = $_POST['status'];
		$rTopic = $_POST['ddltopic'];
		$rcategory = $_POST['ddlcategory'];
		$rGradeID = array();
		$rcurriculumID= array();
		$rChapterID = $_POST['ddlchapter'];
		$rcurriculumID= $_POST["curriculum"];
		$rGradeID = $_POST['grade'];
		$txtVideoFlds =$_POST['txtVideoFlds'];
		$rTagNm = trim($_POST['txttag']);
		$imgName1 =  $_POST['hdnimage'];
		$rclasswork = $_POST['classwrkTime'];
		$rhomework = $_POST['homewrkTime'];
	
			if(isset($_FILES["image1"]) && $_FILES["image1"]["name"] != "")
			{
				if(($_FILES["image1"]["type"] == "image/jpeg" || $_FILES["image1"]["type"] == "image/gif" || $_FILES["image1"]["type"] == "image/png" || $_FILES["image1"]["type"] == "image/jpg" || $_FILES["image1"]["type"] == "image/pjpeg") && $_FILES["image1"]["size"] <= 2097152)
				{
					$randFlName =  uniqid();
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
			if(($_FILES["upload_file"]["type"] == "application/pdf" || $_FILES["upload_file"]["type"] == "application/zip" || $_FILES["upload_file"]["type"] == "application/x-zip-compressed" || $_FILES["upload_file"]["type"] == "application/x-zip" || $_FILES["upload_file"]["type"] == "application/x-compressed" || $_FILES["upload_file"]["type"] == "application/vnd.ms-powerpoint") && $_FILES["upload_file"]["size"] <= 2097152)
			
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
			
			//$n = $db->query("stored procedure","sp_admin_resourse_WImg_update_new('".$txttitle."','".$txtintro."','".$prereading."','".$imgName1."','".$txtFlds."','".$txtVideoFlds."','".$rstatus."','".$_POST['hdUidID']."')");
				$dataforfield = array();
				
				$dataforfield["resource_title"] = $txttitle;
				$dataforfield["resource_desc"] = $txtintro;
				$dataforfield["what_to_love"] = $prereading;
				$dataforfield["entry_date"]= "NOW()";
				$dataforfield["resource_pic"] = $imgName1;
				$dataforfield["upload_file"] = $imgName2;
				$dataforfield["ractive"] = $rstatus;
				$dataforfield["topic_id"] = $rTopic;
				$dataforfield["chapter_id"] = $rChapterID;
				$dataforfield["category_id"] = $rcategory;
				$dataforfield["classwork_hrs"] = $rclasswork;
				$dataforfield["homework_hrs"] = $rhomework;
				
				$wheretosave  = array();
				$wheretosave["unique_id"] = $_POST['hdUidID'];
				
				$n = $db->update("ltf_resources_master",$dataforfield,$wheretosave);
				
			$dataToWhereforfield = array();
			$dataToWhereforfield['question_id'] = $_POST['hdUidID'];
			
			$dlt = $db->delete("avn_question_master",$dataToWhereforfield);
			$k = $db->query("query","select MAX(unique_id) as uid FROM ltf_resources_master");
				for($i=0;$i<count($_POST["txtFlds"]);$i++){
					if($_POST["txtFlds"][$i] != ""){
					$dataToWhereforfield = array();
					$dataToWhereforfield['question_id'] = $_POST['hdUidID'];
					$dataToWhereforfield['question_name'] = $_POST["txtFlds"][$i];
					$option = $db->insert("avn_question_master",$dataToWhereforfield);
					}
				}
				unset($dataToWhereforfield);
				
			$dataToWhereforVideofield = array();
			$dataToWhereforVideofield['video_id'] = $_POST['hdUidID'];
			
			$vddlte = $db->delete("avn_video_master",$dataToWhereforVideofield);
			$vd = $db->query("query","select MAX(unique_id) as uid FROM ltf_resources_master");
				for($i=0;$i<count($_POST["txtVideoFlds"]);$i++){
					if($_POST["txtVideoFlds"][$i] != ""){
					$dataToWhereforVideofield = array();
					$dataToWhereforVideofield['video_id'] = $_POST['hdUidID'];
					$video =  str_replace("\\","",$_POST["txtVideoFlds"][$i]);;
					$dataToWhereforVideofield['video_url'] = $video;
					$videoption = $db->insert("avn_video_master",$dataToWhereforVideofield);
					}
				}
				unset($dataToWhereforVideofield);
				
			$tg = $db->query("stored procedure","sp_admin_Rtag_delete('".$uid."')");
			$t = $db->query("stored procedure","sp_admin_Rtopic_delete('".$uid."')");
			$d = $db->query("stored procedure","sp_admin_Rcategory_delete('".$uid."')");
			$g = $db->query("stored procedure","sp_admin_Rgrade_delete('".$uid."')");
			$k = $db->query("query","delete from avn_resources_curriculum where resource_id=".$uid);
			$j= $db->query("query","delete from avn_resources_chapter where resource_id=".$uid);
			$l= $db->query("query","delete from avn_resources_master where unique_id=".$uid);
			
				
				$dataToSave = array();
				$dataToSave["resource_id"] = $uid;
				$dataToSave["chapter_id"] = $rChapterID;
				$t = $db->insert("avn_resources_chapter", $dataToSave);
					
				unset($dataToSave);
			
			
			
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
					$t = $db->insert("avn_resources_curriculum", $dataToSave);
				}
				unset($rcurriculumID);
			foreach($rGradeID as $gval)
				{	
					$dataToSave = array();
					$dataToSave["resource_id"] = $uid;
					$dataToSave["grade_level_id"] = $gval;
					$t = $db->insert("ltf_resources_grade_level", $dataToSave);
				}
				unset($rGradeID);
			
			if($rTagNm != "")
			{
				$TagNm = explode(",", $rTagNm);
				foreach($TagNm as $tnmval)
				{
					$ts = $db->query("query", "select unique_id from ltf_tags_master where tag_name = '" . trim($tnmval) . "'");
					//print_r($ts);
					if(!array_key_exists("response", $ts))
					{
						$tid = $ts[0]["unique_id"];
						$dataToSave = array();
						$dataToSave["resource_id"] = $uid;
						$dataToSave["tags_id"] = $tid;
						$tsr = $db->insert("ltf_resources_tags", $dataToSave);
						//print_r($tsr);
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
							$dataToSave["resource_id"] = $uid;
							echo $dataToSave["resource_id"];
							$dataToSave["tags_id"] = $tagid;
							$tgr = $db->insert("ltf_resources_tags", $dataToSave);
							
						}	
					}
				}
			}
			
			$url = './resourse.php?resp=up';
			unset($n);
		}
		else
		{
			$n = $db->query("stored procedure","sp_admin_resourse_update_new('".$txttitle."','".$txtintro."','".$prereading."','".$imgName1."','".$txtFlds."','".$txtVideoFlds."','".$rstatus."','".$_POST['hdUidID']."')");
			
			$dataToWhereforfield = array();
			$dataToWhereforfield['question_id'] = $_POST['hdUidID'];
			$dlt = $db->delete("avn_question_master",$dataToWhereforfield);
			$k = $db->query("query","select MAX(unique_id) as uid FROM ltf_resources_master");
			
				for($i=0;$i<count($_POST["txtFlds"]);$i++){
					if($_POST["txtFlds"][$i] != ""){
					$dataToWhereforfield = array();
					$dataToWhereforfield['question_id'] = $k[0]['uid'];
					$dataToWhereforfield['question_name'] = strip_tags($_POST["txtFlds"][$i]);
					$option = $db->insert("avn_question_master",$dataToWhereforfield);
					
					unset($option);
					}
				}
			unset($dataToWhereforfield);
			
			$dataToWhereforVideofield = array();
			$dataToWhereforVideofield['video_id'] = $_POST['hdUidID'];
			
			$vddlte = $db->delete("avn_video_master",$dataToWhereforVideofield);
			$vd = $db->query("query","select MAX(unique_id) as uid FROM ltf_resources_master");
				for($i=0;$i<count($_POST["txtVideoFlds"]);$i++){
					if($_POST["txtVideoFlds"][$i] != ""){
					$dataToWhereforVideofield = array();
					$dataToWhereforVideofield['video_id'] = $k[0]['uid'];
					$video = str_replace($_POST["txtVideoFlds"][$i]);
					$dataToWhereforVideofield['video_url'] = $video;
					$option = $db->insert("avn_video_master",$dataToWhereforVideofield);
					}
				}
				unset($dataToWhereforVideofield);
			
			$tg = $db->query("stored procedure","sp_admin_Rtag_delete('".$uid."')");
			$t = $db->query("stored procedure","sp_admin_Rtopic_delete('".$uid."')");
			$d = $db->query("stored procedure","sp_admin_Rcategory_delete('".$uid."')");
			$g = $db->query("stored procedure","sp_admin_Rgrade_delete('".$uid."')");
			$k = $db->query("query","delete from avn_resources_curriculum where resource_id=".$uid);
			$j= $db->query("query","delete from avn_resources_chapter where resource_id=".$uid);
			$l= $db->query("query","delete from avn_resources_master where unique_id=".$uid);
			
				
				$dataToSave = array();
				$dataToSave["resource_id"] = $uid;
				$dataToSave["chapter_id"] = $rChapterID;
				$t = $db->insert("avn_resources_chapter", $dataToSave);
					
				unset($dataToSave);
			
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
						$t = $db->insert("avn_resources_curriculum", $dataToSave);
					}
					unset($rcurriculumID);
					
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
							$tm = $db->query("query", "select max(unique_id) as unique_id from ltf_tags_master");
							$tagid = $tm[0]["unique_id"];
							$dataToSave = array();
							$dataToSave["resource_id"] = $uid;
							$dataToSave["tags_id"] = $tagid;
							$tgr = $db->insert("ltf_resources_tags", $dataToSave);
						}	
					}
				}
			}
			$url = './resourse.php?resp=up';
		}
		
		unset($n);
		$db->close();
		header('Location: ' . $url);
	}
	else
	{
		header('Location: resourse.php');
	}
?>