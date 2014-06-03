<?php
	include_once("./includes/checkLogin.php");
	$cType = $_COOKIE["cUserType"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title>Avanti &raquo; Dashboard &raquo; Add-Subject</title>
<?php
	include_once("./includes/head-meta.php");
	error_reporting(0);
	include_once("./includes/config.php");		
	include("./classes/cor.mysql.class.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
?>
<script>
function validateForm()
{
var y=document.forms["form"]["txtcategoryUp"].value;
if (y==null || y=="")
  {
  alert("Subject must be filled out");
  return false;
  }
}
</script>
<script>
function validateForm2()
{
var x=document.forms["form2"]["txtcategory"].value;
if (x==null || x=="")
  {
  alert("Subject must be filled out");
  return false;
  }
}
</script>
</head>
<body>
 <?php
	if(isset($_GET["cid"]))
	{
		$cid = $_GET["cid"];
		$r = $db->query("stored procedure","sp_admin_category_editS('".$_GET["cid"]."')");
		if(!array_key_exists("response", $r))
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
				<div class="about"><a href="category.php">Subject</a> &raquo;&nbsp;<a href="add-category.php">Add Subject</a> &raquo; Edit Subject</div><!-- End of about -->
				<div id="displayUser" style="margin-top:20px;">
					<form method="post" name="form" id="form" action="update-category.php" onsubmit="javascript:return validateForm()">
					<input type="hidden" name="hdCatID" id="hdCatID" value="<?php echo $r[0]['unique_id']; ?>" />
					<div class="fl AddUserForm ml20">Subject</div>
					<div class="fl ml20"><input type="text" name="txtcategoryUp" id="txtcategoryUp" class="textbox" value="<?php echo $r[0]['category_name']; ?>" /></div>
					<div class="clr"></div>
					<div class="fl ml30 mt20"><input type="submit" name="btnUpdate" id="btnUpdate" class="btnSIgn" value="Update">
					&nbsp; &nbsp;<a href="./category.php"><input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn" /></a></div>
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
				<div class="about"><a href="category.php">Subject</a> &raquo; Add Subject</div><!-- End of about -->
				<div id="displayUser">
					<form method="post" name="form2" id="form2" action="./save-category.php" onsubmit="return validateForm2()">
					<div class="fl AddUserForm ml20">Subject</div>
					<div class="fl ml20"><input type="text" name="txtcategory" id="txtcategory" class="textbox" /></div>
					<div class="clr"></div>
					<div class="fl ml30 mt20"><input type="submit" name="btnSave" id="btnSave" class="btnSIgn" value="Save">
					&nbsp; &nbsp;<a href="./category.php"><input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn" /></a></div>
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
