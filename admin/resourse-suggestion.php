<?php
	include_once("./includes/checkLogin.php");
	$cType = $_COOKIE["cUserType"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title> Resource Suggestion &raquo; Light The Fire  &raquo; Dashboard </title>
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
				$sqlCount = $db->query("query","select count(unique_id) as 'total' from ltf_suggest_resource");
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
				<div class="about">Resource Suggestion</div><!-- End of about -->
				<div id="ErrMsg" style="margin:10px 0px 0px 15px !important;">
				</div><!-- end of ErrMsg -->
				<div id="displayUser" class="fl mt20 ml20">
					<table cellspacing="1" width="100%" cellpadding="4" border="0" style="background-color:#f5f5f5;">
					<tr style="background-color:#5077BE;color:#ffffff;">
						<td><b>Sr No.</b></td>
						<td><b>Name</b></td>
						<td><b>E-mail</b></td>
						<td><b>Contact No</b></td>
						<td><b>Query</b></td>
						<td><b>Date</b></td>
					</tr>
			<?php
				$r = $db->query("query","select unique_id,user_name,email_id,mobile_no,query,DATE_FORMAT(entry_date, '%d-%b-%Y') as entry_date from ltf_suggest_resource order by unique_id desc limit ".$limitStart.", ".$limitEnd);
					if(!array_key_exists("response", $r))
						{
						if(!$r["response"] == "ERROR")
							{
							$srno = $limitStart;
							for($i=0; $i< count($r); $i++)
								{
									$srno++;
									if($i % 2 == 0)
										$bg = "#f2f2f2";
									else
										$bg = "#d2d2d2";
			?>
					<tr style="background-color:<?php echo $bg; ?>">
					<td><?php echo $srno; ?></td>
					<td style="height:25px;text-align:center;"><?php echo $r[$i]["user_name"]; ?></td >
					<td style="width:100px !important;text-align:left;"><?php echo $r[$i]["email_id"]; ?></td >
					<td style="width:100px !important;text-align:center;"><?php echo $r[$i]["mobile_no"]; ?></td >
					<td style="width:100px !important;text-align:left;"><?php echo $r[$i]["query"]; ?></td >
					<td style="width:100px !important;text-align:center;"><?php echo $r[$i]["entry_date"]; ?></td >
					</tr>
			<?php
				}
					}
						}
			?>		
					<tr>
						<td colspan="7">
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
										$nav .=    " <a href=\"resourse-suggestion.php?page=" . $i .$pageParam . "\" class=\"paging\">$i</a>";
								}
								if($curPage > 5)
								{
									$page = $start - 5;
									$prev = " <a href=\"resourse-suggestion.php?page=" . $page . $pageParam  ."\" class=\"paging\">&lt;&lt;&nbsp;Previous</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
								}
								if($noOfpage > 5 && $end <= $noOfpage)
								{
									$page = $start + 5;
									$next = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"resourse-suggestion.php?page=" . $page . $pageParam . "\" class=\"paging\">Next&nbsp;&gt;&gt;</a> ";
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
		</div><!-- end of wrapper -->
	</div><!-- end of pagecontainer -->
</div><!-- end of page -->
</form>
</body>
</html>
