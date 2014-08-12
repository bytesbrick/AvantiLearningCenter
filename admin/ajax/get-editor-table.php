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
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
	$sort = "DESC";
    $field = "lau.unique_id";
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
	$sqlCount = $db->query("query","SELECT COUNT(unique_id) as 'total' FROM ltf_admin_usermaster");
	$recCount = $sqlCount[0]['total'];
	$noOfpage = ceil($recCount/$recPerpage);
	$limitStart = ($curPage - 1) * $recPerpage;
	$limitEnd = $recPerpage;
?>
<table cellspacing="1" width="100%" id="tabEditor" cellpadding="3" border="0" style="background-color:#f5f5f5;" class="mdata">
	<thead>
	<tr style="background-color:#a74242;color:#ffffff;">
		<th>
			<input type="checkbox" name="chpAll" id="chpAll" onclick="javascript: _checked(this, -1);" style="margin: 0px 0px 0px 15px;" />
		</th>
		<?php
            if($field == "lau.username"){
                if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getEditorTable(<?php echo $curPage; ?>, 'lau.username','desc');" class="sort">User Name <img src="./images/up-arr.png" border="0" /></a></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getEditorTable(<?php echo $curPage; ?>, 'lau.username','asc');" class="sort">User Name <img src="./images/down-arr.png" border="0" /></a></th>
    <?php
                }
            }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getEditorTable(<?php echo $curPage; ?>, 'lau.username','asc');" class="sort">User Name</a></th>
	<?php
			}
            if($field == "lau.emailid"){
                if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getEditorTable(<?php echo $curPage; ?>, 'lau.emailid','desc');" class="sort">Email ID <img src="./images/up-arr.png" border="0" /></a></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getEditorTable(<?php echo $curPage; ?>, 'lau.emailid','asc');" class="sort">Email ID <img src="./images/down-arr.png" border="0" /></a></th>
    <?php
                }
            }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getEditorTable(<?php echo $curPage; ?>, 'lau.emailid','asc');" class="sort">Email ID</a></th>
	<?php
			}
            if($field == "lau.firstname"){
                if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getEditorTable(<?php echo $curPage; ?>, 'lau.firstname','desc');" class="sort">Name <img src="./images/up-arr.png" border="0" /></a></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getEditorTable(<?php echo $curPage; ?>, 'lau.firstname','asc');" class="sort">Name <img src="./images/down-arr.png" border="0" /></a></th>
    <?php
                }
            }else{
    ?>
                    <td><a href="javascript:void(0);" onclick="javascript: _getEditorTable(<?php echo $curPage; ?>, 'lau.firstname','asc');" class="sort">Name</a></td>
	<?php
		}
	if($field == "lau.usertype"){
                if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getEditorTable(<?php echo $curPage; ?>, 'lau.usertype','desc');" class="sort">Type <img src="./images/up-arr.png" border="0" /></a></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getEditorTable(<?php echo $curPage; ?>, 'lau.usertype','asc');" class="sort">Type <img src="./images/down-arr.png" border="0" /></a></th>
    <?php
                }
            }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getEditorTable(<?php echo $curPage; ?>, 'lau.usertype','asc');" class="sort">Type</a></th>
		    <th>Options</th>
	<?php
		}
	?>
	</tr>
<?php
	$r = $db->query("query","SELECT lau.* FROM ltf_admin_usermaster lau ORDER BY " . mysql_escape_string($field) . " " . mysql_escape_string($sort) . " LIMIT " . $limitStart. ", " . $limitEnd);
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
<tbody id="editordata">
	<tr class="<?php echo $class; ?>" id="editorRow-<?php echo $r[$i]["unique_id"]; ?>">
		<td>
			<table>
				<tr>
					<td>
						<input class="fl" type="checkbox" name="chkEditor[]" id="chk-<?php echo $i; ?>" value="<?php echo $r[$i]["unique_id"]; ?>" onclick="javascript: _checked(this, <?php echo $r[$i]["unique_id"]; ?>);" />
					</td>
				</tr>
			</table>
		</td>
		<td><?php echo $r[$i]["username"]; ?></td>
		<td><?php echo $r[$i]["emailid"]; ?></td>
		<td><?php echo $r[$i]["firstname"]; ?>&nbsp;<?php echo $r[$i]["lastname"]; ?><br />
	<?php
		if($r[$i]["gender"] == 1){
	?>
			<small style="color:#0e8a39;">Male</small>
	<?php
		}else if($r[$i]["gender"] == 2){
	?>
			<small style="color:#e21680;">Female</small>
	<?php
		}
            if($r[$i]["status"] == 1){
    ?>
                 <small> | </small><a href="javascript:void(0);" onclick="javascript: _chngEditorStatus(<?php echo $i; ?>,1,<?php echo $curPage; ?>,this)" style="color:#3c6435;"><small><span id="active-<?php echo $i; ?>"><?php echo "Active"; ?></span></small></a>
    <?php
            }else{
    ?>
                <small> | </small><a href="javascript:void(0);" onclick="javascript: _chngEditorStatus(<?php echo $i; ?>,0,<?php echo $curPage; ?>,this)" style="color:#f00;"><small><span id="active-<?php echo $i; ?>"><?php echo "Inactive"; ?></span></small></a>
    <?php
            }
    ?>
		<td><?php echo $r[$i]["usertype"]; ?></td>
		<td>
			<a href="edit-editor.php<?php echo filter_querystring($_SERVER["QUERY_STRING"], array("cid","page","resp"), array($r[$i]["unique_id"],$curPage,"")); ?>">Edit</a> |
			<a href="javascript:void(0);" class="btnDelete" onclick="javascript: _deleteEditor(<?php echo $i; ?>,<?php echo $curPage; ?>)">Delete</a>
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
				$nav .=    " <a href=\"javascript:void(0);\" onclick=\"javascript: _getEditorTable($i, '$field', '$sort');\" class=\"paging\">$i</a>";
		}
		if($curPage > 5)
		{
			$page = $start - 5;
			$prev = " <a href=\"javascript:void(0);\" onclick=\"javascript: _getEditorTable($page, '$field', '$sort');\" class=\"paging\">&lt;&lt;&nbsp;Previous</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		if($noOfpage > 5 && $end <= $noOfpage)
		{
			$page = $start + 5;
			$next = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"javascript:void(0);\" onclick=\"javascript: _getEditorTable($page, '$field', '$sort');\" class=\"paging\">Next&nbsp;&gt;&gt;</a> ";
		}
	?>
	<table cellpadding="5" cellspacing= "0" border ="0" style="border-collapse:collapse; text-align:left; margin-top:15px;"  width='500px' align='center'>
		<tr>
			<input type="hidden" id="pageNo" name="pageNo" value="<?php echo $curPage; ?>" />
			<td align="left"><?php echo $prev . $nav . $next;?></td>
		</tr>
	</table>
</div>