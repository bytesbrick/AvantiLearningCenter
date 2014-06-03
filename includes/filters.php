<span style="float: left;width:100%;padding: 5px 5px 5px 0;">Filters</span>
<?php
    $batchSubjects = "SELECT DISTINCT lcm.unique_id as SubjectID,lcm.category_name,acm.unique_id,acm.curriculum_name FROM avn_curriculum_master acm 
INNER JOIN avn_batch_master abm ON abm.curriculum_id = acm.unique_id INNER JOIN avn_student_master asm ON asm.batch_id = abm.unique_id INNER JOIN ltf_category_master lcm ON lcm.curriculum_id = abm.curriculum_id WHERE acm.curriculum_name = '" . $curname . "'";
    $batchSubjectsRS = $db->query("query", $batchSubjects);
    if(!array_key_exists("response", $batchSubjectsRS)){
?>
        <div class="filterall">
            <input type="checkbox" id="chkAllsubject" name="chkAllsubject" class="fl"  checked="checked" onclick="javascript: _updateParam('page', '1');_subjectFilter('chkAllsubject','chkSubject','chkSubject-<?php echo $batchSubjectsRS[0]["SubjectID"]; ?>',this.id, '<?php echo $action; ?>', 'all');">
            <span class="fl" style="font-family: helvetica;font-size:13px;">All Subjects</span>
        </div>
<?php
        for($s = 0; $s < count($batchSubjectsRS); $s++){
?>
            <div class="chksubject">
                <input type="checkbox" id="chkSubject-<?php echo $batchSubjectsRS[$s]["SubjectID"]; ?>" name="chkSubject" class="fl" value="<?php echo $batchSubjectsRS[$s]["SubjectID"]; ?>" onclick="javascript: _subjectFilter('chkAllsubject','chkSubject',this.id,this.value, 'single');" value="<?php echo $r[$i]["unique_id"]; ?>">
                <span class="subject"><?php echo $batchSubjectsRS[$s]["category_name"]; ?></span>
            </div>
<?php
        }
    }
    unset($batchSubjectsRS);
    $db->close();
?>