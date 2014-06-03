<?php
	include_once("./includes/checkLogin.php");
	if(isset($_COOKIE["cUserType"]))
		$cType = $_COOKIE["cUserType"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title> Avanti &raquo;Dashboard &raquo;Resource  </title>
<?php
	include_once("./includes/head-meta.php");
	
	include_once("./includes/config.php");  
	include("./classes/cor.mysql.class.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
	if(isset($_GET["cid"]))
	{
		$n = $db->query("stored procedure","sp_admin_resourse_editS('".$_GET["cid"]."')");
		//change for topic_id
		if(!array_key_exists("response", $r)){
		//$topic = $db->query("query","select topic_id FROM ltf_resources_topic where resource_id=".$_GET["cid"]);			
?>
<?php
	include_once("./includes/head-meta.php");
?>
<script type="text/javascript">
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>
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
			</div>
			<div id="container">
				<?php
					include_once("./includes/right-menu.php");
				?>
				<div class="about"><a href="resourse.php">Resource </a>&raquo; Edit Resource</div><!-- End of about -->
				<div id="displayUser" class="fl mt20 ml20">
					<form method="post" name="form" enctype='multipart/form-data' id="form" action="./update-resourse.php" onsubmit="return _chkdataResourseEdit()">
					<table cellspacing="4" cellpadding="1" border="0">
					<input type="hidden" name="hdUidID" id="hdUidID" value="<?php echo $n[0]['unique_id']; ?>" />
						<tr>
							<td class="rtd" colspan="2">Title&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input style="width:500px;height:30px;" type="text" value="<?php echo $n[0]['resource_title']; ?>" name="txttitle" id="txttitle" class="textbox" />
							</td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr><td class="rtd" colspan="2">Intro</td></tr>
						<tr><td class="fl" colspan="2">
						<textarea type="text" id="txtintro" name="txtintro" value="" rows="6" cols="75" style="width:619px;"><?php echo $n[0]['resource_desc']; ?></textarea></td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr><td class="rtd" colspan="2">Pre-reading</td></tr>
						<tr>
							<td class="fl">
								<textarea type="text" id="prereading" name="prereading" rows="6" cols="75" style="width:619px;"> <?php echo $n[0]['what_to_love']; ?> </textarea>
								<div id="validateimage"></div>
								<input type="file" id="image1" name="image1" class="mt10 fl" size="22" style="height:30px;" value="<?php echo $n[0]['resource_pic']; ?>" />
								
								<input type="hidden" name="hdnimage" id="hdnimage" value="<?php echo $n[0]['resource_pic']; ?>">
								<div class="image">
									<img src="../admin/images/upload-image/<?php echo $n[0]['resource_pic']; ?>"  />
								</div>
							</td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr><td class="rtd" colspan="2">Video</td></tr>
						<tr>
							<td class="fl">
								<table id="dVideoTab" cellspacing="0" cellpadding="4" border="0" width="400px">
									<?php
										$q= $db->query("stored procedure","sp_avn_video_select_edit('".$_GET["cid"]."')");
										if(!isset($q['response']) && $q['response'] != "ERROR"){
									?>
									<script type="text/javascript">
										arrVRows = null;
										arrVRows = new Array();
									</script>	
									<?php
											for($i=0;$i<count($q);$i++){
									?>
									<tr id="row-<?php echo $i; ?>">
										<td>
											<?php
												$vid = $q[$i]['video_url'];  
											?>
											<input type="text" class="txtwdh" name="txtVideoFlds[]" id="txtVideoFlds-<?php echo $i; ?>" class="txtbox" value="<?php echo htmlspecialchars($vid); ?>" />
										</td>										
										<td>
											<img id="minus-<?php echo $i; ?>" src="./images/minus.png" alt="MINUS" onclick="javascript: _removeVideoField(<?php echo $i; ?>);" />
										</td>
									</tr>
									<script type="text/javascript">
										arrVRows.push(<?php echo $i; ?>);
									</script>
									<?php
											}
									?>
									<script type="text/javascript">
										arrVRows.push(<?php echo $i; ?>);
										var rVID = <?php echo $i; ?>;
									</script>
									<?php	
										}
									?>
									<tr id="row-<?php if(isset($q['response']) && $q['error'] == 'No data found') echo "0"; else echo count($q); ?>">
										<td><input type="text" class="txtwdh" name="txtVideoFlds[]" id="txtVideoFlds-<?php if(isset($q['response']) && $q['error'] == 'No data found') echo "0"; else echo count($q); ?>" value="" class="txtbox"/></td>										
										<td><img id="videoplus" src="./images/plus.png" alt="PLUS" onclick="javascript: _addNewVideoField(this.id);" /></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr style="height:8px;"><td colspan="2"></td></tr>
						<tr><td class="rtd" colspan="2">Tags</td></tr>
						<?php
							$rt = $db->query("stored procedure","sp_admin_Rtag_select('".$n[0]['unique_id']."')");
							//change for topic_id
							if(!$rt["response"] == "ERROR"){
						?>
						<tr>
							<td class="fl">
								<input type="text" onkeyup="javascript: _search(this.value)" style="width:610px;height:30px;"
								value="<?php for($k=0; $k< count($rt); $k++){ if(count($rt) - $k == 1) echo $rt[$k]['tag_name'];  else echo $rt[$k]['tag_name'] . ","; } ?>" name="txttag" id="txttag" autocomplete="off" class="textbox" /><br/>
								<div id="hddnsearchtext" style="display:none;"></div>
							</td>
						</tr>
						<?php 
								}
						else{
						?>
						<tr>
							<td class="fl">
								<input type="text" onkeyup="javascript: _search(this.value)" style="width:610px;height:30px;"name="txttag" id="txttag" autocomplete="off" class="textbox" /><br/>
								<div id="hddnsearchtext" style="display:none;"></div>
							</td>
						</tr>
						<?php
						}
						?>
						<tr style="height:10px;"><td colspan="2"></td></tr>
						<tr>
							<td class="rtd fl" style="margin: 26px 10px 0px 0px ;">Upload File</td>
							<td class="fl">
								<input type="file" class="mt20" size="22" style="height:30px;" name="upload_file" id="upload_file" />
							</td>
						</tr>
						<?php
							$m = $db->query("stored procedure","res_tp_select(". $_GET['cid'] .")");
						?>
						<tr>
							<td style="height:25px;text-align:left;" class="pb15 pt10" colspan="2">
								<fieldset><legend><h3>Choose a subject</h3></legend>
									<div class="ml10">
										<select name="ddlcategory" id="ddlcategory" class="dropdown fl" value="<?php echo $r[0]['category_id']?>" onchange="javascript: _showchapter(this.value);">
											<?php
												$r = $db->query("stored procedure","sp_admin_category_select");
												if(!array_key_exists("response", $r)){
													if(!$r["response"] == "ERROR"){
														for($i=0; $i< count($r); $i++){
															if($r[$i]['unique_id'] == $n[0]['category_id']){
											?>			
															<option value="<?php echo $r[$i]["unique_id"]; ?>" selected><?php echo $r[$i]["category_name"]; ?></option>
											<?php
															}else{
																?>
															<option value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["category_name"]; ?></option>	
																<?php
															}
														}
													}
												}unset($r);
											?>					
										</select>
									</div>
									<div class="ml0 fl" style="margin: 0px 0px 0px 13px;">
										<select name="ddlchapter" id="ddlchapter" class="dropdown fl" onchange="javascript:_showtopic(this.value);">
											<?php
											$chp = $db->query("query","select unique_id,chapter_name from avn_chapter_master where category_id = ". $n[0]['category_id']);
												for($k=0; $k< count($chp); $k++){
													if($chp[$k]['unique_id'] == $n[0]['chapter_id']){
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
									<div class="ml0">
										<select name="ddltopic" id="ddltopic" class="dropdown fl"  style="margin: 8px 0px 0px 13px;">
										<?php
											$tp = $db->query("query","select topic_name,unique_id from avn_topic_master where chapter_id =".$n[0]['chapter_id']);
											print_r($tp);
											if(!isset($tp['response'])){
												for($j=0; $j< count($tp); $j++){
													if($tp[$j]['unique_id'] == $n[0]['topic_id']){
										?>
										
														<option value="<?php echo $tp[$j]['unique_id']; ?>" selected><?php echo $tp[$j]['topic_name']; ?></option>
											<?php
													}else{
											?>
														<option value="<?php echo $tp[$j]['unique_id']; ?>"><?php echo $tp[$j]['topic_name']; ?></option>
											<?php
													}
														
												}
											}
											?>
										</select>
									</div>
									
								</fieldset>
							</td >
						</tr>
						<tr style="height:10px;"><td colspan="2"></td></tr>
						<?php
							$m = $db->query("stored procedure","sp_admin_gradeChkbx_select('".$n[0]['unique_id']."')");
							//change for topic_id
						?>
						<tr>
							<td style="height:25px;text-align:left; width: 300px;" colspan="2" class="bgf pt10 pb15">
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
								</fieldset>
							</td>
						</tr>
						<?php
							$m = $db->query("query","select * from avn_resources_curriculum where resource_id=".$n[0]['unique_id']);
							//change for topic_id
						?>
						<tr>
							<td style="height:25px;text-align:left;" class="pb15 pt10" colspan="2">
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
														$iF = 0;
														for($j=0; $j< count($m); $j++)
														{
															if($m[$j]['curriculum_id'] == $r[$i]["unique_id"])
																$iF = 1;
														}
														if($iF == 0){
										?>
															<li class="fl w120 mt10 ml20">
																<input type="checkbox" name="curriculum[]" value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["curriculum_name"]; ?>
															</li>
										<?php
													}
													else{
										?>
														<li class="fl w120 mt10 ml20">
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
						<tr style="height:10px;"><td colspan="2"></td></tr>
						<td style="height:25px;text-align:left;" class="bgf pb15 pt10" colspan="2">
							<?php
								$r = $db->query("query","select classwork_hrs,homework_hrs from ltf_resources_master where unique_id = ".$_GET['cid']);
								//change for topic_id
							?>
								<fieldset><legend><h3>Time required</h3></legend>
									<ul class="a ml-30">
										<li class="fl mt10 ml20">
											<span class="fl"><h3 class="mr10">Classwork Time</h3></span>
											<input type="text" name="classwrkTime" id="classwrkTime"  value="<?php echo $r[0]['classwork_hrs']?>" class="textbox fl w120" maxlength="2" onkeypress="javascript: return _allowNumeric(event);" />
										</li>
										<li class="fl mt10 ml20">
											<span class="fl"><h3 class="mr10">Homework Time</h3></span>
											<input type="text" name="homewrkTime" id="homewrkTime" value="<?php echo $r[0]['homework_hrs']?>" class="textbox fl"  maxlength="2" onkeypress="javascript: return _allowNumeric(event); "/>
										</li>
									</ul>
								</fieldset>
							</td >
						<tr>
							<td colspan="2" class="bgf pt10 pb15">
								<table class="new_text">
									<tr>
										<td style="height:25px;text-align:left;" colspan="4"><font size="3px" class="b">Resource Status</font>&nbsp;&nbsp;&nbsp;&nbsp;						
											<select name="status" id="status" class="dropdown">
												<option value="1" <?php if ($n[0]['ractive'] == 1) echo "selected"; ?> >Active</option>
												<option value="0" <?php if ($n[0]['ractive'] == 0) echo "selected"; ?> >Inactive</option>
											</select>
										</td>
									</tr>
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
<script type="text/javascript">
	//_showchapter(<?php echo $_GET["cid"]; ?>);
</script>
</body>
</html>