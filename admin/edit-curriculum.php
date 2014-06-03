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
<title>Avanti &raquo; Dashboard &raquo; Edit Curriculum</title>
<?php
	include_once("./includes/head-meta.php");	
?>
</head>
<body>
 <?php
if(isset($_GET["cid"]))
{
	$db->open();
	$cid = $_GET["cid"];
	$curPage = $_GET["page"];
	//$r = $db->query("stored procedure","avn_curriculum_select_edit('".$_GET["cid"]."')");
	$r = $db->query("query","SELECT * FROM avn_curriculum_master WHERE unique_id = " . $_GET["cid"]);
	//print_r($r);
	if(!array_key_exists("response", $r))
		{
		if(!$r["response"] == "ERROR")
			{
?>
<div id="page">
	<div id="pageContainer">
		<div id="wrapper">	
			<div id="header">
			<?php
				$pgName = "curriculums";
				include_once("./includes/header.php");
			?>
			</div><!-- End of header -->
			<div id="container2">
				<div class="about2"><a href="./curriculum.php" class="clrmaroon fl">Curriculums &raquo;</a>&nbsp;Edit Curriculum</div><!-- End of about -->
				<div id="displayUser">
					<form method="post" name="form" id="form" action="update-curriculum.php" onsubmit="javascript:return _validateCurriculum();">
						<input type="hidden" id="hdCurrID" name="hdCurrID" value="<?php echo $_GET["cid"]; ?>">
						<input type="hidden" id="hdIsValidSlug" name="hdIsValidSlug" value="0">
						<input type="hidden" id="hdCurrentSlug" name="hdCurrentSlug" value="<?php echo $r[0]["curriculum_slug"];?>">
						<input type="hidden" id="hdCurrentdulicacy" name="hdCurrentdulicacy" value="<?php echo $r[0]["curriculum_id"];?>">
						<table cellspacing="0" cellpadding="0" border="0" width="100%">
							<tr>
								<td colspan="2"><div id="errormsg" style="height: 20px;"></div></td>
							</tr>
							<tr>
								<td class="chaptertext">Curriculum</td>
								<td>
									<input type="text" name="txtcurriculum" id="txtcurriculum" class="inputseacrh" value="<?php echo $r[0]["curriculum_name"]; ?>" onblur="javascript: _createSlug(this.value, 'txtcurriculumslug', 'curriculum_slug','avn_curriculum_master');" />
								</td>
							</tr>
							<tr>
								<td class="chaptertext">Curriculum ID</td>
								<td>
									<input type="text" name="txtcurriculumID" id="txtcurriculumID" class="inputseacrh mt10" value="<?php echo $r[0]["curriculum_id"]; ?>"/>
								</td>
							</tr>
							<tr>
								<td class="chaptertext">Academic year</td>
								<td>
									<select id="ddlcurrentyear" name="ddlcurrentyear" class="dropdown mt10" style="width: 156px;">
										<option>Select year</option>
										<?php
											$now = date('Y') - 1;
											$future = date('Y') + 4;
											for($i= $now;$i < $future; $i++){
												if($i == $r[0]["current_year"]){
										?>
													<option value="<?php echo $i; ?>"selected><?php echo $i; ?></option>
										<?php
												}else{
										?>
													<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
										<?php
												}
											}
										?>
									</select>
									<select id="ddlnextyear" name="ddlnextyear" class="dropdown mt10 ml10"  style="width: 156px;">
										<option>Select year</option>
										<?php
											$now = date('Y') - 1;
											$future = date('Y') + 4;
											for($i= $now;$i < $future; $i++){
												if($i == $r[0]["next_year"]){
										?>
													<option value="<?php echo $i; ?>"selected><?php echo $i; ?></option>
										<?php
												}else{
										?>
													<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
										<?php
												}
											}
										?>
									</select>
								</td>
							</tr>
							<!--<tr>
								<td class="chaptertext">Curriculum Slug</td>
								<td><input type="text" name="txtcurriculumslug" id="txtcurriculumslug" value="<?php echo $r[0]["curriculum_slug"]; ?>"class="inputseacrh  mt10" onblur="javascript: _checkslug('txtcurriculumslug','curriculum_slug','avn_curriculum_master');" />
									<div id="imgslug" class="imgslug"></div>
									<div id="msg" class="chkedmsg"></div><div class="clr"></div>
									<div class="duplicacymsg fl">This will be checked for duplicacy.</div>
								</td>
							</tr>-->
							<tr>
								<td class="chaptertext">Class</td>
								<td>
									<input type="text" name="txtclass" id="txtclass" class="inputseacrh mt10" maxlength="4" value="<?php echo $r[0]["class"]; ?>" />
								</td>
							</tr> 
							<tr>
								<td colspan="2">
									<div class="fl mt20">
										<input type="submit" name="btnUpdate" id="btnUpdate" class="btnSIgn" value="Update">
										<span><a href="./curriculum.php"><input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn" /></a></span>
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
<?php
			}
		}
	}
	unset($r);
	$db->close();
?>
</body>
</html>