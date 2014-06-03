<?php
	error_reporting(0);
	include("./includes/config.php");		
	include("./classes/cor.mysql.class.php");
	include("./includes/checkLogin.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
?>
<!DOCTYPE html>
<html xml:lang="en" lang="en" itemscope="" itemtype="http://schema.org">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Avanti Learning Centres | Reset Password</title>
    <?php 
		include_once("./includes/head-meta.php");
     ?>
</head>
<body>
   <div id="page">
	<div id="pageContainer">
		<div id="wrapper">
			<div id="centerbox" class="centered">
            <div id="login">
                <div id="loginbox">
                    <div id="signinbox">
						<form id="dllog" action="./save-new-password.php" onsubmit="javascript:return _validateResetPassword();" method="POST" name="dllog">
                        <div class="fl ml10"style="width: 91%;">
                            <div class="ml7">
                                <span class="shead ftb clrmaroon">Reset Password</span>
                            </div>
                            <div id="errormsg" style="margin:10px 0px 0px 7px;">
                                <?php
                              
									if(isset($_GET["r"]) && $_GET["r"] == "s"){
								?>
										Your password has been changed successfully.</br>
								<?php		
									} else if(isset($_GET["r"]) && $_GET["r"] == "e") {
								?>
										Your password could not be changed.</br>
								<?php
									}
								?>
                            </div>
							<?php
									$uid = "";
								if(isset($_GET["ud"]))
									$uid = $_GET["ud"];
								$token = "";
								if(isset($_GET["tk"]))
									$token = $_GET["tk"];
								if($uid != "" && $token != "")
									$r = $db->query("query","SELECT userid FROM ltf_admin_usermaster WHERE userid = '" . $uid . "' AND token = '" . $token . "' AND entrydate >= DATE_ADD(Now(), INTERVAL '-120' MINUTE)");
									if($r['response'] != 'error'){
							?>
							<div class="lgrow">
                                <span class="lgctrl">New Password</span>
								<input type="hidden" name="uid" id="uid" value="<?php echo $uid; ?>" />
								<input type="hidden" name="tkn" id="tkn" value="<?php echo $token; ?>" />
                            </div>
                            <div class="lgrow2">
                                <span class="lgctrl"><input type="password" id="txtNPassword" name="txtNPassword" class="inputseacrh txt279" size="30" value="" maxlength="60" /></span>
                            </div>
                            <div class="lgrow">
                                <span class="lgctrl">Confirm Password</span>
                            </div>
                            <div class="lgrow2">
                                <span class="lgctrl"><input type="password" id="txtNCPassword" name="txtNCPassword" class="inputseacrh txt279" size="30" maxlength="15" /></span>
                            </div>
                            <div class="lgrow" style="width: 99%;">
                                <span class="sbtn fr" style="width: 70%;">
                                    <input id="btnLogin" name="btnLogin" type="submit" class="btn w100 fl" value="Confirm |" />
									<input id="btncancel" name="btncancel" type="reset" class="cancel w100 fr" value="Cancel |" />
                                </span>
                            </div>
                            <div class="lgrow">&nbsp;
                            </div>
							<?php
									}
                            ?>
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
            </div>
</div>
<!--<div class="footerindex"></div>-->
<?php		
	include("./includes/poprequest.php");
?>
</body>
</html>