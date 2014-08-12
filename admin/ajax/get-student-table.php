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
	//echo $arrUserInfo["usertype"];
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
	
	$sort = "desc";
	$field = "alm.entry_date";
	if(isset($_POST["sf"]) && $_POST["sf"] != "")
		$field = $_POST["sf"];
	if(isset($_POST["sd"]) && $_POST["sd"] != "")
		$sort = $_POST["sd"];
	
	$pgName = "users";
	$curPage = $_POST["page"];
	if(($curPage == "") || ($curPage == 0))
	$curPage=1;
	$recPerpage = 25;
	$countWhereClause = "";
	$selectWhereClause = "";
	$pageParam="";
	$sqlCount = $db->query("query","select count(alm.unique_id) as 'total' from avn_student_master alm");
	$recCount = $sqlCount[0]['total'];
	$noOfpage = ceil($recCount/$recPerpage);
	$limitStart = ($curPage - 1) * $recPerpage;
	$limitEnd = $recPerpage;
?>
<table cellspacing="1" width="100%" cellpadding="3" id="tabStudent" border="0" style="background-color:#f5f5f5;" class="mdata">
	<thead>
	<tr style="background-color:#a74242;color:#ffffff;">
		<th width="25px">
			<input type="checkbox" name="chpAll" id="chpAll" onclick="javascript: _checked(this, -1);" style="margin: 0px 0px 0px 15px;" />
		</th>
	<?php
            if($field == "alm.student_id"){
                if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'alm.student_id','desc');" class="sort">Student ID <img src="./images/up-arr.png" border="0" /></a></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'alm.student_id','asc');" class="sort">Student ID <img src="./images/down-arr.png" border="0" /></a></th>
    <?php
                }
            }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'alm.student_id','asc');" class="sort">Student ID</a></th>
	<?php
		}
            if($field == "bm.batch_id"){
                if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'bm.batch_id','desc');" class="sort">BatchID <img src="./images/up-arr.png" border="0" /></a></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'bm.batch_id','asc');" class="sort">BatchID <img src="./images/down-arr.png" border="0" /></a></th>
    <?php
                }
            }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'bm.batch_id','asc');" class="sort">BatchID</a></th>
	<?php
		}
            if($field == "alm.fname"){
                if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'alm.fname','desc');" class="sort">Name <img src="./images/up-arr.png" border="0" /></a></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'alm.fname','asc');" class="sort">Name <img src="./images/down-arr.png" border="0" /></a></th>
    <?php
                }
            }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'alm.fname','asc');" class="sort">Name</a></th>
	<?php
		}
		if($field == "alm.email_id"){
			if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'alm.email_id','desc');" class="sort">Contact</a></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'alm.email_id','asc');" class="sort">Contact</a></th>
    <?php
                }
            }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'alm.email_id','asc');" class="sort">Contact</a></th>
	<?php
		}
	if($field == "alm.address"){
                if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'alm.address','desc');" class="sort">Address <img src="./images/up-arr.png" border="0" /></a></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'alm.address','asc');" class="sort">Address <img src="./images/down-arr.png" border="0" /></a></th>
    <?php
                }
            }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'alm.address','asc');" class="sort">Address</a></th>
	<?php
			}
	if($field == "alm.school"){
                if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'alm.school','desc');" class="sort">School <img src="./images/up-arr.png" border="0" /></a></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'alm.school','asc');" class="sort">School <img src="./images/down-arr.png" border="0" /></a></th>
    <?php
                }
            }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getStudentTable(<?php echo $curPage; ?>, 'alm.status','asc');" class="sort">School</a></th>
	<?php
		}
	?>
	<th>Options</th>
	</tr>
	</thead>
<?php
	if($arrUserInfo["usertype"] == "Teacher"){
		$teacherID = $arrUserInfo["user_ref_id"];
		$r = $db->query("query","SELECT alm.*, bm.batch_id as 'BatchID' FROM avn_student_master alm INNER JOIN avn_batch_master bm ON bm.unique_id = alm.batch_id INNER JOIN avn_teacher_batch_mapping atbm ON atbm.batch_id = alm.batch_id WHERE atbm.teacher_id = " . $teacherID . " ORDER BY " . mysql_escape_string($field) . " " . mysql_escape_string($sort) . " LIMIT " . $limitStart. ", " . $limitEnd);
	}
	else{
		$r = $db->query("query","SELECT alm.*,bm.batch_id as 'BatchID' FROM avn_student_master alm INNER JOIN avn_batch_master bm ON bm.unique_id = alm.batch_id ORDER BY " . mysql_escape_string($field) . " " . mysql_escape_string($sort) . " LIMIT " . $limitStart. ", " . $limitEnd);
	}
	//print_r($r);
	?>
	<tbody id="usersdata">
	<?php
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
	
		<tr class="<?php echo $class; ?>" id="StudentRow-<?php echo $r[$i]["unique_id"]; ?>">
			<td>
				<table>
					<tr>
						<td>
							<input class="fl" type="checkbox" name="chkStudent[]" id="chk-<?php echo $i; ?>" value="<?php echo $r[$i]["unique_id"]; ?>" onclick="javascript: _checked(this, <?php echo $r[$i]["unique_id"]; ?>);" />
						</td>
					</tr>
				</table>
			</td>
			<td><?php echo $r[$i]["student_id"]; ?></td>
			<td><?php echo $r[$i]["BatchID"]; ?></td>
			
			<td><?php echo $r[$i]["fname"]; ?>&nbsp;<?php echo $r[$i]["lname"]; ?><br />
			<?php
			if($r[$i]["gender"] == 1){
			?>
					<small style="color: #0e8a39;">Male</small><small> |</small>
			<?php
				}else if($r[$i]["gender"] == 2){
			?>
					<small style="color: #e21680">Female</small><small> |</small>
			<?php
				}
			
					if($r[$i]["status"] == 1){  
			?>
					<a href="javascript:void(0);" onclick="javascript: _changestudentstatus(<?php echo $i; ?>,1,<?php echo $curPage; ?>,this);" style="color: #3c6435;"><small><span id="active-<?php echo $i; ?>"><?php echo "Active"; ?></span></small></a>
			<?php
				    }else{
			?>
					<a href="javascript:void(0);" onclick="javascript: _changestudentstatus(<?php echo $i; ?>,0,<?php echo $curPage; ?>,this);" style="color: #f00;"><small><span id="active-<?php echo $i; ?>"><?php echo "Inactive"; ?></span></small></a>
			<?php
				    }
					?>
			</td>
			<td><?php echo $r[$i]["email_id"]; ?><br /><small style="color:#0dc7f5;"><?php echo $r[$i]["phone"]; ?></small></td>
			<td><?php echo $r[$i]["address"]; ?></td> 
			<td><?php echo $r[$i]["school"]; ?><br /><small style="color: #c51a46;"><?php echo $r[$i]["board"]; ?></small></td>
			<td>
				<a href="edit-student.php<?php echo filter_querystring($_SERVER["QUERY_STRING"], array("cid","resp","page") , array($r[$i]["unique_id"],"",$curPage)); ?>">Edit</a> |
				<a href="javascript:void(0);" class="btnDelete" onclick="javascript: _deletestudent(<?php echo $i; ?>,<?php echo $curPage; ?>)">Delete</a>
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
		for($i = $start; $i < $end; $i++){
			if($i == $curPage)
				$nav .= "<a href=\"javascript: void(0);\" class=\"currentPage\">$i</a>";
			else
				$nav .=    " <a href=\"javascript: void(0);\" onclick=\"javascript: _getStudentTable($i, '$field', '$sort');\" class=\"paging\">$i</a>";
		}
		if($curPage > 5){
			$page = $start - 5;
			$prev = " <a href=\"javascript:void(0);\" onclick=\"javascript: _getStudentTable($page, '$field', '$sort');\" class=\"paging\">&lt;&lt;&nbsp;Previous</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		if($noOfpage > 5 && $end <= $noOfpage)
		{
			$page = $start + 5;
			$next = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"javascript:void(0);\" onclick=\"javascript: _getStudentTable($page, '$field', '$sort');\" class=\"paging\">Next&nbsp;&gt;&gt;</a> ";
		}
	?>
	<table cellpadding="5" cellspacing= "0" border ="0" style="border-collapse:collapse; text-align:left; margin-top:15px;"  width='500px' align='center'>
		<tr>
			<input type="hidden" id="pageNo" name="pageNo" value="<?php echo $curPage; ?>" />
			<td align="left"><?php echo $prev . $nav . $next;?></td>
		</tr>
	</table>
</div><!-- end of content -->