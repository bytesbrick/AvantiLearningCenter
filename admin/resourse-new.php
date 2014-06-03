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
						<td style="width:100px;"><b>Topic</b></td >
						<td style="width:100px;"><b>Consumer Type</b></td>
						<td style="width:100px;"><b>Grade Level</b></td>
						<td style="width:100px;"><b>Media Type</b></td>
						<td style="width:100px;"><b>Standard</b></td>
						<td style="width:100px;"><b>Cost</b></td>
						<td style="width:100px;"><b>Duration</b></td>
						<td style="width:50px;"><b>#</b></td>
					</tr>
			<?php
				$r = $db->query("query","select unique_id,resource_title,left(resource_desc,80)as resource_desc,left(how_to_improve,80)as how_to_improve,LEFT(what_to_love,80)as what_to_love,LEFT(where_to_start,80)as where_to_start,external_link,resource_pic from `ltf_resources_master` order by unique_id desc limit ".$limitStart.", ".$limitEnd);
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
					<td style="width:100px !important;text-align:left;">
					<a href="http://<?php echo $r[$i]["external_link"]; ?>" target="new"><?php echo $r[$i]["external_link"]; ?></a></td>
					
					<td style="width:100px !important;text-align:left;">
						<ul class="a ml-30">
						<?php
							$ruid = $r[$i]["unique_id"]; 
							$m = $db->query("query","select b.topic_name as topic_name from ltf_resources_topic a inner join ltf_topic_master b on a.topic_id=b.unique_id where a.resource_id=".$ruid);
							if(!array_key_exists("response", $m)){
								if(!$m["response"] == "ERROR"){
									for($j=0; $j< count($m); $j++){
						?>
										<li class="fl">
											<?php echo $m[$j]["topic_name"]; ?>, 
										</li>
						<?php
								}
							}
						}
						unset($m);
						?>
						</ul>
					</td >
					<td style="width:100px !important;text-align:left;">
						<ul class="a ml-30">
						<?php
							$ruid = $r[$i]["unique_id"]; 
							$m = $db->query("query","select b.consumer_type_name as consumer_type_name from ltf_resources_consumer_type a inner join ltf_consumer_type_master b on a.consumer_type_id=b.unique_id where a.resource_id=".$ruid);
							if(!array_key_exists("response", $m)){
								if(!$m["response"] == "ERROR"){
									for($j=0; $j< count($m); $j++){
						?>
										<li class="fl">
											<?php echo $m[$j]["consumer_type_name"]; ?>, 
										</li>
						<?php
								}
							}
						}
						unset($m);
						?>
						</ul>
					</td >
					<td style="width:100px !important;text-align:left;">
						<ul class="a ml-30">
						<?php
							$ruid = $r[$i]["unique_id"]; 
							$m = $db->query("query","select b.grade_name as grade_name from ltf_resources_grade_level a inner join ltf_grade_level_master b on a.grade_level_id=b.unique_id where a.resource_id=".$ruid);
							if(!array_key_exists("response", $m)){
								if(!$m["response"] == "ERROR"){
									for($j=0; $j< count($m); $j++){
						?>
										<li class="fl">
											<?php echo $m[$j]["grade_name"]; ?>, 
										</li>
						<?php
								}
							}
						}
						unset($m);
						?>
						</ul>
					</td >
					<td style="width:100px !important;text-align:left;">
						<ul class="a ml-30">
						<?php
							$ruid = $r[$i]["unique_id"]; 
							$m = $db->query("query","select b.media_type_name as media_type_name from ltf_resources_media_type a inner join ltf_media_type_master b on a.media_type_id=b.unique_id where a.resource_id=".$ruid);
							if(!array_key_exists("response", $m)){
								if(!$m["response"] == "ERROR"){
									for($j=0; $j< count($m); $j++){
						?>
										<li class="fl">
											<?php echo $m[$j]["media_type_name"]; ?>, 
										</li>
						<?php
								}
							}
						}
						unset($m);
						?>
						</ul>
					</td >
					<td style="width:100px !important;text-align:left;">
						<ul class="a ml-30">
						<?php
							$ruid = $r[$i]["unique_id"]; 
							$m = $db->query("query","select b.standards_desc as standards_desc from ltf_resources_standards a inner join ltf_standards_master b on a.standards_id=b.unique_id where a.resource_id=".$ruid);
							if(!array_key_exists("response", $m)){
								if(!$m["response"] == "ERROR"){
									for($j=0; $j< count($m); $j++){
						?>
										<li class="fl">
											<?php echo $m[$j]["standards_desc"]; ?>, 
										</li>
						<?php
								}
							}
						}
						unset($m);
						?>
						</ul>
					</td >
					<td style="width:100px !important;text-align:left;">
						<ul class="a ml-30">
						<?php
							$ruid = $r[$i]["unique_id"]; 
							$m = $db->query("query","select b.cost as cost from ltf_resources_cost a inner join ltf_cost_master b on a.cost_id=b.unique_id where a.resource_id=".$ruid);
							if(!array_key_exists("response", $m)){
								if(!$m["response"] == "ERROR"){
									for($j=0; $j< count($m); $j++){
						?>
										<li class="fl">
											<?php echo $m[$j]["cost"]; ?>, 
										</li>
						<?php
								}
							}
						}
						unset($m);
						?>
						</ul>
					</td >
					<td style="width:100px !important;text-align:left;">
						<ul class="a ml-30">
						<?php
							$ruid = $r[$i]["unique_id"]; 
							$m = $db->query("query","select b.duration_name as duration_name from ltf_resources_duration a inner join ltf_duration_master b on a.duration_id=b.unique_id where a.resource_id=".$ruid);
							if(!array_key_exists("response", $m)){
								if(!$m["response"] == "ERROR"){
									for($j=0; $j< count($m); $j++){
						?>
										<li class="fl">
											<?php echo $m[$j]["duration_name"]; ?>, 
										</li>
						<?php
								}
							}
						}
						unset($m);
						?>
						</ul>
					</td >
					<td style="height:25px;width:50px;"><a href="edit-resourse.php?cid=<?php echo $r[$i]["unique_id"]; ?>">Edit</a></td></tr>
			
			<?php
				}
					}
						}
			?>
					</table>
					<div class="content">
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
