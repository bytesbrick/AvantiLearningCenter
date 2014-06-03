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
?>
<script type="text/javascript" language="javascript" src="./javascript/_resourseData.js"></script>
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
				<div class="about"><a href="resourse.php">Resourse </a>&raquo; Add Resourse</div><!-- End of about -->
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
							
							<td style="height:25px;width:150px;text-align:left;font-size:18px;">Title</td >
							<td class="fl"><input type="text" style="width:368px;height:30px;" name="txttitle" id="txttitle" class="textbox" /></td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr>
							<td style="height:25px;text-align:left;font-size:18px;">Description</td>
							<script type="text/javascript" src="javascript/nicEdit.js"></script>
							<script type="text/javascript">
								bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
							</script>
							<td class="fl"><textarea type="text" id="txtdescription" name="txtdescription" rows="10" style="height:120px;" cols="60" class="textbox"> </textarea></td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr>
							<td style="height:25px;text-align:left;font-size:18px;">What To Love</td >
							<td class="fl"><textarea type="text" id="txtwhatlove" name="txtwhatlove" rows="10" style="height:120px;" cols="60" class="textbox"></textarea></td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr>
							<td style="height:25px;text-align:left;font-size:18px;">How To Improve</td >
							<td class="fl"><textarea type="text" id="txtimprove" name="txtimprove" rows="10" style="height:120px;" cols="60" class="textbox"></textarea></td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr>
							<td style="height:25px;text-align:left;font-size:18px;">Where To Start</td >
							<td class="fl"><textarea type="text" id="txtstart" name="txtstart" rows="10" style="height:120px;" cols="60" class="textbox"></textarea></td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr>
							<td style="height:25px;text-align:left;font-size:18px;">External Link</td >
							<td class="fl"><input type="text" style="width:368px;height:30px;" name="txtexternal" id="txtexternal" class="textbox" /></td>
							</td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr>
							<td style="height:25px;text-align:left;font-size:18px;">Resourse Picture</td >
							<td class="fl"><input type="file" size="22" style="height:30px;" name="image1" id="image1" /></td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr>
							<td style="height:25px;text-align:left;" colspan="2">
							<font size="4px">Topic</font>
								<ul class="a ml-30">
									<?php
										$r = $db->query("stored procedure","sp_admin_topic_select()");
										if(!array_key_exists("response", $r))
										{
										if(!$r["response"] == "ERROR")
											{
											for($i=0; $i< count($r); $i++)
												{
									?>
									<li class="fl mt10 w120">
										<input type="checkbox" name="topic[]" value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["topic_name"]; ?>
									</li>
									<?php
												}
											}
										}
									?>
								</ul>
							</td >
						</tr>
						<!-- <tr>
							<td style="height:25px;text-align:left;" colspan="2">
							<font size="4px">Topic</font>
								<ul class="a ml-30">
									<?php
										$r = $db->query("query","select unique_id,category_name from ltf_category_master");
										if(!array_key_exists("response", $r))
										{
										 if(!$r["response"] == "ERROR")
											{
											for($i=0; $i< count($r); $i++)
												{
												
									?>
									<li>
										<?php echo $r[$i]["category_name"]; ?>
										<ul class="a ml-30">
                                            <?php
												$n = $db->query("query","select a.unique_id,a.topic_name as topic_name,a.category_id from ltf_topic_master a inner join ltf_category_master b on a.category_id = b.unique_id where a.category_id=". $r[$i]["unique_id"]);
												if(!array_key_exists("response", $n))
													{
													if(!$n["response"] == "ERROR")
														{
														for($j=0; $j< count($n); $j++)
															{
											?>
															<li class="w120"><input type="checkbox" name="topic[]" value="<?php echo $n[$j]["unique_id"]; ?>"><?php echo $n[$j]["topic_name"]; ?></li>
										</ul>
									</li>
									<?php
															}
														}
													}
												}
											}
										}
									?>
								</ul>
							</td >
						</tr> -->
						<tr style="height:10px;"><td colspan="2"></td></tr>
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
									?>
									<li class="fl w120 mt10">
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
									?>
									<li class="fl w80 mt10">
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
									?>
									<li class="fl w120 mt10">
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
									?>
									<li class="fl w180 mt10">
										<input type="checkbox" name="standard[]" value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["standards_desc"]; ?>
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
									?>
									<li class="fl w120 mt10">
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
									?>
									<li class="fl w180 mt10">
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
