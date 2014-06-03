<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Avanti  &raquo; Login</title>
<?php 
	include_once("./includes/head-meta.php");
	error_reporting(0);
?>
<script type="text/javascript" language="javascript" src="./javascript/_mm_loginForm.js"></script>
<SCRIPT LANGUAGE="JavaScript">
	 function _setFocus() {
    var f = null;
    if (document.getElementById) {
      f = document.getElementById('dllog');
    }
    if (f) {
      if (f.txtUserID && (f.txtUserID.value == null || f.txtUserID.value == '')
          && f.txtUserID.focus) {
        f.txtUserID.focus();
      } else if (f.txtpassword) {
        f.txtpassword.focus();
      }
    }
  }
  window.onload = _setFocus;
</SCRIPT>
</head>
<body>
<div id="page">
	<div id="pageContainer">
		<div id="wrapper">	
			<div id="centerbox" class="centered">
				<div id="login">
					<div id="loginbox">
						<div id="signinbox">
							<form id="dllog" action="./login.php" onsubmit="return _checkLogin();" method="POST" name="dllog">
							<div class="ml10 fl" style="width: 88%;">
								<div class="ml7">
									<span class="shead ftb clrmaroon">Login Screen</span>
								</div>
								<?php
									if(isset($_GET["resp"]) && $_GET["resp"] != ""){
								?>
										<div id="errormsg" style="margin: 5px 0px 0px 7px; display: block;">
											<?php
												if($_GET["resp"] == "inv")
													echo "Invalid User ID and Password.";
												else if($_GET["resp"] == "O")
													echo "Your are successfully logout.";
												else if($_GET["resp"] == "noinpt")
													echo "Please enter your userid and password.";
											?>
										</div>	
								<?php
									}else{
								?>
										<div id="errormsg" style="margin: 5px 0px 0px 7px; display: block;font-size:13px; padding: 0px;"></div>
								<?php
									}
								?>
								<!--<div id="ErrMsg" name="ErrMsg" style="display: block;background: #fff; font-size: 14px;margin: 5px;padding: 0px;"></div>-->
								<div class="lgrow">
									<span class="lgctrl">Email ID/User ID</span>
								</div>
								<div class="lgrow2">
									<span class="lgctrl"><input type="text" id="txtUserID" name="txtUserID" class="inputseacrh txt279" size="30" value="" maxlength="60" /></span>
								</div>
								<div class="lgrow">
									<span class="lgctrl">Password</span>
								</div>
								<div class="lgrow2">
									<span class="lgctrl"><input type="password" id="txtpassword" name="txtpassword" class="inputseacrh txt279" size="30" maxlength="15" /></span>
								</div>
								<div class="lgrow">
									<span class="fp"><a href="javascript:void(0);" class="forgotpassword" onclick="javascript: _disableThisPage();_setDivPos('forgotpassword');">Forgot password?</a></span>
									<span class="sbtn">
										<input id="btnLogin" name="btnLogin" type="submit" class="btn w100 fr" value="Sign In |" />
									</span>
								</div>
								<div class="lgrow">&nbsp;</div>
							</div>
							</form>
						</div>
						<div id="signupbox">
							<div class="pad10">
								<div>
									<span class="shead tac">Avanti Learning Centres</span>
								</div>
								<div class="lgrow stext tac mt25">
									<br />
									<img src="./images/newavantilogo.png" width="170px" border="0" alt="Avanti Learning Centres" title="Avanti Learning Centres" />
								</div>
							</div>
						</div>
					</div>
				</div><!-- end of login -->
			</div><!-- end of center -->
		</div><!-- end of wrapper -->
		<?php
			include_once("./includes/loginscreen.php");
			$db->close();
		?>
	</div><!-- end of pagecontainer -->
</div><!-- end of page -->
</body>
</html>
