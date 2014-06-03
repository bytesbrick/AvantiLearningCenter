<div class="leftdiv">
	<span class="filter">Filters</span>
	<a class="clearfilter">Clear Filters</a>
<!--<div class="level">
<span class="txtlevel">Curriculum</span>
<?php
	//$r = $db->query("query","select * from avn_curriculum_master");
	for($i=0; $i<count($r); $i++){
?>
	<div class="chkcontent">
		<input type="checkbox" id="chklevel-<?php echo $r[$i]["unique_id"]; ?>" class="check" name="chkcurriculum" onclick="javascript: _createFilterResource('chkcurriculum', this.value, this.id,<?php //echo $r[$i]['unique_id']; ?>,<?php echo $_GET['chpID']; ?>,1);" value="<?php echo $r[$i]["unique_id"]; ?>" <?php if($_GET['currID'] == $r[$i]["unique_id"]) echo "checked"; else echo ""; ?>/>
		<span class="toSelect"><?php echo $r[$i]["curriculum_name"]; ?></span>
	</div>
<?php
	}unset($r);
?>
</div>-->
	<div class="level">
		<span class="txtlevel">Grade Levels</span>
		<?php
			$r = $db->query("stored procedure","sp_grade_level()");
			for($i=0; $i<count($r); $i++){
		?>
			<div class="chkcontent">
				<input type="checkbox" id="chklevel-<?php echo $r[$i]["ID"]; ?>" class="check" name="chkgrade" onclick="javascript: _createFilterResource('chkgrade', this.value, this.id,<?php echo $_GET['tpID']; ?>,<?php echo $_GET['currID']; ?>,<?php echo $_GET['chpID']; ?>);" value="<?php echo $r[$i]["ID"]; ?>">
				<span class="toSelect"><?php echo $r[$i]["Grade Level"]; ?></span>
			</div>
		<?php
			}
			unset($r);
		?>
	</div>
	<!--<div class="level">
	<span class="txtlevel">Subjects</span>
	<?php
	   // $r = $db->query("query","select * from ltf_category_master");
		for($i=0; $i<count($r); $i++){
	?>
	<div class="chkcontent">
		<input type="checkbox" id="chklevel-<?php echo $r[$i]["unique_id"]; ?>" class="check" name="chkcategory" onclick="javascript: _createFilterResource('chkcategory', this.value, this.id,<?php echo $_GET["currID"]; ?>,1);" value="<?php echo $r[$i]["unique_id"]; ?>">
		<span class="toSelect"><?php echo $r[$i]["category_name"]; ?></span>
	</div>
	<?php
		}
		unset($r);
	?>
	</div>-->
	<div class="level">
		<span class="txtlevel">Lesson Time
			<!--<input type="text" id="textLessonTime" name="textLessonTime"  />-->
		</span>
		<div id="slider-range-max-1"></div>
	</div>
	<div class="level">
		<span class="txtlevel">Classwork
			<!--<input type="text" id="textClassworkTime" name="textClassworkTime"  />-->
		</span>
		<div id="slider-range-max-2"></div>
	</div>
	<div class="level">
		<span class="txtlevel">Homework
		   <!-- <input type="text" id="textHomeworkTime" name="textHomeworkTime"  />-->
		</span>
		<div id="slider-range-max-3"></div>	
	</div>
</div><!--left div ends-->