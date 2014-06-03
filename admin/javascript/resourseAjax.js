var r;
_search = function(v){
		var search = v.split(",");
		if(search[search.length - 1].trim() != ""){
			var p = new Array();
			p[0] = new Array("search", search[search.length - 1]);
			var aj = new _ajax("ajax/search-tag.php", "post",p,function(){_waitsearch(r)}, function(r){_responsesearch(r)});
			aj._query();
		}
}
_waitsearch = function(r){
		document.getElementById("hddnsearchtext").style.display = "block";
		document.getElementById('hddnsearchtext').style.color = "#80797C";
		document.getElementById("hddnsearchtext").innerHTML = "Please wait...";
}
_responsesearch = function(resp){
		document.getElementById("hddnsearchtext").innerHTML = " ";
		var disp = resp.split("#/#");
		if(disp[0] != "" && disp[0] == 1){
			document.getElementById("hddnsearchtext").style.display = "block";
			var sch = disp[1].split("##");
			if(disp[1] != ""){
				for(var i = 0;i<sch.length;i++){
					document.getElementById("hddnsearchtext").innerHTML += "<a href='javascript:void(0);' onclick=\"javascript: _setTxtValue('" + sch[i] + "')\">" + sch[i] + "</a><br/>";	
				}
			}else
				document.getElementById("hddnsearchtext").style.display = "none";
		}else
			document.getElementById("hddnsearchtext").style.display = "none";
};

_setTxtValue = function(str){
	var v = document.getElementById("txttag").value;
	var search = v.split(",");
	var fStr = "";
	for(i = 0; i < search.length - 1; i++){
		fStr += fStr == "" ? search[i].trim() : ", " + search[i].trim();
	}
	if(search.length > 1)
		fStr += ", " + str;
	else
		fStr = str;
	document.getElementById("txttag").value = fStr;
	document.getElementById("hddnsearchtext").style.display = "none";
	document.getElementById("txttag").focus();
};