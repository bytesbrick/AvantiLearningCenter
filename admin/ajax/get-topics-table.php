<?php
    include_once("../includes/config.php");  
    include("../classes/cor.mysql.class.php");
    $db = new MySqlConnection(CONNSTRING);
    $db->open();
    
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
    
    $sort = "ASC";
    $field = "tm.topic_priority";
    $currid = 0;
    $chptid = 0;
    $catgid = 0;
    if(isset($_POST["sf"]) && $_POST["sf"] != "")
            $field = $_POST["sf"];
    if(isset($_POST["sd"]) && $_POST["sd"] != "")
            $sort = $_POST["sd"];
    if(isset($_POST["catgid"]) && $_POST["catgid"] != "" && $_POST["catgid"] != "0"){
            $catgid = $_POST["catgid"];
            $where .= $where == "" ? "chm.category_id = " . mysql_escape_string($catgid) : " AND chm.category_id = " . mysql_escape_string($catgid);
    }
    if(isset($_POST["chptid"]) && $_POST["chptid"] != "" && $_POST["chptid"] != "0"){
            $chptid = $_POST["chptid"];
            $where .= $where == "" ? "tm.chapter_id = " . mysql_escape_string($chptid) : " AND tm.chapter_id = " . mysql_escape_string($chptid);
    }
    if(isset($_POST["currid"]) && $_POST["currid"] != "" && $_POST["currid"] != "0"){
            $currid = $_POST["currid"];
            $where .= $where == "" ? "cm.curriculum_id = " . mysql_escape_string($currid) : " AND cm.curriculum_id = " . mysql_escape_string($currid);
    }

    $curPage = $_POST["page"];
    if(($curPage == "") || ($curPage == 0))
    $curPage=1;
    $recPerpage = 25;
    $countWhereClause = "";
    $selectWhereClause = "";
    
    $sql = "SELECT COUNT(tm.unique_id) as 'total' FROM avn_topic_master tm INNER JOIN avn_chapter_master chm ON chm.unique_id = tm.chapter_id INNER JOIN ltf_category_master lcm ON lcm.unique_id = chm.category_id";
    if($where != "")
        $sql.= " WHERE " . $where;
    $sqlCount = $db->query("query",$sql);
    $recCount = $sqlCount[0]['total'];
    $noOfpage = ceil($recCount/$recPerpage);
    $limitStart = ($curPage - 1) * $recPerpage;
    $limitEnd = $recPerpage;
    
    $sqlSubjects = "select unique_id, category_name from ltf_category_master lcm";
    $rsSubjects = $db->query("query", $sqlSubjects);
     
    if($catgid != 0)
        $sqlChapters = "select unique_id, chapter_name from avn_chapter_master chm WHERE chm.category_id = " . $catgid;
    else
        $sqlChapters = "select unique_id, chapter_name from avn_chapter_master chm";
        $rsChapters = $db->query("query", $sqlChapters);
?>
<table cellspacing="1" cellpadding="3" id="tabTopics" width="100%" border="0" style="background-color:#f5f5f5;" class="mdata">
    <thead>
        <tr style="background-color:#A74242;color:#ffffff;">
                <th width="25px">
                    <input type="checkbox" name="chpAll" id="chpAll" onclick="javascript: _checked(this, -1);" style="margin: 0px 0px 0px 15px;" />
                </th>
                <?php
                        if($field == "tm.topic_code"){
                                if($sort == "asc"){
                ?>
                                        <th style='width:100px;'><a href="javascript:void(0);" onclick="javascript: _getTopicTable(<?php echo $currid; ?>,<?php echo $chptid; ?>,<?php echo $catgid; ?>, <?php echo $curPage; ?>, 'tm.topic_code','desc');" class="sort">Topic Code <img src="./images/up-arr.png" border="0" /></a></th>
                <?php
                                }else{
                ?>
                                        <th style='width:100px;'><a href="javascript:void(0);" onclick="javascript: _getTopicTable(<?php echo $currid; ?>,<?php echo $chptid; ?>,<?php echo $catgid; ?>, <?php echo $curPage; ?>, 'tm.topic_code','asc');" class="sort">Topic Code <img src="./images/down-arr.png" border="0" /></a></th>
                <?php
                                }
                        }else{
                ?>
                                        <th style='width:100px;'><a href="javascript:void(0);" onclick="javascript: _getTopicTable(<?php echo $currid; ?>,<?php echo $chptid; ?>,<?php echo $catgid; ?>, <?php echo $curPage; ?>, 'tm.topic_code','asc');" class="sort">Topic Code</a></th>
                <?php
                        }
                 ?>
                <?php
                        if($field == "tm.topic_name"){
                                if($sort == "asc"){
                ?>
                                        <th><a href="javascript:void(0);" onclick="javascript: _getTopicTable(<?php echo $currid; ?>,<?php echo $chptid; ?>,<?php echo $catgid; ?>, <?php echo $curPage; ?>, 'tm.topic_name','desc');" class="sort">Topic <img src="./images/up-arr.png" border="0" /></a><br /><small>Chapter | Subject | Status</small></th>
                <?php
                                }else{
                ?>
                                        <th><a href="javascript:void(0);" onclick="javascript: _getTopicTable(<?php echo $currid; ?>,<?php echo $chptid; ?>,<?php echo $catgid; ?>, <?php echo $curPage; ?>, 'tm.topic_name','asc');" class="sort">Topic <img src="./images/down-arr.png" border="0" /></a><br /><small>Chapter | Subject | Status</small></th>
                <?php
                                }
                        }else{
                ?>
                                <th><a href="javascript:void(0);" onclick="javascript: _getTopicTable(<?php echo $currid; ?>,<?php echo $chptid; ?>,<?php echo $catgid; ?>, <?php echo $curPage; ?>, 'tm.topic_name','asc');" class="sort">Topic</a><br /><small>Chapter | Subject | Status</small></th>
                <?php
                        }
                    if($field == "tm.topic_priority"){
                        if($sort == "asc"){
                ?>
                            <th style='width:100px;'><a href="javascript:void(0);" onclick="javascript: _getTopicTable(<?php echo $currid; ?>,<?php echo $chptid; ?>,<?php echo $catgid; ?>, <?php echo $curPage; ?>, 'tm.topic_priority','desc');" class="sort">Priority <img src="./images/down-arr.png" border="0" /></a></th>
                <?php
                        }else{
                ?>
                            <th style='width:100px;'><a href="javascript:void(0);" onclick="javascript: _getTopicTable(<?php echo $currid; ?>,<?php echo $chptid; ?>,<?php echo $catgid; ?>, <?php echo $curPage; ?>, 'tm.topic_priority','asc');" class="sort">Priority <img src="./images/up-arr.png" border="0" /></a></th>
                <?php
                        }
                    }else{
                ?>
                            <th style='width:100px;'><a href="javascript:void(0);" onclick="javascript: _getTopicTable(<?php echo $currid; ?>,<?php echo $chptid; ?>,<?php echo $catgid; ?>, <?php echo $curPage; ?>, 'tm.topic_priority','asc');" class="sort">Priority</a></th>
                <?php
                    }
                ?>
                <th style='width:180px;'>Options</th>
        </tr>
    </thead>
<?php
    $sqltopic = "SELECT DISTINCT chm.unique_id as 'ChapterID',acm.unique_id as 'currid',chm.category_id,chm.chapter_name,tm.unique_id,tm.chapter_id,tm.topic_code,tm.topic_slug,tm.topic_name,tm.topic_priority,tm.unique_id AS tpid,cm.category_name,tm.status, cm.curriculum_id FROM avn_chapter_master chm INNER JOIN avn_topic_master as tm ON chm.unique_id = tm.chapter_id INNER JOIN ltf_category_master cm ON cm.unique_id = chm.category_id INNER JOIN avn_curriculum_master acm ON acm.unique_id = cm.curriculum_id";
    if($where != "")
        $sqltopic .= " WHERE " . $where;
    $sqltopic .= " ORDER BY " .  mysql_escape_string($field) . " " . mysql_escape_string($sort) . " LIMIT " . $limitStart . ", " .$limitEnd . "";
    $r = $db->query("query",$sqltopic);
    if(!array_key_exists("response", $r)){
?>
    <tbody id="resData">
<?php
        if(!$r["response"] == "ERROR"){
            $srno = $limitStart;
            for($i=0; $i< count($r); $i++){
                $srno++;
                if($i % 2 == 0)
                    $class = "lightyellow";
                else
                    $class = "darkyellow";
                $resCount = 0;
                $sqlResCount = $db->query("query","SELECT COUNT(rd.unique_id) as Total FROM avn_resources_detail rd WHERE rd.topic_id = " . $r[$i]["unique_id"]);
            if(!array_key_exists("response",$sqlResCount)){
                $resCount = $sqlResCount[0]["Total"];
            }
            unset($sqlResCount);
?>
    <tr class="<?php echo $class; ?>" id="topicdatarow-<?php echo $r[$i]["unique_id"]; ?>">
        <td>
            <table>
                <tr>
                    <td><input class="fl" type="checkbox" name="chkTopic[]" id="chk-<?php echo $i; ?>" value="<?php echo $r[$i]["unique_id"]; ?>" onclick="javascript: _checked(this, <?php echo $r[$i]["unique_id"]; ?>);" />
                    </td>
                </tr> 
            </table>
        </td>
        <td><?php echo $r[$i]["topic_code"]; ?></td>
        <td><?php echo $r[$i]["topic_name"]; ?><br /><small class="mt5" style='style="color: #3c6435;'><span class="fl">
            <?php echo $r[$i]["chapter_name"]; ?> | <?php echo $r[$i]["category_name"]; ?></small><small>&nbsp;| <?php
            if($r[$i]["status"] == 1){
?>
                <a href="javascript:void(0);" onclick="javascript: _changestatus(<?php echo $currid; ?>,<?php echo $i; ?>,1,<?php echo $chptid; ?>,<?php echo $catgid; ?>,<?php echo $curPage; ?>,this);" style="color: #3c6435;"><span id="active-<?php echo $i; ?>"><?php echo "Active"; ?></span></a>
<?php
            }else{
?>
                <a href="javascript:void(0);" onclick="javascript: _changestatus(<?php echo $currid; ?>,<?php echo $i; ?>,0,<?php echo $chptid ?>,<?php echo $catgid; ?>,<?php echo $curPage; ?>,this);" style="color: #f00;"><span id="active-<?php echo $i; ?>"><?php echo "Inactive"; ?></span></a>
<?php
            }
?>
        </span></small></td>
        <td style='width:100px;'>
        <?php echo $r[$i]["topic_priority"]; ?>
            <?php
                $totlares = $db->query("query","SELECT COUNT(unique_id) as total FROM avn_topic_master");
                $rd = $db->query("query","SELECT MAX(topic_priority) as maxp,MIN(topic_priority) as minp from avn_topic_master WHERE chapter_id = ". $chptid);
                if($rd[0]['minp'] == $r[$i]['topic_priority'])
                {
            ?>
                    <a href="javascript:void(0);" style="display: none;"> 
                        <img src="./images/showmore-up.png" id="up" name="up" class="noborder" onclick="javascript: _topicpriority(<?php echo $currid; ?>,<?php echo $chptid; ?>,<?php echo $catgid; ?>,<?php echo $r[$i]['tpid']; ?>,this.id,<?php echo $curPage; ?>);" class="fl" style="width: 14px;" />
                    </a>
            <?php
                }else{
            ?>
                    <a href="javascript:void(0);">
                        <img src="./images/showmore-up.png" id="up" name="up" class="noborder" onclick="javascript: _topicpriority(<?php echo $currid; ?>,<?php echo $chptid; ?>,<?php echo $catgid; ?>,<?php echo $r[$i]['tpid']; ?>,this.id,<?php echo $curPage; ?>);"  class="fl" style="width: 14px;" />
                    </a>
            <?php
                }
                if($rd[0]['maxp'] == $r[$i]['topic_priority']){
        ?>
                    <a href="javascript:void(0);" style="display: none;">
                        <img src="./images/showmore.png" id="down" name="down" class="noborder" onclick="javascript: _topicpriority(<?php echo $currid; ?>,<?php echo $chptid; ?>,<?php echo $catgid; ?>,<?php echo $r[$i]['tpid']; ?>,this.id,<?php echo $curPage; ?>);" class="fl" style="width: 14px;" />
                    </a>
            <?php
                }
                else
                {
            ?>
                    <a href="javascript:void(0);">
                        <img src="./images/showmore.png" id="down" name="down" class="noborder" onclick="javascript: _topicpriority(<?php echo $currid; ?>,<?php echo $chptid; ?>,<?php echo $catgid; ?>,<?php echo $r[$i]['unique_id']; ?>,this.id,<?php echo $curPage; ?>);" class="fl" style="width: 14px;" />
                    </a>
            <?php
                }
            ?>
            </td>
            <td style='width:180px;'>
                <a href="edit-topic.php<?php echo filter_querystring($_SERVER["QUERY_STRING"], array("currid", "chptid","catgid","cid","page", "resp"), array($r[$i]["currid"], $r[$i]["ChapterID"],$r[$i]["category_id"],$r[$i]["unique_id"],$curPage, "")); ?>" class="ftblack">Edit</a> | <a href="javascript:void(0);" class="btnDelete" onclick="javascript: _deletetopic(<?php echo $r[$i]["curriculum_id"]; ?>,<?php echo $i; ?>,<?php echo $r[$i]["ChapterID"]; ?>,<?php echo $r[$i]["category_id"];?>,<?php echo $curPage; ?>)">Delete </a> | <a href="./resource.php<?php echo filter_querystring($_SERVER["QUERY_STRING"], array("currid", "topicid", "rid", "resp", "catgid", "chptid"), array($r[$i]["curriculum_id"], $r[$i]["unique_id"], $r[$i]["resid"], "", $r[$i]["category_id"], $r[$i]["ChapterID"])); ?>" class="ftblack">Resources (<?php echo $resCount; ?>)</a>
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
                    $nav .= "<a href=\"javascript:void(0);\" onclick=\"javascript: _getTopicTable($currid,$chptid, $catgid, $i, '$field','$sort');\" class=\"paging\">$i</a>";
            }
            if($curPage > 5)
            {
                $page = $start - 5;
                $prev = " <a href=\"javascript: void(0);\" onclick=\"javascript: _getTopicTable($currid,$chptid, $catgid, $page, '$field','$sort'); \" class=\"paging\">&lt;&lt;&nbsp;Previous</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            }
            if($noOfpage > 5 && $end <= $noOfpage)
            {
                $page = $start + 5;
                $next = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"javascript: _getTopicTable($currid,$chptid, $catgid, $page, '$field','$sort');\" class=\"paging\">Next&nbsp;&gt;&gt;</a> ";
            }
    ?>
        <table cellpadding="5" cellspacing= "0" border ="0" style="border-collapse:collapse; text-align:left; margin-top:15px;"  width='500px' align='center'>
            <tr>
                <input type="hidden" id="pageNo" name="pageNo" value="<?php echo $curPage; ?>" />
                <td align="left"><?php echo $prev . $nav . $next;?></td>
            </tr>
        </table>
    </div><!-- end of content -->
