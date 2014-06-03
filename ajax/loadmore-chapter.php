<?php
	$resp = "";
	$html = "";
	if(isset($_POST["chkcurriculum"])||isset($_POST["chkgrade"]) || isset($_POST["chkcategory"])){
		
		include("../includes/config.php");		
		include("../classes/cor.mysql.class.php");
		$db = new MysqlConnection(CONNSTRING);
		$db->open();
		
		$sql = "SELECT distinct cm.unique_id, cm.chapter_name,cm.chapter_desc,cm.category_id,cm.chapter_image FROM avn_chapter_master cm left outer join avn_topic_master tm on cm.unique_id = tm.chapter_id left outer join ltf_resources_master rm on tm.unique_id = rm.topic_id left outer join avn_resources_curriculum rc on rm.unique_id = rc.resource_id left outer join ltf_category_master lcm on lcm.unique_id = cm.category_id  LEFT OUTER JOIN ltf_resources_grade_level lrgl ON lrgl.resource_id = rm.unique_id LEFT OUTER JOIN ltf_grade_level_master lgml ON lgml.unique_id = lrgl.grade_level_id ";
		
		$where = "";
		$tables = "";
		if(isset($_POST["chkcurriculum"])){
			$where .= $where == "" ? " rc.curriculum_id in (" . $_POST["chkcurriculum"] . ") " : " AND cm.curriculum_id in (" . $_POST["chkcurriculum"] . ") ";
		}
		if(isset($_POST["chkgrade"])){
			
			$where .= $where == "" ? " lgml.unique_id in (" . $_POST["chkgrade"] . ")" : " AND lgml.unique_id in (" . $_POST["chkgrade"] . ")";
		}
		if(isset($_POST["chkcategory"])){
			
			$where .= $where == "" ? " cm.category_id in (" . $_POST["chkcategory"] . ")" : " AND cm.category_id in (" . $_POST["chkcategory"] . ")";
		}
		if($_GET["maxid"] != "")
			$order = " and cm.unique_id < ". $_GET['maxid']." ORDER BY cm.entry_date DESC";
		else
			$order = " ORDER BY cm.entry_date DESC";

		if($where != "")
			$sql .= " WHERE " . $where . $order;
		else
			$sql .= $order;
			
		echo $sql;
		
		$r = $db->query("query", $sql);
		if(!isset($r["response"])){
			if(count($r) > 0){
				$resp = 1;
				$html .= "<H2 style='width:94%;margin-left:43px'>Chapters</H2>";
			
				if(!isset($r['response'])){
					for($i=0; $i<count(3); $i++){
						$islast = "";
						$islast = $r[$i]['unique_id'];
						
						$html .= "<div class='motionclasses'><a href='./topic-list.php?currID=" . $_GET['currid'] . "&chpID=" . $r[$i]['unique_id'] . "' class='fl'><img src='./admin/images/upload-image/".$r[$i]['chapter_image']."' width='294' height='143'></a>";
						$html .= "<div class='headingtxt'><a style='color:#BE2327' href='./topic-list.php?currID=" . $_GET['currid'] .  "&chpID=" . $r[$i]['unique_id'] . "' >".ucwords($r[$i]['chapter_name'])."</a></div>";
						
						$html .= "<div class='schedule'>15 HRS in Class |</div>";
						$html .= "<div class='schedule'>10 HRS at Home</div>";
						
						$w = $db->query("query","select topic_name from avn_topic_master where chapter_id=".$r[$i]["unique_id"]);
						
							if(!isset($w["response"])){							
								$Tcount = count($w);							
								if($Tcount>1)
									$topic="s";
								else
									$topic="";
	
								$html .= "<a href='./topic-list.php?currID=" . $r[$i]['curriculum_id'] . "&chpID=" . $r[$i]['unique_id'] . "' class='linktopics'>".$Tcount." Topic".$topic."</a>";
							}else{
								$html .="<a href='./topic-list.php?currID=" . $r[$i]['curriculum_id'] .  "&chpID=".$r[$i]['unique_id']."' class='linktopics'> 0 Topic</a>";
							}
						$html .= "<div class='content mt5'>".ucwords($r[$i]['chapter_desc'])."</div></div>";
					}
				}
				if(count($r) > 4)
					$html .= "<div class='showmore' style='margin:40px 0px;'><a href='javascript:void(0);' onclick='javascript: _loadMore(" . $_GET['currid'] . ")'>SHOW MORE</a></div>";
			}
		}else
			$resp = 0;
	}	
	//echo $resp."#/#".str_ireplace("\"", "'", $html);
?>