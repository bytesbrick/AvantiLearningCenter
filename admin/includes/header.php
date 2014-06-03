<?php
	error_reporting(0);
	$UserName = $arrUserInfo["firstname"];
	$UserType =  $arrUserInfo["usertype"];
?>
<div id ="topmenu">
	<div id="header">
		<div class="logodiv">
			<a href="./dashboard.php">
				<img border="0" title="Avanti" alt="Avanti" src="./images/logo.png" />
			</a>
		</div>
		<div id="welCome">
			<span class="fl">Welcome! &nbsp;</span>
			<b><?php echo $UserName; ?></b>&nbsp;
			<div class="welcomemenu fr mr3">
				<img src="./images/down_arrow-10px.png" title="" class="mrg" border="0" />
				<div class="cb"></div>
				<label>
					<ul style="width: 155px;">
						<a href="./dashboard.php"><li>Dashboard</li></a>
						<a href="./password-change.php"><li>Change Password</li></a>
						<a href="./logout.php"><li>Logout</li></a>
					</ul>
				</label>
			</div>
		</div><!-- end of welCome -->
		<?php
			if($UserType == "Teacher"){
		?>
				<div id="menu" class="first">
					<ul>
						<li id="administration" class="first">
							<table cellpadding="0" cellspacing="0" border="0" width="100%">
								<tr>
									<td style="text-align: center"><a href="javascript:void(0);">Administration</a></td>
								</tr>
								<tr>
									<td style="text-align: center"><img src="./images/down_arrow-10px.png" title="" class="mrg" border="0" /></td>
								</tr>
							</table>
							<div class="cb"></div>
							<label class="mrlabel">
								<ul>
									<!--<li class="first"><a href="./teacher.php">Teacher</a></li>
									<li><a href="./manager.php">Center Manager</a></li>-->
									<li><a href="./student.php">Student</a></li>
									<!--<li><a href="./batch.php">Batch</a></li>-->
									<!--<li><a href="./editor.php">Admin User</a></li>
									<li><a href="./city.php">City</a></li>-->
									<!--<li class="last"><a href="./learning-center.php">Learning Center</a></li>-->
								</ul>
							</label>
						</li>
					</ul>
				</div>
		<?php
			}
			if($UserType == "Manager"){
		?>
				<div id="menu" class="first">
					<ul>
						<li id="administration" class="first">
							<table cellpadding="0" cellspacing="0" border="0" width="100%">
								<tr>
									<td style="text-align: center"><a href="javascript:void(0);">Administration</a></td>
								</tr>
								<tr>
									<td style="text-align: center"><img src="./images/down_arrow-10px.png" title="" class="mrg" border="0" /></td>
								</tr>
							</table>
							<div class="cb"></div>
							<label class="mrlabel">
								<ul>
									<!--<li class="first"><a href="./teacher.php">Teacher</a></li>
									<li><a href="./manager.php">Center Manager</a></li>
									<li><a href="./student.php">Student</a></li>-->
									<li><a href="./batch.php">Batch</a></li>
									<!--<li><a href="./editor.php">Admin User</a></li>
									<li><a href="./city.php">City</a></li>-->
									<li class="last"><a href="./learning-center.php">Learning Center</a></li>
								</ul>
							</label>
						</li>
					</ul>
				</div>
		<?php
			}
			if($UserType == "Administrator"){
		?>
		<div id="menu">
			<ul>
				<li id="administration" class="first">
					<table cellpadding="0" cellspacing="0" border="0" width="100%">
						<tr>
							<td style="text-align: center"><a href="javascript:void(0);">Administration</a></td>
						</tr>
						<tr>
							<td style="text-align: center"><img src="./images/down_arrow-10px.png" title="" class="mrg" border="0" /></td>
						</tr>
					</table>
					<div class="cb"></div>
					<label class="mrlabel">
						<ul>
							<li class="first"><a href="./teacher.php">Teacher</a></li>
							<li><a href="./manager.php">Center Manager</a></li>
							<li><a href="./student.php">Student</a></li>
							<li><a href="./batch.php">Batch</a></li>
							<li><a href="./editor.php">Admin User</a></li>
							<li><a href="./city.php">City</a></li>
							<li class="last"><a href="./learning-center.php">Learning Center</a></li>
						</ul>
					</label>
				</li>
				<li id="content">
					<table cellpadding="0" cellspacing="0" border="0" width="100%">
						<tr>
							<td style="text-align: center"><a href="javascript:void(0);">Content</a></td>
						</tr>
						<tr>
							<td style="text-align: center"><img src="./images/down_arrow-10px.png" title="" class="mrg" border="0" /></td>
						</tr>
					</table>
					<div class="cb"></div>
					<label class="mrlabel">
						<ul>
							<li class="first"><a href="curriculum.php">Curriculum</a></li>
							<li><a href="./category.php">Subjects</a></li>
							<li><a href="./chapter.php">Chapters</a></li>
							<li class="last"><a href="./topic.php">Topics</a></li>
						</ul>
					</label>
				</li>
				<li id="others" class="last">
					<table cellpadding="0" cellspacing="0" border="0" width="100%">
						<tr>
							<td style="text-align: center"><a href="javascript:void(0);">Others</a></td>
						</tr>
						<tr>
							<td style="text-align: center"><img src="./images/down_arrow-10px.png" title="" class="mrg" border="0" /></td>
						</tr>
					</table>
					<div class="cb"></div>
					<label class="mrlabel">
						<ul>
							<li class="first"><a href="./grade.php">Grade Levels</a></li>
							<li class="last"><a href="./tag.php">Tags</a></li>
						</ul>
					</label>
				</li>
			</ul>  
		</div>
		<?php
			}
		?>
	</div>
</div><!-- end of topmenu-->