<?php
	session_start();
	if(isset($_POST["btnUpdate"]) && $_POST["btnUpdate"] != "")
	{
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		
		if(isset($_POST["hdnqryStringChp"]) && $_POST["hdnqryStringChp"] != "") 
			$qryString = urldecode($_POST["hdnqryStringChp"]);
		//$qryString .= $qryString == "" ? "?" : "&"; 
			
		$wheretosave = array();
		$wheretosave['unique_id'] = $_POST["hdChpID"];
		$dataToSave = array();
		$dataToSave['chapter_slug'] = $_POST['hdCurrentSlug'];
		$dataToSave['category_id']  = $_POST['ddlcategory'];
		$dataToSave['chapter_name'] = $_POST['txtchapter']; 
		$dataToSave['chapter_code'] = $_POST['chaptercode']; 
		$dataToSave['chapter_desc'] = $_POST['txtchapterdescription'];
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
					//unlink("./images/upload-image/" . $randFlName . "");
				}
					$dataToSave['chapter_image'] = $randFlName;
			}
			else
				$dataToSave['chapter_image'] = $_POST["hdChpimg"];
		$r = $db->update("avn_chapter_master",$dataToSave,$wheretosave);
		
		if($r["response"] !== "ERROR" ){
			$url ="./chapter.php".$qryString;
			$_SESSION["resp"] = "up";
		}
		else{
			$url = "./chapter.php".$qryString;
			$_SESSION["resp"] = "invUp";
		}
		unset($r);
		$db->close();
		header('Location: ' . $url);
	}
	else{
		header('Location: chapter.php');
	}
?>