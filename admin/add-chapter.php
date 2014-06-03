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
<title>Avanti  &raquo; Dashboard &raquo; Add Chapter</title>
<?php
	include_once("./includes/head-meta.php");
	
	if(isset($_GET["currid"]) && $_GET["currid"] != "" && $_GET["currid"] != "0"){
		$currid = $_GET["currid"];
		$where .= $where == "" ? "acm.curriculum_id = " . mysql_escape_string($currid) : " AND acm.curriculum_id = " . mysql_escape_string($currid);
	}
	if(isset($_GET["catgid"]) && $_GET["catgid"] != ""){
		$catgid = $_GET["catgid"];
		$where .= $where == "" ? "acm.category_id = " . mysql_escape_string($catgid) : " AND acm.category_id = " . mysql_escape_string($catgid);
	}
	$sqlCurriculums = "select unique_id, curriculum_name from avn_curriculum_master acm";
	$rsCurriculums = $db->query("query", $sqlCurriculums);
	
	$sqlSubjects = "select unique_id, category_name from ltf_category_master lcm";
	$rsSubjects = $db->query("query", $sqlSubjects);
?>
<script type="text/javascript" language="javascript" src="./javascript/chapter.js"></script>
</head>
<body>
	<div id="page"> 
	<div id="pageContainer">
		<div id="wrapper">	
			<div id="header">
			<?php
				$pgName = "chapters";
				include_once("./includes/header.php");
			?>
			</div><!-- End of header -->
			<div id="container2">
				<div class="about2"><span class="mt2px fl"><a href="./curriculum.php" class="clrmaroon fl">Curriculums</a>&nbsp;&raquo;&nbsp;</span><select class="inputseacrh inputseacrh2" id="ddlCurriculum" onchange="javascript: window.location='./category.php?currid=' + this.value;"><option value=''>All</option><?php for($sb = 0; $sb < count($rsCurriculums); $sb++){ if($rsCurriculums[$sb]["unique_id"] == $currid){echo "<option value='" . $rsCurriculums[$sb]["unique_id"] . "' selected='selected'>" . $rsCurriculums[$sb]["curriculum_name"] . "</option>";} else {echo "<option value='" . $rsCurriculums[$sb]["unique_id"] . "'>" . $rsCurriculums[$sb]["curriculum_name"] . "</option>";}} ?></select><span class="mt2px fl">&nbsp;&raquo;&nbsp;</span><select class="inputseacrh inputseacrh2" onchange="javascript: window.location='./add-chapter.php?currid=' + document.getElementById('ddlCurriculum').value + '&catgid=' + this.value;"><option value=''>All</option><?php for($sb = 0; $sb < count($rsSubjects); $sb++){ if($rsSubjects[$sb]["unique_id"] == $catgid){echo "<option value='" . $rsSubjects[$sb]["unique_id"] . "' selected='selected'>" . $rsSubjects[$sb]["category_name"] . "</option>";} else {echo "<option value='" . $rsSubjects[$sb]["unique_id"] . "'>" . $rsSubjects[$sb]["category_name"] . "</option>";}} ?></select><span class="mt2px fl">&nbsp;&raquo;&nbsp;Add chapter</span></div><!-- End of about -->
				<div id="displayUser">
					<form method="post" name="form2" id="form2" action="./save-chapter.php" enctype='multipart/form-data' onsubmit="return _validatechapter();">
						<input type="hidden" id="hdnqryStringChp" name="hdnqryStringChp" value="<?php echo urlencode(filter_querystring($_SERVER["QUERY_STRING"],array(""), array())); ?>">
						<input type="hidden" id="hdIsValidSlug" name="hdIsValidSlug" value="0">
						<input type="hidden" id="hdCurrID" name="hdCurrID" value="<?php echo $_GET["$currid"]; ?>">
						<input type="hidden" id="hdIsSlugAdd" name="hdIsSlugAdd" value="0">
						<input type="hidden" id="hdslug" name="hdslug" value="">
						<input type="hidden" id="hdIsduplicacyAdd" name="hdIsduplicacyAdd" value="0">
						<table cellspacing="0" cellpadding="0" border="0" width="100%">
							<tr>
								<td colspan="2"><div id="errormsg" style="height: 20px;"></div></td>
							</tr>
							<tr>
								<td class="chaptertext">Subject</td>
								<td>
									<select name="ddlcategory" id="ddlcategory" class="dropdown mt10" onchange="javascript: _getchaptercode(this.value);">
										<option value="0">Select Subject</option>
										<?php
											$cid = $_GET["cid"];
											if($currid > 0){ 
												$r = $db->query("stored procedure","sp_admin_category_by_crid(" . $currid . ")"); 
												if(!array_key_exists("response", $r)){
													if(!$r["response"] == "ERROR"){
														for($i=0; $i< count($r); $i++){
															if($catgid == $r[$i]["unique_id"]){
											?>
																<option value="<?php echo $r[$i]["unique_id"]; ?>" selected="selected"><?php echo $r[$i]["category_name"]; ?></option>
											<?php
															}else{
											?>
																<option value="<?php echo $r[$i]["unique_id"]; ?>"><?php echo $r[$i]["category_name"]; ?></option>
											<?php
															}
														}
													}
												}
												unset($r);
											}
										?> 
									</select>
								</td>
							</tr>
							<tr>
								<td class="chaptertext">Chapter Code</td>
								<td>
									<!--<div style="float: left;height: 40px;">-->
										<!--<span class="fl ft16" id="chaptercode" name="chaptercode" value="" style="padding-top: 7px;"></span>-->
										<?php
											$Chp = "SELECT MAX(cm.unique_id) as maxchp, lcm.prefix FROM avn_chapter_master cm INNER JOIN ltf_category_master lcm ON lcm.unique_id = cm.category_id WHERE cm.category_id = " . $_GET["catgid"];
											$rsChp = $db->query("query",$Chp);
											//print_r($rsChp);
											if(!array_key_exists("response", $rsChp))
												$maxCount = $rsChp[0]["prefix"].($rsChp[0]["maxchp"] + 1);
											if(isset($_GET["currid"]) && $_GET["currid"] != ""){
										?>
												<input type="text" name="chaptercode" id="chaptercode" placeholder="Code" value="<?php echo $maxCount; ?>" class="inputseacrh mt10" onblur="javascript:  _checkduplicacy('chaptercode','chapter_code','avn_chapter_master');" />
										<?php
											}else{
										?>
												<input type="text" name="chaptercode" id="chaptercode" placeholder="Code"  class="inputseacrh mt10" onblur="javascript:  _checkduplicacy('chaptercode','chapter_code','avn_chapter_master');" />
										<?php
											}
											unset($rsChp);
										?>
										<!--<input type="text" name="chaptercode" id="chaptercode" placeholder="Code" class="inputseacrh mt10" onblur="javascript:  _checkduplicacy('chaptercode','chapter_code','avn_chapter_master');" />-->
										<div id="imgchk" class="imgslug"></div>
										<div id="msgchk" class="chkedmsg"></div>
									<!--</div>-->
									<input type="hidden" name="txtChaptercode" id="txtChaptercode" />
									<div id="getchpcode"></div>
								</td>
							</tr>
							<tr>
								<td class="chaptertext">Chapter Title</td>
								<td><input type="text" name="txtchapter" id="txtchapter" placeholder="Title" class="inputseacrh mt15" onblur="javascript: if(this.value != ''){_createSlug(this.value, 'hdslug', 'chapter_slug','avn_chapter_master');}" /></td>
							</tr>
							<!--<tr>
								<td class="chaptertext">Chapter Slug</td>
								<td>
									<input type="text" name="txtchapterslug" id="txtchapterslug" placeholder="Slug" class="inputseacrh mt10" onblur="javascript: _checkslug('txtchapterslug', 'chapter_slug','avn_chapter_master');" />
									<div id="imgslug" class="imgslug"></div>
									<div id="msg" class="chkedmsg"></div><div class="clr"></div>
									<div class="duplicacymsg">This will be checked for duplicacy.</div>
								</td>
							</tr>-->
							<tr>
								<td class="chaptertext">Chapter Description</td>
								<td><textarea rows="2" cols="25" name="txtchapterdescription" placeholder="Description" id="txtchapterdescription" class="inputseacrh mt10" /></textarea></td>
							</tr>
							<tr>
								<td class="chaptertext">Chapter Image</td>
								<td><input type="file" name="txtchapterimage" id="txtchapterimage" class="mt10" /></td>
							</tr>
							<tr>
								<td colspan="2">
									<div class="fl mt20">
										<input type="submit" name="btnSave" id="btnSave" class="btnSIgn" value="Save">
										<span><a href="./chapter.php"><input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn" /></a></span>
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
	unset($r);
	$db->close();
?>
</body>
</html>