<?php
	include_once("../includes/config.php");  
	include("../classes/cor.mysql.class.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
	$where = "";
	$sort = "DESC";
	$field = "acm.unique_id";
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
	$sqlCount = $db->query("query","select count(unique_id) as 'total' from avn_curriculum_master");
	$recCount = $sqlCount[0]['total'];
	$noOfpage = ceil($recCount/$recPerpage);
	$limitStart = ($curPage - 1) * $recPerpage;
	$limitEnd = $recPerpage;
	
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
?>
<table cellspacing="1" cellpadding="3" id="tabCurriculums" width="100%" border="0" style="background-color:#f5f5f5;" class="mdata">
	<thead>
		<tr style="background-color:#A74242;color:#ffffff;">
			 <th width="25px">
				<input type="checkbox" name="chpAll" id="chpAll" onclick="javascript: _checked(this, -1);" style="margin: 0px 0px 0px 15px;" />
			</th>
	   <?php
                if($field == "acm.curriculum_name"){
                    if($sort == "asc"){
            ?>
                        <th><a href="javascript:void(0);" onclick="javascript: _getCurriculumTable(<?php echo $curPage; ?>, 'acm.curriculum_name','desc');" class="sort">Curriculum <img src="./images/up-arr.png" border="0" /></a></th>
            <?php
                    }else{
            ?>
                        <th><a href="javascript:void(0);" onclick="javascript: _getCurriculumTable(<?php echo $curPage; ?>, 'acm.curriculum_name','asc');" class="sort">Curriculum <img src="./images/down-arr.png" border="0" /></a></th>
            <?php
                        }
                } else {
            ?>
                        <th><a href="javascript:void(0);" onclick="javascript: _getCurriculumTable(<?php echo $curPage; ?>, 'acm.curriculum_name','asc');" class="sort">Curriculum</a></th>
            <?php
                }
		if($field == "acm.curriculum_id"){
                    if($sort == "asc"){
            ?>
                        <th><a href="javascript:void(0);" onclick="javascript: _getCurriculumTable(<?php echo $curPage; ?>, 'acm.curriculum_id','desc');" class="sort">Curriculum ID <img src="./images/up-arr.png" border="0" /></a></th>
            <?php
                    }else{
            ?>
                        <th><a href="javascript:void(0);" onclick="javascript: _getCurriculumTable(<?php echo $curPage; ?>, 'acm.curriculum_id','asc');" class="sort">Curriculum ID <img src="./images/down-arr.png" border="0" /></a></th>
            <?php
                        }
                } else {
            ?>
                        <th><a href="javascript:void(0);" onclick="javascript: _getCurriculumTable(<?php echo $curPage; ?>, 'acm.curriculum_id','asc');" class="sort">Curriculum ID</a></th>
            <?php
                }
				if($field == "acm.current_year"){
                    if($sort == "asc"){
            ?>
                        <th><a href="javascript:void(0);" onclick="javascript: _getCurriculumTable(<?php echo $curPage; ?>, 'acm.current_year','desc');" class="sort">Academic Year <img src="./images/up-arr.png" border="0" /></a></th>
            <?php
                    }else{
            ?>
                        <th><a href="javascript:void(0);" onclick="javascript: _getCurriculumTable(<?php echo $curPage; ?>, 'acm.current_year','asc');" class="sort">Academic Year <img src="./images/down-arr.png" border="0" /></a></th>
            <?php
                        }
                } else {
            ?>
                        <th><a href="javascript:void(0);" onclick="javascript: _getCurriculumTable(<?php echo $curPage; ?>, 'acm.current_year','asc');" class="sort">Academic Year</a></th>
            <?php
                }
				if($field == "acm.class"){
                    if($sort == "asc"){
            ?>
                        <th><a href="javascript:void(0);" onclick="javascript: _getCurriculumTable(<?php echo $curPage; ?>, 'acm.class','desc');" class="sort">Class <img src="./images/up-arr.png" border="0" /></a></th>
            <?php
                    }else{
            ?>
                        <th><a href="javascript:void(0);" onclick="javascript: _getCurriculumTable(<?php echo $curPage; ?>, 'acm.class','asc');" class="sort">Class <img src="./images/down-arr.png" border="0" /></a></th>
            <?php
                        }
                } else {
            ?>
                        <th><a href="javascript:void(0);" onclick="javascript: _getCurriculumTable(<?php echo $curPage; ?>, 'acm.class','asc');" class="sort">Class</a></th>
            <?php
                }
			?>
		</tr>
	</thead>
<?php
$r = $db->query("query","SELECT acm.* FROM avn_curriculum_master acm ORDER BY " . mysql_escape_string($field) . " " . mysql_escape_string($sort) . " LIMIT " . $limitStart . ", " .$limitEnd . "");
	if(!array_key_exists("response", $r)){
		$srno = $limitStart;
		for($i=0; $i< count($r); $i++){
			$srno++;
				if($i % 2 == 0)
					$class = "lightyellow";
				else
					$class = "darkyellow";
			$sqlSubjCount = $db->query("query","select count(unique_id) as 'total' from ltf_category_master WHERE curriculum_id = " . $r[$i]["unique_id"]);
			$subjCount = $sqlSubjCount[0]['total'];
?>
	<tbody id="curdata">
	<tr class="<?php echo $class; ?>" id="curdatarow-<?php echo $i; ?>">
		<td>
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td><input class="fl" type="checkbox" name="chkCurriculum[]" id="chk-<?php echo $i; ?>" value="<?php echo $r[$i]["unique_id"]; ?>" onclick="javascript: _checked(this, <?php echo $i; ?>);" />
                    </td>
			<td>
				<div class="multimenu"><img src="./images/options.png" title="More actions" />
					<div class="cb"></div>
					<label>
						<ul>
							<li class="settings p1"><a href="edit-curriculum.php<?php echo filter_querystring($_SERVER["QUERY_STRING"], array("cid","page","resp"), array($r[$i]["unique_id"],$curPage,"")); ?>">Edit</a></li>
							<li class="settings p2"><a href="javascript:void(0);" class="btnDelete" onclick="javascript:_deleteCurriculum(<?php echo $i; ?>,<?php echo $curPage; ?>)">Delete</a></li>
							<li class="settings p2"><a href="./category.php?currid=<?php echo $r[$i]["unique_id"]; ?>">Subjects (<?php echo $subjCount; ?>)</a></li>
						</ul>
					</label>
				</div> 
			</td>
		</tr>
	</table>
			<?php
				$curyear =   $r[$i]["current_year"];
				$nextyear =   str_ireplace("20", "-", $r[$i]["next_year"]);
			?>
		<td><?php echo $r[$i]["curriculum_name"]; ?></td>
		<td><?php echo $r[$i]["curriculum_id"]; ?></td>
		<td><?php echo $curyear.$nextyear; ?></td>
		<td><?php echo $r[$i]["class"]; ?></td>
	</tr>
<?php
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
				$nav .=    "<a href=\"javascript: void(0);\" onclick=\"javascript: _getCurriculumTable($i);\" class=\"paging\">$i</a>";
		}
		if($curPage > 5)
		{
			$page = $start - 5;
			$prev = " <a href=\"javascript: void(0);\" onclick=\"javscript: _getCurriculumTable($page);\" class=\"paging\">&laquo;&nbsp;Previous</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		if($noOfpage > 5 && $end <= $noOfpage)
		{
			$page = $start + 5;
			$next = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"javascript: void(0);\" onclick=\"javscript: _getCurriculumTable($page);\" class=\"paging\">Next&nbsp;&raquo;</a> ";
		}
	?>
	<table cellpadding="5" cellspacing= "0" border ="0" style="border-collapse:collapse; text-align:left; margin-top:15px;"  width='500px' align='center'>
		<tr>
			<input type="hidden" id="pageNo" name="pageNo" value="<?php echo $curPage; ?>" />
			<td align="left"><?php echo $prev . $nav . $next;?></td>
		</tr>
	</table>
</div><!-- end of content -->