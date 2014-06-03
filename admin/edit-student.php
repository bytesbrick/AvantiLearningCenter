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
<title>Avanti  &raquo; Dashboard &raquo; Edit Student</title>
<?php
	include_once("./includes/head-meta.php");
	$r = $db->query("query","SELECT asm.*, AES_DECRYPT(alm.password, '" . ENCKEY . "') as PWD FROM avn_student_master asm INNER JOIN avn_login_master alm ON asm.unique_id = alm.user_ref_id WHERE asm.unique_id = " . $_GET["cid"]);
	//print_r($r);
?>
</head>
<body>
<div id="pageR">
	<div id="pageContainerR">
		<div id="wrapper">	
			<div id="header">
			<?php
				$pgName = "students";
				include_once("./includes/header.php");
			?>
			</div><!-- End of header -->
			<div id="container2">
				<div class="about2"><a href="./student.php" class="clrmaroon fl">Students &raquo;</a>&nbsp;Add Student</div><!-- End of about -->
				<div id="displayUser">
					<form method="post" name="form" enctype='multipart/form-data' id="form" action="./update-student.php" onsubmit="javascript: return _chkstudentDetails();">
						<input type="hidden" id="hdStudentid" name="hdStudentid" value="<?php echo $_GET["cid"]; ?>">
						<input type="hidden" id="hdnstudent" name="hdnstudent" value="Student">
						<table cellspacing="6" cellpadding="5" border="0" width="710px">
							<tr>
								<td>
									<div id="errormsg" style="height: 12px;"></div>
								</td>
							</tr>
							<tr>
								<td class="ft16">Batch</td>
								<td class="ft16">Student Name</td>
							</tr>
							<tr>
								<td>
									<select type="dropdown" id="ddlBatch" name="ddlBatch" class="dropdown">
										<option value="none">Select One</option>
										<?php
											if($arrUserInfo["usertype"] == "Teacher"){
												$batch = $db->query("query","SELECT abm.unique_id ,abm.batch_name,abm.batch_id FROM avn_batch_master abm INNER JOIN avn_teacher_master atm ON atm.city_id = abm.city_id WHERE atm.unique_id = " . $arrUserInfo["user_ref_id"]);
												for($i =0; $i < count($batch); $i++){
													if($r[0]["batch_id"] == $batch[$i]["unique_id"]){
											?>
														<option value="<?php echo $batch[$i]["unique_id"]; ?>" selected=><?php echo $batch[$i]["batch_id"]; ?></option>
											<?php
													}else{
											?>
														<option value="<?php echo $batch[$i]["unique_id"]; ?>"><?php echo $batch[$i]["batch_id"]; ?></option>
											<?php
													}
												}
											}
											else{
												$batch = $db->query("query","SELECT unique_id ,batch_name,batch_id FROM avn_batch_master");
													for($i =0; $i < count($batch); $i++){
													if($r[0]["batch_id"] == $batch[$i]["unique_id"]){
											?>
														<option value="<?php echo $batch[$i]["unique_id"]; ?>" selected=><?php echo $batch[$i]["batch_id"]; ?></option>
											<?php
													}else{
											?>
														<option value="<?php echo $batch[$i]["unique_id"]; ?>"><?php echo $batch[$i]["batch_id"]; ?></option>
											<?php
													}
												}
											}
										?>
									</select>
								</td>
								<td><input type="text" id="txtStudentFName" name="txtStudentFName" class="txtboxS" placeholder="First name" value="<?php echo $r[0]["fname"]?>" />&nbsp;<input type="text" id="txtStudentLName" name="txtStudentLName" class="txtboxS" placeholder="Last name" value="<?php echo $r[0]["lname"]?>" /></td>
							</tr>
							<tr>
								<td class="ft16">Student ID</td>
								<td class="ft16">Email</td>
							</tr>
							<tr>
								<td><input type="text" id="txtstudentID" name="txtstudentID" class="inputseacrh" value="<?php echo $r[0]["student_id"]?>" /></td>
								<td><input type="text" id="txtEmailID" name="txtEmailID" class="inputseacrh" value="<?php echo $r[0]["email_id"]; ?>" /></td>
							</tr>
							<tr>
								<td class="ft16">Passsword</td>
								<td class="ft16">Confirm Password</td>
							</tr>
							<tr>
								<td><input type="password" id="textpassword" name="textpassword" class="inputseacrh" value="<?php echo $r[0]["PWD"]; ?>" /></td>
								<td>
									<input type="password" id="textconfirmpassword" name="textconfirmpassword" class="inputseacrh" value="<?php echo $r[0]["PWD"]; ?>"  />
								</td>
							</tr>
							<tr>
								<td class="ft16">Phone Number</td>
								<td class="ft16">Gender</td>
							</tr>
							<tr>
								<td><input type="text" id="txtPhone" name="txtPhone" class="inputseacrh" maxlength="10" value="<?php echo $r[0]["phone"]; ?>" onkeypress="javascript: return _allowNumeric(event);" /></td>
								<td>
									<select type="dropdown" id="ddlGender" name="ddlGender" class="dropdown">
										<?php
											if(isset($r[0]['gender']) && $r[0]['gender'] == '1'){
										?>
											<option value="1" selected>Male</option>
										<?php
										}else{
										?>
											<option value="1">Male</option>
										<?php
										}if(isset($r[0]['gender']) && $r[0]['gender'] == '2'){
										?>
											<option value="2" selected>Female</option>
										<?php
										}else{
										?>
											<option value="2">Female</option>
										<?php
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="ft16">Board</td>
								<td class="ft16">School</td>
							</tr>
							<tr>
								<td><input type="text" id="txtboard" name="txtboard" class="inputseacrh"  value="<?php echo $r[0]["board"]; ?>" /></td>
								<td>
									<input type="text" id="txtschool" name="txtschool" class="inputseacrh"  value="<?php echo $r[0]["school"]; ?>"  />
								</td>
							</tr>
							<tr>
								<td class="ft16">Address</td>
								<td class="ft16">Status</td>
							</tr>
							<tr>
								<td>
									<textarea id="textaddress" name="textaddress" class="textarea">
										<?php echo $r[0]["address"]; ?>
									</textarea>
								</td>
								<td>
									<select type="dropdown" id="ddlStatus" name="ddlStatus" class="dropdown">
										<?php
											if(isset($r[0]['status']) && $r[0]['status'] == '1'){
										?>
											<option value="1" selected>Active</option>
										<?php
										}else{
										?>
											<option value="1">Active</option>
										<?php
										}if(isset($r[0]['status']) && $r[0]['status'] == '0'){
										?>
											<option value="0" selected>Inactive</option>
										<?php
										}else{
										?>
											<option value="0">Inactive</option>
										<?php
										}
										?>
									</select>
								</td>	
							</tr>
							<tr>
								<td><input type="submit" id="btnsave" name="btnsave" value="Save User" class="btnSIgn" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" id="txtLName" name="txtLName"  value="Cancel" class="btnSIgn" /></td>
								<td></td>
							</tr>
						</table>
					</form>
				</div><!-- end of displayUser -->
			</div><!-- end of container -->
			<?php
				include_once("./includes/sidebar.php");
			?>
		</div><!-- end of wrapper -->
	</div><!-- end of pagecontainer -->
</div><!-- end of page -->
</body>
</html>