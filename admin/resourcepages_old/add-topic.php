<?php
	error_reporting(0);
	include_once("./includes/checkLogin.php");
	$cType = $_COOKIE["cUserType"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Avanti &raquo; Dashboard &raquo; Add-Topic </title>
<?php
	include_once("./includes/head-meta.php");
	include_once("./includes/config.php");  
	include("./classes/cor.mysql.class.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
?>
<?php
	include_once("./includes/head-meta.php");
?>
</head>
<body>
<form method=post>
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
				<div class="about2"><a href="./topic.php" class="fl clrmaroon">Topics&nbsp;</a> &raquo; Add Topic</div><!-- End of about -->
				<div id="displayUser">
					<form method="post" name="form" enctype='multipart/form-data' id="form" action="./save-topic.php" onsubmit="javascript:return _chkdataResourse();">
						<table cellspacing="4" cellpadding="0" border="0">
							<tr>
								<td>
									<div id="errormsg"></div>
								</td>
							</tr>
							<tr>
								<td class="Topictext">
									Subject
								</td>
								<td class="fl mt10">
									<div class="fl">
										<select name="ddlcategory" id="ddlcategory" class="dropdown" onchange="javascript: _showtopic(this.value);">
											<option value="0">Select Subject</option>
												<?php
													$r = $db->query("stored procedure","sp_admin_category_select");
													for($j=0;$j<count($r);$j++){
												?>
														<option value="<?php echo $r[$j]['unique_id']; ?>"><?php echo $r[$j]['category_name']; ?></option>
												<?php
													}
												?>
										</select>
									</div>
									<div id="loadchapters"></div>
								</td>
								<!--<td class="fl">
									<div id="loadchapters"></div>
								</td>-->
								<td class="Topictext">
									Chapter
								</td>
								<td class="fl">
									<div class="fl mt10">
										<select name="ddlchapter" id="ddlchapter" class="dropdown" onchange="javascript: _showchapter(this.value);">
											<option value="0">Select Chapter</option>
										</select>
									</div>
									<div id="loadchapters"></div>
								</td>
							</tr>
							<!--<tr>
								<td class="Topictext">
									Chapter
								</td>
								<td class="fl">
									<div class="fl mt10">
										<select name="ddlchapter" id="ddlchapter" class="dropdown" onchange="javascript: _showchapter(this.value);">
											<option value="0">Select Chapter</option>-->
												<?php
												//	   $cid = $_GET["cid"];
												//	   
												//	   if(!array_key_exists("response", $r)){
												//		if(!$r["response"] == "ERROR"){
												//			for($i=0; $i< count($r); $i++){
												//				$k = $db->query("query","select unique_id,chapter_name,category_id from avn_chapter_master where category_id = " . $r[$i]["unique_id"]);
												//				if(!array_key_exists("response", $k)){
												//					 if(!$k["response"] == "ERROR"){
												//?>
															<!--<optgroup label="<?php echo $r[$i]["category_name"]; ?>">-->
												<?php
												//						 for($j=0; $j<count($k); $j++){
												//   ?>
																			<!--<option value="<?php echo $k[$j]["unique_id"]; ?>" ><?php echo $k[$j]["chapter_name"]; ?></option>-->
												   <?php
												//						}
												//?>
															<!--</optgroup>-->
												<?php
												//					}
												//				}
												//				   unset($k);
												//			}
												//		}
												//	}
												//	   unset($r);		
												//   ?>
												
												<?php
													//$k = $db->query("query","select unique_id,chapter_name,category_id from avn_chapter_master where category_id = " . $r[$j]["unique_id"]);
													
												//	if(!array_key_exists("response", $k)){
												//		for($i=0; $i< count($k); $i++){
												//?>
															<!--<option value="<?php echo $k[$i]["unique_id"]; ?>" ></option>-->
												<?php
												//		}
												//	}
												//
												//?>
									<!--	</select>
									</div>
									<div id="loadchapters"></div>
								</td>-->
								<!--<td class="fl">
									<div id="loadchapters"></div>
								</td>-->
							<!--</tr>-->
							<tr>
								<td class="Topictext">
									Chapter Code
								</td>
								<td class="fl mt10">
									<span class="fl" name="CodeChapter" id="CodeChapter" value=""></span>
									<input type="hidden" name="txtchaptercode" id="txtchaptercode"  />
								</td>
							</tr>
							<tr>
								<td class="Topictext">Topic Code</td>
								<td class="fl mt10">
									<span class="fl" name="CodeTopic" id="CodeTopic" value=""></span>
									<input type="hidden" name="txttopiccode" id="txttopiccode"  />
								</td>
							</tr>
							<tr>
								<td class="Topictext">Topic Title</td>
								<td class="fl mt10">
									<input type="text" name="txttopic" id="txttopic" class="inputseacrh fl" />
								</td>
							</tr>
							<tr>
								<td class="Topictext">Topic Description</td>
								<td class=" mt10 fl"><input type="text" name="topicdesc" id="topicdesc" class="inputseacrh fl" /></td>
							</tr> 
							<tr>
								<td class="Topictext">
									Topic image <br /> <span style="font-size: 11px;">Please upload jpg, jpeg or png images.</span>
								</td>
								<td class="fl">
									<input type="file" name="topicimage" id="topicimage" class="mt20" />
									<div id="validateimage" name="validateimage"></div>
								</td>
							</tr>
							<tr style="height:8px;"><td colspan="2"></td></tr>
							<tr>
								<td class="fl ft16 mt10" style="width: 200px; text-align: left;">
									Introduction
								</td>
							</tr>
							<tr>
								<td>
									<script type="text/javascript" language="javascript">
										_showEditor('introduction', 765, 200, '');
									</script>
								</td>
							</tr> 
							<tr>
								<td class="Topictext">Tags</td>
							</tr>
							<tr>
								<td class="fl mt10">
									<input type="text" onkeyup="javascript: _search(this.value)" style="width:610px;" name="txttag" id="txttag" class="inputseacrh" autocomplete="off" /><br/>
									<div id="hddnsearchtext" style="display:none;"></div>
								</td>
							</tr>
							<tr>
								<td class="fl ft16 mt10" style="width: 200px; text-align: left; margin: 20px 0px 0px 0px;">Upload File <br /><span style="font-size: 11px;">Please upload zip,pdf,ppt and pptx files.</span></td>
								<td class="fl">
									<input type="file" class="mt20" size="22" name="upload_file" id="upload_file" />
									<div id="validatefile"></div>
								</td>
							</tr>
							<tr>
								<td style="height:25px;text-align:left;width: 300px;" class="pb15 pt10" colspan="2">
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
									</fieldset>
								</td >
							</tr>
							<tr>
								<td style="height:25px;text-align:left;" class="bgf pb15 pt10" colspan="2">
									<fieldset><legend class="ft16">Curriculum</legend>
										<ul class="a" style="margin:0px;">
											<?php
												$r = $db->query("query","select * from avn_curriculum_master");
												if(!array_key_exists("response", $r))
												{
												if(!$r["response"] == "ERROR")
													{
													for($i=0; $i< count($r); $i++)
														{
											?>
															<li class="fl w120 mt10 ft16">
																<input type="checkbox" name="curriculum[]" value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["curriculum_name"]; ?>
															</li>
											<?php
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
									<fieldset><legend class="ft16">Time required in Mins.</legend>
										<ul class="a" style="margin-top:10px;">
											<li class="fl mr10">
												<span class="fl ft16 mt10 mr10">Classwork Time</span>
												<input type="text" name="classwrkTime" id="classwrkTime"  class="inputseacrh fl w120" maxlength="4" onkeypress="javascript: return _allowNumeric(event);" />
											</li>
											<li class="fl">
												<span class="fl ft16 mr10">Homework Time</span>
												<input type="text" name="homewrkTime" id="homewrkTime"  class="inputseacrh fl"  maxlength="4" onkeypress="javascript: return _allowNumeric(event); "/>
											</li>
										</ul>
									</fieldset>
								</td >
							</tr>
							<tr>
								<td colspan="2" class="bgf pb15">
									<table class="new_text">
										<tr>
											<td style="height:25px;text-align:left;" colspan="4"><font size="3px" class="rtd fl">Resource Status</font>&nbsp;&nbsp;&nbsp;&nbsp;							  	      		  	  <select name="status" id="status" class="dropdown" style="margin: 0px 0px 0px 10px;">
													<option value="1">Active</option>
													<option value="0">Inactive</option>
												</select>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<div class="fl mt20 pb15">
										<input type="submit" name="btnSave" id="btnSave" class="btnSIgn" value="Save">&nbsp; &nbsp;<a href="./topic.php">
										<input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn" /></a>
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
</form>
</body>
</html>
