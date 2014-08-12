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
	$field = "actm.entry_date";
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
	$sqlCount = $db->query("query","select count(abm.unique_id) as 'total' from avn_chapter_test_master abm");
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
	 if($field == "acrm.name"){
                if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getChapterTestTable(<?php echo $curPage; ?>, 'acrm.name','desc');" class="sort">Name <img src="./images/up-arr.png" border="0" /></a></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getChapterTestTable(<?php echo $curPage; ?>, 'acrm.name','asc');" class="sort">Name <img src="./images/down-arr.png" border="0" /></a></th>
    <?php
                }
            }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getChapterTestTable(<?php echo $curPage; ?>, 'acrm.name','asc');" class="sort">Name</a></th>
	<?php
		}
           if($field == "acm.chapter_name"){
                if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getChapterTestTable(<?php echo $curPage; ?>, 'acm.chapter_name','desc');" class="sort">Chapter <img src="./images/up-arr.png" border="0" /></a></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getChapterTestTable(<?php echo $curPage; ?>, 'acm.chapter_name','asc');" class="sort">Chapter <img src="./images/down-arr.png" border="0" /></a></th>
    <?php
                }
            }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getChapterTestTable(<?php echo $curPage; ?>, 'acm.chapter_name','asc');" class="sort">Chapter</a></th>
	<?php
			}
			  if($field == "actm.duration"){
                if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getChapterTestTable(<?php echo $curPage; ?>, 'actm.duration','desc');" class="sort">Duration <img src="./images/up-arr.png" border="0" /></a></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getChapterTestTable(<?php echo $curPage; ?>, 'actm.duration','asc');" class="sort">Duration <img src="./images/down-arr.png" border="0" /></a></th>
    <?php
                }
            }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getChapterTestTable(<?php echo $curPage; ?>, 'actm.duration','asc');" class="sort">Duration</a></th>
	<?php
		}
    ?>
        <th>Action</th>
	</tr>
	</thead>
<?php
	$r = $db->query("query","SELECT acm.chapter_name,actm.unique_id,actm.name,actm.duration,actm.entry_date FROM avn_chapter_test_master actm INNER JOIN avn_chapter_master acm ON acm.unique_id =  actm.chapter_id ORDER BY " . mysql_escape_string($field) . " " . mysql_escape_string($sort) . " LIMIT " . $limitStart. ", " . $limitEnd);
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
			<td><?php echo $r[$i]["name"]; ?></td>
                        <td><?php echo $r[$i]["chapter_name"]; ?></td>
                        <td><?php echo $r[$i]["duration"]; ?></td>
			<td>
                            <a href="edit-chapter-test.php<?php echo filter_querystring($_SERVER["QUERY_STRING"], array("cid","resp","page"), array($r[$i]["unique_id"],"",$curPage)); ?>">Edit </a>|
			    <a href="javascript:void(0);" onclick="javascript:_deleteChapterTest(<?php echo $i; ?>,<?php echo $curPage; ?>)" class="btnDelete">Delete</a>
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
					$nav .=    " <a href=\"javascript:void(0);\" onclick =\"javascript: _getChapterTestTable($i, '$field', '$sort');\" class=\"paging\">$i</a>";
			}
			if($curPage > 5)
			{
				$page = $start - 5;
				$prev = " <a href=\"javascript:void(0);\" onclick =\"javascript: _getChapterTestTable($page, '$field', '$sort');\" class=\"paging\">&lt;&lt;&nbsp;Previous</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			if($noOfpage > 5 && $end <= $noOfpage)
			{
				$page = $start + 5;
				$next = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"javascript:void(0);\" onclick=\"javascript: _getChapterTestTable($page, '$field', '$sort');\" class=\"paging\">Next&nbsp;&gt;&gt;</a> ";
			}
		?>
		<table cellpadding="5" cellspacing= "0" border ="0" style="border-collapse:collapse; text-align:left; margin-top:15px;"  width='500px' align='center'>
			<tr>
				<input type="hidden" id="pageNo" name="pageNo" value="<?php echo $curPage; ?>" />
				<td align="left"><?php echo $prev . $nav . $next;?></td>
			</tr>
		</table>
	</div><!-- end of content -->