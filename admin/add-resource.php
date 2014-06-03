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
<title>Avanti &raquo; Dashboard &raquo; Add Resource</title>
<?php
	include_once("./includes/head-meta.php");
	
	$catgid = 0;
	$chptid = 0;
	$topicid = 0;
	$resid = 0;
	$currid = 0;
	if(isset($_GET["currid"]) && $_GET["currid"] != ""){
		$currid = $_GET["currid"];
	}
	if(isset($_GET["catgid"]) && $_GET["catgid"] != ""){
		$catgid = $_GET["catgid"];
	}
	if(isset($_GET["chptid"]) && $_GET["chptid"] != ""){
		$chptid = $_GET["chptid"];
	}
	if(isset($_GET["topicid"]) && $_GET["topicid"] != ""){
		$topicid = $_GET["topicid"];
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
					$sqltopic = "SELECT unique_id, topic_name FROM avn_topic_master tm WHERE tm.chapter_id = " . $chptid;
				else
					$sqltopic = "SELECT unique_id, topic_name FROM avn_topic_master tm";
					$rstopics = $db->query("query", $sqltopic);
			?>
			</div><!-- End of header -->
			<div id="container2">
				<div class="about2"><span class="fl"><a href="./curriculum.php" class="clrmaroon fl">Curriculums</a><span class="fl">&nbsp;&raquo;&nbsp;</span><span>&nbsp;&raquo;&nbsp;</span><select class="inputseacrh inputseacrh2" id="ddlCurriculum" onchange="javascript: window.location='./category.php?currid=' + this.value;"><option value=''>All</option><?php for($sb = 0; $sb < count($rsCurriculums); $sb++){ if($rsCurriculums[$sb]["unique_id"] == $currid){echo "<option value='" . $rsCurriculums[$sb]["unique_id"] . "' selected='selected'>" . $rsCurriculums[$sb]["curriculum_name"] . "</option>";} else {echo "<option value='" . $rsCurriculums[$sb]["unique_id"] . "'>" . $rsCurriculums[$sb]["curriculum_name"] . "</option>";}} ?></select></span><select class="inputseacrh inputseacrh2" onchange="javascript: window.location='./chapter.php?catgid=' + this.value;"><option value=''>All</option><?php for($sb = 0; $sb < count($rsSubjects); $sb++){ if($rsSubjects[$sb]["unique_id"] == $catgid){echo "<option value='" . $rsSubjects[$sb]["unique_id"] . "' selected='selected'>" . $rsSubjects[$sb]["category_name"] . "</option>";} else {echo "<option value='" . $rsSubjects[$sb]["unique_id"] . "'>" . $rsSubjects[$sb]["category_name"] . "</option>";}} ?></select><span class="mt2px fl">&nbsp;&raquo;&nbsp;</span><select class="inputseacrh inputseacrh2" onchange="javascript: window.location='./topic.php?catgid=<?php echo $catgid; ?>&chptid=' + this.value;"><option value=''>All</option><?php for($ch = 0; $ch < count($rsChapters); $ch++){ if($rsChapters[$ch]["unique_id"] == $chptid){echo "<option value='" . $rsChapters[$ch]["unique_id"] . "' selected='selected'>" . $rsChapters[$ch]["chapter_name"] . "</option>";} else {echo "<option value='" . $rsChapters[$ch]["unique_id"] . "'>" . $rsChapters[$ch]["chapter_name"] . "</option>";}} ?></select><span class="mt2px fl">&nbsp;&raquo;&nbsp;</span><select class="inputseacrh inputseacrh2" onchange="javascript: var d = this.value.split('|'); window.location='./resource.php?currid=<?php echo $currid; ?>&chptid=<?php echo $chptid; ?>&catgid=<?php echo $catgid; ?>&topicid=' + d[1];"><option value=''>All</option><?php for($tp = 0; $tp < count($rstopics); $tp++){ if($rstopics[$tp]["unique_id"] == $topicid){echo "<option value='" . $rstopics[$tp]["ResID"] . "|" . $rstopics[$tp]["unique_id"] ."' selected='selected'>" . $rstopics[$tp]["topic_name"] . "</option>";} else {echo "<option value='" . $rstopics[$tp]["ResID"] . "|" . $rstopics[$tp]["unique_id"] . "'>" . $rstopics[$tp]["topic_name"] . "</option>";}} ?></select>&nbsp;&raquo;&nbsp;Add Resource</span></div><!-- End of about -->
				<div id="displayUser">
					<form method="post" name="form" enctype='multipart/form-data' id="form" action="./save-resource.php" onsubmit="javascript: return _validateresource();">
						<table cellspacing="4" cellpadding="0" border="0" class="mt15" width="100%">
							<input type="hidden" name="hdntp" id="hdntp" value="<?php echo $topicid; ?>" />
							<input type="hidden" name="hdCurrID" id="hdCurrID" value="<?php echo $resid; ?>" />
							<input type="hidden" id="hdIsValidSlug" name="hdIsValidSlug" value="0">
							<input type="hidden" id="hdIsSlugAdd" name="hdIsSlugAdd" value="0">
							<input type="hidden" id="hdIsduplicacyAdd" name="hdIsduplicacyAdd" value="0">
							<input type="hidden" id="hdnqryStringResource" name="hdnqryStringResource" value="<?php echo urlencode(filter_querystring($_SERVER["QUERY_STRING"])); ?>">
							<input type="hidden" id="hdSlug" name="hdSlug" value="">
							<tr>
								<td colspan="2">
									<div id="errormsg"></div>
								</td>
							</tr>
							<tr>
								<td class="Topictext">
									Resource Title
								</td>
								<td class="Topictext" colspan="3">
									<input type="text" name="resourcetitle" id="resourcetitle" placeholder="Title" class="inputseacrh" onblur="javascript: document.getElementById('IFtxtContentIntro').focus();_createSlug(this.value, 'hdSlug', 'resource_slug','avn_resources_detail');" style="width: 544px;" />
								</td>
							</tr>
							<tr>
								<td class="Topictext" colspan="4">
									Text
								</td>
							</tr>
							<tr>
								<td colspan="4">
									<script type="text/javascript" language="javascript">
										_showEditor('txtContentIntro', 765, 500, '');
									</script>
								</td>
							</tr>
							<!--<tr>
								<td class="Topictext">
									Resource Slug
								</td>
								<td><input type="text" name="txtresourceslug" id="txtresourceslug" onblur="javascript: _checkslug('txtresourceslug', 'resource_slug','avn_resources_detail');" class="inputseacrh mt10" placeholder="Slug" />
									<div id="imgslug" class="imgslug"></div>
									<div id="msg" class="chkedmsg"></div><div class="clr"></div>
									<div class="duplicacymsg fl">This will be checked for duplicacy.</div>
								</td>
							</tr>-->
							<tr>
								<td colspan="4">
									<input type="submit" name="btnSave" id="btnSave" class="btnSIgn mt10" value="Save" />
									<a href="./topic.php"><input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn mt10 ml10" /></a>
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