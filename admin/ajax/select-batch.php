<?php
    $html = "";
    $resp = "";
    if(isset($_POST["batch_id"]) && $_POST["batch_id"] != ""){
        include_once("../includes/config.php");  
	include("../classes/cor.mysql.class.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
        $currID = 0;
        $sql = "SELECT curriculum_id FROM avn_batch_master WHERE unique_id = " . $_POST["batch_id"];
        $rsCurr = $db->query("query", $sql);
        if(!array_key_exists("response", $rsCurr))
            $currID = $rsCurr[0]['curriculum_id'];
        unset($rsCurr);
        
        if($currID > 0){
            $batch = "SELECT abm.unique_id,abm.batch_name,abm.batch_id,acm.city_name,alcm.center_name FROM avn_batch_master abm INNER JOIN avn_city_master acm ON acm.unique_id = abm.city_id INNER JOIN avn_learningcenter_master alcm ON alcm.city_id = acm.unique_id WHERE abm.unique_id = " . $_POST["batch_id"];
           
            $batchRS = $db->query("query", $batch);
            $html .='<table width="100%" cellpadding="5" cellspacing="0" border="0">';
            $html .='<tr style="background: #F7CC7A;">';
            $html .='<td class="text" width="25%">Batch ID</td>';
            $html .='<td width="25%"><input id="txtbatchid" class="inputsearch" type="text" placeholder="Batch ID" name="txtbatchid" value=' . $batchRS[0]["batch_id"] . ' readonly=readonly><input id="hdBatchID" name="hdBatchID" type="hidden" value=' . $batchRS[0]["unique_id"] . ' /></td>';
            $html .='<td class="text" width="25%">Batch Name</td>';
            $html .='<td width="25%"><input id="txtbatchname" class="inputsearch" type="text"  placeholder="Batch Name" name="txtbatchname" value=' . $batchRS[0]["batch_name"] . ' readonly=readonly></td>';
            $html .='</tr>';
            $html .='<tr style="background: #F7D79A;">';
            $html .='<td class="text">City</td>';
            $html .='<td><input id="txtcity" class="inputsearch" type="text"  placeholder="Batch City" name="txtcity" value=' . $batchRS[0]["city_name"] . ' readonly=readonly></td>';
            $html .='<td class="text">Center</td>';
            $html .='<td><input id="txtcenter" class="inputsearch" type="text"  placeholder="Center Name" name="txtcenter" value=' . $batchRS[0]["center_name"] . ' readonly=readonly></td>';
            $html .='</tr>';
            $html .='<tr style="background: #F7CC7A;">';
            $html .='<td class="text">Subject</td>';
            $html .='<td colspan="3">';
            $html .='<select name="ddlSubject" id="ddlSubject" class="inputsearch ddlsearch" onchange="javascript: _batchchapters(' . $_POST["batch_id"] . ',this.value)">';
            $html .='<option value="0">All</option>';
                    $sqlSubjects = "select unique_id, category_name from ltf_category_master lcm";
                    $rsSubjects = $db->query("query", $sqlSubjects);
                    if(!array_key_exists("response", $rsSubjects)){
                        for($sb = 0; $sb < count($rsSubjects); $sb++){
                            if($_POST["subject_id"] == $rsSubjects[$sb]["unique_id"]){
                                $html .="<option value='" . $rsSubjects[$sb]["unique_id"] . "' selected>" . $rsSubjects[$sb ]["category_name"] . "</option>";
                            }
                            else
                                $html .="<option value='" . $rsSubjects[$sb]["unique_id"] . "'>" . $rsSubjects[$sb ]["category_name"] . "</option>";
                        }
                    }
            $html .='</select>';
            $html .='</td>';
            $html .='</tr>';
            $html .='</table>';
            if(isset($_POST["subject_id"]) && $_POST["subject_id"] != ""){
                $rsChapters = $db->query("query", "SELECT cm.unique_id,cm.chapter_name FROM avn_chapter_master cm INNER JOIN ltf_category_master lcm ON cm.category_id = lcm.unique_id WHERE cm.category_id = '" . $_POST["subject_id"] . "' AND lcm.curriculum_id = " . $currID . " ORDER BY cm.entry_date DESC");
            }
            else{
                $rsChapters = $db->query("query", "SELECT cm.unique_id,cm.chapter_name FROM avn_chapter_master cm INNER JOIN ltf_category_master lcm ON cm.category_id = lcm.unique_id WHERE lcm.curriculum_id = " . $currID . " ORDER BY cm.entry_date DESC");
            }
                if(!array_key_exists("response", $rsChapters)){
                    $html .='<div class="batchChap mt10">';
                    $html .='<table width="100%" cellpadding="5" cellspacing="1" border="0">';
                    $html .='<tr class="headerRow">';
                    $html .='<th class="white">Select</th>';
                    $html .='<th class="white">Chapters</th>';
                    $html .='<th class="white">Priority</th>';
                    $html .='</tr>';
                    $sqlCountP = "SELECT COUNT(batch_id) as Total FROM avn_batch_chapter_mapping WHERE batch_id = " . $_POST["batch_id"];
                    $isSubjCount = $db->query("query", $sqlCountP);
                    $subjCount = 0;
                    if(!array_key_exists("response", $isSubjCount))
                        $subjCount = $isSubjCount[0]["Total"];
                    //print_r($isSubjCount);
                    unset($isSubjCount);
                    
                    for($i = 0; $i < count($rsChapters); $i++){
                        $sqlATB = "SELECT priority FROM avn_batch_chapter_mapping WHERE chapter_id = " . $rsChapters[$i]['unique_id'] . " AND batch_id = " . $_POST["batch_id"];
                        $isAssignedToBatch = $db->query("query", $sqlATB);
                        $prio = 0;
                        $isAssigned = false;
                        
                        if(!array_key_exists("response", $isAssignedToBatch)){
                            $isAssigned = true;
                            $prio = $isAssignedToBatch[0]["priority"];
                        }
                        unset($isAssignedToBatch);
                        if($i%2 == 0)
                            $class = "lightyellow";
                        else
                            $class = "darkyellow";
                        $html .='<tr class=' .$class . ' class="taleft" id="chapterRow-' . $i .'">';
                        $html .='<td style="width: 50px !important;">';
                        
                        $html .='<input type="checkbox" id="chk-'. $i . '" name="chk[]" value=' . $rsChapters[$i]['unique_id'] . ' onclick="javascript: _checkChapter(this,' . $i . ');"';
                        if($isAssigned){$html .=' checked="checked"';}
                        $html .=' />';
                        $html .='</td>';
                        $html .='<td>'. $rsChapters[$i]["chapter_name"] . '</td>';
                        $html .='<td>';  
                        $html .='<span>';
                        $html .='<select id="ddlpriority-'. $i . '" name="ddlpriority"';
                        if(!$isAssigned){$html .=' disabled=true';}
                        $html .= '>';
                        $html .='<option value="">Choose one</option>';
                        //if($isAssigned){
                            for($j = 1; $j <= $subjCount; $j++){
                                if($j == $prio)
                                    $html .='<option value="' . $j . '" selected="selected">' . $j . '</option>';
                                else
                                    $html .='<option value="' . $j . '">' . $j . '</option>';
                            }
                        //}
                        $html .='</select>';
                        $html .='</span>';
                        $html .='</td>';
                        $html .='</tr>';
                    }
                    $html .='</table></div>';
                    $html .='<table width="100%" cellpadding="5" cellspacing="1" border="0" class="mt10">';
                        $html .='<tr>';
                        $html .='<td>';
                        $html .='<input type="button" id="btnSave" name="btnSave" class="btnSIgn mt10" value="Update" onclick="javascript: _saveChaptersForBatch();" >&nbsp;<input type="button" id="btnClose" name="btnClose" class="btnSIgn mt10" value="Cancel" onclick="javascript: _hideFloatingObjectWithID(\'popupContact\');_enableThisPage();">';
                        $html .='</td>';
                        $html .='</tr>';
                        $html .='</table>';
                    $resp = $subjCount;
                } else {
                    $resp = 0;
                    $html ='<div style="margin: 10px 0 0 0px;color:#a74242;">';
                    $html .='No chapters found for the selected subject/batch.';
                    $html .='</div>';
                }            
            unset($rsSubjects);
            $db->close();
        }else{
            $resp = 0;
            $html ='<div style="margin: 10px 0 0 0px;color:#a74242;">';
            $html .='No curriculum found for the selected batch.';
            $html .='</div>';
        }
    }
    else
        $resp = -1;
    echo $resp . "|#|" . $html;
?>