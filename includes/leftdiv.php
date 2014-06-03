<div class="longdiv">
	<div class="batchdiv">
		<div class="photodiv">
			<a href="javascript:void(0):"><img src="<?php echo __WEBROOT__; ?>/images/Person50px.png" border="0" /></a>
		</div>
		<div class="batchnamediv">
			<span class="fullnamediv"><?php echo ucwords($arrUserInfo["firstname"]); ?></span>
			<span class="classdiv"><?php echo ucwords($arrUserInfo["batch_id"]); ?></span>
		</div>
	</div>
	<div class="batchdiv">
		<?php
			if(isset($arrUserInfo["user_type"]) && $arrUserInfo["user_type"] == "Manager"){
		?>
			<div class="notediv">
				<div class="bookdiv">
					<img src="<?php echo __WEBROOT__;?>/images/lesson-plan.png" border="0" width="24" />
				</div>
				<span class="lessonsdiv"><a href="<?php echo __WEBROOT__; ?>/batches/">Batches</a></span>
				<div class="sidediv">
					<img src="<?php echo __WEBROOT__;?>/images/right_arrow-15px.png" border="0" />
				</div>
			</div>
		<?php
			}
		?>
		<div class="notediv">
			<div class="bookdiv">
				<img src="<?php echo __WEBROOT__;?>/images/lesson-plan.png" border="0" width="24" />
			</div>
			<span class="lessonsdiv"><a href="<?php echo __WEBROOT__; ?>/lesson-plan/">Lesson Plan</a></span>
			<div class="sidediv">
				<img src="<?php echo __WEBROOT__;?>/images/right_arrow-15px.png" border="0" />
			</div>
		</div>
		<div class="notediv">
			<div class="bookdiv">
				<img src="<?php echo __WEBROOT__;?>/images/completed-topics.png" border="0" width="24" />
			</div>
			<span class="lessonsdiv"><a href="<?php echo __WEBROOT__; ?>/topics-completed/">Completed</a></span>
			<div class="sidediv">
				<img src="<?php echo __WEBROOT__;?>/images/right_arrow-15px.png" border="0" />
			</div>
		</div>
		<div class="notediv">
			<div class="bookdiv">
				<img src="<?php echo __WEBROOT__;?>/images/starred.png" border="0" width="24" />
			</div>
			<span class="lessonsdiv"><a href="<?php echo __WEBROOT__; ?>/topics-starred/">Starred</a></span>
			<div class="sidediv">
				<img src="<?php echo __WEBROOT__;?>/images/right_arrow-15px.png" border="0" />
			</div>
		</div>
		<div class="notediv"  style="border-bottom: 0px !important;">
			<div class="bookdiv">
				<img src="<?php echo __WEBROOT__;?>/images/chapter.png" border="0" width="24" />
			</div>
			<span class="lessonsdiv"><a href="<?php echo __WEBROOT__;?>/<?php echo $arrUserInfo["curriculum_slug"]; ?>/">Chapter</a></span>
			<div class="sidediv">
				<img src="<?php echo __WEBROOT__;?>/images/right_arrow-15px.png" border="0" />
			</div>
		</div>
	</div>
</div>