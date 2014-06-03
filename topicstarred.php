<?php
    include_once("./includes/config.php");
    include("./classes/cor.mysql.class.php");
    include_once("./includes/checklogin.php");
?>
<!DOCTYPE HTML>
<html xml:lang="en" lang="en" itemscope="" itemtype="http://schema.org">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Avanti Learning Centres | Starred Topics</title>
<head>
<?php
    include_once("./includes/header-meta.php");
    $db = new MySqlConnection(CONNSTRING);
    $db->open();	    
    $curslug = $arrUserInfo["curriculum_slug"];
    $selCur = $db->query("query","SELECT curriculum_name FROM avn_curriculum_master WHERE curriculum_slug = '" . $curslug . "'");
    if(!array_key_exists("response" , $selCur))
	$curname = $selCur[0]["curriculum_name"];
    unset($selCur);
?>
<script type="text/javascript" language="javascript" src="<?php echo __WEBROOT__; ?>/js/lesson-plan.js?v=<?php echo mktime(); ?>"></script>
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
			?>
                    </div>
                    <div class="headingdiv">
                        <span class="updiv">
			    <div class="fl">
				<a href="javascript: void(0);" onclick="javascript: void(0);"><img src="<?php echo __WEBROOT__; ?>/images/starred.png" width="50" class="fl" alt="Lesson Plan" title="Lesson Plan" border="0"></a>
                                <span class="fl" style="margin: 13px 0 0 5px;">Starred Topics</span><div class="clb"></div>
			    </div>
                            <div class="clb"></div>
			    <div class="selsubject">
				<?php
                                    $action = "Starred";
				    include_once("./includes/filters.php");
				?>
			    </div>
			    <div class="fl">			    
				<div class="fl mt10">
				    <span class="selectall"><a href="javascript:void(0);" style="color: #666;margin-right: 20px;" name="chpAll" id="chpAll" onclick="javascript: _checked(this, -1, 2);">Select All</a></span>
				    <span class="fl ft12" id="linkAct" style="display: none;">
					<a href="javascript: void(0);" style="color: #666;" onclick="javascript: _starred(-1,0);">Mark Unstarred</a>
				    </span>
				</div>
                            </div>
                        </span>
                        <div class="columdiv">
			    <div style="float: left;padding: 10px;width:97%;"><div id="ErrMsg"></div></div>
                            <table cellpadding="0"id="tabLeadusers" name="tabLeadusers" cellspacing="0" border="0" width="100%;" class="mdata">
                                <thead>
				    <tr class='headrow ffhelvetica'>
					<th width='50px' valign='middle'>&nbsp;</th>
					<th width='50px' valign='middle'>#</th>
					<th valign='top'>Code Topic<br /><small>Chapter | Subject</small></th>
					<th>&nbsp;</th>
				    </tr>
				</thead>
				<tbody id="topicsList">				    
				</tbody>
                            </table>
                            <div id="loader"></div>
                        </div>
                    </div>
		</div>
	    </div>
	</div>
	<div class="footerindex"></div>
    </div>   
</body>
<script type="text/javascript">
    p.push(new Array("action", "Starred"));
    p.push(new Array("page", "1"));
    _applyFilter();
</script>
</html>