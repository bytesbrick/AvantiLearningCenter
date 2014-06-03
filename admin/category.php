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
<title>Avanti &raquo; Dashboard &raquo; Subjects</title>
<?php
	include_once("./includes/head-meta.php");
	
	if(isset($_GET["sf"]) && $_GET["sf"] != "")
        $field = $_GET["sf"];
	if(isset($_GET["sd"]) && $_GET["sd"] != "")
        $sort = $_GET["sd"];
	
	$where = "";
	$currid = 0;
	if(isset($_GET["currid"]) && $_GET["currid"] != "" && $_GET["currid"] != "0"){
		$currid = $_GET["currid"];
		$where .= $where == "" ? "acm.category_id = " . mysql_escape_string($currid) : " AND acm.category_id = " . mysql_escape_string($currid);
	}
	$curPage = $_GET["page"];
	if(($curPage == "") || ($curPage == 0))
		$curPage=1;
	//$recPerpage = 25;
	//$countWhereClause = "";
	//$selectWhereClause = "";
	//$pageParam="";
	//$sqlCount = $db->query("query","select count(unique_id) as 'total' from ltf_category_master");
	//$recCount = $sqlCount[0]['total'];
	//$noOfpage = ceil($recCount/$recPerpage);
	//$limitStart = ($curPage - 1) * $recPerpage;
	//$limitEnd = $recPerpage;
?>
<script type="text/javascript" language="javascript" src="./javascript/category.js"></script>
</head>
<body>
<div id="page">
	<div id="pageContainer">
		<div id="wrapper">	
			<div id="header">
			<?php
				$pgName = "subjects";
				include_once("./includes/header.php");
				
				$sqlCurriculums = "select unique_id, curriculum_name from avn_curriculum_master acm";
				$rsCurriculums = $db->query("query", $sqlCurriculums);
			?>
			</div><!-- End of header --> 
			<div id="container2">
				<div class="about2">
					<span class="mt2px fl"><a href="./curriculum.php" class="clrmaroon fl">Curriculums</a>&nbsp;&raquo;&nbsp;</span>
					<span class="mt2px fl"> Subjects of&nbsp;</span>
						<select class="inputseacrh inputseacrh2" id="ddlCurriculum" onchange="javascript: window.location='./category.php?currid=' + this.value;">
							<option value=''>All Curriculums</option>
							<?php for($sb = 0; $sb < count($rsCurriculums); $sb++){ if($rsCurriculums[$sb]["unique_id"] == $currid){echo "<option value='" . $rsCurriculums[$sb]["unique_id"] . "' selected='selected'>" . $rsCurriculums[$sb]["curriculum_name"] . "</option>";} else {echo "<option value='" . $rsCurriculums[$sb]["unique_id"] . "'>" . $rsCurriculums[$sb]["curriculum_name"] . "</option>";}} ?>
						</select>
				</div>
				<div class="act">
					<!--<a href="add-category.php?currid=<?php //echo $currid; ?>">Add Subject</a>-->
				<?php
					if($currid <= 0){
				?>
						<a href="javascript: void(0);" onclick="javascript: alert('Please choose a curriculum to add Subject');document.getElementById('ddlCurriculum').setAttribute('style','border:solid 2px #A74242;');">Add Subject</a>
				<?php
					}
					else{
				?>
						<a href="add-category.php?currid=<?php echo $currid; ?>">Add Subject</a>
				<?php
					}
				?>
					<div id="bulkAct"><a href="javascript:void(0);" id="btnDel" onclick="javascript: _deletesubject(-1,<?php echo $curPage; ?>);" class="ml5">Delete</a></div></div><!-- End of about -->
				<?php
					unset($rsCurriculums);
					if(isset($_SESSION["resp"]) && $_SESSION["resp"] !=""){
				?>
					<div id="ErrMsg" style="display: block;">
						<?php
						if($_SESSION["resp"] == "err")
							echo "<span style=\"color:#00A300;\">Error while adding Lead.</span>";
						else if($_SESSION["resp"] == "suc")
							echo "Subject successfully added.";
						else if($_SESSION["resp"] == "sucdt")
							echo "Subject successfully deleted.";
						else if($_SESSION["resp"] == "inv")
							echo "Blank fields are not allowed.";
						else if($_SESSION["resp"] == "up")
							echo "Subject edited successfully.";
						else if($_SESSION["resp"] == "invEd")
							echo "This subject can't be saved because this is already exit.";
						else if($_SESSION["resp"] == "invUp")
							echo "This subject can't be updated because this is already exit.";
						else if($_SESSION["resp"] == "errEd")
							echo "Error while editing leads";
						else if($_SESSION["resp"] == "err-add")
							echo "SORRY! subject could not be added."; 
						?>
					</div>
				<?php
				}else{
				?>
					<div id="ErrMsg"></div>
				<?php
				}
				?><!-- end of ErrMsg -->
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
	_getCategoryTable(<?php echo $currid; ?>, <?php echo $curPage; ?>,'','');
</script>
</body>
</html>
<?php
	session_destroy();
?>