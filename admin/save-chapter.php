<?php
	session_start();
	error_reporting(0);
	if(isset($_POST["btnSave"]) && $_POST["btnSave"] != "")
	{
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$chkChp = $db->query("query","SELECT MAX(unique_id) as maxid FROM avn_chapter_master WHERE chapter_slug = '" . trim($_POST['hdslug']) . "'");
		if(!array_key_exists("response", $chkChp)){
			if($chkChp[0]["maxid"] != "")
				$slug = $_POST['hdslug'] . "-" . ($chkChp[0]["maxid"] + 1);
			else
				$slug = $_POST['hdslug'];
		}
		else
			$slug = $_POST['hdslug']; 
		$currid = $_POST["hdCurrID"];
		$chapter = $_POST['txtchapter'];
		$category = $_POST['ddlcategory'];;
		$dataToSave = array();
		$dataToSave['category_id'] = $_POST['ddlcategory'];
		$dataToSave['chapter_name'] = $_POST['txtchapter'];
		$dataToSave['chapter_slug'] = $slug;
		$dataToSave['chapter_desc'] = $_POST['txtchapterdescription'];
		$dataToSave['chapter_code'] = $_POST['txtChaptercode']; 
		$dataToSave['chapter_code'] = $_POST['chaptercode'];
		$dataToSave['entry_date'] = "now()";
		 
		$randFlName = "";
		
		if(isset($_FILES["txtchapterimage"]) && $_FILES["txtchapterimage"]["name"] != "")
		{
			if(($_FILES["txtchapterimage"]["type"] == "image/jpeg" || $_FILES["txtchapterimage"]["type"] == "image/gif" || $_FILES["txtchapterimage"]["type"] == "image/png" || $_FILES["txtchapterimage"]["type"] == "image/jpg" || $_FILES["txtchapterimage"]["type"] == "image/pjpeg") && $_FILES["txtchapterimage"]["size"] <= 2097152)
			{
				$randFlName = uniqid();
				switch($_FILES["txtchapterimage"]["type"])
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
				move_uploaded_file($_FILES["txtchapterimage"]["tmp_name"], "./images/upload-image/". $randFlName);
			}
			$dataToSave['chapter_image'] = $randFlName;
			$r = $db->insert("avn_chapter_master", $dataToSave);
		}
		if($r["response"] == "ERROR" ){
			$rURL = "./chapter.php?currid=" . $currid. "&catgid=".$category;
			$_SESSION["resp"] = "err-add";
		}
		else{
			$rURL ="./chapter.php?currid=" . $currid. "&catgid=".$category;
			$_SESSION["resp"] = "suc";
		}
		unset($r);
		$db->close();
	}
	else
	{
		$rURL = "./chapter.phpcurrid=" . $currid. "&catgid=".$category;
		$_SESSION["resp"] = "invEd";
	}
	//header('Location: ' . $rURL);