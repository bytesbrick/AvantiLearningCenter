<?php
	include_once("./includes/config.php");  
	include("./classes/cor.mysql.class.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
?>
<!DOCTYPE html>
<html xml:lang="en" lang="en" itemscope="" itemtype="http://schema.org">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Avanti Learning Centres | Reset Password</title>
    <?php 
		include_once("./includes/header-meta.php");
     ?>
<script type="text/javascript">
	function _validateResetPassword(){
		var chk = false;
		chk = isFilledText(document.getElementById("txtNPassword"), "", "New Password can't be left blank.", "");
		if(chk)
		chk = isFilledText(document.getElementById("txtNCPassword"), "", "Re-enter your password.", "");
		if(chk){
			if(document.getElementById("txtNPassword").value.trim() != document.getElementById("txtNCPassword").value.trim()){
				alert("Passwords are not matching");
				chk = false;
			}
		}
		return chk;
	}
</script>
</head>
<body>
    <div class="mainbody">
    <div style="float: left;width:100%;background: #BD2728;">
	<div style="margin: 0 auto;width:975px;">
		<div class="logodiv">
		    <a href="<?php echo __WEBROOT__; ?>/lesson-plan/"><img src="<?php echo __WEBROOT__;?>/images/Logo-Hindi-only.png" border="0" alt="Avanti" title="Avanti" /></a>
		</div>
		<div class="redcolordiv" style="height:47px;">
		    <div class="enterdiv"></div>
		</div>
	</div>
    </div>
    <div class="center">
	<div class="midcolumn">
	    <div class="outercentrediv" style="float: left;">
		<div class="fl">
						<div class="maintext">
							<!--<span style="color: #a42828;font-size: 18px;">Reset Password</span>
							</br></br>-->
						</div>
						<div class="center">
							<?php
									if(isset($_GET["r"]) && $_GET["r"] == "s"){
								?>
										Your password has been changed successfully.</br></br>
								<?php		
									} else if(isset($_GET["r"]) && $_GET["r"] == "e") {
								?>
										Your password could not be changed.</br></br>
								<?php
									}
								?>
						   <?php
								$uid = "";
								if(isset($_GET["ud"]))
									$uid = $_GET["ud"];
								$token = "";
								if(isset($_GET["tk"]))
									$token = $_GET["tk"];
								if($uid != "" && $token != ""){
									$r = $db->query("query","SELECT userid FROM avn_login_master WHERE userid = '" . $uid . "' AND token = '" . $token . "' AND entrydate >= DATE_ADD(Now(), INTERVAL '-120' MINUTE)");
									if($r['response'] != "ERROR"){
							?>
										
									<div id="displayUser mt20">
										<div class="clr"></div>
										<div class="chngepswrdfrm">
											<div class="about" style="margin: 0px 0px 0px 0px;">Change Password</div>
											<form method="post" name="frmResetPassword" id="frmResetPassword" action="./save-new-password.php" onsubmit="javascript:return _validateResetPassword();">
											<input type="hidden" name="uid" id="uid" value="<?php echo $uid; ?>" />
											<input type="hidden" name="tkn" id="tkn" value="<?php echo $token; ?>" />
											<div class="clr"></div>
											<div class="txtfield">
												<div class="fl mt10">New Password</div>
												<div class="fl ml42"><input type="password" name="txtNPassword" id="txtNPassword" class="textbox ht25 wd210" /></div>
											</div>
											<div class="clr"></div>
											<div class="txtfield">
												<div class="fl mt10">Confirm Password</div>
												<div class="fl ml19"><input type="password" name="txtNCPassword" id="txtNCPassword" class="textbox ht25 wd210" /></div>
											</div>
											<div class="clr"></div>
											<div class="fl mt40"><input type="submit" name="btnregist" id="btnregist" class="btnSIgn" value="Change Password">
											&nbsp; &nbsp;<a href="./resetpassword.php?ud=<?php echo $uid; ?>&tk=<?php echo $token; ?>"><input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn" /></a></div>
											</form>
										</div>
									</div>
							<?php
									} else {
							?>
										<table border="0" cellpadding="5" cellspacing="0">
											<tr>
												<td style="font-family: Arial;font-size: small;font-weight: normal;line-height: 13px;margin: 20px 0px 0px 0px;">This reset password URL has been expired.</td>
											</tr>
										</table>
							<?php
									}
								}
								mysql_free_result($rs);
							?>
						</div>
					</div><!--div fl w625 starts here-->
	    </div>
	</div>
    </div><!-- center div ends -->
</div>
<!--<div class="footerindex"></div>-->
</body>
</html>