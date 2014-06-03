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
<title>Avanti &raquo; Dashboard &raquo; Add Tag</title>
<?php
	include_once("./includes/head-meta.php");
?>
<script>
	function validateForm()
	{
		var x=document.forms["form"]["txttagUp"].value;
		if (x==null || x=="")
		  {
			  alert("Tag must be filled out");
			  return false;
		  }
	}
</script>
<script>
	function validateForm2()
	{
		var y=document.forms["form2"]["txttag"].value;
		if (y==null || y=="")
		  {
			  alert("Tag must be filled out");
			  return false;
		  }
	}
</script>
</head>
<body>
 <?php
	if(isset($_GET["cid"]))
	{
		$db->open();
		$cid = $_GET["cid"];
		$curPage = $_GET["page"];
		$r = $db->query("stored procedure","sp_admin_tag_editS('".$_GET["cid"]."')");
		if(!array_key_exists("response", $r)){
	 ?>
 
<div id="page">
	<div id="pageContainer">
		<div id="wrapper">	
			<div id="header">
			<?php
				$pgName = "tags";
				include_once("./includes/header.php");
			?>
			</div><!-- End of header -->
			<div id="container2">
				<div class="about2"><a href="./tag.php" class="clrmaroon fl">Tags &raquo;</a>&nbsp;Edit Tag</div><!-- End of about -->
				<div id="displayUser">
					<div id="errormsg" style="height: 12px;margin-bottom: 10px;"></div><div class="clr"></div>
					<form method="post" name="form" id="form" action="update-tag.php" onsubmit="javascript:return _validateEditTag();">
					<input type="hidden" name="hdCatID" id="hdCatID" value="<?php echo $r[0]['unique_id']; ?>" />
					<input type="hidden" name="hdstringTag" id="hdstringTag" value="<?php echo urlencode(filter_querystring($_SERVER["QUERY_STRING"],array("cid","page"),array("",$curPage))); ?>" />
					<div class="fl AddUserForm">Tag</div>
					<div class="fl ml20"><input type="text" placeholder="Tag" name="txttagUp" id="txttagUp" class="inputseacrh" value="<?php echo $r[0]['tag_name']; ?>" /></div>
					<div class="clr"></div>
					<div class="fl mt20"><input type="submit" name="btnUpdate" id="btnUpdate" class="btnSIgn" value="Update">
					&nbsp; &nbsp;<a href="./standard.php"><input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn" /></a></div>
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
				$pgName = "tags";
				include_once("./includes/header.php");
			?>
			</div><!-- End of header -->
			<div id="container2">
				<div class="about2"><a href="./tag.php" class="clrmaroon fl">Tags &raquo;</a>&nbsp;Add Tag</div><!-- End of about -->
				<div id="displayUser">
					<div id="errormsg" style="height: 12px;margin-bottom: 10px;"></div><div class="clr"></div>
					<form method="post" name="form2" id="form2" action="./save-tag.php" onsubmit="return _validateAddTag();">
					<div class="fl AddUserForm">Tag</div>
					<div class="fl ml20"><input type="text" name="txttag" id="txttag" class="inputseacrh" /></div>
					<div class="clr"></div>
					<div class="fl mt20"><input type="submit" name="btnSave" id="btnSave" class="btnSIgn" value="Save">
					&nbsp; &nbsp;<a href="./tag.php"><input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn" /></a></div>
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
?>
</body>
</html>
