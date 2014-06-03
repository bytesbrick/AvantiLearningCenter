_chkdataResourse = function(){	
	
	 var chk = false;
	 chk = isFilledText(document.getElementById("txttitle"), "", "Title can't be left blank.", ""); 
	 if(chk == true){
		var x = document.getElementById("txttitle").value;
		if (/[^a-z\s\]/gi.test (x)) 
		 {
			alert("You may only enter characters");
			document.getElementById('txttitle').value= "";
			document.getElementById('txttitle').focus();
		 }
	 }
	 if(chk == true){
		chk = isFilledText(document.getElementById("txtdescription"), "", "Description can't be left blank.", "");
	}
	if(chk == true){
		chk = isCBoxChecked(document.getElementsByName("category[]"), 1, "Select subject check box atleast one", 0, "");
	}
	return chk;
 }

