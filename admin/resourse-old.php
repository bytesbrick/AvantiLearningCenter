<?php
	include_once("./includes/checkLogin.php");
	$cType = $_COOKIE["cUserType"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title> Resourse &raquo; Light The Fire  &raquo; Dashboard </title>
<?php
	include_once("./includes/head-meta.php");
	error_reporting(0);
?>
</head>
<body>
<form method=post>
<div id="page">
	<div id="pageContainer">
		<div id="wrapper">	
			<div id="header">
			<?php
				include_once("./includes/header.php");
				include_once("./includes/config.php");  
				include("./classes/cor.mysql.class.php");
				$db = new MySqlConnection(CONNSTRING);
				$db->open();
				$curPage = $_GET["page"];
				if(($curPage == "") || ($curPage == 0))
					$curPage=1;
				$recPerpage = 10;
				$countWhereClause = "";
				$selectWhereClause = "";
				$pageParam="";
				$sqlCount = $db->query("query","select count(unique_id) as 'total' from ltf_resources_master");
				$recCount = $sqlCount[0]['total'];
				$noOfpage = ceil($recCount/$recPerpage);
				$limitStart = ($curPage - 1) * $recPerpage;
				$limitEnd = $recPerpage;
			?>
			</div><!-- End of header -->
			<div id="container">
				<?php
					include_once("./includes/right-menu.php");
				?>
				<div class="about">Resourse &raquo; <a href="add-resourse.php">Add Resourse</a></div><!-- End of about -->
				<div id="ErrMsg" style="margin:10px 0px 0px 15px !important;">
					<?php
					if($_GET["resp"] == "err")
						echo "<span style=\"color:#00A300;\">Error while adding Lead.</span>";
					else if($_GET["resp"] == "suc")
						echo "Resourse successfully added";
					else if($_GET["resp"] == "inv")
						echo "Blank fields are not allowed";
					else if($_GET["resp"] == "up")
						echo "Resourse edited successfully";
					else if($_GET["resp"] == "invEd")
						echo "This Resourse Cant Not Be Save because this is Already exit";
					else if($_GET["resp"] == "invUp")
						echo "This Resourse Cant Not Be Updated because this is Already exit";
					else if($_GET["resp"] == "errEd")
						echo "Error while editing leads"; 
					?>
				</div><!-- end of ErrMsg -->
				<div id="displayUser" class="fl mt20 ml20">
					<table cellspacing="0" cellpadding="0" border="1">
					<tr>
						<td style="height:25px;width:80px;"><b>Title</b></td>
						<td style="width:100px;"><b>Desription</b></td>
						<td style="width:100px;"><b>what To Love</b></td>
						<td style="width:100px;"><b>How To Improve</b></td>
						<td style="width:100px;"><b>Where To Start</b></td>
						<td style="width:100px;"><b>External Link</b></td>
						<td style="width:50px;"><b>#</b></td>
					</tr>
			<?php
				$r = $db->query("query","select unique_id,resource_title,left(resource_desc,80)as resource_desc,left(how_to_improve,80)as how_to_improve,LEFT(what_to_love,80)as what_to_love, where_to_start,external_link,resource_pic from `ltf_resources_master` order by unique_id desc limit ".$limitStart.", ".$limitEnd);
					if(!array_key_exists("response", $r))
						{
						if(!$r["response"] == "ERROR")
							{
							for($i=0; $i< count($r); $i++)
								{
			?>
					<tr><td style="height:25px;text-align:left;padding-left:5px;"><?php echo $r[$i]["resource_title"]; ?></td >
					<td style="height:25px;text-align:left;padding-left:5px;"><?php echo $r[$i]["resource_desc"]; ?></td >
					<td style="height:25px;text-align:left;padding-left:5px;"><?php echo $r[$i]["what_to_love"]; ?></td >
					<td style="height:25px;text-align:left;padding-left:5px;"><?php echo $r[$i]["how_to_improve"]; ?></td >
					<td style="height:25px;text-align:left;padding-left:5px;"><?php echo $r[$i]["where_to_start"]; ?></td >
					<td style="width:100px !important;text-align:left;"><a href="<?php echo $r[$i]["external_link"]; ?>" target="new"><?php echo $r[$i]["external_link"]; ?></a></td >
					<td style="height:25px;width:50px;"><a href="edit-resourse.php?cid=<?php echo $r[$i]["unique_id"]; ?>">Edit</a></td></tr>
			
			<?php
				}
					}
						}
				//unset($r);
			?>
			
					</table>
					<div class="content">
                            <div class="results">
                            </div>
							<?php
								$start = floor(($curPage - 1)/5)*5;
								$start++;
								$end = $start + 5;
								if($end > $noOfpage)
								$end = $noOfpage + 1;
								for($i = $start; $i < $end; $i++)
								{
									if($i == $curPage)
										$nav .= "<a href=\"javascript: void(0);\" class=\"currentPage\"> $i</a>";
									else
										$nav .=    " <a href=\"resourse.php?page=" . $i .$pageParam . "\" class=\"paging\">$i</a>";
								}
								if($curPage > 5)
								{
									$page = $start - 5;
									$prev = " <a href=\"resourse.php?page=" . $page . $pageParam  ."\" class=\"paging\">&lt;&lt;&nbsp;Previous</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
								}
								if($noOfpage > 5 && $end <= $noOfpage)
								{
									$page = $start + 5;
									$next = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"resourse.php?page=" . $page . $pageParam . "\" class=\"paging\">Next&nbsp;&gt;&gt;</a> ";
								}
							?>
								<table cellpadding="5" cellspacing= "0" border ="0" style="border-collapse:collapse; text-align:left; margin-top:15px;"  width='500px' align='center'>
									<tr>
										<input type="hidden" id="pageNo" name="pageNo" value="<?php echo $curPage; ?>" />
										<td align="left"><?php echo $prev . $nav . $next;?></td>
									</tr>
								</table>
							<div class="bluebtmbdr"></div>
                        </div><!-- end of content -->
				</div><!-- end of displayUser -->
			</div><!-- end of container -->
		</div><!-- end of wrapper -->
	</div><!-- end of pagecontainer -->
</div><!-- end of page -->
</form>
</body>
</html>
