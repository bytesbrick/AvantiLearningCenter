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
<title>Avanti &raquo; Dashboard &raquo; Add Category </title>
<?php
	include_once("./includes/head-meta.php");
	$currid = 0;
	if(isset($_GET["currid"]) && $_GET["currid"] != "" && $_GET["currid"] != "0")
		$currid = $_GET["currid"];
	$page = $_GET["page"];
?>
</head>
<body>
 <?php
	if(isset($_GET["cid"]))
	{
		$cid = $_GET["cid"];
		$r = $db->query("stored procedure","sp_admin_category_editS('".$_GET["cid"]."')");
		if(!array_key_exists("response", $r))
			{
	 ?>
<div id="page">
	<div id="pageContainer">
		<div id="wrapper">	
			<div id="header">
			<?php
				$pgName = "subjects";
				include_once("./includes/header.php");
			?>
			</div><!-- End of header -->
			<div id="container2">
					<?php
						$isNext = false;
						$isPrev = false;
						$SelNextResource = "SELECT lcm.unique_id FROM ltf_category_master lcm INNER JOIN avn_curriculum_master acm ON acm.unique_id = lcm.curriculum_id WHERE lcm.unique_id > " . $_GET["cid"] . " AND acm.unique_id =" .$_GET["currid"] . " ORDER BY unique_id ASC";
						$SelNextResourceRS = $db->query("query", $SelNextResource);
						
						if(!array_key_exists("response", $SelNextResourceRS))
							$nextResource = $SelNextResourceRS[0]["unique_id"];
							$isNext = true;
							if($isNext == true && $nextResource != ""){
					?>
						<span class="fr mr20" style="margin: 10px;"><a href="./add-category.php?currid=<?php echo $currid; ?>&cid=<?php echo $nextResource; ?>&page=<?php echo $page; ?>" class="nexttext">Next &raquo;</a></span>
					<?php
						}
						unset($SelNextResourceRS);
						$SelPreviousResource = "SELECT lcm.unique_id FROM ltf_category_master lcm INNER JOIN avn_curriculum_master acm ON acm.unique_id = lcm.curriculum_id WHERE lcm.unique_id < " . $_GET["cid"] . " AND acm.unique_id =" .$_GET["currid"] . " ORDER BY unique_id ASC";
						$SelPreviousResourceRS = $db->query("query", $SelPreviousResource);
						if(!array_key_exists("response", $SelNextResourceRS))
							$PreviousResource = $SelPreviousResourceRS[0]["unique_id"];
							$isPrev = true;
						if($isPrev == true && $PreviousResource != ""){
					?>
						<span class="fl mr20" style="margin: 10px;"><a href="./add-category.php?currid=<?php echo $currid; ?>&cid=<?php echo $PreviousResource; ?>&page=<?php echo $page; ?>" class="nexttext">&laquo; Previous</a></span>
					<?php
						}
						unset($SelPreviousResourceRS);
					?>
				<div class="about2"><a href="./category.php" class="clrmaroon fl">Subjects &raquo;</a>&nbsp;Edit Subject</div><!-- End of about -->
				<div id="displayUser">
					<form method="post" name="form" id="form" action="update-category.php" onsubmit="javascript:return _validateEditcategory();">
						<input type="hidden" name="hdCatID" id="hdCatID" value="<?php echo $r[0]['unique_id']; ?>" />
						<input type="hidden" name="hdCurrID" id="hdCurrID" value="<?php echo $currid; ?>" />
						<input type="hidden" id="hdIsValidSlug" name="hdIsValidSlug" value="0">
						<input type="hidden" id="hdCurrentSlug" name="hdCurrentSlug" value="<?php echo $r[0]["category_slug"]; ?>">
						<input type="hidden" id="hdCurrentdulicacy" name="hdCurrentdulicacy" value="<?php echo $r[0]["prefix"]; ?>">
						<input type="hidden" name="hdstringCategory" id="hdstringCategory" value="<?php echo filter_querystring($_SERVER["QUERY_STRING"], array("currid","cid","resp"), array($currid,"","")); ?>" />
						<table cellpadding="0" cellspacing="0" border="0" width="100%">
							<tr>
								<td colspan="2"><div id="errormsg" style="margin-bottom: 10px;"></div></td>
							</tr>
							<tr>
								<td class="chaptertext">Curriculum</td>
								<td>
									<select id="ddlcurriculum" name="ddlcurriculum" class="dropdown mt10">
									<?php
										$selcur = $db->query("query","SELECT unique_id ,curriculum_name FROM avn_curriculum_master ORDER BY curriculum_name");
										for($i=0; $i<count($selcur); $i++){
											if($currid == $selcur[$i]["unique_id"]){
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
								<td class="chaptertext">Subject Title</td>
								<td><input type="text" name="txtcategoryUp" id="txtcategoryUp" class="inputseacrh mt10" value="<?php echo $r[0]['category_name']; ?>" onblur="javascript: _createSlug(this.value, 'hdslug','category_slug','ltf_category_master');" /></td>
							</tr>
							<!--<tr>
								<td class="chaptertext">Subject Slug</td>
								<td><input type="text" name="txtcategoryslug" id="txtcategoryslug" class="inputseacrh mt10" value="<?php echo $r[0]['category_slug']; ?>"  onblur="javascript: _checkslug('txtcategoryslug','category_slug','ltf_category_master');" />
									<div id="imgslug" class="imgslug"></div>
									<div id="msg" class="chkedmsg"></div><div class="clr"></div>
									<div class="duplicacymsg fl">This will be checked for duplicacy.</div>
								</td>
							</tr>-->
							<tr>
								<td class="chaptertext">Prefix</td>
								<td><input type="text" name="prefix" id="prefix" class="inputseacrh mt10" value="<?php echo $r[0]['prefix']; ?>" />
									<div id="imgchk" class="imgslug"></div>
									<div id="msgchk" class="chkedmsg"></div>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<div class="fl mt20">
										<input type="submit" name="btnUpdate" id="btnUpdate" class="btnSIgn" value="Update">
										<span><a href="./category.php"><input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn" /></a></span>
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
			else
				{
?>
	<div id="page">
	<div id="pageContainer">
		<div id="wrapper">	
			<div id="header">
			<?php
				$pgName = "subjects";
				include_once("./includes/header.php"); 
			?>
			</div><!-- End of header -->
			<div id="container2">
				<div class="about2"><a href="./category.php?currid=<?php echo $currid; ?>" class="clrmaroon fl">Subjects &raquo;</a>&nbsp;Add Subject</div><!-- End of about -->
				<div id="displayUser">
					<form method="post" name="form2" id="form2" action="./save-category.php" onsubmit="return _validatecategory();">
						<input type="hidden" name="hdCurrID" id="hdCurrID" value="<?php echo $currid; ?>" />
						<input type="hidden" id="hdIsValidSlug" name="hdIsValidSlug" value="0">
						<input type="hidden" id="hdIsSlugAdd" name="hdIsSlugAdd" value="0">
						<input type="hidden" id="hdIsduplicacyAdd" name="hdIsduplicacyAdd" value="0">
						<input type="hidden" name="hdslug" id="hdslug" value="" />
						<table cellpadding="0" cellspacing="0" border="0" width="100%">
							<tr>
								<td colspan="2"><div id="errormsg" style="height: 12px; margin-bottom: 10px;display: block;"></div></td>
							</tr>
							<tr>
								<td class="chaptertext">Curriculum</td>
								<td>
									<select id="ddlcurriculum" name="ddlcurriculum" class="dropdown mt10">
										<option value="0">Select one</option>
									<?php
										$selcur = $db->query("query","SELECT unique_id ,curriculum_name FROM avn_curriculum_master ORDER BY curriculum_name");
										for($i=0; $i<count($selcur); $i++){
											if($currid == $selcur[$i]["unique_id"]){
									?>
												<option value="<?php echo $selcur[$i]["unique_id"]; ?>" selected="selected"><?php echo $selcur[$i]["curriculum_name"]; ?></option>
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
								<td class="chaptertext">Subject Title</td>
								<td><input type="text" name="txtcategory" id="txtcategory" placeholder="Title" class="inputseacrh mt10" onblur="javascript: _createSlug(this.value, 'hdslug','category_slug','ltf_category_master');" /></td>
							</tr>
							<!--<tr>
								<td class="chaptertext">Subject Slug</td>
								<td><input type="text" name="txtcategoryslug" id="txtcategoryslug" placeholder="Slug" class="inputseacrh mt10" onblur="javascript: _checkslug('txtcategoryslug','category_slug','ltf_category_master');" />
									<div id="imgslug" class="imgslug"></div>
									<div id="msg" class="chkedmsg"></div><div class="clr"></div>
									<div class="duplicacymsg fl">This will be checked for duplicacy.</div>
								</td>
							</tr>--> 
							<tr>
								<td class="chaptertext">Prefix</td>
								<td><input type="text" name="prefix" id="prefix" class="inputseacrh mt10" placeholder="Prefix" />
									<div id="imgchk" class="imgslug"></div>
									<div id="msgchk" class="chkedmsg"></div>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<div class="fl mt20">
										<input type="submit" name="btnSave" id="btnSave" class="btnSIgn" value="Save">
										<span><a href="./category.php"><input type="button" name="btnCancel" id="btnCancel"  value="Cancel" class="btnSIgn" /></a></span>
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
	unset($r);
	$db->close();
?>
</body>
</html>
