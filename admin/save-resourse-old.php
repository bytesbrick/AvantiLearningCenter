<?php
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
		$txtdescription = $_POST['txtdescription'];
		$txtwhatlove = $_POST['txtwhatlove'];
		$txtimprove = $_POST['txtimprove'];
		$txtstart = $_POST['txtstart'];
		$txtexternal = $_POST['txtexternal'];
		$rTopicID = array();
		$rTopicID = $_POST["topic"]; 
		$rConsumerID = array();
		$rConsumerID = $_POST['consumer'];
		$rGradeID = array();
		$rGradeID = $_POST['grade'];
		$rMediaID = array();
		$rMediaID = $_POST['media'];
		$rStandard = array();
		$rStandard = $_POST['standard'];
		$rCostID = array();
		$rCostID = $_POST['cost'];
		$rDurationID = array();
		$rDurationID = $_POST['duration'];

		$imgName1 = "";
			if(isset($_FILES["image1"]) && $_FILES["image1"]["name"] != "")
			{
				if(($_FILES["image1"]["type"] == "image/jpeg" || $_FILES["image1"]["type"] == "image/gif" || $_FILES["image1"]["type"] == "image/png" || $_FILES["image1"]["type"] == "image/jpg" || $_FILES["image1"]["type"] == "image/pjpeg") && $_FILES["image1"]["size"] <= 2097152)
				{
					$randFlName = mysql_real_escape_string($txttitle) . "-". uniqid();
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
					$imgName1 = $randFlName;
				}
				else
					$imgName1 = "1";
			}
		if($imgName1 !="" && $imgName1 !="1")
		{
			$r = $db->query("stored procedure", "sp_admin_resourse_insert('".$_POST['txttitle']."','".$_POST['txtdescription']."','".$_POST['txtwhatlove']."','".$_POST['txtimprove']."','".$_POST['txtstart']."','".$_POST['txtexternal']."','".$imgName1."')");
			//$n =$db->query("stored procedure","sp_admin_resourse_max()");
			  if($r["response"] != "ERROR")
			  {
				    $uid = $r[0]["uid"];
				    foreach($rTopicID as $tval)
					{
						$dataToSave = array();
						$dataToSave["resource_id"] = $uid;
						$dataToSave["topic_id"] = $tval;
						$t = $db->insert("ltf_resources_topic", $dataToSave);
					}
					unset($rTopicID);
					foreach($rConsumerID as $cval)
					{	
						$dataToSave = array();
						$dataToSave["resource_id"] = $uid;
						$dataToSave["consumer_type_id"] = $cval;
						$t = $db->insert("ltf_resources_consumer_type", $dataToSave);
					}
					unset($rConsumerID);
					foreach($rGradeID as $gval)
					{	
						$dataToSave = array();
						$dataToSave["resource_id"] = $uid;
						$dataToSave["grade_level_id"] = $gval;
						$t = $db->insert("ltf_resources_grade_level", $dataToSave);
					}
					unset($rGradeID);
					foreach($rMediaID as $mval)
					{	
						$dataToSave = array();
						$dataToSave["resource_id"] = $uid;
						$dataToSave["media_type_id"] = $mval;
						$t = $db->insert("ltf_resources_media_type", $dataToSave);
					}
					unset($rMediaID);
					foreach($rStandard as $sval)
					{	
						$dataToSave = array();
						$dataToSave["resource_id"] = $uid;
						$dataToSave["standards_id"] = $sval;
						$t = $db->insert("ltf_resources_standards", $dataToSave);
					}
					unset($rStandard);
					foreach($rCostID as $cidval)
					{	
						$dataToSave = array();
						$dataToSave["resource_id"] = $uid;
						$dataToSave["cost_id"] = $cidval;
						$t = $db->insert("ltf_resources_cost", $dataToSave);
					}
					unset($rCostID);
					foreach($rDurationID as $dval)
					{	
						$dataToSave = array();
						$dataToSave["resource_id"] = $uid;
						$dataToSave["duration_id"] = $dval;
						$t = $db->insert("ltf_resources_duration", $dataToSave);
					}
					unset($rDurationID);
					$url = './resourse.php?resp=suc';
			  }
		}
		else
		{
			$url = './resourse.php?resp=inv';
		}

	}
	else
	{
		$url = './resourse.php?resp=errEd';
	}
	unset($r);
	$db->close();
	header('Location: ' . $url);
?>