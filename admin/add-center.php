<?php
	error_reporting(0);
	include("./includes/config.php");		
	include("./classes/cor.mysql.class.php");
	include("./includes/checkLogin.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title> Avanti  &raquo; Dashboard &raquo; Add Center</title>
<?php
	$pgName = "Learningcenters";
	include_once("./includes/head-meta.php");
?>
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
			<div id="container2">
				<div class="about2"><a href="./learning-center.php" class="clrmaroon fl">Center &raquo;</a>&nbsp;Add Center</div><!-- End of about -->
				<div id="displayUser">
					<form method="post" name="form" id="form" action="./save-center.php" onsubmit="javascript:return _validateCenter();">
						<input type="hidden" id="hdIsValidSlug" name="hdIsValidSlug" value="0">
						<table cellspacing="0" cellpadding="0" border="0" width="100%">
							<tr>
								<td colspan="2"><div id="errormsg" style="height: 20px;"></div></td>
							</tr>
							<tr>
								<td class="chaptertext">Center Name</td>
								<td>
									<input type="text" name="txtcenter" placeholder="Center" id="txtcenter" class="inputseacrh" />
								</td>
							</tr>
							<tr>
								<td class="chaptertext">City</td>
								<td>
									<select id="ddlcity" name="ddlcity" class="dropdown mt10">
										<option value="0">Select city</option>
									<?php
										$selcity = $db->query("query","SELECT * FROM avn_city_master");
										for($i=0; $i<count($selcity); $i++){
									?>
											<option value="<?php echo $selcity[$i]["unique_id"]; ?>"><?php echo $selcity[$i]["city_name"]; ?></option>
									<?php
										}
										unset($selcity);
									?>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<div class="fl mt20">
										<input type="submit" name="btnSave" id="btnSave" class="btnSIgn" value="Save">
										<span><a href="./learning-center.php"><input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn" /></a></span>
									</div>
								</td>
							</tr>
						</table>
						<?php
							$db->close();;
						?>
					</form>
				</div><!--end of displayUser-->	
			</div><!-- end of container -->
			<?php
				include_once("./includes/sidebar.php");
			?>
		</div><!-- end of wrapper -->
	</div><!-- end of pagecontainer -->
</div><!-- end of page -->
</body>
</html>