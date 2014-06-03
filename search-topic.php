<!DOCTYPE HTML>
<html xml:lang="en" lang="en" itemscope="" itemtype="http://schema.org">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Avanti Learning Centres | Search</title>
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
	    <div class="whole" style="margin: 145px 0px 0px 0px;">
		<?php
		    include_once("./includes/searchleftdiv.php");
		?>
	    <div class="dimension" id="dimensionresource"></div>
	     <div class="showmore" id="showmore">
		    
	       </div>
	    </div>
	</div><!------ center div ends------>
    </div>
    <div class="footer"></div>
    <?php
	include_once("./includes/loginpopup.php");
    ?>
</body>
<script>
	p.push(new Array("query", '<?php echo $_GET["q"]; ?>'));
	_createSearchFilterTopic('query', '<?php echo $_GET["q"]; ?>', 'query-<?php echo $_GET["q"]; ?>','<?php echo $_GET["q"]; ?>');
</script>
</html>