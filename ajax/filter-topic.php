<?php
	$resp = "";
	$html = "";
	$sql = "";
	if(isset($_GET["currid"])||isset($_POST["chkgrade"]) || isset($_POST['chkcurriculum']) || isset($_POST['maxtpid']) || isset($_POST['chpID'])){
		include("../includes/config.php");		
		include("../classes/cor.mysql.class.php");
		$db = new MysqlConnection(CONNSTRING);
		$db->open();
		
		$getcurriculumslug = $db->query("query","SELECT curriculum_slug FROM avn_curriculum_master WHERE unique_id = ". $_GET["currid"]);
		$curriculum = $getcurriculumslug[0]["curriculum_slug"];
		
		$sql = "SELECT DISTINCT cm.chapter_slug,cm.chapter_name,tm.topic_slug,tm.classwork_hrs,tm.homework_hrs, tm.unique_id as topicID, tm.topic_name, tm.topic_code,tm.chapter_id,tm.topic_image, tm.topic_desc,lcm.category_slug FROM avn_topic_master tm LEFT OUTER JOIN avn_chapter_master cm ON cm.unique_id = tm.chapter_id LEFT OUTER JOIN ltf_category_master lcm on lcm.unique_id = cm.category_id LEFT OUTER JOIN avn_topic_grades lrgl ON lrgl.topic_id = tm.unique_id LEFT OUTER JOIN ltf_grade_level_master lgml ON lgml.unique_id = lrgl.grade_id INNER JOIN avn_batch_chapter_mapping abcm ON abcm.chapter_id = cm.unique_id";
		
		$where = "";
		$tables = "";
		
		if(isset($_POST["chkgrade"])){			
			$where .= $where == "" ? " lgml.unique_id in (" . $_POST["chkgrade"] . ")" : " AND lgml.unique_id in (" . $_POST["chkgrade"] . ")";
		}
		if(!isset($_POST['maxtpid'])){
			$order = " AND tm.status = 1 ORDER BY tm.unique_id DESC LIMIT 0,10";
		}
		else{ 
			$order = " AND tm.unique_id < " . $_POST['maxtpid'] . " AND tm.status = 1 ORDER BY tm.unique_id DESC LIMIT 0,10";
		}
		if(isset($_POST['chpID']) && $_POST['chpID'] != ""){
			$sql .= " WHERE " . $where . " tm.chapter_id  = " . $_POST['chpID'] . " AND tm.status = 1";
			$sql .= $where . $order;
		}
		else{
			if($where != "")
				$sql .= " WHERE " . $where . " AND tm.chapter_id  in (" . $_GET['chpid'] . ") AND tm.status = 1" . $order;		
			else if($where == ""){	
				$where = " WHERE tm.chapter_id = " . $_GET['chpid'] . " AND tm.status =1";
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
					$lasttopic = $r[$i]['topicID'];
					$html.= "<tr>";
					//$html.="<td style='width: 100px;'>";
					//$html.="<div class='presondiv' style='margin-right:15px;'><a href='" . __WEBROOT__ . "/" . trim($curriculum) . "/" . trim($r[$i]["category_slug"]) . "/" . trim($r[$i]["chapter_slug"]) . "/" . trim($r[$i]["topic_slug"]) . "/' class='fl'><img src='" . __WEBROOT__ . "/admin/images/upload-image/".$r[$i]['topic_image']."' width='80' class='noborder' style='padding:10px;'></a></div>";
					//$html.="</td>";
					$html.="<td valign='top' class='ft14' style='padding:14px 0 0 18px;color:#000;'>".ucwords($r[$i]['topic_code'])."</td>";
					$html.="<td valign='top'><span class='ft14'><a href='" . __WEBROOT__ . "/" . trim($curriculum) . "/" . trim($r[$i]["category_slug"]) . "/" . trim($r[$i]["chapter_slug"]) . "/" . trim($r[$i]["topic_slug"]) . "/' class='title'>" . $r[$i]['topic_name'] . "<span style='color:#000 !important;font-size:14px;'> | " . ucwords($r[$i]['chapter_name']) . "</span></a></span>";
					$desc = $r[$i]['topic_desc'];
					$html.="<small class='ffhelvetica' style='color:#333;font-size:12px;'><div style='width:100%'>";
					$html.="<div class='fl' style='width:100%;'>";
					if(strlen($desc) > 90){
						$html.="<span class='fl' style='padding-top:5px;'>" . substr($desc, 0, 90) . "...&nbsp;<span>";
						$html.="<span class='morespan'><a href='javascript:void(0);' class='morelink'>More</a>";
						$html.="<div class=\"morecontent\"><img src=\"" . __WEBROOT__ . "/images/up-arrow.jpg\" class=\"fr\" /><div class=\"mdesc\"><div class=\"txt\">" . $desc . "</div></div></div></span>";
					} else {
						$html.="<span class='fl'>" . $desc . "<span>";
					}
					$html.="</div>";
					$html.="</div>";
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
						//$html.="<span class='fl' style='color:#333;'><small>". $time . "&nbsp;|&nbsp;". $Htime . "</small></span>";
					}
					$html.="</td>";
					$html.="<td valign='middle'>";
					$html.="<span class='fr' style='margin-right:30px;'><a href='" . __WEBROOT__ . "/" . trim($curriculum) . "/" . trim($r[$i]["category_slug"]) . "/" . trim($r[$i]["chapter_slug"]) . "/" . trim($r[$i]["topic_slug"]) . "/' class='fl' ><img src='" . __WEBROOT__ . "/images/resourceimg.png' class='fr'></a></span>";
					$html.="</td>";
					$html.="</tr>";
					$html.="<tr>";
					$html.="<td colspan='4' style='padding:0;'>";
					$html.="<span style='border-bottom: 1px solid #ccc;padding:0;float: left;width: 100%;'></span>";
					$html.="</td>";
					$html.="</tr>";
				}
			}
			if(isset($_POST['chpID']) && $_POST['chpID'] != ""){
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
	echo $resp."#/#".str_ireplace("\"", "'", $html)."#/#".$var."#/#".$_POST['chkcurriculum']."#/#".$lasttopic."#/#". $more. "#/#". $chapter;
?>