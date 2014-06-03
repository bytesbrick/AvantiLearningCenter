<?php
	include_once("./includes/checkLogin.php");
	$cType = $_COOKIE["cUserType"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title> Resource &raquo; Light The Fire  &raquo; Dashboard </title>
<?php
	include_once("./includes/head-meta.php");
	error_reporting(0);
	include_once("./includes/config.php");  
	include("./classes/cor.mysql.class.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
?>
<script type="text/javascript" language="javascript" src="./javascript/_resourseData.js"></script>
<script type="text/javascript" language="javascript" src="./javascript/ajax.js"></script>
<script type="text/javascript" language="javascript" src="./javascript/resourseAjax.js"></script>
</head>
<body>
<form method=post>
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
							<td class="rtd">Title&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" style="width:500px;height:30px;" name="txttitle" id="txttitle" class="textbox" /></td >
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<script type="text/javascript" src="javascript/nicEdit.js"></script>
						<script type="text/javascript">
							bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
						</script>
						<tr><td class="rtd" colspan="2">Description</td></tr>
						<tr><td class="fl" colspan="2">
						<textarea type="text" id="txtdescription" name="txtdescription" value="" rows="6" cols="75"></textarea></td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr><td class="rtd">What's to love</td></tr>
						<tr><td class="fl"><textarea type="text" id="txtwhatlove" name="txtwhatlove" rows="6" cols="75"></textarea></td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr><td class="rtd">How to improve it</td></tr>
						<tr><td class="fl"><textarea type="text" id="txtimprove" name="txtimprove" rows="6" cols="75"></textarea></td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr><td class="rtd">Where To Start</td></tr>
						<tr><td class="fl"><textarea type="text" id="txtstart" name="txtstart" rows="6" cols="75"></textarea></td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr><td class="rtd" colspan="2">External  Link</td></tr>
						<tr><td colspan="2" class="fl"><input type="text" style="width:610px;height:30px;" name="txtexternal" id="txtexternal" class="textbox" /></td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr>
							<td class="rtd" colspan="2">Resource Picture&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="file" size="22" style="height:30px;" name="image1" id="image1" /></td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr><td class="rtd">Tags</td></tr>
						<tr><td class="fl">
							<input type="text" onkeyup="javascript: _search(this.value)" style="width:610px;height:30px;" name="txttag" id="txttag" class="textbox" autocomplete="off" /><br/>
							<div id="hddnsearchtext" style="display:none;"></div>
						</td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr>
							<td style="height:25px;text-align:left;" class="bgf pb15 pt10" colspan="2"><font  size="3px" class="b">Subject</font>
								<ul class="a ml-30">
									<?php
										$r = $db->query("stored procedure","sp_admin_category_select()");
										if(!array_key_exists("response", $r))
										{
										if(!$r["response"] == "ERROR")
											{
											for($i=0; $i< count($r); $i++)
												{
									?>
									<li class="fl w120 mt10 ml20">
										<input type="checkbox" name="category[]" value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["category_name"]; ?>
									</li>
									<?php
												}
											}
										}
									?>
								</ul>
							</td >
						</tr>
						<tr style="height:10px;"><td colspan="2"></td></tr>
						<tr>
							<td style="height:25px;text-align:left;" class="bgf pb15 pt10" colspan="2"><font  size="3px" class="b">Best For</font>
								<ul class="a ml-30">
									<?php
										$r = $db->query("stored procedure","sp_admin_consumer_select()");
										if(!array_key_exists("response", $r))
										{
										if(!$r["response"] == "ERROR")
											{
											for($i=0; $i< count($r); $i++)
												{
									?>
									<li class="fl w120 mt10 ml20">
										<input type="checkbox" name="consumer[]" value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["consumer_type_name"]; ?>
									</li>
									<?php
												}
											}
										}
									?>
								</ul>
							</td >
						</tr>
						<tr style="height:10px;"><td colspan="2"></td></tr>
						<tr>
							<td style="height:25px;text-align:left;" class="bgf pb15 pt10" colspan="2"><font  size="3px" class="b">Grade Level</font>
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
									<li class="fl w120 mt10 ml20">
										<input type="checkbox" name="grade[]" value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["grade_name"]; ?>
									</li>
									<?php
												}
											}
										}
									?>
								</ul>
							</td >
						</tr>
						<tr style="height:10px;"><td colspan="2"></td></tr>
						<tr>
							<td style="height:25px;text-align:left;" class="bgf pb15 pt10" colspan="2"><font  size="3px" class="b">Media Type</font>
								<ul class="a ml-30">
									<?php
										$r = $db->query("stored procedure","sp_admin_media_select()");
										if(!array_key_exists("response", $r))
										{
										if(!$r["response"] == "ERROR")
											{
											for($i=0; $i< count($r); $i++)
												{
									?>
									<li class="fl w120 mt10 ml20">
										<input type="checkbox" name="media[]" value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["media_type_name"]; ?>
									</li>
									<?php
												}
											}
										}
									?>
								</ul>
							</td >
						</tr>
						<tr style="height:10px;"><td colspan="2"></td></tr>
						<tr>
							<td style="height:25px;text-align:left;" class="bgf pb15 pt10" colspan="2"><font  size="3px" class="b">Cost</font>
								<ul class="a ml-30">
									<?php
										$r = $db->query("stored procedure","sp_admin_cost_select()");
										if(!array_key_exists("response", $r))
										{
										if(!$r["response"] == "ERROR")
											{
											for($i=0; $i< count($r); $i++)
												{
									?>
									<li class="fl w120 mt10 ml20">
										<input type="checkbox" name="cost[]" value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["cost"]; ?>
									</li>
									<?php
												}
											}
										}
									?>
								</ul>
							</td >
						</tr>
						<tr style="height:10px;"><td colspan="2"></td></tr>
						<tr>
							<td style="height:25px;text-align:left;" class="bgf pb15 pt10" colspan="2"><font  size="3px" class="b">Duration</font>
							<ul class="a ml-30">
									<?php
										$r = $db->query("stored procedure","sp_admin_duration_select()");
										if(!array_key_exists("response", $r))
										{
										if(!$r["response"] == "ERROR")
											{
											for($i=0; $i< count($r); $i++)
												{
									?>
									<li class="fl w120 mt10 ml20">
										<input type="checkbox" name="duration[]" value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["duration_name"]; ?>
									</li>
									<?php
												}
											}
										}
									?>
								</ul>
							</td >
						</tr>
						<tr style="height:10px;"><td colspan="2"></td></tr>
						<tr>
							<td colspan="2" class="bgf pt10 pb15">
								<table class="new_text">
									<tr><td colspan="2" class="fl"><font size="3px" class="b">Standard</font></td></tr>
									<tr>
										<?php
										$r = $db->query("stored procedure","sp_admin_standard_select()");
										if(!array_key_exists("response", $r))
										{
										if(!$r["response"] == "ERROR")
											{
											for($i=0; $i< count($r); $i++)
												{
										?>
													<td style="text-align:right;padding-top:20px;padding-left:35px;padding-right:10px;"><?php echo $r[$i]["standards_desc"]; ?></td>
													<td style="padding-top:20px;">
														<select name="standard[]" id="standard[]" class="dropdown">
															<option value="0" >No</option>
															<option value="<?php echo $r[$i]["unique_id"]; ?>" >Yes</option>
														</select>
													</td>
										<?php
												}
											}
										}
									   ?>
									</tr>									
								</table>
							</td>
						</tr>
						<tr style="height:10px;"><td colspan="2"></td></tr>
						<tr>
							<td colspan="2" class="bgf pb15">
								<table class="new_text">
									<tr><td style="height:25px;text-align:left;" colspan="4"><font size="3px" class="b">Resource Status</font>&nbsp;&nbsp;&nbsp;&nbsp;
										<select name="status" id="status" class="dropdown">
											<option value="1" >Active</option>
											<option value="0" >Inactive</option>
										</select>
										</td>
									</tr>
									<!-- <tr>
										<td style="padding-left:35px;padding-top:20px;">
										<input type='radio' name='status' value='1' /></td>
										<td style="padding-top:20px;">Active</td>
										<td style="padding-left:15px;padding-top:20px;"><input type='radio' name='status' value='0' /></td>
										<td style="padding-top:20px;">Inactive</td>
									</tr> -->
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
