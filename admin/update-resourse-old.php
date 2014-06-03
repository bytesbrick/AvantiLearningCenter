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
			$n = $db->query("stored procedure","sp_admin_resourse_WImg_update('".$_POST['txttitle']."','".$_POST['txtdescription']."','".$_POST['txtwhatlove']."','".$_POST['txtimprove']."','".$_POST['txtstart']."','".$_POST['txtexternal']."','".$imgName1."','".$_POST['hdUidID']."')");
			
			$t = $db->query("stored procedure","sp_admin_Rtopic_delete('".$uid."')");
			$c = $db->query("stored procedure","sp_admin_Rconsumer_delete('".$uid."')");
			$g = $db->query("stored procedure","sp_admin_Rgrade_delete('".$uid."')");
			$m = $db->query("stored procedure","sp_admin_Rmedia_delete('".$uid."')");
			$s = $db->query("stored procedure","sp_admin_Rstandard_delete('".$uid."')");
			$v = $db->query("stored procedure","sp_admin_Rcost_delete('".$uid."')");
			$d = $db->query("stored procedure","sp_admin_Rduration_delete('".$uid."')");
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
			$url = './resourse.php?resp=up';
		
		}
		else
		{
			$n = $db->query("stored procedure","sp_admin_resourse_update('".$_POST['txttitle']."','".$_POST['txtdescription']."','".$_POST['txtwhatlove']."','".$_POST['txtimprove']."','".$_POST['txtstart']."','".$_POST['txtexternal']."','".$_POST['hdUidID']."')");

			$t = $db->query("stored procedure","sp_admin_Rtopic_delete('".$uid."')");
			$c = $db->query("stored procedure","sp_admin_Rconsumer_delete('".$uid."')");
			$g = $db->query("stored procedure","sp_admin_Rgrade_delete('".$uid."')");
			$m = $db->query("stored procedure","sp_admin_Rmedia_delete('".$uid."')");
			$s = $db->query("stored procedure","sp_admin_Rstandard_delete('".$uid."')");
			$v = $db->query("stored procedure","sp_admin_Rcost_delete('".$uid."')");
			$d = $db->query("stored procedure","sp_admin_Rduration_delete('".$uid."')");
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