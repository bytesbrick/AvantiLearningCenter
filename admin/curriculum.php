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
<title>Avanti &raquo; Dashboard &raquo; Curriculums</title>
<?php
	include_once("./includes/head-meta.php");
	$curPage = $_GET["page"];
	if(($curPage == "") || ($curPage == 0))
		$curPage=1;
	$recPerpage = 25;
	$countWhereClause = "";
	$selectWhereClause = "";
	$pageParam="";
	$sqlCount = $db->query("query","select count(unique_id) as 'total' from avn_curriculum_master");
	$recCount = $sqlCount[0]['total'];
	$noOfpage = ceil($recCount/$recPerpage);
	$limitStart = ($curPage - 1) * $recPerpage;
	$limitEnd = $recPerpage;
	
	$sort = "DESC";
	$field = "acm.unique_id";
	if(isset($_GET["sf"]) && $_GET["sf"] != "")
	    $field = $_GET["sf"];
	if(isset($_GET["sd"]) && $_GET["sd"] != "")
	    $sort = $_GET["sd"];
?>

<script type="text/javascript" language="javascript" src="./javascript/curriculum.js"></script>
<script type="text/javascript" src="./javascript/jquery.js"></script>
<script type="text/javascript" src="./javascript/jquery/1.5.1/jquery.min.js"></script>
<!--  For Calender -->
<link rel="stylesheet" href="./css/jquery.ui.datepicker.css" />
<link rel="stylesheet" href="./css/jquery.ui.theme.css" />
<script src="./javascript/jquery.ui.core.js" type="text/javascript"></script>
<script src="./javascript/jquery.ui.datepicker.js" type="text/javascript"></script>
</head>
<body>
<div id="page">
	<div id="pageContainer">
		<div id="wrapper">	
			<div id="header">
			<?php
				$pgName = "curriculums";
				include_once("./includes/header.php");
			?>
			</div><!-- End of header -->
			<div id="container">
				<div class="about">Curriculums </div>
				<div class="fl mt10" style="width:100%;">
					<div class="act"><a href="add-curriculum.php">Add Curriculum</a><div id="bulkAct"><a href="javascript:void(0);" id="btnDel" onclick="javascript: _deleteCurriculum(-1,<?php echo $curPage; ?>);" class="ml5">Delete</a></div></div><!-- End of about -->
					<?php if(isset($_SESSION["resp"]) && $_SESSION["resp"] !="")
					{
					?>
						<div id="ErrMsg" style="display: block;">
						<?php
						if($_SESSION["resp"] == "err")
							echo "<span style=\"color:#00A300;\">Error while adding curriculum.</span>";
						else if($_SESSION["resp"] == "suc")
							echo "Curriculum successfully added.";
						else if($_SESSION["resp"] == "sucdt")
							echo "Curriculum successfully deleted.";
						else if($_SESSION["resp"] == "inv")
							echo "Blank fields are not allowed.";
						else if($_SESSION["resp"] == "up")
							echo "Curriculum edited successfully.";
						else if($_SESSION["resp"] == "invEd")
							echo "This curriculum can't be saved because this is already exist.";
						else if($_SESSION["resp"] == "invUp")
							echo "This curriculum can't be updated because this is already exist.";
						else if($_SESSION["resp"] == "errEd")
							echo "Error while editing curriculum."; 
						?>
					</div>
					<?php
					}else{
					?>
						<div id="ErrMsg"></div>
					<?php
					}
					?>
				<!-- end of ErrMsg -->
				</div>
				<div id="displayUser"></div><!-- end of displayUser -->
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
	_getCurriculumTable(<?php echo $curPage; ?>, '' , '')
</script>
</body>
</html>
<?php
	session_destroy();
?>