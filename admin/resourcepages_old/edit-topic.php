<?php
	error_reporting(0);
	include("./includes/config.php");		
	include("./classes/cor.mysql.class.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open(); 
	include_once("./includes/checkLogin.php");
	$cType = $_COOKIE["cUserType"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title>Avanti &raquo; Dashboard &raquo; Edit-Topic</title>
<?php
	include_once("./includes/head-meta.php");
?>
</head>
<body>
<?php
	$cid = $_GET["cid"];
	//$n = $db->query("stored procedure","sp_admin_resourse_editS('".$_GET["cid"]."')");
	$n = $db->query("query","select * from ltf_resources_master where topic_id = " . $_GET["cid"]);
	$r = $db->query("stored procedure","avn_topic_select_edit('".$_GET["cid"]."')");
?>
<form method=post>
<div id="pageR">
	<div id="pageContainerR">
		<div id="wrapper">	
			<div id="header">
			<?php
				$pgName = "topics";
				include_once("./includes/header.php");
				$gettopic = $db->query("query","SELECT topic_name FROM avn_topic_master WHERE unique_id = " .$_GET['cid']);
			?>
			</div><!-- End of header -->
			<div id="container2">
				<div class="about2"><span class="fl"><a href="./topic.php" class="fl clrmaroon">Topics</a>&nbsp&raquo;&nbsp</span><span class="ft20"><a href="./resourse.php?cid=<?php echo $_GET['cid']; ?>" class="fl clrmaroon"><?php echo $gettopic[0]['topic_name']; ?></a></span>&nbsp;&raquo; Edit Topic</div><!-- End of about -->
				<div id="displayUser" class="fl">
					<table cellspacing="4" cellpadding="0" border="0">
						<form method="post" name="form" id="form" enctype='multipart/form-data' action="update-topic.php" onsubmit="javascript:return _chkdataResourse();">
						<input type="hidden" name="hdtpID" id="hdtpID" value="<?php echo $_GET["cid"]; ?>" />
						<input type="hidden" name="hdChpID" id="hdChpID" value="<?php echo $r[0]['chapter_id']; ?>" />
						<input type="hidden" name="hdresID" id="hdresID" value="<?php echo $n[0]['unique_id']; ?>" />
						<tr>
							<td>
								<div id="errormsg"></div>
							</td>
						</tr>
						<tr>
							<td class="Topictext">
								Subject
							</td>
							<td class="fl">
								<div class="fl mt15">
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
								</div>
							</td>
							<td class="fl">
								<div id="loadchapters"></div>
							</td>
						</tr>
						<tr>
							<td class="Topictext">
								Chapter
							</td>
							<td class="fl">
								<div class="fl mt10">
									<select name="ddlchapter" id="ddlchapter" class="dropdown fl" onchange="javascript:_gettopics(this.value);" style="margin: 0px;">
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
								</div>
							</td>
							<td class="fl">
								<div id="loadchapters"></div>
							</td>
						</tr>
						<tr>
							<td class="Topictext">Topic Title</td>
							<td class="fl">
								<div class="ml0 mt10">
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
								</div>
							</td>
						</tr>
						<tr>
							<td class="Topictext">Topic Code</td>
							<td class="fl mt10">
								<input type="text" name="txttopiccode" id="txttopiccode" readonly= "true" class="inputseacrh fl" value="<?php echo $r[0]["topic_code"]; ?>"  maxlength="10" />
							</td>
						</tr>
						<tr>
							<td class="Topictext">Topic Description</td>
							<td class="fl mt10"><input type="text" class="fl inputseacrh" name="topicdesc" id="topicdesc" value="<?php echo $r[0]["topic_desc"]; ?>" /></td>
						</tr>
						<tr>
							<td class="Topictext">Topic Image<br /> <span style="font-size: 11px;">Please upload jpg, jpeg or png images.</span></td>
							<td class="fl mt10"><input type="file" name="topicimage" id="topicimage" /></td>
							<div id="validateimage" name="validateimage"></div>
						</tr>
						<tr>
							<td>
								<div class="image2">
									<img src="../admin/images/upload-image/<?php echo $r[0]['topic_image']; ?>" width="200px;" />
								</div>
								<input type="hidden" name="hdnimage" id="hdnimage" value="<?php echo $r[0]['topic_image']; ?>" />
							</td>
						</tr>
						<tr>
							<td class="Topictext">
								Introduction
							</td>
						</tr>
						<tr>
							<?php
								$restitle = $db->query("query","select * from ltf_resources_master where topic_id  = " . $_GET['cid']);
							?>
							<td>
								<script type="text/javascript" language="javascript">
									_showEditor('txtintro', 765, 200, '<?php echo html_entity_decode(nl2br($restitle[0]["resource_desc"])); ?>');
								</script>
							</td>
						</tr>
						<tr>
							<td class="Topictext">Tags</td>
						</tr>
						<?php
							$rt = $db->query("stored procedure","sp_admin_Rtag_select('".$n[0]['unique_id']."')");
							//$rt = $db->query("query","select b.tag_name as tag_name from ltf_resources_tags a inner join ltf_tags_master b on a.tags_id = b.unique_id where a.resource_id = " . $n[0]['unique_id'] );
							if(!$rt["response"] == "ERROR"){
						?>
						<tr>
							<td class="fl">
								<input type="text" onkeyup="javascript: _search(this.value)" style="width:614px;"
									value="<?php for($k=0; $k< count($rt); $k++){ if(count($rt) - $k == 1) echo $rt[$k]['tag_name'];  else echo $rt[$k]['tag_name'] . ","; } ?>" name="txttag" 										id="txttag" autocomplete="off" class="inputseacrh" /><br/>
								<div id="hddnsearchtext" style="display:none;"></div>
							</td>
						</tr>
						<?php 
								}
						else{
						?>
						<tr>
							<td class="fl">
								<input type="text" onkeyup="javascript: _search(this.value)" style="width:614px;"name="txttag" id="txttag" autocomplete="off" class="inputseacrh" /><br/>
								<div id="hddnsearchtext" style="display:none;"></div>
							</td>
						</tr>
						<?php
						}
						?>
						<tr>
							<td class="Topictext">Upload File <br /><span style="font-size: 11px;">Please upload zip,pdf,ppt and pptx files.</span></td>
							<td class="fl ml20">
								<input type="file" class="mt20" size="22" name="upload_file" id="upload_file" />
							</td>
						</tr>
						<?php
							$m = $db->query("stored procedure","sp_admin_gradeChkbx_select('".$n[0]['topic_id']."')");
							//$m = $db->query("query","SELECT lrgl.resource_id,lrgl.grade_level_id from ltf_resources_grade_level lrgl INNER JOIN ltf_resources_master rm on rm.unique_id = lrgl.resource_id WHERE rm.topic_id="  . $n[0]['topic_id']);
						?>
						<tr>
							<td style="height:25px;text-align:left; width: 300px;" colspan="2" class="bgf pt10 pb15">
								<fieldset><legend class="ft16">Grade Level</legend>
									<ul class="a" style="margin: 0px;">
										<?php
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
															if($m[$j]['grade_level_id'] == $r[$i]["unique_id"])
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
								</fieldset>
							</td>
						</tr>
						<?php
								$m = $db->query("query","select * from avn_resources_curriculum where resource_id=".$n[0]['unique_id']);
								//change for topic_id
						?>
						<tr>
							<td style="height:25px;text-align:left;" class="bgf pb15 pt10" colspan="2">
								<fieldset><legend class="ft16">Curriculum</legend>
									<ul class="a"style="margin: 0px;">
										<?php
											$r = $db->query("query","select * from avn_curriculum_master");
											if(!array_key_exists("response", $r))
											{
											if(!$r["response"] == "ERROR")
												{
												for($i=0; $i< count($r); $i++)
													{
														$iF = 0;
														for($j=0; $j< count($m); $j++)
														{
															if($m[$j]['curriculum_id'] == $r[$i]["unique_id"])
																$iF = 1;
														}
														if($iF == 0){
										?>
															<li class="fl w120 mt10 ft16">
																<input type="checkbox" name="curriculum[]" value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["curriculum_name"]; ?>
															</li>
										<?php
													}
													else{
										?>
														<li class="fl w120 mt10 ft16">
															<input type="checkbox" name="curriculum[]" checked="checked" value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["curriculum_name"]; ?>
														</li>
										<?php
													}
													}
												}
											}
											unset($r);
										?>
									</ul>
								</fieldset>
							</td >
						</tr>
						<tr>
							<td style="height:25px;text-align:left;" class="bgf pb15 pt10" colspan="2">
								<?php
									$r = $db->query("query","select classwork_hrs,homework_hrs from ltf_resources_master where topic_id = ".$_GET['cid']);
									//change for topic_id
								?>
									<fieldset><legend class="ft16">Time required in Mins.</legend>
										<ul class="a"style="margin-top:10px;">
											<li class="fl mr10">
												<span class="fl ft16">Classwork Time</span>
												<input type="text" name="classwrkTime" id="classwrkTime"  value="<?php echo $r[0]['classwork_hrs']?>" class="inputseacrh ml10 w120" maxlength="4" onkeypress="javascript: return _allowNumeric(event);" />
											</li>
											<li class="fl">
												<span class="fl ft16">Homework Time</span>
												<input type="text" name="homewrkTime" id="homewrkTime" value="<?php echo $r[0]['homework_hrs']?>" class="inputseacrh ml10"  maxlength="4" onkeypress="javascript: return _allowNumeric(event); "/>
											</li>
										</ul>
									</fieldset>
							</td>
						</tr>
						<tr>
							<td colspan="2" class="bgf pb15">
								<table class="new_text">
									<tr>
										<td style="height:25px;text-align:left;" colspan="4"><font size="3px" class="rtd fl">Resource Status</font>&nbsp;&nbsp;&nbsp;&nbsp;						
											<select name="status" id="status" class="dropdown ml10">
												<option value="1" <?php if ($n[0]['ractive'] == 1) echo "selected"; ?> >Active</option>
												<option value="0" <?php if ($n[0]['ractive'] == 0) echo "selected"; ?> >Inactive</option>
											</select>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>
								<div class="fl mt20"><input type="submit" name="btnUpdate" id="btnUpdate" class="btnSIgn" value="Update">
								&nbsp; &nbsp;<a href="./topic.php"><input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn" /></a></div>
							</td>
						</tr>
						</form>
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
</form>
</body>
</html>
