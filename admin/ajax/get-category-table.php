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
    $field = "lcm.unique_id";
	 if(isset($_POST["sf"]) && $_POST["sf"] != "")
        $field = $_POST["sf"];
    if(isset($_POST["sd"]) && $_POST["sd"] != "")
        $sort = $_POST["sd"];
	if(isset($_POST["currid"]) && $_POST["currid"] != "" && $_POST["currid"] != "0"){
        $currid = $_POST["currid"];
        $where .= $where == "" ? "lcm.curriculum_id = " . mysql_escape_string($currid) : " AND lcm.curriculum_id = " . mysql_escape_string($currid);
    }
	
	$curPage = $_POST["page"];
	if(($curPage == "") || ($curPage == 0))
		$curPage=1;
	$recPerpage = 25;
	$countWhereClause = "";
	$selectWhereClause = "";
	$pageParam="";
	$sql = "select count(lcm.unique_id) as 'total' from ltf_category_master lcm";
	if($where != "")
		$sql .= " WHERE " . $where;
	$sqlCount = $db->query("query", $sql);
	$recCount = $sqlCount[0]['total'];
	$noOfpage = ceil($recCount/$recPerpage);
	$limitStart = ($curPage - 1) * $recPerpage;
	$limitEnd = $recPerpage;
?>
<table cellspacing="1" cellpadding="3" id="tabCategory" width="100%" border="0" style="background-color:#f5f5f5;" class="mdata">
	<thead>
	<tr style="background-color:#A74242;color:#ffffff;">
		<th width="25px">
			<input type="checkbox" name="catgAll" id="catgAll"  onclick="javascript: _checked(this, -1);" style="margin-left: 15px;" />
		</th>
	<?php
	    if($field == "acm.curriculum_name"){
                if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getCategoryTable(<?php echo $currid; ?>,<?php echo $curPage; ?>, 'acm.curriculum_name','desc');" class="sort">Curriculum<img src="./images/up-arr.png" border="0" /></a></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getCategoryTable(<?php echo $currid; ?>,<?php echo $curPage; ?>, 'acm.curriculum_name','asc');" class="sort">Curriculum<img src="./images/down-arr.png" border="0" /></a></th>
    <?php
                }
            }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getCategoryTable(<?php echo $currid; ?>,<?php echo $curPage; ?>, 'acm.curriculum_name','asc');" class="sort">Curriculum</a></th>
	<?php
			}
            if($field == "lcm.category_name"){
                if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getCategoryTable(<?php echo $currid; ?>,<?php echo $curPage; ?>, 'lcm.category_name','desc');" class="sort">Subject<img src="./images/up-arr.png" border="0" /></a></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getCategoryTable(<?php echo $currid; ?>,<?php echo $curPage; ?>, 'lcm.category_name','asc');" class="sort">Subject<img src="./images/down-arr.png" border="0" /></a></th>
    <?php
                }
            }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getCategoryTable(<?php echo $curPage; ?>, 'lcm.category_name','asc');" class="sort">Subject</a></th>
	<?php
			}
            if($field == "lcm.prefix"){
                if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getCategoryTable(<?php echo $curPage; ?>, 'lcm.prefix','desc');" class="sort">Prefix<img src="./images/up-arr.png" border="0" /></a></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getCategoryTable(<?php echo $currid; ?>,<?php echo $curPage; ?>, 'lcm.prefix','asc');" class="sort">Prefix<img src="./images/down-arr.png" border="0" /></a></th>
    <?php
                }
            }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getCategoryTable(<?php echo $currid; ?>,<?php echo $curPage; ?>, 'lcm.prefix','asc');" class="sort">Prefix</a></th>
	<?php
			}
	?>
		<th>Options</th>
	</tr>
	</thead>
<?php
	$sql = "SELECT lcm.*, acm.curriculum_name, acm.unique_id as currid FROM ltf_category_master lcm INNER JOIN avn_curriculum_master acm ON acm.unique_id = lcm.curriculum_id";
	if($where != "")
		$sql .= " WHERE " . $where;
	$sql .= " ORDER BY " . mysql_escape_string($field) . " " . mysql_escape_string($sort) . " LIMIT " . $limitStart. ", " . $limitEnd;
	$r = $db->query("query", $sql);
	if(!array_key_exists("response", $r)){
		if(!$r["response"] == "ERROR"){
?>
	<tbody id="ctgData">
<?php
		$srno = $limitStart;
		for($i=0; $i< count($r); $i++){
			$srno++;
			if($i % 2 == 0)
				$class = "lightyellow";
			else
				$class = "darkyellow";
			$sql = "SELECT COUNT(unique_id) as 'Chapters' FROM avn_chapter_master WHERE category_id = " . $r[$i]["unique_id"];
			$chapter = $db->query("query", $sql);
			$chapterCount = 0;
			if(!array_key_exists("response", $chapter))
			$chapterCount = $chapter[0]["Chapters"];
			unset($chapter);
?>
		<tr class="<?php echo $class; ?>" id="catRow-<?php echo $r[$i]["unique_id"]; ?>">
			<td>
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td><input class="fl" type="checkbox" name="chkCategory[]" id="chk-<?php echo $i; ?>" value="<?php echo $r[$i]["unique_id"]; ?>" onclick="javascript: _checked(this, <?php echo $r[$i]["unique_id"]; ?>);" /></td>
					</tr>
				</table>
			</td>
			<td><?php echo $r[$i]["curriculum_name"]; ?></td>
			<td><?php echo $r[$i]["category_name"]; ?></td>
			<td><?php echo $r[$i]["prefix"]; ?></td>
			<td>
				<a href="add-category.php<?php echo filter_querystring($_SERVER["QUERY_STRING"], array("currid","cid","resp","page"), array($r[$i]["currid"], $r[$i]["unique_id"],"",$curPage)); ?>" class="ftblack">Edit</a> | 
				<a href="javascript:void(0);" onclick="javascript:_deletesubject(<?php echo $r[$i]["currid"]; ?>,<?php echo $i; ?>,<?php echo $curPage; ?>)" class="btnDelete">Delete</a> |
				<a href="chapter.php?currid=<?php echo $r[$i]["currid"]; ?>&catgid=<?php echo $r[$i]["unique_id"]; ?>" class="ftblack">Chapters</a> (<?php echo $chapterCount; ?>)
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
					$nav .=    " <a href=\"javascript:void(0);\" onclick =\"javascript: _getCategoryTable($currid,$i, '$field', '$sort');\" class=\"paging\">$i</a>";
			}
			if($curPage > 5)
			{
				$page = $start - 5;
				$prev = " <a href=\"javascript:void(0);\" onclick =\"javascript: _getCategoryTable($currid,$page, '$field', '$sort');\" class=\"paging\">&lt;&lt;&nbsp;Previous</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			if($noOfpage > 5 && $end <= $noOfpage)
			{
				$page = $start + 5;
				$next = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"javascript:void(0);\" onclick=\"javascript: _getCategoryTable($currid,$page, '$field', '$sort');\" class=\"paging\">Next&nbsp;&gt;&gt;</a> ";
			}
		?>
		<table cellpadding="5" cellspacing= "0" border ="0" style="border-collapse:collapse; text-align:left; margin-top:15px;"  width='500px' align='center'>
			<tr>
				<input type="hidden" id="pageNo" name="pageNo" value="<?php echo $curPage; ?>" />
				<td align="left"><?php echo $prev . $nav . $next;?></td>
			</tr>
		</table>
	</div><!-- end of content -->