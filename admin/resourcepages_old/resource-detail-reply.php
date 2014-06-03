<?php 
    include_once("./includes/checklogin.php");
    $userid = $_COOKIE["userID"];
?>
<!DOCTYPE HTML>
<html xml:lang="en" lang="en" itemscope="" itemtype="http://schema.org">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Avanti Learning Centres | Spot Test</title>
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
			$r=$db->query("stored procedure","res_des_select(".$_GET['tpID'].")");
			if(!isset($r['response'])){
		    ?>
		    <div class="dimensionresource" id="dimensionresource">
			<?php
			    if(isset($_GET['q']) && $_GET['q'] == "intro" || !isset($_GET['q'])){
			?>
				
				<div class="resourcecontent"><div class="preread"><?php echo ucwords($r[0]['resource_title']); ?></div>
				<div class="resourcecontent"><div class="preread"><?php echo $r[0]['resource_desc']; ?></div>
				<span class="next fr mr20"><a href="./resource-detail.php?tpID=<?php echo $_GET['tpID']; ?>&q=pread" class="nexttext">next</a></span></div>
			<?php
			    }
			    if(isset($_GET['q'])&& $_GET['q'] == "pread"){
			?>
				<div class="resourceactive">Pre-Reading</div>
				<div class="resourcecontent"><div class="preread"><?php echo $r[0]['what_to_love']; ?></div>
				<span class="next"><a href="./resource-detail.php?tpID=<?php echo $_GET['tpID']; ?>&q=intro" class="nexttext">prev</a></span>
				<span class="next fr mr20"><a href="./resource-detail.php?tpID=<?php echo $_GET['tpID']; ?>&q=spot-test" class="nexttext">next</a></span></div>
			<?php
			    }
			    $st = $db->query("query","select distinct qm.unique_id,qm.question_name,qm.option1,qm.option2,qm.option3,qm.option4,qm.correct_answer,ua.is_correct,ua.answer_option from avn_question_master qm inner join ltf_resources_master rm on rm.unique_id = qm.resource_id inner join user_test_answer ua on ua.test_id = qm.unique_id where  rm.topic_id = ". $_GET['tpID']."  and type = 1 and ua.user_id = '" .$userid . "'");
			    
			       if(isset($_GET['q'])&& $_GET['q'] == "spot-test"){
			?>
				<div class="resourceactive mb20">Spot Test</div>
				<div class="clb"></div>
				<div class="ansoption">
				    <form method="post" name="formsbmtanswer" id="formsbmtanswer" action="">
					<table cellspacing="4" cellpadding="0" border="0" width="100%">
					    <input type="hidden" name="hdnuserid" id="hdnuserid" value="<?php echo $userid ;?>" />
					    <input type="hidden" name="hdntpid" id="hdntpid" value="<?php echo $_GET['tpID'] ;?>" />
					<?php
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
				    </form>
				    <div class="clb"></div>
				</div>
			    <?php
				}
				
				if(isset($_GET['q'])&& $_GET['q'] == "spot-test-appeared"){
			?>
				<div class="resourceactive mb20">Spot Test</div>
				<div class="clb"></div>
				<div class="ansoption">
				    <form method="post" name="formsbmtanswer" id="formsbmtanswer" action="">
					<table cellspacing="4" cellpadding="0" border="0" width="100%">
					    <input type="hidden" name="hdnuserid" id="hdnuserid" value="<?php echo $userid ;?>" />
					    <input type="hidden" name="hdntpid" id="hdntpid" value="<?php echo $_GET['tpID'] ;?>" />
					    <tr>
						<td class="fl red" style="font-size: 15px;margin: 0px 0px 10px 0px ;">
						    <?php  echo "You have already appeared for this spot-test <br />";?>
						</td>
					    </tr>
					<?php
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
				    </form>
				    <div class="clb"></div>
				</div>
			    <?php
				}
				unset($st);
				if(isset($_GET['q'])&& $_GET['q'] == "concept-test"){
				    
				$ct = $db->query("query","select distinct qm.unique_id,qm.question_name,qm.option1,qm.option2,qm.option3,qm.option4,qm.correct_answer,qm.explanation,ua.is_correct,ua.answer_option from avn_question_master qm inner join ltf_resources_master rm on rm.unique_id = qm.resource_id inner join user_test_answer ua on ua.test_id = qm.unique_id where  rm.topic_id = ". $_GET['tpID']."  and type = 2 and ua.user_id = '" .$userid . "' AND qm.unique_id = " .  $_GET['qid'] . " order by unique_id asc limit 0,1");
				
			    ?>
				<div class="resourceactive mb20">Concept Test</div>
				<div class="clb"></div>
				<div class="ansoption">
				    <form method="post" name="formsbmtanswer" id="formsbmtanswer" action="save-concept-answer.php">
					<table cellspacing="4" cellpadding="0" border="0" width="100%">
					    <input type="hidden" name="hdnuserid" id="hdnuserid" value="<?php echo $userid ;?>" />
					    <input type="hidden" name="hdntpid" id="hdntpid" value="<?php echo $_GET['tpID'] ;?>" />
					<?php
					    for($v=0;$v<count($ct);$v++)
					    {
					?>
						<input type="hidden" name="hdnqesid" id="hdnqesid" value="<?php echo $ct[$v]['unique_id']; ?>" />
						<tr>
						    <td><?php echo $v+1 . "."; ?> <?php echo $ct[$v]["question_name"]; ?></td>
						</tr>
						<tr>
						    <td class="fl ml10">
							<?php					    
							for($opt = 1; $opt <= 4; $opt++){
							    $class = "black";
							    if($ct[$v]["is_correct"] == 1 && $ct[$v]["answer_option"] == $opt)
							    $class = "green";
							    elseif($ct[$v]["is_correct"]!= 1 && $ct[$v]["answer_option"] == $opt)
							    $class = "red";
					?>
							<span class="<?php echo $class; ?>"><?php echo $ct[$v]["option" . $opt]; ?></span><br />
					<?php
							}
					?>
						    </td>
						</tr>
						<tr>
						    <?php
							if($ct[$v]['explanation'] != ""){
						    ?>
							<td>
							    <span class="nexttext mt40 fl">
								Explanation
							    </span>
							    <div class="clb"></div>
							    <div class="fl mt10"><?php echo $ct[$v]['explanation']; ?></div>
							</td>
						    <?php
							}
						    ?>
						</tr>
						<tr>
						    <td class="next fr mr20 mt10">
							<?php
							    $count= $db->query("stored procedure","avn_maxuid_conceptest(".$_GET['tpID'].")");
							
							    if($count[0]['maxuid'] !== $_GET['qid']){
							?>
								<a href="./resource-detail.php?tpID=<?php echo $_GET['tpID']; ?>&q=concept-test" class="nexttext">next</a>
							<?php
								}else{
							?>
								
						    </td>
						</tr>
						<tr>
						<?php
								    
									$sc = $db->query("stored procedure","avn_conceptest_score('". $userid ."')");
									if(!isset($sc['response'])){
						?>	
									    <td class="red mt10" style="font-size: 15px;">
										Score <?php echo $sc[0]['score']; ?>
									    </td>
									    <td>
										<a href="./chapter-list.php?currID=<?php echo $r[0]['curriculum_id']; ?>" class="nexttext">next</a>
									    </td>
					    <?php
									}
								}	
					    }
							    unset($sc);
							    unset($ct);
					    ?>
						</tr>
					</table>
				    </form>
				    <div class="clb"></div>
				</div>
			    <?php	    
				}
				unset($st);
				
				if(isset($_GET['q'])&& $_GET['q'] == "concept-test-appeared"){
				    
				$ct = $db->query("query","select distinct qm.unique_id,qm.question_name,qm.option1,qm.option2,qm.option3,qm.option4,qm.correct_answer,qm.explanation,ua.is_correct,ua.answer_option from avn_question_master qm inner join ltf_resources_master rm on rm.unique_id = qm.resource_id inner join user_test_answer ua on ua.test_id = qm.unique_id where  rm.topic_id = ". $_GET['tpID']."  and type = 2 and ua.user_id = '" .$userid . "' order by unique_id asc");
			    ?>
				<div class="resourceactive mb20">Concept Test</div>
				<div class="clb"></div>
				<div class="ansoption">
				    <form method="post" name="formsbmtanswer" id="formsbmtanswer" action="save-concept-answer.php">
					<table cellspacing="4" cellpadding="0" border="0" width="100%">
					    <input type="hidden" name="hdnuserid" id="hdnuserid" value="<?php echo $userid ;?>" />
					    <input type="hidden" name="hdntpid" id="hdntpid" value="<?php echo $_GET['tpID'] ;?>" />
					    <tr>
						<td class="fl red" style="font-size: 15px;margin: 0px 0px 10px 0px ;">
						    <?php  echo "You have already appeared for this spot-test <br />";?>
						</td>
					    </tr>
					<?php
					    for($v=0;$v<count($ct);$v++)
					    {
					?>
						<input type="hidden" name="hdnqesid" id="hdnqesid" value="<?php echo $ct[$v]['unique_id']; ?>" />
						<tr>
						    <td><?php echo $v+1 . "."; ?> <?php echo $ct[$v]["question_name"]; ?></td>
						</tr>
						<tr>
						    <td class="fl ml10">
							<?php					    
							for($opt = 1; $opt <= 4; $opt++){
							    $class = "black";
							    if($ct[$v]["is_correct"] == 1 && $ct[$v]["answer_option"] == $opt)
							    $class = "green";
							    elseif($ct[$v]["is_correct"]!= 1 && $ct[$v]["answer_option"] == $opt)
							    $class = "red";
					?>
							<span class="<?php echo $class; ?>"><?php echo $ct[$v]["option" . $opt]; ?></span><br />
					<?php
							}
					?>
						    </td>
						</tr>
						<tr>
						    <td class="next fr mr20 mt10">
							<?php
							    $count= $db->query("stored procedure","avn_maxuid_conceptest(".$_GET['tpID'].")");
							
							    if($count[0]['maxuid'] !== $_GET['qid']){
							?>
								<a href="./resource-detail.php?tpID=<?php echo $_GET['tpID']; ?>&q=concept-test" class="nexttext">next</a>
							<?php
								}else{
							?>
								<a href="./resource-detail.php?tpID=<?php echo $_GET['tpID']; ?>&q=concept-test" class="nexttext"  style="display: none;">next</a>
						    </td>
						</tr>
						<tr>
						<?php
								    
									$sc = $db->query("stored procedure","avn_conceptest_score('". $userid ."')");
									if(!isset($sc['response'])){
						?>	
									    <td class="red mt10" style="font-size: 15px;">
										Score <?php echo $sc[0]['score']; ?>
									    </td>
									
					    <?php
									}
								}	
					    }
							    unset($sc);
							    unset($ct);
					    ?>
						</tr>
					</table>
				    </form>
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
				<div class="resourceactive mb20"> Video</div>
				<div class="clb"></div>
				<?php
				    for($v=0;$v<count($vid);$v++){					    
				?>
					<div class="videodiv"><?php echo $vid[$v]["video_url"]; ?></div>
				<?php
				    }
				?>	
				<div class="clb"></div>
				<span class="next"><a href="<?php echo $_SERVER["HTTP_REFERER"];?>" class="nexttext">prev</a></span>
			<?php
			    }
			    unset($vid);
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
							<span class="headtext"><a href="./chapter-list.php?currID=<?php echo $r[0]['curriculum_id'] ;?>" class="textnone"<?php echo $cur[$j]['curriculum_name']; ?></a></span>
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
					$tag= $db->query("stored procedure","res_tag_select(".$_GET['tpID'].")");
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