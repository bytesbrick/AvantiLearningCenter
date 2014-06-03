<?php
    error_reporting(1);
    ini_set('auto_detect_line_endings',TRUE);
    if(isset($_FILES['csvFile'])){
        ini_set("post_max_size", "15M");
        ini_set('upload_max_filesize', '15M');
        if(!is_dir("./csv/" . date('Y')))
        mkdir("./csv/" . date('Y'), 0775);
        if(!is_dir("./csv/" . date('Y') . "/" . date('m')))
        mkdir("./csv/" . date('Y') . "/" . date('m'), 0775);
        if(!is_dir("./csv/" . date('Y') . "/" . date('m') . "/" . date('d')))
        mkdir("./csv/" . date('Y') . "/" . date('m') . "/" . date('d'), 0775);
        $uploaddir = "./csv/" . date('Y') . "/" . date('m') . "/" . date('d') . "/"; 
        $file = $uploaddir . basename($_FILES['csvFile']['name']); 
        $file_name= $_FILES['csvFile']['name']; 
         
        if (move_uploaded_file($_FILES['csvFile']['tmp_name'], $file)) {
          $rezultat = $file;
        } else {
          $rezultat = '';
        }
        //echo $rezultat;
        $rezultat = urlencode($rezultat);
        if($rezultat != "")
        {
            include_once("./includes/config.php");  
            include("./classes/cor.mysql.class.php");
            $db = new MySqlConnection(CONNSTRING);
            $db->open();
            
            $csvFile = fopen($file, "r");
            $iCounter = 0;
            while(!feof($csvFile)){
                $arrVals = fgetcsv($csvFile);
                if($iCounter > 0 && count($arrVals) > 8){
                    $sql = "SELECT unique_id FROM avn_batch_master WHERE batch_id = '" . $arrVals[10] . "'";
                    $batchID = $db->query("query", $sql);
                    if(!array_key_exists('response', $batchID)){
                        $studentID = intval($arrVals[0]) < 10 ? $arrVals[10] . "0" . $arrVals[0]: $arrVals[10] . $arrVals[0];
                        $dataToSave = array();
                        $dataToSave['fname'] = $arrVals[1];
                        $dataToSave['lname'] = $arrVals[2];
                        $dataToSave['student_id'] = $studentID;
                        $dataToSave['batch_id'] = $batchID[0]["unique_id"];
                        $dataToSave['email_id'] = $arrVals[3];
                        $dataToSave['phone'] = $arrVals[4];
                        $dataToSave['board'] = $arrVals[7];
                        $dataToSave['school'] = $arrVals[6];
                        $dataToSave['address'] = $arrVals[5];
                        $dataToSave['gender'] = $arrVals[9];
                        $dataToSave['status'] = $arrVals[8];
                        $dataToSave['entry_date'] = "now()";
                        $r = $db->insert('avn_student_master',$dataToSave);
                        unset($dataToSave);
                        if(array_key_exists('response', $r)){
                            if($r['response'] == "SUCCESS"){
                                $sql = "SELECT MAX(unique_id) as NewStudentID FROM avn_student_master";
                                $maxISRs = $db->query("query", $sql);
                                $dataToLogin = array();
                                $dataToLogin['password'] = "AES_ENCRYPT('" . $studentID . "', '" . ENCKEY . "')";
                                $dataToLogin['username'] = $arrVals[3];
                                $dataToLogin['gender'] = $arrVals[9];
                                $dataToLogin['status'] = $arrVals[8];
                                $dataToLogin['firstname'] = $arrVals[1];
                                $dataToLogin['lastname'] = $arrVals[2];
                                $dataToLogin['entrydate'] = "now()";
                                $dataToLogin['user_type'] = "Student";
                                $dataToLogin['userid'] = "uuid()";
                                $dataToLogin['emailid'] = $arrVals[3];
                                $dataToLogin['user_ref_id'] = $maxISRs[0]['NewStudentID'];
                        
                                $user = $db->insert('avn_login_master',$dataToLogin);
                                unset($dataToLogin);
                            }
                        }
                    }
                    unset($batchID);
                }
                $iCounter++;
            }
            fclose($csvFile);
            $db->close();
        }
        echo '<body onload="javacript: parent.doneCSVUpload(\''.$rezultat.'\')"></body>' . $a;   
    }
?>