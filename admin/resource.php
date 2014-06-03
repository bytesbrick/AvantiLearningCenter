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
<title>Avanti &raquo; Dashboard &raquo; Resources</title>
<?php
	include_once("./includes/head-meta.php");
?>
<script type="text/javascript" language="javascript" src="./javascript/resources.js"></script>
</head>
<body>
<div id="page">
	<div id="pageContainer">
		<div id="wrapper">	
			<div id="header">
			<?php
				$pgName = "topics";
				include_once("./includes/header.php");
				
				$sort = "ASC";
				$field = "rd.priority";
				$catgid = 0;
				$chptid = 0;
				$topicid = 0;
				$currid = 0;
				if(isset($_GET["sf"]) && $_GET["sf"] != "")
					$field = $_GET["sf"];
				if(isset($_GET["sd"]) && $_GET["sd"] != "")
					$sort = $_GET["sd"];
				if(isset($_GET["currid"]) && $_GET["currid"] != ""){
					$currid = $_GET["currid"];
				}
				if(isset($_GET["catgid"]) && $_GET["catgid"] != ""){
					$catgid = $_GET["catgid"];
					$where .= $where == "" ? "chm.category_id = " . mysql_escape_string($catgid) : " AND chm.category_id = " . mysql_escape_string($catgid);
				}
				if(isset($_GET["chptid"]) && $_GET["chptid"] != ""){
					$chptid = $_GET["chptid"];
					$where .= $where == "" ? "tm.chapter_id = " . mysql_escape_string($chptid) : " AND tm.chapter_id = " . mysql_escape_string($chptid);
				}
				if(isset($_GET["topicid"]) && $_GET["topicid"] != ""){
					$topicid = $_GET["topicid"];
					$where .= $where == "" ? "rd.topic_id = " . mysql_escape_string($topicid) : " AND rd.topic_id = " . mysql_escape_string($topicid);
				}
					
				$curPage = $_GET["page"];
				if(($curPage == "") || ($curPage == 0))												
				$curPage=1;
				$recPerpage = 25;
				$countWhereClause = "";
				$selectWhereClause = "";
				$pageParam="";
				$sql = "SELECT COUNT(rd.unique_id) as 'total' FROM avn_resources_detail rd INNER JOIN avn_topic_master tm ON rd.topic_id = tm.unique_id INNER JOIN avn_chapter_master chm ON chm.unique_id = tm.chapter_id INNER JOIN ltf_category_master lcm ON lcm.unique_id = chm.category_id WHERE rd.topic_id = " . $topicid;
				if($where != "")
					$sql .= " AND " .$where;
				$sqlCount = $db->query("query",$sql);
				$recCount = $sqlCount[0]['total'];
				$noOfpage = ceil($recCount/$recPerpage);
				$limitStart = ($curPage - 1) * $recPerpage;
				$limitEnd = $recPerpage;
				
				$sqlCurriculums = "select unique_id, curriculum_name from avn_curriculum_master acm";
				$rsCurriculums = $db->query("query", $sqlCurriculums);
				
				$sqlSubjects = "select unique_id, category_name from ltf_category_master lcm";
				$rsSubjects = $db->query("query", $sqlSubjects);
				
				if($catgid != 0)
					$sqlChapters = "select unique_id, chapter_name from avn_chapter_master chm WHERE chm.category_id = " . $catgid;
				else
					$sqlChapters = "select unique_id, chapter_name from avn_chapter_master chm";
					$rsChapters = $db->query("query", $sqlChapters);
					
				if($chptid != 0)
					$sqltopic = "SELECT unique_id, topic_name FROM avn_topic_master WHERE chapter_id = " . $chptid;
				else
					$sqltopic = "SELECT unique_id, topic_name FROM avn_topic_master";
					$rstopics = $db->query("query", $sqltopic);
			?>
			</div><!-- End of header -->
			<div id="container2">
				<div class="about2"><span class="mt2px fl"><a href="./curriculum.php" class="clrmaroon fl">Curriculums</a>&nbsp;&raquo;&nbsp;</span><select class="inputseacrh inputseacrh2" id="ddlCurriculum" onchange="javascript: window.location='./category.php?currid=' + this.value;"><option value=''>All</option><?php for($sb = 0; $sb < count($rsCurriculums); $sb++){ if($rsCurriculums[$sb]["unique_id"] == $currid){echo "<option value='" . $rsCurriculums[$sb]["unique_id"] . "' selected='selected'>" . $rsCurriculums[$sb]["curriculum_name"] . "</option>";} else {echo "<option value='" . $rsCurriculums[$sb]["unique_id"] . "'>" . $rsCurriculums[$sb]["curriculum_name"] . "</option>";}} ?></select><span class="mt2px fl">&nbsp;&raquo;&nbsp;</span><select class="inputseacrh inputseacrh2" onchange="javascript: window.location='./chapter.php?currid=<?php echo $currid; ?>&catgid=' + this.value;"><option value=''>All</option><?php for($sb = 0; $sb < count($rsSubjects); $sb++){ if($rsSubjects[$sb]["unique_id"] == $catgid){echo "<option value='" . $rsSubjects[$sb]["unique_id"] . "' selected='selected'>" . $rsSubjects[$sb]["category_name"] . "</option>";} else {echo "<option value='" . $rsSubjects[$sb]["unique_id"] . "'>" . $rsSubjects[$sb]["category_name"] . "</option>";}} ?></select><span class="mt2px fl">&nbsp;&raquo;&nbsp;</span><select class="inputseacrh inputseacrh2" onchange="javascript: window.location='./topic.php?currid=<?php echo $currid; ?>&catgid=<?php echo $catgid; ?>&chptid=' + this.value;"><option value=''>All</option><?php for($ch = 0; $ch < count($rsChapters); $ch++){ if($rsChapters[$ch]["unique_id"] == $chptid){echo "<option value='" . $rsChapters[$ch]["unique_id"] . "' selected='selected'>" . $rsChapters[$ch]["chapter_name"] . "</option>";} else {echo "<option value='" . $rsChapters[$ch]["unique_id"] . "'>" . $rsChapters[$ch]["chapter_name"] . "</option>";}} ?></select><span class="mt2px fl">&nbsp;&raquo;&nbsp;Resources of&nbsp;</span><select class="inputseacrh inputseacrh2" onchange="javascript: var d = this.value.split('|');window.location='./resource.php?currid=<?php echo $currid; ?>&chptid=<?php echo $chptid; ?>&catgid=<?php echo $catgid; ?>&topicid=' + d[1];"><option value=''>All</option><?php for($tp = 0; $tp < count($rstopics); $tp++){ if($rstopics[$tp]["unique_id"] == $topicid){echo "<option value='" . $rstopics[$tp]["ResID"] . "|" . $rstopics[$tp]["unique_id"] . "' selected='selected'>" . $rstopics[$tp]["topic_name"] . "</option>";} else {echo "<option value='" . $rstopics[$tp]["ResID"] . "|" . $rstopics[$tp]["unique_id"] . "'>" . $rstopics[$tp]["topic_name"] . "</option>";}} ?></select></div><div class="act"><a href="add-resource.php<?php echo filter_querystring($_SERVER["QUERY_STRING"], array("cid","resp","page"), array("","","")); ?>">Add Resource</a>
					
						<?php
							unset($rsCurriculums);
							unset($rsSubjects);
							unset($rsChapters);
							$isSpotlink = false;
							$chkforspot = $db->query("query","SELECT unique_id FROM avn_resources_detail WHERE topic_id = " . $_GET['topicid'] . " AND content_type = 'spot'");
							
							if(!array_key_exists("response",$chkforspot))
								$isSpotlink = true;
							
							$isConceptlink = false;
							$chkforconcept = $db->query("query","SELECT unique_id FROM avn_resources_detail WHERE topic_id = " . $_GET['topicid'] . " AND content_type = 'concept'");
							
							if(!array_key_exists("response",$chkforconcept))
								$isConceptlink = true;
								
							$spotQCount = 0;
							$chkforspot = $db->query("query","SELECT COUNT(qm.unique_id) as Total FROM avn_resources_detail rd INNER JOIN ltf_resources_master rm ON rd.resource_id = rm.unique_id INNER JOIN avn_question_master qm ON qm.resource_id = rm.unique_id WHERE rd.topic_id = " . $_GET['topicid'] . " AND rd.content_type = 'spot' AND qm.type = 1");
							if(!array_key_exists("response",$chkforspot)){
								$spotQCount = $chkforspot[0]["Total"];
							}
							unset($chkforspot);
							
							$conceptQCount = 0;
							$chkforconcept = $db->query("query","SELECT COUNT(qm.unique_id) as Total FROM avn_resources_detail rd INNER JOIN ltf_resources_master rm ON rd.resource_id = rm.unique_id INNER JOIN avn_question_master qm ON qm.resource_id = rm.unique_id WHERE rd.topic_id = " . $_GET['topicid'] . " AND rd.content_type = 'concept' AND qm.type = 2");
							if(!array_key_exists("response",$chkforconcept)){
								$conceptQCount = $chkforconcept[0]["Total"];
							}
							unset($chkforconcept);
							
							if(!$isSpotlink){
						?>
								<a href="javascript:void(0);" id="spottest" name="spottest" style="margin:0px 5px 0px 5px;" onclick="javascript:_addTest(<?php echo $_GET['topicid']; ?>,this.id)">Add Spot Test</a>
						<?php
							} 
							if(!$isConceptlink){
						?>
								<a href="javascript:void(0);" id="concepttest" name="concepttest" style="margin:0px 5px 0px 5px;" onclick="javascript:_addTest(<?php echo $_GET['topicid']; ?>,this.id)">Add Concept Test</a>
						<?php
							} 
						?>
						<div id="bulkAct"><a href="javascript:void(0);" id="btnDel" onclick="javascript: _deleteresource(<?php echo $currid; ?>,-1,<?php echo $topicid; ?>,<?php echo $catgid; ?>,<?php echo $chptid;?>,<?php echo $curPage; ?>);" class="ml5">Delete</a></div><div id="bulkActive"><a href="javascript:void(0);" id="activestatus" onclick="javascript: _chngResStatus(<?php echo $currid; ?>,-1,<?php echo $topicid; ?>,this.id,<?php echo $catgid; ?>,<?php echo $chptid; ?>,<?php echo $curPage; ?>);" class="ml5">Active</a></div>
					</span>
				</div><!-- End of about -->
				<?php if(isset($_SESSION["resp"]) && $_SESSION["resp"] !="")
				{
				?>
					<div id="ErrMsg" style="display: block;">
						<?php
							if($_SESSION["resp"] == "err")
								echo "<span style=\"color:#00A300;\">Error while adding lead.</span>";
							else if($_SESSION["resp"] == "suc")
								echo "Resource successfully added.";
							else if($_SESSION["resp"] == "sucdt")
								echo "Resource successfully deleted.";
							else if($_SESSION["resp"] == "Erdt")
								echo "Resource could not be deleted.";
							else if($_SESSION["resp"] == "up")
								echo "Resource edited successfully.";
							else if($_SESSION["resp"] == "invEd")
								echo "This Resource can't be saved because this is already exist.";
							else if($_SESSION["resp"] == "invUp")
								echo "This Resource can't be updated because this is already exist.";
							else if($_SESSION["resp"] == "errEd")
								echo "Error while editing leads";
							else if($_SESSION["resp"] == "suctestad")
								echo "This Test is successfully added.";
							else if($_SESSION["resp"] == "Erdtadd")
								echo "This Test could not be deleted.";
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
				<input type="hidden" name="hdntopic_id" id ="hdntopic_id" value="<?php echo $topicid; ?>">
			</div><!-- end of container -->
			<?php
				include_once("./includes/sidebar.php");
				$db->close();
			?>
		</div><!-- end of wrapper -->
	</div><!-- end of pagecontainer -->
</div><!-- end of page --> 
<script type="text/javascript">
	_getResourceTable(<?php echo $currid; ?>, <?php echo $topicid; ?>, <?php echo $catgid; ?>, <?php echo $chptid; ?>,<?php echo $curPage; ?>,'','')
</script>
</body>
</html>
<?php
	session_destroy();
?>