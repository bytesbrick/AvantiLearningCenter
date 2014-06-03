<?php
    include("../includes/config.php");		
    include("../classes/cor.mysql.class.php");
    $db = new MySqlConnection(CONNSTRING);
    $db->open();
    
    $chapIDs = explode(",", $_POST["center_id"]);
    
    $dataWhere = array();
    $dataWhere["manager_id"] = $_POST["manager_id"];
    if(isset($_POST["manager_id"]) && $_POST["manager_id"] != "" && $_POST["manager_id"] != "0")
        $dataWhere["manager_id"] = $_POST["manager_id"];
    $r = $db->delete("avn_manager_center_mapping", $dataWhere);
    unset($dataWhere);
    for($i = 0; $i < count($chapIDs); $i++){
        $dataToSave = array();
        $dataToSave["manager_id"] = $_POST["manager_id"];
        $dataToSave["center_id"] = $chapIDs[$i];
        $dataToSave["entry_date"] = "NOW()";
        $r = $db->insert("avn_manager_center_mapping", $dataToSave);
        unset($dataToSave);
        unset($s);
    }
    $db->close();
    echo $_POST["manager_id"];
?>