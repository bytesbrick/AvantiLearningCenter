<?php
	error_reporting(0);
	include_once("./includes/checkLogin.php");
	$cType = $_COOKIE["cUserType"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title> Resource &raquo; Avanti  &raquo; Dashboard </title>
<?php
	include_once("./includes/head-meta.php");
	include_once("./includes/config.php");  
	include("./classes/cor.mysql.class.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
?>
<?php
	include_once("./includes/head-meta.php");
?>
</head>
<body>
<form method=post>
<div id="pageR">
	<div id="pageContainerR">
		<div id="wrapper">	
			<div id="header">
			<?php
				include_once("./includes/header.php");
			?>
			</div><!-- End of header -->
			<div id="container">
				<?php
					include_once("./includes/right-menu.php");
				?>
				<div class="about"><a href="topic.php">Topic </a>&raquo; Add Topic</div><!-- End of about -->
				<div id="displayUser" class="fl mt20 ml20">
					<form method="post" name="form" enctype='multipart/form-data' id="form" action="./save-topic.php">
						<table cellspacing="4" cellpadding="0" border="0">
							<tr>
								<td class="fl ft16 ml10 mt10" style="width: 200px; text-align: left;">
									Text
								</td>
								<td style="width: 500px;">
									<?php
										$r= $db->query("query","SELECT * from avn_resources_detail WHERE topic_id = 42");
										for($i=0;$i<count($r);$i++){
									?>
											$html = <?php echo $r[$i]['text']; ?>
											<div class="fl">
												<?php echo htmlentities($html); ?>
											</div>
									<?php
										}
									?>
								</td>
							</tr>
						</table>					
					</form>
				</div><!-- end of displayUser -->
			</div><!-- end of container -->
		</div><!-- end of wrapper -->
	</div><!-- end of pagecontainer -->
</div><!-- end of page -->
</form>
</body>
</html>
