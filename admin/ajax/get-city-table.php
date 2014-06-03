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
	$sqlCount = $db->query("query","select count(acm.unique_id) as 'total' from avn_city_master acm");
	$recCount = $sqlCount[0]['total'];
	$noOfpage = ceil($recCount/$recPerpage);
	$limitStart = ($curPage - 1) * $recPerpage;
	$limitEnd = $recPerpage;
?>
<table cellspacing="1" cellpadding="3" id="tabCity" width="100%" border="0" style="background-color:#f5f5f5;" class="mdata">
	<thead>
	<tr style="background-color:#A74242;color:#ffffff;">
		<th width="25px">
			<input type="checkbox" name="catgAll" id="catgAll"  onclick="javascript: _checked(this, -1);" style="margin-left: 15px;" />
		</th>
	<?php
            if($field == "acm.city_name"){
                if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getCityTable(<?php echo $curPage; ?>, 'acm.city_name','desc');" class="sort">City <img src="./images/up-arr.png" border="0" /></a></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getCityTable(<?php echo $curPage; ?>, 'acm.city_name','asc');" class="sort">City <img src="./images/down-arr.png" border="0" /></a></th>
    <?php
                }
            }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getCityTable(<?php echo $curPage; ?>, 'acm.city_name','asc');" class="sort">City</a></th>
	<?php
			}
	?>
	<?php
            if($field == "acm.city_prefix"){
                if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getCityTable(<?php echo $curPage; ?>, 'acm.city_prefix','desc');" class="sort">City Prefix <img src="./images/up-arr.png" border="0" /></a></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getCityTable(<?php echo $curPage; ?>, 'acm.city_prefix','asc');" class="sort">City Prefix <img src="./images/down-arr.png" border="0" /></a></th>
    <?php
                }
            }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getCityTable(<?php echo $curPage; ?>, 'acm.city_prefix','asc');" class="sort">City Prefix</a></th>
	<?php
			}
            if($field == "acm.entry_date"){
                if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getCityTable(<?php echo $curPage; ?>, 'acm.entry_date','desc');" class="sort">Entry Date <img src="./images/up-arr.png" border="0" /></a></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getCityTable(<?php echo $curPage; ?>, 'acm.entry_date','asc');" class="sort">Entry Date <img src="./images/down-arr.png" border="0" /></a></th>
    <?php
                }
            }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getCityTable(<?php echo $curPage; ?>, 'acm.entry_date','asc');" class="sort">Entry Date</a></th>
	<?php
			}
    ?>
	</tr>
	</thead>
<?php
	$r = $db->query("query","SELECT acm.* FROM avn_city_master acm ORDER BY " . mysql_escape_string($field) . " " . mysql_escape_string($sort) . " LIMIT " . $limitStart. ", " . $limitEnd);
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
?>
		<tr class="<?php echo $class; ?>" id="cityRow-<?php echo $i; ?>">
			<td>
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td><input class="fl" type="checkbox" name="chkCity[]" id="chk-<?php echo $i; ?>" value="<?php echo $r[$i]["unique_id"]; ?>" onclick="javascript: _checked(this, <?php echo $i; ?>);" /></td>
						<td><div class="multimenu ml10 mr10"><img src="./images/options.png" title="More actions" />
						<div class="cb"></div>
						<label>
							<ul>
								<li class="settings p1"><a href="edit-city.php<?php echo filter_querystring($_SERVER["QUERY_STRING"], array("cid","resp","page"), array($r[$i]["unique_id"],"",$curPage)); ?>">Edit</a></li>
								<li class="settings p2"><a href="javascript:void(0);" onclick="javascript:_deletecity(<?php echo $i; ?>,<?php echo $curPage; ?>)" class="btnDelete">Delete</a></li>
							</ul>
						</label>
						</div></td>
					</tr>
				</table>
			</td>
			<td><?php echo $r[$i]["city_name"]; ?></td>
			<td><?php echo $r[$i]["city_prefix"]; ?></td>
			<td><?php echo $r[$i]["entry_date"]; ?></td>
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
					$nav .=    " <a href=\"javascript:void(0);\" onclick =\"javascript: _getCityTable($i, '$field', '$sort');\" class=\"paging\">$i</a>";
			}
			if($curPage > 5)
			{
				$page = $start - 5;
				$prev = " <a href=\"javascript:void(0);\" onclick =\"javascript: _getCityTable($page, '$field', '$sort');\" class=\"paging\">&lt;&lt;&nbsp;Previous</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			if($noOfpage > 5 && $end <= $noOfpage)
			{
				$page = $start + 5;
				$next = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"javascript:void(0);\" onclick=\"javascript: _getCityTable($page, '$field', '$sort');\" class=\"paging\">Next&nbsp;&gt;&gt;</a> ";
			}
		?>
		<table cellpadding="5" cellspacing= "0" border ="0" style="border-collapse:collapse; text-align:left; margin-top:15px;"  width='500px' align='center'>
			<tr>
				<input type="hidden" id="pageNo" name="pageNo" value="<?php echo $curPage; ?>" />
				<td align="left"><?php echo $prev . $nav . $next;?></td>
			</tr>
		</table>
	</div><!-- end of content -->