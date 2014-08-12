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
<title>Avanti &raquo; Dashboard &raquo; Add Batch</title>
<?php
	$pgName = "batch";
	include_once("./includes/head-meta.php");
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
				<div class="about2"><a href="./batch.php" class="clrmaroon fl">Batches &raquo;</a>&nbsp;Add Batch</div><!-- End of about -->
				<div id="displayUser">
					<form method="post" name="form" id="form" action="save-batch.php" onsubmit="javascript:return _validatebatch();">
						<input type="hidden" id="hdIsValidSlug" name="hdIsValidSlug" value="0">
						<input type="hidden" id="hdIsSlugAdd" name="hdIsSlugAdd" value="0">
						<input type="hidden" id="hdIsduplicacyAdd" name="hdIsduplicacyAdd" value="0">
						<table cellspacing="0" cellpadding="0" border="0" width="100%">
							<tr>
								<td colspan="2"><div id="errormsg" style="height: 20px;"></div></td>
							</tr>
							<tr>
								<td class="chaptertext">City</td>
								<td>
									<select id="ddlcity" name="ddlcity" class="dropdown mt10" onchange="javascript: _getcenter(this.value);">
										<option value="0">Select one</option>
									<?php
										if($arrUserInfo["usertype"] == "Manager")
											$selcity = $db->query("query","SELECT cm.* FROM avn_city_master cm  INNER JOIN avn_centermanager_master acm ON acm.city_id = cm.unique_id WHERE acm.unique_id = " . $arrUserInfo["user_ref_id"] . " ORDER BY cm.city_name");
										else
											$selcity = $db->query("query","SELECT * FROM avn_city_master ORDER BY city_name");
										for($i=0; $i<count($selcity); $i++){
									?>
											<option value="<?php echo $selcity[$i]["unique_id"]; ?>"><?php echo $selcity[$i]["city_name"]; ?></option>
									<?php
										}
										unset($selcity);
									?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="chaptertext">Learning Center</td>
								<td>
									<select id="ddlcenter" name="ddlcenter" class="dropdown mt10" onchange="javascript: _createBatchId(this.value);">
										<option value="0">Select one</option>
									</select>
									<div id="loadcenters"></div>
								</td>
							</tr>
							<tr>
								<td class="chaptertext">Curriculum</td>
								<td>
									<select id="ddlcurriculum" name="ddlcurriculum" class="dropdown mt10">
										<option value="0">Select one</option>
									<?php
										$selcur = $db->query("query","SELECT unique_id ,curriculum_name FROM avn_curriculum_master ORDER BY curriculum_name");
										for($i=0; $i<count($selcur); $i++){
									?>
											<option value="<?php echo $selcur[$i]["unique_id"]; ?>"><?php echo $selcur[$i]["curriculum_name"]; ?></option>
									<?php
										}
										unset($selcur); 
									?> 
									</select>
								</td>
							</tr>
							<tr>
								<td class="chaptertext">Batch ID</td>
								<td><input type="text" name="txtbatchid" id="txtbatchid" placeholder="Batch ID" class="inputseacrh  mt10" onblur="javascript: _checkduplicacy('txtbatchid', 'batch_id','avn_batch_master');" />
									<div id="imgslug" class="imgslug"></div>
									<div id="msg" class="chkedmsg"></div><div class="clr"></div>
									<div class="duplicacymsg fl">This will be checked for duplicacy.</div>
								</td>
							</tr>
							<tr>
								<td class="chaptertext">Batch Name</td>
								<td>
									<input type="text" name="txtbatchname" placeholder="Batch Name" id="txtbatchname" class="inputseacrh mt10" />
								</td>
							</tr>
							<tr>
								<td class="chaptertext">Strength</td>     
								<td>
									<input type="text" name="txtstrength"  placeholder="Strength"  id="txtstrength" class="inputseacrh mt10" maxlength="3" onkeypress="javascript: return _allowNumeric(event);" />
								</td>
							</tr>
							<tr>
								<td class="chaptertext">Facilitator</td>
								<td>
									<select id="ddlfacilitator" name="ddlfacilitator" class="dropdown mt10">
										<option vlaue="0">Select one</option>
										<?php
											$selteacher = $db->query("query","SELECT unique_id, fname, lname FROM avn_teacher_master WHERE status = 1 ORDER BY fname ASC, lname ASC");
											if(!array_key_exists("response", $selteacher)){
										?>
											<optgroup label="Teachers">
										<?php
												for($i =0; $i < count($selteacher); $i++){
										?>
												<option value="<?php echo $selteacher[$i]["unique_id"] ;?>"><?php echo $selteacher[$i]["fname"] ;?>&nbsp;<?php echo $selteacher[$i]["lname"] ;?></option>
										<?php
												}
										?>
											</optgroup>
										<?php
											}
											unset($selteacher);
											$selCMS = $db->query("query","SELECT unique_id, fname, lname FROM avn_centermanager_master WHERE status = 1 ORDER BY fname ASC, lname ASC");
											if(!array_key_exists("response", $selCMS)){
										?>
											<optgroup label="Center Managers">
										<?php
												for($i =0; $i < count($selCMS); $i++){
										?>
												<option value="<?php echo $selCMS[$i]["unique_id"] ;?>"><?php echo $selCMS[$i]["fname"] ;?>&nbsp;<?php echo $selCMS[$i]["lname"] ;?></option>
										<?php
												}
										?>
											</optgroup>
										<?php
											}
											unset($selCMS);
										?>
									</select>
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