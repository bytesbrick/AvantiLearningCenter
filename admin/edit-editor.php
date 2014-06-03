<?php
	include_once("./includes/config.php");		
	include("./classes/cor.mysql.class.php");
	include_once("./includes/checkLogin.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Avanti &raquo; Dashboard &raquo; Edit Editors</title>
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
				$pgName = "editors";
				include_once("./includes/header.php");
			?>
			</div><!-- End of header -->
			<div id="container2">
				<div class="about2"><a href="./editor.php" class="clrmaroon fl">Editors &raquo;</a>&nbsp;Edit Editor</div><!-- End of about -->
				<div id="displayUser">
					<?php
						if(isset($_GET["cid"]) && $_GET["cid"] != "")
							$r = $db->query("query","SELECT * FROM ltf_admin_usermaster WHERE unique_id=" . $_GET["cid"]);
					?>
					<form method="post" id="editorform" name="editorform" action="./update-editor.php" onsubmit="return _chkuserDetailsedit();">
						<input type="hidden" id="hdnuID" name="hdnuID" value="<?php echo $_GET['cid']; ?>"/>
						<input type="hidden" id="hdnqryStringEditor" name="hdnqryStringEditor" value="<?php echo urlencode(filter_querystring($_SERVER["QUERY_STRING"],array("resp","cid"),array("",""))); ?>">
						<table cellspacing="6" cellpadding="4" border="0" width="710px" align="left">
							<tr>
								<td>
									<div id="errormsg"style="height: 12px;"></div>
								</td>
							</tr>
							<tr>
								<td class="ft16">First Name</td>
								<td class="ft16">Last Name</td>
							</tr>
							<tr>
								<td><input type="text" id="txtFName" name="txtFName" class="inputseacrh" maxlength="50" value="<?php if(isset($r[0]['firstname'])) echo $r[0]['firstname']; else echo ""; ?>"/></td>
								<td><input type="text" id="txtLName" name="txtLName" class="inputseacrh" maxlength="50" value="<?php if(isset($r[0]['lastname'])) echo $r[0]['lastname']; else echo ""; ?>"/></td>
							</tr>
							<tr>
								<td class="ft16">Email Id</td>
								<td class="ft16">Password</td>
							</tr>
							<tr>
								<td><input type="text" id="txtEmailID" name="txtEmailID" class="inputseacrh" value="<?php if(isset($r[0]['lastname'])) echo $r[0]['emailid']; else echo ""; ?>"/></td>
								<td><input type="password" id="txtPassword" name="txtPassword" class="inputseacrh" maxlength="20" value="<?php if(isset($r[0]['lastname'])) echo $r[0]['lastname']; else echo ""; ?>"  /></td>
							</tr>
							<tr>
								<td class="ft16">User Name</td>
								<td class="ft16">Gender</td>
							</tr>
							<tr>
								<td><input type="text" id="txtUserName" name="txtUserName" class="inputseacrh" value="<?php if(isset($r[0]['username'])) echo $r[0]['username']; else echo ""; ?>"/></td>
								<td>
									<select type="dropdown" id="ddlGender" name="ddlGender" class="dropdown">
										<!--<option value="none">Select One</option>-->
										<?php
											if(isset($r[0]['gender']) && $r[0]['gender'] == '1'){
										?>
											<option value="1" selected>Male</option>
										<?php
										}else{
										?>
											<option value="1">Male</option>
										<?php
										}if(isset($r[0]['gender']) && $r[0]['gender'] == '0'){
										?>
											<option value="0" selected>Female</option>
										<?php
										}else{
										?>
											<option value="0">Female</option>
										<?php
										}
										?>
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
										<!--<option value="none">Select One</option>-->
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
								<td>
									<select type="dropdown" id="ddlTypeUser" name="ddlTypeUser" class="dropdown">
										<!--<option value="none">Select One</option>-->
										<?php
											if(isset($r[0]['usertype']) && $r[0]['usertype'] == 'Manager'){
										?>
												<option value="Manager" selected>Manager</option>
										<?php
										}
										else
											{
										?>
												<option value="Manager">Manager</option>
										<?php
											}
										?>
										<?php
											if(isset($r[0]['usertype']) && $r[0]['usertype'] == 'Teacher'){
										?>
												<option value="Teacher" selected>Teacher</option>
										<?php
										}else	
											{
										?>
												<option value="Teacher">Teacher</option>
										<?php
											}
										
											if(isset($r[0]['usertype']) && $r[0]['usertype'] == 'Administrator'){
										?>
												<option value="Administrator" selected>Administrator</option>
										<?php
										}else
											{
										?>
												<option value="Administrator">Administrator</option>
										<?php
											}
										?>
									</select>	
								</td>
							</tr>
							<tr>
								<td><input type="submit" id="btnupdate" name="btnupdate" value="Update Editor" class="btnSIgn" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button"  value="Cancel" class="btnSIgn" /></td>
								<td></td>
							</tr>
						</table>
					</form>
				</div><!--end of displayUser-->	
			</div><!-- end of container -->
			<?php
				include_once("./includes/sidebar.php");
				$db->close();
			?>
		</div><!-- end of wrapper -->
	</div><!-- end of pagecontainer -->
</div><!-- end of page -->
</body>
</html>