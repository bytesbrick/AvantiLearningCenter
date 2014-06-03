<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <link href="./css/login.css" type="text/css" rel="stylesheet" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    <title>Login | Avanti Learning Centres</title>
</head>
<body>
    <div id="page">
        <div id="centerbox" class="centered">
            <div id="forgotpassword">
              <!--  <div><img src="./images/header.png" width="565px" border="0" /></div>-->
                <div id="loginbox" style="height: 270px;">
                     <a id="popupContactClose" onclick="javascript: _hideFloatingObjectWithID('forgotpassword');_enableThisPage();">x</a>
                     <input type="hidden" id="hdnurl" name="hdnurl" value="<?php echo $_SERVER["REQUEST_URI"]; ?>"  />
                    <div id="signinbox" style="height: 270px;">
                        <div class="forgetpasswordDiv">
                            <div class="ml7">
                                <span class="shead ftb clrmaroon">Forget Password?</span>
                            </div>
                            <div class="lgrow">
                                <div class="texttosendmail">Your password will be sent to the email address associated with this account.</div>
                                <input type="hidden" id="hdnurl" name="hdnurl" value="<?php echo $_SERVER["REQUEST_URI"]; ?>"  />
                                <span class="lgctrl">Email ID</span>
                            </div>
                            <div class="lgrow2">
                                <span class="lgctrl"><input type="text" id="txtforgetemailid" name="txtforgetemailid" placeholder="user@example.com" class="inputseacrh txt279" size="30" value="" maxlength="60" /></span>
                            </div>
                            <div class="diverror">
                                <div id="pleasewait" style="display: block;"></div>
				<div class="fl" id="pleasewait"></div>
				<div class="fl" id="fgpassmsg"></div>
                            </div>
                            <div class="lgrow mt10" style="width: 88%;">
                                <span class="sbtn">
                                    <input id="loginbtn" class="btn w100 fr" type="button" value="Submit" name="loginbtn" onclick="javascript: return _valsendpwd();" />
                                </span>
                            </div>
                        </div>
                    </div>
                    <div id="signupbox">
                        <div class="pad10">
                            <div>
                                <span class="shead tac">Avanti Learning Centres</span>
                            </div>
                            <div class="lgrow stext tac mt25">
                                <br />
                                <img src="./images/newavantilogo.png" width="200px" border="0" alt="Avanti Learning Centres" title="Avanti Learning Centres" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>