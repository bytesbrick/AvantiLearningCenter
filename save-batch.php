<?php
    if(isset($_POST["btnsubmit"]) && $_POST["btnsubmit"] != ""){
        include_once("./includes/config.php");  
        include("./classes/cor.mysql.class.php");
        include_once("./includes/checklogin.php");
        $db = new MySqlConnection(CONNSTRING);
        $db->open();
        $selCurrID = "SELECT curriculum_id FROM avn_batch_master WHERE unique_id = " . $_POST["ddlbatch"];
        $selCurridRS = $db->query("query", $selCurrID);
        if(!array_key_exists("response", $selCurridRS)){
            $CurrID = $selCurridRS[0]["curriculum_id"];
            $selCurrslug = "SELECT curriculum_slug FROM avn_curriculum_master WHERE unique_id = " . $CurrID;
            $selCurrslugRS = $db->query("query", $selCurrslug);
            if(!array_key_exists("response", $selCurrslugRS)){
                $CurrSlug = $selCurrslugRS[0]["curriculum_slug"];
            }
	    unset($selCurrslugRS);
            $batchID = $_POST["ddlbatch"];
            $selBatchid = "SELECT batch_id FROM avn_batch_master WHERE unique_id = " . $batchID;
            $selBatchidRS = $db->query("query", $selBatchid);
            if(!array_key_exists("response", $selCurrslugRS)){
                $Batch = $selBatchidRS[0]["batch_id"];
            }
	    unset($selBatchidRS);
            $userInfo = $_COOKIE["userInfo"];
            $cookieData = $db->_decrypt($userInfo, ENCKEY);
            $arrUserInfo = unserialize($cookieData);
            
            $new_array = array('curriculum_id'=>$CurrID ,'curriculum_slug'=>$CurrSlug,'batch_id'=>$Batch);
            $a= array_merge($arrUserInfo, $new_array);
            $cookieData = $a;
            $encCData = $db->_encrypt(serialize($cookieData), ENCKEY);
	    setcookie("userInfo", $encCData, time() + (24 * 60 * 60), "/");
            $fURL = __WEBROOT__ . "/lesson-plan/";
        }
	unset($selCurridRS);
        $db->close();
        header('Location: ' . $fURL);
    }
?>