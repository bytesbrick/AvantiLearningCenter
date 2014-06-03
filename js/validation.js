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