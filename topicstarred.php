<?php
   error_reporting(0);
   include_once("./includes/config.php");
   include("./classes/cor.mysql.class.php");
   include_once("./includes/checklogin.php");
   $db = new MySqlConnection(CONNSTRING);
   $db->open();
   $curslug = $arrUserInfo["curriculum_slug"];
   $selCur = $db->query("query","SELECT unique_id, curriculum_name FROM avn_curriculum_master WHERE curriculum_slug = '" . $curslug . "'");
   if(!array_key_exists("response" , $selCur))
      $curname = $selCur[0]["curriculum_name"];
      $currID = $selCur[0]["unique_id"];
   unset($selCur);
?>
<html xml:lang="en" lang="en" itemscope="" itemtype="http://schema.org">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<head>
<title>Avanti Learning Centres | Starred Topics</title>
<link rel="stylesheet" type="text/css" href="<?php echo __WEBROOT__ ?>/css/home-style.css?v=<?php echo mktime(); ?>" />
<script type="text/javascript" src="<?php echo __WEBROOT__; ?>/js/ajax.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo __WEBROOT__; ?>/js/lesson-plan.js?v=<?php echo mktime(); ?>"></script>
</head>
<body>
    <div class="mainbody">
	    <?php include_once("./includes/header.php");?>
	    <div class="maincontent">
		<div class="leftdiv">
		    <div class="lessonbg"><span class="lessontext">Starred Topics</span></div>
		    <span class="filter">Filters</span>
		    <div class="topics">
			 <span class="checkboxFive"><input type="checkbox" name="chktopicdetails" id="chkAllsubject" class="checkbox1" checked="checked" /><label for="chkAllsubject"></label></span>
			 <span class="topic">All Subjects</span>
		   </div>
		   <?php
			$action = "Starred";
		      $selcategory = "SELECT unique_id ,category_name FROM ltf_category_master WHERE curriculum_id = " . $currID;
		      $selcategoryRS = $db->query("query", $selcategory);
		      if(!array_key_exists("response", $selcategoryRS)){
			 for($i = 0; $i < count($selcategoryRS); $i++){
		   ?>
			    <div class="topics">
			       <span class="checkboxFive">
				<input type="checkbox" id="chkSubject-<?php echo $selcategoryRS[$i]["unique_id"]; ?>" name="chkcategory" class="fl" value="<?php echo $selcategoryRS[$i]["unique_id"]; ?>" onclick="javascript: _subjectFilter('chkAllsubject','chkSubject',this.id,this.value, 'single');" value="<?php echo $selcategoryRS[$i]["unique_id"]; ?>"><label for="chkSubject-<?php echo $selcategoryRS[$i]["unique_id"]; ?>"></label></span>
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
			<span class="topicspan"><a href="<?php echo __WEBROOT__; ?>/lesson-plan/">Lesson Plan</a></span>
			<span class="topicspan"><a href="<?php echo __WEBROOT__; ?>/topics-completed/">Completed</a></span>
			<span class="topicspan"><a href="<?php echo __WEBROOT__ ?>/<?php echo $arrUserInfo["curriculum_slug"]; ?>/">Chapter</a></span>
		    </div>
		    <div class="fl">			    
			<div class="fl">
			    <span class="black selectall ft14"><a href="javascript:void(0);" class='black' name="chpAll" id="chpAll" onclick="javascript: _checked(this, -1, 2);" style='padding-left: 20px;margin-top: 22px;float: left;'>Select All</a></span>
			    <span class="fl ft12" id="linkAct" style="display: none;">
				<a href="javascript: void(0);" class='ft14 black' onclick="javascript: _starred(-1,0);" style='padding-left: 20px;margin-top: 22px;float: left;'>Mark Unstarred</a>
			    </span>
			</div>
		    </div>
		    <div class="columdiv">
			<div style="float: left;padding: 10px;width:97%;"><div id="ErrMsg"></div></div>
			<table cellpadding="0"id="tabLeadusers" name="tabLeadusers" cellspacing="0" border="0" width="100%" class="mdata" style='table-layout: fixed;'>
			    <thead>
				<tr class='topicheading'>
				  <th valign='middle' align="middle" class='black' width='155px'>#</th>
				  <th valign='middle' align="left" class='black' width='57px'>Code</th>
				  <th valign='middle' align="left" class='black' width='154px'><span class="title">Topic</span> | Chapter</th>
				  <th valign='middle' align="right" class='black' width='173px'>Subject</th>
				  <th valign='middle' align="right" class='black'>Resources</th>
			      </tr>
			    </thead>
			    <table cellpadding="0"id="topicsList" name="topicsList" cellspacing="0" border="0" width="100%;" class="mdata"></table>
			</table>
			<div id="loader"></div>
		    </div>
		</div>
		<?php
		    include("./includes/footer.php");
		    $db->close();
		?>
	    </div>
	</div>
    </div>
</body>
<script type="text/javascript">
    p.push(new Array("action", "Starred"));
    p.push(new Array("page", "1"));
    _applyFilter();
</script>
</html>