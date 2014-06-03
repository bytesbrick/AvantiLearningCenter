<?php
	error_reporting(0);
	include("./includes/config.php");		
	include("./classes/cor.mysql.class.php");
	include("./includes/checkLogin.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title>Avanti &raquo; Resouces &raquo; Questions &raquo; Edit Question</title>
<?php
	include_once("./includes/head-meta.php");
?>
</head>
<body>
 <?php
if(isset($_GET["cid"]))
{
	$type = "";
	$Qlink = "";
	$pagetitle = "";
	$type = $_GET["type"];
	if($type == 1){ 
		$Qlink = "spot-test-questions"; 
		$pagetitle = "Spot Test";
	}
	if($type == 2){
		$Qlink = "concept-test-questions";
		$pagetitle = "Concept Test";
	}
		
	$r = $db->query("query","select * from avn_question_master where unique_id = " . $_GET['cid']);
	if(isset($_GET["catgid"]) && $_GET["catgid"] != ""){
		$catgid = $_GET["catgid"];
		$where .= $where == "" ? "chm.category_id = " . mysql_escape_string($catgid) : " AND chm.category_id = " . mysql_escape_string($catgid);
	}
	if(isset($_GET["chptid"]) && $_GET["chptid"] != ""){
		$chptid = $_GET["chptid"];
		$where .= $where == "" ? "tm.chapter_id = " . mysql_escape_string($chptid) : " AND tm.chapter_id = " . mysql_escape_string($chptid);
	}
	if(isset($_GET["topicid"]) && $_GET["topicid"] != ""){
		$topicid = $_GET["topicid"];
		$where .= $where == "" ? "rd.topic_id = " . mysql_escape_string($topicid) : " AND rd.topic_id = " . mysql_escape_string($topicid);
	}
	if(isset($_GET["rid"]) && $_GET["rid"] != "")
		$resid = $_GET["rid"];
	if(isset($_GET["currid"]) && $_GET["currid"] != "")
		$currid = $_GET["currid"];
	if(!array_key_exists("response", $r))
		{
		if(!$r["response"] == "ERROR")
			{
			for($i=0; $i< count($r); $i++)
				{
?>
<div id="page">
	<div id="pageContainer">
		<div id="wrapper">	
			<div id="header">
			<?php
				$pgName = "topics";
				include_once("./includes/header.php");
				
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
				    $sqltopic = "SELECT tm.unique_id, tm.topic_name, lrm.unique_id as 'ResID' FROM avn_topic_master tm INNER JOIN ltf_resources_master lrm ON tm.unique_id = lrm.topic_id WHERE tm.chapter_id = " . $chptid;
							
				else
				    $sqltopic = "SELECT tm.unique_id, tm.topic_name, lrm.unique_id as 'ResID' FROM avn_topic_master tm INNER JOIN ltf_resources_master lrm ON tm.unique_id = lrm.topic_id";
				    $rstopics = $db->query("query", $sqltopic);
			?>
			</div><!-- End of header -->
			<div id="container2">
				<?php
					$isNext = false;
					$isPrev = false;
					$SelNextResource = "SELECT DISTINCT qm.unique_id FROM avn_question_master qm INNER JOIN avn_resources_detail rd ON qm.resource_id = rd.resource_id WHERE qm.unique_id > " . $_GET["cid"] . " AND rd.topic_id = " . $_GET["topicid"] . " AND type = " . $_GET["type"] . " AND qm.resource_id = " . $_GET["rid"] . " ORDER BY qm.priority ASC";
					$SelNextResourceRS = $db->query("query", $SelNextResource);
					if(!array_key_exists("response", $SelNextResourceRS))
						$nextResource = $SelNextResourceRS[0]["unique_id"];
						$isNext = true;
						if($isNext == true && $nextResource != ""){
				?>
					<span class="fr mr20" style="margin: 10px;"><a href="./edit-spot-test.php?currid=<?php echo $durrid; ?>&cid=<?php echo $nextResource; ?>&catgid=<?php echo $catgid; ?>&chptid=<?php echo $chptid; ?>&topicid=<?php echo $topicid; ?>&rid=<?php echo $resid; ?>&type=<?php echo $_GET["type"]; ?>&page=<?php echo $_GET["page"]; ?>" class="nexttext">Next &raquo;</a></span>
				<?php
					}
					unset($SelNextResourceRS);
					$SelPreviousResource = "SELECT DISTINCT qm.unique_id FROM avn_question_master qm INNER JOIN avn_resources_detail rd ON qm.resource_id = rd.resource_id WHERE qm.unique_id < " . $_GET["cid"] . " AND rd.topic_id = " . $_GET["topicid"] . " AND type = " . $_GET["type"] . " AND qm.resource_id = " . $_GET["rid"] . " ORDER BY qm.priority ASC";
					$SelPreviousResourceRS = $db->query("query", $SelPreviousResource);
					if(!array_key_exists("response", $SelNextResourceRS))
						$PreviousResource = $SelPreviousResourceRS[0]["unique_id"];
						$isPrev = true;
					if($isPrev == true && $PreviousResource != ""){
				?>
					<span class="fl mr20" style="margin: 10px;"><a href="./edit-spot-test.php?currid=<?php echo $durrid; ?>&cid=<?php echo $PreviousResource; ?>&catgid=<?php echo $catgid; ?>&chptid=<?php echo $chptid; ?>&topicid=<?php echo $topicid; ?>&rid=<?php echo $resid; ?>&type=<?php echo $_GET["type"]; ?>&page=<?php echo $_GET["page"]; ?>" class="nexttext">&laquo; Previous</a></span>
				<?php
					}
					unset($SelPreviousResourceRS);
				?>
				<div class="about2"><span class="mt2px fl"><a href="./curriculum.php" class="clrmaroon fl">Curriculums</a>&nbsp;&raquo;&nbsp;</span><select class="inputseacrh inputseacrh2" id="ddlCurriculum" onchange="javascript: window.location='./category.php?currid=' + this.value;"><option value=''>All</option><?php for($sb = 0; $sb < count($rsCurriculums); $sb++){ if($rsCurriculums[$sb]["unique_id"] == $currid){echo "<option value='" . $rsCurriculums[$sb]["unique_id"] . "' selected='selected'>" . $rsCurriculums[$sb]["curriculum_name"] . "</option>";} else {echo "<option value='" . $rsCurriculums[$sb]["unique_id"] . "'>" . $rsCurriculums[$sb]["curriculum_name"] . "</option>";}} ?></select><span class="mt2px fl">&nbsp;&raquo;&nbsp;</span><select class="inputseacrh inputseacrh2" onchange="javascript: window.location='./chapter.php?catgid=' + this.value;"><option value=''>All</option><?php for($sb = 0; $sb < count($rsSubjects); $sb++){ if($rsSubjects[$sb]["unique_id"] == $catgid){echo "<option value='" . $rsSubjects[$sb]["unique_id"] . "' selected='selected'>" . $rsSubjects[$sb]["category_name"] . "</option>";} else {echo "<option value='" . $rsSubjects[$sb]["unique_id"] . "'>" . $rsSubjects[$sb]["category_name"] . "</option>";}} ?></select><span class="mt2px fl">&nbsp;&raquo;&nbsp;</span><select class="inputseacrh inputseacrh2" onchange="javascript: window.location='./topic.php?catgid=<?php echo $catgid; ?>&chptid=' + this.value;"><option value=''>All</option><?php for($ch = 0; $ch < count($rsChapters); $ch++){ if($rsChapters[$ch]["unique_id"] == $chptid){echo "<option value='" . $rsChapters[$ch]["unique_id"] . "' selected='selected'>" . $rsChapters[$ch]["chapter_name"] . "</option>";} else {echo "<option value='" . $rsChapters[$ch]["unique_id"] . "'>" . $rsChapters[$ch]["chapter_name"] . "</option>";}} ?></select><span class="mt2px fl">&nbsp;&raquo;&nbsp;</span><select class="inputseacrh inputseacrh2" onchange="javascript: var d = this.value.split('|'); window.location='./resource.php?chptid=<?php echo $chptid; ?>&rid=' + d[0] + '&catgid=<?php echo $catgid; ?>&topicid=' + d[1];"><option value=''>All</option><?php for($tp = 0; $tp < count($rstopics); $tp++){ if($rstopics[$tp]["unique_id"] == $topicid){echo "<option value='" . $rstopics[$tp]["ResID"] . "|" . $rstopics[$tp]["unique_id"] ."' selected='selected'>" . $rstopics[$tp]["topic_name"] . "</option>";} else {echo "<option value='" . $rstopics[$tp]["ResID"] . "|" . $rstopics[$tp]["unique_id"] . "'>" . $rstopics[$tp]["topic_name"] . "</option>";}} ?></select><span class="mt2px fl">&nbsp;&raquo;&nbsp;<a href="./<?php echo $Qlink; ?>.php<?php echo filter_querystring($_SERVER["QUERY_STRING"], array("cid","page"), array("","")); ?>"><?php echo $pagetitle; ?></a>&nbsp;&raquo;&nbsp;Edit question</span></div><!-- End of about -->
				<div id="displayUser">
					<form method="post" name="form" id="form" enctype='multipart/form-data' action="update-spot-test.php" onsubmit="return _EditTest();">
						<input type="hidden" name="hdqid" id="hdqid" value="<?php echo $r[0]['unique_id']; ?>" />
						<input type="hidden" name="hdnresid" id="hdnresid" value="<?php echo $resid; ?>" />
						<input type="hidden" name="hdntpid" id="hdntpid" value="<?php echo $topicid; ?>" />
						<input type="hidden" name="hdnQtype" id="hdnQtype" value="<?php echo $type; ?>" />
						<input type="hidden" id="hdnqryStringTestQuestions" name="hdnqryStringTestQuestions" value="<?php echo urlencode(filter_querystring($_SERVER["QUERY_STRING"],array("cid","resp"), array("",""))); ?>">
						<table cellspacing="0" cellpadding="0" border="0">
							<tr><td colspan="2" style="height:20px;"><div id="ErrMsg"></div></td></tr>
							<tr>
								<td colspan="2">
									<span class="rtd fl mt5">Test</span>
									<select name="ddltesttype" id="ddltesttype" class="dropdown ml20">
										<option value="1" <?php if ($r[0]['type'] == 1) echo "selected"; ?> >Spot Test</option>
										<option value="2" <?php if ($r[0]['type'] == 2) echo "selected"; ?> >Concept Test</option>
									</select>
								</td>
							</tr>
							<tr style="height:15px;"><td colspan="2"></td></tr>
							<tr><td class="rtd" colspan="2">Question</td></tr>
							<tr>
								<td>
									<script type="text/javascript" language="javascript">
										_showEditor('txtquestion', 765, 200, '<?php echo html_entity_decode(nl2br($r[0]['question_name'])); ?>');
									</script>
								</td>
							</tr>
							<tr style="height:15px;"><td colspan="2"></td></tr>
							<tr><td class="rtd" colspan="2">Option 1</td></tr>
							<tr>
								<td class="fl" colspan="2">
									<script type="text/javascript" language="javascript">
										_showEditor('txtoptionone', 765, 200, '<?php echo html_entity_decode(nl2br($r[0]['option1'])); ?>');
									</script>
								</td>
							</tr>
							<tr style="height:15px;"><td colspan="2"></td></tr>
							<tr><td class="rtd" colspan="2">Option 2</td></tr>
							<tr>
								<td class="fl" colspan="2">
									<script type="text/javascript" language="javascript">
										_showEditor('txtoptiontwo', 765, 200, '<?php echo html_entity_decode(nl2br($r[0]['option2'])); ?>');
									</script>
								</td>
							</tr>
							<tr style="height:15px;"><td colspan="2"></td></tr>
							<tr><td class="rtd" colspan="2">Option 3</td></tr>
							<tr>
								<td class="fl" colspan="2">
									<script type="text/javascript" language="javascript">
										_showEditor('txtoptionthree', 765, 200, '<?php echo html_entity_decode(nl2br($r[0]['option3'])); ?>');
									</script>
								</td>
							</tr>
							<tr style="height:15px;"><td colspan="2"></td></tr>
							<tr><td class="rtd" colspan="2">Option 4</td></tr>
							<tr>
								<td class="fl" colspan="2">
									<script type="text/javascript" language="javascript">
										_showEditor('txtoptionfour', 765, 200, '<?php echo html_entity_decode(nl2br($r[0]['option4'])); ?>');
									</script>
								</td>
							</tr>
							<tr style="height:15px;"><td colspan="2"></td></tr>
							<tr>
								<td class="rtd mt10" colspan="2">Explanation</td>
							</tr>
							<tr>
								<td colspan="2">
									<script type="text/javascript" language="javascript">
										_showEditor('txtexplanation', 765, 200, '<?php echo html_entity_decode(nl2br($r[0]['explanation'])); ?>');
									</script>
								</td>
							</tr>
							<tr style="height:10px;"><td colspan="2"></td></tr>
							<tr>
								<td colspan="2">
									<span class="rtd fl mt10 w150">Correct Option</span>
									<select name="ddlAnsOption" id="ddlAnsOption" class="dropdown mt10">
										<option value="1" <?php if ($r[0]['correct_answer'] == 1) echo "selected"; ?> >Option 1</option>
										<option value="2" <?php if ($r[0]['correct_answer'] == 2) echo "selected"; ?> >Option 2</option>
										<option value="3" <?php if ($r[0]['correct_answer'] == 3) echo "selected"; ?> >Option 3</option>
										<option value="4" <?php if ($r[0]['correct_answer'] == 4) echo "selected"; ?> >Option 4</option>
									</select>
								</td>
							</tr>
							<tr style="height:10px;"><td colspan="2"></td></tr>
							<tr>
								<td colspan="2">
									<span class="rtd fl mt10 w150">Question Status</span>
									<select name="ddlstatus" id="ddlstatus" class="dropdown mt10">
										<option value="1" <?php if ($r[0]['status'] == 1) echo "selected"; ?> >Active</option>
										<option value="0" <?php if ($r[0]['status'] == 0) echo "selected"; ?> >Inactive</option>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<input type="submit" name="btnUpdate" id="btnUpdate" class="btnSIgn mt20" value="Update">
									<a href="./spot-test.php"><input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn" /></a>
								</td>
							</tr>
						</table>
					</form>
				</div><!--end of displayUser-->	
			</div><!-- end of container -->
			<?php
				include_once("./includes/sidebar.php");
			?>
		</div><!-- end of wrapper -->
	</div><!-- end of pagecontainer -->
</div><!-- end of page -->
<?php
			}
		}
	}
}	
	unset($r);
	$db->close();
?>
</body>
</html>