<?php
	error_reporting(0);
	include_once("./includes/config.php");
	include("./classes/cor.mysql.class.php");
	include_once("./includes/checklogin.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title>Avanti Learning Centres| Change Password </title>
<?php
	include("./includes/header-meta.php");
?>
<style>
	.pd2{padding: 3% !important}
</style>
<script>
function validateForm()
{
	var x=document.forms["form"]["txtNewPassword"].value;
	var y=document.forms["form"]["txtConfirmPassword"].value;
	var z=document.forms["form"]["txtCurrentPassword"].value;
	if (z==null || z=="")
	{
		//alert("Current password  must be filled out");
		document.getElementById('ErrMsg').innerHTML = "Please fill your current password.";
		return false;
	}
	else if (x==null || x=="")
	{
		//alert("New password must be filled out");
		document.getElementById('ErrMsg').innerHTML = "Please fill your new password.";
		return false;
	}
	else if (y==null || y=="")
	{
		//alert("Confirm password must be filled out");
		document.getElementById('ErrMsg').innerHTML = "Please fill your confirm password.";
		return false;
	}
	else if(x != y)
	{
		document.getElementById('ErrMsg').innerHTML = "New and confirm passwords do not match.";
		return false;
	}
}
</script>
</head>
<body>
	<div class="mainbody">
	<?php
	   include_once("./includes/header.php")
	?>
        <div class="maincontent">
	<div class="fl" style="width:500px">
		<form method="post" name="form" id="form" action="<?php echo __WEBROOT__; ?>/change-password.php" onsubmit="javascript:return validateForm();">
			<table cellpadding="10px" cellspacing="0" border="0" width="100%">
				<tr>
					<td colspan="2">
						<div id="ErrMsg" style="margin:0px !important; font-family: 'AvenirLTStd-Light';font-size:13px;color: #f00;">
							<?php
								if($_GET["resp"] == "chps")
									echo "<span style=\"color:#00A300;\">Your Password has been changed successfully.</span>";
								else if($_GET["resp"] == "nChps")
									echo "Your Credentials are invalid.";
								else if($_GET["resp"] == "ntChps")
									echo "Your password could not changed successfully.";
								else if($_GET["resp"] == "wrngpswrd")
									echo "Enter your correct existing password.";
							?>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<span style='color: #a74242;font-size:19px;font-family: "AvenirLTStd-Light"'>Change Password</span>
					</td>
				</tr>
				<tr>
					<td class="ft14">
						Current Password
					</td>
					<td><input type="password" name="txtCurrentPassword" id="txtCurrentPassword" class="textbox pd2" placeholder="Current Password"/></td>
				</tr>
				<tr>
					<td class="ft14">
						New Password
					</td>
					<td><input type="password" name="txtNewPassword" id="txtNewPassword" class="textbox pd2" placeholder="New Password"/></td>
				</tr>
				<tr>
					<td class="ft14">Confirm Password</td>
					<td><input type="password" name="txtConfirmPassword" id="txtConfirmPassword" class="textbox pd2" placeholder="Confirm Password"/></td>
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
            <?php
	       include("./includes/footer.php");
	    ?>
        </div>
    </div>
</body>
</html>
