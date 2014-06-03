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
<title>Avanti  &raquo; Dashboard &raquo; Add Manager</title>
<?php
	include_once("./includes/head-meta.php");
	$selmanager = $db->query("query", "SELECT MAX(unique_id) as CountManager FROM avn_centermanager_master");
	if(!array_key_exists("response", $selmanager)){           
		$managerID = ($selmanager[0]["CountManager"] + 1);
		if(intval($managerID) < 10){
			$NewManager = "MH0" . $managerID;
		}
		else{
			$NewManager = "MH". $managerID;
		}
		unset($selmanager);
	}
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
				<div class="about2"><a href="./manager.php" class="clrmaroon fl">Managers &raquo;</a>&nbsp;Add Manager</div><!-- End of about -->
				<div id="displayUser">
					<form method="post" name="form" enctype='multipart/form-data' id="form" action="./save-manager.php" onsubmit="javascript: return _chkmanagerDetails();">
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
								<td><input type="text" id="txtManagerID" name="txtManagerID" class="inputseacrh" value="<?php echo $NewManager; ?>" /></td>
								<td><input type="text" id="txtManagerFName" name="txtManagerFName" class="txtboxS" placeholder="First name" />&nbsp;<input type="text" id="txtManagerLName" name="txtManagerLName" class="txtboxS" placeholder="Last name" /></td>
							</tr>
							<tr>
								<td class="ft16">City</td>
								<td class="ft16">Email</td>
								<!--<td class="ft16">Learning Center</td>-->
							</tr>
							<tr>
								<td>
									<select type="dropdown" id="ddlcity" name="ddlcity" class="dropdown" onchange="javascript: _getcenter(this.value);">
										<option value="none">Select One</option>
										<?php
											$city = $db->query("query","SELECT unique_id ,city_name FROM avn_city_master");
											for($i =0; $i < count($city); $i++){
												if(!array_key_exists("response", $city)){
										?>
													<option value="<?php echo $city[$i]["unique_id"]; ?>"><?php echo $city[$i]["city_name"]; ?></option>
										<?php
												}
											}
											unset($city);
										?>
									</select>
								</td>
								<td>
									<input type="text" id="txtemailid" name="txtemailid" placeholder="Email" class="inputseacrh"  />
								</td>
								<!--<td>
									<select type="dropdown" id="ddlcenter" name="ddlcenter" class="dropdown">
										<option value="none">Select One</option>
									</select>
									<div id="loadcenters"></div>
								</td>-->
							</tr>
							<tr>
								<!--<td class="ft16">Curriculum</td>-->
								<!--<td class="ft16">Email</td>-->
							</tr>
							<tr>
								<!--<td>
									<select type="dropdown" id="ddlcurriculum" name="ddlcurriculum" class="dropdown">
										<option value="none">Select One</option>
										<?php
											//$cur = $db->query("query","SELECT unique_id ,curriculum_name FROM avn_curriculum_master");
											//for($i =0; $i < count($cur); $i++){
												//if(!array_key_exists("response", $cur)){
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
									<input type="text" id="txtemailid" name="txtemailid" placeholder="Email" class="inputseacrh"  />
								</td>-->
							</tr>
							<tr>
								<td class="ft16">Passsword</td>
								<td class="ft16">Confirm Password</td>
							</tr>
							<tr>
								<td><input type="password" id="textpassword" name="textpassword" class="inputseacrh" placeholder="Passsword" /></td>
								<td>
									<input type="password" id="textconfirmpassword" name="textconfirmpassword" class="inputseacrh" placeholder="Confirm Password"  />
								</td>
							</tr>
							<tr>
								<td class="ft16">Phone Number</td>
								<td class="ft16">Gender</td>
							</tr>
							<tr>
								<td><input type="text" id="txtPhone" name="txtPhone" class="inputseacrh" maxlength="10" placeholder="Phone Number" onkeypress="javascript: return _allowNumeric(event);" /></td>
								<td>
									<select type="dropdown" id="ddlGender" name="ddlGender" class="dropdown">
										<option value="none">Select One</option>
										<option value="1">Male</option>
										<option value="2">Female</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="ft16" colspan="2">Status</td>
							</tr>
							<tr>
								<td colspan="2">
									<select type="dropdown" id="ddlStatus" name="ddlStatus" class="dropdown">
										<option value="1" selected>Active</option>
										<option value="0" selected>Inactive</option>
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