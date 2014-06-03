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
	$currid = 0;
	$catgid = 0;
	$chptid = 0;
	$topicid = 0;
	$resid = 0;
	$sort = "ASC";
	$field = "qm.priority";
	    if(isset($_POST["sf"]) && $_POST["sf"] != "")
	    $field = $_POST["sf"];
	if(isset($_POST["sd"]) && $_POST["sd"] != "")
	    $sort = $_POST["sd"];
	
	if(isset($_POST["currid"]) && $_POST["currid"] != ""){
		$currid = $_POST["currid"];
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
	$recPerpage = 25;
	$countWhereClause = "";
	$selectWhereClause = "";
	$pageParam="";               
	$sqlCount = $db->query("query","select count(unique_id) as 'total' from avn_question_master WHERE resource_id = " . $resid . " and type = 2");             
	$recCount = $sqlCount[0]['total'];
	$noOfpage = ceil($recCount/$recPerpage);
	$limitStart = ($curPage - 1) * $recPerpage;
	$limitEnd = $recPerpage;
	$sqlCurriculums = "select unique_id, curriculum_name from avn_curriculum_master acm";
	$rsCurriculums = $db->query("query", $sqlCurriculums);
	
	$sqlSubjects = "select unique_id, category_name from ltf_category_master lcm";
	$rsSubjects = $db->query("query", $sqlSubjects);
	
	if($catgid != 0)
		$sqlChapters = "select unique_id, chapter_name from avn_chapter_master chm WHERE chm.category_id = " . $catgid;
	else
		$sqlChapters = "select unique_id, chapter_name from avn_chapter_master chm";
		$rsChapters = $db->query("query", $sqlChapters);
	if($chptid != 0)
		$sqltopic = "SELECT unique_id, topic_name FROM avn_topic_master WHERE tm.chapter_id = " . $chptid;
	else
		$sqltopic = "SELECT unique_id, topic_name FROM avn_topic_master";
		$rstopics = $db->query("query", $sqltopic);
?>
<table cellspacing="1" width="100%" id="tabConceptqestions" cellpadding="3" border="0" style="background-color:#f5f5f5;" class="mdata">
	<input type="hidden" name="hdntpid" id="hdntpid" value="<?php echo $topicid; ?>">
	<thead>
		<tr style="background-color:#a74242;color:#ffffff;">
			<th width="25px">
                <input type="checkbox" name="chpAll" id="chpAll" onclick="javascript: _checked(this, -1);" style="margin: 0px 0px 0px 15px;" />
            </th>
			<th>Test Type</th>
		<?php
				if($field == "qm.question_name"){
					if($sort == "asc"){
		?>
						<th><a href="javascript:void(0);" onclick="javascript: _getConceptQesTable(<?php echo $currid; ?>,<?php echo $topicid; ?>,<?php echo $catgid; ?>,<?php echo $chptid; ?>, <?php echo $curPage; ?>, 'qm.question_name','desc');" class="sort">Question <img src="./images/up-arr.png" border="0" /></a></th>
		<?php
					}else{
		?>
						<th><a href="javascript:void(0);" onclick="javascript: _getConceptQesTable(<?php echo $currid; ?>,<?php echo $topicid; ?>,<?php echo $catgid; ?>,<?php echo $chptid; ?>, <?php echo $curPage; ?>, 'qm.question_name','asc');" class="sort">Question <img src="./images/down-arr.png" border="0" /></a></th>
		<?php
					}
				}else{
		?>
						<th><a href="javascript:void(0);" onclick="javascript: _getConceptQesTable(<?php echo $currid; ?>,<?php echo $topicid; ?>,<?php echo $catgid; ?>,<?php echo $chptid; ?>, <?php echo $curPage; ?>, 'qm.question_name','asc');" class="sort">Question</a></th>
		<?php
				}
				if($field == "qm.priority"){
					if($sort == "asc"){
		?>
						<th><a href="javascript:void(0);" onclick="javascript: _getConceptQesTable(<?php echo $currid; ?>,<?php echo $topicid; ?>,<?php echo $catgid; ?>,<?php echo $chptid; ?>, <?php echo $curPage; ?>, 'qm.priority','desc');" class="sort">Priority <img src="./images/up-arr.png" border="0" /></a></th>
		<?php
					}else{
		?>
						<th><a href="javascript:void(0);" onclick="javascript: _getConceptQesTable(<?php echo $currid; ?>,<?php echo $topicid; ?>,<?php echo $catgid; ?>,<?php echo $chptid; ?>, <?php echo $curPage; ?>, 'qm.priority','asc');" class="sort">Priority <img src="./images/down-arr.png" border="0" /></a></th>
		<?php
					}
				}else{
		?>
						<th><a href="javascript:void(0);" onclick="javascript: _getConceptQesTable(<?php echo $currid; ?>,<?php echo $topicid; ?>,<?php echo $catgid; ?>,<?php echo $chptid; ?>, <?php echo $curPage; ?>, 'qm.priority','asc');" class="sort">Priority</a></th>
		<?php
				}
		if($field == "qm.status"){
					if($sort == "asc"){
		?>
						<th><a href="javascript:void(0);" onclick="javascript: _getConceptQesTable(<?php echo $currid; ?>,<?php echo $topicid; ?>,<?php echo $catgid; ?>,<?php echo $chptid; ?>, <?php echo $curPage; ?>, 'qm.status','desc');" class="sort">Status <img src="./images/up-arr.png" border="0" /></a></th>
		<?php
					}else{
		?>
						<th><a href="javascript:void(0);" onclick="javascript: _getConceptQesTable(<?php echo $currid; ?>,<?php echo $topicid; ?>,<?php echo $catgid; ?>,<?php echo $chptid; ?>, <?php echo $curPage; ?>, 'qm.status','asc');" class="sort">Status <img src="./images/down-arr.png" border="0" /></a></th>
		<?php
					}
				}else{
		?>
						<th><a href="javascript:void(0);" onclick="javascript: _getConceptQesTable(<?php echo $currid; ?>,<?php echo $topicid; ?>,<?php echo $catgid; ?>,<?php echo $chptid; ?>, <?php echo $curPage; ?>, 'qm.status','asc');" class="sort">Status</a></th>
		<?php
				}
		?>
		</tr>
	</thead>
		<?php
			$r = $db->query("query","SELECT DISTINCT qm.*,rd.topic_id FROM avn_question_master qm INNER JOIN avn_resources_detail rd ON rd.topic_id = qm.topic_id WHERE qm.topic_id = " . $topicid . " AND qm.type = 2 AND rd.topic_id = " . $topicid . " ORDER BY " . mysql_escape_string($field) . " " . mysql_escape_string($sort) . " limit ".$limitStart.", ".$limitEnd);
			if(!array_key_exists("response", $r))
			{
		?>
		<tbody id="Conceptqesdata">
		<?php
			$srno = $limitStart;
			for($i=0; $i< count($r); $i++)
			{
				$srno++;
				if($i % 2 == 0)
					$class = "lightyellow";
				else
					$class = "darkyellow";
		?>
			<tr class="<?php echo $class; ?>" id="Conceptdatarow-<?php echo $i; ?>">
				<td>
					<table>
						<tr>
							<td><input class="fl" type="checkbox" name="chkconceptqes[]" id="chk-<?php echo $i; ?>" value="<?php echo $r[$i]["unique_id"]; ?>" onclick="javascript: _checked(this, <?php echo $i; ?>);" /></td>
							<td>
								<div class="multimenu"><img src="./images/options.png" title="More actions" />
									<div class="cb"></div>
									<label>
										<ul>
											<li class="settings p1"><a href="edit-spot-test.php<?php echo filter_querystring($_SERVER["QUERY_STRING"], array("currid","cid","catgid","chptid","topicid","rid","type","resp","page"),array($currid,$r[$i]["unique_id"],$catgid,$chptid,$topicid,$resid, 2,"",$curPage))?>">Edit</a></li>
											<li class="settings p2"><a href="javascript:void(0);" style="color:#f00;margin:0px 5px 0px 0px;" onclick="javascript:_deleteconceptquestion(<?php echo $currid; ?>,<?php echo $i; ?>,<?php echo $topicid; ?>,<?php echo $chptid; ?>,<?php echo $catgid; ?>,'2',<?php echo $curPage; ?>)">Delete</a></li>
										</ul>
									</label>
								</div>
							</td>
						</tr>
					</table>
				</td>
				<?php
						if($r[$i]["type"] == 1){
				?>
							<td><?php echo "Spot Test" ?></td>
				<?php
						}else{
				?>
							<td><?php echo "Concept Test" ?></td>
				<?php
						}
				?>
				<td><?php echo $r[$i]["question_name"]; ?></td>
				<td>
					<?php echo $r[$i]["priority"]; ?>
					<?php
						$totlares = $db->query("query","SELECT COUNT(unique_id) as total FROM avn_question_master WHERE resource_id = " . $resid . " AND type = 2");
						$rd = $db->query("query","SELECT MAX(priority) as maxp,MIN(priority) as minp FROM avn_question_master WHERE resource_id = ". $resid . " AND type = 2");
						if($rd[0]['minp'] == $r[$i]['priority'])
						{
				?>
							<a href="javascript:void(0);" style="display: none;">
								<img src="./images/showmore-up.png" id="up" name="up" class="noborder" onclick="javascript: _setqnspriority(<?php echo $currid; ?>,<?php echo $catgid; ?>,<?php echo $chptid; ?>,<?php echo $r[$i]['unique_id']; ?>,this.id,<?php echo $topicid; ?>,'2',<?php echo $curPage; ?>);" class="fl" style="width: 14px;" />
							</a>
				<?php
						}else{
				?>
							<a href="javascript:void(0);">
								<img src="./images/showmore-up.png" id="up" name="up" class="noborder" onclick="javascript: _setqnspriority(<?php echo $currid; ?>,<?php echo $catgid; ?>,<?php echo $chptid; ?>,<?php echo $r[$i]['unique_id']; ?>,this.id,<?php echo $topicid; ?>,'2',<?php echo $curPage; ?>);"  class="fl" style="width: 14px;" />
							</a>
				<?php
							}
							if($rd[0]['maxp'] == $r[$i]['priority']){
				?>
								<a href="javascript:void(0);" style="display: none;">
									<img src="./images/showmore.png" id="down" name="down" class="noborder" onclick="javascript: _setqnspriority(<?php echo $currid; ?>,<?php echo $catgid; ?>,<?php echo $chptid; ?>,<?php echo $r[$i]['unique_id']?>,this.id,<?php echo $topicid; ?>,'2',<?php echo $curPage; ?>);" class="fl" style="width: 14px;" />
								</a>
				<?php
							}
							else
							{
				?>
								<a href="javascript:void(0);">
									<img src="./images/showmore.png" id="down" name="down" class="noborder" onclick="javascript: _setqnspriority(<?php echo $currid; ?>,<?php echo $catgid; ?>,<?php echo $chptid; ?>,<?php echo $r[$i]['unique_id']?>,this.id,<?php echo $topicid; ?>,'2',<?php echo $curPage; ?>);" class="fl" style="width: 14px;" />
								</a>
				<?php
							}
				?>
				</td>
				<?php
						if($r[$i]["status"] == 1){
				?>
							<td><a href="javascript:void(0);" id="inactivestatus" name="inactivestatus" style="color: #3c6435;" onclick="javascript: _chngConQesStatus(<?php echo $currid; ?>,<?php echo $i; ?>,<?php echo $r[$i]['topic_id']; ?>,<?php echo $chptid; ?>,<?php echo $catgid; ?>,this.id,2,<?php echo $curPage; ?>)"><?php echo "Active"; ?></a></td>
				<?php
						}else{
				?>
							<td><a href="javascript:void(0);" id="activestatus" name="activestatus" style="color: #f00;" onclick="javascript: _chngConQesStatus(<?php echo $currid; ?>,<?php echo $i; ?>,<?php echo $r[$i]['topic_id']; ?>,<?php echo $chptid; ?>,<?php echo $catgid; ?>,this.id,2,<?php echo $curPage; ?>)"><?php echo "Inactive"; ?></a></td>
				<?php
						}
				?>
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
					$nav .= "<a href=\"javascript: void(0);\" class=\"currentPage\"> $i</a>";
				else
					$nav .=    " <a href=\"javascript:void(0);\" onclick=\"javascript: _getConceptQesTable($currid,$topicid, $resid, $catgid, $chptid,$i,'$field','$sort');\" class=\"paging\">$i</a>";
			}
			if($curPage > 5)
			{
				$page = $start - 5;
				$prev = " <a href=\"javascript:void(0);\" onclick=\"javascript: _getConceptQesTable($currid,$topicid, $resid, $catgid, $chptid,$page,'$field','$sort');\" class=\"paging\">&lt;&lt;&nbsp;Previous</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			if($noOfpage > 5 && $end <= $noOfpage)
			{
				$page = $start + 5;
				$next = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"javascript:void(0);\" onclick=\"javascript: _getConceptQesTable($currid,$topicid, $resid, $catgid, $chptid,$page,'$field','$sort');\" class=\"paging\">Next&nbsp;&gt;&gt;</a> ";
			}
		?>
			<table cellpadding="5" cellspacing= "0" border ="0" style="border-collapse:collapse; text-align:left; margin-top:15px;"  width='500px' align='center'>
				<tr>
					<input type="hidden" id="pageNo" name="pageNo" value="<?php echo $curPage; ?>" />
					<td align="left"><?php echo $prev . $nav . $next;?></td>
				</tr>
			</table>
			<input type="hidden" id="hdnqryStringTestQuestions" name="hdnqryStringTestQuestions" value="<?php echo filter_querystring($_SERVER["QUERY_STRING"]); ?>">
		</div><!-- end of content -->