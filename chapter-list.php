<?php
    include_once("./includes/config.php");
    include("./classes/cor.mysql.class.php");
    include_once("./includes/checklogin.php");
    if(trim($_GET['currslug']) != trim($arrUserInfo["curriculum_slug"])){
	$redPath = __WEBROOT__ . "/logout.php";
	//echo $redPath;
	header("Location: " . $redPath);
    }
?>
<html xml:lang="en" lang="en" itemscope="" itemtype="http://schema.org">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Avanti Learning Centres | Chapter List</title>
<head>
    <?php
	include("./includes/header-meta.php");
	
	$db = new MySqlConnection(CONNSTRING);
	$db->open();	    
	$sql = "SELECT unique_id FROM avn_curriculum_master WHERE curriculum_slug = '" . mysql_escape_string($_GET['currslug']) . "'";
	$r = $db->query("query", $sql);
	if(!array_key_exists("response", $r)){
	    $currID = $r[0]["unique_id"];
	}
	//else {
	//    $db->close();
	//    //header("Location: " . __WEBROOT__ . "/page-not-found/");
	//}
    ?>
<script type="text/javascript" src="<?php echo __WEBROOT__; ?>/js/ajax.js"></script>
<script type="text/javascript" src="<?php echo __WEBROOT__; ?>/js/ajax_login.js?v=<?php echo mktime(); ?>"></script>
<style>
    body{font-family: "AvenirLTStd-Light";}
</style>
</head>
<body>
    <div class="mainbody">
	<?php
	   include_once("./includes/header.php")
	?>
	<div class="maincontent">
            <div class="leftdiv">
		<div class="lessonbg"><span class="lessontext">Chapter List</span></div>
                <span class="filter">Filters</span>
                <div class="topics">
		     <span class="checkboxFive"><input type="checkbox" name="chktopicdetails" id="chkAllsubject" class="checkbox1" checked="checked" /><label for="chkAllsubject"></label></span>
		     <span class="topic">All Subjects</span>
               </div>
	       <?php
		  $selcategory = "SELECT unique_id ,category_name FROM ltf_category_master WHERE curriculum_id = " . $currID;
		  $selcategoryRS = $db->query("query", $selcategory);
		  if(!array_key_exists("response", $selcategoryRS)){
		     for($i = 0; $i < count($selcategoryRS); $i++){
	       ?>
			<div class="topics">
			   <span class="checkboxFive">
			    <input type="checkbox" id="chkSubject-<?php echo $selcategoryRS[$i]["unique_id"]; ?>" name="chkcategory" class="fl" value="<?php echo $selcategoryRS[$i]["unique_id"]; ?>" onclick="javascript: _createFilter('chkAllsubject','chkcategory', this.value, this.id,<?php echo $currID; ?>, 'single');" value="<?php echo $selcategoryRS[$i]["unique_id"]; ?>"><label for="chkSubject-<?php echo $selcategoryRS[$i]["unique_id"]; ?>"></label></span>
			   <span class="topic"><?php echo $selcategoryRS[$i]["category_name"]; ?></span>
		       </div>
	       <?php
		     }
		     unset($selcategoryRS);
		  }
		?>
	    </div>
	    <div class="rightdiv">
                <div class="righttopdiv">
                    <span class="topicspan"><a href="<?php echo __WEBROOT__; ?>/topics-completed/">Completed</a></span>
                    <span class="topicspan"><a href="<?php echo __WEBROOT__; ?>/topics-starred/">Starred</a></span>
                    <span class="topicspan"><a href="<?php echo __WEBROOT__; ?>/lesson-plan/">Lesson Plan</a></span>
                </div>
		<div class="columdiv" style="margin-top:20px;">
		    <table cellpadding="0"id="tabLeadusers" name="tabLeadusers" cellspacing="0" border="0" width="100%;" class="mdata">
		    <thead>
			<tr class='topicheading'>
			    <th width='43px' valign='middle' align="left" class='black'>Code</th>
			    <th width='438px' valign='middle'  align="left" class='black'>Chapter</th>
			    <th valign='middle'  align="right" style="padding-right: 20px;" class='black'>Subject</th>
			    <th valign='middle'  align="right" style="padding-right: 20px;" class='black'>Topics</th>
			</tr>
		    </thead>
		    </table>
		    <div id="columdiv" class="columdiv"></div>
		</div>
		<div class="showmore" id="showmore"></div>
	      </div>
		<?php
		    include("./includes/footer.php");
		?>
            </div>
	</div>
    </div>
</body>
<script type="text/javascript">
    p.push(new Array("chkcurriculum", '<?php echo $currID; ?>'));
    _applyFilter();
</script>
</html>