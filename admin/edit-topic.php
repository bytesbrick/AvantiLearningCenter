<?php
	error_reporting(0);
	include("./includes/config.php");		
	include("./classes/cor.mysql.class.php");
	include("./includes/checkLogin.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
	
	$chptid = 0;
	$catgid = 0;
	$currid = 0;
	if(isset($_GET["currid"]) && $_GET["currid"] != "" && $_GET["currid"] != "0"){
        $currid = $_GET["currid"];
	}
	if(isset($_GET["catgid"]) && $_GET["catgid"] != "" && $_GET["catgid"] != "0"){
		$catgid = $_GET["catgid"];
	}
	if(isset($_GET["chptid"]) && $_GET["chptid"] != "" && $_GET["chptid"] != "0"){
		$chptid = $_GET["chptid"];
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title>Avanti &raquo; Dashboard &raquo; Edit Topic</title>
<?php
	include_once("./includes/head-meta.php");
	$sqlCurriculums = "select unique_id, curriculum_name from avn_curriculum_master acm";
	$rsCurriculums = $db->query("query", $sqlCurriculums);
	
	$sqlSubjects = "select unique_id, category_name from ltf_category_master lcm";
	$rsSubjects = $db->query("query", $sqlSubjects);
	
	if($catgid != 0)
		$sqlChapters = "select unique_id, chapter_name from avn_chapter_master chm WHERE chm.category_id = " . $catgid;
	else
		$sqlChapters = "select unique_id, chapter_name from avn_chapter_master chm";
		$rsChapters = $db->query("query", $sqlChapters);
		
	$sqlTopics = "select unique_id, topic_name from avn_topic_master WHERE chapter_id = " . $chptid;
	$rsTopics = $db->query("query", $sqlTopics);
?>
</head>
<body>
<?php
	$cid = $_GET["cid"];
	$curPage = $_GET["page"];
	$r = $db->query("stored procedure","avn_topic_select_edit('".$_GET["cid"]."')");
	$topicdesc = $r[0]["topic_desc"];
	$topicimage = $r[0]["topic_image"];
	$uploadfile = $r[0]["upload_file"];
	$status = $r[0]["status"];
?>
<div id="pageR">
	<div id="pageContainerR">
		<div id="wrapper">	
			<div id="header">
			<?php
				$pgName = "topics";
				include_once("./includes/header.php");
			?>
			</div><!-- End of header -->
			<div id="container2">
				<?php
					$isNext = false;
					$isPrev = false;
					$SelNextResource = "SELECT tm.unique_id FROM avn_topic_master tm INNER JOIN avn_chapter_master cm ON tm.chapter_id = cm.unique_id WHERE tm.unique_id > " . $_GET["cid"] . " AND tm.chapter_id = " . $_GET["chptid"] . " AND cm.category_id = " . $_GET["catgid"] . "  ORDER BY tm.unique_id ASC";
					$SelNextResourceRS = $db->query("query", $SelNextResource);
					if(!array_key_exists("response", $SelNextResourceRS))
						$nextResource = $SelNextResourceRS[0]["unique_id"];
						$isNext = true;
						if($isNext == true && $nextResource != ""){
				?>
					<span class="fr mr20" style="margin: 10px;"><a href="./edit-topic.php?currid=<?php echo $currid; ?>&chptid=<?php echo $chptid; ?>&catgid=<?php echo $catgid; ?>&cid=<?php echo $nextResource; ?>&page=<?php echo $curPage; ?>" class="nexttext">Next &raquo;</a></span>
				<?php
					}
					unset($SelNextResourceRS);
					$SelPreviousResource = "SELECT tm.unique_id FROM avn_topic_master tm INNER JOIN avn_chapter_master cm ON tm.chapter_id = cm.unique_id WHERE tm.unique_id < " . $_GET["cid"] . " AND tm.chapter_id = " . $_GET["chptid"] . " AND cm.category_id = " . $_GET["catgid"] . " ORDER BY tm.unique_id ASC";
					$SelPreviousResourceRS = $db->query("query", $SelPreviousResource);
					if(!array_key_exists("response", $SelNextResourceRS))
						$PreviousResource = $SelPreviousResourceRS[0]["unique_id"];
						$isPrev = true;
					if($isPrev == true && $PreviousResource != ""){
				?>
					<span class="fl mr20" style="margin: 10px;"><a href="./edit-topic.php?currid=<?php echo $currid; ?>&chptid=<?php echo $chptid; ?>&catgid=<?php echo $catgid; ?>&cid=<?php echo $PreviousResource; ?>&page=<?php echo $curPage; ?>" class="nexttext">&laquo; Previous</a></span>
				<?php
					}
					unset($SelPreviousResourceRS);
				?>
				<div class="about2"><span class="mt2px fl"><a href="./curriculum.php" class="clrmaroon fl">Curriculums</a>&nbsp;&raquo;&nbsp;</span><select class="inputseacrh inputseacrh2" id="ddlCurriculum" onchange="javascript: window.location='./category.php?currid=' + this.value;"><option value=''>All</option><?php for($sb = 0; $sb < count($rsCurriculums); $sb++){ if($rsCurriculums[$sb]["unique_id"] == $currid){echo "<option value='" . $rsCurriculums[$sb]["unique_id"] . "' selected='selected'>" . $rsCurriculums[$sb]["curriculum_name"] . "</option>";} else {echo "<option value='" . $rsCurriculums[$sb]["unique_id"] . "'>" . $rsCurriculums[$sb]["curriculum_name"] . "</option>";}} ?></select><span class="mt2px fl">&nbsp;&raquo;&nbsp;</span><select class="inputseacrh inputseacrh2" id="ddlSubject" onchange="javascript: window.location='./chapter.php?currid=<?php echo $currid; ?>&catgid=' + this.value;"><option value=''>All</option><?php for($sb = 0; $sb < count($rsSubjects); $sb++){ if($rsSubjects[$sb]["unique_id"] == $catgid){echo "<option value='" . $rsSubjects[$sb]["unique_id"] . "' selected='selected'>" . $rsSubjects[$sb]["category_name"] . "</option>";} else {echo "<option value='" . $rsSubjects[$sb]["unique_id"] . "'>" . $rsSubjects[$sb]["category_name"] . "</option>";}} ?></select><span class="mt2px fl">&nbsp;&raquo;&nbsp;&nbsp;</span><select class="inputseacrh inputseacrh2" onchange="javascript: window.location='./topic.php?currid=<?php echo $currid; ?>&catgid=<?php echo $catgid; ?>&chptid=' + this.value;"><option value=''>All</option><?php for($ch = 0; $ch < count($rsChapters); $ch++){ if($rsChapters[$ch]["unique_id"] == $chptid){echo "<option value='" . $rsChapters[$ch]["unique_id"] . "' selected='selected'>" . $rsChapters[$ch]["chapter_name"] . "</option>";} else {echo "<option value='" . $rsChapters[$ch]["unique_id"] . "'>" . $rsChapters[$ch]["chapter_name"] . "</option>";}} ?></select><span class="fl">&nbsp;&raquo;&nbsp;Edit Topic &nbsp;&raquo;&nbsp;</span><span class="mt2px"><select class="inputseacrh inputseacrh2" id="ddltopics" onchange="javascript: window.location='./edit-topic.php?currid=<?php echo $currid; ?>&catgid=<?php echo $catgid; ?>&chptid=<?php echo $chptid; ?>&cid=' + this.value;"><option value=''>All</option><?php for($ch = 0; $ch < count($rsTopics); $ch++){ if($rsTopics[$ch]["unique_id"] == $cid){echo "<option value='" . $rsTopics[$ch]["unique_id"] . "' selected='selected'>" . $rsTopics[$ch]["topic_name"] . "</option>";} else {echo "<option value='" . $rsTopics[$ch]["unique_id"] . "'>" . $rsTopics[$ch]["topic_name"] . "</option>";}} ?></select></span></div><!-- End of about -->
				<div id="displayUser" class="fl">
					<table cellspacing="4" cellpadding="5" border="0" width="100%">
						<form method="post" name="form" id="form" enctype='multipart/form-data' action="./update-topic.php" onsubmit="javascript:return _chkdataResourseEdit();">
						<input type="hidden" name="hdtpID" id="hdtpID" value="<?php echo $_GET["cid"]; ?>" />
						<input type="hidden" name="hdChpID" id="hdChpID" value="<?php echo $r[0]['chapter_id']; ?>" />
						<input type="hidden" name="hdnimage" id="hdnimage" value="<?php echo $r[0]['topic_image']; ?>" />
						<input type="hidden" id="hdIsValidSlug" name="hdIsValidSlug" value="0">
						<input type="hidden" id="hdCurrentSlug" name="hdCurrentSlug" value="<?php echo $r[0]["topic_slug"];?>"> 
						<input type="hidden" id="hdCurrentdulicacy" name="hdCurrentdulicacy" value="<?php echo $r[0]["topic_code"];?>">
						<input type="hidden" name="hdnqryStringTopic" id="hdnqryStringTopic" value="<?php echo filter_querystring($_SERVER["QUERY_STRING"],array("cid","page"), array("",$curPage)); ?>" />
						<tr><td colspan="4"><div id="errormsg"></div></td></tr>
						<tr>
							<td class="Topictext">Subject</td>
							<td>
								<select name="ddlcategory" id="ddlcategory" class="dropdown fl" onchange="javascript: _showtopic(this.value);">
									<?php
										$category  = $db->query("query","SELECT * FROM ltf_category_master");
										$chp = $db->query("query","SELECT cgm.unique_id,cgm.category_name,cm.category_id FROM avn_topic_master tm inner join avn_chapter_master cm on tm.chapter_id = cm.unique_id inner join ltf_category_master cgm on cm.category_id = cgm.unique_id WHERE tm.unique_id = " .$_GET['cid']);
										for($k=0; $k< count($category); $k++){
											if($category[$k]['unique_id'] == $r[0]['category_id']){
									?>
												<option value="<?php echo $category[$k]['unique_id']; ?>" selected><?php echo $category[$k]['category_name']; ?></option>
									<?php			
											}else{
									?>				
												<option value="<?php echo $category[$k]['unique_id']; ?>"><?php echo $category[$k]['category_name']; ?></option>
									<?php
											}
										}
											unset($chp);		
									?>
								</select>
								<!--<div id="loadchapters"></div>-->
							</td>
							<td class="Topictext">Chapter</td>
							<td>
								<select name="ddlchapter" id="ddlchapter" class="dropdown fl" onchange="javascript:_showchapter(this.value);" style="margin: 0px;">
									<?php									
										$chp = $db->query("query","select unique_id,chapter_name,category_id from avn_chapter_master WHERE category_id = " .$r[0]['category_id'] );
										for($k=0; $k< count($chp); $k++){
											if($chp[$k]['unique_id'] == $r[0]['chapter_id']){
									?>
												<option value="<?php echo $chp[$k]['unique_id']; ?>" selected><?php echo $chp[$k]['chapter_name']; ?></option>
									<?php			
											}else{
									?>				
												<option value="<?php echo $chp[$k]['unique_id']; ?>"><?php echo $chp[$k]['chapter_name']; ?></option>
									<?php
											}
										}
											unset($chp);		
									?>
								</select>
							</td>
							<td style="width: 40px;">
								<div id="loadchapters"></div>
							</td>
						</tr>
						<tr>
							<td class="Topictext">Topic Title</td>
							<td>
								<select name="ddltopic" id="ddltopic" class="dropdown fl">
								<?php
									$tp = $db->query("query","select topic_name,unique_id from avn_topic_master where chapter_id =".$r[0]['chapter_id']);
										for($j=0; $j< count($tp); $j++){
											if($tp[$j]['unique_id'] == $r[0]['topic_id']){
								?>
												<option value="<?php echo $tp[$j]['unique_id']; ?>"selected><?php echo $tp[$j]['topic_name']; ?></option>
								<?php
											}else{
								?>
												<option value="<?php echo $tp[$j]['unique_id']; ?>"><?php echo $tp[$j]['topic_name']; ?></option>
								<?php
											}	
										}
								?>
								</select>
							</td>
							<td class="Topictext">
								Chapter Code
							</td>
							<td>
								<!--<span  class="fl ft16" name="CodeChapter" id="CodeChapter"><?php //echo $r[0]["chapter_code"]; ?></span>-->
								<input type ="text" name="CodeChapter" id="CodeChapter" class="inputseacrh" value="<?php echo $r[0]["chapter_code"]; ?>"/>
								<input type="hidden" name="txtchaptercode" id="txtchaptercode"  value="<?php echo $r[0]["chapter_code"]; ?>" />
							</td>
						</tr>
						<tr>
							<td colspan="2"></td>
							<!--<td class="Topictext">Topic Slug</td>
							<td><input type="text" name="txttopicslug" id="txttopicslug" class="inputseacrh" value="<?php echo $r[0]['topic_slug']; ?>" onblur="_checkslug('txttopicslug','topic_slug','avn_topic_master');"/>
								<div style="float: left;height: 30px;">
									<div id="imgslug" class="imgslug mt5"></div>
									<div id="msg" class="chkedmsg mt5"></div>
									<div class="duplicacymsg fl">This will be checked for duplicacy.</div>
								</div>
							</td>-->
							<td class="Topictext">Topic Code</td>
							<td>
								<!--<span class="fl ft16" name="CodeTopic" id="CodeTopic"><?php //echo $r[0]["topic_code"]; ?></span>-->
								<input type="text" name="txttopiccode" id="txttopiccode" class="inputseacrh" value="<?php echo $r[0]["topic_code"]; ?>" onblur="javascript:  _checkduplicacy('txttopiccode','topic_code','avn_topic_master');" />
								<div style="float: left;height: 27px;width: 270px;">
									<div id="imgchk" class="imgslug mt5"></div>
									<div id="msgchk" class="chkedmsg mt5"></div>
								</div>
								<!--<input type="hidden" name="txttopiccode" id="txttopiccode" value="<?php //echo $r[0]["topic_code"]; ?>" />-->
							</td>
						</tr>
						<tr> 
							<td colspan="2" class="Topictext">
								Topic image<br /><small>Please upload jpg, jpeg or png images.</small><span><a href="javascript:void(0);" class= "viewimage" style="padding: 3px 0px 0px 0px;" onclick = "javascript: _disableThisPage();_setDivPos('viewimage');">View image</a></span>
							</td>
							<td colspan="2" class="Topictext">
								Upload Final Document<small> (Accessible to Teachers &amp; Managers only) Please upload zip,pdf,ppt and pptx files.</small>
								<?php
									if(isset($uploadfile) && $uploadfile != "" && $uploadfile != "0"){
								?>
										<span><a href="http://beta.peerlearning.com/admin/images/upload-file/<?php echo $uploadfile ;?>" class="viewimage" target="_blank">Download</a></span>
								<?php
									}
								?>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<input type="file" name="topicimage" id="topicimage" class="mt10" style="width: 250px;" />
								<div id="validateimage" name="validateimage"></div>
							</td>
							<td colspan="2">
								<input type="file" class="mt10" name="upload_file" id="upload_file" style="width: 265px;" />
								<div id="validatefile"></div>
							</td>
						</tr>
						<tr>
							<td class="Topictext" colspan="2">Classwork Time <small>(In minutes)</small></td>
							<td class="Topictext">Homework Time <small>(In minutes)</small></td>
						</tr>
						<tr>
							<td colspan="2"><input type="text" name="classwrkTime" id="classwrkTime" value="<?php echo $r[0]['classwork_hrs']?>" class="inputseacrh fl w120" maxlength="4" onkeypress="javascript: return _allowNumeric(event);" /></td>
							
							<td colspan="2"><input type="text" name="homewrkTime" id="homewrkTime"  class="inputseacrh fl" value="<?php echo $r[0]['homework_hrs']?>"  maxlength="4" onkeypress="javascript: return _allowNumeric(event); "/></td>
						</tr>
						<tr>
							<td class="Topictext">Grade Level</td>
							<td colspan="3">
								<ul class="a" style="margin:0px;padding:0px;">
									<?php
										$m = $db->query("stored procedure","sp_admin_gradeChkbx_select('" . $cid . "')");
										$r = $db->query("stored procedure","sp_admin_grade_select()");
										if(!array_key_exists("response", $r))
										{
											if(!$r["response"] == "ERROR")
											{
												for($i=0; $i< count($r); $i++)
												{
													$iF = 0;
													for($j=0; $j< count($m); $j++)
													{
														if($m[$j]['grade_id'] == $r[$i]["unique_id"])
															$iF = 1;
													}
													if($iF == 0){
									?>
														<li class="fl w80 mt10 ft16">
															<input type="checkbox" name="grade[]" value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["grade_name"]; ?>
														</li>
									<?php
													} else {
									?>
														<li class="fl w80 mt10 ft16">
															<input type="checkbox" name="grade[]" checked="checked"  value="<?php echo $r[$i]["unique_id"]; ?>" ><?php echo $r[$i]["grade_name"]; ?>
														</li>
									<?php
													}
												}
											}
										}
										unset($m);
									?>
								</ul>
							</td>
						</tr>
						<!--<tr>
							<?php
								//$m = $db->query("query","select * from avn_resources_curriculum where resource_id=".$n[0]['unique_id']);
								//change for topic_id
							?>
							<td class="Topictext">Curriculum</td>
							<td colspan="3">
								<ul class="a"style="margin: 0px;padding: 0px;">
									<?php
										//$rc = $db->query("query","select * from avn_curriculum_master");
										//if(!array_key_exists("response", $r))
										//{
										//	if(!$rc["response"] == "ERROR")
										//	{
										//		for($i=0; $i< count($rc); $i++)
										//		{
										//			$iF = 0;
										//			for($j=0; $j< count($m); $j++)
										//			{
										//				if($m[$j]['curriculum_id'] == $rc[$i]["unique_id"])
										//					$iF = 1;
										//			}
										//			if($iF == 0){
									?>
														<li class="fl w120 mt10 ft16">
															<input type="checkbox" name="curriculum[]" value="<?php echo $rc[$i]["unique_id"]; ?>"><?php echo $rc[$i]["curriculum_name"]; ?>
														</li>
									<?php
													//}
													//else{
									?>
														<li class="fl w120 mt10 ft16">
															<input type="checkbox" name="curriculum[]" checked="checked" value="<?php echo $rc[$i]["unique_id"]; ?>"><?php echo $rc[$i]["curriculum_name"]; ?>
														</li>
									<?php
										//			}
										//		}
										//	}
										//}
										//unset($rc);
									?>
								</ul>
							</td >
						</tr>-->
						<tr>
							<td class="Topictext">Tags</td>
						<?php
							$rt = $db->query("stored procedure","sp_admin_Rtag_select('" . $cid . "')");
							if(!$rt["response"] == "ERROR"){
						?>
							<td>
								<input type="text" onkeyup="javascript: _search(this.value)" style="width:310px; margin: 10px 0px 0px 0px;" value="<?php for($k=0; $k< count($rt); $k++){ if(count($rt) - $k == 1) echo $rt[$k]['tag_name'];  else echo $rt[$k]['tag_name'] . ","; } ?>" name="txttag" id="txttag" autocomplete="off" class="inputseacrh" /><br/>
								<div id="hddnsearchtext" style="display:none;"></div>
							</td>
						<?php 
							} else{
						?>
							<td>
								<input type="text" onkeyup="javascript: _search(this.value)" name="txttag" id="txttag" autocomplete="off" class="inputseacrh" /><br/>
								<div id="hddnsearchtext" style="display:none;"></div>
							</td>
						<?php
						}
						?>
							<td class="Topictext">Topic status</td>
							<td>					
								<select name="status" id="status" class="dropdown" onblur="javascript: document.getElementById('IFtopicdesc').focus();">
									<option value="1" <?php if ($status == 1) echo "selected"; ?> >Active</option>
									<option value="0" <?php if ($status == 0) echo "selected"; ?> >Inactive</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="Topictext" colspan="4">Topic Description</td>
						</tr>
						<tr>
							<td colspan="4">
								<script type="text/javascript" language="javascript">
									_showEditor('topicdesc', 765, 200, '<?php echo html_entity_decode(nl2br($topicdesc)); ?>');
								</script>
							</td>
						</tr>
						<tr>
							<td colspan="4">
								<div class="fl mt20"><input type="submit" name="btnUpdate" id="btnUpdate" class="btnSIgn" value="Update">
								&nbsp; &nbsp;<a href="./topic.php"><input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn" /></a></div>
							</td>
						</tr>
					</table>
					</form>
					<div id="viewimage"><!--For topic image pop-up-->
						<a id="viewimageClose" onclick="javascript: _hideFloatingObjectWithID('viewimage');_enableThisPage();">x</a>
						<span><img src="../admin/images/upload-image/<?php echo $topicimage; ?>"></span>
					</div>
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
