<?php
	include("../includes/config.php");		
	include("../classes/cor.mysql.class.php");
	include_once("../includes/checklogin.php");
	
	$resp = "";
	$html = "";
	$sql = "";
	if(isset($_POST["chkcurriculum"])||isset($_POST["chkgrade"]) || isset($_POST["chkcategory"])){
		$db = new MysqlConnection(CONNSTRING);
		$db->open();
		
		$sql = "SELECT DISTINCT lcm.category_name,abcm.priority,cm.unique_id,cm.chapter_name  ,cm.chapter_code,cm.chapter_desc,cm.chapter_image,cm.chapter_slug,lcm.category_slug,acm.curriculum_slug,acm.curriculum_name FROM avn_chapter_master cm LEFT OUTER JOIN avn_batch_chapter_mapping abcm ON abcm.chapter_id = cm.unique_id LEFT OUTER JOIN ltf_category_master lcm ON lcm.unique_id = cm.category_id LEFT OUTER JOIN avn_curriculum_master acm ON acm.unique_id = lcm.curriculum_id LEFT OUTER JOIN avn_batch_master abm ON abm.unique_id = abcm.batch_id";
		
		$where = "";
		$tables = "";
		if(isset($_POST["chkcurriculum"])){
			$where .= $where == "" ? " lcm.curriculum_id in (" . $_POST["chkcurriculum"] . ") AND abm.batch_id = '" . $arrUserInfo["batch_id"] .  "'" : " AND lcm.curriculum_id in (" . $_POST["chkcurriculum"] . ") AND abm.batch_id = '" . $arrUserInfo["batch_id"] .  "'";
		}
		if(isset($_POST["chkgrade"])){
			$where .= $where == "" ? " lgml.unique_id in (" . $_POST["chkgrade"] . ") AND abm.batch_id = '" . $arrUserInfo["batch_id"] .  "'" : " AND lgml.unique_id in (" . $_POST["chkgrade"] . ") AND abm.batch_id = '" . $arrUserInfo["batch_id"] .  "'";
		}
		if(isset($_POST["chkcategory"])){
			$where .= $where == "" ? " lcm.unique_id in (" . $_POST["chkcategory"] . ") AND abm.batch_id = '" . $arrUserInfo["batch_id"] .  "'" : " AND lcm.unique_id in (" . $_POST["chkcategory"] . ") AND abm.batch_id = '" . $arrUserInfo["batch_id"] .  "'";
		}
		if(!isset($_POST['maxid'])){
			$order = " ORDER BY abcm.priority ASC LIMIT 0,10";
		}
		else{
			$order = " AND abcm.priority > " . $_POST['maxid'] . " ORDER BY abcm.priority ASC LIMIT 0,10";
		}
		if($where != "")
			$sql .= " WHERE " . $where .  $order;
		else
			$sql .= $order;
		//echo $sql;
		$r = $db->query("query", $sql);
		//print_r($r);
		if(!isset($r["response"])){
			$html.= "<table cellpadding='0' cellspacing='0' border='0' width='100%' min-height='100%'>";
			if(count($r) > 0){
				$resp = 1;
				if(!isset($r['response'])){
					for($i=0; $i<count($r); $i++){
						$islast = "";
						$islast = $r[$i]['unique_id'];
						$lastchpPriority = $r[$i]["priority"];
						$html.= "<tr>";
						//$html.="<td width='60px'>";
						//$html.="<div class='presondiv' style='margin-right:15px;'><a href='" . __WEBROOT__ . "/" . trim($r[$i]["curriculum_slug"]) . "/" . trim($r[$i]["category_slug"]) . "/" . trim($r[$i]["chapter_slug"]) . "/' class='fl' ><img src='" . __WEBROOT__ . "/admin/images/upload-image/".$r[$i]['chapter_image']."' width='80' class='noborder' style='padding:0 10px;'></a></div>";
						//$html.="</td>";
						$html.="<td valign='top'><a href='" . __WEBROOT__ . "/" . trim($r[$i]["curriculum_slug"]) . "/" . trim($r[$i]["category_slug"]) . "/" . trim($r[$i]["chapter_slug"]) . "/' style='color: #333;' class='ffhelvetica'>" . $r[$i]['chapter_code'] . "</a></td>";
						
						$html.="<td valign='top'>";
						$html.="<span class='title ft14'>".ucwords($r[$i]['chapter_name'])."</span>";
						$hrs = $db->query("query","SELECT SUM(classwork_hrs) as sumchp , SUM(homework_hrs) as sumhmwrk from avn_topic_master where chapter_id = ". $r[$i]['unique_id']);
						$calclasshrs = intval($hrs[0]['sumchp']/60);
						$calclassmins =  $hrs[0]['sumchp'] % 60;
						$calhmwrkhrs = intval($hrs[0]['sumhmwrk']/60);
						$calhmwrkmins = $hrs[0]['sumhmwrk'] % 60;
						$time ="";
						if($calclasshrs > 0){
							if($calclassmins > 0){
								if($calclasshrs == 1 && $calclassmins > 1){
									$time = "" . floor($calclasshrs) . " hr " . $calclassmins . " minutes in Class";
								}
								else
									$time = "" . floor($calclasshrs) . " hrs " . $calclassmins . " minutes in Class";
							}
							else{
								if($calclasshrs > 1){
									
									$time = "" . floor($calclasshrs) . " hrs in Class";
								}
								else
									$time = "" . floor($calclasshrs) . " hr in Class";
							}
						}
						else{
							if($calclassmins == 1)
								$time = "" . $calclassmins . " min in Class";							
							else
								$time = "" . $calclassmins . " mins in Class";
						}
						$Htime ="";
						if($calhmwrkhrs > 0){
							if($calhmwrkmins > 0){
								if($calhmwrkhrs == 1 && $calhmwrkmins > 1){
									$Htime = "" . floor($calhmwrkhrs) . " hour " . $calhmwrkmins . " mins at Home";
								}
								else
									$Htime = "" . floor($calhmwrkhrs) . " hours " . $calhmwrkmins . " mins at Home";
							}
							else{
								if($calhmwrkhrs > 1){
									$Htime ="" . floor($calhmwrkhrs) . " hrs at Home";
								}else
									$Htime ="" . floor($calhmwrkhrs) . " hr at Home";
							}
						}
						else{
							if($calhmwrkmins == 1)
								$Htime = "" . $calhmwrkmins . " min at Home";
							else
								$Htime = "" . $calhmwrkmins . " mins at Home";
						}
						$w = $db->query("query","select topic_name from avn_topic_master where chapter_id = " . $r[$i]["unique_id"]);
						if(!isset($w["response"])){							
							$Tcount = count($w);							
							if($Tcount>1)
								$topic="s";
							else
								$topic="";
						$topic= "<a href='" . __WEBROOT__ . "/" . trim($r[$i]["curriculum_slug"]) . "/" . trim($r[$i]["category_slug"]) . "/" . trim($r[$i]["chapter_slug"]) . "/' class='ffhelvetica' style='color:#333;'><small>".$Tcount." Topic".$topic."</small></a>";
						}else{
							$topic ="<a href='" . __WEBROOT__ . "/" . trim($r[$i]["curriculum_slug"]) . "/" . trim($r[$i]["category_slug"]) . "/" . trim($r[$i]["chapter_slug"]) . "/' class='ffhelvetica'  style='color:#333; font-size:11px;'> 0 Topic</a>";
						}
						$desc = $r[$i]['chapter_desc'];
						$html.="<small class='ffhelvetica' style='color:#333;font-size:12px;'><div style='width:100%;padding-top:5px;'>";
						$html.="<div class='fl' style='width:100%;'>";
						if(strlen($desc) > 70){
							$html.="<span class='fl'>" . substr($desc, 0, 70) . "...&nbsp;<span>";
							$html.="<span class='morespan'><a href='javascript:void(0);' class='morelink'>More</a>";
							$html.="<div class=\"morecontent\"><img src=\"" . __WEBROOT__ . "/images/up-arrow.jpg\" class=\"fr\" /><div class=\"mdesc\"><div class=\"txt\">" . $desc . "</div></div></div></span>";
						} else {
							$html.="<span class='fl'>" . $desc . "<span>";
						}
						$html.="</div>";
						$html.="</div>";
						//$html.="</small><div class='fl'><span class='fl ffhelvetica'><small style='color:#333 !important;'></small></span><small class='ffhelvetica' style='font-size:11px;color:#333;'>" . $topic . "&nbsp;|&nbsp;</small><small class='ffhelvetica' style='color:#333;font-size:11px';>". $time . "&nbsp;|&nbsp;". $Htime . "</small></span></div>";
						$html.="</td>";
						$html.="<td><span class='fl ft14 black'>".ucwords($r[$i]['category_name'])."</span></td>";
						$html.="<td>";
						$html.="<span class='fr' style='margin-right:30px;'><a href='" . __WEBROOT__ . "/" . trim($r[$i]["curriculum_slug"]) . "/" . trim($r[$i]["category_slug"]) . "/" . trim($r[$i]["chapter_slug"]) . "/' class='fl' ><img src='" . __WEBROOT__ . "/images/arrow.png' class='fr'></a></span>";
						$html.="</td>";
						$html.="</tr>";
						$html.="<tr>";
						$html.="<td colspan='4' style='padding:0 !important;'>";
						$html.="<span style='border-bottom: 1px solid #ccc;float: left;width: 100%;'></span>";
						$html.="</td>";
						$html.="</tr>";
						unset($hrs);
						unset($w);
					}
					$html.="</table>";
				}
				if(isset($_POST["chkcategory"]) && $_POST["chkcategory"] != ""){
					$rem = $db->query("query","SELECT COUNT(priority) as remid FROM avn_batch_chapter_mapping WHERE priority > " . $lastchpPriority . " AND subject_id = " . $_POST["chkcategory"]);
				}
				else{
					$rem = $db->query("query","SELECT COUNT(priority) as remid FROM avn_batch_chapter_mapping WHERE priority > " . $lastchpPriority);
				}
					if($rem[0]['remid'] > 0)
						$more = "1";
					else
						$more = "0";
					unset($rem);
				if(count($r)> 3)
					$var = 1;
				else
					$var = 0;					
			}
		}else
			$resp = 0;
	}	
	echo $resp."#/#".str_ireplace("\"", "'", $html)."#/#".$var."#/#".$_POST['chkcurriculum']."#/#".$lastchpPriority."#/#".$more;
?>