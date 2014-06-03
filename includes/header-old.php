   <!-- <div class="band"></div>-->
    <div id="headerNew">
	<div class="center">
        <?php
	    if(isset($_COOKIE["cUserName"]))
		$UserName = $_COOKIE["cUserName"];
            include_once("./includes/config.php");
            include_once("./classes/cor.mysql.class.php");
            $db = new MySqlConnection(CONNSTRING);
            $db->open();
        ?>
	    <header id="banner" class="container_24" role="banner">
	    <div class="grid_24">
    <!-- Login and Search Area -->
		    <div id="pre-header" class="container">
			<article id="search-3" class="widget-1 widget-first widget widget_search">
			    <div class="widget-1 widget-first container">
				<div id="loginuser" style="height: 20px; float: right;">
				    <!-- <div id="menu">
					 <ul>
					     <li><?php //echo ucwords($UserName); ?>&nbsp; | &nbsp;</li>
					     <li>Account
						 <div id="submenu">
						     <ul>
							 <li><a href="./password-change.php" class="loginclr">Change password</a>
							 <li><a href="./logout.php">Logout</a></li>
						     </ul>
						 </div>
					     </li>  
					 </ul>
				     </div>-->
				    <div id="cssmenu" style="height: 20px;">
					<ul>
					    <?php if(isset($UserName))
						{
					    ?>
						    <li class='has-sub last'><span><?php echo ucwords($UserName); ?>&nbsp; | &nbsp;</span> 
						     <li class='has-sub last'><span>Account</span>
							<ul>
							    <li><a href='<?php echo __WEBROOT__; ?>/change-password/'><span>Change Password</span></a></li>
							   <li><a href='<?php echo __WEBROOT__; ?>/logout/'><span>Logout</span></a></li>
							</ul>
						    </li>
					    <?php
						}
					    ?>
					</ul>
				    </div>
				</div>
				<div class="clb"></div>
				<div class="searchbox">
				    <div class="fl">
					<input type="text" id="txtsearch" class="inputseacrh"  onkeyup="javascript: _search(event, this.value, this.id);" placeholder="Search.." name="txtsearch"  /> <a class="searchimg" href="javascript:void(0);" onclick="javascript: _searchresult();"></a></div><div class="clb"></div>
				    <div id="hddnsearchtext"></div>
				</div>
			    </div>
			</article>            
		    </div>
		    <div class="container">
			<a id="logo" href="<?php echo __WEBROOT__; ?>/">
			    <img src="<?php echo __WEBROOT__; ?>/images/logo.png" alt="Avanti" title="Avanti" class="noborder" />
			</a>
			<div class="nav fr" id="nav-main" role="navigation">
			    <ul id="menu-00-primary-navigation" class="menu">
				<li id="menu-about"><a href="./results.php">Results</a></li>
				<li id="menu-learning-centers"><a href="./pedagogy.php">Pedalogy</a></li>
				<?php
				    $selcur = $db->query("query","SELECT curriculum_name, unique_id, curriculum_slug FROM avn_curriculum_master order by unique_id ASC");
				    $cur = $selcur[0]['unique_id'];
				    $slug = $selcur[0]['curriculum_slug'];
				?>
				<li id="menu-fellowship"><a href="<?php echo __WEBROOT__; ?>/curriculums/<?php echo $slug; ?>/">Curriculum</a>
				    <!--<ul class="sub-menu">
					<?php
					//$r = $db->query("query","select * from avn_curriculum_master ");
					//for($i=0; $i<count($r); $i++){
					?>
					    <li><a href="./chapter-list.php?currID=<?php //echo $r[$i]["unique_id"]; ?>"><?php //echo $r[$i]["curriculum_name"]; ?></a></li>
					<?php
					//}
					?>
				    </ul>-->
				</li>
				<li id="menu-application"><a href="./contact-us.php">Contact Us</a></li>
			    </ul>                                   
			</div>                
		    </div>
		</div>
	    </header>
	</div>
    </div>
    