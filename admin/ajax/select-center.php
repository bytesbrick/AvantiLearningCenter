<?php
    $html = "";
    $resp = "";
    if(isset($_POST["manager_id"]) && $_POST["manager_id"] != ""){
        include_once("../includes/config.php");  
	include("../classes/cor.mysql.class.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
        $currID = 0;
        $sql = "SELECT city_id FROM avn_centermanager_master WHERE unique_id = " . $_POST["manager_id"];
        $rsCity = $db->query("query", $sql);
        if(!array_key_exists("response", $rsCity))
            $CityID = $rsCity[0]['city_id'];
        unset($rsCity);
        if($CityID > 0){
            $batch = "SELECT cty.city_name,acm.center_manager_id, acm.fname,acm.lname,acm.email_id,alcm.unique_id,alcm.center_code,alcm.center_name,alcm.city_id FROM avn_learningcenter_master alcm INNER JOIN avn_centermanager_master acm ON acm.city_id = alcm.unique_id INNER JOIN avn_city_master cty ON cty.unique_id = acm.city_id WHERE acm.city_id= " . $CityID . " AND acm.unique_id = " . $_POST["manager_id"];
            $batchRS = $db->query("query", $batch);
	    $name = $batchRS[0]["fname"]. $batchRS[0]["lname"];
	    $cityName = $batchRS[0]["city_name"];
            $html .='<table width="100%" cellpadding="5" cellspacing="0" border="0">';
            $html .='<tr style="background: #F7CC7A;">';
            $html .='<td class="text" width="25%">Manager Name</td>';
            $html .='<td width="25%"><input id="txtbatchid" class="inputsearch" type="text" placeholder="Batch ID" name="txtbatchid" value="' . $name . '" readonly=readonly><input id="hdBatchID" name="hdBatchID" type="hidden" value=' . $_POST["manager_id"] . ' /></td>';
            $html .='<td class="text">City</td>';
            $html .='<td><input id="txtcity" class="inputsearch" type="text"  placeholder="Batch City" name="txtcity" value="' . $cityName . '" readonly=readonly></td>';
            $html .='</tr>';
            $html .='<tr style="background: #F7D79A;">';
            $html .='<td class="text">Manager ID</td>';
            $html .='<td><input id="txtcity" class="inputsearch" type="text"  placeholder="Batch City" name="txtcity" value="' . $batchRS[0]["center_manager_id"] . '" readonly=readonly></td>';
	    $html .='<td class="text">Email ID</td>';
            $html .='<td><input id="txtcity" class="inputsearch" type="text"  placeholder="Batch City" name="txtcity" value="' . $batchRS[0]["email_id"] . '" readonly=readonly></td>';
            $html .='</tr>';
            $html .='</table>';
	    $getCenters = "SELECT unique_id,center_name,center_code FROM avn_learningcenter_master WHERE city_id = " . $CityID;
	    $getCentersRS = $db->query("query", $getCenters);
                if(!array_key_exists("response", $getCentersRS)){
                    $html .='<div class="batchChap mt10">';
                    $html .='<table width="100%" cellpadding="5" cellspacing="1" border="0">';
                    $html .='<tr class="headerRow">';
                    $html .='<th class="white">Select</th>';
                    $html .='<th class="white">Centers Code</th>';
		    $html .='<th class="white">Center</th>';
                    $html .='</tr>';
                    for($i = 0; $i < count($getCentersRS); $i++){
			$sqlATB = "SELECT center_id FROM avn_manager_center_mapping WHERE center_id = " . $getCentersRS[$i]['unique_id'] . " AND manager_id = " . $_POST["manager_id"];
                        $isAssignedToBatch = $db->query("query", $sqlATB);
                        $prio = 0;
                        $isAssigned = false;
                        
                        if(!array_key_exists("response", $isAssignedToBatch)){
                            $isAssigned = true;
                            $prio = $isAssignedToBatch[0]["center_id"];
                        }
                        unset($isAssignedToBatch);
                        if($i%2 == 0)
                            $class = "lightyellow";
                        else
                            $class = "darkyellow";
                        $html .='<tr class=' .$class . ' class="taleft" id="chapterRow-' . $i .'">';
                        $html .='<td style="width: 50px !important;">';
                        
                        $html .='<input type="checkbox" id="chk-'. $i . '" name="chk[]" value=' . $getCentersRS[$i]['unique_id'] . '';
                        if($isAssigned){$html .=' checked="checked"';}
                        $html .=' />';
                        $html .='</td>';
                        $html .='<td>'. $getCentersRS[$i]["center_code"] . '</td>';
                        $html .='<td>'. $getCentersRS[$i]["center_name"] . '</td>';
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
                    $html .='No centers found.';
                    $html .='</div>';
                }            
            unset($rsSubjects);
            $db->close();
	    $resp = 1;
        }else{
            $html ='<div style="margin: 10px 0 0 0px;color:#a74242;">';
            $html .='No center found for the selected city.';
            $html .='</div>';
	    $resp = 0;
        }
    }
    else
        $resp = -1;
    echo $resp . "|#|" . $html;
?>