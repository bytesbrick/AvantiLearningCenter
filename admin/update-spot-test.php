<?php
	session_start();
	if(isset($_POST["btnUpdate"]))
	{
		include("./includes/config.php");		
		include("./classes/cor.mysql.class.php");
		$db = new MySqlConnection(CONNSTRING);
		$db->open();
		
		if(isset($_POST["hdnqryStringTestQuestions"]) && $_POST["hdnqryStringTestQuestions"] != "")
			$qryString = urldecode($_POST["hdnqryStringTestQuestions"]);
		$qryString .= $qryString == "" ? "?" : "&";
	
		$wheretosave = array();
		$wheretosave['unique_id'] = $_POST["hdqid"];
		$rid= $_POST['hdnresid'];
		$cid= $_POST['hdntpid'];
		$qes = str_replace("\\","",$_POST["txtquestion"]);
		$optone = str_replace("\\","",$_POST["txtoptionone"]);
		$opttwo = str_replace("\\","",$_POST["txtoptiontwo"]);
		$optthree = str_replace("\\","",$_POST["txtoptionthree"]);
		$optfour = str_replace("\\","",$_POST["txtoptionfour"]);
		$optexp = str_replace("\\","",$_POST["txtexplanation"]);
		$testtype = $_POST['ddltesttype'];
		$dataToSave = array();
		$dataToSave['type'] = $_POST['ddltesttype'];
		$dataToSave['resource_id'] = $_POST['hdnresid'];
		$dataToSave['question_name'] = htmlspecialchars_decode($qes);
		$dataToSave['option1'] = htmlspecialchars_decode($optone);
		$dataToSave['option2'] = htmlspecialchars_decode($opttwo);
		$dataToSave['option3'] = htmlspecialchars_decode($optthree);
		$dataToSave['option4'] = htmlspecialchars_decode($optfour);
		$dataToSave['explanation'] = htmlspecialchars_decode($optexp);
		
		$dataToSave['entry_date'] = "now()";
		$dataToSave['status'] = $_POST['ddlstatus'];
		$dataToSave['correct_answer'] = $_POST['ddlAnsOption'];
		
		$r = $db->update("avn_question_master",$dataToSave,$wheretosave);

		if($r["response"] !== "ERROR" )
		{
			if($testtype == 1){
				$url ="./spot-test-questions.php" . $qryString . "resp=up";
				$_SESSION["resp"] = "up";
			}
			if($testtype == 2)
				$url ="./concept-test-questions.php" . $qryString . "resp=up";
		}
		else
		{
			if($testtype == 1)
				$url ="./spot-test-questions.php" . $qryString . "resp=invUp";
			if($testtype == 2)
				$url ="./concept-test-questions.php" . $qryString . "resp=invUp";
		}
		
		unset($r);
		$db->close();
		header('Location: ' . $url);
	}
?>