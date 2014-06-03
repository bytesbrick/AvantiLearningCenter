<?php
	error_reporting(0);
	$UserName = $_COOKIE["cUserName"];
	$userType = $_COOKIE["cUserType"];
?>
<div id ="topmenu">
	<div id="top-part">
		 <div id="logo-part"><a href="./dashboard.php"><img src="./images/logo.png" alt="Avanti" title="Avanti" border="0"></a></div>
		 <div id="welCome">
			<span class="fl">Welcome! &nbsp;</span>
			<b><?php echo $UserName; ?></b>&nbsp;
			<div class="multimenu fr mr3">
				<img src="./images/options.png" title="More actions" class="mt3"/>
				<div class="cb"></div>
				<label class="mrlabel">
					<ul style="width: 155px;">
						<a href="./dashboard.php"><li>Dashboard</li></a>
						<a href="./password-change.php"><li>Change Password</li></a>
						<a href="./logout.php"><li>Logout</li></a>
					</ul>
				</label>
			</div>
		</div><!-- end of welCome -->
	</div><!-- end of top part -->
	<div id="insideLHS">
		<ul>
			<?php if($pgName == "curriculums") { ?>
				<li><a href="./curriculum.php" class="selected">Curriculums</a></li>
			<?php } else { ?>
				<li><a href="./curriculum.php">Curriculums</a></li>
			<?php }
			if($pgName == "subjects") { ?>
				<li><a href="./category.php" class="selected">Subjects</a></li>
			<?php } else { ?>
				<li><a href="./category.php">Subjects</a></li>
			<?php } 
			if($pgName == "chapters") { ?>
				<li><a href="./chapter.php" class="selected">Chapters</a></li>
			<?php } else { ?>
				<li><a href="./chapter.php">Chapters</a></li>
			<?php } 
			if($pgName == "topics") { ?>
				<li><a href="./topic.php" class="selected">Topics</a></li>
			<?php } else { ?>
				<li><a href="./topic.php">Topics</a></li>
			<?php } 
			if($pgName == "grades") { ?>
				<li><a href="./grade.php" class="selected">Grade Levels</a></li>
			<?php } else { ?>
				<li><a href="./grade.php">Grade Levels</a></li>
			<?php } 
			if($pgName == "tags") { ?>
				<li><a href="./tag.php" class="selected">Tags</a></li>
			<?php } else { ?>
				<li><a href="./tag.php">Tags</a></li>
			<?php } ?>
			<?php
			if($pgName == "users") { ?>
				<li><a href="./lead-users.php" class="selected">Users</a></li>
			<?php } else { ?>
				<li><a href="./lead-users.php">Users</a></li>
			<?php } ?>
			<?php
			if($pgName == "editors") { ?>
				<li><a href="./editor.php" class="selected">Editors</a></li>
			<?php } else { ?>
				<li><a href="./editor.php">Editors</a></li>
			<?php } ?>
		</ul>
	</div>
</div> <!-- end of topmenu-->
	<div id="changePassword" class="floatDiv">
		<div id="cross"><a href="javascript: void(0);" onclick="javascript: _hideFloatingObjectWithID('changePassword');_enableThisPage();"><img src="./images/close.png" alt="Close" title="Close" border="0" /></a></div>
		<form name="form1" id="form1" method="POST" action="./change-password.php" onsubmit="return _chkAllSet();">
		<input type="hidden" name="hdChPCheck" id="hdChPCheck" value="0" />
			<div id="chLoginform">
				<div class="formRow">
					<b class="heading">Change Password</b>
				</div>
				<div id="pwderr" class="err" style="float:left;"></div>
				<div class="formRow">
					<span class="txtlabel">Current Password</span>
					<input type="password" name="txtOpwd" onblur="javascript: _checkPassword();" id="txtOpwd" class="chtxtbox" />
				</div>
				<div class="formRow">
					<span class="txtlabel">New Password</span>
					<input type="password" name="txtNpwd" id="txtNpwd" class="chtxtbox" disabled/>
				</div>
				<div class="formRow">
					<span class="txtlabel">Confirm Password</span>
					<input type="password" name="txtCpwd" id="txtCpwd" class="chtxtbox" disabled/>
				</div>
				<div class="formRow">
					<input type="submit" name="btnPassword" id="btnPassword"  value="Change Password" class="btnSIgn" style="width:150px" tabindex="4" />
					<input type="reset" name="btnClose" id="btnClose" value="Reset" class="btnSIgn" tabindex="5" /><br /><br />
				</div>
			</div>
		</form>
</div><!-- end of changePassword -->