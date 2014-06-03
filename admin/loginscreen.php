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
            <div id="login">
              <!--  <div><img src="./images/header.png" width="565px" border="0" /></div>-->
                <div id="loginbox">
                     <a id="popupContactClose" onclick="javascript: _hideFloatingObjectWithID('login2');_enableThisPage();">x</a>
                     <input type="hidden" id="hdnurl" name="hdnurl" value="<?php echo $_SERVER["REQUEST_URI"]; ?>"  />
                    <div id="signinbox">
                        <div style="float: left;margin:  0px 0px 0px 5px;width: 88%;">
                            <div style="margin:0px 0px 0px 7px;">
                                <span class="shead ftb clrmaroon">Forget Password?</span>
                            </div>
                            <div id="ErrMsg">
                                <?php
                                    //if($_GET["resp"] == "inv")
                                    //    echo "Invalid User ID and Password.";
                                    //else if($_GET["resp"] == "O")
                                    //    echo "Your are successfully logout.";
                                    //else if($_GET["resp"] == "noinpt")
                                    //    echo "Please enter your userid and password.";
                                ?>
                            </div>
                            <div>
                                <div id="dError" name="dError" class="err"></div>
                            </div>
                            <div class="lgrow">
                                <input type="hidden" id="hdnurl" name="hdnurl" value="<?php echo $_SERVER["REQUEST_URI"]; ?>"  />
                                <span class="lgctrl">Email ID</span>
                            </div>
                            <div class="lgrow2">
                                <span class="lgctrl"><input type="text" id="txtforgetemailid" name="txtforgetemailid" class="textbox txt270" size="30" value="" maxlength="60" /></span>
                            </div>
                            <div class="lgrow">
                                <div class="texttosendmail" style="font-size: 11px;color: #a74242;margin: 0px 0px 0px 7px;">Your password will be sent to the email address associated with this account.</div>
                                <!--<span class="sbtn">
                                  <!--  <button id="btnSignIn" class="btn w100 fr"><span class="signin">Submit</span></button>-->
                                   <!-- <input type="button" class="btn" id="loginbtn" name="loginbtn" value="Submit" onclick="javascript: return _valsendpwd();" />
                                </span>-->
                                <div class="lgrow">
                                    <span class="sbtn">
                                        <input id="loginbtn" class="btn w100 fl ml10" type="button" value="Submit" name="loginbtn" onclick="javascript: return _valsendpwd();" />
                                    </span>
                                </div>
                            </div>
                            <div class="lgrow">&nbsp;
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
    <div id="lgprocess" class="fdiv inv">
        <img src="./images/wait.gif" border="0" alt="" title="" id="wait" /><br />
    </div>
</body>
</html>