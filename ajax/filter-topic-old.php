<?php
	$resp = "";
	$html = "";
	$sql = "";
	if(isset($_POST["currid"])||isset($_POST["chkgrade"]) || isset($_POST['chkcurriculum']) || isset($_POST['maxtpid']) || isset($_POST['chpID'])){
		include("../includes/config.php");		
		include("../classes/cor.mysql.class.php");
		$db = new MysqlConnection(CONNSTRING);
		$db->open();
		
		$getcurriculumslug = $db->query("query","SELECT curriculum_slug FROM avn_curriculum_master WHERE unique_id = ". $_POST["chkcurriculum"]);
		$curriculum = $getcurriculumslug[0]["curriculum_slug"];
		
		$sql = "SELECT DISTINCT cm.chapter_slug,tm.topic_slug,rm.classwork_hrs,rm.homework_hrs,tm.topic_code, tm.unique_id, tm.topic_name, tm.chapter_id,tm.topic_image,tm.topic_desc,lcm.category_slug FROM avn_topic_master tm LEFT OUTER JOIN  avn_chapter_master cm ON cm.unique_id = tm.chapter_id LEFT OUTER JOIN ltf_resources_master rm ON tm.unique_id = rm.topic_id LEFT OUTER JOIN ltf_category_master lcm on lcm.unique_id = cm.category_id LEFT OUTER JOIN avn_resources_curriculum rc ON rm.unique_id = rc.resource_id LEFT OUTER JOIN ltf_resources_grade_level lrgl ON lrgl.resource_id = rm.unique_id LEFT OUTER JOIN ltf_grade_level_master lgml ON lgml.unique_id = lrgl.grade_level_id";
		
		$where = "";
		$tables = "";
		
		if(isset($_POST["chkgrade"])){			
			$where .= $where == "" ? " lgml.unique_id in (" . $_POST["chkgrade"] . ")" : " AND lgml.unique_id in (" . $_POST["chkgrade"] . ")";
		}
		if(!isset($_POST['maxtpid'])){
			$order = " AND rm.ractive = 1 ORDER BY tm.unique_id DESC LIMIT 0,4";
		}
		else{
			$order = " AND tm.unique_id < " . $_POST['maxtpid'] . " AND rm.ractive = 1 ORDER BY tm.unique_id DESC LIMIT 0,4";
		}
		if(isset($_POST['chpID'])){
			$sql .= " WHERE " . $where . " tm.chapter_id  = " . $_POST['chpID'] . " AND rm.ractive = 1 " . $order;
			$sql .= $where . $order;
		}
		else{
			if($where != "")
				$sql .= " WHERE " . $where . " AND tm.chapter_id  in (" .$_GET['chpid'] . ") AND rm.ractive = 1" . $order;		
			else if($where == ""){	
				$where = " WHERE tm.chapter_id = " . $_GET['chpid'] . " AND rm.ractive =1";
				$sql .= $where . $order;
			}
		}
		$r = $db->query("query", $sql);
		
	}
		//echo $sql;
		if(!isset($r["response"])){
		if(count($r) > 0){
			$resp = 1;
			$chapter = $_GET['chpid'];
			if(!isset($r['response'])){
				$html.= "<table cellpadding='0' cellspacing='0' border='0' width='100%' min-height='100%'>";
				for($i=0; $i<count($r); $i++){
					$lasttopic = "";
					$lasttopic = $r[$i]['unique_id'];
					$html.= "<tr>";
					$html.="<td style='width: 100px;' rowspan='2'>";
					//if(!isset($_COOKIE["cUserID"])){
					//$html.="<div class='presondiv' style='margin-right:15px;'><a href='" . __WEBROOT__ . "/curriculum/" . trim($curriculum) . "/" . trim($r[$i]["category_slug"]) . "/" . trim($r[$i]["chapter_slug"]) . "/" . trim($r[$i]["topic_slug"]) . "/' class='fl'><img src='" . __WEBROOT__ . "/admin/images/upload-image/".$r[$i]['topic_image']."' width='80' height='70' class='noborder' style='padding:10px;'></a></div>";
					//$html.="</td>";
					//$html.="<td valign='top'><div class='titteldiv'><span class='enterlessonsdiv'>". ucwords($r[$i]['chapter_name']) ."</span></div>";
					//}else{
						$html.="<div class='presondiv' style='margin-right:15px;'><a href='" . __WEBROOT__ . "/curriculum/" . trim($curriculum) . "/" . trim($r[$i]["category_slug"]) . "/" . trim($r[$i]["chapter_slug"]) . "/" . trim($r[$i]["topic_slug"]) . "/' class='fl'><img src='" . __WEBROOT__ . "/admin/images/upload-image/".$r[$i]['topic_image']."' width='80' height='70' class='noborder' style='padding:10px;'></a></div>";
					$html.="</td>";
					$html.="<td valign='top'><div class='titteldiv'><span class='enterlessonsdiv'><a href='" . __WEBROOT__ . "/curriculum/" . trim($curriculum) . "/" . trim($r[$i]["category_slug"]) . "/" . trim($r[$i]["chapter_slug"]) . "/" . trim($r[$i]["topic_slug"]) . "/' >".ucwords($r[$i]['topic_name'])." (" . $r[$i]['topic_code'] . ")</a></span></div>";
					//}
					$html.="<span class='enterclassdiv'>".ucwords($r[$i]['topic_desc'])."</span>";
					if(!isset($r['response']))
					{
						$calclasshrs = intval($r[$i]['classwork_hrs']/60);
						$calclassmins =  $r[$i]['classwork_hrs'] % 60;
						$calhmwrkhrs = intval($r[$i]['homework_hrs']/60);
						$calhmwrkmins = $r[$i]['homework_hrs'] % 60;
						$time ="";
						if($calclasshrs > 0){
							if($calclassmins > 0){
								if($calclasshrs == 1){
									$time = "" . floor($calclasshrs) . " hour " . $calclassmins . " minute in Class";
								}
								else
									$time = "" . floor($calclasshrs) . " hour " . $calclassmins . " minutes in Class";
							}
							else{
								if($calclasshrs > 1){
									$time ="" . floor($calclasshrs) . " hours in Class";
								}
								else
									$time ="" . floor($calclasshrs) . " hour in Class";
							}
						}
						else{
							if($calclassmins == 1)
								$time = "" . $calclassmins . " minute in Class";
							else
								$time = "" . $calclassmins . " minutes in Class";
						}
						$Htime ="";
						if($calhmwrkhrs > 0){
							if($calhmwrkmins > 0){
								if($calhmwrkhrs == 1){
									$Htime = "" . floor($calhmwrkhrs) . " hour " . $calhmwrkmins . " minute at Home";
								}
								else
									$Htime = "" . floor($calhmwrkhrs) . " hours " . $calhmwrkmins . " minutes at Home";
							}
							else{
								if($calhmwrkhrs == 1){
									
									$Htime ="" . floor($calhmwrkhrs) . " hour at Home";
								}else
									$Htime ="" . floor($calhmwrkhrs) . " hours at Home";
							}
						}
						else{
							if($calhmwrkmins == 1)
								$Htime = "" . $calhmwrkmins . " minute at Home";
							else
								$Htime = "" . $calhmwrkmins . " minutes at Home";
						}
						$html.="<tr>";
							$html.="<td colspan='2' style='font-size:12px;font-family:helvetica;'>". $time . "&nbsp;|&nbsp;". $Htime . "</td>";
							$html.="</tr>";
					}
					$html.="</td>";
					$html.="</tr>";
					$html.="<tr>";
					$html.="<td colspan='2'>";
					$html.="<span style='border-bottom: 1px solid #ccc;margin-bottom: 10px;float: left;width: 100%;'></span>";
					$html.="</td>";
					$html.="</tr>";
				}
			}
			if(isset($_POST['chpID'])){
				$chapter = $_POST['chpID'];
				$remtopic = $db->query("query","SELECT count(unique_id) as remid from avn_topic_master where chapter_id = " . $_POST['chpID'] . " AND unique_id < " . $lasttopic);
			}
			else
				$remtopic = $db->query("query","SELECT count(unique_id) as remid from avn_topic_master where chapter_id = " . $_GET['chpid'] . " AND unique_id < " . $lasttopic);
				if($remtopic[0]['remid'] > 0)
					$more = "1";
				else
					$more = "0";
				if(count($r) > 3)
					$var = 1;
				else
					$var = 0;
		}
	}else
		$resp = 0;
	echo $resp."#/#".str_ireplace("\"", "'", $html)."#/#".$var."#/#".$_POST['chkcurriculum']."#/#".$lasttopic."#/#".$more."#/#".$chapter;
?>