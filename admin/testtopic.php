<?php
	error_reporting(0);
	include_once("./includes/checkLogin.php");
	$cType = $_COOKIE["cUserType"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title> Avanti  &raquo; Dashboard </title>
<?php
	include_once("./includes/head-meta.php");
?>
<script>
	function validateForm()
	{
		var x=document.forms["form"]["txttopic"].value;
		if (x==null || x=="")
		  {
			  alert("Topic must be filled out");
			  return false;
		  }
	}
</script>
<script type="text/javascript" src="javascript/nicEdit.js"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>
</head>
<body>
<div id="page">
	<div id="pageContainer">
		<div id="wrapper">	
			<div id="header">
			<?php
				include_once("./includes/header.php");
			?>
			</div><!-- End of header -->
			<div id="container">
				<?php
					include_once("./includes/right-menu.php");
				?>
				<div class="about"><a href="topic.php">Topic</a> &raquo; Add Topic</div><!-- End of about -->
				<div id="displayUser" style="margin-top:20px;">
					<table cellspacing="4" cellpadding="0" border="0">
						<form method="post" name="form" id="form" enctype='multipart/form-data' action="save-topic.php" onsubmit="javascript:return validateForm()">
						<input type="hidden" name="hdCatID" id="hdCatID" value="<?php echo $r[0]['unique_id']; ?>" />
						<tr>
							<td class="fl ft16 ml10 mt10" style="width: 200px; text-align: left;">
								Chapter
							</td>
							<td class="fl">
								<div class="fl ml20">
									<select name="ddlchapter" id="ddlchapter" class="dropdown">
										<option value="0">Select chapter</option>
											<?php
											       include("./includes/config.php");		
											       include("./classes/cor.mysql.class.php");
											       $db = new MySqlConnection(CONNSTRING);
												$db->open();
											       $cid = $_GET["cid"];
											       $r = $db->query("stored procedure","sp_admin_category_select");
											       if(!array_key_exists("response", $r)){
													if(!$r["response"] == "ERROR"){
														for($i=0; $i< count($r); $i++){
															$k = $db->query("query","select unique_id,chapter_name,category_id from avn_chapter_master where category_id = " . $r[$i]["unique_id"]);
															
															if(!array_key_exists("response", $k)){
																 if(!$k["response"] == "ERROR"){
											?>
														<optgroup label="<?php echo $r[$i]["category_name"]; ?>">
											<?php
																	 for($j=0; $j<count($k); $j++){
										       ?>
																		<option value="<?php echo $k[$j]["unique_id"]; ?>" ><?php echo $k[$j]["chapter_name"]; ?></option>
										       <?php
																	}
											?>
														</optgroup>
											<?php
																}
															}
														       unset($k);
														}
													}
												}
											       unset($r);		
										       ?>
									</select>
								</div>
							</td>
						</tr>
						<tr>
							<td class="fl ft16 ml10 mt10" style="width: 200px; text-align: left;">Topics</td>
							<td class="fl mt10 ml20">
								<input type="text" name="txttopic" id="txttopic" class="textbox fl" />
							</td>
						</tr>
						<tr>
							<td class="fl ft16 ml10 mt10" style="width: 200px; text-align: left;">Topic Description</td>
							<td class="ml20 mt10 fl"><input type="text" name="topicdesc" id="topicdesc" class="textbox fl" /></td>
						</tr>
						<tr>
							<td class="fl ft16 ml10 mt10" style="width: 200px; text-align: left;">
								Topic image
							</td>
							<td class="fl">
								<input type="file" name="topicimage" id="topicimage" class="ml20 mt20" />
							</td>
						</tr>
						<tr>
							<td class="fl ft16 ml10 mt10" style="width: 200px; text-align: left;">
								Introduction
							</td>
						</tr>
						<tr>
							<td class="fl ml10 mt10">
								<textarea type="text" id="txtintro" name="txtintro" value="" rows="6" cols="75" style="width:619px;"></textarea>
							</td>
						</tr>
						<tr>
							<td class="fl ft16 ml10 mt10" style="width: 200px; text-align: left;">Tags</td>
						</tr>
						<tr>
							<td class="fl ml10 mt10">
								<input type="text" onkeyup="javascript: _search(this.value)" style="width:610px;height:30px;" name="txttag" id="txttag" class="textbox" autocomplete="off" /><br/>
								<div id="hddnsearchtext" style="display:none;"></div>
							</td>
						</tr>
						<tr>
							<td class="fl ft16 ml10 mt10" style="width: 200px; text-align: left; margin: 30px 0px 0px 10px;">Upload File</td>
							<td class="fl ml20">
								<input type="file" class="mt20" size="22" style="height:30px;" name="upload_file" id="upload_file" />
							</td>
						</tr>
						<tr>
							<td style="height:25px;text-align:left;" class="pb15 pt10" colspan="2">
								<fieldset><legend><h3>Choose a subject</h3></legend>
									<div class="ml10">
										<?php
											$r = $db->query("stored procedure","sp_admin_category_select");
										?>
										<select name="ddlcategory" id="ddlcategory" class="dropdown fl" value="<?php echo $r[0]['category_id']?>" onchange="javascript:_showchapter(this.value);">
											<option value="0">Select Subject</option>
												<?php
													$cid = $_GET["cid"];
													
													if(!array_key_exists("response", $r)){
														if(!$r["response"] == "ERROR"){
															for($i=0; $i< count($r); $i++){
												?>			
																<option value="<?php echo $r[$i]["unique_id"]; ?>" ><?php echo $r[$i]["category_name"]; ?></option>
												<?php		
															}
														}
													}
													unset($r);		
												?>
										</select>
									</div>
									<div class="ml0 fl" style="margin: 0px 0px 0px 13px;">
										<select name="ddlchapter" id="ddlchapter" class="dropdown fl" onchange="javascript:_showtopic(this.value);" ">
											<option value="0">select chapter</option>
										</select>
									</div>
									<div class="ml0">
										<select name="ddltopic" id="ddltopic" class="dropdown fl" style="margin: 8px 0px 0px 13px;">
											<option value="0">select topic</option>
										</select>
									</div>
								</fieldset>
							</td >
						</tr>
						<tr>
							<td style="height:25px;text-align:left;width: 300px;" class="pb15 pt10" colspan="2">
								<fieldset><legend><h3>Grade Level</h3></legend>
									<ul class="a ml-30">
										<?php
											$r = $db->query("stored procedure","sp_admin_grade_select()");
											if(!array_key_exists("response", $r))
											{
											if(!$r["response"] == "ERROR")
												{
												for($i=0; $i< count($r); $i++)
													{
										?>
										<li class="fl w80 mt10 ml20">
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
								<fieldset><legend><h3>Curriculum</h3></legend>
									<ul class="a ml-30">
										<?php
											$r = $db->query("query","select * from avn_curriculum_master");
											if(!array_key_exists("response", $r))
											{
											if(!$r["response"] == "ERROR")
												{
												for($i=0; $i< count($r); $i++)
													{
										?>
										<li class="fl w120 mt10 ml20">
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
								<fieldset><legend><h3>Time required</h3></legend>
									<ul class="a ml-30">
										<li class="fl mt10 ml20">
											<span class="fl"><h3 class="mr10">Classwork Time</h3></span>
											<input type="text" name="classwrkTime" id="classwrkTime"  class="textbox fl w120" maxlength="2" onkeypress="javascript: return _allowNumeric(event);" />
										</li>
										<li class="fl mt10 ml20">
											<span class="fl"><h3 class="mr10">Homework Time</h3></span>
											<input type="text" name="homewrkTime" id="homewrkTime"  class="textbox fl"  maxlength="2" onkeypress="javascript: return _allowNumeric(event); "/>
										</li>
									</ul>
								</fieldset>
							</td >
						</tr>
						<tr>
							<td colspan="2" class="bgf pb15">
								<table class="new_text">
									<tr>
										<td style="height:25px;text-align:left;" colspan="4"><font size="3px" class="b">Resource Status</font>&nbsp;&nbsp;&nbsp;&nbsp;							  	      <select name="status" id="status" class="dropdown">
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
								<div class="fl ml30 mt20 pb15">
									<input type="submit" name="btnSave" id="btnSave" class="btnSIgn" value="Save">&nbsp; &nbsp;<a href="./topic.php">
									<input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn" /></a>
								</div>
							</td>
						</tr>
						</form>
					</table>
				</div><!--end of displayUser-->	
			</div><!-- end of container -->
		</div><!-- end of wrapper -->
	</div><!-- end of pagecontainer -->
</div><!-- end of page -->


</body>
</html>
