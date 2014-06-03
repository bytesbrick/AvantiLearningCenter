<?php
	error_reporting(0);
	session_start();
	include_once("./includes/checkLogin.php");
	$cType = $_COOKIE["cUserType"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title>Avanti &raquo; Dashboard &raquo; Tests</title>
<?php
	include_once("./includes/head-meta.php");
?>
<script type="text/javascript" language="javascript" src="./javascript/formValidate.js"></script>
</head>
<body>
<div id="page">
	<div id="pageContainer">
		<div id="wrapper">	
			<div id="header">
			<?php
				$pgName = "topics";
				include_once("./includes/header.php");
				include_once("./includes/config.php");  
				include("./classes/cor.mysql.class.php");
				$db = new MySqlConnection(CONNSTRING);
				$db->open();
				$curPage = $_GET["page"];
				if(($curPage == "") || ($curPage == 0))
				$curPage=1;
				$recPerpage = 15;
				$countWhereClause = "";
				$selectWhereClause = "";
				$pageParam="";
				$sqlCount = $db->query("query","select count(unique_id) as 'total' from avn_question_master WHERE resource_id = " . $_GET["cid"]);
				$recCount = $sqlCount[0]['total'];
				$noOfpage = ceil($recCount/$recPerpage);
				$limitStart = ($curPage - 1) * $recPerpage;
				$limitEnd = $recPerpage;
				
				$gettopic = $db->query("query","SELECT tm.topic_name,tm.unique_id,rm.topic_id from avn_topic_master tm inner join ltf_resources_master rm on rm.topic_id = tm.unique_id WHERE rm.unique_id = " . $_GET['cid']);
			?>
			</div><!-- End of header -->
			<div id="container2">
				<div class="about2"><div id="listtab"><a href="./topic.php">Topics&nbsp;</a></div>&raquo; <span class="ft20"><a href="./resourse.php?cid=<?php echo $gettopic[0]['topic_id']; ?>"><?php echo $gettopic[0]['topic_name']; ?></a> </span>&raquo; Questions <span id="add"><a href="./add-spot-test.php?cid=<?php echo $_GET['cid']; ?>">Add Question</a></span></div><!-- End of about -->
				<?php if(isset($_GET["resp"]) && $_GET["resp"] !="")
				{
				?>
					<div id="ErrMsg" style="display: block;">
						<?php
						if($_GET["resp"] == "err")
							echo "<span style=\"color:#00A300;\">Error while adding Lead.</span>";
						else if($_GET["resp"] == "suc")
							echo "Question successfully added";
						else if($_GET["resp"] == "Errdlt")
							echo "Question is not deleted successfully";
						else if($_GET["resp"] == "sucdt")
							echo "Question successfully deleted";
						else if($_GET["resp"] == "up")
							echo "Question edited successfully";
						else if($_GET["resp"] == "invEd")
							echo "This Question Could not Not Be Saved";
						else if($_GET["resp"] == "invUp")
							echo "This Question Cant Not Be Updated because this is Already exit";
						else if($_GET["resp"] == "errEd")
							echo "Error while editing leads"; 
						?>
					</div>
				<?php
				}
				?><!-- end of ErrMsg -->
				<div id="displayUser" class="fl">
					<table cellspacing="1" width="100%" cellpadding="3" border="0" style="background-color:#f5f5f5;">
						<input type="hidden" name="hdnresid" id="hdnresid" value="<?php echo $_GET['cid']; ?>">
						<tr style="background-color:#a74242;color:#ffffff;">
							<td style="height:25px;width:5px;"><b>Sr No.</b></td>
							<td style="height:25px;width:80px;"><b>Test Title</b></td>
							<td style="width:100px;"><b>Question</b></td>
							<td style="width:50px;"><b>Status</b></td>
							<td style="width:100px;"><b>Priority</b></td>
							<td style="width:50px;"><b>Action</b></td>
						</tr>
					<?php
						$r = $db->query("query","SELECT * FROM avn_question_master WHERE resource_id = " . $_GET['cid'] . " order by priority ASC");
						
						if(!array_key_exists("response", $r))
						{
							if(!$r["response"] == "ERROR")
							{
								$srno = $limitStart;
								for($i=0; $i< count($r); $i++)
								{
									$srno++;
									if($i % 2 == 0)
										$class = "lightyellow";
									else
										$class = "darkyellow";
					?>
					<tr class="<?php echo $class; ?>">
						<td><?php echo $srno; ?></td>
						<?php
							if($r[$i]["type"] == 1){
						?>
								<td style="height:25px;text-align:left;"><?php echo "Spot Test" ?></td>
						<?php
							}else{
						?>
								<td style="height:25px;text-align:left;"><?php echo "Concept Test" ?></td>
						<?php
							}
						?>
						
						<td style="height:25px;text-align:left;"><?php echo $r[$i]["question_name"]; ?></td>
						<?php
							if($r[$i]["status"]==1){
								
						?>
								<td style="width:100px !important;text-align:left;"><?php echo "Active"; ?></td>
						<?php
							}else{
						?>
								<td style="width:100px !important;text-align:left;"><?php echo "Inactive"; ?></td>
						<?php
								
							}
						?>
						<td style="height:25px;text-align:left;"><?php echo $r[$i]["priority"]; ?></td>
						<td style="height:25px;width:100px;">
						<div class="fl">
								<div class="fr mt5">
										<span id="linkedit"><a href="edit-spot-test.php?qid=<?php echo $r[$i]["unique_id"]; ?>">Edit</a></span>&nbsp;| <a href="javascript:void(0);" style="color:#f00;margin:0px 5px 0px 0px;" onclick="javascript:_deletequestion(<?php echo $r[$i]['unique_id']?>,<?php echo $_GET['cid']; ?>)">Delete</a>
									<?php
										$totlares = $db->query("query","SELECT COUNT(unique_id) as total FROM avn_question_master");
										
										$rd = $db->query("query","SELECT MAX(priority) as maxp,MIN(priority) as minp FROM avn_question_master WHERE resource_id = ". $_GET['cid']);
										
										if($rd[0]['minp'] == $r[$i]['priority'])
										{
									?>
											<a href="javascript:void(0);" style="display: none;">
												<img src="./images/showmore-up.png" id="up" name="up" class="noborder" onclick="javascript: _setqnspriority(<?php echo $r[$i]['unique_id']?>,this.id);" class="fl" style="width: 14px;" />
											</a>
									<?php
										}else{
									?>
											<a href="javascript:void(0);">
												<img src="./images/showmore-up.png" id="up" name="up" class="noborder" onclick="javascript: _setqnspriority(<?php echo $r[$i]['unique_id']?>,this.id);"  class="fl" style="width: 14px;" />
											</a>
									<?php
										}
										if($rd[0]['maxp'] == $r[$i]['priority']){
									?>
											<a href="javascript:void(0);" style="display: none;">
												<img src="./images/showmore.png" id="down" name="down" class="noborder" onclick="javascript: _setqnspriority(<?php echo $r[$i]['unique_id']?>,this.id);" class="fl" style="width: 14px;" />
									 		</a>
									<?php
										}
										else
										{
									?>
											<a href="javascript:void(0);">
												<img src="./images/showmore.png" id="down" name="down" class="noborder" onclick="javascript: _setqnspriority(<?php echo $r[$i]['unique_id']?>,this.id);" class="fl" style="width: 14px;" />
											</a>
									<?php
										}
									?>
								</div>
							</div>
						</td>
					</tr>
					<?php
								}
							}
						}
					?>		
					<tr>
						<td colspan="7">
							<div class="content">
								<div class="results"></div>
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
						</td>
					</tr>
					</table>
				</div><!-- end of displayUser -->
			</div><!-- end of container -->
			<?php
				include_once("./includes/sidebar.php");
				$db->close();
			?>
		</div><!-- end of wrapper -->
	</div><!-- end of pagecontainer -->
</div><!-- end of page -->
</body>
</html>
<?php
	session_destroy();
?>