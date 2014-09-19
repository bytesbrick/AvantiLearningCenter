<?php
    include_once("./includes/config.php");
    include("./classes/cor.mysql.class.php");
    include_once("./includes/checklogin.php");
?>
<!DOCTYPE HTML>
<html xml:lang="en" lang="en" itemscope="" itemtype="http://schema.org">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Avanti Learning Centres | Class Schedule</title>
<head>
<?php
    include_once("./includes/header-meta.php");
    $db = new MySqlConnection(CONNSTRING);
    $db->open();	    
    $curslug = $arrUserInfo["curriculum_slug"];
    //echo $curslug;
    $selCur = $db->query("query","SELECT unique_id, curriculum_name FROM avn_curriculum_master WHERE curriculum_slug = '" . $curslug . "'");
    if(!array_key_exists("response" , $selCur))
	$curname = $selCur[0]["curriculum_name"];
	$currID = $selCur[0]["unique_id"];
    unset($selCur);
    $selbatch = $db->query("query","SELECT unique_id FROM avn_batch_master WHERE batch_id = '" . $arrUserInfo["batch_id"] . "'");
    if(!array_key_exists("response" , $selbatch))
	$batchID = $selbatch[0]["unique_id"];
    unset($selbatch);
    $curweek = date("W");
?>
<script type="text/javascript" language="javascript" src="<?php echo __WEBROOT__; ?>/js/schedule.js?v=<?php echo mktime(); ?>"></script>
</head>
<body>
    <div style="width:100%;"class="fl">
	<div style="width:100%;background: #BD2728;" class="fl">
	    <?php include_once("./includes/header.php");?>
	</div>
	<div class="maindiv" style="min-height: 737px;">
	    <div class="blackborderdiv">
		<div class="tabeldiv">
                    <div class="longdiv">
                        <?php
			    include_once("./includes/leftdiv.php");
                            $curweek = date("W");
                            $t=date('d-m-Y');
                            $curdate = date("D",strtotime($t));
                            $current_dayname = date("l");
                            $date = date("d M, Y",strtotime('monday this week')).' To '.date("d M, Y",strtotime("sunday this week"));
			?>
                    </div>
                    <div class="headingdiv">
                        <span class="updiv">
                            <div class="fl">
                                <img src="<?php echo __WEBROOT__; ?>/images/class-schedule.png" width="50" class="fl" alt="Lesson Plan" title="Lesson Plan" border="0">
                                <span class="fl" style="margin: 13px 0 0 5px;">Class Schedule</span><div class="clb"></div>
                            </div>
                            <div class="selsubject"></div>
                            <div class="fl">
                                <div class="fl mt10"></div>
                            </div>
                        </span>
                        <div class="columdiv">
                            <div style="float: left;padding: 10px;width:97%;"><div id="ErrMsg"></div></div>
                            <table cellpadding="0"id="tabLeadusers" name="tabLeadusers" cellspacing="0" border="0" width="100%;" class="mdata">
                                <thead>
                                    <tr class='headrow ffhelvetica'>
                                        <th width='50px' valign='middle'>&nbsp;</th>
                                        <th width='50px' valign='middle'></th>
                                        <th valign='top'>
                                            <div style="margin: 0 auto;width:87%;">
                                                <a href="javascript: void(0);" onclick='javascript: _getweek(document.getElementById("hdncurweek").value, 1,<?php echo $batchID; ?>);' style="color:#fff;font-size:27px;float: left;"><img src="<?php echo __WEBROOT__; ?>/images/less.png" width="20px;"></a> <span id='curweek' style='float: left;width:200px; margin: 0 75px; text-align: center;'><?php echo $date; ?></span><a href='javascript: void(0);' onclick='javascript: _getweek(document.getElementById("hdncurweek").value, 2,<?php echo $batchID; ?>);' style='color:#fff;font-size:27px;float: left;'><img src="<?php echo __WEBROOT__; ?>/images/grt.png" width="20px;"></a>
                                                <input type='hidden' name='hdncurweek' id='hdncurweek' value='<?php echo $curweek; ?>'>
                                                <input type='hidden' name='hdstartdate' id='hdstartdate' value='<?php echo  date("d M, Y",strtotime('monday this week')); ?>'>
                                                <input type='hidden' name='hdenddate' id='hdenddate' value='<?php echo date("d M, Y",strtotime("sunday this week")); ?>'>
                                            </div>
                                        </th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody id="daysList"></tbody>
                            </table>
                            <div class="divSchedule" id="Schedule"></div>
                        </div>
                    </div>
		</div>
	    </div>
	</div>
	<div class="footerindex"></div>
	<?php
	    $db->close();
	?>
    </div>   
</body>
<script type="text/javascript">
    _getweek(<?php echo $curweek; ?>, 0,<?php echo $batchID; ?>)
</script>
</html>