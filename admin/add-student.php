<?php
	error_reporting(0);
	include("./includes/config.php");		
	include("./classes/cor.mysql.class.php");
	include("./includes/checkLogin.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Avanti  &raquo; Dashboard &raquo; Add Students</title>
<?php
	include_once("./includes/head-meta.php");
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
					<form method="post" name="form" enctype='multipart/form-data' id="form" action="./save-student.php" onsubmit="javascript: return _chkstudentDetails();">
						<input type="hidden" id="hdnstudent" name="hdnstudent" value="Student" />
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
									<select type="dropdown" id="ddlBatch" name="ddlBatch" class="dropdown" onchange="javascript: _createStudentId(this.value);">
										<option value="none">Select One</option>
									<?php
										if($arrUserInfo["usertype"] == "Teacher")
											$sql = "SELECT bm.unique_id as BatchID, bm.batch_name, bm.batch_id, lcm.center_name, cm.city_name FROM avn_batch_master bm INNER JOIN avn_learningcenter_master lcm ON bm.learning_center = lcm.unique_id INNER JOIN avn_city_master cm ON lcm.city_id = cm.unique_id INNER JOIN avn_teacher_master atm ON atm.city_id = lcm.city_id WHERE atm.unique_id = " . $arrUserInfo["user_ref_id"];
										else
											$sql = "SELECT bm.unique_id as BatchID, bm.batch_name, bm.batch_id, lcm.center_name, cm.city_name FROM avn_batch_master bm INNER JOIN avn_learningcenter_master lcm ON bm.learning_center = lcm.unique_id INNER JOIN avn_city_master cm ON lcm.city_id = cm.unique_id";
											
											$batch = $db->query("query", $sql);
											///print_r($batch);
											if(!array_key_exists("response", $batch)){
												for($i =0; $i < count($batch); $i++){
									?>
												<option value="<?php echo $batch[$i]["BatchID"]; ?>"><?php echo $batch[$i]["batch_name"]; ?>, <?php echo $batch[$i]["center_name"]; ?>, <?php echo $batch[$i]["city_name"]; ?> [<?php echo $batch[$i]["batch_id"]; ?>]</option>
									<?php
												} 
											}unset($batch);
									?>
									</select>
								</td>
								<td><input type="text" id="txtStudentFName" name="txtStudentFName" placeholder="Student Name" class="txtboxS" placeholder="First name" />&nbsp;<input type="text" id="txtStudentLName" name="txtStudentLName" class="txtboxS" placeholder="Last name" /></td>
							</tr>
							<tr>
								<td class="ft16">Student ID</td>
								<td class="ft16">Email</td>
							</tr>
							<tr>
								<td><input type="text" id="txtstudentID" name="txtstudentID" class="inputseacrh" placeholder="Student ID" /></td>
								<td><input type="text" id="txtEmailID" name="txtEmailID" class="inputseacrh" value="" placeholder="Email" /></td>
							</tr>
							<tr>
								<td class="ft16">Passsword</td>
								<td class="ft16">Confirm Password</td>
							</tr>
							<tr>
								<td><input type="password" id="textpassword" name="textpassword" class="inputseacrh" placeholder="Passsword" /></td>
								<td>
									<input type="password" id="textconfirmpassword" name="textconfirmpassword" placeholder="Confirm Password" class="inputseacrh"  />
								</td>
							</tr>
							<tr>
								<td class="ft16">Phone Number</td>
								<td class="ft16">Gender</td>
							</tr>
							<tr>
								<td><input type="text" id="txtPhone" name="txtPhone" class="inputseacrh" maxlength="10" placeholder="Phone Number" placeholder="eg. 9876543210" onkeypress="javascript: return _allowNumeric(event);" /></td>
								<td>
									<select type="dropdown" id="ddlGender" name="ddlGender" class="dropdown">
										<option value="none">Select One</option>
										<option value="1">Male</option>
										<option value="2">Female</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="ft16">Board</td>
								<td class="ft16">School</td>
							</tr>
							<tr>
								<td><input type="text" id="txtboard" name="txtboard" class="inputseacrh" placeholder="Board" /></td>
								<td>
									<input type="text" id="txtschool" name="txtschool" class="inputseacrh" placeholder="School"  />
								</td>
							</tr>
							<tr>
								<td class="ft16">Address</td>
								<td class="ft16">Status</td>
							</tr>
							<tr>
								<td>
									<textarea id="textaddress" name="textaddress" cols="10"  rows="1" placeholder="Address" style="width: 315px;height: 31px;"></textarea>
								</td>
								<td>
									<select type="dropdown" id="ddlStatus" name="ddlStatus" class="dropdown">
										<option value="none">Select One</option>
										<option value="1">Active</option>
										<option value="0">Inactive</option>
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