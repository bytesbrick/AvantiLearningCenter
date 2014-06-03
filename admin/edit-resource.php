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
<title>Avanti &raquo; Dashboard &raquo; Edit Resource</title>
<?php
	include_once("./includes/head-meta.php");
	
	$currid = 0;
	$catgid = 0;
	$chptid = 0;
	$topicid = 0;
	$resid = 0;
	$cid = $_GET["cid"];
	$curPage = $_GET["page"];
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
					$sqltopic = "SELECT unique_id, topic_name FROM avn_topic_master WHERE chapter_id = " . $chptid;
				else
					$sqltopic = "SELECT unique_id, topic_name FROM avn_topic_master";
					$rstopics = $db->query("query", $sqltopic);
				
				$sqlRes = "SELECT unique_id,title FROM avn_resources_detail WHERE topic_id = " . $topicid . " AND content_type = 'Content'" ;
				$RSres = $db->query("query",$sqlRes);
			?>
			</div><!-- End of header -->
			<div id="container2">
				<div class="fl" style="width: 100%;">
					<?php
						$isNext = false;
						$isPrev = false;
						$SelNextResource = "SELECT rd.unique_id,rd.title,rd.text,rd.status,tm.topic_name FROM avn_resources_detail rd INNER JOIN avn_topic_master tm ON rd.topic_id = tm.unique_id WHERE rd.unique_id > " . $_GET['cid'] . " AND content_type = 'Content' AND rd.topic_id = " . $topicid . " ORDER BY rd.priority ASC";
						$SelNextResourceRS = $db->query("query", $SelNextResource);
						if(!array_key_exists("response", $SelNextResourceRS))
							$nextResource = $SelNextResourceRS[0]["unique_id"];
							$isNext = true;
							if($isNext == true && $nextResource != ""){
					?>
						<span class="fr mr20" style="margin: 10px;"><a href="./edit-resource.php?currid=<?php echo $currid; ?>&topicid=<?php echo $topicid; ?>&rid=<?php echo $resid; ?>&catgid=<?php echo $catgid; ?>&chptid=<?php echo $chptid; ?>&cid=<?php echo $nextResource; ?>" class="nexttext">Next &raquo;</a></span>
					<?php
						}
						unset($SelNextResourceRS);
						$SelPreviousResource = "SELECT MAX(rd.unique_id) as 'uid',rd.title,rd.resource_slug,rd.status,tm.topic_name FROM avn_resources_detail rd INNER JOIN avn_topic_master tm ON rd.topic_id = tm.unique_id WHERE rd.unique_id < " . $_GET['cid'] . " AND content_type = 'Content' AND rd.topic_id = " . $topicid . " ORDER BY rd.priority ASC";
						$SelPreviousResourceRS = $db->query("query", $SelPreviousResource);
						if(!array_key_exists("response", $SelNextResourceRS))
							$PreviousResource = $SelPreviousResourceRS[0]["uid"];
							$isPrev = true;
						if($isPrev == true && $PreviousResource != ""){
					?>
						<span class="fl mr20" style="margin: 10px;"><a href="./edit-resource.php?currid=<?php echo $currid; ?>&topicid=<?php echo $topicid; ?>&rid=<?php echo $resid; ?>&catgid=<?php echo $catgid; ?>&chptid=<?php echo $chptid; ?>&cid=<?php echo $PreviousResource; ?>" class="nexttext">&laquo; Previous</a></span>
					<?php
						}
						unset($SelPreviousResourceRS);
					?>
				</div>
				<div class="about2"><span class="fl"><a href="./curriculum.php" class="clrmaroon fl">Curriculums</a><span class="fl">&nbsp;&raquo;&nbsp;</span><span>&nbsp;&raquo;&nbsp;</span><select class="inputseacrh inputseacrh2" id="ddlCurriculum" onchange="javascript: window.location='./category.php?currid=' + this.value;"><option value=''>All</option><?php for($sb = 0; $sb < count($rsCurriculums); $sb++){ if($rsCurriculums[$sb]["unique_id"] == $currid){echo "<option value='" . $rsCurriculums[$sb]["unique_id"] . "' selected='selected'>" . $rsCurriculums[$sb]["curriculum_name"] . "</option>";} else {echo "<option value='" . $rsCurriculums[$sb]["unique_id"] . "'>" . $rsCurriculums[$sb]["curriculum_name"] . "</option>";}} ?></select></span><select class="inputseacrh inputseacrh2" onchange="javascript: window.location='./chapter.php?catgid=' + this.value;"><option value=''>All</option><?php for($sb = 0; $sb < count($rsSubjects); $sb++){ if($rsSubjects[$sb]["unique_id"] == $catgid){echo "<option value='" . $rsSubjects[$sb]["unique_id"] . "' selected='selected'>" . $rsSubjects[$sb]["category_name"] . "</option>";} else {echo "<option value='" . $rsSubjects[$sb]["unique_id"] . "'>" . $rsSubjects[$sb]["category_name"] . "</option>";}} ?></select><span class="mt2px fl">&nbsp;&raquo;&nbsp;</span><select class="inputseacrh inputseacrh2" onchange="javascript: window.location='./topic.php?catgid=<?php echo $catgid; ?>&chptid=' + this.value;"><option value=''>All</option><?php for($ch = 0; $ch < count($rsChapters); $ch++){ if($rsChapters[$ch]["unique_id"] == $chptid){echo "<option value='" . $rsChapters[$ch]["unique_id"] . "' selected='selected'>" . $rsChapters[$ch]["chapter_name"] . "</option>";} else {echo "<option value='" . $rsChapters[$ch]["unique_id"] . "'>" . $rsChapters[$ch]["chapter_name"] . "</option>";}} ?></select><span class="mt2px fl">&nbsp;&raquo;&nbsp;</span><select class="inputseacrh inputseacrh2" onchange="javascript: var d = this.value.split('|'); window.location='./topic.php?chptid=<?php echo $chptid; ?>&rid=' + d[0] + '&catgid=<?php echo $catgid; ?>&topicid=' + d[1];"><option value=''>All</option><?php for($tp = 0; $tp < count($rstopics); $tp++){ if($rstopics[$tp]["unique_id"] == $topicid){echo "<option value='|" . $rstopics[$tp]["unique_id"] ."' selected='selected'>" . $rstopics[$tp]["topic_name"] . "</option>";} else {echo "<option value='|" . $rstopics[$tp]["unique_id"] . "'>" . $rstopics[$tp]["topic_name"] . "</option>";}} ?></select></span><span class="fl">&nbsp;&raquo;&nbsp;Edit Resource&nbsp;&raquo;&nbsp;</span><span class="fl"><select class="inputseacrh inputseacrh2" id="ddlresource" onchange="javascript: window.location='./edit-resource.php?currid=<?php echo $currid; ?>&topicid=<?php echo $topicid; ?>&rid=<?php echo $resid; ?>&catgid=<?php echo $catgid; ?>&chptid=<?php echo $chptid; ?>&cid=' + this.value + '&page=<?php echo $curPage; ?>';"><option value=''>All</option><?php for($sb = 0; $sb < count($RSres); $sb++){ if($RSres[$sb]["unique_id"] == $cid){echo "<option value='" . $RSres[$sb]["unique_id"] . "' selected='selected'>" . $RSres[$sb]["title"] . "</option>";} else {echo "<option value='" . $RSres[$sb]["unique_id"] . "'>" . $RSres[$sb]["title"] . "</option>";}} ?></select></span></div>
				<?php
					$r = $db->query("query","SELECT rd.*,tm.topic_name FROM avn_resources_detail rd INNER JOIN avn_topic_master tm ON rd.topic_id = tm.unique_id WHERE rd.unique_id = " . $_GET['cid']);
					unset($RSres);
					unset($rstopics);
					unset($rsChapters);
					unset($sqlSubjects);
					unset($rsCurriculums);
				?>
				<div id="displayUser" class="fl mt20">
					<form method="post" name="form" enctype='multipart/form-data' id="form" action="./update-resource.php" onsubmit="javascript:return _validateresource();">
						<input type="hidden" name="hdnuid" id="hdnuid" value="<?php echo $_GET['cid']; ?>" />
						<input type="hidden" name="hdntpid" id="hdntpid" value="<?php echo $topicid; ?>" />
						<input type="hidden" name="hdCurrID" id="hdCurrID" value="<?php echo $currid; ?>" />
						<input type="hidden" id="hdIsValidSlug" name="hdIsValidSlug" value="0">
						<input type="hidden" id="hdCurrentSlug" name="hdCurrentSlug" value="<?php echo $r[0]["resource_slug"]; ?>"> 
						<input type="hidden" id="hdSlug" name="hdSlug" value="">
						<!--<input type="hidden" id="hdCurrentdulicacy" name="hdCurrentdulicacy" value="<?php //echo $r[0]["batch_id"];?>">-->
						<input type="hidden" id="hdnqryStringResource" name="hdnqryStringResource" value="<?php echo urlencode(filter_querystring($_SERVER["QUERY_STRING"],array("page","cid","resp"), array($curPage,"",""))); ?>">
						<table cellspacing="4" cellpadding="0" border="0" width="100%">
							<tr>
								<td class="Topictext">
									Resource Title
								</td>
								<td colspan="3">
									<input type="text" name="resourcetitle" id="resourcetitle" class="inputseacrh" style="width: 544px;" value="<?php echo $r[0]['title']; ?>" onblur="javascript: document.getElementById('IFtxtintro').focus(); _createSlug(this.value, 'hdSlug','resource_slug','avn_resources_detail');" />
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
										_showEditor('txtintro', 765, 500, '<?php echo html_entity_decode(nl2br($r[0]['text'])); ?>');
									</script>	
								</td>
							</tr>
							<!--<tr>
								<td class="Topictext">
									Resource Slug
								</td>
								<td><input type="text" name="txtresourceslug" id="txtresourceslug" class="inputseacrh mt10" value="<?php echo $r[0]['resource_slug']; ?>" onblur="javascript:_checkslug('txtresourceslug','resource_slug','avn_resources_detail');"  />
									<div id="imgslug" class="imgslug"></div>
									<div id="msg" class="chkedmsg"></div><div class="clr"></div>
									<div class="duplicacymsg fl">This will be checked for duplicacy.</div>
								</td>
							</tr>-->
							<tr>
								<td class="Topictext">Resource Status</td>
								<td colspan="3">
									<select name="ddlstatus" id="ddlstatus" class="dropdown" style="margin: 10px 0px 0px 0px !important;">
										<option value="1" <?php if ($r[0]['status'] == 1) echo "selected"; ?> >Active</option>
										<option value="0" <?php if ($r[0]['status'] == 0) echo "selected"; ?> >Inactive</option>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<input type="submit" name="btnSave" id="btnSave" class="btnSIgn mt10" value="Update" />
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