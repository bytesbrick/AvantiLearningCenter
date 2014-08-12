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
<!DOCTYPE HTML>
<html xml:lang="en" lang="en" itemscope="" itemtype="http://schema.org">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Avanti Learning Centres | Resource Detail</title>
<?php
    include_once("./includes/header-meta.php");
    $r = $db->query("stored procedure","res_des_select(" . $topicID . ")");
//    $res = $db->query("query","SELECT unique_id FROM avn_resources_detail WHERE topic_id = " . $topicID . " AND priority = " . $priority);
//    $selresources = $db->query("query","SELECT unique_id FROM avn_user_resource_item WHERE resource_item_id = " . $res[0]["unique_id"] . " AND userid = '" . $userid . "'");
//    if($selresources["response"] == "ERROR"){
//	$dataToSave = array();
//	$dataToSave["userid"] = $userid;
//	$dataToSave["topic_id"] = $topicID;
//	$dataToSave["resource_item_id"] = $res[0]["unique_id"];
//	$dataToSave["entry_date"] = "NOW()";
//	$dataToSave["priority"] = $priority;
//	$dataToSave["last_view_date"] = "NOW()";
//	$viewedres = $db->insert("avn_user_resource_item", $dataToSave);
//	unset($viewedres);
//	unset($selresources);
//	unset($res);
//    }
//    else
//	$updatelasteview = $db->query("query","UPDATE avn_user_resource_item SET last_view_date = now() WHERE resource_item_id = " . $res[0]["unique_id"] . " AND userid = '" . $userid . "'");
?>
<script type="text/javascript" src="<?php echo __WEBROOT__;?>/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="<?php echo __WEBROOT__;?>/js/resources.js"></script>
<!-- Google CDN jQuery with fallback to local -->
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>	-->
<!-- custom scrollbars plugin -->
<style>
    .content{width:95%; height:240px;overflow:auto; background:#fff;padding: 0 0 24px 7px;font-family:helvetica;}
</style>
</head>
<body style="background: #fff;">
    <div class="mainbody">
	<div style="float: left;width:100%;background: #BD2728;">
	    <div style="margin: 0 auto;width:975px;">
		<?php include_once("./includes/header.php");?>
	    </div>
	</div>
	<div class="clb"></div>
	    <div class="center">
		<div class="whole" style="/*margin: 130px 0px 0px 0px ;*/min-height:670px;">
		    <div class="clb"></div>
		    <div class="longdiv" style="padding-top: 17px;">			
			<?php include_once("./includes/leftdiv.php"); ?>
			<!--<div class="batchdiv">
			    <img src="<?php //echo __WEBROOT__; ?>/admin/images/upload-image/<?php //echo $r[0]["topic_image"]; ?>" width="218" style="padding: 3px;" />
			</div>-->
			<div class="batchdiv">
			    <div class="notediv">
				<div class="bookdiv">
				    <img src="<?php echo __WEBROOT__;?>/images/Lesson-25px.png" border="0" alt="" title="">
				</div>
				<span class="lessonsdiv">Resources</span>
				<div class="sidediv"></div>
			    </div>
			    <div style="float: left;width: 100%;margin-top: 5px;">
				<div id="content_1" class="content"></div>
				<div id="ResourcesDiv"><div id="ResourcesDivText"><br /><br /><img src="<?php echo __WEBROOT__; ?>/images/image.gif" /><br />Loading...</div></div>
			    </div>
			</div>
		    </div>
		    <?php
			if(!array_key_exists("response", $resourceRS)){
		    ?>
			    <div id="dimensionresource" class="dimensionresource">
				<div class="clb"></div>
				<div style="float: left;width: 100%;font-family: helvetica;font-size: 18px;">
				    <span class="updiv" style="padding: 30px 0 28px 11px;"><a href="<?php echo __WEBROOT__?>/<?php echo trim($_GET['currslug']); ?>/" class="textnone"><?php echo $curname; ?></a> &raquo; <a href="<?php echo __WEBROOT__?>/<?php echo trim($_GET['currslug']); ?>/<?php echo trim($_GET['catgslug']); ?>/<?php echo trim($_GET['chpslug']); ?>/" class="textnone"><?php echo $chaptername; ?></a> &raquo; <?php echo $topicname; ?></span>
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
	    </div>
	<?php
	    $db->close();
	    include_once("./includes/footer.php");
	?>
    </div>
</body>
<script>
    _link(document.getElementById('hdnTopicID').value, document.getElementById('hdnCurrP').value);
</script>
</html>