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
<title>Avanti  &raquo; Dashboard &raquo; Edit Teacher</title>
<?php
	include_once("./includes/head-meta.php");
	$r = $db->query("query","SELECT acmm.*,AES_DECRYPT(alm.password, '" . ENCKEY . "') as PWD FROM avn_centermanager_master acmm LEFT JOIN avn_login_master alm ON alm.user_ref_id = acmm.unique_id WHERE acmm.unique_id = " .$_GET["cid"]);
?>
</head>
<body>
<div id="pageR">
	<div id="pageContainerR">
		<div id="wrapper">	
			<div id="header">
			<?php
				$pgName = "managers";
				include_once("./includes/header.php");
			?>
			</div><!-- End of header -->
			<div id="container2">
				<div class="about2"><a href="./manager.php" class="clrmaroon fl">Managers &raquo;</a>&nbsp;Edit Manager</div><!-- End of about -->
				<div id="displayUser">
					<form method="post" name="form" enctype='multipart/form-data' id="form" action="./update-manager.php" onsubmit="javascript: return _chkmanagerDetails();">
						<input type="hidden" id="hdManagerid" name="hdManagerid" value="<?php echo $_GET["cid"]; ?>">
						<input type="hidden" id="hdnmanager" name="hdnmanager" value="Manager" />
						<table cellspacing="6" cellpadding="5" border="0" width="65%">
							<tr>
								<td>
									<div id="errormsg" style="height: 12px;"></div>
								</td>
							</tr>
							<tr>
								<td class="ft16">Manager ID</td>
								<td class="ft16">Manager Name</td>
							</tr>
							<tr>
								<td><input type="text" id="txtManagerID" name="txtManagerID" class="inputseacrh" readonly="true" value="<?php echo $r[0]["center_manager_id"]; ?>" /></td>
								<td><input type="text" id="txtManagerFName" name="txtManagerFName" class="txtboxS" placeholder="First name" value="<?php echo $r[0]["fname"]?>" />&nbsp;<input type="text" id="txtManagerLName" name="txtManagerLName" class="txtboxS" placeholder="Last name" value="<?php echo $r[0]["lname"]?>" /></td>
							</tr>
							<tr>
								<td class="ft16">City</td>
								<td class="ft16">Email</td>
								<!--<td class="ft16">Learning Center</td>-->
							</tr>
							<tr>
								<td>
									<select type="dropdown" id="ddlcity" name="ddlcity" class="dropdown" onchange="javascript: _getcenter(this.value);">
										<?php
										$selcity = $db->query("query","SELECT * FROM avn_city_master");
										for($i=0; $i<count($selcity); $i++){
											if($r[0]["city_id"] == $selcity[$i]["unique_id"]){
										?>
												<option value="<?php echo $selcity[$i]["unique_id"]; ?>" selected><?php echo $selcity[$i]["city_name"]; ?></option>
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
								<td>
									<input type="text" id="txtemailid" name="txtemailid" class="inputseacrh" value="<?php echo $r[0]["email_id"]; ?>"  />
								</td>
								<!--<td>
									<select type="dropdown" id="ddlcenter" name="ddlcenter" class="dropdown">
									<?php
										//$selcenter = $db->query("query","SELECT * FROM avn_learningcenter_master");
										//for($i=0; $i<count($selcenter); $i++){
										//	if($r[0]["learning_center"] == $selcenter[$i]["unique_id"]){
									?>
												<option value="<?php //echo $selcenter[$i]["unique_id"]; ?>" selected><?php //echo $selcenter[$i]["center_name"]; ?></option>
									<?php
											//}else{
									?>
												<option value="<?php //echo $selcenter[$i]["unique_id"]; ?>"><?php //echo $selcenter[$i]["center_name"]; ?></option>
									<?php
											//}
										//}
									?>
									</select>
									<div id="loadcenters"></div>
								</td>-->
							</tr>
							<!--<tr>
								<td class="ft16">Curriculum</td>
								<td class="ft16">Email</td>
							</tr>-->
							<!--<tr>-->
								<!--<td>
									<select type="dropdown" id="ddlcurriculum" name="ddlcurriculum" class="dropdown">
										<option value="none">Select One</option>
										<?php
											//$cur = $db->query("query","SELECT unique_id ,curriculum_name FROM avn_curriculum_master");
											//for($i =0; $i < count($cur); $i++){
											//	if($r[0]["curriculum_id"] == $cur[$i]["unique_id"]){
										?>
												<option value="<?php //echo $cur[$i]["unique_id"]; ?>"selected><?php //echo $cur[$i]["curriculum_name"]; ?></option>
										<?php
											//}else{
										?>
												<option value="<?php //echo $cur[$i]["unique_id"]; ?>"><?php //echo $cur[$i]["curriculum_name"]; ?></option>
										<?php
												//}
											//}
											//unset($cur);
										?>
									</select>
								</td>-->
								<!--<td>
									<input type="text" id="txtemailid" name="txtemailid" class="inputseacrh" value="<?php echo $r[0]["email_id"]; ?>"  />
								</td>-->
							<!--</tr>-->
							<tr>
								<td class="ft16">Passsword</td>
								<td class="ft16">Confirm Password</td>
							</tr>
							<tr>
								<td><input type="password" id="textpassword" name="textpassword" class="inputseacrh" value="<?php echo $r[0]["PWD"]; ?>" /></td>
								<td>
									<input type="password" id="textconfirmpassword" name="textconfirmpassword" class="inputseacrh" value="<?php echo $r[0]["PWD"]; ?>" />
								</td>
							</tr>
							<tr>
								<td class="ft16">Phone Number</td>
								<td class="ft16">Gender</td>
							</tr>
							<tr>
								<td><input type="text" id="txtPhone" name="txtPhone" class="inputseacrh" value="<?php echo $r[0]["phone"]; ?>" maxlength="10" onkeypress="javascript: return _allowNumeric(event);" /></td>
								<td>
									<select type="dropdown" id="ddlGender" name="ddlGender" class="dropdown">
										<?php
											if(isset($r[0]['gender']) && $r[0]['gender'] == '1'){
										?>
											<option value="1" selected>Male</option>
										<?php
										}	else{
										?>
											<option value="1">Male</option>
										<?php
										}	if(isset($r[0]['gender']) && $r[0]['gender'] == '2'){
										?>
											<option value="2" selected>Female</option>
										<?php
										}	else{
										?>
											<option value="2">Female</option>
										<?php
											}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="ft16" colspan="2">Status</td>
							</tr>
							<tr>
								<td colspan="2">
									<select type="dropdown" id="ddlStatus" name="ddlStatus" class="dropdown">
										<?php
											if(isset($r[0]['status']) && $r[0]['status'] == '1'){
										?>
											<option value="1" selected>Active</option>
										<?php
										}else{
										?>
											<option value="1">Active</option>
										<?php
										}if(isset($r[0]['status']) && $r[0]['status'] == '0'){
										?>
											<option value="0" selected>Inactive</option>
										<?php
										}else{
										?>
											<option value="0">Inactive</option>
										<?php
										}
										?>
									</select>
								</td>	
							</tr>
							<tr>
								<td><input type="submit" id="btnsave" name="btnsave" value="Save" class="btnSIgn" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" id="txtLName" name="txtLName"  value="Cancel" class="btnSIgn" /></td>
								<td></td>
							</tr>
						</table>
					</form>
				</div><!-- end of displayUser -->
			</div><!-- end of container -->
			<?php
				$db->close();
				include_once("./includes/sidebar.php");
			?>
		</div><!-- end of wrapper -->
	</div><!-- end of pagecontainer -->
</div><!-- end of page -->
</body>
</html>