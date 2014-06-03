<?php
	error_reporting(0);
	include_once("./includes/config.php");  
	include_once("./classes/cor.mysql.class.php");
	include_once("./includes/checkLogin.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title>Avanti Learning Centres| Change Password </title>
<?php
	include_once("./includes/header-meta.php");	
?>
<script>
function validateForm()
{
	var x=document.forms["form"]["txtNewPassword"].value;
	var y=document.forms["form"]["txtConfirmPassword"].value;
	if (x==null || x=="")
	{
		alert("New password  must be filled out");
		return false;
	}
	else if (y==null || y=="")
	{
		alert("Conform password must be filled out");
		return false;
	}
	else if(x != y)
	{
		alert("New Password and Confirm Password are not matched");
		return false;
	}
}
</script>
</head>
<body>
	<div style="width:100%;float: left;">
	<div style="float: left;width:100%;background: #BD2728;">
	    <?php include_once("./includes/header.php");?>
	</div>
	<div class="maindiv" style="min-height: 737px;">
        <div class="blackborderdiv">
            <div class="tabeldiv">
				<?php
					include_once("./includes/leftdiv.php");
				?>
                <div class="headingdiv">
					<span class="updiv" style="padding-bottom: 22px;">Change Password</span>
					<div class="columdiv" id="columdiv">
						<form method="post" name="form" id="form" action="<?php echo __WEBROOT__; ?>/change-password.php" onsubmit="javascript:return validateForm();">
							<table cellpadding="10px" cellspacing="0" border="0" width="100%">
								<tr>
									<td colspan="2">
										<div id="ErrMsg" style="margin:0px !important;">
											<?php
												if($_GET["resp"] == "chps")
													echo "<span style=\"color:#00A300;\">Your Password has been successfully changed.</span>";
												else if($_GET["resp"] == "nChps")
													echo "Your Credentials are invalid";
												else if($_GET["resp"] == "ntChps")
													echo "Your password is not changed";
											?>
										</div>
									</td>
								</tr>
								<tr>
									<td>
										New Password
									</td>
									<td><input type="password" name="txtNewPassword" id="txtNewPassword" class="textbox" /></td>
								</tr>
								<tr>
									<td>Confirm Password</td>
									<td><input type="password" name="txtConfirmPassword" id="txtConfirmPassword" class="textbox" /></td>
								</tr>
								<tr>
									<td colspan="2">
										<input type="submit" name="btnUpdate" id="btnUpdate" class="btnSIgn" value="Update">
										<a href="./password-change.php"><input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn" /></a>
									</td>
								</tr>
							</table>
						</form>
					</div>
                </div>
            </div>
        </div>
    </div>
	</div>
</body>
</html>
