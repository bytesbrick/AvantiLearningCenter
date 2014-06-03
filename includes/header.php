<div class="avantiheaderdiv">
    <?php $user = $arrUserInfo["firstname"];?>
    <div class="logodiv">
	<a href="<?php echo __WEBROOT__; ?>/lesson-plan/"><img src="<?php echo __WEBROOT__;?>/images/Logo-Hindi-only.png" border="0" alt="Avanti" title="Avanti" /></a>
    </div>
    <div class="redcolordiv">
	<div class="enterdiv">
	    <div class="searchdiv">
		<input type="text" name="textsearch" id="textsearch" class="searchtextdiv" placeholder="search for lessons. elements and more..." style="width:500px;" onkeypress="javascript: _chkEntersearch(event);">
	    </div>
	    <div class="searchlogediv">
		<a href="javascript:void(0);" onclick="javascript: _searchdata();" id="search" name="textsearch"><img src="<?php echo __WEBROOT__;?>/images/magnifyingglass-15px.png" border="0" /></a>
	    </div>
	    <div class="namediv">
		<div class="manlogodiv">
		    <img src="<?php echo __WEBROOT__;?>/images/Person30px.png" border="0" />
		</div>
		<span class="clintdiv"><?php echo ucwords($user); ?>
		    <div class="downlogodiv">
			<div class="multimenu fr mr3">
			    <img src="<?php echo __WEBROOT__;?>/images/down_arrow-10px.png" title="More actions" class="mt3" />
			    <div class="cb"></div>
			    <label class="mrlabel">
				<ul style="width: 170px;">
				    <a href="javascript:void(0);"><li>Profile</li></a>
				    <a href="<?php echo __WEBROOT__;?>/password/"><li>Change Password</li></a>
				    <a href="<?php echo __WEBROOT__;?>/logout/"><li>Logout</li></a>
				</ul>
			    </label>
			</div>
		    </div>
		</span>
	    </div>
	</div>
    </div>
</div>