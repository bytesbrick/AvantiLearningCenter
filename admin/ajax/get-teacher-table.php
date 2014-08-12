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
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
	
	$sort = "DESC";
	$field = "alm.unique_id";
	if(isset($_POST["sf"]) && $_POST["sf"] != "")
		$field = $_POST["sf"];
	if(isset($_POST["sd"]) && $_POST["sd"] != "")
		$sort = $_POST["sd"];
	
	$pgName = "teachers";
	$curPage = $_POST["page"];
	if(($curPage == "") || ($curPage == 0))
	$curPage=1;
	$recPerpage = 25;
	$countWhereClause = "";
	$selectWhereClause = "";
	$pageParam="";
	$sqlCount = $db->query("query","select count(alm.unique_id) as 'total' from avn_teacher_master alm");
	$recCount = $sqlCount[0]['total'];
	$noOfpage = ceil($recCount/$recPerpage);
	$limitStart = ($curPage - 1) * $recPerpage;
	$limitEnd = $recPerpage;
?>
<table cellspacing="1" width="100%" cellpadding="3" id="tabTeacher" border="0" style="background-color:#f5f5f5;" class="mdata">
	<thead>
	<tr style="background-color:#a74242;color:#ffffff;">
		<th width="25px">
			<input type="checkbox" name="chpAll" id="chpAll" onclick="javascript: _checked(this, -1);" style="margin: 0px 0px 0px 15px;" />
		</th>
	<?php
            if($field == "alm.teacher_id"){
                if($sort == "asc"){
	?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'alm.teacher_id','desc');" class="sort">Teacher ID <img src="./images/up-arr.png" border="0" /></a></th>
	<?php
                }else{
	?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'alm.teacher_id','asc');" class="sort">Teacher ID <img src="./images/down-arr.png" border="0" /></a></th>
	<?php
                }
            }else{
	?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'alm.teacher_id','asc');" class="sort">Teacher ID</a></th>
	<?php
			}
            if($field == "alm.fname"){
                if($sort == "asc"){
	?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'alm.fname','desc');" class="sort">Teacher Name <img src="./images/up-arr.png" border="0" /></a><br /><small>Gender | Status</small></th>
	<?php
                }else{
	?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'alm.fname','asc');" class="sort">Teacher Name <img src="./images/down-arr.png" border="0" /></a><br /><small>Gender | Status</small></th>
	<?php
                }
            }else{
	?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'alm.fname','asc');" class="sort">Teacher Name</a><br /><small>Gender | Status</small></th>
	<?php
		}
            if($field == "alm.email_id"){
                if($sort == "asc"){
	?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'alm.email_id','desc');" class="sort">Email <img src="./images/up-arr.png" border="0" /></a></th>
	<?php
                }else{
	?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'alm.email_id','asc');" class="sort">Email <img src="./images/down-arr.png" border="0" /></a></th>
	<?php
                }
            }else{
	?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'alm.email_id','asc');" class="sort">Email</a></th>
	<?php
		}
		if($field == "alm.city_name"){
                if($sort == "asc"){
	?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'alm.city_name','desc');" class="sort">City Name <img src="./images/up-arr.png" border="0" /></a></th>
	<?php
                }else{
	?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'alm.city_name','asc');" class="sort">City Name <img src="./images/down-arr.png" border="0" /></a></th>
	<?php
                }
            }else{
	?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'alm.city_name','asc');" class="sort">City Name</a></th>
	<?php
		}
		if($field == "alm.phone"){
			if($sort == "asc"){
	?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'alm.phone','desc');" class="sort">Phone <img src="./images/up-arr.png" border="0" /></a></th>
	<?php
                }else{
	?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'alm.phone','asc');" class="sort">Phone <img src="./images/down-arr.png" border="0" /></a></th>
	<?php
                }
            }else{
	?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'alm.phone','asc');" class="sort">Phone</a></th>
	<?php
			}
	?>
		<th>Options</th>
	</tr>
	</thead>
<?php
	$r = $db->query("query","SELECT alm.*,acm.city_name, alm.city_id,lm.status as 'statuslogin'  FROM avn_teacher_master alm INNER JOIN avn_city_master acm ON acm.unique_id = alm.city_id INNER JOIN avn_login_master lm ON lm.user_ref_id = alm.unique_id ORDER BY " . mysql_escape_string($field) . " " . mysql_escape_string($sort) . " LIMIT " . $limitStart. ", " . $limitEnd);
	if(!array_key_exists("response", $r))
	{
		if(!$r["response"] == "ERROR")
		{
			$srno = $limitStart;
			for($i=0; $i< count($r); $i++)
			{
				$srno++;
				if($i % 2 == 0)
					$class = "lightyellow";
				else
					$class = "darkyellow";
?>
	<tbody id="usersdata">
		<tr class="<?php echo $class; ?>" id="TeacherRow-<?php echo $r[$i]["unique_id"]; ?>">
			<td>
				<table>
					<tr>
						<td>
							<input class="fl" type="checkbox" name="chkTeacher[]" id="chk-<?php echo $i; ?>" value="<?php echo $r[$i]["unique_id"]; ?>" onclick="javascript: _checked(this, <?php echo $r[$i]["unique_id"]; ?>);" />
						</td>
					</tr>
				</table>
			</td>
			<td><?php echo $r[$i]["teacher_id"]; ?></td>
			<td><?php echo $r[$i]["fname"]; ?>&nbsp;<?php echo $r[$i]["lname"]; ?><br />
				<?php
					if($r[$i]["gender"] == 1){
				?>
						<small style="color:#0e8a39;">Male</small> <small>|</small>
				<?php
					}else if($r[$i]["gender"] == 2){
				?>
						<small style="color:#e21680;">Female</small> <small>|</small>
				<?php
					}
					if($r[$i]["statuslogin"] == 1){
				?> 
				<a href="javascript:void(0);" onclick="javascript: _changeteacherstatus(<?php echo $i; ?>,1,<?php echo $curPage; ?>,this);" style="color: #3c6435;"><small><span id="active-<?php echo $i; ?>"><?php echo "Active"; ?></span></small></a>
				<?php
					}elseif($r[$i]["statuslogin"] == 0){
				?>
				<a href="javascript:void(0);" onclick="javascript: _changeteacherstatus(<?php echo $i; ?>,0,<?php echo $curPage; ?>,this);" style="color: #f00;"><small><span id="active-<?php echo $i; ?>"><?php echo "Inactive"; ?></span></small></a>
				<?php
					}
				?>
			</td>
			<td><?php echo $r[$i]["email_id"]; ?></td>
			<td><?php echo $r[$i]["city_name"]; ?></td>
			<td><?php echo $r[$i]["phone"]; ?></td>
		
		<td>
			<a href="edit-teacher.php<?php echo filter_querystring($_SERVER["QUERY_STRING"], array("cid","resp","page") , array($r[$i]["unique_id"],"",$curPage)); ?>">Edit</a> |
			<a href="javascript:void(0);" class="btnDelete" onclick="javascript: _deleteteacher(<?php echo $i; ?>,<?php echo $curPage; ?>)">Delete</a> |
			<a href="javascript:void(0);" onclick="javascript: _disableThisPage();_setDivPos('popupContact'); _batchAssigntoTeacher(<?php echo $r[$i]["city_id"]; ?>,<?php echo $r[$i]["unique_id"]; ?>)">Assign Batch</a>
		</td>
	</tr>
	<?php
				}
			}
		}
		unset($r);
		$db->close();
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
				$nav .=    " <a href=\"javascript: void(0);\" onclick=\"javascript: _getTeacherTable($i, '$field', '$sort');\" class=\"paging\">$i</a>";
		}
		if($curPage > 5)
		{
			$page = $start - 5;
			$prev = " <a href=\"javascript:void(0);\" onclick=\"javascript: _getTeacherTable($page, '$field', '$sort');\" class=\"paging\">&lt;&lt;&nbsp;Previous</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		if($noOfpage > 5 && $end <= $noOfpage)
		{
			$page = $start + 5;
			$next = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"javascript:void(0);\" onclick=\"javascript: _getTeacherTable($page, '$field', '$sort');\" class=\"paging\">Next&nbsp;&gt;&gt;</a> ";
		}
	?>
	<table cellpadding="5" cellspacing= "0" border ="0" style="border-collapse:collapse; text-align:left; margin-top:15px;"  width='500px' align='center'>
		<tr>
			<input type="hidden" id="pageNo" name="pageNo" value="<?php echo $curPage; ?>" />
			<td align="left"><?php echo $prev . $nav . $next;?></td>
		</tr>
	</table>
</div><!-- end of content -->
<div class="popup" id="popupContact"><!--Pop-up for assigning batches-->
	<a id="popupContactClose" onclick="javascript: _hideFloatingObjectWithID('popupContact');_enableThisPage();">X</a>
	<div class="batchInfo" id="TabheadingBatch"></div>
</div><!-- end of assigning batches to Teacher pop-up -->