var _checkLogin;
_checkLogin = function(){
	document.getElementById("errormsg").innerHTML = "";
	var chk = true;	
	chk = isFilledText(document.getElementById("txtUserID"), "", "User ID can't be left blank.", "errormsg");	
	if(chk == true)
		chk = isEmailAddr(document.getElementById("txtUserID"), "Invalid Email ID.", "errormsg");
	if(chk == true)
		chk = isFilledText(document.getElementById("txtpassword"), "", "Password can't be left blank.", "errormsg");
	return chk;
};
_valsendpwd = function(){
        document.getElementById("pleasewait").innerHTML = "";
	var chk = true;
       if(chk == true)
		chk = isFilledText(document.getElementById("txtforgetemailid"), "", "Email ID can't be left blank.", "pleasewait");
	if(chk == true)
		chk = isEmailAddr(document.getElementById("txtforgetemailid"), "Please fill in your valid EmailID", "pleasewait");
	if(chk == true)
		_userchkpwd();
	return chk;
}
_userchkpwd = function(){
	var txtforgetemailid = document.getElementById("txtforgetemailid").value;
	var p = new Array();
	p[0] = new Array("txtforgetemailid", txtforgetemailid);
	var aj = new _ajax("./ajax/send-password.php", "post",p,function(){_waitGetuserchkpwd()},function(r){_responseuserchkpwd(r)});
	aj._query();
}
_waitGetuserchkpwd = function(){
         document.getElementById("pleasewait").style.display = "block";
         document.getElementById('pleasewait').innerHTML = 'Please wait...';
};
_responseuserchkpwd = function(resp){
	if(resp != "" && resp != undefined){
		if(resp == 1){
		   document.getElementById("pleasewait").style.display = "none";
			document.getElementById("fgpassmsg").style.display = "block";
			document.getElementById("fgpassmsg").innerHTML = "An email has been sent to your email id to reset your password.";
		}
		else{
		    document.getElementById("pleasewait").style.display = "none";
			document.getElementById("fgpassmsg").style.display = "block";
			document.getElementById("fgpassmsg").innerHTML = "Please check your email id as it is not registered in our system.";
		}
	}
}
