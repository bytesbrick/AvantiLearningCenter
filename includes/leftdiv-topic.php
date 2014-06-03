<div class="longdiv">
	<div class="batchdiv">
	    <div class="photodiv">
		<a href="javascript:void(0):"><img src="<?php echo __WEBROOT__;?>/images/Person50px.png" border="0" /></a>
	    </div>
	    <div class="batchnamediv">
		<span class="fullnamediv"><?php echo ucwords($arrUserInfo["firstname"]); ?></span>
                <span class="classdiv"><?php echo ucwords($arrUserInfo["batch_id"]); ?></span>
	    </div>
	</div>
	<div class="batchdiv" style="padding-bottom: 10px;">
	    <div class="notediv">
	       <div class="bookdiv">
		   <img src="<?php echo __WEBROOT__;?>/images/Lesson-25px.png"/>
	       </div>
	       <span class="lessonsdiv">Grades</span>
	       <div class="sidediv">
		   <img src="<?php echo __WEBROOT__;?>/images/right_arrow-15px.png" border="0" />
	       </div>
	   </div>
		<?php
		    $r = $db->query("stored procedure","sp_grade_level()");
		    for($i=0; $i<count($r); $i++){
		?>
		    <div class="chkcontent">
			<input type="checkbox" id="chklevel-<?php echo $r[$i]["ID"]; ?>" class="check" name="chkgrade" onclick="javascript: _createFilter('chkgrade', this.value, this.id,<?php echo $currID; ?>);" value="<?php echo $r[$i]["ID"]; ?>">
			<span class="toSelect"><?php echo $r[$i]["Grade Level"]; ?></span>
		    </div>
		<?php
		    }
		    unset($r); 
		?>
	</div>
</div>