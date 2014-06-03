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
<script>
	function _setcontent(){
		
		if(document.getElementById('rdvideo').checked){
		
			document.getElementById('video').style.display = "block";
		}
		else
			document.getElementById('video').style.display = "none";
			
		if(document.getElementById('rdcontent').checked){
		
			document.getElementById('content').style.display = "block";
		}
		else
			document.getElementById('content').style.display = "none";
		
		if(document.getElementById('rdspottest').checked){
		
			document.getElementById('spottest').style.display = "block";
		}
		else
			document.getElementById('spottest').style.display = "none";
			
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
				<div id="displayUser" style="margin-top:20px;">
					<table cellspacing="4" cellpadding="0" border="0">
						<form method="post" name="form" id="form" enctype='multipart/form-data' action="save-resourse.php" onsubmit="javascript:return validateForm()">
							<input type="hidden" name="hdCatID" id="hdCatID" value="<?php echo $r[0]['unique_id']; ?>" />
							<tr>
								<td class="fl">
									<div class="fl">
										<div class=" fl AddUserForm ml20 mt10 rtd">Content Type</div>
										<div class="fl" style="margin: 10px 0px 0px 63px;">
											<div class="fl">
												<input type="radio" name="ckradio" id="rdvideo" class="fl"  onclick="javascript:_setcontent();" />
												<div class="fl ml10 ft16">Text/Video Content</div>
											</div>
											<div class="fl">
												<input type="radio" name="ckradio" id="rdcontent" class="fl ml20" onclick="javascript:_setcontent();" />
												<div class="fl ml10 ft16">Spot test</div>
											</div>
											<div class="fl">
												<input type="radio" name="ckradio" id="rdspottest" class="fl ml10" onclick="javascript:_setcontent();" />
												<div class="fl ml10 ft16">Concept test</div
											</div>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td class="fl">
									<div class="fl mt10" id="video" style="display: none;">
										<div class=" fl AddUserForm ml20 mt10 rtd">Video</div>
										<div class="fl" style="margin: 10px 0px 0px 123px;">
											<table id="dVideoTab" border="0">
												<tr id="Videorow-1">
													<td><input type="text" class="textbox" name="txtVideoFlds[]" id="txtVideoFlds-1" value="" style="width:610px;height:30px;" /></td>
													<td><img id="videoplus" src="./images/plus.png" onclick="javascript: _addNewVideoField(this.id);" /></td>
												</tr>
											</table>
										</div>
										<div class="clr"></div>
										<div class="fl AddUserForm ml20 mt10 rtd">Text</div>
										<div class="fl mt10" style="margin: 10px 0px 0px 135px;">
											<textarea type="text" id="textcontent" name="textcontent" value="" rows="6" cols="75" style="width:619px;height:131px !important;"></textarea>
										</div>
										<div class="clr"></div>
										<div class="fl ml30 mt20 mb60">
											<input type="submit" name="btnSave" id="btnSave" class="btnSIgn" value="Save">
											&nbsp; &nbsp;<a href="./add-resourse.php"><input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn" /></a>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="fl mt10" id="content" style="display: none;">
										<div class= "fl AddUserForm ml20 mt10 rtd">Introduction</div>						
										<div class="fl mt10" style="margin: 10px 0px 0px 80px;">
											<textarea type="text" id="txtintro" name="txtintro" value="" rows="6" cols="75" style="width:619px;height:131px !important;"></textarea>
										</div>
										<div class="clr"></div>
										<div class="fl ml30 mt20 mb60">
											<input type="submit" name="btnSave" id="btnSave" class="btnSIgn" value="Save">
											&nbsp; &nbsp;<a href="./spot-test.php"><input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn" /></a>
										</div>
									</div>
								</td>
							</tr>
						</form>
							<tr>
								<td>
									<div class="fl" id="spottest" style="display: none;">
										<div class="fl ml20" style="margin:0px 0px 0px 18px;">
											<table cellspacing="4" cellpadding="0" border="0">
												<form method="post" name="form" enctype='multipart/form-data' id="form" action="./save-spot-test.php" onsubmit="return _chkdataResourse()">
												<input type="hidden" name="hdnresid" id="hdnresid" value="<?php echo $_GET['cid']; ?>">
												<tr>
													<td colspan="2" style="height:20px;">
														<div id="ErrMsg">
														</div>
													</td>
												</tr>
												<tr>
												<td class="rtd fl mt10" colspan="2">Test</td>
													<td class="fl ml20" style="margin: 0px 0px 0px 135px;">
														<select name="ddltesttype" id="ddltesttype" class="dropdown fl">
															<option value="1">Spot-Test</option>
															<option value="2">Concept-Test</option>
														</select>
													</td>
												</tr>
												<tr style="height:8px;"><td colspan="2"></td></tr>
												<tr><td class="rtd" colspan="2">Question</td></tr>
												<tr>
													<td class="fl" colspan="2">
														<textarea type="text" id="txtquestion" name="txtquestion" value="" rows="6" cols="75" style="width:619px;height:131px !important;"></textarea>
													</td>
												</tr>
												<tr><td class="rtd" colspan="2">Option 1</td></tr>
												<tr>
													<td class="fl" colspan="2">
														<textarea type="text" id="txtoptionone" name="txtoptionone" value="" rows="6" cols="75" style="width:619px;height:131px !important;"></textarea>
													</td>
												</tr>
												<tr><td class="rtd" colspan="2">Option 2</td></tr>
												<tr>
													<td class="fl" colspan="2">
														<textarea type="text" id="txtoptiontwo" name="txtoptiontwo" value="" rows="6" cols="75" style="width:619px;height:131px !important;"></textarea>
													</td>
												</tr>
												<tr><td class="rtd" colspan="2">Option 3</td></tr>
												<tr>
													<td class="fl" colspan="2">
														<textarea type="text" id="txtoptionthree" name="txtoptionthree" value="" rows="6" cols="75" style="width:619px;height:131px !important;"></textarea>
													</td>
												</tr>
												<tr><td class="rtd" colspan="2">Option 4</td></tr>
												<tr>
													<td class="fl" colspan="2">
														<textarea type="text" id="txtoptionfour" name="txtoptionfour" value="" rows="6" cols="75" style="width:619px;height:131px !important;"></textarea>
													</td>
												</tr>
												<tr style="height:8px;"><td colspan="2"></td></tr>
												<tr>
													<td class="rtd fl mt10" colspan="2">Explanation</td>
												</tr>
												<tr>
													<td class="fl ml40">
														<td class="fl" colspan="2">
														<textarea type="text" id="txtexplanation" name="txtexplanation" value="" rows="6" cols="75" style="width:619px;height:131px !important;"></textarea>
													</td>
													</td>
												</tr>
												<tr>
													<td class="rtd fl mt10" colspan="2">Correct Option</td>
													<td class="fl ml40">
														<select name="ddlAnsOption" id="ddlAnsOption" class="dropdown fl">
															<option value="1">Option 1</option>
															<option value="2">Option 2</option>
															<option value="3">Option 3</option>
															<option value="4">Option 4</option>
														</select>
													</td>
												</tr>
												
												<tr style="height:8px;"><td colspan="2"></td></tr>
												<tr>
													<td colspan="2" class="bgf pb15">
														<table class="new_text">
															<tr>
																<td style="height:25px;text-align:left;" colspan="4"><font size="3px" class="b">Question Status</font>&nbsp;&nbsp;&nbsp;&nbsp;							  	      		  <select name="ddlstatus" id="ddlstatus" class="dropdown">
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
														<div class="fl ml30 mt20 mb60"><input type="submit" name="btnSave" id="btnSave" class="btnSIgn" value="Save">
														&nbsp; &nbsp;<a href="./spot-test.php"><input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn" /></a></div>
													</td>
												</tr>
											</form>
										</table>
									</div>
								</td>
							</tr>
						</table>					
					</div><!--end of displayUser-->
				</div>
			</div><!-- end of container -->
		</div><!-- end of wrapper -->
	</div><!-- end of pagecontainer -->
</div><!-- end of page -->


</body>
</html>
