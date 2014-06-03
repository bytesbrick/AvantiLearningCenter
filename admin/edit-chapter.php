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
<title>Avanti &raquo; Dashboard &raquo; Edit Chapter</title>
<?php
	include_once("./includes/head-meta.php");
?>
</head>
<body>
 <?php
 $chptid = $_GET["chptid"];
  $curPage = $_GET["page"];
if(isset($chptid))
{ 
	//$r = $db->query("stored procedure","sp_avn_chapterselect_edit('" . $chptid . "')");
	$chpedit = "select a.unique_id as uid,a.chapter_name,a.chapter_desc,a.category_id,a.chapter_slug,b.category_name,a.chapter_image,a.chapter_code from avn_chapter_master a
 INNER JOIN ltf_category_master b on a.category_id = b.unique_id where a.unique_id = " . $chptid;
	$r = $db->query("query", $chpedit);
	if(!array_key_exists("response", $r))
		{
		if(!$r["response"] == "ERROR")
			{
			for($i=0; $i< count($r); $i++)
				{
?>
<div id="page">
	<div id="pageContainer">
		<div id="wrapper">	
			<div id="header">
			<?php
				$pgName = "chapters";
				include_once("./includes/header.php");
				if(isset($_GET["catgid"]) && $_GET["catgid"] != ""){
					$catgid = $_GET["catgid"];
				}
				if(isset($_GET["chptid"]) && $_GET["chptid"] != ""){
					$chptid = $_GET["chptid"];
				}
				if(isset($_GET["currid"]) && $_GET["currid"] != "" && $_GET["currid"] != "0"){
					$currid = $_GET["currid"];
					$where .= $where == "" ? "acm.curriculum_id = " . mysql_escape_string($currid) : " AND acm.curriculum_id = " . mysql_escape_string($currid);
				}
				$sqlCurriculums = "select unique_id, curriculum_name from avn_curriculum_master acm";
				$rsCurriculums = $db->query("query", $sqlCurriculums);
				
				$sqlSubjects = "select unique_id, category_name from ltf_category_master lcm";
				$rsSubjects = $db->query("query", $sqlSubjects);
			
				$sqlChapters = "select unique_id, chapter_name from avn_chapter_master chm WHERE category_id = " . $catgid;
				$rsChapters = $db->query("query", $sqlChapters);
			?>
			</div><!-- End of header -->
			<div id="container2">
				<?php
					$isNext = false;
					$isPrev = false;
					$SelNextResource = "SELECT acm.unique_id FROM avn_chapter_master acm INNER JOIN ltf_category_master lcm ON acm.category_id = lcm.unique_id WHERE acm.unique_id > " . $_GET["chptid"] . " AND acm.category_id = " . $_GET["catgid"] . "  ORDER BY acm.unique_id ASC";
					$SelNextResourceRS = $db->query("query", $SelNextResource);
					if(!array_key_exists("response", $SelNextResourceRS))
						$nextResource = $SelNextResourceRS[0]["unique_id"];
						$isNext = true;
						if($isNext == true && $nextResource != ""){
				?>
					<span class="fr mr20" style="margin: 10px;"><a href="./edit-chapter.php?currid=<?php echo $currid; ?>&catgid=<?php echo $catgid; ?>&chptid=<?php echo $nextResource; ?>&page=<?php echo $curPage; ?>" class="nexttext">Next &raquo;</a></span>
				<?php
					}
					unset($SelNextResourceRS);
					$SelPreviousResource = "SELECT acm.unique_id FROM avn_chapter_master acm INNER JOIN ltf_category_master lcm ON acm.category_id = lcm.unique_id WHERE acm.unique_id < " . $_GET["chptid"] . " AND acm.category_id = " . $_GET["catgid"] . "  ORDER BY acm.unique_id ASC";
					$SelPreviousResourceRS = $db->query("query", $SelPreviousResource);
					if(!array_key_exists("response", $SelNextResourceRS))
						$PreviousResource = $SelPreviousResourceRS[0]["unique_id"];
						$isPrev = true;
					if($isPrev == true && $PreviousResource != ""){
				?>
					<span class="fl mr20" style="margin: 10px;"><a href="./edit-chapter.php?currid=<?php echo $currid; ?>&catgid=<?php echo $catgid; ?>&chptid=<?php echo $PreviousResource; ?>&page=<?php echo $curPage; ?>" class="nexttext">&laquo; Previous</a></span>
				<?php
					}
					unset($SelPreviousResourceRS);
				?>
				<div class="about2"><span class="mt2px fl"><a href="./curriculum.php" class="clrmaroon fl">Curriculums</a>&nbsp;&raquo;&nbsp;</span><select class="inputseacrh inputseacrh2" id="ddlCurriculum" onchange="javascript: window.location='./category.php?currid=' + this.value;"><option value=''>All</option><?php for($sb = 0; $sb < count($rsCurriculums); $sb++){ if($rsCurriculums[$sb]["unique_id"] == $currid){echo "<option value='" . $rsCurriculums[$sb]["unique_id"] . "' selected='selected'>" . $rsCurriculums[$sb]["curriculum_name"] . "</option>";} else {echo "<option value='" . $rsCurriculums[$sb]["unique_id"] . "'>" . $rsCurriculums[$sb]["curriculum_name"] . "</option>";}} ?></select><span class="mt2px fl">&nbsp;&raquo;&nbsp;</span><select class="inputseacrh inputseacrh2" id="ddlSubject" onchange="javascript: window.location='./chapter.php?currid=' + document.getElementById('ddlCurriculum').value + '&catgid=' + this.value;"><option value=''>All</option><?php for($sb = 0; $sb < count($rsSubjects); $sb++){ if($rsSubjects[$sb]["unique_id"] == $catgid){echo "<option value='" . $rsSubjects[$sb]["unique_id"] . "' selected='selected'>" . $rsSubjects[$sb]["category_name"] . "</option>";} else {echo "<option value='" . $rsSubjects[$sb]["unique_id"] . "'>" . $rsSubjects[$sb]["category_name"] . "</option>";}} ?></select><span class="mt2px fl">&nbsp;&raquo;&nbsp;Edit chapter&nbsp;</span><select class="inputseacrh inputseacrh2" onchange="javascript: window.location='./edit-chapter.php?currid=' + document.getElementById('ddlCurriculum').value + '&catgid=' + document.getElementById('ddlSubject').value + '&chptid=' + this.value + '&page=<?php echo $curPage; ?>';"><option value=''>All</option><?php for($sb = 0; $sb < count($rsChapters); $sb++){ if($rsChapters[$sb]["unique_id"] == $chptid){echo "<option value='" . $rsChapters[$sb]["unique_id"] . "' selected='selected'>" . $rsChapters[$sb]["chapter_name"] . "</option>";} else {echo "<option value='" . $rsChapters[$sb]["unique_id"] . "'>" . $rsChapters[$sb]["chapter_name"] . "</option>";}} ?></select></div><!-- End of about -->
			<?php
				unset($rsCurriculums);
				unset($rsSubjects);
				unset($rsChapters);
			?>
				<div id="displayUser">
					<form method="post" name="form" id="form" enctype='multipart/form-data' action="update-chapter.php" onsubmit="return _validateEditchapter();">
						<input type="hidden" id="hdnqryStringChp" name="hdnqryStringChp" value="<?php echo urlencode(filter_querystring($_SERVER["QUERY_STRING"],array("cid","resp"), array("",""))); ?>"> 
						<input type="hidden" id="hdChpID" name="hdChpID" value="<?php echo $chptid; ?>">
						<input type="hidden" id="hdIsValidSlug" name="hdIsValidSlug" value="0">
						<input type="hidden" id="hdCurrentSlug" name="hdCurrentSlug" value="<?php echo $r[0]["chapter_slug"];?>">
						<input type="hidden" id="hdCurrentdulicacy" name="hdCurrentdulicacy" value="<?php echo $r[0]["chapter_code"];?>">
						<input type="hidden" id="hdChpimg" name="hdChpimg" value="<?php echo $r[0]["chapter_image"]; ?>">
						<table cellpadding="0" cellspacing="0" border="0" width="100%">
							<tr>
								<td colspan="2">
									<div id="errormsg" style="margin-bottom: 10px;"></div>
								</td>
							</tr>
							<tr>
								<td class="chaptertext">Subject</td>
								<td>
									<select name="ddlcategory" id="ddlcategory" class="dropdown" onchange="javascript: _getchaptercode(this.value);">
									<?php
										$sub = $db->query("stored procedure","sp_admin_category_select");
										if(!array_key_exists("response", $sub)){
											if(!$sub["response"] == "ERROR"){
												for($i=0; $i< count($sub); $i++){
													if($sub[$i]['unique_id'] == $r[0]['category_id']){
										?>			
													<option value="<?php echo $sub[$i]["unique_id"]; ?>" selected><?php echo $sub[$i]["category_name"]; ?></option>
										<?php
													}else{
														?>
													<option value="<?php echo $sub[$i]["unique_id"]; ?>"><?php echo $sub[$i]["category_name"]; ?></option>	
														<?php
													}
												}
											}
										}unset($sub);
									?>	
									</select>
								</td>
							</tr>
							<tr>
								<td class="chaptertext">Chapter Code</td>
								<td><input type="text" name="chaptercode" id="chaptercode" class="inputseacrh mt10" value="<?php echo $r[0]["chapter_code"]; ?>" onblur="javascript: _checkduplicacy('chaptercode', 'chapter_code','avn_chapter_master');" />
									<div id="imgchk" class="imgslug"></div>
									<div id="msgchk" class="chkedmsg"></div><div class="clr"></div>
									<!--<span class="fl ft16 mt10"><?php //echo $r[0]["chapter_code"]; ?></span>-->
									<input type="hidden" name="txtChaptercode" id="txtChaptercode" value="<?php echo $r[0]["chapter_code"]; ?>" />
									<div id="getchpcode"></div>
								</td
							</tr>
							<tr>
								<td class="chaptertext">Chapter Title</td>
								<td><input type="text" value="<?php echo $r[0]["chapter_name"]; ?>" name="txtchapter" id="txtchapter" class="inputseacrh mt10" onblur="javascript: _createSlug(this.value, 'txtchapterslug', 'chapter_slug','avn_chapter_master');" /></td>
							</tr>
							<!--<tr>
								<td class="chaptertext">Chapter Slug</td>
								<td><input type="text" name="txtchapterslug" id="txtchapterslug" class="inputseacrh mt10" value="<?php echo $r[0]["chapter_slug"]; ?>"  onblur="javascript: _checkslug('txtchapterslug','chapter_slug','avn_chapter_master');"/>
									<div id="imgslug" class="imgslug"></div>
									<div id="msg" class="chkedmsg"></div><div class="clr"></div>
									<div class="duplicacymsg fl">This will be checked for duplicacy.</div>
								</td>
							</tr>--> 
							<tr>
								<td class="chaptertext">Chapter Description</td>
								<td class="mt10"><textarea rows="2" cols="25" name="txtchapterdescription" id="txtchapterdescription" class="inputseacrh mt10"><?php echo $r[0]["chapter_desc"]; ?></textarea></td>
							</tr>
							<tr>
								<td class="chaptertext">Chapter Image</td>
								<td><input type="file" name="txtchapterimage" id="txtchapterimage" class="mt10" /></td>
							</tr>
							<tr>
								<td></td>
								<td colspan="2"><img src="../admin/images/upload-image/<?php echo $r[0]['chapter_image']; ?>" width="200px" class="mt10" /></td>
							</tr>
							<tr>
								<td colspan="2">
									<div class="fl mt20">
										<input type="submit" name="btnUpdate" id="btnUpdate" class="btnSIgn" value="Update">
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
			}
		}
	}
}	
	unset($r);
	$db->close();
?>

</body>
</html>