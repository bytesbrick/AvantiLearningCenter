<?php
    include("../includes/config.php");		
    include("../classes/cor.mysql.class.php");
    $db = new MySqlConnection(CONNSTRING);
    $db->open();
    
    $chapIDs = explode(",", $_POST["chapter_id"]);
    $Prios = explode(",", $_POST["priority"]);
    
    $dataWhere = array();
    $dataWhere["batch_id"] = $_POST["batch_id"];
    if(isset($_POST["subject_id"]) && $_POST["subject_id"] != "" && $_POST["subject_id"] != "0")
    $dataWhere["subject_id"] = $_POST["subject_id"];
    $r = $db->delete("avn_batch_chapter_mapping", $dataWhere);
    unset($dataWhere);
    
    for($i = 0; $i < count($chapIDs); $i++){
        $sql = "SELECT category_id FROM avn_chapter_master WHERE unique_id = " . $chapIDs[$i];
        $s = $db->query("query", $sql);
        if(!array_key_exists("response", $s)){
           $subjectID = $s[0]["category_id"];
           $dataToSave = array();
            $dataToSave["batch_id"] = $_POST["batch_id"];
            $dataToSave["subject_id"] = $subjectID;
            $dataToSave["chapter_id"] = $chapIDs[$i];
            $dataToSave["priority"] = $Prios[$i];
            $dataToSave["entry_date"] = "NOW()";
            $r = $db->insert("avn_batch_chapter_mapping", $dataToSave);
            unset($dataToSave);
        }
        unset($s);
    }
    //unset($r);
    $db->close();
    echo $_POST["batch_id"] . "|#|" . $_POST["subject_id"];
?>