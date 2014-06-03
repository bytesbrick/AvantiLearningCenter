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
<title> Avanti  &raquo; Dashboard &raquo; Edit City</title>
<?php
	$pgName = "city";
	include_once("./includes/head-meta.php");

	$r = $db->query("query","SELECT * FROM avn_city_master WHERE unique_id = " . $_GET["cid"]);
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
				<div class="about2"><a href="./city.php" class="clrmaroon fl">City &raquo;</a>&nbsp;Add City</div><!-- End of about -->
				<div id="displayUser">
					<form method="post" name="form" id="form" action="update-city.php" onsubmit="javascript:return _validateCity();">
						<input type="hidden" id="hdIsValidSlug" name="hdIsValidSlug" value="0">
						<input type="hidden" id="hdncityid" name="hdncityid" value="<?php echo $_GET["cid"]; ?>">
						<table cellspacing="0" cellpadding="0" border="0" width="100%">
							<tr>
								<td colspan="2"><div id="errormsg" style="height: 20px;"></div></td>
							</tr>
							<tr>
								<td class="chaptertext">City</td>
								<td>
									<input type="text" name="txtcity" id="txtcity" class="inputseacrh" value="<?php echo $r[0]["city_name"]; ?>" />
								</td>
							</tr>
							<tr>
								<td class="chaptertext">City Prefix</td>
								<td><input type="text" name="txtcityprefix" id="txtcityprefix" class="inputseacrh  mt10" value="<?php echo $r[0]["city_prefix"]; ?>" onblur="javascript: _checkslug('txtcityprefix', 'city_prefix','avn_city_master');" />
									<div id="imgslug" class="imgslug"></div>
									<div id="msg" class="chkedmsg"></div><div class="clr"></div>
									<div class="duplicacymsg fl">This will be checked for duplicacy.</div>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<div class="fl mt20">
										<input type="submit" name="btnSave" id="btnSave" class="btnSIgn" value="Save">
										<span><a href="./edit-city.php"><input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn" /></a></span>
									</div>
								</td>
							</tr>
						</table>
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