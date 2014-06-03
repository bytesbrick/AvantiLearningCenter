<!DOCTYPE HTML>
<html xml:lang="en" lang="en" itemscope="" itemtype="http://schema.org">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Avanti Learning Centres | Chapter-List</title>
<head>
    <?php
	//include_once("./includes/checkLogin.php");
	include_once("./includes/config.php");
	include_once("./includes/header-meta.php");
	if(isset($_COOKIE["cUserName"]))
	    $UserName = $_COOKIE["cUserName"];
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
</head>
<body>
    <div style="width:100%;float: left;">
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
			<span class="updiv"></span>
			<div class="columdiv" id="columdiv"></div>
			<div class="showmore" id="showmore"></div>
		    </div>
		</div>
	    </div>
	</div>
    <div class="footerindex"></div>
    </div>   
</body>
<script type="text/javascript">
    p.push(new Array("chkcurriculum", '<?php echo $currID; ?>'));
    _createFilter('chkcurriculum', '<?php echo $currID; ?>', 'curriculum-<?php echo $currID; ?>', <?php echo $currID; ?>);
</script>
</html>