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
    include("../includes/config.php");		
    include("../classes/cor.mysql.class.php");
    include("../includes/checkLogin.php");
    $db = new MySqlConnection(CONNSTRING);
    $db->open();
    $where = "";
    $sort = "DESC";
    $field = "lglm.unique_id";
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
    $sqlCount = $db->query("query","select count(unique_id) as 'total' from ltf_grade_level_master");
    $recCount = $sqlCount[0]['total'];
    $noOfpage = ceil($recCount/$recPerpage);
    $limitStart = ($curPage - 1) * $recPerpage;
    $limitEnd = $recPerpage;
?>

<table cellspacing="1" cellpadding="3" id="tabGrade" width="100%" border="0" style="background-color:#f5f5f5;" class="mdata">
    <thead>
        <tr style="background-color:#a74242;color:#ffffff;">
            <th width="25px">
		<input type="checkbox" name="chpAll" id="chpAll" onclick="javascript: _checked(this, -1);" style="margin: 0px 0px 0px 15px;" />
	    </th>
            <?php
                if($field == "lglm.grade_name"){
                    if($sort == "asc"){
            ?>
                        <th><a href="javascript:void(0);" onclick="javascript: _getGradeTable(<?php echo $curPage; ?>, 'lglm.grade_name','desc');" class="sort">Grade <img src="./images/up-arr.png" border="0" /></a></th>
            <?php
                    }else{
            ?>
                        <th><a href="javascript:void(0);" onclick="javascript: _getGradeTable(<?php echo $curPage; ?>, 'lglm.grade_name','asc');" class="sort">Grade <img src="./images/down-arr.png" border="0" /></a></th>
            <?php
                        }
                } else {
            ?>
                        <th><a href="javascript:void(0);" onclick="javascript: _getGradeTable(<?php echo $curPage; ?>, 'lglm.grade_name','asc');" class="sort">Grade</a></th>
            <?php
                }
			?>
	    <th>Options</th>
        </tr>
    </thead>
        <?php
            $r = $db->query("query","SELECT lglm.* FROM ltf_grade_level_master lglm ORDER BY " . mysql_escape_string($field) . " " . mysql_escape_string($sort) . " LIMIT " . $limitStart . ", " .$limitEnd . "");
            if(!array_key_exists("response", $r)){
                if(!$r["response"] == "ERROR"){
                    $srno = $limitStart;
                    for($i=0; $i< count($r); $i++){
                        $srno++;
                        if($i % 2 == 0)
                            $class = "lightyellow";
                        else
                            $class = "darkyellow";
        ?>
                <tbody id="gradedata">
                    <tr class="<?php echo $class; ?>" id="graderow-<?php echo $r[$i]["unique_id"]; ?>">
                        <td>
                            <table cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td><input class="fl" type="checkbox" name="chkGrade[]" id="chk-<?php echo $i; ?>" value="<?php echo $r[$i]["unique_id"]; ?>" onclick="javascript: _checked(this, <?php echo $r[$i]["unique_id"]; ?>);" /></td>
                                </tr>
                            </table>
                        </td>
                        <td><?php echo $r[$i]["grade_name"]; ?></td>
			<td>
			    <a href="javascript:void(0);" onclick="javascript: _editGrade(<?php echo $r[$i]["unique_id"]; ?>, <?php echo ($i + 1); ?>);">Edit</a> |
                            <a href="javascript:void(0);" class="btnDelete" onclick="javascript:_deletegrade(<?php echo $i; ?>,<?php echo $curPage; ?>)">Delete</a>
			</td>
                    </tr>
    <?php
                    }
                }
            }
            unset($r);
            $db->query();
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
                $nav .=    " <a href=\"javascript:void(0);\" onclick=\"javascript: _getGradeTable($i);\" class=\"paging\">$i</a>";
        }
        if($curPage > 5)
        {
            $page = $start - 5;
            $prev = " <a href=\"javascript:void(0);\" onclick=\"javascript: _getGradeTable($page);\" class=\"paging\">&lt;&lt;&nbsp;Previous</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        }
        if($noOfpage > 5 && $end <= $noOfpage)
        {
            $page = $start + 5;
            $next = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"javascript:void(0);\" onclick=\"javascript: _getGradeTable($page);\" class=\"paging\">Next&nbsp;&gt;&gt;</a> ";
        }
    ?>
        <table cellpadding="5" cellspacing= "0" border ="0" style="border-collapse:collapse; text-align:left; margin-top:15px;"  width='500px' align='center'>
            <tr>
                <input type="hidden" id="pageNo" name="pageNo" value="<?php echo $curPage; ?>" />
                <td align="left"><?php echo $prev . $nav . $next;?></td>
            </tr>
        </table>
</div><!-- end of content -->