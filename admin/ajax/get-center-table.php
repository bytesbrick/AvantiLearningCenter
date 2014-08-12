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
	$field = "alcm.unique_id";
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
	$sqlCount = $db->query("query","select count(alcm.unique_id) as 'total' from avn_learningcenter_master alcm");
	$recCount = $sqlCount[0]['total'];
	$noOfpage = ceil($recCount/$recPerpage);
	$limitStart = ($curPage - 1) * $recPerpage;
	$limitEnd = $recPerpage;
?>
<table cellspacing="1" cellpadding="3" id="tabCenter" width="100%" border="0" style="background-color:#f5f5f5;" class="mdata">
	<thead>
	<tr style="background-color:#A74242;color:#ffffff;">
		<th width="25px">
			<input type="checkbox" name="catgAll" id="catgAll"  onclick="javascript: _checked(this, -1);" style="margin-left: 15px;" />
		</th>
	<?php
			if($field == "alcm.center_code"){
                if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getCenterTable(<?php echo $curPage; ?>, 'alcm.center_code','desc');" class="sort">Center Code <img src="./images/up-arr.png" border="0" /></a></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getCenterTable(<?php echo $curPage; ?>, 'alcm.center_code','asc');" class="sort">Center Code <img src="./images/down-arr.png" border="0" /></a></th>
    <?php
                }
            }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getCenterTable(<?php echo $curPage; ?>, 'alcm.center_code','asc');" class="sort">Center Code</a></th>
	<?php
			}
            if($field == "alcm.center_name"){
                if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getCenterTable(<?php echo $curPage; ?>, 'alcm.center_name','desc');" class="sort">Center <img src="./images/up-arr.png" border="0" /></a></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getCenterTable(<?php echo $curPage; ?>, 'alcm.center_name','asc');" class="sort">Center <img src="./images/down-arr.png" border="0" /></a></th>
    <?php
                }
            }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getCenterTable(<?php echo $curPage; ?>, 'alcm.center_name','asc');" class="sort">Center</a></th>
	<?php
			}
	?>
	<?php
            if($field == "acm.city_name"){
                if($sort == "asc"){
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getCenterTable(<?php echo $curPage; ?>, 'acm.city_name','desc');" class="sort">City Name <img src="./images/up-arr.png" border="0" /></a></th>
    <?php
                }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getCenterTable(<?php echo $curPage; ?>, 'acm.city_name','asc');" class="sort">City Name <img src="./images/down-arr.png" border="0" /></a></th>
    <?php
                }
            }else{
    ?>
                    <th><a href="javascript:void(0);" onclick="javascript: _getCenterTable(<?php echo $curPage; ?>, 'acm.city_name','asc');" class="sort">City Name</a></th>
	<?php
            
			}
    ?>
	<th>Options</th>
	</tr>
	</thead>
<?php
	if($arrUserInfo["usertype"] == "Manager"){
		$managerID = $arrUserInfo["user_ref_id"];
		$r = $db->query("query","SELECT DISTINCT alcm.*, acm.city_name FROM avn_learningcenter_master alcm INNER JOIN avn_city_master acm ON acm.unique_id = alcm.city_id INNER JOIN avn_manager_center_mapping amcm ON amcm.center_id =  alcm.unique_id AND manager_id =  " . $managerID . "  ORDER BY " . mysql_escape_string($field) . " " . mysql_escape_string($sort) . " LIMIT " . $limitStart. ", " . $limitEnd);
	}else{
		$r = $db->query("query","SELECT alcm.*, acm.city_name FROM avn_learningcenter_master alcm INNER JOIN avn_city_master acm ON acm.unique_id = alcm.city_id ORDER BY " . mysql_escape_string($field) . " " . mysql_escape_string($sort) . " LIMIT " . $limitStart. ", " . $limitEnd);
	}
	//print_r($r);
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
		<tr class="<?php echo $class; ?>" id="centerRow-<?php echo $r[$i]["unique_id"]; ?>">
			<td>
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td><input class="fl" type="checkbox" name="chkCenter[]" id="chk-<?php echo $i; ?>" value="<?php echo $r[$i]["unique_id"]; ?>" onclick="javascript: _checked(this, <?php echo $r[$i]["unique_id"]; ?>);" /></td>
					</tr>
				</table>
			</td>
			<td><?php echo $r[$i]["center_code"]; ?></td>
			<td><?php echo $r[$i]["center_name"]; ?></td>
			<td><?php echo $r[$i]["city_name"]; ?></td>
			<td>
				<a href="edit-center.php<?php echo filter_querystring($_SERVER["QUERY_STRING"], array("cid","resp","page"), array($r[$i]["unique_id"],"",$curPage)); ?>">Edit</a> |
				<a href="javascript:void(0);" onclick="javascript:_deletecenter(<?php echo $i; ?>,<?php echo $curPage; ?>)" class="btnDelete">Delete</a>
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