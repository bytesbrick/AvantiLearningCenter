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
<title>Avanti Learning Centres | Lesson Plan</title>
<?php
   include("./includes/header-meta.php");
?>
<script type="text/javascript" src="<?php echo __WEBROOT__; ?>/js/ajax.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo __WEBROOT__; ?>/js/lesson-plan.js?v=<?php echo mktime(); ?>"></script>
</head>
<body>
    <div class="mainbody">
      <?php
	 include_once("./includes/header.php")
      ?>
        <div class="maincontent">
            <div class="leftdiv">
                <div class="lessonbg"><span class="lessontext">Lesson Plan</span></div>
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
			   <span class="checkboxFive"><input type="checkbox" name="chkSubject" id="chkSubject-<?php echo $selcategoryRS[$i]["unique_id"]; ?>" class="checkbox1" onclick="javascript: _subjectFilter('chkAllsubject','chkSubject',this.id,this.value, 'single');" value="<?php echo $selcategoryRS[$i]["unique_id"]; ?>" /><label for="chkSubject-<?php echo $selcategoryRS[$i]["unique_id"]; ?>"></label></span>
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
                <div class="columdiv">
		  <div style="float: left;padding: 10px;width:97%;"><div id="ErrMsg"></div></div>
		 <div class="fl">
		     <div class="select">
			 <span class="selectall"><a href="javascript:void(0);" class="black" name="chpAll" id="chpAll" onclick="javascript: _checked(this, -1, 2);">Select All</a></span>
			 <span class="fl ft12" id="linkAct" style="display: none;">
			     <a href="javascript: void(0);" class="black" onclick="javascript: _complete(-1,1);">Mark Complete</a><a href="javascript: void(0);" class="black" onclick="javascript: _starred(-1,1);">Mark Starred</a>
			 </span>
		     </div>
		 </div>
		  <table cellpadding="0"id="tabLeadusers" name="tabLeadusers" cellspacing="0" border="0" style='table-layout:fixed;' width="100%;" class="mdata">
		      <thead>
			  <tr class='topicheading'>
			      <th width='66px' valign='middle'  align="left">&nbsp;</th>
			      <th width='38px' valign='middle' align="left" class="black">#</th>
			      <th width='90px' valign='middle' align="left" class="black">Code</th>
			      <th width='222px' valign='middle'  align="left" class="black"><span class="title">Topic</span> | Chapter</th>
			      <th width='112px' valign='middle'  align="left" class="black">Subject</th>
			      <th width='86px' valign='middle'  align="left" class="black">Resources</th>
			  </tr>
		      </thead>
		      <tbody id='topicsList'></tbody>
		  </table>
		  <div id="loader"></div>
	      </div>
            </div>
            <?php
	       include("./includes/footer.php");
	    ?>
        </div>
    </div>
</body>
<script type="text/javascript">
    p.push(new Array("action", "Incomplete"));
    p.push(new Array("page", "1"));
    _applyFilter();
</script>
</html>