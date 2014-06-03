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
<title>Avanti &raquo; Dashboard &raquo; Topics</title>
<?php
	include_once("./includes/head-meta.php");	
?>
<script type="text/javascript" language="javascript" src="./javascript/topic.js"></script>
</head>
<body>
<div id="page">
	<div id="pageContainer">
		<div id="wrapper">	
			<div id="header">
			<?php
				$pgName = "topics";
				include_once("./includes/header.php");
				
				$sort = "DESC";
				$field = "tm.unique_id";
				$currid = 0;
				$chptid = 0;
				$catgid = 0;
				$resid = 0;
				if(isset($_GET["sf"]) && $_GET["sf"] != "")
					$field = $_GET["sf"];
				if(isset($_GET["sd"]) && $_GET["sd"] != "")
					$sort = $_GET["sd"];
				if(isset($_GET["currid"]) && $_GET["currid"] != "" && $_GET["currid"] != "0"){
					$currid = $_GET["currid"];
				}
				if(isset($_GET["catgid"]) && $_GET["catgid"] != "" && $_GET["catgid"] != "0"){
					$catgid = $_GET["catgid"];
					$where .= $where == "" ? "chm.category_id = " . mysql_escape_string($catgid) : " AND chm.category_id = " . mysql_escape_string($catgid);
				}
				if(isset($_GET["chptid"]) && $_GET["chptid"] != "" && $_GET["chptid"] != "0"){
					$chptid = $_GET["chptid"];
					$where .= $where == "" ? "tm.chapter_id = " . mysql_escape_string($chptid) : " AND tm.chapter_id = " . mysql_escape_string($chptid);
				}
					
				$curPage = $_GET["page"];
				if(($curPage == "") || ($curPage == 0))
				$curPage=1;
				$recPerpage = 25;
				$countWhereClause = "";
				$selectWhereClause = "";

				$sql = "SELECT COUNT(tm.unique_id) as 'total' FROM avn_topic_master tm INNER JOIN avn_chapter_master chm ON chm.unique_id = tm.chapter_id INNER JOIN ltf_category_master lcm ON lcm.unique_id = chm.category_id";
				if($where != "")
					$sql.= " WHERE " . $where;
				$sqlCount = $db->query("query",$sql);
				$recCount = $sqlCount[0]['total'];
				$noOfpage = ceil($recCount/$recPerpage);
				$limitStart = ($curPage - 1) * $recPerpage;
				$limitEnd = $recPerpage;
				
				$sqlCurriculums = "select unique_id, curriculum_name from avn_curriculum_master acm";
				$rsCurriculums = $db->query("query", $sqlCurriculums);
				
				if($currid <= 0)
				$sqlSubjects = "select unique_id, category_name from ltf_category_master lcm";
				else
				$sqlSubjects = "select unique_id, category_name from ltf_category_master lcm WHERE lcm.curriculum_id = " . $currid;
				$rsSubjects = $db->query("query", $sqlSubjects);
				
				if($catgid != 0)
					$sqlChapters = "select unique_id, chapter_name from avn_chapter_master chm WHERE chm.category_id = " . $catgid;
				else
					$sqlChapters = "select unique_id, chapter_name from avn_chapter_master chm";
					$rsChapters = $db->query("query", $sqlChapters);
			?>
			</div><!-- End of header -->
			<div id="container2">
				<div class="about2">
					<span class="mt2px fl"><a href="./curriculum.php" class="clrmaroon fl">Curriculums</a>&nbsp;&raquo;&nbsp;</span>
					<select class="inputseacrh inputseacrh2" id="ddlCurriculum" onchange="javascript: window.location='./topic.php?currid=' + this.value;">
						<option value=''>All Curriculums</option>
						<?php for($sb = 0; $sb < count($rsCurriculums); $sb++){ if($rsCurriculums[$sb]["unique_id"] == $currid){echo "<option value='" . $rsCurriculums[$sb]["unique_id"] . "' selected='selected'>" . $rsCurriculums[$sb]["curriculum_name"] . "</option>";} else {echo "<option value='" . $rsCurriculums[$sb]["unique_id"] . "'>" . $rsCurriculums[$sb]["curriculum_name"] . "</option>";}} ?></select>
					<span class="mt2px fl">&nbsp;&raquo;&nbsp;</span>
					<select class="inputseacrh inputseacrh2" id="ddlSubject" onchange="javascript: window.location='./topic.php?currid=<?php echo $currid; ?>&catgid=' + this.value;">
						<option value=''>All Subjects</option>
						<?php for($sb = 0; $sb < count($rsSubjects); $sb++){ if($rsSubjects[$sb]["unique_id"] == $catgid){echo "<option value='" . $rsSubjects[$sb]["unique_id"] . "' selected='selected'>" . $rsSubjects[$sb]["category_name"] . "</option>";} else {echo "<option value='" . $rsSubjects[$sb]["unique_id"] . "'>" . $rsSubjects[$sb]["category_name"] . "</option>";}} ?></select>
					<span class="mt2px fl">&nbsp;&raquo;&nbsp;Topics of&nbsp;</span>
					<select class="inputseacrh inputseacrh2" id="ddlChapter" onchange="javascript: window.location='./topic.php?currid=<?php echo $currid; ?>&catgid=<?php echo $catgid; ?>&chptid=' + this.value;">
						<option value=''>All Chapters</option>
						<?php for($ch = 0; $ch < count($rsChapters); $ch++){ if($rsChapters[$ch]["unique_id"] == $chptid){echo "<option value='" . $rsChapters[$ch]["unique_id"] . "' selected='selected'>" . $rsChapters[$ch]["chapter_name"] . "</option>";} else {echo "<option value='" . $rsChapters[$ch]["unique_id"] . "'>" . $rsChapters[$ch]["chapter_name"] . "</option>";}} ?></select>
				</div>
				<div class="act">
				<?php
					if($currid <= 0){
				?>
						<a href="javascript: void(0);" onclick="javascript: alert('Please choose a curriculum to add topic');document.getElementById('ddlCurriculum').setAttribute('style','border:solid 2px #A74242;');">Add Topic</a>
				<?php
					}
					elseif($catgid <= 0){
				?>
						<a href="javascript: void(0);" onclick="javascript: alert('Please choose a subject to add topic');document.getElementById('ddlSubject').setAttribute('style','border:solid 2px #A74242;');">Add Topic</a>
				<?php
					}
					elseif($chptid <= 0){
				?>
						<a href="javascript: void(0);" onclick="javascript: alert('Please choose a chapter to add topic');document.getElementById('ddlChapter').setAttribute('style','border:solid 2px #A74242;');">Add Topic</a>
				<?php
					} else {
				?>
						<a href="add-topic.php<?php echo filter_querystring($_SERVER["QUERY_STRING"], array("resp","page"), array("","")); ?>">Add Topic</a>
				<?php
					}
				?>
					<div id="bulkAct"><a href="javascript:void(0);" id="btnDel" onclick="javascript: _deletetopic(<?php echo $currid; ?>,-1,<?php echo $chptid; ?>,<?php echo $catgid;?>,<?php echo $curPage; ?>);" class="ml10">Delete</a></div><div id="bulkActive"><a href="javascript:void(0);" id="statusinactive" onclick="javascript: _changestatus(<?php echo $currid; ?>,-1,this.id,<?php echo $chptid; ?>,<?php echo $catgid; ?>,<?php echo $curPage; ?>);" class="ml10">Active</a>
				</div>
			</div>
			<!-- End of about -->
				<?php
					unset($rsCurriculums);
					unset($rsSubjects);
					unset($rsChapters);
				if(isset($_SESSION["resp"]) && $_SESSION["resp"] !=""){
				?>
					<div id="ErrMsg" style="display: block;">
						<?php
						if($_SESSION["resp"] == "err")
							echo "<span style=\"color:#00A300;\">Error while adding Topics.</span>";
						else if($_SESSION["resp"] == "suc")
							echo "Topic successfully added.";
						else if($_SESSION["resp"] == "sucdt")
							echo "Topic successfully deleted.";
						else if($_SESSION["resp"] == "inv")
							echo "Blank fields are not allowed.";
						else if($_SESSION["resp"] == "up")
							echo "Topic edited successfully.";
						else if($_SESSION["resp"] == "invEd")
							echo "This Topic can't be saved because this is already exist.";
						else if($_SESSION["resp"] == "invUp")
							echo "This Topic can't be updated because this is already exist.";
						else if($_SESSION["resp"] == "errEd")
							echo "Error while editing topics.";
						else if($_SESSION["resp"] == "err-add")
							echo "SORRY! topic could not be added.";
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
	_getTopicTable(<?php echo $currid; ?>, <?php echo $chptid; ?>,<?php echo $catgid; ?>,<?php echo $curPage; ?>,'','')
</script>
</body>
</html>
<?php
	session_destroy();
?>