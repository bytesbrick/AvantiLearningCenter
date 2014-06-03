<?php
    include_once("./includes/config.php");     
    include("./classes/cor.mysql.class.php");
    $db = new MySqlConnection(CONNSTRING);
    $db->open();
    
    $sql = "SELECT unique_id FROM avn_curriculum_master WHERE curriculum_slug = '" . mysql_escape_string($_GET['currslug']) . "'";
    $r = $db->query("query", $sql);
    if(!array_key_exists("response", $r)){
	$currID = $r[0]["unique_id"];
    } else {
	header("Location: " . __WEBROOT__ . "/page-not-found/");
    }
?>
<!DOCTYPE HTML>
<html xml:lang="en" lang="en" itemscope="" itemtype="http://schema.org">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Avanti Learning Centres | Chapter-list</title>
<?php
    include_once("./includes/header-meta.php"); 
?>
</head>
<body style="background: #fff;">
<div class="mainbody">
    <?php
	include_once("./includes/header.php");
    ?>
    <div class="clb"></div>
    <div class="center">
	<div class="midcolumn">
	    <?php
		include_once("./includes/leftdiv.php");
	    ?>
	    <div class="outercentrediv">
		<div class="textchapter">Chapters</div>
		<div class="dimension" id="dimension"></div>
	       <div class="showmore" id="showmore"></div>
	    </div>
	</div>
    </div><!-- center div ends -->
</div>
<div class="footerindex"></div>
<script type="text/javascript">
    p.push(new Array("chkcurriculum", '<?php echo $currID; ?>'));
    _createFilter('chkcurriculum', '<?php echo $currID; ?>', 'curriculum-<?php echo $currID; ?>', <?php echo $currID; ?>);
</script>
</body>
</html>