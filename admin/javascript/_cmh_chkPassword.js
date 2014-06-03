
_checkPassword = function(){
	document.getElementById("pwderr").innerHTML = "";
	var chk = true;	
	chk = isFilledText(document.getElementById("txtOpwd"), "", "Old Password can't be left blank.", "pwderr");
	if(chk == true)
		_chkPassword(document.getElementById("txtOpwd").value);
};

 var aj;
_chkPassword = function(txtpassword){
	if(window.XMLHttpRequest)
		aj = new XMLHttpRequest;
	else if(window.ActiveXObject)
		aj = new ActiveXObject("Microsoft.XMLHTTP");
	aj.open("POST", "chk-pwd.php", true);
	aj.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	aj.onreadystatechange = _httpChkPass;
	aj.send("txtPassword=" + txtpassword);
};
_httpChkPass = function(){
	if(aj.readyState < 4)
		document.getElementById("pwderr").innerHTML = "";
	else if(aj.readyState == 4)
	{ 			
		var disp = aj.responseText;
		if(disp != "" && disp != undefined)
		{
			if(disp != 1)
			{
				document.getElementById("hdChPCheck").value = 0;
				document.getElementById("txtNpwd").disabled = true;
				document.getElementById("txtCpwd").disabled = true;
				document.getElementById("pwderr").innerHTML = "Current Password is not correct. Please enter correct current password";
			}
			else
			{
				document.getElementById("hdChPCheck").value = 1;
				document.getElementById("txtNpwd").disabled = false;
				document.getElementById("txtCpwd").disabled = false;
				document.getElementById("pwderr").innerHTML = "Current Password is matched.";
			}
		}
	}
 };
_chkAllSet = function(){
	document.getElementById("pwderr").innerHTML = "";
	var chk = true;	
	chk = isFilledText(document.getElementById("txtOpwd"), "", "Old Password can't be left blank.", "pwderr");
	if(chk == true)
		if(document.getElementById("hdChPCheck").value == 0)
		{
			chk = false;
			document.getElementById("pwderr").innerHTML = "Current Password is not correct. Please enter correct current password";
		}
	if(chk == true)
		chk = isFilledText(document.getElementById("txtNpwd"), "", "New Password can't be left blank.", "pwderr");
	if(chk == true)
	{
		if(document.getElementById("txtNpwd").value.trim() != document.getElementById("txtCpwd").value.trim())
		{
			document.getElementById("pwderr").innerHTML = "New Password are not matching.";
			chk = false;
		}
	}
	return chk;
};