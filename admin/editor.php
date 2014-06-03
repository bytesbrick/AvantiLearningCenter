<?php
	error_reporting(0);
	session_start();
	include("./includes/config.php");		
	include("./classes/cor.mysql.class.php");
	include("./includes/checkLogin.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title>Avanti &raquo; Dashboard &raquo; Editors</title>
<?php
	include_once("./includes/head-meta.php");
	$curPage = $_GET["page"];
	if(($curPage == "") || ($curPage == 0))
	$curPage=1;
	$recPerpage = 25;
	$countWhereClause = "";
	$selectWhereClause = "";
	$pageParam="";
	$sqlCount = $db->query("query","select COUNT(unique_id) as 'total' from ltf_admin_usermaster");
	$recCount = $sqlCount[0]['total'];
	$noOfpage = ceil($recCount/$recPerpage);
	$limitStart = ($curPage - 1) * $recPerpage;
	$limitEnd = $recPerpage;
?>
<script type="text/javascript" language="javascript" src="./javascript/editor-user.js"></script>
</head>
<body>
<div id="page">
	<div id="pageContainer">
		<div id="wrapper">	
			<div id="header">
			<?php
				$pgName = "editors";
				include_once("./includes/header.php");
			?>
			</div><!-- End of header -->
			<div id="container">
				<div class="about">Editors</div><div class="act"><a href="add-editor.php">Add Editor</a><div id="bulkAct"><a href="javascript:void(0);" id="btnDel" onclick="javascript: _deleteEditor(-1,<?php echo $curPage; ?>);" class="ml5">Delete</a></div><div id="bulkActive"><a href="javascript:void(0);" id="activestatus" onclick="javascript: _chngEditorStatus(-1,this.id,<?php echo $curPage; ?>);" class="ml5">Active</a></div></div><!-- End of about -->
				<?php if(isset($_SESSION["resp"]) && $_SESSION["resp"] !="")
				{
				?>
					<div id="ErrMsg" style="display: block;">
						<?php
						if($_SESSION["resp"] == "err")
							echo "<span style=\"color:#00A300;\">Error while adding Lead.</span>";
						else if($_SESSION["resp"] == "succ")
							echo "Editor successfully added.";
						else if($_SESSION["resp"] == "sucdt")
							echo "Editor successfully deleted.";
						else if($_SESSION["resp"] == "up")
							echo "Editor edited successfully.";
						else if($_SESSION["resp"] == "invEd")
							echo "This editor can't be saved because this is already exit.";
						else if($_SESSION["resp"] == "invUp")
							echo "This editor can't be updated because this is already exit.";
						else if($_SESSION["resp"] == "errEd")
							echo "Error while adding User."; 
						?>
					</div>
				<?php
				}else{
				?>
					<div id="ErrMsg"></div>
				<?php
				}
				?><!-- end of ErrMsg -->
				<div id="displayUser"></div><!-- end of content -->
				<div id="disableDiv"><div id="disableText"><br /><br /><img src="./images/avn-loader.gif" /><br />Loading...</div></div>
				</div><!-- end of displayUser -->
				<?php
					include_once("./includes/sidebar.php");
					$db->close();
			?>
			</div><!-- end of container -->
		</div><!-- end of wrapper -->
	</div><!-- end of pagecontainer -->
</div><!-- end of page -->
<script type="text/javascript">
	_getEditorTable(<?php echo $curPage; ?>,'','')
</script>
</body>
</html>
<?php
	session_destroy();
?>