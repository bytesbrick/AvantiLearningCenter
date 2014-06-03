<!DOCTYPE HTML>
<html xml:lang="en" lang="en" itemscope="" itemtype="http://schema.org">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Avanti Learning Centres | Contact us</title>
<?php
    include_once("./includes/header-meta.php");
?>
</head>
<body>
<div class="mainbody">
	<?php
	include_once("./includes/header.php");
	?>      
	<div class="center">
		<div class="whole" style="margin: 130px 0px 0px 0px;">
			<div class="dimension" style="float:left !important">
			<?php
				for($i=0;$i<4;$i++){
			?>
				<div class="motionclasses" style="margin-left:10px;">
					<img src="./images/pedagogy.png" alt="" title="" border="0" />
					<div class="headingtxt">P1 Motion in 2 Dimensions</div>
					<div class="schedule">15 HRS in Class |</div>
					<div class="schedule">5 HRS at Home</div>
					<div class="tags">
						<ul>
						<li>
							<span class="fl"><a href="javascript:void(0);" class="linktopics">IIT JEE</a></span>
							>
						</li>
						<li>
							<span class="fl"><a href="javascript:void(0);" class="linktopics">Physics</a></span>
							>
						</li>
						<li>
							<span class="fl"><a href="javascript:void(0);" class="linktopics">Motion in 2D</a></span>
						</li>
						</ul>
					</div>
					<div class="content mt5">
						Our curriculam is developed by India's top IIT-JEE teachers.Our team has helped over 1,700 qualify the IIT JEE with 75  students placing in the top 100 nationally.              
					</div>
				</div><!-- end of  motionclasses-->
			<?php
				}
			?>
			</div><!-- end of dimension -->
		</div>
	</div><!------ center div ends------>
	<div class="footerindex"></div>
</div>
<script language="javascript" type="text/javascript">
	var pageName ="contact-us";
	document.getElementById("nav-main").getElementsByTagName("li")[5].getElementsByTagName("a")[0].className = "activeitem";
</script>
</body>
</html>
