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
<title> Avanti  &raquo; Dashboard &raquo; Edit Center</title>
<?php
	$pgName = "Learningcenters";
	include_once("./includes/head-meta.php");
	$r = $db->query("query","SELECT * FROM avn_learningcenter_master WHERE unique_id = " . $_GET["cid"]);
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
				<div class="about2"><a href="./learning-center.php" class="clrmaroon fl">Centers &raquo;</a>&nbsp;Edit Center</div><!-- End of about -->
				<div id="displayUser">
					<form method="post" name="editform" id="editform" action="update-center.php" onsubmit="javascript:return _validateCity();">
						<input type="hidden" id="hdIsValidSlug" name="hdIsValidSlug" value="0">
						<input type="hidden" id="hdncenterid" name="hdncenterid" value="<?php echo $_GET["cid"]; ?>">
						<input type="hidden" id="hdCurrentdulicacy" name="hdCurrentdulicacy" value="<?php echo $r[0]["center_code"];?>">
						<table cellspacing="0" cellpadding="0" border="0" width="100%">
							<tr>
								<td colspan="2"><div id="errormsg" style="height: 20px;"></div></td>
							</tr>
							<tr>
								<td class="chaptertext">Center Code</td>
								<td>
									<input type="text" name="txtcentercode" id="txtcentercode" class="inputseacrh" value="<?php echo $r[0]["center_code"]; ?>" onblur="javascript: _checkduplicacy('txtcentercode','center_code','avn_learningcenter_master');" />
									<div id="imgchk" class="imgslug mt15"></div>
									<div id="msgchk" class="chkedmsg mt15"></div><div class="clr"></div>
									<div class="duplicacymsg fl">This will be checked for duplicacy.</div>
								</td>
							</tr>
							<tr>
								<td class="chaptertext">Center Name</td>
								<td>
									<input type="text" name="txtcenter" id="txtcenter" class="inputseacrh mt10" value="<?php echo $r[0]["center_name"]; ?>" />
								</td>
							</tr>
							<tr>
								<td class="chaptertext">City</td>
								<td>
									<select id="ddlcity" name="ddlcity" class="dropdown mt10">
									<?php
										$selcity = $db->query("query","SELECT * FROM avn_city_master");
										for($i=0; $i<count($selcity); $i++){
											if($selcity[$i]["unique_id"] == $r[0]["city_id"]){
									?>
												<option value="<?php echo $selcity[$i]["unique_id"]; ?>" selected=><?php echo $selcity[$i]["city_name"]; ?></option>
									<?php
											}
											else{
									?>
												<option value="<?php echo $selcity[$i]["unique_id"]; ?>"><?php echo $selcity[$i]["city_name"]; ?></option>
									<?php
											}
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
										<span><a href="./edit-center.php"><input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn" /></a></span>
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