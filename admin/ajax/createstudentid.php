<?php
    $resp = "";
    if(isset($_POST["unique_id"]) && $_POST["unique_id"] != ""){
        include("../includes/config.php");		
        include("../classes/cor.mysql.class.php");
        $db = new MySqlConnection(CONNSTRING);
        $db->open();
        $batchRS = $db->query("query","SELECT unique_id,batch_id,learning_center FROM avn_batch_master WHERE unique_id = " . $_POST["unique_id"]);
        if(!array_key_exists("response", $batchRS)){
            $studentCount = $db->query("query","SELECT MAX(unique_id) as totalstudent FROM avn_student_master WHERE batch_id = " . $batchRS[0]["unique_id"]);
            $rollNum = ($studentCount[0]["totalstudent"] + 1);
            $batchID = $batchRS[0]["batch_id"];
            if(intval($rollNum) < 10)
                $NewRollNum = "0" . $rollNum;
            else
                $NewRollNum = $rollNum;
            $studentid = $batchID.$NewRollNum;
            unset($studentCount);
            unset($centerRS);
            unset($batchRS);
            $resp = 1;
            $db->close();
        }
    }else
        $resp = 0;
    echo $resp . "|#|" . $studentid;
?>