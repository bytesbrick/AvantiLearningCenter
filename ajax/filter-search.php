<?php
	$resp = "";
	$html = "";
	if(isset($_POST["chkcurriculum"])||isset($_POST["chkgrade"]) || isset($_POST["chkcategory"]) || isset($_POST["query"])){
		
		include("../includes/config.php");		
		include("../classes/cor.mysql.class.php");
		$db = new MysqlConnection(CONNSTRING);
		$db->open();
		
		$sql = "SELECT distinct cm.unique_id,cm.chapter_desc,cm.chapter_name,cm.chapter_image FROM avn_chapter_master cm left outer join avn_topic_master tm on cm.unique_id = tm.chapter_id left outer join ltf_resources_master rm on tm.unique_id = rm.topic_id left outer join avn_resources_curriculum rc on rm.unique_id = rc.resource_id left outer join ltf_category_master lcm on lcm.unique_id = cm.category_id LEFT OUTER JOIN ltf_resources_grade_level lrgl ON lrgl.resource_id = rm.unique_id LEFT OUTER JOIN ltf_grade_level_master lgml ON lgml.unique_id = lrgl.grade_level_id  WHERE (cm.chapter_name LIKE '%".$_GET['q']."%')";
		
		$where = "";
		
		if(isset($_POST["chkcurriculum"])){
			
			$where .= $where == "" ? " rc.curriculum_id in (" . $_POST["chkcurriculum"] . ") " : " AND rc.curriculum_id in (" . $_POST["chkcurriculum"] . ") ";
		}
		if(isset($_POST["chkgrade"])){
			
			$where .= $where == "" ? " lgml.unique_id in (" . $_POST["chkgrade"] . ")" : " AND lgml.unique_id in (" . $_POST["chkgrade"] . ")";
		}
		if(isset($_POST["chkcategory"])){
			
			$where .= $where == "" ? " lcm.unique_id in (" . $_POST["chkcategory"] . ")" : " AND lcm.unique_id in (" . $_POST["chkcategory"] . ")";
		}		
		$order = " ORDER BY cm.unique_id DESC";
		if($where != ""){
			$sql .= "and " . $where . "". $order;
		}else if($where == ""){
			$order = "ORDER BY cm.unique_id DESC";
			$sql .= $where . $order;
		}
		$r = $db->query("query", $sql);
	}
	//echo $sql;
		if(!isset($r["response"])){
			if(count($r) > 0){
				$resp = 1;
				for($i=0; $i<count($r); $i++){
					$cur = $db->query("query","select distinct acm.unique_id from ltf_resources_master rm left outer join  avn_resources_curriculum rc on rm.unique_id = rc.resource_id left outer join avn_curriculum_master acm on acm.unique_id = rc.curriculum_id where rm.chapter_id= ". $r[$i]['unique_id']);
					//print_r($cur);
					$html .= "<div class='motionclasses'><a href='./topic-list.php?chpID=" . $r[$i]['unique_id'] . "' class='fl'><img src='./admin/images/upload-image/".$r[$i]['chapter_image']."' width ='294' height ='145'></a>";
					$html .= "<div class='headingtxt'><a style='color:#BE2327' href='./topic-list.php?chpID=" . $r[$i]['unique_id'] . "' >".ucwords($r[$i]['chapter_name'])."</a></div>";
					$hrs = $db->query("query","SELECT SUM(classwork_hrs) as sumchp , SUM(homework_hrs) as sumhmwrk from ltf_resources_master  where chapter_id = ". $r[$i]['unique_id']);
						
						
						$calclasshrs = intval($hrs[0]['sumchp'] / 60);
						$calclassmins =  $hrs[0]['sumchp'] % 60;
						
						$calhmwrkhrs = intval($hrs[0]['sumhmwrk'] / 60);
					
						$calhmwrkmins = $hrs[0]['sumhmwrk'] % 60;
						
						$time ="";
						if($calclasshrs > 0){
							if($calclassmins > 0){
								
								if($calclasshrs == 1 && $calclassmins > 1){
									$time = "" . floor($calclasshrs) . " hour " . $calclassmins . " minutes in Class";
								}
								else
									$time = "" . floor($calclasshrs) . " hours " . $calclassmins . " minutes in Class";
							}
							else{
								if($calclasshrs > 1){
									
									$time = "" . floor($calclasshrs) . " hours in Class";
								}
								else
									$time = "" . floor($calclasshrs) . " hour in Class";
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
								
								if($calhmwrkhrs == 1 && $calhmwrkmins > 1){
									$Htime = "" . floor($calhmwrkhrs) . " hour " . $calhmwrkmins . " minutes at Home";
								}
								else
									$Htime = "" . floor($calhmwrkhrs) . " hours " . $calhmwrkmins . " minutes at Home";
							}
							else{
								if($calhmwrkhrs > 1){
									
									$Htime ="" . floor($calhmwrkhrs) . " hours at Home";
								}else
								
									$Htime ="" . floor($calhmwrkhrs) . " hour at Home";
							}
						}
						else{
							if($calhmwrkmins == 1)
							
								$Htime = "" . $calhmwrkmins . " minute at Home";
							else
							
								$Htime = "" . $calhmwrkmins . " minutes at Home";
						}
						
						$html .= "<div class='schedule'>". $time . "</div>";
						$html .= "<div class='schedule'>". $Htime ."</div>";
					
					$w = $db->query("query","select topic_name from avn_topic_master where chapter_id=".$r[$i]["unique_id"]);
					
						if(!isset($w["response"])){							
							$Tcount = count($w);							
							if($Tcount>1)
								$topic="s";
							else
								$topic="";

							$html .= "<a href='./topic-list.php?chpID=" . $r[$i]['unique_id'] . "' class='linktopics'>".$Tcount." Topic".$topic."</a>";
						}else{
							$html .="<a href='./topic-list.php?chpID=".$r[$i]['unique_id']."' class='linktopics'> 0 Topic</a>";
						}
					$html .= "<div class='content mt5'>".ucwords($r[$i]['chapter_desc'])."</div></div>";
				}
				if(count($r) > 4)
					$html .= "<div class='showmore' style='margin:40px 0px;'><a href='javascript:void(0);' onclick='javascript: void(0);'>SHOW MORE</a></div>";
			}
		}else
			$resp = 0;
	
	echo $resp."#/#".str_ireplace("\"", "'", $html);
?>