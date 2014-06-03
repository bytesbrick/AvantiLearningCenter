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
	
	$pgName = "users";
	$curPage = $_POST["page"];
	if(($curPage == "") || ($curPage == 0))
	$curPage=1;
	$recPerpage = 25;
	$countWhereClause = "";
	$selectWhereClause = "";
	$pageParam="";
	$sqlCount = $db->query("query","select count(alm.unique_id) as 'total' from avn_login_master alm");
	$recCount = $sqlCount[0]['total'];
	$noOfpage = ceil($recCount/$recPerpage);
	$limitStart = ($curPage - 1) * $recPerpage;
	$limitEnd = $recPerpage;
?>
<table cellspacing="1" width="100%" cellpadding="3" id="tabLeadusers" border="0" style="background-color:#f5f5f5;" class="mdata">
	<thead>
	<tr style="background-color:#a74242;color:#ffffff;">
		<th width="25px">
			<input type="checkbox" name="chpAll" id="chpAll" onclick="javascript: _checked(this, -1);" style="margin: 0px 0px 0px 15px;" />
		</th>
	<?php
            if($field == "alm.username"){
                if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getLeadUserTable(<?php echo $curPage; ?>, 'alm.username','desc');" class="sort">User Name <img src="./images/up-arr.png" border="0" /></a></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getLeadUserTable(<?php echo $curPage; ?>, 'alm.username','asc');" class="sort">User Name <img src="./images/down-arr.png" border="0" /></a></th>
    <?php
                }
            }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getLeadUserTable(<?php echo $curPage; ?>, 'alm.username','asc');" class="sort">User Name</a></th>
	<?php
			}
            if($field == "alm.emailid"){
                if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getLeadUserTable(<?php echo $curPage; ?>, 'alm.emailid','desc');" class="sort">Email ID <img src="./images/up-arr.png" border="0" /></a></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getLeadUserTable(<?php echo $curPage; ?>, 'alm.emailid','asc');" class="sort">Email ID <img src="./images/down-arr.png" border="0" /></a></th>
    <?php
                }
            }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getLeadUserTable(<?php echo $curPage; ?>, 'alm.emailid','asc');" class="sort">Email ID</a></th>
	<?php
			}
            if($field == "alm.firstname"){
                if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getLeadUserTable(<?php echo $curPage; ?>, 'alm.firstname','desc');" class="sort">First Name <img src="./images/up-arr.png" border="0" /></a></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getLeadUserTable(<?php echo $curPage; ?>, 'alm.firstname','asc');" class="sort">First Name <img src="./images/down-arr.png" border="0" /></a></th>
    <?php
                }
            }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getLeadUserTable(<?php echo $curPage; ?>, 'alm.firstname','asc');" class="sort">First Name</a></th>
	<?php
			}
	if($field == "alm.lastname"){
                if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getLeadUserTable(<?php echo $curPage; ?>, 'alm.lastname','desc');" class="sort">Last Name <img src="./images/up-arr.png" border="0" /></a></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getLeadUserTable(<?php echo $curPage; ?>, 'alm.lastname','asc');" class="sort">Last Name <img src="./images/down-arr.png" border="0" /></a></th>
    <?php
                }
            }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getLeadUserTable(<?php echo $curPage; ?>, 'alm.lastname','asc');" class="sort">Last Name</a></th>
	<?php
			}
	if($field == "alm.gender"){
                if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getLeadUserTable(<?php echo $curPage; ?>, 'alm.gender','desc');" class="sort">Gender <img src="./images/up-arr.png" border="0" /></a></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getLeadUserTable(<?php echo $curPage; ?>, 'alm.gender','asc');" class="sort">Gender <img src="./images/down-arr.png" border="0" /></a></th>
    <?php
                }
            }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getLeadUserTable(<?php echo $curPage; ?>, 'alm.gender','asc');" class="sort">Gender</a></th>
	<?php
			}
	if($field == "alm.status"){
                if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getLeadUserTable(<?php echo $curPage; ?>, 'alm.status','desc');" class="sort">Status <img src="./images/up-arr.png" border="0" /></a></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getLeadUserTable(<?php echo $curPage; ?>, 'alm.status','asc');" class="sort">Status <img src="./images/down-arr.png" border="0" /></a></th>
    <?php
                }
            }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getLeadUserTable(<?php echo $curPage; ?>, 'alm.status','asc');" class="sort">Status</a></th>
	<?php
			}
	if($field == "alm.user_type"){
                if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getLeadUserTable(<?php echo $curPage; ?>, 'alm.user_type','desc');" class="sort">Type <img src="./images/up-arr.png" border="0" /></a></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getLeadUserTable(<?php echo $curPage; ?>, 'alm.user_type','asc');" class="sort">Type <img src="./images/down-arr.png" border="0" /></a></th>
    <?php
                }
            }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getLeadUserTable(<?php echo $curPage; ?>, 'alm.user_type','asc');" class="sort">Type</a></th>
	<?php
			}
	?>
	</tr>
	</thead>
<?php
	$r = $db->query("query","SELECT alm.* FROM avn_login_master alm ORDER BY " . mysql_escape_string($field) . " " . mysql_escape_string($sort) . " LIMIT " . $limitStart. ", " . $limitEnd);
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
		<tr class="<?php echo $class; ?>" id="leaduserRow-<?php echo $i; ?>">
			<td>
				<table>
					<tr>
						<td>
							<input class="fl" type="checkbox" name="chkUser[]" id="chk-<?php echo $i; ?>" value="<?php echo $r[$i]["unique_id"]; ?>" onclick="javascript: _checked(this, <?php echo $i; ?>);" />
						</td>
						<td>
							<div class="multimenu"><img src="./images/options.png" title="More actions" />
								<div class="cb"></div>
								<label>
									<ul>
										<li class="settings p1"><a href="edit-user.php<?php echo filter_querystring($_SERVER["QUERY_STRING"], array("cid","resp","page") , array($r[$i]["unique_id"],"",$curPage)); ?>">Edit</a></li>
										<li class="settings p2"><a href="javascript:void(0);" class="btnDelete" onclick="javascript: _deleteUserDetail(<?php echo $i; ?>,<?php echo $curPage; ?>)">Delete</a></li>
									</ul>
								</label>
							</div>
						</td>
					</tr>
				</table>
			</td>
			<td><?php echo $r[$i]["username"]; ?></td>
			<td><?php echo $r[$i]["emailid"]; ?></td>
			<td><?php echo $r[$i]["firstname"]; ?></td>
			<td><?php echo $r[$i]["lastname"]; ?></td>
		<?php
			if($r[$i]["gender"] == 1){
		?>
				<td>Male</td>
		<?php
			}else if($r[$i]["gender"] == 2){
		?>
				<td>Female</td>
		<?php
			}
		if($r[$i]["status"] == 1){
?>
                <td><a href="javascript:void(0);" id="statusinactive" name="statusinactive" onclick="javascript: _changeuserstatus(<?php echo $i; ?>,this.id,<?php echo $curPage; ?>);" style="color: #3c6435;"><?php echo "Active"; ?></a></td>
<?php
            }else{
?>
                <td><a href="javascript:void(0);" id="statusactive" name="statusactive" onclick="javascript: _changeuserstatus(<?php echo $i; ?>,this.id,<?php echo $curPage; ?>);" style="color: #f00;"><?php echo "Inactive"; ?></a></td>
<?php
            }
		?>
		<td><?php echo $r[$i]["user_type"]; ?></td>
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
				$nav .=    " <a href=\"javascript: void(0);\" onclick=\"javascript: _getLeadUserTable($i, '$field', '$sort');\" class=\"paging\">$i</a>";
		}
		if($curPage > 5)
		{
			$page = $start - 5;
			$prev = " <a href=\"javascript:void(0);\" onclick=\"javascript: _getLeadUserTable($page, '$field', '$sort');\" class=\"paging\">&lt;&lt;&nbsp;Previous</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		if($noOfpage > 5 && $end <= $noOfpage)
		{
			$page = $start + 5;
			$next = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"javascript:void(0);\" onclick=\"javascript: _getLeadUserTable($page, '$field', '$sort');\" class=\"paging\">Next&nbsp;&gt;&gt;</a> ";
		}
	?>
	<table cellpadding="5" cellspacing= "0" border ="0" style="border-collapse:collapse; text-align:left; margin-top:15px;"  width='500px' align='center'>
		<tr>
			<input type="hidden" id="pageNo" name="pageNo" value="<?php echo $curPage; ?>" />
			<td align="left"><?php echo $prev . $nav . $next;?></td>
		</tr>
	</table>
</div><!-- end of content -->