<?php
	error_reporting(0);
	session_start();
	include("./includes/config.php");		
	include("./classes/cor.mysql.class.php");
	include("./includes/checkLogin.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title>Avanti &raquo; Dashboard &raquo; Password-change</title>
<?php
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
			<div id="container">
				<div class="about clrmaroon">Change Password</div><!-- End of about -->
				<div id="displayUser">
					<?php if(isset($_GET["resp"]) && $_GET["resp"] !=""){
				?>
					<div id="ErrMsg" style="display: block;">
						<?php
						if($_GET["resp"] == "chps")
							echo "Password changed successfully.";
						else if($_GET["resp"] == "ntChps")
							echo "Password not changed.";
						?>
					</div>
				<?php
				}
				?>
					<div id="errormsg" style="height: 12px;"></div>
					<form method="post" name="form" id="form" action="change-password.php" onsubmit="javascript:return _validateChangePassword()">
						<div class="clr"></div>
						<div class="fl AddUserForm mt20">New Password</div>
						<div class="fl mt20" style="margin-left:44px;"><input type="password" name="txtNewPassword" id="txtNewPassword" class="inputseacrh" /></div>
						<div class="clr"></div>
						<div class="fl AddUserForm mt20">Confirm Password</div>
						<div class="fl ml20 mt20"><input type="password" name="txtConfirmPassword" id="txtConfirmPassword" class="inputseacrh" /></div>
						<div class="clr"></div>
						<div class="fl mt20"><input type="submit" name="btnUpdate" id="btnUpdate" class="btnSIgn" value="Update">
						&nbsp; &nbsp;<a href="./dashboard.php"><input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn" /></a></div>
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
<?php
	session_destroy();
?>