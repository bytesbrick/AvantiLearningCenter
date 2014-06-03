<?php
    $resp = "";
    if(isset($_POST["unique_id"]) && $_POST["unique_id"] != ""){
        include("../includes/config.php");		
        include("../classes/cor.mysql.class.php");
        $db = new MySqlConnection(CONNSTRING);
        $db->open();
        $centerRS = $db->query("query","SELECT unique_id,center_code,center_name FROM avn_learningcenter_master WHERE unique_id = " . $_POST["unique_id"]);
        if(!array_key_exists("response", $centerRS)){           
            $batchCount = $db->query("query","SELECT MAX(unique_id) as totalbatch FROM avn_batch_master WHERE learning_center = " . $centerRS[0]["unique_id"]);
            $batchID = ($batchCount[0]["totalbatch"] + 1);
            if(intval($batchID) < 10){
                $batch = "0" . $batchID;
                $Newbatch = $centerRS[0]["center_code"].date('y').$batch;
            }
            else{
                $Newbatch = $centerRS[0]["center_code"].date('y').$batchID;
            }
            $resp = 1;
            unset($batchCount);
            unset($centerRS);
        }
        $db->close();
    }else
        $resp = 0;
    echo $resp . "|#|" . $Newbatch;
?>