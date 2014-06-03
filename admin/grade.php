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
<title>Avanti &raquo; Dashboard &raquo; Grades</title>
<?php
	include_once("./includes/head-meta.php");
?>
<script type="text/javascript" language="javascript" src="./javascript/grade.js"></script>
</head>
<body>
<div id="page">
	<div id="pageContainer">
		<div id="wrapper">	
			<div id="header">
			<?php
				include_once("./includes/header.php");
				
				$pgName = "tags";
				
				$curPage = $_GET["page"];
				if(($curPage == "") || ($curPage == 0))
					$curPage=1;
				$recPerpage = 25;
				$countWhereClause = "";
				$selectWhereClause = "";
				$pageParam="";
				$sqlCount = $db->query("query","select count(unique_id) as 'total' from ltf_grade_level_master");
				$recCount = $sqlCount[0]['total'];
				$noOfpage = ceil($recCount/$recPerpage);
				$limitStart = ($curPage - 1) * $recPerpage;
				$limitEnd = $recPerpage;
				$where = "";
				$sort = "DESC";
				$field = "lglm.unique_id";
				if(isset($_GET["sf"]) && $_GET["sf"] != "")
					$field = $_GET["sf"];
				if(isset($_GET["sd"]) && $_GET["sd"] != "")
					$sort = $_GET["sd"];
			?>
			</div><!-- End of header -->
			<div id="container">
				<div class="about">Grades</div><div class="act"><a href="add-grade.php">Add Grade</a><div id="bulkAct"><a href="javascript:void(0);" id="btnDel" onclick="javascript: _deletegrade(-1,<?php echo $curPage; ?>);" class="ml5">Delete</a></div></div><!-- End of about -->
				<?php if(isset($_SESSION["resp"]) && $_SESSION["resp"] !=""){
				?>
					<div id="ErrMsg" style="display: block;">
						<?php
						if($_SESSION["resp"] == "err")
							echo "<span style=\"color:#00A300;\">Error while adding Lead.</span>";
						else if($_SESSION["resp"] == "suc")
							echo "Grade successfully added";
						else if($_SESSION["resp"] == "sucdt")
							echo "Grade successfully deleted";
						else if($_SESSION["resp"] == "inv")
							echo "Blank fields are not allowed";
						else if($_SESSION["resp"] == "up")
							echo "Grade edited successfully";
						else if($_SESSION["resp"] == "invEd")
							echo "This Grade Cant Not Be Save because this is Already exit";
						else if($_SESSION["resp"] == "invUp")
							echo "This Grade Cant Not Be Updated because this is Already exit";
						else if($_SESSION["resp"] == "errEd")
							echo "Error while editing leads"; 
						?>
					</div>
				<?php
				}else{
				?>
					<div id="ErrMsg"></div>
				<?php
				}
				?><!-- end of ErrMsg -->
				<div id="displayUser"></div>
				<div id="disableDiv"><div id="disableText"><br /><br /><img src="./images/avn-loader.gif" /><br />Loading...</div></div>
			</div><!-- end of container -->
			<?php
				include_once("./includes/sidebar.php");
				$db->close();
			?>
		</div><!-- end of wrapper -->
	</div><!-- end of pagecontainer -->
</div><!-- end of page -->
<script type="text/javascript">
	_getGradeTable(<?php echo $curPage; ?>, '', '')
</script>
</body>
</html>
<?php
	session_destroy();
?>