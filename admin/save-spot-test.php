<?php
	session_start();
	if(isset($_POST["btnSave"]) && $_POST["btnSave"] != "")
	{
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		$testtype = $_POST['ddltesttype'];
		$cid= $_POST['hdntpid'];
		
		if(isset($_POST["hdnqryStringTestQuestions"]) && $_POST["hdnqryStringTestQuestions"] != "")
			$qryString = urldecode($_POST["hdnqryStringTestQuestions"]);
		//$qryString .= $qryString == "" ? "?" : "&";
		
		$qes = str_replace("\\","",$_POST["txtquestion"]);
		$optone = str_replace("\\","",$_POST["txtoptionone"]);
		$opttwo = str_replace("\\","",$_POST["txtoptiontwo"]);
		$optthree = str_replace("\\","",$_POST["txtoptionthree"]);
		$optfour = str_replace("\\","",$_POST["txtoptionfour"]);
		$optexp = str_replace("\\","",$_POST["txtexplanation"]);
		if(isset($testtype) && $testtype == 1){
			$Rsquestions = $db->query("query","SELECT MAX(priority) as maxpriority FROM avn_question_master WHERE topic_id = " . $_POST["hdntpid"] . " AND type = 1");
		}
		if(isset($testtype) && $testtype == 2){
			$Rsquestions = $db->query("query","SELECT MAX(priority) as maxpriority FROM avn_question_master WHERE topic_id = " . $_POST["hdntpid"] . " AND type = 2");
		}
		
		$forfirst = $Rsquestions[0]['maxpriority'];
		$fornext = $forfirst + 1;
		$dataToSave = array();
		$dataToSave['type'] = $_POST['ddltesttype'];
		$dataToSave['priority'] = $fornext;
		$dataToSave['topic_id'] = $_POST["hdntpid"];
		$dataToSave['question_name'] = htmlspecialchars_decode($qes);
		$dataToSave['option1'] = htmlspecialchars_decode($optone);
		$dataToSave['option2'] = htmlspecialchars_decode($opttwo);
		$dataToSave['option3'] = htmlspecialchars_decode($optthree);
		$dataToSave['option4'] = htmlspecialchars_decode($optfour);
		$dataToSave['explanation'] = htmlspecialchars_decode($optexp);
	
		$dataToSave['entry_date'] = "now()"; 
		$dataToSave['status'] = $_POST['ddlstatus'];
		$dataToSave['correct_answer'] = $_POST['ddlAnsOption'];
		
		$r = $db->insert("avn_question_master", $dataToSave);
		if($r["response"] == "ERROR" ){
			if($testtype == 1){
				$rURL ="./spot-test-questions.php" . $qryString;
				$_SESSION["resp"] = "invEd";
			}
			if($testtype == 2){
				$rURL ="./concept-test-questions.php" . $qryString;
				$_SESSION["resp"] = "invEd";
			}
		}
		else{
			if($testtype == 1){
				$rURL ="./spot-test-questions.php" . $qryString;
				$_SESSION["resp"] = "suc";
			}
			if($testtype == 2){
				$rURL ="./concept-test-questions.php" . $qryString;
				$_SESSION["resp"] = "suc";
			}
		}
	} 
	else
	{
		if($testtype == 1){
			$rURL ="./spot-test-questions.php" . $qryString;
			$_SESSION["resp"] = "errEd";
		}
		if($testtype == 2){
			$rURL ="./concept-test-questions.php" . $qryString . "resp=errEd";
			$_SESSION["resp"] = "errEd";
		}
	}
	unset($r);
	$db->close();
	header('Location: ' . $rURL);
?>