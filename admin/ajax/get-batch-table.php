<?php
function filter_querystring($query_string, $arrFields, $arrValues){
	if($query_string != ""){
		$qString = "";
		if(count($arrFields) > 0 && count($arrFields) == count($arrValues)){
			$qsParams = explode("&", $query_string);
			for($f = 0; $f < count($arrFields); $f++){
				$iF = -1;
				for($q = 0; $q < count($qsParams); $q++){
					$qsParam = explode("=", $qsParams[$q]);
					if($qsParam[0] == $arrFields[$f]){
						$qsParams[$q] = str_ireplace("=" . $qsParam[1], "=" . $arrValues[$f], $qsParams[$q]);
						$iF = $f;
						break;
					}
				}
				if($iF == -1 && $arrValues[$f] != "")
				$qString .= $qString == "" ? $arrFields[$f] . "=" . $arrValues[$f] : "&" . $arrFields[$f] . "=" . $arrValues[$f];
			}
			for($q = 0; $q < count($qsParams); $q++){
				$qsParam = explode("=", $qsParams[$q]);
				if($qsParam[0] != "" && $qsParam[1] != "") 
				   $qString .= $qString == "" ? $qsParam[0] . "=" . $qsParam[1] : "&" . $qsParam[0] . "=" . $qsParam[1];
			}
		} else {
			$qString = $query_string;
		}
	}else{
		$qString = "";
		if(count($arrFields) > 0 && count($arrFields) == count($arrValues)){
			for($f = 0; $f < count($arrFields); $f++){
				if($arrValues[$f] != "")
				$qString .= $qString == "" ? $arrFields[$f] . "=" . $arrValues[$f] : "&" . $arrFields[$f] . "=" . $arrValues[$f];
			}
		}
	}
	if($qString != "")
		$qString ="?" . $qString;
	return $qString;
}

	include_once("../includes/config.php");  
	include("../classes/cor.mysql.class.php");
	include("../includes/checkLogin.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
	
	$sort = "DESC";
	$field = "abm.entry_date";
	if(isset($_POST["sf"]) && $_POST["sf"] != "")
	    $field = $_POST["sf"];
	if(isset($_POST["sd"]) && $_POST["sd"] != "")
	    $sort = $_POST["sd"];
	
	$curPage = $_POST["page"];
	if(($curPage == "") || ($curPage == 0))
		$curPage=1;
	$recPerpage = 25;
	$countWhereClause = "";
	$selectWhereClause = "";
	$pageParam="";
	$sqlCount = $db->query("query","select count(abm.unique_id) as 'total' from avn_batch_master abm");
	$recCount = $sqlCount[0]['total'];
	$noOfpage = ceil($recCount/$recPerpage);
	$limitStart = ($curPage - 1) * $recPerpage;
	$limitEnd = $recPerpage;
?>
<table cellspacing="1" cellpadding="3" id="tabBatch" width="100%" border="0" style="background-color:#f5f5f5;" class="mdata">
	<thead>
	<tr style="background-color:#A74242;color:#ffffff;">
		<th width="25px">
			<input type="checkbox" name="catgAll" id="catgAll"  onclick="javascript: _checked(this, -1);" style="margin-left: 15px;" />
		</th>
	<?php
	 if($field == "acrm.curriculum_name"){
                if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getBatchTable(<?php echo $curPage; ?>, 'acrm.curriculum_name','desc');" class="sort">Curriculum <img src="./images/up-arr.png" border="0" /></a></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getBatchTable(<?php echo $curPage; ?>, 'acrm.curriculum_name','asc');" class="sort">Curriculum <img src="./images/down-arr.png" border="0" /></a></th>
    <?php
                }
            }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getBatchTable(<?php echo $curPage; ?>, 'acrm.curriculum_name','asc');" class="sort">Curriculum</a></th>
	<?php
			}
			 if($field == "abm.batch_id"){
                if($sort == "asc"){
    ?>
                    <th style="width:85px;"><a href="javascript:void(0);" onclick="javascript: _getBatchTable(<?php echo $curPage; ?>, 'abm.batch_id','desc');" class="sort">Batch ID <img src="./images/up-arr.png" border="0" /></a></th>
    <?php
                }else{
    ?>
                    <th style="width:85px;"><a href="javascript:void(0);" onclick="javascript: _getBatchTable(<?php echo $curPage; ?>, 'abm.batch_id','asc');" class="sort">Batch ID <img src="./images/down-arr.png" border="0" /></a></th>
    <?php
                }
            }else{
    ?>
                    <th style="width:85px;"><a href="javascript:void(0);" onclick="javascript: _getBatchTable(<?php echo $curPage; ?>, 'abm.batch_id','asc');" class="sort">Batch ID</a></th>
	<?php
			}
            if($field == "abm.batch_name"){
                if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getBatchTable(<?php echo $curPage; ?>, 'abm.batch_name','desc');" class="sort">Batch Name <img src="./images/up-arr.png" border="0" /></a><br /><small>Facilitator | Strength</small></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getBatchTable(<?php echo $curPage; ?>, 'abm.batch_name','asc');" class="sort">Batch Name <img src="./images/down-arr.png" border="0" /></a><br /><small>Facilitator | Strength</small></th>
    <?php
                }
            }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getBatchTable(<?php echo $curPage; ?>, 'abm.batch_name','asc');" class="sort">Batch Name</a><br /><small>Facilitator | Strength</small></th>
	<?php
			}
	  if($field == "abm.city_id"){
                if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getBatchTable(<?php echo $curPage; ?>, 'abm.city_id','desc');" class="sort">City <img src="./images/up-arr.png" border="0" /></a></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getBatchTable(<?php echo $curPage; ?>, 'abm.city_id','asc');" class="sort">City <img src="./images/down-arr.png" border="0" /></a></th>
    <?php
                }
            }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getBatchTable(<?php echo $curPage; ?>, 'abm.city_id','asc');" class="sort">City</a></th>
	<?php
			}
			if($field == "abm.learning_center"){
                if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getBatchTable(<?php echo $curPage; ?>, 'abm.learning_center','desc');" class="sort">Center <img src="./images/up-arr.png" border="0" /></a></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getBatchTable(<?php echo $curPage; ?>, 'abm.learning_center','asc');" class="sort">Center <img src="./images/down-arr.png" border="0" /></a></th>
    <?php
                }
            }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getBatchTable(<?php echo $curPage; ?>, 'abm.learning_center','asc');" class="sort">Center</a></th>
	<?php
			}
    ?>
		<th>Options</th>
	</tr>
	</thead>
<?php
	$r = $db->query("query","SELECT abm.*,cmm.unique_id as 'managerID',acrm.curriculum_name, acrm.unique_id as 'curid',acm.city_name,alcm.center_name, CONCAT(cmm.fname, ' ', cmm.lname) as manager_name, CONCAT(tm.fname, ' ', tm.lname) as teacher_name FROM avn_batch_master abm INNER JOIN avn_city_master acm ON acm.unique_id = abm.city_id INNER JOIN avn_learningcenter_master alcm ON alcm.unique_id = abm.learning_center LEFT JOIN avn_centermanager_master cmm ON cmm.unique_id = abm.facilitator_id LEFT JOIN avn_teacher_master tm ON tm.unique_id = abm.facilitator_id INNER JOIN avn_curriculum_master acrm ON acrm.unique_id = abm.curriculum_id ORDER BY " . mysql_escape_string($field) . " " . mysql_escape_string($sort) . " LIMIT " . $limitStart. ", " . $limitEnd);
	if(!array_key_exists("response", $r)){
		if(!$r["response"] == "ERROR"){
?>
	<tbody id="ctgData">
<?php
		$srno = $limitStart;
		for($i = 0; $i < count($r); $i++){
			$srno++;
			if($i % 2 == 0)
				$class = "lightyellow";
			else
				$class = "darkyellow";
?>
		<tr class="<?php echo $class; ?>" id="batchRow-<?php echo $r[$i]["unique_id"]; ?>">
			<td>
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td><input class="fl" type="checkbox" name="chkBatch[]" id="chk-<?php echo $i; ?>" value="<?php echo $r[$i]["unique_id"]; ?>" onclick="javascript: _checked(this, <?php echo $r[$i]["unique_id"]; ?>);" /></td>
					</tr>
				</table>
			</td>
			<td><?php echo $r[$i]["curriculum_name"]; ?></td>
			<?php
				if($r[$i]["teacher_name"] != "")
					$facilitator = $r[$i]["teacher_name"];
				else{
					$selteacherRS = $db->query("query", "SELECT CONCAT(atm.fname, ' ', atm.lname) as teacher_name FROM avn_teacher_master atm INNER JOIN avn_teacher_batch_mapping atbm ON atm.unique_id = atbm.teacher_id WHERE batch_id = " . $r[$i]["unique_id"]);
					$facilitator = $selteacherRS[0]["teacher_name"];
					unset($selteacherRS);
				}
				if($r[$i]["manager_name"] != "")
					$facilitator = $r[$i]["manager_name"];
				//else{
				//	$selManagerRS = $db->query("query", "SELECT CONCAT(atm.fname, ' ', atm.lname) as Managername FROM avn_centermanager_master atm INNER JOIN avn_manager_center_mapping atbm ON atm.unique_id = atbm.manager_id WHERE manager_id = " . $r[$i]["managerID"]);
				//	print_r($selManagerRS);
				//	$facilitator = $selManagerRS[0]["Managername"];
				//}
			?>
			<td><?php echo $r[$i]["batch_id"]; ?></td>
			<td><?php echo $r[$i]["batch_name"]; ?><br /><small style="color: #a74242;"><?php echo $facilitator; ?> | <?php echo $r[$i]["strength"]; ?></small></td>
			<td><?php echo $r[$i]["city_name"]; ?></td>
			<td><?php echo $r[$i]["center_name"]; ?></td>
			<td>
				
				<a href="edit-batch.php<?php echo filter_querystring($_SERVER["QUERY_STRING"], array("cid","resp","page"), array($r[$i]["unique_id"],"",$curPage)); ?>">Edit</a> | 
				<a href="javascript:void(0);" onclick="javascript:_deletebatch(<?php echo $i; ?>,<?php echo $curPage; ?>)" class="btnDelete">Delete</a>
			</td>
		</tr>
<?php
			}
		}
	}
	unset($r);
?>
		</tbody>
	</table>
	<div class="content">
		<div class="results"></div>
		<?php
			$start = floor(($curPage - 1)/5)*5;
			$start++;
			$end = $start + 5;
			if($end > $noOfpage)
			$end = $noOfpage + 1;
			for($i = $start; $i < $end; $i++)
			{
				if($i == $curPage)
					$nav .= "<a href=\"javascript: void(0);\" class=\"currentPage\">$i</a>";
				else
					$nav .=    " <a href=\"javascript:void(0);\" onclick =\"javascript: _getBatchTable($i, '$field', '$sort');\" class=\"paging\">$i</a>";
			}
			if($curPage > 5)
			{
				$page = $start - 5;
				$prev = " <a href=\"javascript:void(0);\" onclick =\"javascript: _getBatchTable($page, '$field', '$sort');\" class=\"paging\">&lt;&lt;&nbsp;Previous</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			if($noOfpage > 5 && $end <= $noOfpage)
			{
				$page = $start + 5;
				$next = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"javascript:void(0);\" onclick=\"javascript: _getBatchTable($page, '$field', '$sort');\" class=\"paging\">Next&nbsp;&gt;&gt;</a> ";
			}
		?>
		<table cellpadding="5" cellspacing= "0" border ="0" style="border-collapse:collapse; text-align:left; margin-top:15px;"  width='500px' align='center'>
			<tr>
				<input type="hidden" id="pageNo" name="pageNo" value="<?php echo $curPage; ?>" />
				<td align="left"><?php echo $prev . $nav . $next;?></td>
			</tr>
		</table>
	</div><!-- end of content -->
	<div class="popup" id="popupContact"><!--Pop-up for assigning chapters-->
		<a id="popupContactClose" onclick="javascript: _hideFloatingObjectWithID('popupContact');_enableThisPage();">X</a>
		<div class="batchInfo" id="TabheadingBatch"></div>
	</div><!-- end of assigning chapter pop-up -->
	<div class="popup" id="popupContact2"><!--Pop-up for assigning chapters-->
		<a id="popupContactClose2" onclick="javascript: _hideFloatingObjectWithID('popupContact2');_enableThisPage();">X</a>
		<div class="" id="TabheadingBatch2"></div>
	</div><!-- end of assigning chapter pop-up -->
	<div class="popup" id="popupContact1"><!--Pop-up for assigning chapters-->
					<a id="popupContactClose1" onclick="javascript: _hideFloatingObjectWithID('popupContact1');_enableThisPage();">X</a>
					<div class="batchInfo" id="TabheadingBatch1">	
					</div>
				</div><!-- end of assigning chapter pop-up -->
