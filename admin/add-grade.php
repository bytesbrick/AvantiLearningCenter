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
<title>Avanti &raquo; Dashboard &raquo;Add Grade</title>
<?php
	include_once("./includes/head-meta.php");
?>
</head>
<body>
 <?php
	if(isset($_GET["cid"]))
	{
		$cid = $_GET["cid"];
		$r = $db->query("stored procedure","sp_admin_grade_editS('".$_GET["cid"]."')");
		if(!array_key_exists("response", $r)){
	 ?>
 
<div id="page">
	<div id="pageContainer">
		<div id="wrapper">	
			<div id="header">
			<?php
				$pgName = "grades";
				include_once("./includes/header.php");
			?>
			</div><!-- End of header -->
			<div id="container2">
				<div class="about2"><a href="./grade.php" class="clrmaroon fl">Grades &raquo;</a>&nbsp;Edit Grade</div><!-- End of about -->
				<div id="displayUser">
					<div id="errormsg" style="height: 12px;margin-bottom: 10px;"></div><div class="clr"></div>
					<form method="post" name="form" id="form" action="update-grade.php" onsubmit="javascript:return _validateEditgrade();">
						<input type="hidden" name="hdCatID" id="hdCatID" value="<?php echo $r[0]['unique_id']; ?>" />
						<input type="hidden" id="hdnqryStringGrade" name="hdnqryStringGrade" value="<?php echo urlencode(filter_querystring($_SERVER["QUERY_STRING"],array("cid","resp"), array("",""))); ?>">
						<div class="fl AddUserForm">Grade</div>
						<div class="fl ml20"><input type="numbers" placeholder="Grade" name="txtgradeUp" id="txtgradeUp" class="inputseacrh" value="<?php echo $r[0]['grade_name']; ?>" /></div>
						<div class="clr"></div>
						<div class="fl mt20"><input type="submit" name="btnUpdate" id="btnUpdate" class="btnSIgn" value="Update" >
						&nbsp; &nbsp;<a href="./grade.php"><input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn" /></a></div>
					</form>
				</div><!--end of displayUser-->	
			</div><!-- end of container -->
			<?php
				include_once("./includes/sidebar.php");
			?>
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
			include("./includes/config.php");		
			include("./classes/cor.mysql.class.php");
			$db = new MySqlConnection(CONNSTRING);
			$db->open();
				$pgName = "grades";
				include_once("./includes/header.php");
			?>
			</div><!-- End of header -->
			<div id="container2">
				<div class="about2"><a href="./grade.php" class="clrmaroon fl">Grades &raquo;</a>&nbsp;Add Grade</div><!-- End of about -->
				<div id="displayUser">
					<div id="errormsg" style="height: 12px;margin-bottom: 10px;"></div><div class="clr"></div>
					<form method="post" name="form2" id="form2" action="./save-grade.php" onsubmit="return _validateAddgrade();">
					<div class="fl AddUserForm">Grade</div>
					<div class="fl ml20"><input type="text" name="txtgrade" id="txtgrade" class="inputseacrh" /></div>
					<div class="clr"></div>
					<div class="fl mt20"><input type="submit" name="btnSave" id="btnSave" class="btnSIgn" value="Save">
					&nbsp; &nbsp;<a href="./grade.php"><input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn" /></a></div>
					</form>
				</div><!--end of displayUser-->	
			</div><!-- end of container -->
			<?php
				include_once("./includes/sidebar.php");
			?>
		</div><!-- end of wrapper -->
	</div><!-- end of pagecontainer -->
</div><!-- end of page -->	
 <?php
	}
	unset($r);
	$db->close();
?>
</body>
</html>
