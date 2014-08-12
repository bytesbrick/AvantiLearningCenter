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
    $sort = "ASC";
    $field = "rd.priority";
    $catgid = 0;
    $chptid = 0;
    $topicid = 0;
    $resid = 0;
    if(isset($_POST["sf"]) && $_POST["sf"] != "")
        $field = $_POST["sf"];
    if(isset($_POST["sd"]) && $_POST["sd"] != "")
        $sort = $_POST["sd"];
    $currid = 0;
    if(isset($_POST["currid"]) && $_POST["currid"] != "" && $_POST["currid"] != "0"){
            $currid = $_POST["currid"];
            $where .= $where == "" ? "lcm.curriculum_id = " . mysql_escape_string($currid) : " AND lcm.curriculum_id = " . mysql_escape_string($currid);
    }
    if(isset($_POST["catgid"]) && $_POST["catgid"] != ""){
        $catgid = $_POST["catgid"];
        $where .= $where == "" ? "chm.category_id = " . mysql_escape_string($catgid) : " AND chm.category_id = " . mysql_escape_string($catgid);
    }
    if(isset($_POST["chptid"]) && $_POST["chptid"] != ""){
        $chptid = $_POST["chptid"];
        $where .= $where == "" ? "tm.chapter_id = " . mysql_escape_string($chptid) : " AND tm.chapter_id = " . mysql_escape_string($chptid);
    }
    if(isset($_POST["topicid"]) && $_POST["topicid"] != ""){
        $topicid = $_POST["topicid"];
        $where .= $where == "" ? "rd.topic_id = " . mysql_escape_string($topicid) : " AND rd.topic_id = " . mysql_escape_string($topicid);
    }
  
    $curPage = $_POST["page"];
    if(($curPage == "") || ($curPage == 0))												
        $curPage=1;
        
        //echo $curPage;
    $recPerpage = 25;
    $countWhereClause = "";
    $selectWhereClause = "";
    $pageParam="";
    $sql = "SELECT COUNT(rd.unique_id) as 'total' FROM avn_resources_detail rd INNER JOIN avn_topic_master tm ON rd.topic_id = tm.unique_id INNER JOIN avn_chapter_master chm ON chm.unique_id = tm.chapter_id INNER JOIN ltf_category_master lcm ON lcm.unique_id = chm.category_id";
    if($where != "")
        $sql .= " WHERE " .$where;
        //echo $sql;
    $sqlCount = $db->query("query",$sql);
    $recCount = $sqlCount[0]['total'];
    $noOfpage = ceil($recCount/$recPerpage);
    $limitStart = ($curPage - 1) * $recPerpage;
    $limitEnd = $recPerpage;
    
    $isSpotlink = false;
    $chkforspot = $db->query("query","SELECT unique_id FROM avn_resources_detail WHERE topic_id = " . $_POST['topicid'] . " AND content_type = 'spot'");
    
    if(!array_key_exists("response",$chkforspot))
        $isSpotlink = true;
    
    $isConceptlink = false;
    $chkforconcept = $db->query("query","SELECT unique_id FROM avn_resources_detail WHERE topic_id = " . $_POST['topicid'] . " AND content_type = 'concept'");
    
    if(!array_key_exists("response",$chkforconcept))
        $isConceptlink = true;
  
    $spotQCount = 0;
    $chkforspot = $db->query("query","SELECT COUNT(qm.unique_id) as Total FROM avn_resources_detail rd INNER JOIN avn_question_master qm ON qm.topic_id = rd.topic_id WHERE rd.topic_id = " . $_POST['topicid'] . " AND rd.content_type = 'spot' AND qm.type = 1");
    if(!array_key_exists("response",$chkforspot)){
        $spotQCount = $chkforspot[0]["Total"];
    }
    unset($chkforspot);
    
    $conceptQCount = 0;
    $chkforconcept = $db->query("query","SELECT COUNT(qm.unique_id) as Total FROM avn_resources_detail rd INNER JOIN avn_question_master qm ON qm.topic_id = rd.topic_id WHERE rd.topic_id = " . $_POST['topicid'] . " AND rd.content_type = 'concept' AND qm.type = 2");
    if(!array_key_exists("response",$chkforconcept)){
        $conceptQCount = $chkforconcept[0]["Total"];
    }
    unset($chkforconcept);
?>
<table cellspacing="1" width="100%" id="tabResources" cellpadding="3" border="0" style="background-color:#f5f5f5;" class="mdata">
    <thead>
        <tr style="background-color:#A74242;color:#ffffff;">
            <th width="25px">
                <input type="checkbox" name="chpAll" id="chpAll" onclick="javascript: _checked(this, -1);" style="margin: 0px 0px 0px 15px;" />
            </th>
            <?php
                    if($field == "rd.title"){
                        if($sort == "asc"){
            ?>
                            <th><a href="javascript:void(0);" onclick="javascript: _getResourceTable(<?php echo $topicid; ?>,<?php echo $resid; ?>,<?php echo $catgid; ?>,<?php echo $chptid; ?>, <?php echo $curPage; ?>, 'rd.title','desc');" class="sort">Title <img src="./images/up-arr.png" border="0" /></a></th>
            <?php
                        }else{
            ?>
                            <th><a href="javascript:void(0);" onclick="javascript: _getResourceTable(<?php echo $topicid; ?>,<?php echo $resid; ?>,<?php echo $catgid; ?>,<?php echo $chptid; ?>, <?php echo $curPage; ?>, 'rd.title','asc');" class="sort">Title <img src="./images/down-arr.png" border="0" /></a></th>
            <?php
                        }
                    }else{
            ?>
                            <th><a href="javascript:void(0);" onclick="javascript: _getResourceTable(<?php echo $topicid; ?>,<?php echo $resid; ?>,<?php echo $catgid; ?>,<?php echo $chptid; ?>, <?php echo $curPage; ?>, 'rd.title','asc');" class="sort">Title</a></th>
            <?php
                    if($field == "rd.visiblity"){
                        if($sort == "asc"){
            ?>
                            <th><a href="javascript:void(0);" onclick="javascript: _getResourceTable(<?php echo $topicid; ?>,<?php echo $resid; ?>,<?php echo $catgid; ?>,<?php echo $chptid; ?>, <?php echo $curPage; ?>, 'rd.visiblity','desc');" class="sort">Resource Visiblity <img src="./images/up-arr.png" border="0" /></a></th>
            <?php
                        }else{
            ?>
                            <th><a href="javascript:void(0);" onclick="javascript: _getResourceTable(<?php echo $topicid; ?>,<?php echo $resid; ?>,<?php echo $catgid; ?>,<?php echo $chptid; ?>, <?php echo $curPage; ?>, 'rd.visiblity','asc');" class="sort">Resource Visiblity <img src="./images/down-arr.png" border="0" /></a></th>
            <?php
                        }
                    }else{
            ?>
                            <th><a href="javascript:void(0);" onclick="javascript: _getResourceTable(<?php echo $topicid; ?>,<?php echo $resid; ?>,<?php echo $catgid; ?>,<?php echo $chptid; ?>, <?php echo $curPage; ?>, 'rd.visiblity','asc');" class="sort">Resource Visiblity</a></th>
            <?php
                    }
                    }
            ?>
            <?php 
                    if($field == "rd.priority"){
                        if($sort == "asc"){
            ?>
                            <th><a href="javascript:void(0);" onclick="javascript: _getResourceTable(<?php echo $topicid; ?>,<?php echo $resid; ?>,<?php echo $catgid; ?>,<?php echo $chptid; ?>, <?php echo $curPage; ?>, 'rd.priority','desc');" class="sort">Priority <img src="./images/down-arr.png" border="0" /></a></th>
            <?php
                        }else{
            ?>
                            <th><a href="javascript:void(0);" onclick="javascript: _getResourceTable(<?php echo $topicid; ?>,<?php echo $resid; ?>,<?php echo $catgid; ?>,<?php echo $chptid; ?>, <?php echo $curPage; ?>, 'rd.priority','asc');" class="sort">Priority <img src="./images/up-arr.png" border="0" /></a></th>
            <?php
                        }
                    }else{
            ?>
                            <th><a href="javascript:void(0);" onclick="javascript: _getResourceTable(<?php echo $topicid; ?>,<?php echo $resid; ?>,<?php echo $catgid; ?>,<?php echo $chptid; ?>, <?php echo $curPage; ?>, 'rd.priority','asc');" class="sort">Priority</a></th>
            <?php
                    }
            ?>
                <th>Options</th>
            </tr>
    </thead>
<?php
    $sqlres = "SELECT rd.unique_id,rd.title,rd.text,rd.topic_id,rd.resource_id,rd.entry_date,rd.priority,rd.content_type,rd.status,rd.resource_slug from avn_resources_detail rd INNER JOIN avn_topic_master tm on tm.unique_id = rd.topic_id INNER JOIN avn_chapter_master chm ON chm.unique_id = tm.chapter_id INNER JOIN ltf_category_master lcm ON lcm.unique_id = chm.category_id";
    if($where != "")
        $sqlres .= " WHERE " . $where;
    $sqlres .= " ORDER BY " . mysql_escape_string($field) . " " . mysql_escape_string($sort) . " limit ".$limitStart.", ".$limitEnd . "";
    $r = $db->query("query",$sqlres);
    //echo $sqlres;
    if(!array_key_exists("response", $r))
    {
?>
<tbody id="resData">
<?php
    $srno = $limitStart;
    for($i=0; $i< count($r); $i++){
        $srno++;
        if($i % 2 == 0)
            $class = "lightyellow";
        else
            $class = "darkyellow";
?>
<tr class="<?php echo $class; ?>" id="rdatarow-<?php echo $r[$i]["unique_id"]; ?>">
    <td>
        <table>
            <tr>
                <td>
                    <input class="fl" type="checkbox" name="chkResource[]" id="chk-<?php echo $i; ?>" value="<?php echo $r[$i]["unique_id"]; ?>" onclick="javascript: _checked(this, <?php echo $r[$i]["unique_id"]; ?>);" />
                </td>
            </tr>
        </table>
    </td>
    <td><?php echo $r[$i]["title"]; ?><br />
    <?php
        if($r[$i]["status"] == 1){
    ?>
            <a href="javascript:void(0);" onclick="javascript: _chngResStatus(<?php echo $currid; ?>,<?php echo $i; ?>,<?php echo $r[$i]['topic_id']; ?>,1,<?php echo $catgid; ?>,<?php echo $chptid; ?>,<?php echo $curPage; ?>,this)" style="color:#3c6435;"><small><span id="active-<?php echo $i; ?>"><?php echo "Active"; ?></span></small></a>
    <?php
        }else{
    ?>
            <a href="javascript:void(0);"  onclick="javascript: _chngResStatus(<?php echo $currid; ?>,<?php echo $i; ?>,<?php echo $r[$i]['topic_id']; ?>,0,<?php echo $catgid; ?>,<?php echo $chptid; ?>,<?php echo $curPage; ?>,this)" style="color:#f00;"><small><span id="active-<?php echo $i; ?>"><?php echo "Inactive"; ?></span></small></a>
    <?php
        }
    ?>
    </td>
    <td>
            <?php
                $userVisible = "";
                $selvisibleUser = "SELECT visiblity FROM avn_resource_visiblity_mapping WHERE resource_id = " . $r[$i]["unique_id"];
                $selvisibleUserRS = $db->query("query" , $selvisibleUser);
                if(!array_key_exists("response", $selvisibleUserRS)){
                    for($k = 0; $k < count($selvisibleUserRS); $k++){
                        if($selvisibleUserRS[$k]["visiblity"] == 1){
                            $userVisible = "Student";
                        }
                        if($selvisibleUserRS[$k]["visiblity"] == 2){
                            $userVisible .= $userVisible == "" ? "Teacher" : " | " . "Teacher";
                        }
                        if($selvisibleUserRS[$k]["visiblity"] == 3){
                            $userVisible .= $userVisible == "" ? "Manager" : " | " . "Manager";
                        }
                    }
                    echo $userVisible;
                }
                unset($selvisibleUserRS);
            ?>
    </td> 
    <td>
        <?php echo $r[$i]["priority"]; ?>
        <?php
            $totlares = $db->query("query","SELECT COUNT(unique_id) as total FROM avn_resources_detail");
                $rd = $db->query("query","SELECT MAX(priority) as maxp,MIN(priority) as minp from avn_resources_detail WHERE topic_id = ". $_POST['topicid']);
                if($rd[0]['minp'] == $r[$i]['priority']){
            ?>
                    <a href="javascript:void(0);" style="display: none;">
                        <img src="./images/showmore-up.png" id="up" name="up" class="noborder" onclick="javascript: _setpriority(<?php echo $currid; ?>,<?php echo $catgid; ?>,<?php echo $chptid; ?>,<?php echo $r[$i]['unique_id']; ?>,<?php echo $topicid; ?>,this.id,<?php echo $curPage; ?>);" class="fl" style="width: 14px;" />
                    </a>
            <?php
                }else{
            ?>
                    <a href="javascript:void(0);">
                        <img src="./images/showmore-up.png" id="up" name="up" class="noborder" onclick="javascript: _setpriority(<?php echo $currid; ?>,<?php echo $catgid; ?>,<?php echo $chptid; ?>,<?php echo $r[$i]['unique_id']; ?>,<?php echo $topicid; ?>,this.id,<?php echo $curPage; ?>);"  class="fl" style="width: 14px;" />
                    </a>
            <?php
                }
                if($rd[0]['maxp'] == $r[$i]['priority']){
        ?>
                    <a href="javascript:void(0);" style="display: none;">
                        <img src="./images/showmore.png" id="down" name="down" class="noborder" onclick="javascript: _setpriority(<?php echo $currid; ?>,<?php echo $catgid; ?>,<?php echo $chptid; ?>,<?php echo $r[$i]['unique_id']; ?>,<?php echo $topicid; ?>,this.id,<?php echo $curPage; ?>);" class="fl" style="width: 14px;" />
                    </a>
            <?php
                }
                else
                {
            ?>
                    <a href="javascript:void(0);">
                        <img src="./images/showmore.png" id="down" name="down" class="noborder" onclick="javascript: _setpriority(<?php echo $currid; ?>,<?php echo $catgid; ?>,<?php echo $chptid; ?>,<?php echo $r[$i]['unique_id']; ?>,<?php echo $topicid; ?>,this.id,<?php echo $curPage; ?>);" class="fl" style="width: 14px;" />
                    </a>
            <?php
                }
            ?>
    </td>
    <td>
        <?php
            if(isset($r[$i]['content_type']) && $r[$i]['content_type'] == "Content"){
        ?>
                <a href="./edit-resource.php<?php echo filter_querystring($_SERVER["QUERY_STRING"], array("currid","topicid","catgid","chptid","cid","resp","page"), array($currid,$topicid,$catgid,$chptid,$r[$i]["unique_id"],"",$curPage)); ?>" class="ftblack">Edit</a> | 
        <?php
            }
        ?>
        <a href="javascript:void(0);" style="color:#f00;" onclick="javascript:_deleteresource(<?php echo $currid; ?>,<?php echo $i; ?>,<?php echo $topicid; ?>,<?php echo $catgid; ?>,<?php echo $chptid; ?>,<?php echo $curPage; ?>)">Delete</a>
        <?php
            if(strtolower($r[$i]['content_type']) == "spot" && $isSpotlink){
        ?>
                 | <a href="./spot-test-questions.php<?php echo filter_querystring($_SERVER["QUERY_STRING"], array("currid","chptid","catgid","topicid","resp","page"), array($currid,$chptid,$catgid,$topicid ,"" ,"")); ?>" class="ftblack">Questions (<?php echo $spotQCount; ?>)</a>
        <?php
            }
            if(strtolower($r[$i]['content_type']) == "concept" && $isConceptlink){
        ?>
                 | <a href="./concept-test-questions.php<?php echo filter_querystring($_SERVER["QUERY_STRING"], array("currid","chptid","catgid","topicid","resp","page"), array($currid,$chptid,$catgid,$topicid ,"" ,"")); ?>" class="ftblack">Questions (<?php echo $conceptQCount; ?>)</a>
        <?php
            }
        ?>
        </td>
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
                    $nav .=  " <a href=\"javascript:void(0);\" onclick=\"javascript: _getResourceTable($currid,$topicid, $catgid, $chptid,$i,'$field','$sort');\" class=\"paging\">$i</a>";
            }
            if($curPage > 5)
            {
                $page = $start - 5;
                $prev = " <a href=\javascript: void(0);\" onclick=\"javascript: _getResourceTable($currid,$topicid, $catgid, $chptid,$page,'$field','$sort');\" class=\"paging\">&lt;&lt;&nbsp;Previous</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            }
            if($noOfpage > 5 && $end <= $noOfpage)
            {
                $page = $start + 5;
                $next = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"javascript: void(0);\" onclick=\"_getResourceTable($currid,$topicid, $catgid, $chptid,$page,'$field','$sort');\" class=\"paging\">Next&nbsp;&gt;&gt;</a>";
            }
        ?>
        <table cellpadding="5" cellspacing= "0" border ="0" style="border-collapse:collapse; text-align:left; margin-top:15px;"  width='500px' align='center'>
            <tr>
                <input type="hidden" id="pageNo" name="pageNo" value="<?php echo $curPage; ?>" />
                <td align="left"><?php echo $prev . $nav . $next;?></td>
            </tr>
        </table>
    </div><!-- end of content -->