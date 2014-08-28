<?php
	include("../includes/config.php");		
	include("../classes/cor.mysql.class.php");
	include_once("../includes/checklogin.php");
	$resp = '';
	if(isset($_POST['priority']) && $_POST["priority"] != ""){
		$db = new MysqlConnection(CONNSTRING);
		$db->open();
		$webroot = __WEBROOT__;
		$topicID = $_POST['topicID'];
		$topicID = $db->_decrypt($topicID, ENCKEY);
		$userid = $arrUserInfo["userid"];
		$priority = $_POST["priority"];
		$nextPriority = "0";
		$Isnext = "SELECT MIN(priority) as priority FROM avn_resources_detail WHERE priority > " . $priority . " AND topic_id = " . $topicID . " AND status = 1";
		$IsnextRS = $db->query("query", $Isnext);
		if(!array_key_exists("response", $IsnextRS)){
			if($IsnextRS[0]['priority'] != "")
			$nextPriority = $IsnextRS[0]['priority'];
		}
		$prevPriority = "0";
		$IsPrev = "SELECT MAX(priority) as priority FROM avn_resources_detail WHERE priority < " . $priority . " AND topic_id = " . $topicID . " AND status = 1";
		$IsPrevRS = $db->query("query", $IsPrev);
		if(!array_key_exists("response", $IsPrevRS)){
			if($IsPrevRS[0]['priority'] != "")
			$prevPriority = $IsPrevRS[0]['priority'];
		}
		$encTopicID = $db->_encrypt($topicID, ENCKEY);
		
		//--------To mark resource items of a user------
		
		$res = $db->query("query","SELECT unique_id FROM avn_resources_detail WHERE topic_id = " . $topicID . " AND priority = " . $priority . " AND status = 1 ORDER BY priority ASC");
		$selresources = $db->query("query","SELECT unique_id FROM avn_user_resource_item WHERE resource_item_id = " . $res[0]["unique_id"] . " AND userid = '" . $userid . "'");
		if($selresources["response"] == "ERROR"){
			$dataToSave = array();
			$dataToSave["userid"] = $userid;
			$dataToSave["topic_id"] = $topicID;
			$dataToSave["resource_item_id"] = $res[0]["unique_id"];
			$dataToSave["entry_date"] = "NOW()";
			$dataToSave["priority"] = $priority;
			$dataToSave["last_view_date"] = "NOW()";
			$viewedres = $db->insert("avn_user_resource_item", $dataToSave);
			unset($viewedres);
			unset($selresources);
			unset($res);
		}
		else
			$updatelasteview = $db->query("query","UPDATE avn_user_resource_item SET last_view_date = now() WHERE resource_item_id = " . $res[0]["unique_id"] . " AND userid = '" . $userid . "'");
				$usertype = $arrUserInfo["user_type"];
				$visibleUser = '';
				
				if($usertype == "Student"){
					$visibleUser = 1;
				}
				elseif($usertype == "Teacher"){
					$visibleUser = 2;
				}
				elseif($usertype == "Manager"){
					$visibleUser = 3;
				}
				$sql = "SELECT rd.* FROM avn_resources_detail rd INNER JOIN avn_topic_master tm ON rd.topic_id = tm.unique_id INNER JOIN avn_resource_visiblity_mapping arvm ON rd.unique_id = arvm.resource_id WHERE arvm.visiblity = " . $visibleUser . " AND rd.topic_id = " . $topicID . " AND rd.status = 1 ORDER BY rd.priority ASC";
				//$resources .= $sql;
				$resourceRS = $db->query("query", $sql);
				//print_r($resourceRS);
				if(!array_key_exists("response", $resourceRS)){
					$resources .= "<div class='clb'></div>";
					for($c = 0; $c <count($resourceRS); $c++){
						//$selUser = $db->query("query", "SELECT ard.title,arvm.resource_id FROM avn_resource_visiblity_mapping arvm INNER JOIN avn_resources_detail ard ON ard.unique_id = arvm.resource_id WHERE arvm.visiblity = " . $visibleUser . " AND arvm.resource_id = " . $resourceRS[$c]["unique_id"]);
						
						////print_r($selUser);
						//if(!array_key_exists("response", $selUser)){
						//	for($k = 0; $k < count($selUser); $k++)	{
						//		if($resourceRS[$c]["unique_id"] == $selUser[$k]["resource_id"])
						//		
						//	}
						//}
						$title = $resourceRS[$c]['title'];
						$resPriority = $resourceRS[$c]['priority'];
						$seluserviews = $db->query("query","SELECT COUNT(aur.unique_id) as 'resitem' FROM avn_resources_detail rd INNER JOIN avn_user_resource_item aur ON aur.resource_item_id = rd.unique_id WHERE aur.userid = '" . $userid . "' AND aur.resource_item_id = " . $resourceRS[$c]["unique_id"]);
						for($j = 0; $j <count($seluserviews); $j++){
						     $resources .="<div class='headtext'>";				
							if($seluserviews[$j]["resitem"] == 1){
							       $image = "<img src=\"" . __WEBROOT__ . "/images/correct-ans.png\" border=\"0\" alt=\"viewed\" title=\"viewed\" width=\"10px\" height=\"10px\" style=\"margin:5px 5px 0 0\" />";
							}
							else{
							       $image = "<img src=\"" . __WEBROOT__ . "/images/inactiveicon.png\" border=\"0\" alt=\"notviewed\" title=\"notviewed\" width=\"12px\" height=\"12px\" style=\"margin:3px 5px 0 0\" />";
							}
						      $resources .="<span class='fl'>$image</span>";
						      $resources .="<div style='float: left;width: 80%;'><a href='javascript:void(0);' class='textnone' onclick='javascript: _changeURL($resPriority);_link(\"$encTopicID\",$resPriority);'>$title</a></div></div>";
						      $resources .="<div class='clb'></div>";
				 
						}
					}
				}
			$contentType = "";
			$sql = "SELECT * FROM avn_resources_detail rd INNER JOIN avn_resource_visiblity_mapping arvm ON arvm.resource_id = rd.unique_id WHERE topic_id = " . $topicID . " and priority = " . $priority . " AND status = 1";
			$priorityRS = $db->query("query", $sql);
			if(!array_key_exists("response", $priorityRS)){			
				$contentType = strtolower($priorityRS[0]["content_type"]);
				$contentTitle = $priorityRS[0]["title"];
				$contentText = (nl2br($priorityRS[0]["text"]));
				$slug = strtolower($priorityRS[0]["resource_slug"]);
				$html .="<input type='hidden' name='hdnNextP' id='hdnNextP' value='$nextPriority'>";
				$html .="<input type='hidden' name='hdnPrevP' id='hdnPrevP' value='$prevPriority'>";
				$html .="<input type='hidden' name='hdnCurrP' id='hdnCurrP' value='$priority'>";
				$html .="<input type='hidden' name='hdnTopicID' id='hdnTopicID' value='$encTopicID'>";
				$html .="<input type='hidden' name='hdnSlug' id='hdnSlug' value='$slug'>";
				switch($contentType){
					case "content":
						$html .="<div class='resourceactive'>$contentTitle</div>";
						$html .="<div class='ansoption' style='font-size: 15px;padding:0px 0px 10px 0px;margin-bottom: 15px;min-height: 338px;'>";
						$html .="<div class='preread'>$contentText</div></div>";
					break;
					case "spot":
						if(isset($arrUserInfo["user_type"])&& $arrUserInfo["user_type"] == "Manager" || $arrUserInfo["user_type"] == "Teacher"){
							$sqlCheckSpotTest = "select qm.unique_id,qm.question_name,qm.option1,qm.option2,qm.option3,qm.option4,qm.correct_answer FROM avn_question_master qm INNER JOIN avn_topic_master tm ON tm.unique_id = qm.topic_id WHERE tm.unique_id = ". $topicID." and qm.type= 1 and qm.status = 1 ORDER BY qm.priority ASC";
							$rsCheckSpotTest = $db->query("query", $sqlCheckSpotTest);
							if(!array_key_exists("response", $rsCheckSpotTest)){
								$html .="<div class='clb'></div>";
								$html .="<div class='resourceactive'>Spot Test</div>";							
								$html .="<div class='clb'></div>";
								$html .="<div class='ansoption'>";
								$html .="<form method='post' name='formsbmtanswer' id='formsbmtanswer' action = $webroot/save-submit-answer.php onsubmit='return validateForm();'>";
								$html .="<br />";
								$html .="<table cellspacing='4' cellpadding='3' border='0' width='100%'>";
								$html .="<input type='hidden' name='hdntpid' id='hdntpid' value='$topicID' />";
								$html .="<input type='hidden' name='priority' id='priority' value='$priority' />";
								for($stQ = 0; $stQ < count($rsCheckSpotTest); $stQ++){
								$optionid .= $optionid == '' ? $rsCheckSpotTest[$stQ]['unique_id'] : ',' . $rsCheckSpotTest[$stQ]['unique_id'];
									$questions = $rsCheckSpotTest[$stQ]['question_name'];
									$counter = ($stQ + 1);
									$uid = $rsCheckSpotTest[$stQ]['unique_id'];
									$html .="<input type='hidden' name='hdnqesid[]' id='hdnqesid-$uid' value='$uid' />";
									$html .="<tr>";
									$html .="<td width='7%' valign='top'>Q $counter:</td>";
									$html .="<td colspan='2'>$questions</td>";
									$html .="</tr>";
									$html .="<tr>";
									if(isset($rsCheckSpotTest[$stQ]['option1']) && $rsCheckSpotTest[$stQ]['option1'] != ''){
										$html .="<td></td>";
										$html .="<td width='20px' valign='top'><input type='radio' id='rd$uid' name='rdoption$uid' value='1' class='noborder'></td>";
										$html .="<td class='ml10'>";
										$html .= $rsCheckSpotTest[$stQ]['option1'];
										$html .="</td>";
									}
									$html .="</tr>";
									$html .="<tr>";
									if(isset($rsCheckSpotTest[$stQ]['option2']) && $rsCheckSpotTest[$stQ]['option2'] != ''){
										$html .="<td></td>";
										$html .="<td width='20px' valign='top'><input type='radio' id='rd$uid' name='rdoption$uid' value='2' class='noborder'></td>";
										$html .="<td class='ml10'>";
										$html .= $rsCheckSpotTest[$stQ]['option2'];
										$html .="</td>";
									}
									$html .="</tr>";
									$html .="<tr>";
									if(isset($rsCheckSpotTest[$stQ]['option3']) && $rsCheckSpotTest[$stQ]['option3'] != ''){
										$html .="<td></td>";
										$html .="<td width='20px' valign='top'><input type='radio' id='rd$uid' name='rdoption$uid' value='3' class='noborder'></td>";
										$html .="<td class='ml10'>";
										$html .= $rsCheckSpotTest[$stQ]['option3'];
										$html .="</td>";
									}
									$html .="</tr>";
									$html .="<tr>";
									if(isset($rsCheckSpotTest[$stQ]['option4']) && $rsCheckSpotTest[$stQ]['option4'] != ''){
										$html .="<td></td>";
										$html .="<td width='20px' valign='top'><input type='radio' id='rd$uid' name='rdoption$uid' value='4' class='noborder'></td>";
										$html .="<td class='ml10'>";
										$html .= $rsCheckSpotTest[$stQ]['option4'];
										$html .="</td>";
									}
									$html .="</tr>";
								}
								$html .="</table>";
								$html .="<input type='hidden' name='hdnoption' id='hdnoption' value='$optionid' />";
								$html .="</form>";
								$html .="</div>";
							
							}
						}
						elseif(isset($arrUserInfo["user_type"])&& $arrUserInfo["user_type"] == "Student"){
							$sqlCheckSpotTest = "select qm.unique_id,qm.question_name,qm.option1,qm.option2,qm.option3,qm.option4,qm.correct_answer from avn_question_master qm INNER JOIN avn_topic_master tm ON tm.unique_id = qm.topic_id LEFT OUTER JOIN user_test_answer uta ON uta.test_id = qm.unique_id where uta.test_id is NULL AND tm.unique_id = ". $topicID." and qm.type= 1 and qm.status =1 ORDER BY qm.priority ASC";
							$rsCheckSpotTest = $db->query("query", $sqlCheckSpotTest);
						if(array_key_exists("response", $rsCheckSpotTest)){
						$sqlSpotTestQuestions = "select distinct qm.unique_id,qm.question_name,qm.option1,qm.option2,qm.option3,qm.option4,qm.correct_answer,ua.is_correct,ua.answer_option from avn_question_master qm inner join avn_topic_master tm ON tm.unique_id = qm.topic_id inner join user_test_answer ua on ua.test_id = qm.unique_id where tm.unique_id = ". $topicID."  and qm.type = 1 and ua.user_id = '" .$userid . "' ORDER BY qm.priority ASC";
						$rsSpotTestQuestions = $db->query("query", $sqlSpotTestQuestions);
						//print_r($rsSpotTestQuestions);
						if(!array_key_exists("response", $rsSpotTestQuestions)){
						$html .="<div class='clb'></div>";
						$html .="<div class='resourceactive'>Spot Test Result</div>";
						$html .="<div class='clb'></div>";
						$html .="<div class='ansoption'>";
						$html .="<br />";
						$html .="<table cellspacing='4' cellpadding='3' border='0' width='100%'>";					
						$spotScore = 0;
						for($stQ = 0; $stQ < count($rsSpotTestQuestions); $stQ++){
							$counter = ($stQ + 1);
							$question = $rsSpotTestQuestions[$stQ]['question_name'];
							$html .="<tr>";
							$html .="<td width='7%' valign='top'>Q $counter:</td>";
							$html .="<td>$question</td>";
							$html .="</tr>";
							for($opt = 1; $opt <= 4; $opt++){
								if($rsSpotTestQuestions[$stQ]["is_correct"] == 1 && $rsSpotTestQuestions[$stQ]["answer_option"] == $opt){
									$img = "<img src=\"" . __WEBROOT__ . "/images/correct-ans.png\" border=\"0\" alt=\"correct\" title=\"correct\" width=\"17px\" height=\"17px\" class=\"ml15\" />";
									$spotScore++;
								}
							elseif($rsSpotTestQuestions[$stQ]["is_correct"]!= 1 && $rsSpotTestQuestions[$stQ]["answer_option"] == $opt)
								$img = "<img src=\"" . __WEBROOT__ . "/images/wrong-ans.png\" border=\"0\" alt=\"wrong\" title=\"wrong\" width=\"17px\" height=\"17px\" class=\"ml15\" />";
							if($rsSpotTestQuestions[$stQ]["correct_answer"] == $opt)
								$img = "<img src=\"" . __WEBROOT__ . "/images/correct-ans.png\" border=\"0\" alt=\"correct\" title=\"correct\" width=\"17px\" height=\"17px\" class=\"ml15\" />";
							$html .="<tr>";
							$html .="<td width='15px'></td>";
								if($rsSpotTestQuestions[$stQ]["option" . $opt] != "" && $rsSpotTestQuestions[$stQ]["answer_option"] == $opt || $rsSpotTestQuestions[$stQ]["correct_answer"] == $opt){
									$ans = str_replace("<br>"," ",$rsSpotTestQuestions[$stQ]["option" . $opt]);
									$html .="<td class='ml10' class='black'>$ans $img</td>";
								}else{
									$otheroption = $rsSpotTestQuestions[$stQ]['option' . $opt];
									$html .="<td class='ml10' class='black'>$otheroption</td>";
								}								
							$html .="</td>";
							$html .="</tr>";
							}
						}
							$html .="<tr>";
							$html .="<td colspan='2' class='nexttext'>&nbsp;</td>";
							$html .="</tr>";
							$html .="<tr>";
							$html .="<td colspan='2' class='red mt10' style='font-size: 15px;border-top:dotted 1px #e2e2e2;border-bottom:dotted 1px #e2e2e2;padding:10px 0px;'>";
							$spotscore = $spotScore . "/" .  count($rsSpotTestQuestions);
							$html .="Score: $spotscore";
							$html .="</td>";
							$html .="</tr>";
							$html .="</table>";
							$html .="</div>";
						}
						unset($rsSpotTestQuestions);
					} else {					
						$html .="<div class='clb'></div>";
						$html .="<div class='resourceactive'>Spot Test</div>";
						$html .="<div class='clb'></div>";
						$html .="<div class='ansoption'>";
						$html .="<form method='post' name='formsbmtanswer' id='formsbmtanswer' action = $webroot/save-submit-answer.php onsubmit='return validateForm();'>";
						$html .="<br />";
						$html .="<table cellspacing='4' cellpadding='3' border='0' width='100%'>";
						$html .="<input type='hidden' name='hdntpid' id='hdntpid' value='$topicID' />";
						$html .="<input type='hidden' name='hdnresid' id='hdnresid' value='$st[0]['resource_id']' />";
						$html .="<input type='hidden' name='priority' id='priority' value='$priority' />";
						for($stQ = 0; $stQ < count($rsCheckSpotTest); $stQ++){
						$optionid .= $optionid == '' ? $rsCheckSpotTest[$stQ]['unique_id'] : ',' . $rsCheckSpotTest[$stQ]['unique_id'];
							$questions = $rsCheckSpotTest[$stQ]['question_name'];
							$counter = ($stQ + 1);
							$uid = $rsCheckSpotTest[$stQ]['unique_id'];
							$html .="<input type='hidden' name='hdnqesid[]' id='hdnqesid-$uid' value='$uid' />";
							$html .="<tr>";
							$html .="<td width='7%' valign='top'>Q $counter:</td>";
							$html .="<td colspan='2'>$questions</td>";
							$html .="</tr>";
							$html .="<tr>";
							if(isset($rsCheckSpotTest[$stQ]['option1']) && $rsCheckSpotTest[$stQ]['option1'] != ''){
								$html .="<td></td>";
								$html .="<td width='20px' valign='top'><input type='radio' id='rd$uid' name='rdoption$uid' value='1' class='noborder'></td>";
								$html .="<td class='ml10'>";
								$html .= $rsCheckSpotTest[$stQ]['option1'];
								$html .="</td>";
							}
							$html .="</tr>";
							$html .="<tr>";
							if(isset($rsCheckSpotTest[$stQ]['option2']) && $rsCheckSpotTest[$stQ]['option2'] != ''){
								$html .="<td></td>";
								$html .="<td width='20px' valign='top'><input type='radio' id='rd$uid' name='rdoption$uid' value='2' class='noborder'></td>";
								$html .="<td class='ml10'>";
								$html .= $rsCheckSpotTest[$stQ]['option2'];
								$html .="</td>";
							}
							$html .="</tr>";
							$html .="<tr>";
							if(isset($rsCheckSpotTest[$stQ]['option3']) && $rsCheckSpotTest[$stQ]['option3'] != ''){
								$html .="<td></td>";
								$html .="<td width='20px' valign='top'><input type='radio' id='rd$uid' name='rdoption$uid' value='3' class='noborder'></td>";
								$html .="<td class='ml10'>";
								$html .= $rsCheckSpotTest[$stQ]['option3'];
								$html .="</td>";
							}
							$html .="</tr>";
							$html .="<tr>";
							if(isset($rsCheckSpotTest[$stQ]['option4']) && $rsCheckSpotTest[$stQ]['option4'] != ''){
								$html .="<td></td>";
								$html .="<td width='20px' valign='top'><input type='radio' id='rd$uid' name='rdoption$uid' value='4' class='noborder'></td>";
								$html .="<td class='ml10'>";
								$html .= $rsCheckSpotTest[$stQ]['option4'];
								$html .="</td>";
							}
							$html .="</tr>";
						}
						$html .="</table>";
						$html .="<input type='hidden' name='hdnoption' id='hdnoption' value='$optionid' />";
						if($arrUserInfo['user_type'] == 'Student'){
							$html .="<div class='fl mt20'>";
							$html .="<input type='submit' name='btnSubmit' id='btnSubmit' class='btnSIgn cursor' value='Submit' />";
							$html .="</div>";
						}
						$html .="</form>";
						$html .="</div>";
					}
					}
					unset($rsCheckSpotTest);
					break;
					case "concept":
						if(isset($arrUserInfo["user_type"])&& $arrUserInfo["user_type"] == "Manager" || $arrUserInfo["user_type"] == "Teacher"){
							$html .="<div class='resourceactive'>Concept Test</div>";
							$sqlGetOneQuest = "select distinct qm.unique_id,qm.question_name,qm.option1,qm.option2,qm.option3,qm.option4, qm.correct_answer,qm.explanation from avn_question_master qm inner join avn_topic_master tm on tm.unique_id = qm.topic_id WHERE qm.type = 2 AND tm.unique_id = " . $topicID . " ORDER BY qm.priority ASC";
						$rsGetOneQuest = $db->query('query', $sqlGetOneQuest);
						if(!array_key_exists('response', $rsGetOneQuest)){
							for($i = 0; $i <count($rsGetOneQuest); $i++){
							$GetoneQes = $rsGetOneQuest[$i]['unique_id'];
							$ctoptionid .= $ctoptionid == '' ? $GetoneQes : ',' . $GetoneQes;
							$getqes = $rsGetOneQuest[$i]['question_name'];
							$html .="<div class='clb'></div>";
							$html .="<div class='ansoption'>";
							$html .="<form method='post' name='formsbmtanswer' id='formsbmtanswer' action='$webroot/save-concept-answer.php' onsubmit='return conceptvalidateForm();'>";
							$html .="<br />";
							$html .="<table cellspacing='4' cellpadding='3' border='0' width='100%'>";
							$html .="<input type='hidden' name='hdntpid' id='hdntpid' value='$topicID' />";
							$html .="<input type='hidden' name='priority' id='priority' value='$priority' />";
							$html .="<input type='hidden' name='hdnqesid' id='hdnqesid' value='$GetoneQes' />";
							$html .="<tr>";
							$html .="<td width='3%' valign='top'>Q:</td>";
							$html .="<td colspan='2'>$getqes</td>";
							$html .="</tr>";
							$html .="<tr>";
								if(isset($rsGetOneQuest[$i]['option1']) && $rsGetOneQuest[$i]['option1'] != ''){
									$html .="<td></td>";
									$html .="<td width='3%' valign='top'><input type='radio' id='rd1-$getqes' name='ctrdoption$GetoneQes' value='1' class='noborder'></td>";
									$html .="<td>";
									$html .=$rsGetOneQuest[$i]['option1'];
									$html .="</td>";
								}
								$html .="</tr>";
								$html .="<tr>";
								if(isset($rsGetOneQuest[$i]['option2']) && $rsGetOneQuest[$i]['option2'] != ''){
									$html .="<td></td>";
									$html .="<td width='3%' valign='top'><input type='radio' id='rd2-$getqes' name='ctrdoption$GetoneQes' value='2' class='noborder'></td>";
									$html .="<td>";
									$html .=$rsGetOneQuest[$i]['option2'];
									$html .="</td>";
								}
									$html .="</tr>";
									$html .="<tr>";
								if(isset($rsGetOneQuest[$i]['option3']) && $rsGetOneQuest[$i]['option3'] != ''){
									$html .="<td></td>";
									$html .="<td width='3%' valign='top'><input type='radio' id='rd3-$getqes' name='ctrdoption$GetoneQes' value='3' class='noborder'></td>";
									$html .="<td>";
									$html .= $rsGetOneQuest[$i]['option3'];
									$html .="</td>";
								}
								$html .="</tr>";
								$html .="<tr>";
								if(isset($rsGetOneQuest[$i]['option4']) && $rsGetOneQuest[$i]['option4'] != ''){
									$html .="<td></td>";
									$html .="<td width='3%' valign='top'><input type='radio' id='rd4-$getqes' name='ctrdoption$GetoneQes' value='4' class='noborder'></td>";
									$html .="<td>";
									$html .=$rsGetOneQuest[$i]['option4'];
									$html .="</td>";
								}
								$html .="</tr>";
								$html .="</table>";
								$html .="<input type='hidden' name='hdnctoption' id='hdnctoption' value='$ctoptionid' />";
								$html .="</form>";
								$html .="</div>";
								}
							}
							unset($rsGetOneQuest);
						}
						elseif(isset($arrUserInfo["user_type"])&& $arrUserInfo["user_type"] == "Student"){
					$sqlCheckForNextQuest = "SELECT qm.question_name,qm.unique_id,qm.explanation,qm.option1,qm.option2,qm.option3,qm.option4, qm.correct_answer FROM avn_question_master qm INNER JOIN avn_topic_master tm on tm.unique_id = qm.topic_id LEFT OUTER JOIN user_test_answer uta ON uta.test_id = qm.unique_id WHERE uta.test_id is NULL AND qm.type = 2 AND tm.unique_id = " . $topicID . " ORDER BY qm.priority ASC";
					$rsCheckForNextQuest = $db->query('query', $sqlCheckForNextQuest);
					if(array_key_exists('response', $rsCheckForNextQuest)){
						$sqlGetAllQuest = "select distinct qm.unique_id,qm.question_name,qm.option1,qm.option2,qm.option3,qm.option4,qm.correct_answer,qm.explanation,ua.is_correct,ua.answer_option from avn_question_master qm inner join avn_topic_master tm on tm.unique_id = qm.topic_id inner join user_test_answer ua on ua.test_id = qm.unique_id where tm.unique_id = " . $topicID . " and qm.type = 2 and ua.user_id = '" .$userid . "' order by qm.priority ASC";
						$rsGetAllQuest = $db->query('query', $sqlGetAllQuest);
						if(!array_key_exists('response', $rsGetAllQuest)){
							$html .="<div class='clb'></div>";
							$html .="<div class='resourceactive'>Concept Test Result</div>";
							$html .="<div class='clb'></div>";
							$html .="<div class='ansoption'>";
							$html .="<br />";
							$html .="<table cellspacing='4' cellpadding='3' border='0' width='100%'>";
							$conceptScore = 0;
							for($stQ = 0; $stQ < count($rsGetAllQuest); $stQ++){
								$counter = ($stQ + 1) ;
								$question = $rsGetAllQuest[$stQ]['question_name'];
								$html .="<input type='hidden' name='hdnqesid' id='hdnqesid' value='$rsGetAllQuest[$stQ]['unique_id']' />";
								$html .="<tr>";
								$html .="<td width='7%' valign='top'>Q $counter:</td>";
								$html .="<td>$question</td>";
								$html .="</tr>";
								for($opt = 1; $opt <= 4; $opt++){
									$ans = str_replace('<br>',' ',$rsGetAllQuest[$stQ]['option' . $opt]);
									if($rsGetAllQuest[$stQ]['is_correct'] == 1 && $rsGetAllQuest[$stQ]['answer_option'] == $opt){
										$img = '<img src=\'' . __WEBROOT__ . '/images/correct-ans.png\' border=\'0\' alt=\'correct\' title=\'correct\' width=\'17px\' height=\'17px\' class=\'ml15\' />';
										$conceptScore++;
									}
									elseif($rsGetAllQuest[$stQ]['is_correct']!= 1 && $rsGetAllQuest[$stQ]['answer_option'] == $opt)
										$img = '<img src=\'' . __WEBROOT__ . '/images/wrong-ans.png\' border=\'0\' alt=\'wrong\' title=\'wrong\' width=\'17px\' height=\'17px\' class=\'ml15\' />';
									if($rsGetAllQuest[$stQ]['correct_answer'] == $opt)
										$img = '<img src=\'' . __WEBROOT__ . '/images/correct-ans.png\' border=\'0\' alt=\'wrong\' title=\'wrong\' width=\'17px\' height=\'17px\' class=\'ml15\' />';
									$html .="<tr>";
									$html .="<td width='15px'></td>";
										if($rsGetAllQuest[$stQ]['option' . $opt] != '' && $rsGetAllQuest[$stQ]['answer_option'] == $opt || $rsGetAllQuest[$stQ]['correct_answer'] == $opt){
											$html .="<td class='ml10' class='black'>$ans $img</td>";
										}else{
											$html .="<td class='ml10' class='black'>$ans</td>";
										}
									 $html .="</td>";
									$html .="</tr>";
								}
							if($rsGetAllQuest[$stQ]['explanation'] != ''){
								$explanation = $rsGetAllQuest[$stQ]['explanation'];
								$html .="<tr>";
								$html .="<td colspan='2' class='nexttext'>Explanation</td>";
								$html .="</tr>";
								$html .="<tr>";
								$html .="<td colspan='2'>$explanation</td>";
								$html .="</tr>";
								}
							}
							$html .="<tr>";
							$html .="<td colspan='2' class='nexttext'>&nbsp;</td>";
							$html .="</tr>";
							$html .="<tr>";
							$html .="<td colspan='2' class='red mt10' style='font-size: 15px;border-top:dotted 1px #e2e2e2;border-bottom:dotted 1px #e2e2e2;padding:10px 0px;'>";
							$Cscore = $conceptScore . "/" . count($rsGetAllQuest);
							$html .="Score: $Cscore";
							$html .="</td>";
							$html .="</tr>";
							$html .="</table>";
						$html .="</div>";
						}
					} else {
						$sqlGetOneQuest = "select distinct qm.unique_id,qm.question_name,qm.option1,qm.option2,qm.option3,qm.option4, qm.correct_answer,qm.explanation from avn_question_master qm inner join avn_topic_master tm on tm.unique_id = qm.topic_id LEFT OUTER JOIN user_test_answer uta ON uta.test_id = qm.unique_id where uta.test_id is NULL AND qm.type = 2 AND tm.unique_id = " . $topicID . " ORDER BY qm.priority ASC limit 0,1";
						$rsGetOneQuest = $db->query('query', $sqlGetOneQuest);
						if(!array_key_exists('response', $rsGetOneQuest)){
							$GetoneQes = $rsGetOneQuest[0]['unique_id'];
							$ctoptionid .= $ctoptionid == '' ? $GetoneQes : ',' . $GetoneQes;
							$getqes = $rsGetOneQuest[0]['question_name'];
							$html .="<div class='clb'></div>";
							$html .="<div class='resourceactive'>Concept Test</div>";
							$html .="<div class='clb'></div>";
							$html .="<div class='ansoption'>";
							$html .="<form method='post' name='formsbmtanswer' id='formsbmtanswer' action='$webroot/save-concept-answer.php' onsubmit='return conceptvalidateForm();'>";
							$html .="<br />";
							$html .="<table cellspacing='4' cellpadding='3' border='0' width='100%'>";
							$html .="<input type='hidden' name='hdntpid' id='hdntpid' value='$topicID' />";
							$html .="<input type='hidden' name='priority' id='priority' value='$priority' />";
							$html .="<input type='hidden' name='hdnqesid' id='hdnqesid' value='$GetoneQes' />";
							$html .="<tr>";
							$html .="<td width='3%' valign='top'>Q:</td>";
							$html .="<td colspan='2'>$getqes</td>";
							$html .="</tr>";
							$html .="<tr>";
								if(isset($rsGetOneQuest[0]['option1']) && $rsGetOneQuest[0]['option1'] != ''){
									$html .="<td></td>";
									$html .="<td width='3%' valign='top'><input type='radio' id='rd1-$getqes' name='ctrdoption$GetoneQes' value='1' class='noborder'></td>";
									$html .="<td>";
									$html .=$rsGetOneQuest[0]['option1'];
									$html .="</td>";
								}
								$html .="</tr>";
								$html .="<tr>";
								if(isset($rsGetOneQuest[0]['option2']) && $rsGetOneQuest[0]['option2'] != ''){
									$html .="<td></td>";
									$html .="<td width='3%' valign='top'><input type='radio' id='rd2-$getqes' name='ctrdoption$GetoneQes' value='2' class='noborder'></td>";
									$html .="<td>";
									$html .=$rsGetOneQuest[0]['option2'];
									$html .="</td>";
								}
									$html .="</tr>";
									$html .="<tr>";
								if(isset($rsGetOneQuest[0]['option3']) && $rsGetOneQuest[0]['option3'] != ''){
									$html .="<td></td>";
									$html .="<td width='3%' valign='top'><input type='radio' id='rd3-$getqes' name='ctrdoption$GetoneQes' value='3' class='noborder'></td>";
									$html .="<td>";
									$html .= $rsGetOneQuest[0]['option3'];
									$html .="</td>";
								}
								$html .="</tr>";
								$html .="<tr>";
								if(isset($rsGetOneQuest[0]['option4']) && $rsGetOneQuest[0]['option4'] != ''){
									$html .="<td></td>";
									$html .="<td width='3%' valign='top'><input type='radio' id='rd4-$getqes' name='ctrdoption$GetoneQes' value='4' class='noborder'></td>";
									$html .="<td>";
									$html .=$rsGetOneQuest[0]['option4'];
									$html .="</td>";
								}
							$html .="</tr>";
							$html .="</table>";
							$html .="<input type='hidden' name='hdnctoption' id='hdnctoption' value='$ctoptionid' />";
							if($arrUserInfo['user_type'] == 'Student'){
								$html .="<div class='fl mt20'><input type='submit' name='btnSubmit' id='btnSubmit' class='btnSIgn cursor' value='Submit'></div>";
							}
							$html .="</form>";
							$html .="</div>";
						}
					}
				}
			}
		}else{
			$html .="<div id='dimensionresource' class='dimensionresource' style='border:0px;'>";
			$html .="<div class='resourcecontent'>";
			$html .="<div class='headingresource' style='margin: 30px 0px 0px 100px;'>There are no resources for this topic.</div>";
			$html .="</div>";
			$html .="</div>";
		}
		$resp = 1;
	}
	else
		$resp = 0;
	echo $resp."|#|". $html . "|#|" . $resources;
?>