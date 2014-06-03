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
            $qString = "?" . $qString;
        return $qString;
    }
    
    $pgName = "chapters";
    include_once("../includes/config.php");  
    include("../classes/cor.mysql.class.php");
    $db = new MySqlConnection(CONNSTRING);
    $db->open();
    $where = "";
    $sort = "DESC";
    $field = "acm.unique_id";
    $catgid = 0;
    if(isset($_POST["sf"]) && $_POST["sf"] != "")
        $field = $_POST["sf"];
    if(isset($_POST["sd"]) && $_POST["sd"] != "")
        $sort = $_POST["sd"];
    if(isset($_POST["catgid"]) && $_POST["catgid"] != "" && $_POST["catgid"] != "0"){
        $catgid = $_POST["catgid"];
        $where .= $where == "" ? "acm.category_id = " . mysql_escape_string($catgid) : " AND acm.category_id = " . mysql_escape_string($catgid);
    }
    $currid = 0;
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
    $sql = "select count(acm.unique_id) as 'total' from avn_chapter_master acm";
    if($where != "")
        $sql .= " WHERE " . $where;
    $sqlCount = $db->query("query", $sql);
    $recCount = $sqlCount[0]['total'];
    $noOfpage = ceil($recCount/$recPerpage);
    $limitStart = ($curPage - 1) * $recPerpage;
    $limitEnd = $recPerpage;
    
    $sqlSubjects = "select unique_id, category_name from ltf_category_master lcm";
    $rsSubjects = $db->query("query", $sqlSubjects);
?>
<table cellspacing="1" cellpadding="3" id="tabChapters" width="100%" border="0" style="background-color:#f5f5f5;" class="mdata">
    <thead>
        <tr style="background-color:#a74242;color:#ffffff;">
            <th width="25px">
                <input type="checkbox" name="chpAll" id="chpAll" onclick="javascript: _checked(this, -1);" style="margin: 0px 0px 0px 15px;" />
            </th>
            <?php
                if($field == "lcm.category_name"){
                    if($sort == "asc"){
            ?>
                        <th><a href="javascript:void(0);" onclick="javascript: _getChapterTable(<?php echo $currid; ?>,<?php echo $catgid; ?>, <?php echo $curPage; ?>, 'lcm.category_name','desc');" class="sort">Subject <img src="./images/up-arr.png" border="0" /></a></th>
            <?php
                    }else{
            ?>
                        <th><a href="javascript:void(0);" onclick="javascript: _getChapterTable(<?php echo $currid; ?>,<?php echo $catgid; ?>, <?php echo $curPage; ?>, 'lcm.category_name','asc');" class="sort">Subject <img src="./images/down-arr.png" border="0" /></a></th>
            <?php
                        }
                } else {
            ?>
                        <th><a href="javascript:void(0);" onclick="javascript: _getChapterTable(<?php echo $currid; ?>,<?php echo $catgid; ?>, <?php echo $curPage; ?>, 'lcm.category_name','asc');" class="sort">Subject</a></th>
            <?php
                }
                if($field == "acm.chapter_name"){
                    if($sort == "asc"){
            ?>
                        <th><a href="javascript:void(0);" onclick="javascript: _getChapterTable(<?php echo $currid; ?>,<?php echo $catgid; ?>, <?php echo $curPage; ?>, 'acm.chapter_name','desc');" class="sort">Chapter <img src="./images/up-arr.png" border="0" /></a></th>
            <?php
                    }else{
            ?>
                        <th><a href="javascript:void(0);" onclick="javascript: _getChapterTable(<?php echo $currid; ?>,<?php echo $catgid; ?>, <?php echo $curPage; ?>, 'acm.chapter_name','asc');" class="sort">Chapter <img src="./images/down-arr.png" border="0" /></a></th>
            <?php
                    }
                } else {
            ?>
                        <th><a href="javascript:void(0);" onclick="javascript: _getChapterTable(<?php echo $currid; ?>,<?php echo $catgid; ?>, <?php echo $curPage; ?>, 'acm.chapter_name','asc');" class="sort">Chapter</a></th>
            <?php
                }               
                if($field == "acm.chapter_code"){
                    if($sort == "asc"){
        ?>
                        <td><a href="javascript:void(0);" onclick="javascript: _getChapterTable(<?php echo $currid; ?>,<?php echo $catgid; ?>, <?php echo $curPage; ?>, 'acm.chapter_code','desc');" class="sort">Chapter Code <img src="./images/up-arr.png" border="0" /></a></td>
            <?php
                    }else{
            ?>
                        <th><a href="javascript:void(0);" onclick="javascript: _getChapterTable(<?php echo $currid; ?>,<?php echo $catgid; ?>, <?php echo $curPage; ?>, 'acm.chapter_code','asc');" class="sort">Chapter Code <img src="./images/down-arr.png" border="0" /></a></th>
            <?php
                    }
                } else {
            ?>
                        <th><a href="javascript:void(0);" onclick="javascript: _getChapterTable(<?php echo $currid; ?>,<?php echo $catgid; ?>, <?php echo $curPage; ?>, 'acm.chapter_code','asc');" class="sort">Chapter Code</a></th>
            <?php
                }
            ?>
            <th>Topic Count</th>
        </tr>
    </thead>
<?php
    $sqlChapter = "SELECT cur.unique_id as 'curid',cur.curriculum_name,acm.unique_id,acm.chapter_name,acm.chapter_slug,lcm.category_name,acm.category_id,acm.chapter_code FROM avn_chapter_master acm INNER JOIN ltf_category_master lcm ON acm.category_id = lcm.unique_id INNER JOIN avn_curriculum_master cur ON cur.unique_id = lcm.curriculum_id";
    if($where != "")
        $sqlChapter .= " WHERE " . $where;
    $sqlChapter .= " ORDER BY " . mysql_escape_string($field) . " " . mysql_escape_string($sort) . " LIMIT " . $limitStart . ", " .$limitEnd . "";
    $r = $db->query("query", $sqlChapter);
?>
    <tbody id="chpData">
<?php
    if(!array_key_exists("response", $r)){
        $srno = $limitStart ;
        for($i=0; $i< count($r); $i++){
            $srno++;
            if($i % 2 == 0)
                $class = "lightyellow";
            else
                $class = "darkyellow";
            $sql = "SELECT COUNT(unique_id) as 'Topics' FROM avn_topic_master WHERE chapter_id = " . $r[$i]["unique_id"];
            $topic = $db->query("query", $sql);
            $topicCount = 0;
            if(!array_key_exists("response", $topic))
                $topicCount = $topic[0]["Topics"];
        unset($topic);
?>
    <tr class="<?php echo $class; ?>" id="chpdatarow-<?php echo $i; ?>">
        <td>
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td><input class="fl" type="checkbox" name="chkChapter[]" id="chk-<?php echo $i; ?>" value="<?php echo $r[$i]["unique_id"]; ?>" onclick="javascript: _checked(this, <?php echo $i; ?>);" /></td>
                    <td>
                        <div class="multimenu ml10 mr10"><img src="./images/options.png" title="More actions" />
                            <div class="cb"></div>
                            <label>
                                <ul>
                                    <li class="settings p1"><a href="edit-chapter.php<?php echo filter_querystring($_SERVER["QUERY_STRING"], array("currid", "catgid", "chptid","page","resp"), array($r[$i]["curid"], $r[$i]["category_id"], $r[$i]["unique_id"],$curPage,"")); ?>">Edit</a></li>
                                    <li class="settings p2"><a href="javascript:void(0);" onclick="javascript:_deletechapter(<?php echo $r[$i]["curid"]; ?>,<?php echo $i; ?>,<?php echo $catgid; ?>,<?php echo $curPage; ?>)" class="btnDelete">Delete</a></li>
                                    <li class="settings p3"><a href="topic.php<?php echo filter_querystring($_SERVER["QUERY_STRING"], array("currid", "catgid", "chptid", "resp"), array($r[$i]["curid"], $r[$i]["category_id"], $r[$i]["unique_id"], "")); ?>">Topics (<?php echo $topicCount; ?>)</a></li>
                                </ul>
                            </label>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
        <td><?php echo $r[$i]["category_name"]; ?></td>
        <td><?php echo $r[$i]["chapter_name"]; ?></td>
        <td><?php echo $r[$i]["chapter_code"]; ?></td>
        <td><?php echo $topicCount; ?></td>
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
        for($i = $start; $i < $end; $i++){
            if($i == $curPage)
                $nav .= "<a href=\"javascript: void(0);\" class=\"currentPage\">$i</a>";
            else
                $nav .=    "<a href=\"javascript:void(0);\" onclick=\"javascript: _getChapterTable($currid,$catgid,$i,'$field','$sort');\" class=\"paging\">$i</a>";
        }
        if($curPage > 5){
            $page = $start - 5;
            $prev = " <a href=\"javascript:void(0);\" onclick=\"javascript: _getChapterTable($currid,$catgid,$page,'$field','$sort');\" class=\"paging\">&laquo;&nbsp;Previous</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        }
        if($noOfpage > 5 && $end <= $noOfpage){
            $page = $start + 5;
            $next = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"javascript:void(0);\" onclick=\"javascript: _getChapterTable($currid,$catgid,$page,'$field','$sort');\ class=\"paging\">Next&nbsp;&raquo;</a> ";
        }
    ?>
    <table cellpadding="5" cellspacing= "0" border ="0" style="border-collapse:collapse; text-align:left; margin-top:15px;"  width='500px' align='center'>
        <tr>
            <input type="hidden" id="pageNo" name="pageNo" value="<?php echo $curPage; ?>" />
            <td align="left"><?php echo $prev . $nav . $next;?></td>
        </tr>
    </table>
</div><!-- end of content -->