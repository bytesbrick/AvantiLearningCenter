<?php
    include_once("./includes/config.php");  
    include("./classes/cor.mysql.class.php");
    include_once("./includes/checklogin.php");
    $db = new MySqlConnection(CONNSTRING);
    $db->open();
    $userid = $arrUserInfo["userid"];
    $topicID = 0;
    $sql = "SELECT unique_id,curriculum_name FROM avn_curriculum_master WHERE curriculum_slug = '" . mysql_escape_string($_GET['currslug']) . "'";
    $r = $db->query("query", $sql);
    if(!array_key_exists("response", $r)){
	$currID = $r[0]["unique_id"];
	$curname = $r[0]["curriculum_name"];
	$sql = "SELECT unique_id,chapter_name FROM avn_chapter_master WHERE chapter_slug = '" . mysql_escape_string($_GET['chpslug']) . "'";
	$c = $db->query("query", $sql);
	if(!array_key_exists("response", $c)){
	    $chapID = $c[0]["unique_id"];
	    $chaptername = $c[0]["chapter_name"];
	    $sql = "SELECT unique_id,topic_name FROM avn_topic_master WHERE topic_slug = '" . mysql_escape_string($_GET['topicslug']) . "'";
	    $ts = $db->query("query", $sql);
		if(!array_key_exists("response", $ts)){
		    $topicID = $ts[0]["unique_id"];
		    $topicname = $ts[0]["topic_name"];
		} else {
		    header("Location: " . __WEBROOT__ . "/page-not-found/?1");
		}
	} else {
	    header("Location: " . __WEBROOT__ . "/page-not-found/?2");
	}
    } else {
	header("Location: " . __WEBROOT__ . "/page-not-found/?3");
    }
    unset($r);
    $priority = "0";
    $sql = "SELECT MIN(priority) as priority FROM avn_resources_detail WHERE topic_id = " . $topicID . " AND status = 1";
    $priorityRS = $db->query("query", $sql);
    if(!array_key_exists("response", $priorityRS)){
	if($priorityRS[0]['priority'] != "")
	$priority = $priorityRS[0]['priority'];
    }
    $encTopicID = $db->_encrypt($topicID, ENCKEY);
?>
<html xml:lang="en" lang="en" itemscope="" itemtype="http://schema.org">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<head>
<title>Avanti Learning Centres | Resources Details</title>
<?php
    include_once("./includes/header-meta.php");
?>
<script type="text/javascript" src="<?php echo __WEBROOT__; ?>/js/ajax.js"></script>
<link rel="stylesheet" href="<?php echo __WEBROOT__; ?>/css/jquery.1.10.3.css" />
<script src="<?php echo __WEBROOT__; ?>/js/jquery.1.9.1.js"></script>
<script src="<?php echo __WEBROOT__; ?>/js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo __WEBROOT__; ?>/css/jquery.mCustomScrollbar.css" />
<script type="text/javascript" src="<?php echo __WEBROOT__;?>/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="<?php echo __WEBROOT__;?>/js/resources.js"></script>
</head>
<body>
    <div class="mainbody">
	<?php include_once("./includes/header.php");?>
	<div class="maincontent">
	    <div class="leftdiv">
		<div class="lessonbg"><span class="lessontext">Resources</span></div>
		<div style="float: left;width: 100%;margin-top: 3px;height:42%;">
		    <div id="content_1" class="content"></div>
		    <div id="ResourcesDiv"><div id="ResourcesDivText"><br /><br /><img src="<?php echo __WEBROOT__; ?>/images/image.gif" /><br />Loading...</div></div>
		</div>
	    </div>
	    <div class="rightdiv">
		<div class="righttopdiv">
		    <span class="topicspan"><a href="<?php echo __WEBROOT__; ?>/lesson-plan/">Lesson Plan</a></span>
		    <span class="topicspan"><a href="<?php echo __WEBROOT__; ?>/topics-completed/">Completed</a></span>
		    <span class="topicspan"><a href="<?php echo __WEBROOT__ ?>/<?php echo $arrUserInfo["curriculum_slug"]; ?>/">Chapter</a></span>
		</div>
		<?php
		    if(!array_key_exists("response", $resourceRS)){
		?>
			<div id="dimensionresource" class="dimensionresource">
			    <div class="clb"></div>
			    <div style="float: left;width: 100%;">
				<span class="updiv" style="padding: 15px 0 12px 11px;"><a href="<?php echo __WEBROOT__?>/<?php echo trim($_GET['currslug']); ?>/" class="textnone"><?php echo $curname; ?></a> &raquo; <a href="<?php echo __WEBROOT__?>/<?php echo trim($_GET['currslug']); ?>/<?php echo trim($_GET['catgslug']); ?>/<?php echo trim($_GET['chpslug']); ?>/" class="textnone"><?php echo $chaptername; ?></a> &raquo; <?php echo $topicname; ?></span>
			    </div> 
		<?php
			    $sql = "SELECT MIN(priority) as fPriority FROM avn_resources_detail WHERE topic_id = " . $topicID . " AND status = 1";
			    $priorityRS = $db->query("query", $sql);
			    if(!array_key_exists("response", $priorityRS))
				$priority = $priorityRS[0]["fPriority"];
		?>
			    <span class="pd8 fr"><a href="javascript:void(0);" id="nextLink" name="nextLink" onclick="javascript: _changeURL(document.getElementById('hdnNextP').value);_link(document.getElementById('hdnTopicID').value, document.getElementById('hdnNextP').value);" class="nexttext">Next &raquo;</a></span>
		    
			    <span class="pd8 fl"><a href="javascript:void(0);" id="prevLink" name="prevLink" onclick="javascript: _changeURL(document.getElementById('hdnPrevP').value);_link(document.getElementById('hdnTopicID').value, document.getElementById('hdnPrevP').value);" class="nexttext">&laquo; Previous</a></span>
		<?php
		    }
		?>
			<div class="resourceinfo">
			    <div id="displayUser">
				<input type='hidden' name='hdnNextP' id='hdnNextP' value=''>					
				<input type='hidden' name='hdnPrevP' id='hdnPrevP' value=''>
				<input type='hidden' name='hdnCurrP' id='hdnCurrP' value='<?php echo $priority; ?>'>
				<input type='hidden' name='hdnTopicID' id='hdnTopicID' value='<?php echo $encTopicID; ?>'>
			    </div><!-- end of displayUser -->
			    <div id="disableDiv"><div id="disableText"><br /><br /><img src="<?php echo __WEBROOT__; ?>/images/image.gif" /><br />Loading...</div></div>
			</div>
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
<script>
    _link(document.getElementById('hdnTopicID').value, document.getElementById('hdnCurrP').value);
</script>
</html>