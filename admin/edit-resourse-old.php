<?php
	include_once("./includes/checkLogin.php");
	$cType = $_COOKIE["cUserType"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title> Resourse &raquo; Light The Fire  &raquo; Dashboard </title>
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
				<div class="about"><a href="resourse.php">Resourse </a>&raquo;&nbsp;&nbsp;<a href="add-resourse.php">Add Resourse </a>&raquo; Edit Resourse</div><!-- End of about -->
				<div id="displayUser" class="fl mt20 ml20">
					<form method="post" name="form" enctype='multipart/form-data' id="form" action="./update-resourse.php" onsubmit="return check()">
					<table cellspacing="4" cellpadding="0" border="0">
					<input type="hidden" name="hdUidID" id="hdUidID" value="<?php echo $n[0]['unique_id']; ?>" />
						<tr>
							<td style="height:25px;width:150px;text-align:left;font-size:18px;">Title</td >
							<td class="fl"><input style="width:368px;height:30px;" type="text" value="<?php echo $n[0]['resource_title']; ?>" name="txttitle" id="txttitle" class="textbox" /></td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr>
							<td style="height:25px;text-align:left;font-size:18px;">Description</td>
							<script type="text/javascript" src="javascript/nicEdit.js"></script>
							<script type="text/javascript">
								bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
							</script>
							<td class="fl"><textarea type="text" id="txtdescription" name="txtdescription" rows="10" style="height:120px;" cols="60" class="textbox"><?php echo $n[0]['resource_desc']; ?></textarea></td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr>
							<td style="height:25px;text-align:left;font-size:18px;">What To Love</td >
							<td class="fl"><textarea type="text" id="txtwhatlove" name="txtwhatlove" rows="10" style="height:120px;" cols="60" class="textbox"><?php echo $n[0]['what_to_love']; ?></textarea></td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr>
							<td style="height:25px;text-align:left;font-size:18px;">How To Improve</td >
							<td class="fl"><textarea type="text" id="txtimprove" name="txtimprove" rows="10" style="height:120px;" cols="60" class="textbox"><?php echo $n[0]['how_to_improve']; ?></textarea></td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr>
							<td style="height:25px;text-align:left;font-size:18px;">Where To Start</td >
							<td class="fl"><textarea type="text" id="txtstart" name="txtstart" rows="10" style="height:120px;" cols="60" class="textbox"><?php echo $n[0]['where_to_start']; ?></textarea></td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr>
							<td style="height:25px;text-align:left;font-size:18px;">External Link</td >
							<td class="fl"><input style="width:368px;height:30px;" type="text" value="<?php echo $n[0]['external_link']; ?>" name="txtexternal" id="txtexternal" class="textbox" /></td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr>
							<td style="height:25px;text-align:left;font-size:18px;">Resourse Picture</td >
							<td class="fl"><img src="./images/upload-image/<?php echo $n[0]['resource_pic']; ?>" alt ="" border="0" width ="200px" height="200px" /></td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr>
							<td style="height:25px;text-align:left;"></td >
							<td class="fl"><input type="file" size="22" name="image1" id="image1" /></td>
						</tr>
						<tr style="height:10px;"><td colspan="2"></td></tr>
						<?php
							$m = $db->query("stored procedure","sp_admin_topicChkbx_select('".$n[0]['unique_id']."')");
						?>
						<tr>
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
						</tr>
						<tr style="height:10px;"><td colspan="2"></td></tr>
						<?php
							$m = $db->query("stored procedure","sp_admin_consumerChkbx_select('".$n[0]['unique_id']."')");
						?>
						<tr>
							<td style="height:25px;text-align:left;" colspan="2"><font size="4px">Best For</font>
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
												<li class="fl w120 mt10">
													<input type="checkbox" name="consumer[]" value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["consumer_type_name"]; ?>
												</li>
									<?php
									} else {
									?>
												<li class="fl w120 mt10">
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
							<td style="height:25px;text-align:left;" colspan="2"><font size="4px">Grade Level</font>
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
												<li class="fl w80 mt10">
													<input type="checkbox" name="grade[]" value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["grade_name"]; ?>
												</li>
									<?php
									} else {
									?>
												<li class="fl w80 mt10">
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
							<td style="height:25px;text-align:left;" colspan="2"><font size="4px">Media Type</font>
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
									<li class="fl w120 mt10">
										<input type="checkbox" name="media[]" value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["media_type_name"]; ?>
									</li>
									<?php
									}else{
									?>
									<li class="fl w120 mt10">
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
							$m = $db->query("stored procedure","sp_admin_standardChkbx_select('".$n[0]['unique_id']."')");
						?>
						<tr>
							<td style="height:25px;text-align:left;" colspan="2"><font size="4px">Standard</font>
								<ul class="a ml-30">
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
									<li class="fl w180 mt10">
										<input type="checkbox" name="standard[]" value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["standards_desc"]; ?>
									</li>
									<?php
										}else{
									?>
									<li class="fl w180 mt10">
										<input type="checkbox" checked="checked" name="standard[]" value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["standards_desc"]; ?>
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
							<td style="height:25px;text-align:left;" colspan="2"><font size="4px">Cost</font>
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
													<li class="fl w120 mt10">
														<input type="checkbox" name="cost[]" value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["cost"]; ?>
													</li>
													<?php
														}else{
													?>
													<li class="fl w120 mt10">
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
							<td style="height:25px;text-align:left;" colspan="2"><font size="4px">Duration</font>
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
													<li class="fl w180 mt10">
														<input type="checkbox" name="duration[]" value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["duration_name"]; ?>
													</li>
													<?php
														}else{
													?>
													<li class="fl w180 mt10">
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