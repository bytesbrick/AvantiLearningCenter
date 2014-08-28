var WEBROOT = "http://localhost:8080/avanti-design-new";
//var WEBROOT = "http://beta.peerlearning.com";
//var WEBROOT = "http://bytesbrick.com/app-test/avanti";

_checkLogin = function()
{
	//var chk = true;	
	//if(chk == true)
	//	chk = isFilledText(document.getElementById("txtemailid"),"Emailid", "E-mail can't be left blank.", ""); 
	//if(chk == true)
	//	chk = isEmailAddr(document.getElementById("txtemailid"), "Invalid Email ID.", "");
	//if(chk == true)
	//	chk = isFilledText(document.getElementById("txtpassword"),"password", "Password can't be left blank.", "");
	//return chk;
	
	document.getElementById("emsg").innerHTML = "";
	var chk = true;
	if(chk == true)
		chk = isFilledText(document.getElementById("txtemailid"), "", "E-mail can't be left blank.", "emsg");	
	if(chk == true)
		chk = isEmailAddr(document.getElementById("txtemailid"), "Invalid Email ID.", "emsg");
	if(chk == true)
		chk = isFilledText(document.getElementById("txtpassword"), "", "Password can't be left blank.", "emsg");
	return chk;
};

validateForm = function()
{
	var hd = document.getElementById("hdnoption").value;
	var qIDs = hd.split(",");
	var chk = true;	
	for (q = 0; q < qIDs.length; q++) {
		var x = document.getElementsByName("rdoption" + qIDs[q]);
		var ic=0;
		for(a= 0; a < x.length; a++){
			if (x.item(a).checked){
				ic=1;
				break;
			}
		}
		if (ic == 0) {
			alert("Please answer all question before submitting.");
			chk = false;
			break;
		}	
	}
	return chk;
}

conceptvalidateForm = function()
{
	var hd = document.getElementById("hdnctoption").value;
	var qIDs = hd.split(",");
	var chk = true;	
	for (q = 0; q < qIDs.length; q++) {
		var x = document.getElementsByName("ctrdoption" + qIDs[q]);
		var ic=0;
		for(a= 0; a < x.length; a++){
			if (x.item(a).checked){
				ic=1;
				break;
			}
		}
		if (ic == 0) {
			alert("Please answer the question before submitting.");
			chk = false;
			break;
		}	
	}
	return chk;
}

_getHeight = function(eID){
	if (document.getElementById(eID).style.height) {
		return parseInt(document.getElementById(eID).style.height);
	} else {
		if(document.getElementById(eID).offsetHeight < 150){
			return 200;
		} else {
			return parseInt(document.getElementById(eID).offsetHeight) + 100;
		}	
	}
	
}
_selectbatch = function(){
	document.getElementById("errormsg").innerHTML = "";
	var chk = true;
	if(chk == true){
		chk = isFilledSelect(document.getElementById("ddlcenter"),0,"Please select a center",0,"errormsg");
	    }
	if(chk == true){
		chk = isFilledSelect(document.getElementById("ddlbatch"),0,"Please select a batch",0,"errormsg");
	}
	return chk;
}
_valsendpwd = function(){
         document.getElementById("errormsg").innerHTML = "";
	var chk = true;
       if(chk == true)
		chk = isFilledText(document.getElementById("txtforgetemailid"), "", "Email address can't be left blank.", "errormsg");
	if(chk == true)
		chk = isEmailAddr(document.getElementById("txtforgetemailid"), "Please fill in your valid EmailID", "errormsg");
	if(chk == true)
		_userchkpwd();
	return chk;
}
_userchkpwd = function(){
	var txtforgetemailid = document.getElementById("txtforgetemailid").value;
	var p = new Array();
	p[0] = new Array("txtforgetemailid", txtforgetemailid);
	var aj = new _ajax(WEBROOT + "/ajax/send-password.php", "post",p,function(){_waitGetuserchkpwd()},function(r){_responseuserchkpwd(r)});
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

_getHeight = function(eID){
	if (document.getElementById(eID).style.height) {
		return parseInt(document.getElementById(eID).style.height);
	} else {
		if(document.getElementById(eID).offsetHeight < 150){
			return 200;
		} else {
			return parseInt(document.getElementById(eID).offsetHeight) + 100;
		}	
	}
	
}

_click = function(id){
	if (document.getElementById(id).style.display == "none")
		document.getElementById(id).style.display = "block";
	else
		document.getElementById(id).style.display = "none";
}