<div id="popupContact">		
    <div class="loginform2">
	<form id="frmLogin" name="frmLogin" action="login.php" method="post" onsubmit="javascript: return _checkLogin();">
	    <input type="hidden" id="hdTopicID" name="hdTopicID" value=""  />
	    <input type="hidden" id="hdntopicpage" name="hdntopicpage" value="topicpage"  />
		<div class="div345">
		    <a id="popupContactClose" onclick="javascript: _hideFloatingObjectWithID('popupContact');_enableThisPage();">x</a>
		    <span class="centermidbdr"></span>
		    <span class="centerHeading">
			Avanti Learning Centres
		    </span>
		    <input type="text" id="txtemailid" class="Linput" name="txtemailid" placeholder="user@example.com" />
		    <input type="password" id="txtpassword" class="Linput" name="txtpassword" placeholder="Password" />
		    <input type="submit" class="login" id="submitbtn" name="submitbtn" value="Login" />
		    <a href="javascript:void(0);" class="forgotpassword" onclick="javascript: _disableThisPage();_setDivPos('forgotpassword');document.getElementById('popupContact').style.display = 'none';document.getElementById('popupContact').style.display = 'none';document.getElementById('forgotpassword').style.display = 'block';">Forgot password?</a>
		    <div id="emsg"></div>
		    <div class="respinv">
			<?php
			    if($_GET['resp'] =='inv')
			    echo "Please check your email id as it is not registered in our system";
			?>
		    </div>
		</div>
	</form>
    </div>	
</div>
<div id="forgotpassword" style="float: left; margin: 40px;">		
    <div class="loginform2">
    <!--<form id="frmLogin" name="frmLogin" action="login.php" method="post" onsubmit="javascript: return _valsendpwd();">-->
	<input type="hidden" id="hdnurl" name="hdnurl" value="<?php echo $_SERVER["REQUEST_URI"]; ?>"  />
	<div class="div345">
	    <a id="popupContactClose" onclick="javascript: _hideFloatingObjectWithID('forgotpassword');_enableThisPage();document.getElementById('popupContact').style.display = 'none';document.getElementById('popupContact').style.display = 'block';document.getElementById('forgotpassword').style.display = 'none';">x</a>
	    <div class="clb"></div>
	    <div class="fl">
		<span class="centermidbdr"></span>
		<span class="centerHeading">Avanti Learning Centres</span>
	    </div>
	    <div style="float: left; color:#fff;font-size: 16px; width:100%;">Forgot Password</div>
	    <div style="float: left; color:#fff; font-size: 11px;margin: 15px 0px 0px 0px;">Your password will be sent to the email address associated with this account.</div>
	    <input type="text" id="txtforgetemailid" class="Linput" name="txtforgetemailid" placeholder="user@example.com" />
	    <input type="button" class="login" id="submitbtn" name="submitbtn" value="Submit"  onclick="javascript: return _valsendpwd();" />
	    <div id="errormsg"></div>
	    <div class="fl" id="pleasewait"></div>
	    <div class="fl" id="fgpassmsg"></div>
	</div>
    <!--</form>-->
    </div>	
</div>