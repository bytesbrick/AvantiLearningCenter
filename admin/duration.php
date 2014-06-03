<?php
	include_once("./includes/checkLogin.php");
	$cType = $_COOKIE["cUserType"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title> Duration &raquo; Light The Fire  &raquo; Dashboard </title>
<?php
	include_once("./includes/head-meta.php");
	error_reporting(0);
?>
<script type="text/javascript" language="javascript" src="./javascript/formValidate.js"></script>
</head>
<body>
<form method=post>
<div id="page">
	<div id="pageContainer">
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
				<div class="about">Duration &raquo; <a href="add-duration.php">Add Duration</a></div><!-- End of about -->
				<div id="ErrMsg" style="margin:10px 0px 0px 15px !important;">
					<?php
					if($_GET["resp"] == "err")
						echo "<span style=\"color:#00A300;\">Error while adding Lead.</span>";
					else if($_GET["resp"] == "suc")
						echo "Duration successfully added";
					else if($_GET["resp"] == "sucdt")
						echo "Duration successfully deleted";
					else if($_GET["resp"] == "inv")
						echo "Blank fields are not allowed";
					else if($_GET["resp"] == "up")
						echo "Duration edited successfully";
					else if($_GET["resp"] == "invEd")
						echo "This Duration Cant Not Be Save because this is Already exit";
					else if($_GET["resp"] == "invUp")
						echo "This Duration Cant Not Be Updated because this is Already exit";
					else if($_GET["resp"] == "errEd")
						echo "Error while editing leads"; 
					?>
				</div><!-- end of ErrMsg -->
				<div id="displayUser" class="fl mt20 ml20">
					<table cellspacing="1" cellpadding="3" border="0" width="100%" style="background-color:#f5f5f5;">
					<tr style="background-color:#5077BE;color:#ffffff;">
					<td style="height:25px;width:5px;"><b>Sr No.</b></td>
					<td style="height:25px;width:180px;"><b>Duration</b></td >
					<td style="height:25px;width:50px;"><b>Action</b></td></tr>
			<?php
			include_once("./includes/config.php");  
			include("./classes/cor.mysql.class.php");
			$db = new MySqlConnection(CONNSTRING);
			$db->open();

			$r = $db->query("stored procedure","sp_admin_duration_select()");
			if(!array_key_exists("response", $r)){
				if(!$r["response"] == "ERROR"){
						$srno = 0;
						for($i=0; $i< count($r); $i++){
							$srno++;
							if($i % 2 == 0)
										$bg = "#f2f2f2";
									else
										$bg = "#d2d2d2";
			?>
					<tr style="background-color:<?php echo $bg; ?>">
					<td><?php echo $srno; ?></td>
					<td style="height:25px;text-align:left;padding-left:20px;"><?php echo $r[$i]["duration_name"]; ?></td >
					<td style="height:25px;width:100px;"><a href="add-duration.php?cid=<?php echo $r[$i]["unique_id"]; ?>">Edit</a> | <a href="javascript:void(0);" style="color:#f00;" onclick="javascript:_deleteduration(<?php echo $r[$i]['unique_id']?>)">Delete</a></td></tr>
			<?php
				}
					}
						}
				unset($r);
			?>
		</table>
		</div>
			</div><!-- end of container -->
		</div><!-- end of wrapper -->
	</div><!-- end of pagecontainer -->
</div><!-- end of page -->
</form>
</body>
</html>
