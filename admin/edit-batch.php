<?php
	error_reporting(0);
	include("./includes/config.php");		
	include("./classes/cor.mysql.class.php");
	include("./includes/checkLogin.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title> Avanti  &raquo; Dashboard &raquo; Edit Batch</title>
<?php
	$pgName = "batch";
	include_once("./includes/head-meta.php");
	$r = $db->query("query","SELECT abm.*,acm.city_name,alcm.center_name FROM avn_batch_master abm INNER JOIN avn_city_master acm ON acm.unique_id = abm.city_id INNER JOIN avn_learningcenter_master alcm ON alcm.city_id = acm.unique_id WHERE abm.unique_id = " . $_GET["cid"]);
?>
</head>
<body>
<div id="page">
	<div id="pageContainer">
		<div id="wrapper">	
			<div id="header">
			<?php
				include_once("./includes/header.php");
			?>
			</div><!-- End of header -->
			<div id="container2">
				<div class="about2"><a href="./batch.php" class="clrmaroon fl">Batches &raquo;</a>&nbsp;Edit Batch</div><!-- End of about -->
				<div id="displayUser">
					<form method="post" name="form" id="form" action="update-batch.php" onsubmit="javascript:return _validatebatch();">
						<input type="hidden" id="hdIsValidSlug" name="hdIsValidSlug" value="0">
						<input type="hidden" id="hdnbatchid" name="hdnbatchid" value="<?php echo $_GET["cid"];?>">
						<input type="hidden" id="hdCurrentSlug" name="hdCurrentSlug" value="">
						<input type="hidden" id="hdCurrentdulicacy" name="hdCurrentdulicacy" value="<?php echo $r[0]["batch_id"];?>">
						<table cellspacing="0" cellpadding="0" border="0" width="100%">
							<tr>
								<td colspan="2"><div id="errormsg" style="height: 20px;"></div></td>
							</tr>
							<tr>
								<td class="chaptertext">City</td>
								<td>
									<select id="ddlcity" name="ddlcity" class="dropdown mt10" onchange="javascript: _getcenter(this.value);">
									<?php
										$selcity = $db->query("query","SELECT * FROM avn_city_master");
										for($i=0; $i<count($selcity); $i++){
											if($r[0]["city_id"] == $selcity[$i]["unique_id"]){
									?>
												<option value="<?php echo $selcity[$i]["unique_id"]; ?>" selected><?php echo $selcity[$i]["city_name"]; ?></option>
									<?php
											}
											else{
									?>
											<option value="<?php echo $selcity[$i]["unique_id"]; ?>"><?php echo $selcity[$i]["city_name"]; ?></option>	
									<?php
											}
										}
										unset($selcity);
									?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="chaptertext">Learning Center</td>
								<td>
									<select id="ddlcenter" name="ddlcenter" class="dropdown mt10">
									<?php
										$selcenter = $db->query("query","SELECT * FROM avn_learningcenter_master");
										for($i=0; $i<count($selcenter); $i++){
											if($r[0]["learning_center"] == $selcenter[$i]["unique_id"]){
									?>
												<option value="<?php echo $selcenter[$i]["unique_id"]; ?>" selected><?php echo $selcenter[$i]["center_name"]; ?></option>
									<?php
											}
										}
									?>
									</select>
									<div id="loadcenters"></div>
								</td>
							</tr>
							<tr>
								<td class="chaptertext">Curriculum</td>
								<td>
									<select id="ddlcurriculum" name="ddlcurriculum" class="dropdown mt10">
									<?php
										$selcur = $db->query("query","SELECT unique_id ,curriculum_name FROM avn_curriculum_master ORDER BY curriculum_name");
										for($i=0; $i<count($selcur); $i++){
											if($r[0]["curriculum_id"] == $selcur[$i]["unique_id"]){
									?>
											<option value="<?php echo $selcur[$i]["unique_id"]; ?>"selected><?php echo $selcur[$i]["curriculum_name"]; ?></option>
									<?php
											}
										else{
									?>
											<option value="<?php echo $selcur[$i]["unique_id"]; ?>"><?php echo $selcur[$i]["curriculum_name"]; ?></option>
									<?php
											}
										}
										unset($selcur);
									?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="chaptertext">Batch ID</td>
								<td><input type="text" name="txtbatchid" id="txtbatchid" class="inputseacrh  mt10" onblur="javascript: _checkduplicacy('txtbatchid', 'batch_id','avn_batch_master');" value="<?php echo $r[0]["batch_id"]; ?>" />
									<div id="imgchk" class="imgslug"></div>
									<div id="msgchk" class="chkedmsg"></div><div class="clr"></div>
									<div class="duplicacymsg fl">This will be checked for duplicacy.</div>
								</td>
							</tr>
							<tr>
								<td class="chaptertext">Batch Name</td>
								<td>
									<input type="text" name="txtbatchname" id="txtbatchname" class="inputseacrh mt10" value="<?php echo $r[0]["batch_name"]; ?>"/>
								</td>
							</tr>
							<tr>
								<td class="chaptertext">Strength</td>
								<td>
									<input type="text" name="txtstrength" id="txtstrength" class="inputseacrh mt10" value="<?php echo $r[0]["strength"]; ?>"  maxlength="3" onkeypress="javascript: return _allowNumeric(event);" />
								</td>
							</tr>
							<tr>
								<td class="chaptertext">Facilitator</td>
								<td>
									<select id="ddlfacilitator" name="ddlfacilitator" class="dropdown mt10">
										<option vlaue="0">Select one</option>
										<optgroup label="Teachers">
										<?php
											$selteacher = $db->query("query","SELECT unique_id,CONCAT(fname, ' ',lname) as teachername  FROM avn_teacher_master WHERE status = 1 ORDER BY fname asc");
											for($i =0; $i < count($selteacher); $i++){
												if($selteacher[$i]["unique_id"] == $r[0]["facilitator_id"]){
										?>
												<option value="<?php echo $selteacher[$i]["unique_id"] ;?>"selected><?php echo $selteacher[$i]["teachername"] ;?></option>
										<?php
											}else{
										?>
												<option value="<?php echo $selteacher[$i]["unique_id"] ;?>"><?php echo $selteacher[$i]["teachername"] ;?></option>	
										<?php
												}
											}
											unset($selteacher);
										?>
										</optgroup>
										<optgroup label="Center Managers">
											<?php
												$selCMS = $db->query("query","SELECT unique_id,CONCAT(fname, ' ',lname) as manager_name FROM avn_centermanager_master WHERE status = 1 ORDER BY fname asc");
												for($i =0; $i < count($selCMS); $i++){
													if($selCMS[$i]["unique_id"] == $r[0]["facilitator_id"]){
											?>
													<option value="<?php echo $selCMS[$i]["unique_id"] ;?>" selected><?php echo $selCMS[$i]["manager_name"] ;?></option>
											<?php
													}else{
											?>
														<option value="<?php echo $selCMS[$i]["unique_id"] ;?>"><?php echo $selCMS[$i]["manager_name"] ;?></option>
											<?php
													}
												}
												unset($selCMS);
											?>
										</optgroup>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<div class="fl mt20">
										<input type="submit" name="btnSave" id="btnSave" class="btnSIgn mt10" value="Save">
										<span><a href="./add-city.php"><input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn mt10" /></a></span>
									</div>
								</td>
							</tr>
						</table>
					</form>
				</div><!--end of displayUser-->	
			</div><!-- end of container -->
			<?php
				include_once("./includes/sidebar.php");
			?>
		</div><!-- end of wrapper -->
	</div><!-- end of pagecontainer -->
</div><!-- end of page -->
</body>
</html>