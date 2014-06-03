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
		var x=document.forms["form"]["txtVideoFlds"].value;
		var y=document.forms["form"]["textcontent"].value;
		if (x==null || x=="")
		  {
			  alert("Enter the embed code of the video");
			  return false;
		  }
		if (y==null || y=="")
		  {
			  alert("Enter the Text");
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
				<div id="displayUser" style="margin-top:20px;">
					<div class="about"><a href="resourse.php">Resource </a>&raquo; Add Resource</div><!-- End of about -->
					<table cellspacing="4" cellpadding="0" border="0">
						<form method="post" name="form" id="form" enctype='multipart/form-data' action="save-resourse.php" onsubmit="javascript:return validateForm()">
							<input type="hidden" name="hdCatID" id="hdCatID" value="<?php echo $r[0]['unique_id']; ?>" />
							<tr>
								<td class="fl">
									<div class="fl mt10" id="video">
										<div class=" fl AddUserForm ml20 mt20 rtd">Video</div>
										<div class="fl" style="margin: 10px 0px 0px 123px;">
											<table id="dVideoTab" border="0">
												<tr id="Videorow-1">
													<td><input type="text" class="textbox" name="txtVideoFlds[]" id="txtVideoFlds-1" value="" style="width:610px;height:30px;" /></td>
													<td><img id="videoplus" src="./images/plus.png" onclick="javascript: _addNewVideoField(this.id);" /></td>
												</tr>
											</table>
										</div>
										<div class="clr"></div>
										<div class="fl AddUserForm ml20 mt20 rtd">Text</div>
										<div class="fl mt10" style="margin: 10px 0px 0px 135px;">
											<textarea type="text" id="textcontent" name="textcontent" value="" rows="6" cols="75" style="width:619px;height:131px !important;"></textarea>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="fl ml30 mt20 mb60">
										<input type="submit" name="btnSave" id="btnSave" class="btnSIgn" value="Save">
										&nbsp; &nbsp;<a href="./add-resourse.php"><input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn" /></a>
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
