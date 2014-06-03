<?php
	if(isset($_POST["btnSubmit"]) && $_POST["btnSubmit"] != "")
	{
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		include_once("./includes/checklogin.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$userid= $arrUserInfo["userid"];
		$curpriority = $_POST['priority'];
		$cid= $_POST['hdnresid'];
		$tpid = $_POST['hdntpid'];
		$qes = $_POST['hdnqesid'];
		$itemslug = $_POST['hdnitemslug'];
		$currslug = $arrUserInfo["curriculum_slug"];
		$selcurSlug = "SELECT unique_id FROM avn_curriculum_master WHERE curriculum_slug = '" . $currslug . "'";
		$selcurSlugRS = $db->query("query", $selcurSlug);
		//print_r($selcurSlugRS);
		if(!array_key_exists("response",$selcurSlugRS)){
			$curriculumId = $selcurSlugRS[0]["unique_id"];
		}
		$seltopicData = "SELECT ltf.category_slug,cm.chapter_slug,tm.topic_slug FROM ltf_category_master ltf INNER JOIN avn_chapter_master cm ON ltf.unique_id = cm.category_id
INNER JOIN avn_curriculum_master acm ON acm.unique_id = ltf.curriculum_id INNER JOIN avn_topic_master tm ON tm.chapter_id = cm.unique_id WHERE acm.unique_id = " . $curriculumId ." AND tm.unique_id = " . $tpid;
		$seltopicDataRS = $db->query("query", $seltopicData);
		//print_r($seltopicDataRS);
		if(!array_key_exists("response", $seltopicDataRS)){
			$catgslug = $seltopicDataRS[0]['category_slug'];
			$chpslug = $seltopicDataRS[0]['chapter_slug'];
			$topicslug = $seltopicDataRS[0]['topic_slug'];
		}
		
		$test = $db->query("query","select qm.unique_id,qm.question_name,qm.correct_answer from avn_question_master qm left outer join avn_topic_master tm on tm.unique_id = qm.topic_id where tm.unique_id = " . $tpid . " and qm.type = 2 AND qm.unique_id = " . $qes. " and qm.status = 1 order by unique_id asc");
		for($i=0;$i<count($test);$i++){
			$isCorrect = 0;
			$correctans = $test[$i]['correct_answer'];
			$userans = 'ctrdoption'.$test[$i]['unique_id'];
			
			if($correctans == $_POST[$userans])
				$isCorrect = 1;
			else
				$isCorrect = 0;
		
			$dataToSave = array();
			$dataToSave['user_id'] = $userid;
			$dataToSave['test_id'] =  $test[$i]['unique_id'];
			$dataToSave['answer_option'] = $_POST[$userans];
			$dataToSave['topic_id'] = $_POST['hdntpid'];
			$dataToSave['is_correct'] = $isCorrect;
			$dataToSave['entry_date'] = "now()";
			$r = $db->insert("user_test_answer", $dataToSave);
		
		}
		if($r["response"] == "ERROR"){
		    $rURL =  __WEBROOT__. "/". $currslug . "/" . $catgslug ."/" . $chpslug . "/" . $topicslug . "/#" . $curpriority;
		}
		else{
		    $rURL = __WEBROOT__."/". $currslug . "/" . $catgslug ."/" . $chpslug . "/" . $topicslug . "/#" . $curpriority;
		}
	}
	else
		$rURL = __WEBROOT__. "/". $currslug . "/" . $catgslug ."/" . $chpslug . "/" . $topicslug . "/#" . $curpriority;
	unset($r);
	$db->close();
	header('Location: ' . $rURL);
?>