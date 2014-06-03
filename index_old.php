<?php
    //include_once("./includes/checklogin.php");
    include_once("./includes/config.php");  
    include_once("./classes/cor.mysql.class.php");
    $db = new MySqlConnection(CONNSTRING);
    $db->open();
?>
<!DOCTYPE HTML>
<html xml:lang="en" lang="en" itemscope="" itemtype="http://schema.org">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Avanti Learning Centres | Home</title>
<?php
    include_once("./includes/header-meta.php");
?>
<script type="text/javascript">
$(function(){

	//Hide SubLevel Menus
	$('#menu ul li ul').hide();

	//OnHover Show SubLevel Menus
	$('#menu ul li').hover(
		//OnHover
		function(){
			//Hide Other Menus
			$('#menu ul li').not($('ul', this)).stop();
			
			//Add the Arrow
			$('ul li:first-child', this).before(
				//'<li class="arrow">arrow</li>'
			);

			////Remove the Border
			//$('ul li.arrow', this).css('border-bottom', '0');

			// Show Hoved Menu
			$('ul', this).slideDown();
		},
		//OnOut
		function(){
			// Hide Other Menus
			$('ul', this).slideUp();

			////Remove the Arrow
			//$('ul li.arrow', this).remove();
		}
	);

});
</script>
</head>
    <body>
	<div class="mainbody">
	    <?php
		include_once("./includes/header.php");
	    ?>
                <div class="clb"></div>
		<div class="center">
		    <div style="float: left;width: 100%; margin: 115px 0px 0px 0px ;">
		    <div class="bgimg">
			<?php
			    if(!isset($_COOKIE['userID'])){
			?>
			<div clas="fl" id="login">
			    <div class="loginform">
				<form id="frmLogin" name="frmLogin" action="login.php" method="post" onsubmit="javascript: return _checkLogin();">
				    <input type="hidden" id="hdnurl" name="hdnurl" value="<?php echo $_SERVER["REQUEST_URI"]; ?>"  />
				    <input type="hidden" id="hdnresp" name="hdnresp" value="<?php echo $_GET['resp']; ?>"  />
				    <div class="div345">
					<span class="centermidbdr"></span>
					<span class="centerHeading">
					    Avanti Learning Centres
					</span>
					<input type="text" id="txtemailid" class="Linput" name="txtemailid" placeholder="user@example.com" />
					<input type="password" id="txtpassword" class="Linput" name="txtpassword" placeholder="Password" />
					<input type="submit" class="login" id="submitbtn" name="submitbtn" value="Login" />
					<a href="javascript:void(0);" class="forgotpassword" onclick="javascript: _disableThisPage();_setDivPos('forgotpassword');">Forgot password?</a>
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
			<?php
			    }
			?>
		    </div>
		    <div class="bdrmiddle"></div>
		    <span class="learnmore">Learn more</span>
		    <div class="divlearnmore">
			<div class="tolearn">
			    <a href="./results.php"><img src="./images/result.png" alt="" title="" border="0" /></a>
			    <a href="./results.php"><span class="textheading">Results</span></a><div class="clb"></div>
			    <div class="content">
				Our students a greater than two-fold improvement in the selection to the IITs and other top engineering and science programs.                   
			    </div>
			    <a href="./results.php" class="link">Learn more &gt;&gt;</a></a>
			</div>
			<div class="tolearn mrl39">
			    <a href="./pedagogy.php"><img src="./images/pedagogy.png" alt="" title="" border="0" /></a>
			    <a href="./pedagogy.php"><span class="textheading">Pedagogy</span></a><div class="clb"></div>
			    <div class="content">
				Peer learning methods developed through over 20 years of research at Harvard University form the core of how we run our classrooms.
			    </div>
			    <a href="./pedagogy.php" class="link">Learn more &gt;&gt;</a>
			</div>
			<div class="tolearn mrl39">
			    <a href="./curriculum.php"><img src="./images/curriculam.png" alt="" title="" border="0" /></a>
			    <a href="./curriculum.php"><span class="textheading">Curriculum</span></a><div class="clb"></div>
			    <div class="content">
				Our curriculum is developed by India's top IIT-JEE teachers.Our team has helped over 1,700 qualify the IIT JEE with 75  students placing in the top 100 nationally.              
			    </div>
			    <a href="./curriculum.php" class="link">Learn more &gt;&gt;</a>
			</div>
		    </div>
		</div>
		</div>
		<div class="footerindex"></div>
        </div>
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
			<div style="float: left; color:#fff;font-size: 16px; width:100%;">Forgot Password</div>
			<div style="float: left; color:#fff; font-size: 11px;margin: 15px 0px 0px 0px;">Your password will be sent to the email address associated with this account.</div>
			<input type="text" id="txtforgetemailid" class="Linput" name="txtforgetemailid" placeholder="user@example.com" />
			<input type="button" class="login" id="loginbtn" name="loginbtn" value="Submit" onclick="javascript: return _valsendpwd();" />
			<div id="errormsg"></div>
			<div class="fl" id="pleasewait"></div>
			<div class="fl" id="fgpassmsg"></div>
		    </div>
		<!--</form>-->
	    </div>	
	</div>
    </body>
</html>