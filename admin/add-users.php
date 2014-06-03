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
<title>Avanti  &raquo; Dashboard &raquo; Add Users</title>
<?php
	include_once("./includes/head-meta.php");
?>
</head>
<body>
<div id="pageR">
	<div id="pageContainerR">
		<div id="wrapper">	
			<div id="header">
			<?php
				$pgName = "users";
				include_once("./includes/header.php");
			?>
			</div><!-- End of header -->
			<div id="container2">
				<div class="about2"><a href="./lead-users.php" class="clrmaroon fl">Users &raquo;</a>&nbsp;Add Users</div><!-- End of about -->
				<div id="displayUser">
					<form method="post" name="form" enctype='multipart/form-data' id="form" action="./save-users.php" onsubmit="return _chkuserDetails();">
						<table cellspacing="6" cellpadding="5" border="0" width="710px">
							<tr>
								<td>
									<div id="errormsg" style="height: 12px;"></div>
								</td>
							</tr>
							<tr>
								<td class="ft16">First Name</td>
								<td class="ft16">Last Name</td>
							</tr>
							<tr>
								<td><input type="text" id="txtFName" name="txtFName" class="inputseacrh" maxlength="50"/></td>
								<td><input type="text" id="txtLName" name="txtLName" class="inputseacrh" maxlength="50"/></td>
							</tr>
							<tr>
								<td class="ft16">Email Id</td>
								<td class="ft16">Password</td>
							</tr>
							<tr>
								<td><input type="text" id="txtEmailID" name="txtEmailID" class="inputseacrh"/></td>
								<td><input type="password" id="txtPassword" name="txtPassword" class="inputseacrh" maxlength="20"/></td>
							</tr>
							<tr>
								<td class="ft16">User Name</td>
								<td class="ft16">Gender</td>
							</tr>
							<tr>
								<td><input type="text" id="txtUserName" name="txtUserName" class="inputseacrh"/></td>
								<td>
									<select type="dropdown" id="ddlGender" name="ddlGender" class="dropdown">
										<option value="none">Select One</option>
										<option value="1">Male</option>
										<option value="0">Female</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="ft16">Status</td>
								<td class="ft16">Type User</td>
							</tr>
							<tr>
								<td>
									<select type="dropdown" id="ddlStatus" name="ddlStatus" class="dropdown">
										<option value="none">Select One</option>
										<option value="1">Active</option>
										<option value="0">Inactive</option>
									</select>
								</td>
								<td>
									<select type="dropdown" id="ddlTypeUser" name="ddlTypeUser" class="dropdown">
										<option value="none">Select One</option>
										<option value="Manager">Manager</option>
										<option value="Teacher">Teacher</option>
										<option value="Student">Student</option>
									</select>
								</td>	
							</tr>
							<tr>
								<td><input type="submit" id="btnsave" name="btnsave" value="Save User" class="btnSIgn" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" id="txtLName" name="txtLName"  value="Cancel" class="btnSIgn" /></td>
								<td></td>
							</tr>
						</table>
					</form>
				</div><!-- end of displayUser -->
			</div><!-- end of container -->
			<?php
				include_once("./includes/sidebar.php");
			?>
		</div><!-- end of wrapper -->
	</div><!-- end of pagecontainer -->
</div><!-- end of page -->
</body>
</html>