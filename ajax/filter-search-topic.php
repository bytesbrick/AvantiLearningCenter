<?php
	$resp = "";
	$html = "";
	$sql = "";
	
	if(isset($_GET["currid"])||isset($_POST["chkgrade"]) || isset($_POST['chkcurriculum']) || isset($_POST['maxtpid']) || isset($_POST['chpID']) || isset($_POST["query"])){
		
		include("../includes/config.php");		
		include("../classes/cor.mysql.class.php");
		$db = new MysqlConnection(CONNSTRING);
		$db->open();
		
		$sql = "SELECT distinct rm.classwork_hrs,rm.homework_hrs, tm.unique_id, tm.topic_name, tm.chapter_id,tm.topic_image,tm.topic_desc FROM avn_topic_master tm left outer join  avn_chapter_master cm  on cm.unique_id = tm.chapter_id left outer join ltf_resources_master rm on tm.unique_id = rm.topic_id left outer join avn_resources_curriculum rc on rm.unique_id = rc.resource_id LEFT OUTER JOIN ltf_resources_grade_level lrgl ON lrgl.resource_id = rm.unique_id LEFT OUTER JOIN ltf_grade_level_master lgml ON lgml.unique_id = lrgl.grade_level_id WHERE (tm.topic_name LIKE '%".$_GET['q']."%')";
		
		$where = "";
		$tables = "";
		
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
			
			if(!isset($r['response'])){
				
				
				for($i=0; $i<count($r); $i++){
					
					
					if(!isset($_COOKIE["cUserID"]))
					{
						$html .= "<div class='motionclasses'><a class='fl' href='javascript: void(0);' onclick='javascript: _disableThisPage();_setDivPos(|!|popupContact|!|);_setTopicID(" . $r[$i]['unique_id'] . ")'><img src='./admin/images/upload-image/" . $r[$i]['topic_image'] . "' style='width:294px;height:150px;'></a>";
						$html .= "<div class='headingtxt'><a style='color:#BE2327' href='javascript: void(0);' onclick='javascript: _disableThisPage();_setDivPos(|!|popupContact|!|);_setTopicID(" . $r[$i]['unique_id'] . ")'>".ucwords($r[$i]['topic_name'])."</a></div>";
					}
					
					else
					{
						$html .= "<div class='motionclasses'><a class='fl' href='./resource-detail.php?tpID=" . $r[$i]['unique_id']. "'><img src='./admin/images/upload-image/" . $r[$i]['topic_image'] . "' style='width:294px;height:150px;'></a>";
						$html .= "<div class='headingtxt'><a style='color:#BE2327' href='./resource-detail.php?tpID=" . $r[$i]['unique_id']. "' >".ucwords($r[$i]['topic_name'])."</a></div>";
					}
					
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
						
						$html .= "<div class='schedule'>". $time . "</div>";
						$html .= "<div class='schedule'>". $Htime ."</div>";
						
						$html .= "<div class='content mt5'>".ucwords($r[$i]['topic_desc'])."</div></div>";
					}
				}
			}
			
			
		}
	}else
			$resp = 0;
	echo $resp."#/#".str_ireplace("\"", "'", $html);