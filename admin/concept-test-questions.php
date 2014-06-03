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
<title>Avanti &raquo; Resources &raquo; Concept Test Questions</title>
<?php
    include_once("./includes/head-meta.php");
?>
<script type="text/javascript" language="javascript" src="./javascript/concept-test-questions.js"></script>
</head>
<body>
<div id="page">
    <div id="pageContainer">
	<div id="wrapper">	
	    <div id="header">
            <?php
                $pgName = "topics";
                include_once("./includes/header.php");
                
		$currid = 0;
                $catgid = 0;
                $chptid = 0;
                $topicid = 0;
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
                $sqlCount = $db->query("query","select count(unique_id) as 'total' from avn_question_master WHERE resource_id = " . $_GET["rid"] . " and type = 2");             
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
	    <div class="about2">
		<span class="mt2px fl"><a href="./curriculum.php" class="clrmaroon fl">Curriculums</a>&nbsp;&raquo;&nbsp;</span>
		<select class="inputseacrh inputseacrh2" id="ddlCurriculum" onchange="javascript: window.location='./category.php?currid=' + this.value;"><option value=''>All</option><?php for($sb = 0; $sb < count($rsCurriculums); $sb++){ if($rsCurriculums[$sb]["unique_id"] == $currid){echo "<option value='" . $rsCurriculums[$sb]["unique_id"] . "' selected='selected'>" . $rsCurriculums[$sb]["curriculum_name"] . "</option>";} else {echo "<option value='" . $rsCurriculums[$sb]["unique_id"] . "'>" . $rsCurriculums[$sb]["curriculum_name"] . "</option>";}} ?></select>
		<span class="mt2px fl">&nbsp;&raquo;&nbsp;</span>
		<select class="inputseacrh inputseacrh2" onchange="javascript: window.location='./chapter.php?catgid=' + this.value;"><option value=''>All</option><?php for($sb = 0; $sb < count($rsSubjects); $sb++){ if($rsSubjects[$sb]["unique_id"] == $catgid){echo "<option value='" . $rsSubjects[$sb]["unique_id"] . "' selected='selected'>" . $rsSubjects[$sb]["category_name"] . "</option>";} else {echo "<option value='" . $rsSubjects[$sb]["unique_id"] . "'>" . $rsSubjects[$sb]["category_name"] . "</option>";}} ?></select>
		<span class="mt2px fl">&nbsp;&raquo;&nbsp;</span>
		<select class="inputseacrh inputseacrh2" onchange="javascript: window.location='./topic.php?catgid=<?php echo $catgid; ?>&chptid=' + this.value;"><option value=''>All</option><?php for($ch = 0; $ch < count($rsChapters); $ch++){ if($rsChapters[$ch]["unique_id"] == $chptid){echo "<option value='" . $rsChapters[$ch]["unique_id"] . "' selected='selected'>" . $rsChapters[$ch]["chapter_name"] . "</option>";} else {echo "<option value='" . $rsChapters[$ch]["unique_id"] . "'>" . $rsChapters[$ch]["chapter_name"] . "</option>";}} ?>
		</select>
		<span class="mt2px fl">&nbsp;&raquo;&nbsp;</span>
		<select class="inputseacrh inputseacrh2" onchange="javascript: var d = this.value.split('|'); window.location='./resource.php?currid=<?php echo $currid; ?>chptid=<?php echo $chptid; ?>&rid=' + d[0] + '&catgid=<?php echo $catgid; ?>&topicid=' + d[1];">
		    <option value=''>All</option>
		    <?php for($tp = 0; $tp < count($rstopics); $tp++){ if($rstopics[$tp]["unique_id"] == $topicid){echo "<option value='|" . $rstopics[$tp]["unique_id"] ."' selected='selected'>" . $rstopics[$tp]["topic_name"] . "</option>";} else {echo "<option value='|" . $rstopics[$tp]["unique_id"] . "'>" . $rstopics[$tp]["topic_name"] . "</option>";}} ?>
		</select>
		<span class="mt2px fl">&nbsp;&raquo;&nbsp;<a href="./resource.php<?php echo filter_querystring($_SERVER["QUERY_STRING"], array("currid","catgid","chptid","topicid","resp","page","type"), array($currid,$catgid,$chptid,$topicid,"","","")); ?>">Resources</a>&nbsp;&raquo;&nbsp;Concept Test</span>
	    </div>
	    <div class="act">
		<a href="./add-spot-test.php<?php echo filter_querystring($_SERVER["QUERY_STRING"], array("cid","type","resp","page"), array("","2","","")); ?>">Add Question</a></span>
		<div id="bulkAct"><a href="javascript:void(0);" id="btnDel" onclick="javascript: _deleteconceptquestion(<?php echo $currid; ?>,-1,<?php echo $topicid; ?>,<?php echo $chptid; ?>,<?php echo $catgid;?>,'2',<?php echo $curPage; ?>);" class="ml5">Delete</a></div>
		<div id="bulkActive"><a href="javascript:void(0);" id="activestatus" onclick="javascript: _chngConQesStatus(<?php echo $currid; ?>,-1,<?php echo $topicid; ?>,<?php echo $chptid; ?>,<?php echo $catgid; ?>,this.id,2,<?php echo $curPage; ?>);" class="ml5">Active</a>
		</div>
	    </div><!-- End of about -->
            <?php
                if(isset($_SESSION["resp"]) && $_SESSION["resp"] != ""){ 
            ?>
	    <div id="ErrMsg" style="display: block;">
                <?php
                    if($_SESSION["resp"] == "err")
                        echo "<span style=\"color:#00A300;\">Error while adding Lead.</span>";
                    else if($_SESSION["resp"] == "suc")
                        echo "Concept test question is successfully added.";
                    else if($_SESSION["resp"] == "Errdlt")
                        echo "Concept test question is not deleted successfully.";
                    else if($_SESSION["resp"] == "sucdt")
                        echo "Concept test question successfully deleted.";
                    else if($_SESSION["resp"] == "up")
                        echo "Concept test question edited successfully.";
                    else if($_SESSION["resp"] == "invEd")
                        echo "Concept test question can't be saved";
                    else if($_SESSION["resp"] == "invUp")
                        echo "Concept test question can't be updated because this is already exist";
                    else if($_SESSION["resp"] == "errEd")
                        echo "Error while editing leads"; 
                ?>
	    </div><!-- end of ErrMsg -->
            <?php
                }else{
            ?>
                    <div id="ErrMsg"></div>
            <?php
                }
            ?>
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
    _getConceptQesTable(<?php echo $currid; ?>,<?php echo $topicid; ?>, <?php echo $catgid; ?>, <?php echo $chptid; ?>,<?php echo $curPage;?>,'','')
</script>
</body>
</html>
<?php
    session_destroy();
?>