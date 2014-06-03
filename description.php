<!DOCTYPE HTML>
<html xml:lang="en" lang="en" itemscope="" itemtype="http://schema.org">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Avanti | Chapter-list</title>
<?php
    include_once("./includes/header-meta.php");
    include_once("./includes/config.php");  
    include("./classes/cor.mysql.class.php");
    $db = new MySqlConnection(CONNSTRING);
    $db->open();
?>
</head>
    <body>
	<div class="mainbody">
	    <?php
		include_once("./includes/header.php");
	    ?>
                <div class="clb"></div>
		<div class="center">
		    <div class="whole">
			    <?php
				$r = $db->query("query","select unique_id,resource_title,resource_desc,resource_pic from ltf_resources_master where unique_id = " . $_GET['id']);
				if(!isset($r["response"])){
			    ?>
				    <div class="description">
					<div class="resource_title"><?php echo $r[0]["resource_title"]; ?></div>
					<div class="resource_desc"><?php echo $r[0]["resource_desc"]; ?></div>
					<div class=""></div>
				    </div>
				    <div class="textdesc">
					<div class="resource-pic">
					    <img src="./admin/images/upload-image/<?php echo $r[0]["resource_pic"]; ?>"  />
					</div>
					<div class="resource">
					    <div class="contentresource"></div>
					    <div class="contentresource">
						<span class="headingresource">Chapter:</span>
						<?php
						    $k= $db->query("query","select acm.chapter_name from avn_chapter_master acm inner join avn_resources_chapter arc on acm.unique_id= arc.chapter_id where arc.resource_id=". $_GET['id']);
						    if(!isset($k["response"])){
							for($j=0;$j<count($k);$j++){
						    ?>
							    <span class="headtext"><?php echo $k[$j]["chapter_name"]?></span>
						    <?php
							}
						    }
						    ?>
					    </div>
					    <div class="contentresource">
						<span class="headingresource">Grade:</span>
						<?php
						   
						    $g= $db->query("query","select lgl.grade_name from ltf_grade_level_master lgl inner join ltf_resources_grade_level lrl on lgl.unique_id= lrl.resource_id where resource_id=" .$_GET['id']);
						     if(!isset($g["response"])){
						    for($h=0;$h<count($
								      g))
						?>
						<span class="headtext"><?php echo ?></span>
					    </div>
					</div>
				    </div>
			    <?php
				}
				unset($r);
			    ?>
			</div>
		    </div> <!--dimension div ends-->
		    <div class="showmore">
			<a href="javascript:void(0);">SHOW MORE</a>
		    </div><!--showmore div ends-->
		</div><!------ center div ends------>
		<?php
		    include_once("./includes/footer.php");
		?>
        </div>
    </body>
    <script type="text/javascript">
	p.push(new Array("chkcurriculum", '<?php echo $_GET['id']; ?>'));
	_createFilter('chkcurriculum', '<?php echo $_GET['id']; ?>', 'curriculum-<?php echo $_GET['id']; ?>',<?php echo $_GET['id']; ?>,1);
    </script>
</html>
