<?php
    $resp = "";
    if(isset($_POST["field"]) && $_POST["field"] != ""){
        include("../includes/config.php");		
        include("../classes/cor.mysql.class.php");
        $db = new MySqlConnection(CONNSTRING);
        $db->open();
        $slugRS = $db->query("query","SELECT " . $_POST["field"] . " FROM " . $_POST["table"]  . " WHERE " . $_POST["field"] . " = '" . strtolower($_POST["slug"]) . "'");
        //print_r($slugRS);
        if($slugRS["response"] == "ERROR"){
            $resp = 2;
        }
        else{
            $resp = 1;
        }
    }else
        $resp = 0;
    echo $resp;
?>