<?php 
    include_once("./includes/checklogin.php");
    $userid = $_COOKIE["userID"];
?>
<!DOCTYPE HTML>
<html xml:lang="en" lang="en" itemscope="" itemtype="http://schema.org">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Avanti Learning Centres | Resource-Detail</title>
<?php

    include_once("./includes/header-meta.php");
    include_once("./includes/config.php");  
    include("./classes/cor.mysql.class.php");
    $db = new MySqlConnection(CONNSTRING);
    $db->open();
?>
</head>
<body>
    <div class="mainbody">
	<?php
	    include_once("./includes/header.php");
	?>
	<div class="clb"></div>
	    <div class="center">
		<div class="whole" style="margin: 130px 0px 0px 0px ;">
		    <div class="clb"></div>
		    <?php
			$count = $db->query("query","SELECT COUNT(unique_id) as total FROM avn_resources_detail WHERE topic_id = " . $_GET['tpID']);
			$cntres = $count[0]['total'];
			$r=$db->query("stored procedure","res_des_select(".$_GET['tpID'].")");
			if(!isset($r['response'])){
		    ?>
		    <div class="dimensionresource" id="dimensionresource">
		    	<?php
			    $priority = 1;
			    if(isset($_GET['q']) && $_GET['q'] != "")
			    $priority = $_GET['q'];
			    
			    if(isset($_GET['tpID']) && $_GET['tpID'] != "")
			    {
				$sql = $db->query("query","SELECT * FROM avn_resources_detail WHERE topic_id = " .$_GET['tpID'] . " AND priority = " . $priority . " order by priority ASC");
				$type =$sql[0]['content_type'];
			    ?>
				    <div class="resourceactive"><?php echo ucwords($sql[0]['title']); ?></div>
				    <div class="clb"></div>
				    <div class="resourcecontent">
					<div class="preread"><?php echo $sql[0]['text']; ?></div>
			    <?php
					$isPrev = false;
					$isNext = false;
					if($priority > 1){
					    $isPrev = true;
					    $lpriority = $priority - 1;
					}
					if($priority < $cntres){
					    $isNext = true;
					    $npriority = $priority + 1;
					}
					
					if($isPrev)
					{
				    ?>
					    <span class="next fl mr20"><a href="./resource-detail.php?tpID=<?php echo $_GET['tpID']; ?>&q=<?php echo $lpriority; ?>" class="nexttext">prev</a></span>
				    <?php
					}
					if($isNext){
				    ?>
					    <span class="next fr mr20"><a href="./resource-detail.php?tpID=<?php echo $_GET['tpID']; ?>&q=<?php echo $npriority; ?>" class="nexttext">next</a></span>
				    <?php
					    }
				    ?>
				    </div>
			<?php
				}
			    if(isset($_GET['q'])&& $_GET['q'] == "spot-test"){
				$st = $db->query("query","select qm.unique_id,qm.question_name,qm.resource_id,qm.option1,qm.option2,qm.option3,qm.option4,qm.correct_answer from avn_question_master qm left outer join ltf_resources_master rm on rm.unique_id = qm.resource_id where rm.topic_id = " . $_GET['tpID'] . " and type= 1 and status =1 AND NOT qm.unique_id IN (SELECT test_id FROM user_test_answer WHERE user_id = '". $userid . "' and topic_id =" . $_GET['tpID'] . ") order by unique_id asc");
			?>

				<div class="clb"></div>
				<div class="ansoption">
			<?php
				if(array_key_exists("response", $st)){
				    
			?>
				    <table cellspacing="4" cellpadding="0" border="0" width="100%">
					    <input type="hidden" name="hdnuserid" id="hdnuserid" value="<?php echo $userid ;?>" />
					    <input type="hidden" name="hdntpid" id="hdntpid" value="<?php echo $_GET['tpID'] ;?>" />
					    <tr>
						<td class="fl red" style="font-size: 15px;margin: 0px 0px 10px 0px ;">
						    <?php  echo "You have already appeared for this spot-test <br />";?>
						</td>
					    </tr>
					<?php
					    $st = $db->query("query","select distinct qm.unique_id,qm.question_name,qm.option1,qm.option2,qm.option3,qm.option4,qm.correct_answer,ua.is_correct,ua.answer_option from avn_question_master qm inner join ltf_resources_master rm on rm.unique_id = qm.resource_id inner join user_test_answer ua on ua.test_id = qm.unique_id where  rm.topic_id = ". $_GET['tpID']."  and type = 1 and ua.user_id = '" .$userid . "'");
					    for($v=0;$v<count($st);$v++)
					    {
					?>
						<input type="hidden" name="hdnqesid[]" id="hdnqesid" value="<?php echo $st[$v]['unique_id']; ?>" />
						<tr>
						    <td><?php echo $v+1 . "."; ?><?php echo $st[$v]["question_name"]; ?></td>
						</tr>
						<tr>
						    <td class="fl ml10">
							<?php					    
							for($opt = 1; $opt <= 4; $opt++)
							{
							    $class = "black";
							    if($st[$v]["is_correct"] == 1 && $st[$v]["answer_option"] == $opt)
								$class = "green";
							    elseif($st[$v]["is_correct"]!= 1 && $st[$v]["answer_option"] == $opt)
								$class = "red";
					?>
							    <span class="<?php echo $class; ?>"><?php echo $st[$v]["option" . $opt]; ?></span><br />
					<?php
							}
					?>
						    </td>
						</tr>
					<?php
					    }
					    $sc = $db->query("stored procedure","avn_spotest_score('" .$userid . "')");
					    if(!isset($sc['response'])){
					?>
						<tr>
						    <td class="red mt10" style="font-size: 15px;">
							Score <?php echo $sc[0]['score']; ?>
						    </td>
						    <td class="fr">
							<?php
							    if($r[0]['video_url'] == ""){
							?>
								<span class="next fr mr20 mt10"><a href="./resource-detail.php?tpID=<?php echo $_GET['tpID']; ?>&q=concept-test" class="nexttext" >next</a>
							<?php
							    }else{
							?>
								<span class="next fr mr20 mt10"><a href="./resource-detail.php?tpID=<?php echo $_GET['tpID']; ?>&q=video" class="nexttext" >next</a>
							<?php
							    }
							?>
							</span>
						    </td>
						</tr>
					<?php
					    }
					    unset($sc);
					?>
					</table>
			<?php
				} else {
			?>
				    <form method="post" name="formsbmtanswer" id="formsbmtanswer" action="save-submit-answer.php" onsubmit="return validateForm();">
					<table cellspacing="4" cellpadding="0" border="0" width="100%">
					    <input type="hidden" name="hdnuserid" id="hdnuserid" value="<?php echo $userid ;?>" />
					    <input type="hidden" name="hdntpid" id="hdntpid" value="<?php echo $_GET['tpID'] ;?>" />
					    <input type="hidden" name="hdnresid" id="hdnresid" value="<?php echo $st[0]['resource_id'] ;?>" />
					<?php
					    $optionid = "";
					    for($v=0;$v<count($st);$v++){
						$optionid .= $optionid == "" ? $st[$v]['unique_id'] : "," . $st[$v]['unique_id'];
					?>
						<input type="hidden" name="hdnqesid[]" id="hdnqesid-<?php echo $st[$v]['unique_id']; ?>" value="<?php echo $st[$v]['unique_id']; ?>" />
						<tr>
						    <td><div class="fl" id="question-<?php echo $st[$v]['unique_id']; ?>" name="question"><?php echo $v+1 . "."; ?><?php echo $st[$v]["question_name"]; ?></div></td>
						</tr>
						<tr>
						    <td class="fl"><input type="radio" id="rd<?php echo $st[$v]['unique_id']; ?>" name="rdoption<?php echo $st[$v]['unique_id']; ?>" value="1"></td>
						    <td class="fl ml10">
							<?php echo $st[$v]["option1"]; ?>
						    </td>
						</tr>
						<tr>
						    <td class="fl"><input type="radio" id="rd<?php echo $st[$v]['unique_id']; ?>" name="rdoption<?php echo $st[$v]['unique_id']; ?>" value="2"></td>
						    <td class="fl ml10">
							<?php echo $st[$v]["option2"]; ?>
						    </td>
						</tr>
						<tr>
						    <td class="fl"><input type="radio" id="rd<?php echo $st[$v]['unique_id']; ?>" name="rdoption<?php echo $st[$v]['unique_id']; ?>" value="3"></td>
						    <td class="fl ml10">
							<?php echo $st[$v]["option3"]; ?>
						    </td>
						</tr>
						<tr>
						    <td class="fl"><input type="radio" id="rd<?php echo $st[$v]['unique_id']; ?>" name="rdoption<?php echo $st[$v]['unique_id']; ?>" value="4"></td>
						    <td class="fl ml10">
							<?php echo $st[$v]["option4"]; ?>
						    </td>
						</tr>
					<?php
					    }
					?>
					</table>
					<input type="hidden" name="hdnoption" id="hdnoption" value="<?php echo $optionid ; ?>" />
					<div class="fl mt20">
					    <input type="submit" name="btnSubmit" id="btnSubmit" class="btnSIgn" value="Submit" />
					</div>
				    </form>
				<?php
				    }
				?>
				    <div class="clb"></div>
				</div>
			    <?php
				}
			    unset($st);
			    ?>
			<?php
			     if(isset($_GET['q'])&& $_GET['q'] == "video"){
				$vid = $db->query("stored procedure","res_video_select(".$_GET['tpID'].")");
			?>
				<div class="resourceactive mb20">Video</div>
				<div class="clb"></div>
				<?php
				    for($v=0;$v<count($vid);$v++){					    
				?>
					<div class="videodiv"><?php echo $vid[$v]["video_url"]; ?></div>
				<?php
				    }
				?>	
				<div class="clb"></div>
				<span class="next"><a href="<?php echo $_SERVER["HTTP_REFERER"];?>" class="nexttext" >prev</a></span>
				<span class="next fr mr20"><a href="./resource-detail.php?tpID=<?php echo $_GET['tpID']; ?>&q=concept-test" class="nexttext">next</a></span>
			<?php
			    }
			    unset($vid);
			?>
			<?php
			    if(isset($_GET['q'])&& $_GET['q'] == "concept-test"){
			?>
				<div class="resourceactive mb20">Concept Test</div>
				<div class="clb"></div>
				<?php
				    
				    $sel = $db->query("query","SELECT qm.question_name,qm.unique_id,qm.explanation,qm.option1,qm.option2,qm.option3,qm.option4, qm.correct_answer from avn_question_master qm inner join ltf_resources_master rm on rm.unique_id = qm.resource_id where qm.type = 2 and rm.topic_id =" . $_GET['tpID'] . " AND NOT qm.unique_id IN (SELECT test_id FROM user_test_answer WHERE user_id = '". $userid . "' and topic_id =" . $_GET['tpID'] . ")");
				    if(array_key_exists("response", $sel)){
				?>
				    <div class="ansoption">
				    <form method="post" name="formsbmtanswer" id="formsbmtanswer" action="save-concept-answer.php" onsubmit="return conceptvalidateForm();">
					<table cellspacing="4" cellpadding="0" border="0" width="100%">
					    <input type="hidden" name="hdnuserid" id="hdnuserid" value="<?php echo $userid ;?>" />
					    <input type="hidden" name="hdntpid" id="hdntpid" value="<?php echo $_GET['tpID'] ;?>" />
					    <tr>
						<td class="fl red" style="font-size: 15px;margin: 0px 0px 10px 0px ;">
						    <?php  echo "You have already appeared for this Concept-test <br />";?>
						</td>
					    </tr>
					<?php
					    $sel = $db->query("query","select distinct qm.unique_id,qm.question_name,qm.option1,qm.option2,qm.option3,qm.option4,qm.correct_answer,qm.explanation,ua.is_correct,ua.answer_option from avn_question_master qm inner join ltf_resources_master rm on rm.unique_id = qm.resource_id inner join user_test_answer ua on ua.test_id = qm.unique_id where  rm.topic_id = ". $_GET['tpID']."  and type = 2 and ua.user_id = '" .$userid . "' order by unique_id asc");
					    //print_r($sel);
					    for($v=0;$v<count($sel);$v++)
					    {
					?>
						<input type="hidden" name="hdnqesid" id="hdnqesid" value="<?php echo $sel[$v]['unique_id']; ?>" />
						<tr>
						    <td><?php echo $v+1 . "."; ?>&nbsp;<?php echo $sel[$v]["question_name"]; ?></td>
						</tr>
						<tr>
						    <td class="fl ml10">
							<?php					    
							for($opt = 1; $opt <= 4; $opt++){
							    $class = "black";
							    if($sel[$v]["is_correct"] == 1 && $sel[$v]["answer_option"] == $opt)
							    $class = "green";
							    elseif($sel[$v]["is_correct"]!= 1 && $sel[$v]["answer_option"] == $opt)
							    $class = "red";
					?>
							<span class="<?php echo $class; ?>"><?php echo $sel[$v]["option" . $opt]; ?></span><br />
					<?php
							}
					?>
						    </td>
						</tr>
						<tr>
						<?php
					    }
					    ?>
					    <tr>
						<td class="red mt10 fl" style="font-size: 15px;">
						    <?php	    
							$sc = $db->query("stored procedure","avn_conceptest_score('". $userid ."')");
							if(!isset($sc['response'])){
						?>		Score <?php echo $sc[0]['score']; ?>
						</td>  
					    <?php
							}
						unset($sc);
						unset($ct);
					    ?>
						<td>
						    <span class="next fr mr20 mt10"><a href="./chapter-list.php?currID=<?php echo $r[0]['curriculum_id']; ?>" class="nexttext">next</a>
						</td>
					    </tr>
					</table>
					<input type="hidden" name="hdnctoption" id="hdnctoption" value="<?php echo $ctoptionid ; ?>" />
					<!--<div class="fl mt20"><input type="submit" name="btnSubmit" id="btnSubmit" class="btnSIgn" value="Submit"></div>-->
				    </form>
				    <div class="clb"></div>
				</div>
				<?php
				    }else{
					$st = $db->query("query","select distinct qm.unique_id,qm.question_name,qm.option1,qm.option2,qm.option3,qm.option4, qm.correct_answer,qm.explanation  from avn_question_master qm inner join ltf_resources_master rm on rm.unique_id = qm.resource_id WHERE qm.type = 2 AND rm.topic_id = " . $_GET['tpID']. " AND NOT qm.unique_id IN (SELECT distinct test_id FROM user_test_answer WHERE user_id = '" .$userid . "') order by unique_id asc limit 0,1");
				//print_r($st);
				?>
				<div class="ansoption">
				    <form method="post" name="formsbmtanswer" id="formsbmtanswer" action="save-concept-answer.php" onsubmit="return conceptvalidateForm();">
					<table cellspacing="4" cellpadding="0" border="0" width="100%">
					    <input type="hidden" name="hdnuserid" id="hdnuserid" value="<?php echo $userid ;?>" />
					    <input type="hidden" name="hdntpid" id="hdntpid" value="<?php echo $_GET['tpID'] ;?>" />
					<?php
					    $ctoptionid = "";
					    for($v=0;$v<count($st);$v++){
						$ctoptionid .= $ctoptionid == "" ? $st[$v]['unique_id'] : "," . $st[$v]['unique_id'];
					?>
						<input type="hidden" name="hdnqesid" id="hdnqesid" value="<?php echo $st[$v]['unique_id']; ?>" />
						<tr>
						    <td><?php echo $v+1 . "."; ?>&nbsp;<?php echo $st[$v]["question_name"]; ?></td>
						</tr>
						<tr>
						    <td class="fl"><input type="radio" id="rd1-<?php echo $st[$v]['unique_id']; ?>" name="ctrdoption<?php echo $st[$v]['unique_id']; ?>" value="1"></td>
						    <td class="fl ml10">
							<?php echo $st[$v]["option1"]; ?>
						    </td>
						</tr>
						<tr>
						    <td class="fl"><input type="radio" id="rd2-<?php echo $st[$v]['unique_id']; ?>" name="ctrdoption<?php echo $st[$v]['unique_id']; ?>" value="2"></td>
						    <td class="fl ml10">
							<?php echo $st[$v]["option2"]; ?>
						    </td>
						</tr>
						<tr>
						    <td class="fl"><input type="radio" id="rd3-<?php echo $st[$v]['unique_id']; ?>" name="ctrdoption<?php echo $st[$v]['unique_id']; ?>" value="3"></td>
						    <td class="fl ml10">
							<?php echo $st[$v]["option3"]; ?>
						    </td>
						</tr>
						<tr>
						    <td class="fl"><input type="radio" id="rd4-<?php echo $st[$v]['unique_id']; ?>" name="ctrdoption<?php echo $st[$v]['unique_id']; ?>" value="4"></td>
						    <td class="fl ml10">
							<?php echo $st[$v]["option4"]; ?>
						    </td>
						</tr>
					<?php
					    }
					?>
					</table>
					<input type="hidden" name="hdnctoption" id="hdnctoption" value="<?php echo $ctoptionid ; ?>" />
					<div class="fl mt20"><input type="submit" name="btnSubmit" id="btnSubmit" class="btnSIgn" value="Submit"></div>
				    </form>
				    <div class="clb"></div>
				</div>
			    <?php
				    }
				}
			    unset($st);
			    ?>
			</div>
			<div class="textdesc">
			<div class="resource-pic">
			    <img src="./admin/images/upload-image/<?php echo $r[0]["topic_image"]; ?>" width="294" height="150"  />
			</div>
			<div class="resource">
			    <div class="contentresource">
				<?php if(isset($r[0]['category_name']) && $r[0]['category_name'] != ""){ ?>
				    <div class="resdta">
					<span class="headingresource">Subject :</span>
					<span class="headtext"><a href="./chapter-list.php?currID=<?php echo $r[0]['curriculum_id'] ;?>" class="textnone"><?php echo $r[0]["category_name"]; ?></a></span>
				    </div>
				<?php
				}
				?>
				    <div class="clb"></div>
				    <?php if(isset($r[0]['chapter_name']) && $r[0]['chapter_name'] != ""){
					$chp = $db->query("stored procedure","res_chp_select(".$_GET['tpID'].")");
				    ?>
					<div class="resdta">
					    <span class="headingresource">Chapter :</span>
					    <?php
						for($k=0;$k<count($chp);$k++){
					    ?>
						    <span class="headtext"><a href="./chapter-list.php?currID=<?php echo $r[0]['curriculum_id'] ;?>" class="textnone"><?php echo $chp[$k]['chapter_name']; ?></a></span>
					    <?php
						}
						unset($chp);
					   ?>
					</div>
				    <?php
				    }
				    ?>
				    <div class="clb"></div>
				    <?php if(isset($r[0]['curriculum_name']) && $r[0]['curriculum_name'] != ""){
					$cur= $db->query("stored procedure","res_cur_select(".$r[0]['unique_id'] .",". $_GET['tpID'] .")");
				    ?>
					<div class="resdta">
					    <span class="headingresource">Curriculum :</span>
					    <?php
						for($j=0;$j<count($cur);$j++){
						    if($j<count($cur)-1){
					    ?>
						    <span class="headtext"><a href="./chapter-list.php?currID=<?php echo $r[0]['curriculum_id'] ;?>" class="textnone""><?php echo $cur[$j]['curriculum_name']; ?></a>,</span>
					    <?php
						}else{
					    ?>
							<span class="headtext"><a href="./chapter-list.php?currID=<?php echo $r[0]['curriculum_id'] ;?>" class="textnone"><?php echo $cur[$j]['curriculum_name']; ?></a></span>
					    <?php
						    }
						}
						unset($cur);
					    ?>
					</div>
				    <?php
				    }
				    unset($cur);
				    ?>
				    <div class="clb"></div>
				    <?php if(isset($r[0]['grade_name']) && $r[0]['grade_name'] != ""){
					$gr= $db->query("stored procedure","res_grd_select(".$r[0]['unique_id'] .",".$_GET['tpID'].")");
				    ?>
					<div class="resdta">
					    <span class="headingresource">Grade :</span>
					    <?php
						for($j=0;$j<count($gr);$j++){
						   if($j<count($gr)-1){
					    ?>
							<span class="headtext"><a href="./chapter-list.php?currID=<?php echo $r[0]['curriculum_id'] ;?>" class="textnone"><?php echo $gr[$j]['grade_name']; ?></a>,</span>
					    <?php
						    }else{
					    ?>
							<span class="headtext"><a href="./chapter-list.php?currID=<?php echo $r[0]['curriculum_id'] ;?>" class="textnone"><?php echo $gr[$j]['grade_name']; ?></a></span>
					    <?php
						    }
						}
						unset($gr);
					    ?>
					</div>
				    <?php
				    }
				    ?>
				    <div class="clb"></div>
				    <?php if(isset($r[0]['tag_name']) && $r[0]['tag_name'] != ""){
					$tag= $db->query("stored procedure","res_tag_select(".$r[0]['unique_id'] .",".$_GET['tpID'].")");
				    ?>
					<div class="resdta">
					    <span class="headingresource">Tag :</span>
					    <?php
						for($j=0;$j<count($tag);$j++){
						   if($j<count($tag)-1){
					    ?>
							<span class="headtext"><a href="./chapter-list.php?currID=<?php echo $r[0]['curriculum_id'] ;?>" class="textnone"><?php echo $tag[$j]['tag_name']; ?></a>,</span>
					    <?php
						    }else{
					    ?>
							<span class="headtext"><a href="./chapter-list.php?currID=<?php echo $r[0]['curriculum_id'] ;?>" class="textnone"><?php echo $tag[$j]['tag_name']; ?></a></span>
					    <?php
						    }
						}
						unset($tag);
					    ?>
					</div>
				    <?php
				    }else{
				    ?>
					<div class="resdta" style="display: none;">
					    <span class="headingresource">Tag :</span>
					    <span class="headtext"><a href="javascript:void(0);" class="textnone"><?php echo $r[0]['tag_name']; ?></a></span>
					</div>
				    <?php
				    }
				?>
			    </div>
			</div>	
		    </div>
		    <?php
		    }
		    ?>
		</div>
	    </div>
	<?php
	    include_once("./includes/footer.php");
	?>
    </div>
</body>   
</html>