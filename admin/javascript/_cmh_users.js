var _filterCheck,_validateStatus,_checkUser,_selAllJobs,_pageChange,_checkVendor,_checkuname,_httpCheckuname,_checkRelHistory,_checkUserExist,_httpCheckUserExist,_validateGallery,_validateEditGallery;

_filterCheck= function(){
	document.getElementById("ErrMsg").innerHTML = "";
	var chk = false;
	chk = isFilledSelect(document.getElementById("ddlColumn"), 0, "Choose Column filter.", 0, "ErrMsg");
	if(chk == true)
		chk = isFilledText(document.getElementById("txtvalue"), "", "Value can't be left blank.", "ErrMsg");	
	return chk;
};
_validateStatus = function(){
	document.getElementById("ErrMassage").innerHTML = "";
	var chk = false;
	chk = isFilledSelect(document.getElementById("ddlStatus"), 0, "Please choose status.", 0, "");
	if(chk == true)
		chk = isCBoxChecked(document.getElementsByName("chkUsers[]"), 1, "Please choose user(s) to change status.", 0, "");
	return chk;
};
_checkUser = function(){
	document.getElementById("ErrMsg").innerHTML = "";
	var chk = false;	
	chk = isFilledText(document.getElementById("txtUserID"), "", "User ID can't be left blank.", "");	
	if(chk == true)
		chk = isEmailAddr(document.getElementById("txtUserID"), "Invalid Email ID.", "");
	if(chk == true)
		chk = isFilledText(document.getElementById("hdUserCheck"), "0", "This email id is already taken.Please try something else.", "");
	if(chk == true)
		chk = isFilledText(document.getElementById("txtpassword"), "", "Password can't be left blank.", "");
	if(chk == true)
	{
		if(document.getElementById("txtpassword").value.trim() != document.getElementById("txtConfirmPass").value.trim())
		{
			alert("Passwords are not matching.");
			chk = false;
		}
	}
	if(chk == true)
		chk = isFilledSelect(document.getElementById("ddlUserType"), 0, "UserType can't be left blank.", 0, "");
	if(chk == true)
		chk = isFilledText(document.getElementById("txtfirstName"), "", "First can't be left blank.", "");
	if(chk == true)
		chk = isFilledSelect(document.getElementById("ddlSuperVisor"), 0, "SuperVisor can't be left blank.", 0, "");
	return chk;
};
_selAllJobs = function(){
	for(i = 0;  i < document.getElementsByName("chkJobs[]").length; i++)
	{
		document.getElementsByName("chkJobs[]")[i].checked = document.getElementById("chkAllJobs").checked;
	}
};		
_pageChange = function(){
	var pageNo = document.getElementById("ddlpage").value;
	window.location.href='user-management.php?page=' + pageNo;
};
_passwordmatch = function(){
		if(document.getElementById("txtpassword").value.trim() != document.getElementById("txtConfirmPass").value.trim())
		{
			alert("Passwords are not matching.");
			document.getElementById("txtConfirmPass").focus();
			return false;
		}
}

_checkVendor = function(){
	document.getElementById("ErrMsg").innerHTML = "";
	var chk = false;	

	chk = isFilledSelect(document.getElementById("ddlCity"), 0, "Please select city.", 0, "");
	if(chk == true)
	chk = isFilledText(document.getElementById("txtpassword"), "", "Please enter your password", "");
	if(chk == true)
	chk = isFilledText(document.getElementById("txtConfirmPass"), "", "Please confirm your password", "");	
	if(chk == true)
	{
		if(document.getElementById("txtpassword").value.trim() != document.getElementById("txtConfirmPass").value.trim())
		{
			alert("Passwords are not matching.");
			chk = false;
		}
	}
	if(chk == true)
		chk = isFilledSelect(document.getElementById("ddlAreaofOps"), 0, "Please select area of operations.", 0, "");
	if(chk == true)
		chk = isFilledSelect(document.getElementById("ddlCategory"), 0, "Please select category.", 0, "");
	if(chk == true)
		chk = isFilledText(document.getElementById("txtMemIndustrialBody"), "", "Please mention if you are a member of any Industrial Body.", "");
	if(chk == true)
		chk = isFilledSelect(document.getElementById("ddlProjectsType"), 0, "Please select project type.", 0, "");
	if(chk == true)
		chk = isFilledText(document.getElementById("txtComapnyView"), "", "Please enter companys view.", "");
	if(chk == true)
		chk = isFilledText(document.getElementById("txtCNamePerson"), "", "Please enter name of concerned person.", "");
	if(chk == true)
		chk = isFilledText(document.getElementById("txtWebsite"), "", "Please enter website name.", "");
	if(chk == true)
		chk = isFilledText(document.getElementById("txtContactNo"), "", "Please enter contact number.", "");
	if(chk == true)
	{
		chk = isFilledText(document.getElementById("txtCellNo"), "", "Please enter cell number.", "");
	}

	var flName = document.getElementById("uploadProfile").value;
	var flParts = flName.split(".");
	var flExtn = flParts[flParts.length - 1].toLowerCase();
	if(flName != "" && chk == true)
	{
		if(flExtn != "jpg" && flExtn != "jpeg" && flExtn != "pdf")
		{
			alert("Please upload jpg ,jpeg or pdf files.");
			chk = false;
		}
	}
	if(chk == true)
		chk = isFilledText(document.getElementById("txtEmail"), "", "Please enter email address.", "");
	if(chk == true)
		chk = isEmailAddr(document.getElementById("txtEmail"), "Please enter valid Email ID.", "");
	if(chk == true)
		chk = isFilledText(document.getElementById("hdUserCheck"), "0", "This email id is already taken.Please try something else.", "");
	if(chk == true)
		chk = isFilledText(document.getElementById("txtDateOfferMailed"), "", "Please enter date offer mailed.", "");
	if(chk == true)
		chk = isFilledText(document.getElementById("txtCompanyProfileReceived"), "", "Please enter if company profile is received", "");
	if(chk == true)
		chk = isFilledText(document.getElementById("txtClientsTestRec"), "", "Please enter if clients testimonial is received", "");
	if(chk == true)
		chk = isFilledText(document.getElementById("txtProjPicReceived"), "", "Please enter if projects picture is received", "");
	if(chk == true)
		chk = isFilledText(document.getElementById("txtReference"), "", "Please enter your reference", "");
	if(chk == true)
		chk = isFilledText(document.getElementById("txtVendorName"), "", "Please enter your name", "");

	return chk;
};


/*Check for duplicate vendor */
var aj;
 _checkuname = function(email)
{
	var myRandom = parseInt(Math.random()* 99999999);
	if(window.XMLHttpRequest)
		aj = new XMLHttpRequest;
	else if(window.ActiveXObject)
		aj = new ActiveXObject("Microsoft.XMLHTTP");

	aj.open("GET","chkDuplicateVendor.php?rand=" + myRandom + "&email=" + email,true);
	aj.onreadystatechange = _httpCheckuname;
	aj.send(null);
 };
 _httpCheckuname = function()
{
	if(aj.readyState < 4)
	{;}
	else if(aj.readyState == 4)
	{
		var resp = aj.responseText;
		if(resp == 1)
		{
			//alert("This email id is already taken.Please try something else.");
			document.getElementById("hdUserCheck").value = "0";
		}
		else if(resp == 0)
		{
			//alert("This email id is available.");
			document.getElementById("hdUserCheck").value = "1";
		}
	}
 };


_checkRelHistory = function()
{
	document.getElementById("ErrMsg").innerHTML = "";
	var chk = false;

	chk = isFilledText(document.getElementById("txtProjectsReferred"), "", "Please enter Projects Referred", "");
	if(chk == true)
		chk = isFilledText(document.getElementById("txtSatinCustomer"), "", "Please enter satisfaction in customer", "");
	if(chk == true)
		chk = isFilledText(document.getElementById("txtPaymentRec"), "", "Please enter if payment is received", "");
	if(chk == true)
		chk = isFilledText(document.getElementById("txtTypeOfVendor"), "", "Please enter type of vendor.", "");
	return chk;
}


/*Check for duplicate user */
var aj;
 _checkUserExist = function(email)
{
	var myRandom = parseInt(Math.random()* 99999999);
	if(window.XMLHttpRequest)
		aj = new XMLHttpRequest;
	else if(window.ActiveXObject)
		aj = new ActiveXObject("Microsoft.XMLHTTP");

	aj.open("GET","chkDuplicateUser.php?rand=" + myRandom + "&email=" + email,true);
	aj.onreadystatechange = _httpCheckUserExist;
	aj.send(null);
 };
 _httpCheckUserExist = function()
{
	if(aj.readyState < 4)
	{;}
	else if(aj.readyState == 4)
	{
		var resp = aj.responseText;
		if(resp == 1)
		{
			//alert("This email id is already taken.Please try something else.");
			document.getElementById("innermassege").innerHTML ="Already Taken..";
			document.getElementById("txtUserID").value = "";
			document.getElementById("hdUserCheck").value = "0";
		}
		else if(resp == 0)
		{
			//alert("This email id is available.");
			document.getElementById("innermassege").innerHTML ="Available...";
			document.getElementById("hdUserCheck").value = "1";
		}
	}
 };

 /*Gallery*/
 _validateGallery = function()
{
	var chk =  true;
	document.getElementById("UploadErr").innerHTML = "";
	var flName = document.getElementById("uploadFile").value;
	var flParts = flName.split(".");
	var flExtn = flParts[flParts.length - 1].toLowerCase();
	if(flName == "")
	{
		alert("Please choose a image to upload.");
		chk = false;
	}
	if(chk == true)
	{
		if(flExtn != "jpg" && flExtn != "gif" && flExtn != "jpeg" && flExtn != "png")
		{
			alert("You can only upload images (jpeg/jpg/gif/png).");
			chk = false;
		}
	}
	if(chk == true)
	{
		chk = isFilledText(document.getElementById("txttitle"), "", "Title text can't be left blank.", "");
	}
	if(chk == true)
	{
		chk = isFilledText(document.getElementById("txtalt"), "", "Alternate text can't be left blank.", "");
	}
	
	return chk;
};

 _validateEditGallery = function()
{
	var chk =  true;
	document.getElementById("UploadErr").innerHTML = "";
	var flName = document.getElementById("uploadFile").value;
	var flParts = flName.split(".");
	var flExtn = flParts[flParts.length - 1].toLowerCase();
	if(flName != "" && chk == true)
	{
		if(flExtn != "jpg" && flExtn != "gif" && flExtn != "jpeg" && flExtn != "png")
		{
			alert("You can only upload images (jpeg/jpg/gif/png).");
			chk = false;
		}
	}
	if(chk == true)
	{
		chk = isFilledText(document.getElementById("txttitle"), "", "Title text can't be left blank.", "");
	}
	if(chk == true)
	{
		chk = isFilledText(document.getElementById("txtalt"), "", "Alternate text can't be left blank.", "");
	}
	
	return chk;
};
/*_validatPartner = function()
{
	var chk = true;
	chk = isFilledText(document.getElementById("txtPartnerName"), "", "Parterner Name can't be left blank.", "");
	if(chk == true)
	{
	chk = isFilledText(document.getElementById("txtAddress"), "", "Address can't be left blank.", "");
	}
	if(chk == true)
	{
	chk = isFilledText(document.getElementById("txtAddress"), "", "Address can't be left blank.", "");
	}
	return chk;		
};
*/

function CheckfilesType()
{
	var fup = document.getElementById('txtFile');
	var fileName = fup.value;
	var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
	if(ext == "gif" || ext == "GIF" || ext == "JPEG" || ext == "jpeg" || ext == "jpg" || ext == "JPG" || ext == "png" || ext == "PNG")
{
return true;
}
else
{
alert("Upload Gif or Jpg images only");
fup.focus();
return false;
}
};



_Checkpartneravailable = function(partnername){
	var p = new Array();
		p[0] = new Array("partnername", partnername);
		var aj = new _ajax("./partnername_available.php", "post",p,"_waitGetrespPartner","_responseGetrespPartner");
		aj._query();
};
_waitGetrespPartner = function(){
};
_responseGetrespPartner = function(resp){
	if(resp == 1){
		document.getElementById('txtmassage').innerHTML = "Duplicate Partner Not Allowed";
		document.getElementById('txtPartnerName').value="";
		document.getElementById('txtPartnerName').focus();
	}
	else
		document.getElementById('txtmassage').innerHTML = "";
};
