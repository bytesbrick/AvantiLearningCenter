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
<!DOCTYPE HTML>
<html xml:lang="en" lang="en" itemscope="" itemtype="http://schema.org">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Avanti Learning Centres | Chapter List</title>
<head>
    <?php
	include_once("./includes/header-meta.php");
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
<!--<style>
    .content{width:95%; height:240px;overflow:auto; background:#fff;padding: 0 0 24px 0px;font-family:helvetica;}
</style>-->
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
			<span class="updiv">
			    <div class="fl">
				<img src="<?php echo __WEBROOT__; ?>/images/lesson-plan.png" width="50" class="fl" alt="Lesson Plan" title="Lesson Plan" border="0">
				<span class="fl" style="margin: 13px 0 0 5px;">Chapters</span><div class="clb"></div>
			    </div>
			    <div class="selsubject">
				<span style="float: left;width:100%;padding: 5px 5px 5px 0;">Filters</span>
				<?php
				    $batchSubjects = "SELECT lcm.unique_id,lcm.category_name FROM ltf_category_master lcm INNER JOIN avn_curriculum_master acm ON acm.unique_id = lcm.curriculum_id WHERE acm.unique_id = " . $currID;
				    $batchSubjectsRS = $db->query("query", $batchSubjects);
				    if(!array_key_exists("response", $batchSubjectsRS)){
				?>
					<div class="filterall">
					    <input type="checkbox" id="chkAllsubject" name="chkAllsubject" class="fl"  checked="checked" onclick="javascript: _createFilter('chkAllsubject','chkcategory', '<?php echo $currID; ?>', this.id,<?php echo $currID; ?>, 'all');">
					    <span class="fl" style="font-family: helvetica;font-size:13px;">All Subjects</span>
					</div>
				<?php
					for($s = 0; $s < count($batchSubjectsRS); $s++){
				?>
					    <div class="chksubject">
						<input type="checkbox" id="chklevel-<?php echo $r[$i]["unique_id"]; ?>" name="chkcategory" class="fl" value="<?php echo $batchSubjectsRS[$s]["unique_id"]; ?>" onclick="javascript: _createFilter('chkAllsubject','chkcategory', this.value, this.id,<?php echo $currID; ?>, 'single');" value="<?php echo $r[$i]["unique_id"]; ?>">
						<span class="subject"><?php echo $batchSubjectsRS[$s]["category_name"]; ?></span>
					    </div>
				<?php
					}
				    }
				    unset($batchSubjectsRS);
				    $db->close();
				?>
			    </div>
			</span>
			<div class="columdiv">
			    <table cellpadding="0" cellspacing="0" border="0" width="100%" min-height="100%">
				<tr class="headrow ffhelvetica">
				    <th valign="middle" width="120">#</th>
				    <th valign="middle" align="left">Code - Chapter<br /><small>Description<br />Subject | Topic | Time</small></th>
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
    _applyFilter();
</script>
</html>