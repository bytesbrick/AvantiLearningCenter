<?php
    
    $resp = "";
    $html = "";
    if(isset($_POST["action"]) && $_POST["action"] != ""){
        include("../includes/config.php");		
        include("../classes/cor.mysql.class.php");
        include_once("../includes/checklogin.php");
        $db = new MySqlConnection(CONNSTRING);
        $db->open();
        $curslug = $arrUserInfo["curriculum_slug"];
        $batchID = $arrUserInfo["batch_id"];
        $value = $_POST["value"];
        $userid = $arrUserInfo["userid"];
        $subjectid = "";
        if(isset($_POST["chkSubject"]) && $_POST["chkSubject"] != "")
        $subjectid = $_POST["chkSubject"];
        $recPerPage = 10;
        $page = "";
        if(isset($_POST["page"]) && $_POST["page"] != "")
        $page = $_POST["page"];
        $startRec = ($page - 1) * $recPerPage;
        $batchUID = 0;
        $totTopic = 0;
        $totCompTopic = 0;
        $allTopicCompleted = false;
        $isStarred = false;
        $sql = "SELECT unique_id FROM avn_batch_master WHERE batch_id = '" . $batchID . "'";
        $rsBatchID = $db->query("query", $sql);
        if(!array_key_exists("response", $rsBatchID))
            $batchUID = $rsBatchID[0]["unique_id"];
        unset($rsBatchID);
        if($batchUID > 0){
            $iCounter = 1;
            
            $sqlLessonPlan = "SELECT tm.unique_id,tm.topic_code, tm.topic_name, tm.topic_slug, lcm.category_name, cm.chapter_name, lcm.category_slug, cm.chapter_slug FROM avn_topic_master tm INNER JOIN avn_chapter_master cm ON tm.chapter_id = cm.unique_id INNER JOIN avn_batch_chapter_mapping abcm ON abcm.chapter_id = cm.unique_id INNER JOIN ltf_category_master lcm ON cm.category_id = lcm.unique_id";
            if($_POST["action"] == "Incomplete")
                $sqlLessonPlan .= " LEFT JOIN avn_user_topic_mapping aut ON aut.topic_id = tm.unique_id ";
            elseif($_POST["action"] == "Complete")
                $sqlLessonPlan .= " INNER JOIN avn_user_topic_mapping aut ON aut.topic_id = tm.unique_id";
            elseif($_POST["action"] == "Starred"){
                $sqlLessonPlan .= " INNER JOIN avn_user_topic_starred auts ON auts.topic_id = tm.unique_id";
                $isStarred = true;
            }
            if($subjectid != "")
                $sqlLessonPlan .= " WHERE abcm.batch_id = " . $batchUID . " AND cm.category_id IN (" . $subjectid . ") AND tm.status = 1 ";
            else
                $sqlLessonPlan .= " WHERE abcm.batch_id = " . $batchUID . " AND tm.status = 1";
                
            if($_POST["action"] == "Incomplete")
            $sqlLessonPlan .= " AND aut.topic_id IS NULL";
            
            $sqlLessonPlan .= " ORDER BY tm.topic_priority ASC LIMIT " . $startRec . ", " . ($recPerPage + 1);
            $rsLessonPlan = $db->query("query", $sqlLessonPlan);
            //print_r($rsLessonPlan);
            if(!array_key_exists("response", $rsLessonPlan)){
                $totTopic += count($rsLessonPlan);
                $maxI = $recPerPage;
                if(count($rsLessonPlan) < $recPerPage)
                    $maxI = count($rsLessonPlan);
                $iCounter = ($startRec + 1);
                for($i = 0; $i < $maxI; $i++){
                    $isDataFound = true;
                    if($iCounter % 2 == 0)
                        $class = "lightgrey";
                    else
                        $class = "white";
                    $html .="<tr class= '" . $class ."' id='leaduserRow-". $rsLessonPlan[$i]['unique_id'] . "'>";
                    $html .="<td width='90px'><table cellpadding='0' cellspacing='0' border='0'><tr>";
                    $html .="<td style='padding-left:6px !important;'><span class='checkboxFive'><input type='checkbox' name='chkUser[]' id='chk-". $rsLessonPlan[$i]['unique_id'] . "' value=" . $rsLessonPlan[$i]['unique_id'] . " onclick='javascript: _checked(this, $i,1);' />";
                    $html .="<label for='chk-". $rsLessonPlan[$i]['unique_id'] . "'></label></span></td>";
                    if($isStarred){
                        $html .="<td style='padding-left:15px !important;'><a href='javascript: void(0);' onclick='javascript: _singleStarred(" . $rsLessonPlan[$i]['unique_id'] . ", 0, this);'><img src=\"" . __WEBROOT__ . "/images/star.png\" border=\"0\" id=\"btnStar-" . $rsLessonPlan[$i]['unique_id'] . "\" alt=\"Starred\" title=\"Starred\" width=\"17px\" height=\"17px\" class=\"ml10\" /></a></td>";
                        $selcompletetopics = "SELECT topic_id FROM avn_user_topic_mapping WHERE topic_id = " . $rsLessonPlan[$i]['unique_id'];
                        $selCompletedTopicsRS = $db->query("query", $selcompletetopics);
                        if(!array_key_exists("response", $selCompletedTopicsRS))
                        $html .="<td style='padding-left:15px !important;'><img src=\"" . __WEBROOT__ . "/images/correct-ans.png\" border=\"0\" id=\"btnStar\" alt=\"Starred\" title=\"Starred\" width=\"17px\" height=\"17px\" class=\"ml10\" /></td>";
                        else
                        $html .="<td>&nbsp;</td>";
                        unset($selCompletedTopicsRS);
                    } else {
                        $selstarredtopics = "SELECT topic_id FROM avn_user_topic_starred WHERE topic_id = " . $rsLessonPlan[$i]['unique_id'];
                        $selstarredtopicsRS = $db->query("query", $selstarredtopics);
                        if(!array_key_exists("response", $selstarredtopicsRS))
                            $html .="<td style='padding-left:15px !important;'><a href='javascript: void(0);' onclick='javascript: _singleStarred(" . $rsLessonPlan[$i]['unique_id'] . ", 0, this);'><img src=\"" . __WEBROOT__ . "/images/star.png\" border=\"0\" id=\"btnStar-" . $rsLessonPlan[$i]['unique_id'] . "\" alt=\"Starred\" title=\"Starred\" width=\"17px\" height=\"17px\" class=\"ml10\" /></a></td>";
                        else
                            $html .="<td style='padding-left:15px !important;'><a href='javascript: void(0);' onclick='javascript: _singleStarred(" . $rsLessonPlan[$i]['unique_id'] . ", 1, this);'><img src=\"" . __WEBROOT__ . "/images/unstar.png\" border=\"0\" id=\"btnStar-" . $rsLessonPlan[$i]['unique_id'] . "\" alt=\"Unstarred\" title=\"Unstarred\" width=\"17px\" height=\"17px\" class=\"ml10\" /></a></td>";
                        unset($selstarredtopicsRS);
                    }
                    $html .= "</tr></table></td>";
                    $html .="<td>" . $iCounter . "</td>";
                    $html .="<td><span class='ft14'>" . $rsLessonPlan[$i]['topic_code'] . "</span></td>";
                    $html .= "<td><a href='" .  __WEBROOT__ . "/" . $curslug . "/" . $rsLessonPlan[$i]['category_slug'] . "/" . $rsLessonPlan[$i]['chapter_slug'] . "/" . $rsLessonPlan[$i]['topic_slug'] . "/' class='title ft14' style='word-wrap: break-word;'>";
                    $html .= "" . $rsLessonPlan[$i]['topic_name'] . "<br /><span class='black'>" . $rsLessonPlan[$i]['chapter_name'] . " </span>";
                    $html .= "</a></td>";
                     $html .="<td><span class='ft14'>" . $rsLessonPlan[$i]['category_name'] . "</span></td>";
                    $html .= "<td align='center'>";
                    $html .= "<a href='" .  __WEBROOT__ . "/" . $curslug . "/" . $rsLessonPlan[$i]['category_slug'] . "/" . $rsLessonPlan[$i]['chapter_slug'] . "/" . $rsLessonPlan[$i]['topic_slug'] . "/' class='topichover'><img src=\"" . __WEBROOT__ . "/images/resourceimg.png\" border=\"0\" alt=\"View resources\" title=\"View resources\" class=\"ml10\" /></a>";
                    $html .="</td>";
                    $html .="</tr>";
                    $iCounter++;                           
                }
                $resp = 1;
                if(count($rsLessonPlan) > $recPerPage){
                    $html .="<tr class='ffhelvetica'>";
                    $html .="<td colspan='4' style='text-align:center;padding:20px 0 0 0;'><div class='showmore'><a href='javascript: void(0);' onclick='javascript: _updateParam(\"page\", \"" . ($page + 1) . "\");_applyFilter();' style='color:#c1c1c1;'>Show more</a></div></td>";
                    $html .="</tr>";
                    
                }
            }
            unset($rsLessonPlan);
        }   
        $db->close(); 
    }
    else
        $resp = 0;
    echo $resp . "|#|" . $html;
?>