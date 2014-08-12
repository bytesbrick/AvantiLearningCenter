<?php
    include("../includes/config.php");		
    include("../classes/cor.mysql.class.php");
    $db = new MySqlConnection(CONNSTRING);
    $db->open();
    
    $StudentIDs = explode(",", $_POST["StudentIDs"]);
    $ispresent = explode(",", $_POST["ispresent"]);
    $Prios = $_POST["date"];
    $pDate = str_ireplace(",", "",$Prios);
    $pickDate = date_create($Prios);
    $d = $pickDate->format('Y-m-d');
    //echo $_POST["date"];
    $datatowhere = array();
    $datatowhere["batch_id"] = $_POST["batch_id"];
    
    $datatowhere["attendence_date"] = $pickDate->format('Y-m-d');
    $datatowhere["class_schedule_id"] = $_POST["unique_id"];
    if(isset($_POST["batch_id"]) && $_POST["batch_id"] != "" && $_POST["batch_id"] != "0" && isset($_POST["date"]) && $_POST["date"] != "")
    $delete = $db->delete("avn_student_attendance", $datatowhere);
    for($i = 0; $i < count($StudentIDs); $i++){
        $dataToSave = array();
        $dataToSave["student_id"] = $StudentIDs[$i];
        $dataToSave["isPresent"] = $ispresent[$i];
	$dataToSave["batch_id"] = $_POST["batch_id"];
	$dataToSave["attendence_date"] = $d;
	$dataToSave["class_schedule_id"] = $_POST["unique_id"];
	$dataToSave["topic_id"] = $_POST["topicid"];
	
	//print_r($dataToSave);
        $r = $db->insert("avn_student_attendance", $dataToSave);
	//print_r($r);
        unset($dataToSave);
        unset($r); 
    }
    $db->close();
    echo $_POST["batch_id"] . "|#|" . $d . "|#|" . $_POST["unique_id"] . "|#|" . $_POST["topicid"];
?>