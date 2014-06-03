var _chkdataResourse;
_chkdataResourse = function(){
	document.getElementById("ErrMsg").innerHTML = "";
	var chk = true;
	chk = isFilledText(document.getElementById("txttitle"), "", "Title must be filled out", "ErrMsg");
	if(chk == true)
		chk = isFilledText(document.getElementById("txtdescription"), "", "Description must be filled out", "ErrMsg");
	if(chk == true)
		chk = isFilledText(document.getElementById("txtwhatlove"), "", "What to Love must be filled out", "ErrMsg");
	if(chk == true)
		chk = isFilledText(document.getElementById("txtimprove"), "", "How to Improve must be filled out", "ErrMsg");
	if(chk == true)
		chk = isFilledText(document.getElementById("txtstart"), "", "How to Start must be filled out", "ErrMsg");
	if(chk == true)
		chk = isFilledText(document.getElementById("txtexternal"), "", "External Link must be filled out", "ErrMsg");

	return chk;
	alert(chk);
};
var _chkdataConsumer;
_chkdataConsumer = function(){
	document.getElementById("ErrMsg").innerHTML = "";
	var chk = true;
		chk = isFilledText(document.getElementById("txtconsumer"), "", "Consumer must be filled out", "ErrMsg");
};