<?php
	error_reporting(0);
	include("./includes/config.php");		
	include("./classes/cor.mysql.class.php");
	include("./includes/checkLogin.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Avanti &raquo; Dashboard &raquo; Add Topic </title>
<?php
	include_once("./includes/head-meta.php");
	
	$currid = 0;
	$chptid = 0;
	$catgid = 0;
	if(isset($_GET["currid"]) && $_GET["currid"] != "" && $_GET["currid"] != "0"){
            $currid = $_GET["currid"];
    }
	if(isset($_GET["catgid"]) && $_GET["catgid"] != "" && $_GET["catgid"] != "0"){
		$catgid = $_GET["catgid"];
		//$where .= $where == "" ? "acm.unique_id = " . mysql_escape_string($catgid) : " AND acm.unique_id = " . mysql_escape_string($catgid);
	}
	if(isset($_GET["chptid"]) && $_GET["chptid"] != "" && $_GET["chptid"] != "0"){
		$chptid = $_GET["chptid"];
		//$where .= $where == "" ? "cm.unique_id = " . mysql_escape_string($chptid) : " AND cm.unique_id = " . mysql_escape_string($chptid);
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
			?>
			</div><!-- End of header -->
			<div id="container2">
				<div class="about2"><span class="mt2px fl"><a href="./curriculum.php" class="clrmaroon fl">Curriculums</a>&nbsp;&raquo;&nbsp;</span><select class="inputseacrh inputseacrh2" id="ddlCurriculum" onchange="javascript: window.location='./category.php?currid=' + this.value;"><option value=''>All</option><?php for($sb = 0; $sb < count($rsCurriculums); $sb++){ if($rsCurriculums[$sb]["unique_id"] == $currid){echo "<option value='" . $rsCurriculums[$sb]["unique_id"] . "' selected='selected'>" . $rsCurriculums[$sb]["curriculum_name"] . "</option>";} else {echo "<option value='" . $rsCurriculums[$sb]["unique_id"] . "'>" . $rsCurriculums[$sb]["curriculum_name"] . "</option>";}} ?></select><span class="mt2px fl">&nbsp;&raquo;&nbsp;</span><select class="inputseacrh inputseacrh2" id="ddlSubject" onchange="javascript: window.location='./chapter.php?currid=<?php echo $currid; ?>&catgid=' + this.value;"><option value=''>All</option><?php for($sb = 0; $sb < count($rsSubjects); $sb++){ if($rsSubjects[$sb]["unique_id"] == $catgid){echo "<option value='" . $rsSubjects[$sb]["unique_id"] . "' selected='selected'>" . $rsSubjects[$sb]["category_name"] . "</option>";} else {echo "<option value='" . $rsSubjects[$sb]["unique_id"] . "'>" . $rsSubjects[$sb]["category_name"] . "</option>";}} ?></select><span class="mt2px fl">&nbsp;&raquo;&nbsp;&nbsp;</span><select class="inputseacrh inputseacrh2" onchange="javascript: window.location='./add-topic.php?currid=<?php echo $currid; ?>&catgid=<?php echo $catgid; ?>&chptid=' + this.value;"><option value=''>All</option><?php for($ch = 0; $ch < count($rsChapters); $ch++){ if($rsChapters[$ch]["unique_id"] == $chptid){echo "<option value='" . $rsChapters[$ch]["unique_id"] . "' selected='selected'>" . $rsChapters[$ch]["chapter_name"] . "</option>";} else {echo "<option value='" . $rsChapters[$ch]["unique_id"] . "'>" . $rsChapters[$ch]["chapter_name"] . "</option>";}} ?></select>&nbsp;&raquo;&nbsp;Add Topic</div><!-- End of about -->
				<div id="displayUser">
					<form method="post" name="form" enctype='multipart/form-data' id="form" action="./save-topic.php" onsubmit="javascript:return _chkdataResourse();">
						<input type="hidden" id="hdnqryStringTopic" name="hdnqryStringTopic" value="<?php echo filter_querystring($_SERVER["QUERY_STRING"]); ?>">
						<input type="hidden" id="hdIsValidSlug" name="hdIsValidSlug" value="0">
						<input type="hidden" id="hdIsSlugAdd" name="hdIsSlugAdd" value="0">
						<input type="hidden" id="hdslug" name="hdslug" value="">
						<input type="hidden" id="hdCurrID" name="hdCurrID" value="<?php echo $currid; ?>">
						<input type="hidden" id="hdIsduplicacyAdd" name="hdIsduplicacyAdd" value="0">
						<table cellspacing="4" cellpadding="5" border="0">
							<tr><td colspan="4"><div id="errormsg"></div></td></tr>
							<tr>
								<td class="Topictext">Subject</td>
								<td>
									<select name="ddlcategory" id="ddlcategory" class="dropdown" onchange="javascript: _showtopic(this.value); ">
										<option value="0">Select Subject</option>
											<?php
											unset($rsCurriculums);
											unset($rsSubjects);
											unset($rsChapters);
											if($currid > 0){
												$r = $db->query("stored procedure","sp_admin_category_by_crid(" . $currid . ")");
												for($j=0;$j<count($r);$j++){
													if($r[$j]["unique_id"] == $catgid){
											?>
														<option value="<?php echo $r[$j]['unique_id']; ?>" selected><?php echo $r[$j]['category_name']; ?></option>
											<?php
													}
													else{
											?>
														<option value="<?php echo $r[$j]['unique_id']; ?>"><?php echo $r[$j]['category_name']; ?></option>
											<?php
														}
												}
												unset($r);
											}
											?>
									</select>
									<!--<div id="loadchapters"></div>-->
								</td>
								<td class="Topictext">Chapter</td>
								<td>
									<?php
										if(isset($_GET["chptid"]) && $_GET["chptid"] != ""){
									?>
											<select name="ddlchapter" id="ddlchapter" class="dropdown" onchange="javascript: _showchapter(this.value);">
												<option value="0">Select Chapter</option>
												<?php
													$chp = $db->query("query","SELECT unique_id,chapter_name,chapter_code FROM avn_chapter_master WHERE category_id = " . $catgid);
													if(!array_key_exists("response", $chp)){
														for($c=0;$c<count($chp);$c++){
															if($chp[$c]["unique_id"] == $chptid){
												?>
																<option value="<?php echo $chp[$c]['unique_id']; ?>" selected><?php echo $chp[$c]['chapter_name']; ?></option>
												<?php
															}else{
												?>
																<option value="<?php echo $chp[$c]['unique_id']; ?>"><?php echo $chp[$c]['chapter_name']; ?></option>
												<?php
															}
														}											
													}
												?> 
											</select>
									<?php
										}else{
									?>
											<select name="ddlchapter" id="ddlchapter" class="dropdown" onchange="javascript: _showchapter(this.value);">
												<option value="0">Select Chapter</option>
											</select>
									<?php
										}
									?>
								</td>
								<td style="width: 40px;">
									<div id="loadchapters"></div>
								</td>
							</tr>
							<tr>
								<td class="Topictext">Topic Title</td>
								<td> 
									<input type="text" name="txttopic" placeholder="Title" id="txttopic" class="inputseacrh fl" onblur="javascript: _createSlug(this.value, 'hdslug','topic_slug','avn_topic_master');" />
								</td>
								<td class="Topictext">Chapter Code</td>
								<td>
									<?php
										$Chp = "SELECT cm.chapter_code FROM avn_chapter_master cm INNER JOIN ltf_category_master lcm ON lcm.unique_id = cm.category_id WHERE cm.unique_id = " . $_GET["chptid"];
											$rsChp = $db->query("query",$Chp);
											if(!array_key_exists("response", $rsChp))
												$maxCount = $rsChp[0]["chapter_code"];
												if(isset($_GET["chptid"]) && $_GET["chptid"] != ""){
									?>
											<input type="text" name="CodeChapter" id="CodeChapter" placeholder="Chapter Code" value="<?php echo $maxCount; ?>" class="inputseacrh">
											<input type="hidden" name="txtchaptercode" id="txtchaptercode"  value="<?php echo $chpcode[0]["chapter_code"]; ?>" />
									<?php
											}else{
									?>
											<input type="text" name="CodeChapter" id="CodeChapter" placeholder="Chapter Code" class="inputseacrh" value="<?php echo $maxCount; ?>">
											<input type="hidden" name="txtchaptercode" id="txtchaptercode"  />
									<?php
											}
									?>
								</td>
							</tr>
							<tr>
								<td colspan="2">&nbsp;</td>
								<!--<td class="Topictext">Topic Slug</td>
								<td><input type="text" name="txttopicslug" id="txttopicslug" placeholder="Slug" class="inputseacrh fl" onblur="javascript: _checkslug('txttopicslug','topic_slug','avn_topic_master');" />
									<div style="float: left;height: 30px;">
										<div id="imgslug" class="imgslug mt5"></div>
										<div id="msg" class="chkedmsg mt5"></div>
										<div class="duplicacymsg fl">This will be checked for duplicacy.</div>
									</div>
								</td>-->
								<td class="Topictext">Topic Code</td>
								<td>
									<?php
										$Chp = "SELECT MAX(tm.unique_id) as maxtopics, cm.chapter_code FROM avn_chapter_master cm INNER JOIN avn_topic_master tm ON cm.unique_id = tm.chapter_id WHERE tm.chapter_id = " . $_GET["chptid"];
											$rsChp = $db->query("query",$Chp);
											if(!array_key_exists("response", $rsChp))
												$chpcode = $rsChp[0]["chapter_code"];
												$maxCount = "$chpcode.".($rsChp[0]["maxtopics"] + 1);
										
										if(isset($_GET["chptid"]) && $_GET["chptid"] != ""){
									?>
											<input type="text" id="CodeTopic" name="CodeTopic" placeholder="Topic Code" class="inputseacrh" value="<?php echo $maxCount; ?>" onblur="javascript:  _checkduplicacy('CodeTopic','topic_code','avn_topic_master');">
											<div style="float: left;height: 27px;width: 270px;">
												<div id="imgchk" class="imgslug mt5"></div>
												<div id="msgchk" class="chkedmsg mt5"></div>
											</div>
											<input type="hidden" name="txttopiccode" id="txttopiccode" value="<?php echo $maxCount; ?>" />
									<?php
										}else{
									?>
											<input type="text" id="CodeTopic" name="CodeTopic" placeholder="Topic Code" class="inputseacrh" value="" onblur="javascript:  _checkduplicacy('CodeTopic','topic_code','avn_topic_master');">
											<input type="hidden" name="txttopiccode" id="txttopiccode"  />
									<?php
										}
									?>
								</td>
							</tr>
							<tr>
								<td colspan="2" class="Topictext">
									Topic image<br /><small>Please upload jpg, jpeg or png images.</small>
								</td>
								<td colspan="2" class="Topictext">
									Upload Final Document &nbsp; <small>(Accessible to Teachers &amp; Managers only) Please upload zip,pdf,ppt and pptx files.</small></td>
							</tr>
							<tr>
								<td colspan="2">
									<input type="file" name="topicimage" id="topicimage" />
									<div id="validateimage" name="validateimage"></div>
								</td> 
								<td colspan="2">
									<input type="file" size="22" name="upload_file" id="upload_file" />
									<div id="validatefile"></div>
								</td>
							</tr>
							<tr>
								<td class="Topictext" colspan="2">Classwork Time <small>(In minutes)</small></td>
								<td class="Topictext" colspan="2">Homework Time <small>(In minutes)</small></td>
							</tr>
							<tr>
								<td colspan="2"><input type="text" name="classwrkTime" id="classwrkTime" placeholder="Classwork Hrs"  class="inputseacrh fl w120" maxlength="4" onkeypress="javascript: return _allowNumeric(event);" /></td>
								<td colspan="2"><input type="text" name="homewrkTime" id="homewrkTime" placeholder="Homework Hrs" class="inputseacrh fl"  maxlength="4" onkeypress="javascript: return _allowNumeric(event); "/></td>
							</tr>
							<tr>
								<td class="Topictext">Grade Levels</td>
								<td colspan="3">
									<ul class="a" style="margin: 0px;padding: 0px;">
										<?php
											$r = $db->query("stored procedure","sp_admin_grade_select()");
											if(!array_key_exists("response", $r))
											{
												if(!$r["response"] == "ERROR")
												{
													for($i=0; $i< count($r); $i++)
													{
										?>
														<li class="fl w80 mt10 ft16">
															<input type="checkbox" name="grade[]" value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["grade_name"]; ?>
														</li>
										<?php
													}
												}
											}
											unset($r);
										?>
									</ul>
								</td>
							</tr>
							<!--<tr>
								<td class="Topictext">Curriculum</td>
								<td colspan="3">
									<ul class="a" style="margin:0px;padding:0px;">
										<?php
											//$r = $db->query("query","select * from avn_curriculum_master");
											//if(!array_key_exists("response", $r))
											//{
											//if(!$r["response"] == "ERROR")
											//	{
											//	for($i=0; $i< count($r); $i++)
											//		{
										?>
														<li class="fl w120 mt10 ft16">
															<input type="checkbox" name="curriculum[]" value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["curriculum_name"]; ?>
														</li>
										<?php
											//		}
											//	}
											//}
											//unset($r);
										?>
									</ul>
								</td>
							</tr>-->
							<tr>
								<td class="Topictext">Tags</td>
								<td colspan="3">
									<input type="text" onkeyup="javascript: _search(this.value)" name="txttag" id="txttag" placeholder="Tag" class="inputseacrh" autocomplete="off" onblur="javascript: document.getElementById('IFtopicdesc').focus();"  /><br/>
									<div id="hddnsearchtext" style="display:none;"></div>
								</td>
								<!--<td class="Topictext">Resource Status</td>
								<td>
									<select name="status" id="status" class="dropdown">
										<option value="1">Active</option>
										<option value="0">Inactive</option>
									</select>
								</td>-->
							</tr>
							<tr>
								<td class="Topictext" colspan="4">
									Topic Introduction
								</td>
							</tr>
							<tr>
								<td colspan="4">
									<script type="text/javascript" language="javascript">
										_showEditor('topicdesc', 765, 200, '');
									</script>
								</td>
							</tr>
							<tr>
								<td colspan="4">
									<div class="fl mt20">
										<input type="submit" name="btnSave" id="btnSave" class="btnSIgn" value="Save">
										<span><a href="./topic.php"><input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn" /></a></span>
									</div>
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
