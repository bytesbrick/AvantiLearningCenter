<?php
       error_reporting(0);
	include_once("./includes/checkLogin.php");
	$cType = $_COOKIE["cUserType"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title> Avanti &raquo; Dashboard </title>
<?php
	include_once("./includes/head-meta.php");
?>
</head>
<body>
<div id="page">
	<div id="pageContainer">
		<div id="wrapper">	
			<div id="header">
			<?php
				include_once("./includes/header.php");
			?>
			</div><!-- End of header -->
			<div id="container">
				<div class="about"><a href="./dashboard.php">Dashboard</a> &raquo; Filter Dashboard</div><!-- End of about -->
				<div id="ErrMsg" style="margin:0px !important;">
					<?php
					if($_GET["resp"] == "chps")
						echo "<span style=\"color:#00A300;\">Your Password has been successfully changed.</span>";
					else if($_GET["resp"] == "nChps")
						echo "Your Credentials are invalid";
					?>
				</div>
				<div id="displayUserDB" style="margin-top:20px;">	
						<ul class="a ml-30">
							<li class="fl">
								<div id="Users" class="dispdetails" style="margin-right:30px;">
								<div class="texttitle"><a href="./tag.php"><b>Curriculum</b></a>
								</div><!-- end of texttitle -->
								<div id="dashUser" class="DashImages">
								<a href="./curriculum.php"><img src="./images/standard.gif" title="curriculum" alt="curriculum" border="0"/> </a>
							</div><!-- end of texttitle -->
							<div><a href="./add-curriculum.php">Add</a> | <a href="./curriculum.php">Edit</a></div>
							</div><!-- end of Users -->
							</li>
							<li class="fl">
								<div id="Users" class="dispdetails" style="margin-right:30px;">
								<div class="texttitle"><a href="./category.php"><b>Subject</b></a>
								</div><!-- end of texttitle -->
								<div id="dashUser" class="DashImages">
								<a href="./category.php"><img src="./images/subject.jpg" title="Subject" alt="Subject" border="0"/> </a>
							</div><!-- end of texttitle -->
							<div><a href="./add-category.php">Add</a> | <a href="./category.php">Edit</a> | <a href="./category.php">Delete</a></div>
							</div><!-- end of Users -->
							</li>
							<li class="fl">
								<div id="Users" class="dispdetails" style="margin-right:30px;">
								<div class="texttitle"><a href="./tag.php"><b>Chapter</b></a>
								</div><!-- end of texttitle -->
								<div id="dashUser" class="DashImages">
								<a href="./chapter.php"><img src="./images/standard.gif" title="chapter" alt="chapter" border="0"/> </a>
							</div><!-- end of texttitle -->
							<div><a href="./add-chapter.php">Add</a> | <a href="./chapter.php">Edit</a></div>
							</div><!-- end of Users -->
							</li>
							<li class="fl">
								<div id="Users" class="dispdetails" style="margin-right:30px;">
								<div class="texttitle"><a href="./tag.php"><b>Topics</b></a>
								</div><!-- end of texttitle -->
								<div id="dashUser" class="DashImages">
								<a href="./topic.php"><img src="./images/topic.gif" title="tags" alt="tags" border="0"/> </a>
							</div><!-- end of texttitle -->
							<div><a href="./add-topic.php">Add</a> | <a href="./topics.php">Edit</a></div>
							</div><!-- end of Users -->
							</li>
							<li class="fl">
								<div id="Users" class="dispdetails" style="margin-right:30px;">
								<div class="texttitle"><a href="./grade.php"><b>Grade Level</b></a>
								</div><!-- end of texttitle -->
								<div id="dashUser" class="DashImages">
								<a href="./grade.php"><img src="./images/grade.gif" title="Grade Level" alt="Grade Level" border="0"/> </a>
							</div><!-- end of texttitle -->
							<div><a href="./add-grade.php">Add</a> | <a href="./grade.php">Edit</a> | <a href="./grade.php">Delete</a></div>
							</div><!-- end of Users -->
							</li>
							</li><li class="fl">
								<div id="Users" class="dispdetails" style="margin-right:30px;">
								<div class="texttitle"><a href="./tag.php"><b>Tags</b></a>
								</div><!-- end of texttitle -->
								<div id="dashUser" class="DashImages">
								<a href="./tag.php"><img src="./images/tag.gif" title="tags" alt="tags" border="0"/> </a>
							</div><!-- end of texttitle -->
							<div><a href="./add-tag.php">Add</a> | <a href="./tag.php">Edit</a></div>
							</div><!-- end of Users -->
							</li>
							
							
							
						</ul>
					</div><!-- end of Home -->
				</div><!-- end of displayUser -->
			</div><!-- end of container -->
		</div><!-- end of wrapper -->
	</div><!-- end of pagecontainer -->
</div><!-- end of page -->
</body>
</html>
