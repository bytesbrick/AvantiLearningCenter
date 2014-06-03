<?php
    $html = "";
    $resp = "";
    if(isset($_POST["teacher_id"]) && $_POST["teacher_id"] != ""){
        include_once("../includes/config.php");  
	include("../classes/cor.mysql.class.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
        $cityID = $_POST["city_id"];
        
        if($cityID > 0){
            $batch = "SELECT atm.*,cty.city_name FROM avn_teacher_master atm INNER JOIN avn_city_master cty ON atm.city_id = cty.unique_id WHERE atm.unique_id = " . $_POST["teacher_id"];
            $batchRS = $db->query("query", $batch);
            $html .='<table width="100%" cellpadding="5" cellspacing="0" border="0">';
            $html .='<tr style="background: #F7CC7A;">';
            $html .='<td class="text" width="25%">Teacher ID</td>';
            $html .='<td width="25%"><input id="txtbatchid" class="inputsearch" type="text" placeholder="Batch ID" name="txtbatchid" value=' . $batchRS[0]["teacher_id"] . ' readonly=readonly><input id="hdTeacherID" name="hdTeacherID" type="hidden" value=' . $_POST["teacher_id"] . ' /><input id="hdCityID" name="hdCityID" type="hidden" value=' . $cityID . ' /></td>';
            $html .='<td class="text" width="25%">Name</td>';
            $html .='<td width="25%"><input id="txtbatchname" class="inputsearch" type="text"  placeholder="Batch Name" name="txtbatchname" value=' . $batchRS[0]["fname"] . '&nbsp;' . $batchRS[0]["lname"] . ' readonly=readonly></td>';
            $html .='</tr>';
            $html .='<tr style="background: #F7D79A;">';
            $html .='<td class="text">City</td>';
            $html .='<td><input id="txtcity" class="inputsearch" type="text"  placeholder="Batch City" name="txtcity" value=' . $batchRS[0]["city_name"] . ' readonly=readonly></td>';
            $html .='<td class="text">Center</td>';
            $html .='<td colspan="3">';
            $html .='<select name="ddlSubject" id="ddlSubject" class="inputsearch ddlsearch" onchange="javascript: _batchchapters(' . $cityID . ',' . $_POST["teacher_id"] . ',this.value)">';
	    
            $html .='<option value="0">All</option>';
                    $sqlSubjects = "select unique_id, center_code,center_name from avn_learningcenter_master WHERE city_id = " . $cityID;
                    $rsSubjects = $db->query("query", $sqlSubjects);
                    if(!array_key_exists("response", $rsSubjects)){
                        for($sb = 0; $sb < count($rsSubjects); $sb++){
                            if($_POST["center_id"] == $rsSubjects[$sb]["unique_id"]){
                                $html .="<option value='" . $rsSubjects[$sb]["unique_id"] . "' selected>" . $rsSubjects[$sb ]["center_name"] . "</option>";
                            }
                            else
                                $html .="<option value='" . $rsSubjects[$sb]["unique_id"] . "'>" . $rsSubjects[$sb ]["center_name"] . "</option>";
                        }
                    }
            $html .='</select>';
            $html .='</td>';
	    $html .='</tr>';
	    $html .='<tr>';
	    if(!isset($_POST["center_id"]))
		$html .='<td colspan="4" style="text-align:center;color:#a74242;padding-top:10px;font-size:15px;">Please select a center to select the batches.</td></tr>';
            $html .='</table>';
            if(isset($_POST["center_id"]) && $_POST["center_id"] != ""){
                $rsChapters = $db->query("query", "SELECT bm.unique_id,bm.batch_name,bm.batch_id FROM avn_batch_master bm INNER JOIN avn_teacher_master atm ON atm.city_id = bm.city_id WHERE atm.city_id = " . $cityID . " AND bm.learning_center = " . $_POST["center_id"] . " ORDER BY bm.entry_date DESC");
                if(!array_key_exists("response", $rsChapters)){
                    $html .='<div class="batchChap mt10">';
                    $html .='<table width="100%" cellpadding="5" cellspacing="1" border="0">';
                    $html .='<tr class="headerRow">';
                    $html .='<th class="white">Select</th>';
                    $html .='<th class="white">Batches</th>';
                    $html .='<th class="white">Barches ID</th>';
                    $html .='</tr>';
                    for($i = 0; $i < count($rsChapters); $i++){
                        $sqlATB = "SELECT center_id FROM avn_teacher_batch_mapping WHERE batch_id = " . $rsChapters[$i]['unique_id'] . " AND center_id = " . $_POST["center_id"] . " AND teacher_id = " . $_POST["teacher_id"];
                        $isAssignedToBatch = $db->query("query", $sqlATB);
                        $isAssigned = false;
                        if(!array_key_exists("response", $isAssignedToBatch)){
                            $isAssigned = true;
                        }
                        unset($isAssignedToBatch);
                        if($i%2 == 0)
                            $class = "lightyellow";
                        else
                            $class = "darkyellow";
                        $html .='<tr class=' .$class . ' class="taleft" id="chapterRow-' . $i .'">';
                        $html .='<td style="width: 50px !important;">';
                        $html .='<input type="checkbox" id="chk-'. $i . '" name="chk[]" value=' . $rsChapters[$i]['unique_id'] . '';
                        if($isAssigned){$html .=' checked="checked"';}
                        $html .=' />';
                        $html .='</td>';
                        $html .='<td>'. $rsChapters[$i]["batch_name"] . '</td>';
                        $html .='<td>'. $rsChapters[$i]["batch_id"] . '</td>';
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
                }
		else{
		    $html .='<span style="margin: 10px 0 0 0px;color:#a74242;float:left;text-align:center;width:100%;font-size:15px;">No batches for this center.</span>';
		}
	    }
	    $resp = 1;
            unset($rsSubjects);
            $db->close();
        }else{
            $resp = 0;
            $html ='<div style="margin: 10px 0 0 0px;color:#a74242;">';
            $html .='No centers found for the selected teacher city.';
            $html .='</div>';
        }
    }
    else
        $resp = -1;
    echo $resp . "|#|" . $html . "|#|" . $selectbatch;
?>