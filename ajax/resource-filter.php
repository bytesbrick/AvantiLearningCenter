<?php
	$resp = "";
	$html = "";
	if(isset($_GET["tpid"]) && isset($_GET["chpid"])){
		
		include("../includes/config.php");		
		include("../classes/cor.mysql.class.php");
		$db = new MysqlConnection(CONNSTRING);
		$db->open();
		
		$sql = "SELECT distinct rm.`unique_id`, rm.`resource_title`,rm.resource_pic FROM `avn_chapter_master` cm left outer join `avn_topic_master` tm on cm.`unique_id` = tm.`chapter_id` left outer join `ltf_resources_master` rm on tm.`unique_id` = rm.`topic_id` left outer join `avn_resources_curriculum` rc on rm.`unique_id` = rc.`resource_id` left outer join ltf_resources_grade_level lrgl ON lrgl.resource_id = rm.unique_id LEFT OUTER JOIN ltf_grade_level_master lgml ON lgml.unique_id = lrgl.grade_level_id";
		
		$where = "";
		$tables = "";

		if(isset($_GET["tpid"]) && isset($_GET["chpid"])){
			$where .= $where == "" ? " rc.`curriculum_id` in (" . $_GET['currid'] . ") AND cm.`unique_id` = " . $_GET['chpid'] . " AND tm.`unique_id` = " . $_GET['tpid'] . "" : " AND rc.`curriculum_id` in (" . $_GET['currid'] . ") AND cm.`unique_id` = " . $_GET['chpid'] . " AND tm.`unique_id` = " . $_GET['tpid'] . "";
		}

		if(isset($_POST["chkgrade"])){
			$where .= $where == "" ? " lgml.unique_id in (" . $_POST["chkgrade"] . ")" : " AND lgml.unique_id in (" . $_POST["chkgrade"] . ")";
		}
		
		$order ="ORDER BY unique_id DESC";
		$order = " ORDER BY rm.views DESC";
		if($where != ""){
			$order = " ORDER BY rm.entry_date DESC";
			$sql .= $tables . " WHERE " . $where . " And rm.ractive = 1 " . $order;
		}else if($where == ""){
			$order = " ORDER BY rm.entry_date DESC";
			$sql .= $where . $order;
		}		
		$r = $db->query("query", $sql);
	}
		
		if(!isset($r["response"])){
		if(count($r) > 0){
			$resp = 1;
			$html .= "<H2 style='width:94%;margin-left:43px'>Resource List</H2>";
			for($i=0; $i<count($r); $i++){
				$html .= "<div class='motionclasses'>";
				if(isset($_COOKIE["cUserID"])){
					$html .= "<a class='fl' href='./resource-detail.php?resID=" . $r[$i]['unique_id']. "'><img src='./admin/images/upload-image/" . $r[$i]['resource_pic'] . "'></a><div class='headingtxt'><a style='color:#BE2327' href='./resource-detail.php?resID=" . $r[$i]['unique_id']. "' >".$r[$i]['resource_title']."</a></div>";
				}else{
					$html .= "<a class='fl' href='javascript:void(0);' onclick='javascript: _disableThisPage();_setDivPos(|!|popupContact|!|);'><img src='./admin/images/upload-image/" . $r[$i]['resource_pic'] . "'></a><div class='headingtxt'><a style='color:#BE2327' onclick='javascript: _disableThisPage();_setDivPos(|!|popupContact|!|);' href='javascript:void(0);'>" . $r[$i]['resource_title']."</a></div>";
				}
				$html .= "<div class='schedule'>15 HRS in Class |</div>";
				$html .= "<div class='schedule'> 5 HRS at Home</div>";
				
				$w = $db->query("query","SELECT distinct rm.unique_id as total,rm.resource_title,rm.resource_desc,tm.chapter_id,rc.curriculum_id FROM avn_chapter_master cm left outer join avn_topic_master tm on cm.unique_id = tm.chapter_id left outer join ltf_resources_master rm on tm.`unique_id` = rm.`topic_id`left outer join avn_resources_curriculum rc on rm.unique_id = rc.resource_id WHERE rc.curriculum_id in (".$r[$i]["curriculum_id"].") AND cm.unique_id = " . $r[$i]['chapter_id'] . " AND tm.unique_id =" .$r[$i]["topic_id"]);
				
					if(!isset($w["response"])){
						$res = $w[0]['total'];
						
						if($res>1)
							$resource="s";
						else
							$resource="";
						$html .= "<a class='linktopics' href='./resource-detail.php?resID=".$r[$i]['unique_id']."</a>";
					}else{
						$html .="<a class='linktopics' href='./resource-detail.php?resID=" . $r[$i]['unique_id'] . " </a>";
					}
				$html .= "<div class='content mt5'><a class='linktopics' id = " . $r[$i]['unique_id'] ." onclick= '_disableThisPage();' href='./resource-detail.php'".$r[$i]['resource_title']."</a></div></div>";
			}
			if(count($r) > 4)
				$html .= "<div class='showmore' style='margin:40px 0px;'><a href='javascript:void(0);' onclick='javascript: void(0);'>SHOW MORE</a></div>";
		}
		}else
			$resp = 0;
	
	echo $resp."#/#".str_ireplace("\"", "'", $html);
?>