<?php
    include_once("./includes/config.php");  
    include("./classes/cor.mysql.class.php");
    include_once("./includes/checklogin.php");
    if(trim($_GET['currslug']) != trim($arrUserInfo["curriculum_slug"])){
	$redPath = __WEBROOT__ . "/logout.php";
	header("Location: " . $redPath);
    }
?>
<!DOCTYPE HTML>
<html xml:lang="en" lang="en" itemscope="" itemtype="http://schema.org">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Avanti Learning Centres | Topic List</title>
<head>
    <?php
	include_once("./includes/header-meta.php");
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
</head>
<body>
    <div style="float: left;width:100%;background: #BD2728;">
	<?php include_once("./includes/header.php");?>
    </div>
    <div class="maindiv" style="min-height: 737px;">
        <div class="blackborderdiv">
            <div class="tabeldiv">
                <?php
		    include_once("./includes/leftdiv.php");
		?>
                <div class="headingdiv">
		    <span class="updiv" style="padding: 30px 0 28px 10px;">Chapters &raquo; Topics</span>
                    <div class="columdiv mt10">
			<table cellpadding="0" cellspacing="0" border="0" width="100%" min-height="100%">
			    <tr class="headrow ffhelvetica">
				<th valign="middle" width="115">#</th>
				<th valign="middle" align="left">Code - Topic<br /><small>Description | Time</small></th>
				<th>&nbsp;</th>
			    </tr>
			    <tr>
				<td colspan="3">
				    <span style="margin-bottom: 10px;float: left;width: 100%;"></span>
				</td>
			    </tr>
			</table>
			<div id="columdiv" class="columdiv"></div>
		    </div>
		    <div class="showmore" id="showmoretopic"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="footerindex"></div>
</body>
<script type="text/javascript">
    p.push(new Array('chkcurriculum', '<?php echo $currID; ?>'));
    _createFilterTopic('chkcurriculum', '<?php echo $currID; ?>', 'curriculum-<?php echo $currID; ?>','<?php echo $currID; ?>','<?php echo $chapID; ?>');
</script>
</html>