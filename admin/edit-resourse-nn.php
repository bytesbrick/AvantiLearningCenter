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
	if(isset($_GET["cid"]))
	{
		$n = $db->query("stored procedure","sp_admin_resourse_editS('".$_GET["cid"]."')");
		if(!array_key_exists("response", $r)){
?>
<script type="text/javascript" language="javascript" src="./javascript/_resourseData.js"></script>
<script type="text/javascript" language="javascript" src="./javascript/ajax.js"></script>
<script type="text/javascript" language="javascript" src="./javascript/resourseAjax.js"></script>
<script type="text/javascript" src="javascript/nicEdit.js"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>
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
				<div class="about"><a href="resourse.php">Resource </a>&raquo;&nbsp;&nbsp;<a href="add-resourse.php">Add Resource </a>&raquo; Edit Resource</div><!-- End of about -->
				<div id="displayUser" class="fl mt20 ml20">
					<form method="post" name="form" enctype='multipart/form-data' id="form" action="./update-resourse.php" onsubmit="return _chkdataResourse()">
					<table cellspacing="4" cellpadding="1" border="0">
					<input type="hidden" name="hdUidID" id="hdUidID" value="<?php echo $n[0]['unique_id']; ?>" />
						<tr>
							<td class="rtd" colspan="2">Title&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input style="width:500px;height:30px;" type="text" value="<?php echo $n[0]['resource_title']; ?>" name="txttitle" id="txttitle" class="textbox" /></td>
							
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr><td class="rtd" colspan="2">Description</td></tr>
						<tr>
							<td class="fl" colspan="2"><textarea type="text" id="txtdescription" name="txtdescription" rows="10" style="height:120px;" cols="60" class="textbox" ><?php echo $n[0]['resource_desc']; ?></textarea></td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr><td class="rtd" colspan="2">What's to love</td></tr>
						<tr><td class="fl"><textarea type="text" id="txtwhatlove" name="txtwhatlove" rows="10" style="height:120px;" cols="60" class="textbox"> <?php echo $n[0]['what_to_love']; ?> </textarea></td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr><td class="rtd" colspan="2">How to improve it</td></tr>
						<tr><td class="fl" colspan="2"><textarea type="text" id="txtimprove" name="txtimprove" rows="10" style="height:120px;" cols="60" class="textbox"> <?php echo $n[0]['how_to_improve']; ?> </textarea></td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr><td class="rtd" colspan="2">Where To Start</td></tr>
						<tr><td class="fl" colspan="2"><textarea type="text" id="txtstart" name="txtstart" rows="10" style="height:120px;" cols="60" class="textbox"> <?php echo $n[0]['where_to_start']; ?> </textarea></td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr>
							<td class="rtd" colspan="2">External Link</td></tr>
							<tr><td class="fl"><input style="width:610px;height:30px;" type="text" value="<?php echo $n[0]['external_link']; ?>" name="txtexternal" id="txtexternal" class="textbox" /></td>
							
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr><td class="rtd" colspan="2">Resource Picture</td></tr>
						<tr>
							<td align="left" colspan="2">
								<img src="./images/upload-image/<?php echo $n[0]['resource_pic']; ?>" alt ="" border="0" width ="400px" height="300px" />
							</td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr>
							<td class="fl" colspan="2"><input type="file" size="22" name="image1" id="image1" /></td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr><td class="rtd" colspan="2">Tags</td></tr>
						<?php
							$rt = $db->query("stored procedure","sp_admin_Rtag_select('".$n[0]['unique_id']."')");
							if(!array_key_exists("response", $rt)){
								if(!$rt["response"] == "ERROR"){
						?>
						<tr><td class="fl">
								<input type="text" onkeyup="javascript: _search(this.value)" style="width:610px;height:30px;"
								value="<?php for($k=0; $k< count($rt); $k++){ if(count($rt) - $k == 1) echo $rt[$k]['tag_name'];  else echo $rt[$k]['tag_name'] . ","; } ?>" name="txttag" id="txttag" autocomplete="off" class="textbox" /><br/>
								<div id="hddnsearchtext" style="display:none;"></div>
						</td></tr>
						<?php 
							}
						}
						else
						{
						?>
						<tr><td class="fl">
								<input type="text" onkeyup="javascript: _search(this.value)" style="width:610px;height:30px;"name="txttag" id="txttag" autocomplete="off" class="textbox" /><br/>
								<div id="hddnsearchtext" style="display:none;"></div>
						</td></tr>
						<?php
						}
						?>
						<tr style="height:10px;"><td colspan="2"></td></tr>
						<?php
							$m = $db->query("stored procedure","sp_admin_topicChkbx_select('".$n[0]['unique_id']."')");
						?>
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
												$iF = 0;
													for($j=0; $j< count($m); $j++)
													{
														if($m[$j]['category_id'] == $r[$i]["unique_id"])
															$iF = 1;
													}
													if($iF == 0){
									?>
									<li class="fl w120 mt10 ml20">
										<input type="checkbox" name="category[]" value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["category_name"]; ?>
									</li>
									<?php
										} else {
									?>
									<li class="fl w120 mt10 ml20">
										<input type="checkbox" checked="checked" name="category[]" value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["category_name"]; ?>
									</li>
									<?php
													}
												} 
											}
										}
									?>
								</ul>
							</td >
						</tr>
						<!-- <tr>
							<td style="height:25px;text-align:left;" colspan="2"><font size="4px">Topic</font>
								<ul class="a ml-30">
									<?php
										$r = $db->query("stored procedure","sp_admin_topic_select()");
										if(!array_key_exists("response", $r))
										{
											if(!$r["response"] == "ERROR")
											{
												for($i=0; $i< count($r); $i++)
												{
													$iF = 0;
													for($j=0; $j< count($m); $j++)
													{
														if($m[$j]['topic_id'] == $r[$i]["unique_id"])
															$iF = 1;
													}
													if($iF == 0){
									?>
									
													<li class="fl w120 mt10">
														<input type="checkbox" name="topic[]"  value="<?php echo $r[$i]["unique_id"]; ?>" ><?php echo $r[$i]["topic_name"]; ?>
													</li>
									
									<?php
													} else {
									?>
													<li class="fl w120 mt10">
														<input type="checkbox" name="topic[]" checked="checked"  value="<?php echo $r[$i]["unique_id"]; ?>" ><?php echo $r[$i]["topic_name"]; ?>
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
						</tr> -->
						<tr style="height:10px;"><td colspan="2"></td></tr>
						<?php
							$m = $db->query("stored procedure","sp_admin_consumerChkbx_select('".$n[0]['unique_id']."')");
						?>
						<tr>
							<td style="height:25px;text-align:left;" colspan="2" class="bgf pt10 pb15"><font size="3px" class="b">Best For</font>
								<ul class="a ml-30">
									<?php
										$r = $db->query("stored procedure","sp_admin_consumer_select()");
										if(!array_key_exists("response", $r))
										{
										if(!$r["response"] == "ERROR")
											{
											for($i=0; $i< count($r); $i++)
												{
												$iF = 0;
													for($j=0; $j< count($m); $j++)
													{
														if($m[$j]['consumer_type_id'] == $r[$i]["unique_id"])
															$iF = 1;
													}
													if($iF == 0){
									?>
												<li class="fl w120 mt10 ml20">
													<input type="checkbox" name="consumer[]" value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["consumer_type_name"]; ?>
												</li>
									<?php
									} else {
									?>
												<li class="fl w120 mt10 ml20">
													<input type="checkbox" name="consumer[]" checked="checked"  value="<?php echo $r[$i]["unique_id"]; ?>" ><?php echo $r[$i]["consumer_type_name"]; ?>
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
						<tr style="height:10px;"><td colspan="2"></td></tr>
						<?php
							$m = $db->query("stored procedure","sp_admin_gradeChkbx_select('".$n[0]['unique_id']."')");
						?>
						<tr>
							<td style="height:25px;text-align:left;" colspan="2" class="bgf pt10 pb15"><font size="3px" class="b">Grade Level</font>
								<ul class="a ml-30">
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
												<li class="fl w80 mt10 ml20">
													<input type="checkbox" name="grade[]" value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["grade_name"]; ?>
												</li>
									<?php
									} else {
									?>
												<li class="fl w80 mt10 ml20">
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
						<tr style="height:10px;"><td colspan="2"></td></tr>
						<?php
							$m = $db->query("stored procedure","sp_admin_mediaChkbx_select('".$n[0]['unique_id']."')");
						?>
						<tr>
							<td style="height:25px;text-align:left;" colspan="2" class="bgf pt10 pb15"><font size="3px" class="b">Media Type</font>
								<ul class="a ml-30">
									<?php
										$r = $db->query("stored procedure","sp_admin_media_select()");
										if(!array_key_exists("response", $r))
										{
										if(!$r["response"] == "ERROR")
											{
											for($i=0; $i< count($r); $i++)
												{
													$iF = 0;
													for($j=0; $j< count($m); $j++)
													{
														if($m[$j]['media_type_id'] == $r[$i]["unique_id"])
															$iF = 1;
													}
													if($iF == 0){

									?>
									<li class="fl w120 mt10 ml20">
										<input type="checkbox" name="media[]" value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["media_type_name"]; ?>
									</li>
									<?php
									}else{
									?>
									<li class="fl w120 mt10 ml20">
										<input type="checkbox" checked="checked" name="media[]" value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["media_type_name"]; ?>
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
						<tr style="height:10px;"><td colspan="2"></td></tr>
						<?php
							$m = $db->query("stored procedure","sp_admin_costChkbx_select('".$n[0]['unique_id']."')");
						?>
						<tr>
							<td style="height:25px;text-align:left;" colspan="2" class="bgf pt10 pb15"><font size="3px" class="b">Cost</font>
								<ul class="a ml-30">
									<?php
										$r = $db->query("stored procedure","sp_admin_cost_select()");
										if(!array_key_exists("response", $r))
										{
										if(!$r["response"] == "ERROR")
											{
											for($i=0; $i< count($r); $i++)
												{
													$iF = 0;
													for($j=0; $j< count($m); $j++)
													{
														if($m[$j]['cost_id'] == $r[$i]["unique_id"])
															$iF = 1;
													}
													if($iF == 0){
									?>
													<li class="fl w120 mt10 ml20">
														<input type="checkbox" name="cost[]" value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["cost"]; ?>
													</li>
													<?php
														}else{
													?>
													<li class="fl w120 mt10 ml20">
														<input type="checkbox" checked="checked" name="cost[]" value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["cost"]; ?>
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
						<tr style="height:10px;"><td colspan="2"></td></tr>
						<?php
							$m = $db->query("stored procedure","sp_admin_durationChkbx_select('".$n[0]['unique_id']."')");
						?>
						<tr>
							<td style="height:25px;text-align:left;" colspan="2" class="bgf pt10 pb15"><font size="3px" class="b">Duration</font>
								<ul class="a ml-30">
									<?php
										$r = $db->query("stored procedure","sp_admin_duration_select()");
										if(!array_key_exists("response", $r))
										{
										if(!$r["response"] == "ERROR")
											{
											for($i=0; $i< count($r); $i++)
												{
													$iF = 0;
													for($j=0; $j< count($m); $j++)
													{
														if($m[$j]['duration_id'] == $r[$i]["unique_id"])
															$iF = 1;
													}
													if($iF == 0){
									?>
													<li class="fl w180 mt10 ml20">
														<input type="checkbox" name="duration[]" value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["duration_name"]; ?>
													</li>
													<?php
														}else{
													?>
													<li class="fl w180 mt10 ml20">
														<input type="checkbox" checked="checked" name="duration[]" value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["duration_name"]; ?>
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
						<tr style="height:10px;"><td colspan="2"></td></tr>
						<?php
							$m = $db->query("stored procedure","sp_admin_standardChkbx_select('".$n[0]['unique_id']."')");
						?>
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
												$iF = 0;
												for($j=0; $j< count($m); $j++)
													{
														if($m[$j]['standards_id'] == $r[$i]["unique_id"])
															$iF = 1;
													}
													if($iF == 0){
										?>
										<td style="text-align:left;padding-top:20px;padding-left:35px;"><?php echo $r[$i]["standards_desc"]; ?></td>
										<td style="padding-top:20px;">
											<select name="standard[]" id="standard[]" class="dropdown">
												<option value="0">No</option>
												<option value="<?php echo $r[$i]["unique_id"]; ?>"> Yes</option>
											</select>
										</td>
										<?php
											}else{
										?>
										<td style="text-align:left;padding-top:20px;padding-left:35px;"><?php echo $r[$i]["standards_desc"]; ?></td>
										<td style="padding-top:20px;">
											<select name="standard[]" id="standard[]" class="dropdown">
												<option value="0">No</option>
												<option value="<?php echo $r[$i]["unique_id"]; ?>" selected>
												Yes</option>
											</select>
										</td>
										<?php
													}
												}
											}
										}
										unset($m);
									?>
									</tr>
								</table>
							</td>
						</tr>
						<tr style="height:10px;"><td colspan="2"></td></tr>
						<tr>
							<td colspan="2" class="bgf pt10 pb15">
								<table class="new_text">
									<tr><td style="height:25px;text-align:left;" colspan="4"><font size="3px" class="b">Resource Status</font>&nbsp;&nbsp;&nbsp;&nbsp;
										<select name="status" id="status" class="dropdown">
											<option value="1" <?php if ($n[0]['ractive'] == 1) echo "selected"; ?> >Active</option>
											<option value="0" <?php if ($n[0]['ractive'] == 0) echo "selected"; ?> >Inactive</option>
										</select></td></tr>
									<!-- <tr>
										<td style="padding-left:35px;padding-top:20px;">
										<input type='radio' name='status' value='1' <?php if ($n[0]['ractive'] == 1) echo "checked"; ?> /></td>
										<td style="padding-top:20px;">Active</td>
										<td style="padding-top:20px;"><input type='radio' name='status' value='0' <?php if ($n[0]['ractive'] == 0) echo "checked"; ?> /></td>
										<td style="padding-top:20px;">Inactive</td>
									</tr> -->
								</table>
							</td>
						</tr>
					</table>
					<?php
		}
	}
					?>
					<div class="fl ml30 mt20 mb60"><input type="submit" name="btnUpdate" id="btnUpdate" class="btnSIgn" value="Update">
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