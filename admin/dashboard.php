<?php
	error_reporting(0);
	include("./includes/config.php");		
	include("./classes/cor.mysql.class.php");
	include("./includes/checkLogin.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title>Avanti &raquo; Dashboard </title>
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
				<div class="about clrmaroon">Dashboard</div><!-- End of about -->
				<?php if(isset($_GET["resp"]) && $_GET["resp"] !="")
				{
				?>
					<div id="ErrMsg" style="display: block;"">
						<?php
						if($_GET["resp"] == "chps")
							echo "<span style=\"color:#00A300;\">Your Password has been successfully changed.</span>";
						else if($_GET["resp"] == "nChps")
							echo "Your Credentials are invalid";
						?>
					</div>
				<?php
				}
				?>
				<div id="displayUserDB" style="margin-top:20px;">	
					<ul class="a fl" style="margin: 0px;padding: 0px;">
						<li class="fl">
							<div id="Users" class="dispdetails" style="margin-right:30px;">
								<div class="texttitle"><a href="./topic.php"><b>Topic/Resource</b></a></div><!-- end of texttitle -->
								<div id="dashUser" class="DashImages">
									<a href="./topic.php"><img src="./images/resource.png" title="Topic/Resource" alt="Topic/Resource" border="0"/> </a>
								</div><!-- end of texttitle -->
								<div><a href="./add-topic.php">Add</a> | <a href="./topic.php">Edit</a> | <a href="./topic.php">Delete</a></div>
							</div><!-- end of Users -->
						</li>
						<li class="fl">
							<div id="Users" class="dispdetails" style="margin-right:30px;">
								<div class="texttitle"><a href="./dashboard-filter.php"><b>Filters</b></a></div><!-- end of texttitle -->
								<div id="dashUser" class="DashImages">
									<a href="./dashboard-filter.php"><img src="./images/flter.jpg" title="Filters" alt="Filters" border="0"/> </a>
								</div><!-- end of texttitle -->
							</div><!-- end of Users -->
						</li>
						<li class="fl">
							<div id="Users" class="dispdetails" style="margin-right:30px;">
								<div class="texttitle"><a href="./lead-users.php"><b>User Details</b></a></div><!-- end of texttitle -->
								<div id="dashUser" class="DashImages">
									<a href="./lead-users.php"><img src="./images/userdetail.png" title="User Details" alt="User Details" border="0"/> </a>
								</div><!-- end of texttitle -->
							</div><!-- end of Users -->
						</li>
					</ul>
				</div><!-- end of displayUserDB -->
			</div><!-- end of container -->
			<?php
				include_once("./includes/sidebar.php");
			?>
			</div>
		</div><!-- end of wrapper -->
	</div><!-- end of pagecontainer -->
</div><!-- end of page -->
</body>
</html>