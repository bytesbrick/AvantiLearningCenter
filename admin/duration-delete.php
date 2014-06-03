<?php
	include_once("./includes/checkLogin.php");
	$cType = $_COOKIE["cUserType"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title> Consumer &raquo; Light The Fire  &raquo; Dashboard </title>
<?php
	include_once("./includes/head-meta.php");
	error_reporting(0);
?>
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
		$r = $db->query("stored procedure","sp_admin_duration_editS('".$_GET["cid"]."')");
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
				<div class="about"><a href="duration.php">Duration</a> &raquo; <a href="add-duration.php">Add Duration</a> &raquo; Delete Duration</div><!-- End of about -->
				<div id="displayUser" style="margin-top:20px;">
					<form method="post" name="form" id="form" action="remove-duration.php">
					<input type="hidden" name="hdCatID" id="hdCatID" value="<?php echo $r[0]['unique_id']; ?>" />
					<div class="fl ml20" style="color:red;text-align:left;">This Duration Data are Related to Resource Data..if You want to DELETE it forcefully.<br> click to continue</div>
					<div class="clr"></div>
					<div class="fl AddUserForm ml20 mt20">Duration</div>
					<div class="fl ml20 mt20"><input type="text" name="txtconsumerUp" id="txtconsumerUp" class="textbox" value="<?php echo $r[0]['duration_name']; ?>" /></div>
					<div class="clr"></div>
					<div class="fl ml30 mt20"><input type="submit" name="btnContinue" id="btnContinue" class="btnSIgn" value="Continue">
					&nbsp; &nbsp;<a href="./duration.php"><input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn" /></a></div>
					</form>
				</div><!--end of displayUser-->	
			</div><!-- end of container -->
		</div><!-- end of wrapper -->
	</div><!-- end of pagecontainer -->
</div><!-- end of page -->
<?php
		}
	}
	unset($r);
?>
</body>
</html>
