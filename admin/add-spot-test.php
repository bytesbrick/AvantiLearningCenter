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
<title>Avanti &raquo; Dashboard &raquo; Add Test</title>
<?php
	include_once("./includes/head-meta.php");

	$Qlink = "";
	$type = $_GET["type"];
	if($type == 1){
		$Qlink = "spot-test-questions";
		$pagetitle = "Spot Test";
	}
	if($type == 2){
		$Qlink = "concept-test-questions";
		$pagetitle = "Concept Test";
	}
	if(isset($_GET["currid"]) && $_GET["currid"] != ""){
		$currid = $_GET["currid"];
	}
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
?>
</head>
<body>
<div id="pageR">
	<div id="pageContainerR">
		<div id="wrapper">	
			<div id="header">
			<?php
				$pgName = "topics";
				include_once("./includes/header.php");
				
				$sqlSubjects = "select unique_id, category_name from ltf_category_master lcm";
				$rsSubjects = $db->query("query", $sqlSubjects);
				
				$sqlCurriculums = "select unique_id, curriculum_name from avn_curriculum_master acm";
				$rsCurriculums = $db->query("query", $sqlCurriculums);
				
				if($catgid != 0)
					$sqlChapters = "select unique_id, chapter_name from avn_chapter_master chm WHERE chm.category_id = " . $catgid;
				else
					$sqlChapters = "select unique_id, chapter_name from avn_chapter_master chm";
					$rsChapters = $db->query("query", $sqlChapters);
				if($chptid != 0)
					$sqltopic = "SELECT unique_id, topic_name FROM avn_topic_master WHERE chapter_id = " . $chptid;
				else
					$sqltopic = "SELECT unique_id, topic_name FROM avn_topic_master";
					$rstopics = $db->query("query", $sqltopic);
			?>
			</div><!-- End of header -->
			<div id="container2">
			<div class="about2"><span class="mt2px fl"><a href="./curriculum.php" class="clrmaroon fl">Curriculums</a>&nbsp;&raquo;&nbsp;</span><select class="inputseacrh inputseacrh2" style="width: 130px !important;" id="ddlCurriculum" onchange="javascript: window.location='./category.php?currid=' + this.value;"><option value=''>All</option><?php for($sb = 0; $sb < count($rsCurriculums); $sb++){ if($rsCurriculums[$sb]["unique_id"] == $currid){echo "<option value='" . $rsCurriculums[$sb]["unique_id"] . "' selected='selected'>" . $rsCurriculums[$sb]["curriculum_name"] . "</option>";} else {echo "<option value='" . $rsCurriculums[$sb]["unique_id"] . "'>" . $rsCurriculums[$sb]["curriculum_name"] . "</option>";}} ?></select><span class="mt2px fl">&nbsp;&raquo;&nbsp;</span><select class="inputseacrh inputseacrh2" onchange="javascript: window.location='./chapter.php?catgid=' + this.value;"><option value=''>All</option><?php for($sb = 0; $sb < count($rsSubjects); $sb++){ if($rsSubjects[$sb]["unique_id"] == $catgid){echo "<option value='" . $rsSubjects[$sb]["unique_id"] . "' selected='selected'>" . $rsSubjects[$sb]["category_name"] . "</option>";} else {echo "<option value='" . $rsSubjects[$sb]["unique_id"] . "'>" . $rsSubjects[$sb]["category_name"] . "</option>";}} ?></select><span class="mt2px fl">&nbsp;&raquo;&nbsp;</span><select class="inputseacrh inputseacrh2" onchange="javascript: window.location='./topic.php?catgid=<?php echo $catgid; ?>&chptid=' + this.value;"><option value=''>All</option><?php for($ch = 0; $ch < count($rsChapters); $ch++){ if($rsChapters[$ch]["unique_id"] == $chptid){echo "<option value='" . $rsChapters[$ch]["unique_id"] . "' selected='selected'>" . $rsChapters[$ch]["chapter_name"] . "</option>";} else {echo "<option value='" . $rsChapters[$ch]["unique_id"] . "'>" . $rsChapters[$ch]["chapter_name"] . "</option>";}} ?></select><span class="mt2px fl">&nbsp;&raquo;&nbsp;</span><select class="inputseacrh inputseacrh2" onchange="javascript: var d = this.value.split('|'); window.location='./resource.php?chptid=<?php echo $chptid; ?>&rid=' + d[0] + '&catgid=<?php echo $catgid; ?>&topicid=' + d[1];"><option value=''>All</option><?php for($tp = 0; $tp < count($rstopics); $tp++){ if($rstopics[$tp]["unique_id"] == $topicid){echo "<option value='|" . $rstopics[$tp]["unique_id"] ."' selected='selected'>" . $rstopics[$tp]["topic_name"] . "</option>";} else {echo "<option value='|" . $rstopics[$tp]["unique_id"] . "'>" . $rstopics[$tp]["topic_name"] . "</option>";}} ?></select><span class="mt2px fl">&nbsp;&raquo;&nbsp;<a href="./<?php echo $Qlink; ?>.php<?php echo filter_querystring($_SERVER["QUERY_STRING"], array(), array()); ?>"><?php echo $pagetitle; ?></a>&nbsp;&raquo;&nbsp;Add question</span></div><!-- End of about -->
				<div id="displayUser">
					<form method="post" name="form" enctype='multipart/form-data' id="form" action="./save-spot-test.php"  onsubmit="javascript: return _validatequestion();">						
						<input type="hidden" name="hdCurrID" id="hdCurrID" value="<?php echo $currid; ?>">
						<input type="hidden" name="hdntpid" id="hdntpid" value="<?php echo $_GET["topicid"]; ?>">
						<input type="hidden" name="ddltesttype" id="ddltesttype" value="<?php echo $_GET["type"]; ?>">
						<input type="hidden" id="hdnqryStringTestQuestions" name="hdnqryStringTestQuestions" value="<?php echo urlencode(filter_querystring($_SERVER["QUERY_STRING"])); ?>">
						<table cellspacing="0" cellpadding="0" border="0">
							<tr><td colspan="2" style="height:20px;"><div id="ErrMsg"></div></td></tr>
							<!--<tr>
								<td class="rtd fl mt10" colspan="2">Test</td>
								<td class="fl ml20">
									<select name="ddltesttype" id="ddltesttype" class="dropdown fl" onblur="javascript: document.getElementById('IFtxtquestion').focus();">
										<option value="0">Select Test</option>
										<option value="1">Spot Test</option>
										<option value="2">Concept Test</option>
									</select>
								</td>
							</tr>-->
							<tr><td class="rtd" colspan="2">Question</td></tr>
							<tr>
								<td colspan="2">
									<script type="text/javascript" language="javascript">
										_showEditor('txtquestion', 765, 200, '');
									</script>
								</td>
							</tr>
							<tr style="height:15px;"><td colspan="2"></td></tr>
							<tr><td class="rtd" colspan="2">Option 1</td></tr>
							<tr>
								<td colspan="2">
									<script type="text/javascript" language="javascript">
										_showEditor('txtoptionone', 765, 200, '');
									</script>
								</td>
							</tr>
							<tr style="height:15px;"><td colspan="2"></td></tr>
							<tr><td class="rtd" colspan="2">Option 2</td></tr>
							<tr>
								<td colspan="2">
									<script type="text/javascript" language="javascript">
										_showEditor('txtoptiontwo', 765, 200, '');
									</script>
								</td>
							</tr>
							<tr style="height:15px;"><td colspan="2"></td></tr>
							<tr><td class="rtd" colspan="2">Option 3</td></tr>
							<tr>
								<td colspan="2">
									<script type="text/javascript" language="javascript">
										_showEditor('txtoptionthree', 765, 200, '');
									</script>
								</td>
							</tr>
							<tr style="height:15px;"><td colspan="2"></td></tr>
							<tr><td class="rtd" colspan="2">Option 4</td></tr>
							<tr>
								<td colspan="2">
									<script type="text/javascript" language="javascript">
										_showEditor('txtoptionfour', 765, 200, '');
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
										_showEditor('txtexplanation', 765, 200, '');
									</script>
								</td> 
							</tr>
							<tr style="height:10px;"><td colspan="2"></td></tr>
							<tr>
								<td class="rtd w150">Correct Option</td>
								<td class="ml40 mt10">
									<select name="ddlAnsOption" id="ddlAnsOption" class="dropdown mt10">
										<option value="0">Select option</option>
										<option value="1">Option 1</option>
										<option value="2">Option 2</option>
										<option value="3">Option 3</option>
										<option value="4">Option 4</option>
									</select>
								</td>
							</tr>
							<tr style="height:15px;"><td colspan="2"></td></tr>
							<!--<tr>
								<td class="rtd w150">Question Status</td>
								<td>
									<select name="ddlstatus" id="ddlstatus" class="dropdown mt5">
										<option value="">Select option</option>
										<option value="1">Active</option>
										<option value="0">Inactive</option>
									</select>
								</td>
							</tr>-->
							<tr style="height:15px;"><td colspan="2"></td></tr>
							<tr>
								<td colspan="2">
									<input type="submit" name="btnSave" id="btnSave" class="btnSIgn mt10" value="Save">
									<a href="./spot-test.php"><input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn" /></a>
								</td>
							</tr>
						</table>
					</form>
				</div><!-- end of displayUser -->
			</div><!-- end of container -->
			<?php
				include_once("./includes/sidebar.php");
				$db->close();
			?>
		</div><!-- end of wrapper -->
	</div><!-- end of pagecontainer --> 
</div><!-- end of page -->
</body>
</html>
