<?php
	error_reporting(0);
	include_once("./includes/checkLogin.php");
	$cType = $_COOKIE["cUserType"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title> Resource &raquo; Avanti  &raquo; Dashboard </title>
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
				include_once("./includes/header.php");
			?>
			</div><!-- End of header -->
			<div id="container">
				<?php
					include_once("./includes/right-menu.php");
				?>
				<div class="about"><a href="resourse.php">Resource </a>&raquo; Add Resource</div><!-- End of about -->
				<div id="displayUser" class="fl mt20 ml20">
					<form method="post" name="form" enctype='multipart/form-data' id="form" action="./save-resourse.php" onsubmit="return _chkdataResourse()">
					<table cellspacing="4" cellpadding="0" border="0">
						<tr>
							<td colspan="2" style="height:20px;">
								<div id="ErrMsg">
								</div>
							</td>
						</tr>
						<tr class="mt10">
							<td class="rtd">Title&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" style="width:500px;height:30px;" name="txttitle" id="txttitle" class="textbox" />
							</td >
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<script type="text/javascript" src="javascript/nicEdit.js"></script>
						<script type="text/javascript">
							bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
						</script>
						<tr><td class="rtd" colspan="2">Intro</td></tr>
						<tr>
							<td class="fl" colspan="2">
								<textarea type="text" id="txtintro" name="txtintro" value="" rows="6" cols="75" style="width:619px;"></textarea>
							</td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr><td class="rtd">Pre-Reading</td></tr>
						<tr>
							<td class="fl">
								<textarea type="text" id="prereading" name="prereading" value="" rows="6" cols="75" style="width:619px;"></textarea>
								<input type="file" class="mt20" size="22" style="height:30px;" name="image1" id="image1" />
							</td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<!--<tr><td class="rtd">Spot Test</td></tr>-->
						<!--<tr>-->
						<!--	<td>-->
						<!--		<table id="dTab" border="0">-->
						<!--			<tr id="row-1">-->
						<!--			    <td><input type="text" class="textbox" name="txtFlds[]" id="txtFlds-1" value="" style="width:610px;height:30px;" /></td>-->
						<!--			    <td><img id="plus" src="./images/plus.png" onclick="javascript: _addNewField(this.id);" /></td>-->
						<!--			</tr>-->
						<!--		</table>-->
						<!--	</td>-->
						<!--</tr>-->
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr><td class="rtd">Video</td></tr>
						<tr>
							<td class="fl">
								<table id="dVideoTab" border="0">
									<tr id="Videorow-1">
									    <td><input type="text" class="textbox" name="txtVideoFlds[]" id="txtVideoFlds-1" value="" style="width:610px;height:30px;" /></td>
									    <td><img id="videoplus" src="./images/plus.png" onclick="javascript: _addNewVideoField(this.id);" /></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr><td class="rtd">Tags</td></tr>
						<tr><td class="fl">
							<input type="text" onkeyup="javascript: _search(this.value)" style="width:610px;height:30px;" name="txttag" id="txttag" class="textbox" autocomplete="off" /><br/>
							<div id="hddnsearchtext" style="display:none;"></div>
							</td>
							
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr>
							<td class="rtd fl" style="margin: 26px 10px 0px 0px ;">Upload File</td>
							<td class="fl">
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
						<tr style="height:10px;"><td colspan="2"></td></tr>
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
						<tr style="height:10px;"><td colspan="2"></td></tr>
						<tr>
							<td colspan="2" class="bgf pb15">
								<table class="new_text">
									<tr>
										<td style="height:25px;text-align:left;" colspan="4"><font size="3px" class="b">Resource Status</font>&nbsp;&nbsp;&nbsp;&nbsp;							  	      <select name="status" id="status" class="dropdown">
												<option value="1" >Active</option>
												<option value="0" >Inactive</option>
											</select>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<div class="fl ml30 mt20 mb60"><input type="submit" name="btnSave" id="btnSave" class="btnSIgn" value="Save">
					&nbsp; &nbsp;<a href="./resourse.php"><input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn" /></a></div>
					</form>
				</div><!-- end of displayUser -->
			</div><!-- end of container -->
		</div><!-- end of wrapper -->
	</div><!-- end of pagecontainer -->
</div><!-- end of page -->
</form>
</body>
</html>
