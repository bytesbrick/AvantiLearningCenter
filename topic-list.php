<?php
    include_once("./includes/config.php");  
    include("./classes/cor.mysql.class.php");
    include_once("./includes/checklogin.php");
    if(trim($_GET['currslug']) != trim($arrUserInfo["curriculum_slug"])){
	$redPath = __WEBROOT__ . "/logout.php";
	header("Location: " . $redPath);
    }
?>
<html xml:lang="en" lang="en" itemscope="" itemtype="http://schema.org">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Avanti Learning Centres | Topic List</title>
<head>
<?php
    include("./includes/header-meta.php");
    
    $db = new MySqlConnection(CONNSTRING);
    $db->open();
    $sql = "SELECT unique_id FROM avn_curriculum_master WHERE curriculum_slug = '" . mysql_escape_string($_GET['currslug']) . "'";
    $r = $db->query("query", $sql);
    if(!array_key_exists("response", $r)){
	$currID = $r[0]["unique_id"];
	$sql = "SELECT unique_id FROM avn_chapter_master WHERE chapter_slug = '" . mysql_escape_string($_GET['chpslug']) . "'";
	$c = $db->query("query", $sql);
	if(!array_key_exists("response", $c)){
	    $chapID = $c[0]["unique_id"];
	} else {
	    header("Location: " . __WEBROOT__ . "/page-not-found/");
	}
    } else {
	header("Location: " . __WEBROOT__ . "/page-not-found/");
    }
?>
<script type="text/javascript" src="<?php echo __WEBROOT__; ?>/js/ajax.js"></script>
<script type="text/javascript" src="<?php echo __WEBROOT__; ?>/js/ajax_login.js?v=<?php echo mktime(); ?>"></script>
</head>
<body>
    <div class="mainbody">
	<?php include_once("./includes/header.php");?>
    </div>
    <div class="maincontent">
	<div class="leftdiv">
	    <div class="lessonbg"><span class="lessontext">Topic List</span></div>
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
	       <span class="topicspan"><a href="<?php echo __WEBROOT__ ?>/<?php echo $arrUserInfo["curriculum_slug"]; ?>/">Chapter</a></span>
	   </div>
	   <div class="columdiv" style="margin-top:20px;">
	       <table cellpadding="0"id="tabLeadusers" name="tabLeadusers" cellspacing="0" border="0" width="100%;" class="mdata">
	       <thead>
		   <tr class='topicheading'>
		       <!--<th width='74px' valign='middle'  align="middle">#</th>-->
		       <th width='55px' valign='left' align="left" style='padding-left: 20px;color: #000;'>Code</th>
		       <th width='116px' valign='middle'  align="left"><span class="title">Topic</span> | <span style='color: #000;'>Chapter</span></th>
		       <th width='' valign='middle'  align="right" style="padding-right: 20px;color: #000;">Resources</th>
		   </tr>
	       </thead>
	       </table>
	       <div id="columdiv" class="columdiv"></div>
	   </div>
	   <div class="showmore" id="showmoretopic"></div>
	</div>
	<?php
	    include("./includes/footer.php");
	?>
    </div>
</body>
<script type="text/javascript">
    p.push(new Array('chkcurriculum', '<?php echo $currID; ?>'));
    _createFilterTopic('chkcurriculum', '<?php echo $currID; ?>', 'curriculum-<?php echo $currID; ?>','<?php echo $currID; ?>','<?php echo $chapID; ?>');
</script>
</html>