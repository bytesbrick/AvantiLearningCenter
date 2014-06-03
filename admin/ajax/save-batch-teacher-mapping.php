<?php
    include("../includes/config.php");		
    include("../classes/cor.mysql.class.php");
    $db = new MySqlConnection(CONNSTRING);
    $db->open();
    
    $chapIDs = explode(",", $_POST["batch_id"]);
    $city= $_POST["city_id"];
    $teacher = $_POST["teacher_id"];
    $dataWhere = array();
    $dataWhere["center_id"] = $_POST["center_id"];
    if(isset($_POST["center_id"]) && $_POST["center_id"] != "" && $_POST["center_id"] != "0")
        $dataWhere["center_id"] = $_POST["center_id"];
    $r = $db->delete("avn_teacher_batch_mapping", $dataWhere);
    unset($dataWhere);
    
    for($i = 0; $i < count($chapIDs); $i++){
        $dataToSave = array();
        $dataToSave["batch_id"] = $chapIDs[$i];
        $dataToSave["teacher_id"] = $teacher;
        $dataToSave["center_id"] = $_POST["center_id"];
        $dataToSave["entry_date"] = "NOW()";
        $r = $db->insert("avn_teacher_batch_mapping", $dataToSave);
        unset($dataToSave);
        unset($s);
    }
    $db->close();
    echo $city . "|#|" . $teacher . "|#|" . $_POST["center_id"];
?> 