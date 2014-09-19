<?php
   error_reporting(0);
   include_once("./includes/config.php");
   include("./classes/cor.mysql.class.php");
   $db = new MySqlConnection(CONNSTRING);
   $db->open();
?>
<html xml:lang="en" lang="en" itemscope="" itemtype="http://schema.org">
<head>
<title>Avanti Learning Centres | Home</title>
<link rel="stylesheet" type="text/css" href="<?php echo __WEBROOT__; ?>/css/home-style.css" />
<script src="<?php echo __WEBROOT__; ?>/js/_bb_general_v3.js?v=<?php echo mktime(); ?>"></script>
<script src="<?php echo __WEBROOT__; ?>/js/validation.js?v=<?php echo mktime(); ?>"></script>
<script type="text/javascript" src="<?php echo __WEBROOT__; ?>/js/ajax.js"></script>
<script type="text/javascript" src="<?php echo __WEBROOT__; ?>/js/_bb_disablepage.js"></script>
<script type="text/javascript" src="<?php echo __WEBROOT__; ?>/js/_bb_elmpos.js"></script>
</head>
<body>
    <div class="mainbody">
      <div class="headerdiv">
         <div id="header">
            <div class="avantilogodiv">
                <a href="javascript:void(0);"><img src="<?php echo __WEBROOT__ ?>/images/avanti.png" border="0" alt="Avanti" title="Avanti" class="logo-img" /></a>
            </div>
           <div id="menu">
               <ul>
		  <li><a href="javascript:void(0);">ABOUT US</a></li>
		  <li><a href="javascript:void(0);">COURSES</a></li>
		  <li><a href="javascript:void(0);">ACADEMIC ASSOCIATIONS</a></li>
		  <li><a href="javascript:void(0);">GET IN TOUCH</a></li>
               </ul>
            </div>
        </div>
      </div>
        <div class="yellowbg">
         <div class="middiv">
            <div class="learningcenter">
               <div class="centerlogin">
                  <div class="learningText">
                     <span class="fl">LEARNING BETTER <br />TOGETHER</span> <div class="clearboth"></div>
                     <div class="welcometext">Welcome to PeerLearning.com.</div>
                     <div class="clearboth"></div>
                     <div class="divportal">This Portal is exclusively available to Students enrolled at Avanti's Learning centers across india.To learn more please visit our corporate website.</div>
                  </div>
                  <div class="res-div">
                     <div class="dologin">
			<span class="pdb">Sign in to continue</span>
			<form name="formlogin" id="formlogin" method="post" action="login.php" onsubmit="javascript: return _checkLogin();">
			   <span class="pdb">
			      <input class="textbox" type="text" name="txtemailid" id="txtemailid" placeholder="Email Address" />
			   </span>
			   <span class="pdb">
			      <input class="textbox" type="password" name="txtpassword" id="txtpassword" placeholder="Password" />
			   </span>
			   <span class="pdb">
			      <input class="btnSignIn" type="submit" name="btnSignIn" id="btnSignIn" value="Sign In"/>
			   </span>
			   <span class="fgtpsd"><a href="javascript:void(0);"onclick="javascript: _disableThisPage();_setDivPos('forgotpassword');">Forgot Your Password ?</a></span>
			</form>
			<?php
			   if(isset($_GET['resp']) && $_GET['resp'] != ""){
			     if($_GET['resp'] =='invemail'){
			?>
			   <div id="emsg">Please check your email id as it is not registered in our system.</div>
			<?php
			     }
			      else if($_GET['resp'] =='invpassword')  {	
			?>
			      <div id="emsg">Please check your password.</div>
			<?php
			      }
			   }else{
			?>
			   <div id="emsg"></div>
			<?php
			   }
			?>
			   </div>
		     </div>
                  </div>
               </div>
               <div class="onlinecourses">
                  <!--<span class="online">Online Courses</span>
                  <div class="onlinetopic">
		     <?php
			$selLatesttopics = "SELECT lcm.category_name,tm.unique_id,tm.topic_name,tm.topic_image,tm.topic_code FROM avn_topic_master tm INNER JOIN avn_chapter_master cm ON cm.unique_id = tm.chapter_id INNER JOIN ltf_category_master lcm ON lcm.unique_id = cm.category_id WHERE tm.status = 1 ORDER BY tm.unique_id DESC LIMIT 0,3";
			$selLatesttopicsRS = $db->query("query", $selLatesttopics);
			if(!array_key_exists("response", $selLatesttopicsRS)){
			   $count = count($selLatesttopicsRS);
			   for($i = 0; $i < count($selLatesttopicsRS); $i++){
			      if(($i + 1) % 3 == 0)
				 $class = " mrb";
			      else
				 $class = " mrtb";
		     ?>
			      <div class="topicnew<?php echo $class; ?>">
				 <div class="topictext">
				    <span class="fl"><a href="javascript:void(0);"><img src="<?php echo __WEBROOT__ ?>/admin/images/upload-image/<?php echo $selLatesttopicsRS[$i]["topic_image"]; ?>" width="298" height="144" border="0" class="borderradius"/></a></span>
				    <span class="topicname"><?php echo $selLatesttopicsRS[$i]["topic_name"]; ?></span>
				    <div class="topicinfo">
				       <ul>
					  <li><a href="javascript:void(0);"><?php echo $selLatesttopicsRS[$i]["topic_code"]; ?></a>&nbsp;|&nbsp;</li>
					  <li><a href="javascript:void(0);"><?php echo $selLatesttopicsRS[$i]["topic_name"]; ?></a></li>
				       </ul>
				       <div class="clearboth"></div>
				       <span class="date"><?php echo $selLatesttopicsRS[$i]["category_name"]; ?></span>
				    </div>
				 </div>
			      </div>
                    <?php
			   }
			   unset($selLatesttopicsRS);
			}
			$db->close();
		    ?>
	       </div>-->
               </div>
                <div id="footer">
                  <div id="footermenu">
		     <ul>
			<li><a href="javascript:void(0);">ABOUT US</a></li>
			<li><a href="javascript:void(0);">COURSES</a></li>
			<li><a href="javascript:void(0);">ACADEMIC ASSOCIATIONS</a></li>
			<li><a href="javascript:void(0);">GET IN TOUCH</a></li>
		     </ul>
                     <span class="copyright" >Copyright &copy Avanti Fellows 2014.All rights reserved.</span>
                  </div>
              </div>
            </div>
         </div>
      </div>
   </div>
</body>
<div id="forgotpassword">		
   <div class="loginform2">
      <input type="hidden" id="hdnurl" name="hdnurl" value="<?php echo $_SERVER["REQUEST_URI"]; ?>"  />
      <div class="div345">
	 <a id="popupContactClose" onclick="javascript: _hideFloatingObjectWithID('forgotpassword');_enableThisPage();"><img src="<?php echo __WEBROOT__ ?>/images/close.png" border="0" alt="Avanti" title="Avanti" width="32" /></a>
	 <div class="clb"></div>
	 <div class="fl">
	    <span class="centermidbdr"></span>
	    <span class="centerHeading">Avanti Learning Centres</span>
	 </div>
	 <div class="forgotText">Forgot Password</div>
	 <div class="emailtext">Your password will be sent to the email address associated with this account.</div>
	 <input type="text" id="txtforgetemailid" class="Linput" name="txtforgetemailid" placeholder="user@example.com" />
	 <input type="button" class="login" id="loginbtn" name="loginbtn" value="Submit" onclick="javascript: return _valsendpwd();" />
	 <div id="errormsg"></div>
	 <div class="fl" id="pleasewait"></div>
	 <div class="fl" id="fgpassmsg"></div>
      </div>
   </div>	
</div>
</html>