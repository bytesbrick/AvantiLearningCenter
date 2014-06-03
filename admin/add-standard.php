<?php
	include_once("./includes/checkLogin.php");
	$cType = $_COOKIE["cUserType"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title> Light The Fire  &raquo; Dashboard </title>
<?php
	include_once("./includes/head-meta.php");
	error_reporting(0);
?>
<script>
	function validateForm()
	{
		var x=document.forms["form"]["txtstandardUp"].value;
		if (x==null || x=="")
		  {
			  alert("Standard must be filled out");
			  return false;
		  }
	}
</script>
<script>
	function validateForm2()
	{
		var y=document.forms["form2"]["txtstandard"].value;
		if (y==null || y=="")
		  {
			  alert("Standard must be filled out");
			  return false;
		  }
	}
</script>
</head>
<body>
 <?php
	if(isset($_GET["cid"]))
	{
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
			$db->open();
		$cid = $_GET["cid"];
		$r = $db->query("stored procedure","sp_admin_standards_editS('".$_GET["cid"]."')");
		if(!array_key_exists("response", $r)){
	 ?>
 
<div id="page">
	<div id="pageContainer">
		<div id="wrapper">	
			<div id="header">
			<?php
				include_once("./includes/header.php");
			?>
			</div><!-- End of header -->
			<div id="container">
				<?php
					include_once("./includes/right-menu.php");
				?>
				<div class="about"><a href="standard.php">Standard</a> &raquo; <a href="add-standard.php">Add Standard</a> &raquo; Edit Standard</div><!-- End of about -->
				<div id="displayUser" style="margin-top:20px;">
					<form method="post" name="form" id="form" action="update-standard.php" onsubmit="javascript:return validateForm()">
					<input type="hidden" name="hdCatID" id="hdCatID" value="<?php echo $r[0]['unique_id']; ?>" />
					<div class="fl AddUserForm ml20">Standard</div>
					<div class="fl ml20"><input type="text" name="txtstandardUp" id="txtstandardUp" class="textbox" value="<?php echo $r[0]['standards_desc']; ?>" /></div>
					<div class="clr"></div>
					<div class="fl ml30 mt20"><input type="submit" name="btnUpdate" id="btnUpdate" class="btnSIgn" value="Update">
					&nbsp; &nbsp;<a href="./standard.php"><input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn" /></a></div>
					</form>
				</div><!--end of displayUser-->	
			</div><!-- end of container -->
		</div><!-- end of wrapper -->
	</div><!-- end of pagecontainer -->
</div><!-- end of page -->
<?php
	}
		}
	else
	{
?>
	<div id="page">
	<div id="pageContainer">
		<div id="wrapper">	
			<div id="header">
			<?php
				include_once("./includes/header.php");
			?>
			</div><!-- End of header -->
			<div id="container">
				<?php
					include_once("./includes/right-menu.php");
				?>
				<div class="about"><a href="standard.php">Standard</a> &raquo; Add Standard</div><!-- End of about -->
				<div id="displayUser" style="margin-top:20px;">
					<form method="post" name="form2" id="form2" action="./save-standard.php" onsubmit="return validateForm2()">
					<div class="fl AddUserForm ml20">Standard</div>
					<div class="fl ml20"><input type="text" name="txtstandard" id="txtstandard" class="textbox" /></div>
					<div class="clr"></div>
					<div class="fl ml30 mt20"><input type="submit" name="btnSave" id="btnSave" class="btnSIgn" value="Save">
					&nbsp; &nbsp;<a href="./standard.php"><input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn" /></a></div>
					</form>
				</div><!--end of displayUser-->	
			</div><!-- end of container -->
		</div><!-- end of wrapper -->
	</div><!-- end of pagecontainer -->
</div><!-- end of page -->	
 <?php
	}
	unset($r);
?>
</body>
</html>
