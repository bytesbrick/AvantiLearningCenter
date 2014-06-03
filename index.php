<?php
   error_reporting(0);
    include_once("./includes/config.php"); 
//    if(isset($_COOKIE["cUserName"]) && $_COOKIE["cUserName"] != ""){
//	header("Location: " . __WEBROOT__ . "/curriculum/iit-jee/");
//    }
//    else{
//	header("Location: " . __WEBROOT__ . "/");
//    }    
?>
<html xml:lang="en" lang="en" itemscope="" itemtype="http://schema.org">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<head>
<title>Avanti Learning Centres | Home</title>
<?php
    include_once("./includes/header-meta.php");
?>
<style>
   body{
      background-image:url(./images/newstudent2.jpg);
      background-repeat:no-repeat;
      /*background-color: #ececec;*/
   }
</style>
</head>
<body>
    <div class="maindiv">
        <div class="avantidiv">
            <div class="rightdiv">
                <div class="avantilogodiv">
                    <a href="./"><img src="./images/avanti.png" style="border: 0px solid #fff;"/></a>
                </div>
                <div class="boxdiv">
                    <div class="learntextdiv">
                        <div class="twotextdiv">
                            <span class="textdiv">Learn Better Together!</span>
                            <span class="welcometextdiv">Welcome to PeerLearning.com. This portal is exclusively available to students enrolled at Avanti's Learning Centres across India. To learn more please visit our <a href="http://www.avantifellows.org/" target="_blank">corporate website</a>.</span>
                        </div>
                    </div>
                    <div class="signdiv">
                        <div class="iddiv">
                            <span class="textdiv wd280" style="font-size: 28px !important;">Sign in to continue</span>
                            <div class="firstenterdiv">
                                <form name="formlogin" id="formlogin" method="post" action="login.php" onsubmit="javascript: return _checkLogin();">
					<?php
					    if(isset($_COOKIE['userID'])){
					?>
					    <div class="emaildiv mt10">
						<input type="text" name="txtemailid" id="txtemailid" class="textbox" value="<?php echo $_COOKIE['cUserID'];?>">
					    </div>
					    <div class="passworddiv mt10" style="display: none;">
						<input type="password" name="txtpassword" id="txtpassword" class="textbox" placeholder="password" style="width: 100px; margin-top:2px;">
					    </div>
					    <a href="<?php echo __WEBROOT__;?>/logout.php">
					       <input type="button" name="Login" id="Login" class="summitdiv" value="Logout" style="margin-left: 0px;" />
					    </a>
					<?php
					    }else{
					?>
					    <div class="emaildiv mt10">
						<input type="text" name="txtemailid" id="txtemailid" class="textbox" placeholder="email address">
					    </div>
					    <div class="passworddiv mt10">
						<input type="password" name="txtpassword" id="txtpassword" class="textbox" placeholder="password" style="width: 115px !important; margin-top:2px;">
					    </div>
					    <input type="submit" name="Login" id="Login" class="summitdiv" value="Login">
					<?php
					    }
					?>
                                </form>
                            </div>
			    <div id="emsg" style="height: 20px;padding-top: 6px;"></div>
			    <div class="respinv">
				<?php
				    if($_GET['resp'] =='invemail')
				       echo "Please check your email id as it is not registered in our system.";
				    elseif($_GET['resp'] =='invpassword')
				       echo "Please check your password.";
				?>
			    </div>
                            <div class="forgatediv">
                                <span class="redtextdiv"><a href="javascript:void(0);" class="redtextdiv"  onclick="javascript: _disableThisPage();_setDivPos('forgotpassword');">Forgot your password?</a></span>
                            </div>
                            <!--<div class="facebookdiv">
                                <div class="gmaildiv mt20">
                                    <a href="javascript:void(0);"><img src="<?php //echo __WEBROOT__;?>/images/facebook.png"/></a>
                                </div>
                                <div class="googlediv mt10">
                                    <a href="javascript:void(0);"><img src="<?php //echo __WEBROOT__;?>/images/google.png"/></a>
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<div id="forgotpassword">		
    <div class="loginform2">
	<!--<form id="frmLogin" name="frmLogin" action="" method="post" onsubmit="javascript: return _valsendpwd();">-->
	    <input type="hidden" id="hdnurl" name="hdnurl" value="<?php echo $_SERVER["REQUEST_URI"]; ?>"  />
	    <div class="div345">
		<a id="popupContactClose" onclick="javascript: _hideFloatingObjectWithID('forgotpassword');_enableThisPage();">x</a>
		<div class="clb"></div>
		<div class="fl">
		    <span class="centermidbdr"></span>
		    <span class="centerHeading">Avanti Learning Centres</span>
		</div>
		<div style="float: left; color:#fff;font-size: 16px; width:100%;font-family: helvetica;">Forgot Password</div>
		<div style="float: left; color:#fff; font-size: 11px;margin: 15px 0px 0px 0px;font-family: helvetica;">Your password will be sent to the email address associated with this account.</div>
		<input type="text" id="txtforgetemailid" class="Linput" name="txtforgetemailid" placeholder="user@example.com" />
		<input type="button" class="login" id="loginbtn" name="loginbtn" value="Submit" onclick="javascript: return _valsendpwd();" />
		<div id="errormsg"></div>
		<div class="fl" id="pleasewait"></div>
		<div class="fl" id="fgpassmsg"></div>
	    </div>
	<!--</form>-->
    </div>	
</div>
</html>