var aj;
var p = new Array();
var WEBROOT = "http://localhost:8080/avanti/";
//var WEBROOT = "http://beta.peerlearning.com";
//var WEBROOT = "http://bytesbrick.com/app-test/avanti";
_createFilter = function(chkAllsubject, type, value, id, currid, mode){
	var iF = -1;
	for(c = 0; c < p.length; c++){
		if(p[c][0] == type){
			iF = c;
			break;
		}
	}
	if (mode == "all"){
        if (document.getElementById(chkAllsubject).checked == true) {
            var allSub = document.getElementsByName(type);
            for(c = 0; c < allSub.length; c++)
            allSub[c].checked = false;
        } 
    }
	if(document.getElementById(id)){
		var cObj = document.getElementById(id);
		switch(cObj.type){
			case "checkbox":
				var objName = cObj.name;
				var allObj = document.getElementsByName(objName);
				var strVal = "";
				tc = 0;
				for(c = 0; c < allObj.length; c++){
					if(allObj[c].checked == true){
						tc++;
						strVal += strVal == "" ? allObj[c].value : "," + allObj[c].value;
					}
				}
				if (tc == allObj.length){
				   document.getElementById(chkAllsubject).checked = true;
				}
				else {
					if (tc > 0)
						document.getElementById(chkAllsubject).checked = false;
					else
						document.getElementById(chkAllsubject).checked = true;
				}
				if(strVal != "" && strVal != "on"){
					if(iF <= -1)
						p.push(new Array(type, strVal));
					else{
						p[iF][1] = strVal;
					}
				}
				else{
					p.splice(iF, 1);
					if (mode == "single") {
						document.getElementById(chkAllsubject).checked == true
					}
					else{
						if (document.getElementById(chkAllsubject).checked == true){
							if (p.length <= 0){
								if (mode == "all"){
									p.push(new Array("chkcurriculum", currid));
								}
							}
						}	
					}
				}
			break;
			case "select-one":
				p.push(new Array(type, value));
			break;
		}
	}
	_applyFilter();
};
_applyFilter = function(){
	var aj = new _ajax(WEBROOT + "/ajax/filter-chapter.php" , "post",p, function(){_waitApplyFilter()},  function(r){_responseApplyFilter(r)});
	aj._query();
}
_waitApplyFilter = function(){  
	document.getElementById("columdiv").innerHTML = "<img src=\"" + WEBROOT + "/images/image.gif\" style=\"left:54%;top:50%;position:absolute;\" id=\"imgajax\">";
}

_responseApplyFilter = function(resp){
		
		var disp = resp;
		var regspl = disp.split("#/#");
		if(regspl[0] != "" && regspl[0] == 1){
			document.getElementById("columdiv").innerHTML = regspl[1];
		}
		if (regspl[2] == 1){
			document.getElementById("showmore").innerHTML = "";
			document.getElementById('showmore').innerHTML = "<a href='javascript:void(0);' onclick='javascript: _loadMore(" + regspl[3] + "," + regspl[4] + ")'>SHOW MORE</a>";
		}
		if (regspl[4] != ""){
			document.getElementById("showmore").innerHTML = "";
			document.getElementById('showmore').innerHTML = "<a href='javascript:void(0);' onclick='javascript: _loadMore(" + regspl[3] + "," + regspl[4] + ")'>SHOW MORE</a>";
		}
		if (regspl[5] == 0){
			document.getElementById("showmore").style.display = "none";
			//document.getElementById('showmore').innerHTML = "<a href='javascript:void(0);' onclick='javascript: _loadMore(" + regspl[3] + "," + regspl[4] + ")'>SHOW MORE</a>";
		}
		if(regspl[0] != "" && regspl[0] == 0){
			document.getElementById("columdiv").innerHTML = "<H3 style='margin:100px 0px 0px 300px'>No resource found</H3>";		
		}
		
}
//---------filter topic----------
_createFilterTopic = function(type, value, id, currID, chpID){
	var iF = -1;
	for(c = 0; c < p.length; c++){
		if(p[c][0] == type){
			iF = c;
			break;
		}
	}
	if(document.getElementById(id)){
		var cObj = document.getElementById(id);
		switch(cObj.type){
			case "checkbox":
				var objName = cObj.name;
				var allObj = document.getElementsByName(objName);
				var strVal = "";
				for(c = 0; c < allObj.length; c++){
					if(allObj[c].checked == true)
						strVal += strVal == "" ? allObj[c].value : "," + allObj[c].value;
				}
				if(strVal != ""){
					if(iF <= -1)
						p.push(new Array(type, strVal));
					else{
						p[iF][1] = strVal;
					}
				}
				else
					p.splice(iF, 1);
			break;
			case "select-one":
				p.push(new Array(type, value));
			break;
		}
	}
	_applyFilterTopic(currID,chpID);
};
_applyFilterTopic = function(currID ,chpID){
         var aj = new _ajax(WEBROOT + "/ajax/filter-topic.php?currID=" + currID + "&chpID=" + chpID , "post",p, function(){_waitApplyFilterTopic()},  function(r){_responseApplyFilterTopic(r)});
         aj._query();
}
_waitApplyFilterTopic = function(){
         document.getElementById("columdiv").innerHTML = "<img src=\"" + WEBROOT + "/images/image.gif\" style=\"left:54%;top:50%;position:absolute;\" id=\"imgajax\">";
}

_responseApplyFilterTopic = function(resp){
		 document.getElementById("columdiv").innerHTML = "";
                
         var disp = resp;
         var regspl = disp.split("#/#");
          //alert("0: " + regspl[0] + "1: " + regspl[1] + "2: "+ regspl[2] + "3: "+ regspl[3] +  "4: " + regspl[4] + "5 :" +  regspl[5]);
         if(regspl[0] != "" && regspl[0] == 1){
                 document.getElementById("columdiv").innerHTML = regspl[1].replace(/\|\!\|/g,'"');
         }
         if (regspl[2] ==1){
                  document.getElementById("showmoretopic").innerHTML = "";
                  document.getElementById('showmoretopic').innerHTML = "<a href='javascript:void(0);' onclick='javascript: _loadMoreTopic(" + regspl[3] + "," + regspl[4] + "," + regspl[6] + ")'>SHOW MORE</a>";
         }
         else
            document.getElementById("showmoretopic").style.display = "none";
         if (regspl[4] != ""){
                  document.getElementById("showmoretopic").innerHTML = "";
                  document.getElementById('showmoretopic').innerHTML = "<a href='javascript:void(0);' onclick='javascript: _loadMoreTopic(" + regspl[3] + "," + regspl[4] + "," + regspl[6] + ")'>SHOW MORE</a>";
         }
	if (regspl[5] == 0)
                  document.getElementById("showmoretopic").style.display = "none";
	if (regspl[4] == 0)
                  document.getElementById("showmoretopic").style.display = "none";
         if(regspl[0] != "" && regspl[0] == 0){
                 document.getElementById("dimension").innerHTML = "<H3 style='margin:100px 0px 0px 300px'>No resource found</H3>";
         }
         
}

//-------filetr for resource--------

_createFilterResource= function(type, value, id, tpID, currID, chpID){
	var iF = -1;
	for(c = 0; c < p.length; c++){
		if(p[c][0] == type){
			iF = c;
			break;
		}
	}
	if(document.getElementById(id)){
		var cObj = document.getElementById(id);
		switch(cObj.type){
			case "checkbox":
				var objName = cObj.name;
				var allObj = document.getElementsByName(objName);
				var strVal = "";
				for(c = 0; c < allObj.length; c++){
					if(allObj[c].checked == true)
						strVal += strVal == "" ? allObj[c].value : "," + allObj[c].value;
				}
				if(strVal != ""){
					if(iF <= -1)
						p.push(new Array(type, strVal));
					else{
						p[iF][1] = strVal;
					}
				}
				else
					p.splice(iF, 1);
			break;
			case "select-one":
				p.push(new Array(type, value));
			break;
		}
	}
	_applyFilterResource(tpID, currID,chpID);
};
_applyFilterResource = function(tpID, currID,chpID){
         var aj = new _ajax(WEBROOT + "/ajax/resource-filter.php?currID=" + currID + "&chpID=" + chpID +"&tpID=" + tpID , "post",p, function(){_waitApplyFilterResource()},  function(r){_responseApplyFilterResource(r)});
         aj._query();
}
_waitApplyFilterResource = function(){  
         document.getElementById("dimension").innerHTML = "<img src=\"" + WEBROOT + "/images/image.gif\" style=\"left:60%;top:50%;position:absolute;\" id=\"imgajax\">";
}

_responseApplyFilterResource = function(resp){
         document.getElementById("dimension"). innerHTML = "";
         var disp = resp;
         var regspl = disp.split("#/#");
         if(regspl[0] != "" && regspl[0] == 1){
                 document.getElementById("dimension").innerHTML = regspl[1].replace(/\|\!\|/g,'"');
         }
         if(regspl[0] != "" && regspl[0] == 0){
                 document.getElementById("dimension").innerHTML = "<H3 style='margin:100px 0px 0px 300px'>No resource found</H3>";
         }
}

var udCounter = -1;
var maxCounter = 9;
_search = function(ev, v){
	var search = v;
	var kc;
		if(window.event)
			kc = ev.keyCode; 
		else if(ev.which)
			kc = ev.which;
		if(kc == 38)
		 {
			if(udCounter > -1)
				udCounter--;
			else
				udCounter = maxCounter;
		 }
		 else if(kc == 40)
		 {
			 if(udCounter < maxCounter)
				udCounter++;
			 else
				 udCounter = 0;
		 }
		 for(i = 0; i <= maxCounter; i++)
		 {
			 if(document.getElementById("an" + i))
				document.getElementById("an" + i).className = "setText";
		 }
		 if(document.getElementById("an" + udCounter))
		 {
			 document.getElementById("an" + udCounter).className = "selText";
		 }
		if((kc >= 65 && kc <= 90) || kc == 8 || kc == 46)
		 {
			if(search.length >= 1)
			 {
				var p = new Array();
				p[0] = new Array("search", search);
				var aj = new _ajax("ajax/search-text.php", "post",p,function(){_waitsearch()},function(r){_responsesearch(r)});
				aj._query();
			 }else
			 {
				document.getElementById("hddnsearchtext").innerHTML = "";
				document.getElementById("hddnsearchtext").style.display = "none";
			 }

		 }else if(kc == 13) {
			 if(document.getElementById("an" + udCounter))
				document.getElementById("txtsearch").value = document.getElementById("an" + udCounter).innerHTML;
			 document.getElementById("hddnsearchtext").innerHTML = "";
			 document.getElementById("hddnsearchtext").style.display = "none";
		 }
}
_waitsearch = function(){
		document.getElementById("hddnsearchtext").style.display = "block";
		document.getElementById("hddnsearchtext").innerHTML = "Please wait...";
}
_responsesearch = function(resp){
		document.getElementById("hddnsearchtext").innerHTML = "";
		var disp = resp.split("#/#");
		if(disp[0] != "" && disp[0] == 1){
			document.getElementById("hddnsearchtext").style.display = "block";

			var sch = disp[1].split("##");
			if(disp[1] != ""){
				for(var i = 0;i<sch.length;i++){
				    document.getElementById("hddnsearchtext").innerHTML += "<a href='javascript:void(0);' id=\"an" + i + "\" class='schacnkrhover' onclick=\"javascript: _setTxtValue('" + sch[i] + "')\">" + sch[i] + "</a>";	
				}
			}else
				document.getElementById("hddnsearchtext").style.display = "none";
		}else
			document.getElementById("hddnsearchtext").innerHTML = "<H4 style='margin:3px 0px 0px 5px'>Chapter not found</H4>";
}


_setTxtValue = function(txt){
	   document.getElementById("txtsearch").value = txt;
	   document.getElementById("hddnsearchtext").innerHTML = "";
	   document.getElementById("hddnsearchtext").style.display = "none";
};

_searchresult = function(){
	var txtsearch = document.getElementById('txtsearch').value;
	window.location = "./search.php?q=" + txtsearch; 
}

_createSearchFilter = function(type, value, id, catid){
	var iF = -1;
	for(c = 0; c < p.length; c++){
		if(p[c][0] == type){
			iF = c;
			break;
		}
	}
	if(document.getElementById(id)){
		var cObj = document.getElementById(id);
		switch(cObj.type){
			case "checkbox":
				var objName = cObj.name;
				var allObj = document.getElementsByName(objName);
				var strVal = "";
				for(c = 0; c < allObj.length; c++){
					if(allObj[c].checked == true)
						strVal += strVal == "" ? allObj[c].value : "," + allObj[c].value;
				}
				if(strVal != ""){
					if(iF <= -1)
						p.push(new Array(type, strVal));
					else{
						p[iF][1] = strVal;
					}
				}
				else
					p.splice(iF, 1);
			break;
			case "select-one":
				p.push(new Array(type, value));
			break;
		}
	}
	_applySearchFilter(catid);
};
_applySearchFilter = function(catid){
		var aj = new _ajax(WEBROOT + "/ajax/filter-search.php?q=" + catid , "post",p,function(){_waitApplysearchFilter},function(r){_responseApplysearchFilter(r)});
		aj._query();
}
_waitApplysearchFilter = function(){
		document.getElementById("dimensionresource").innerHTML = "<img src=\"" + WEBROOT + "/images/image.gif\" style=\"left:60%;top:50%;position:absolute;\" id=\"imgajax\">";
}
_responseApplysearchFilter = function(resp){
		document.getElementById("dimensionresource").innerHTML = "";
		var disp = resp;
		var regspl = disp.split("#/#");
		if(regspl[0] != "" && regspl[0] == 1){
			document.getElementById("dimensionresource").innerHTML = regspl[1];
		}
		if(regspl[0] != "" && regspl[0] == 0){
			document.getElementById("dimensionresource").innerHTML = "<H3 style='margin:100px 0px 0px 300px'>No resource found</H3>";
		}
}


//search for topic


_searchTopic = function(ev, v){
	var searchTopic = v;
	var kc;
		if(window.event)
			kc = ev.keyCode; 
		else if(ev.which)
			kc = ev.which;
		if(kc == 38)
		 {
			if(udCounter > -1)
				udCounter--;
			else
				udCounter = maxCounter;
		 }
		 else if(kc == 40)
		 {
			 if(udCounter < maxCounter)
				udCounter++;
			 else
				 udCounter = 0;
		 }
		 for(i = 0; i <= maxCounter; i++)
		 {
			 if(document.getElementById("an" + i))
				document.getElementById("an" + i).className = "setText";
		 }
		 if(document.getElementById("an" + udCounter))
		 {
			 document.getElementById("an" + udCounter).className = "selText";
		 }
		if((kc >= 65 && kc <= 90) || kc == 8 || kc == 46)
		 {
			if(searchTopic.length >= 1)
			 {
				var p = new Array();
				p[0] = new Array("searchTopic", searchTopic);
				var aj = new _ajax("ajax/search-text.php", "post",p,function(){_waitsearchTopic()},function(r){_responsesearchTopic(r)});
				aj._query();
			 }else
			 {
				document.getElementById("hddnsearchtext").innerHTML = "";
				document.getElementById("hddnsearchtext").style.display = "none";
			 }

		 }else if(kc == 13) {
			 if(document.getElementById("an" + udCounter))
				document.getElementById("txtsearch").value = document.getElementById("an" + udCounter).innerHTML;
			 document.getElementById("hddnsearchtext").innerHTML = "";
			 document.getElementById("hddnsearchtext").style.display = "none";
		 }
}
_waitsearchTopic = function(){
		document.getElementById("hddnsearchtext").style.display = "block";
		document.getElementById("hddnsearchtext").innerHTML = "Please wait...";
}
_responsesearchTopic = function(resp){
		document.getElementById("hddnsearchtext").innerHTML = "";
		var disp = resp.split("#/#");
		if(disp[0] != "" && disp[0] == 1){
			document.getElementById("hddnsearchtext").style.display = "block";

			var sch = disp[1].split("##");
			if(disp[1] != ""){
				for(var i = 0;i<sch.length;i++){
				    document.getElementById("hddnsearchtext").innerHTML += "<a href='javascript:void(0);' id=\"an" + i + "\" class='schacnkrhover' onclick=\"javascript: _setTxtValueTopic('" + sch[i] + "')\">" + sch[i] + "</a>";	
				}
			}else
				document.getElementById("hddnsearchtext").style.display = "none";
		}else
			document.getElementById("hddnsearchtext").innerHTML = "<H4 style='margin:3px 0px 0px 5px'>Topic not found</H4>";
}


_setTxtValueTopic = function(txt){
	   document.getElementById("txtsearch").value = txt;
	   document.getElementById("hddnsearchtext").innerHTML = "";
	   document.getElementById("hddnsearchtext").style.display = "none";
};

       



_searchresultTopic = function(){
	var txtsearch = document.getElementById('txtsearch').value;
	window.location = "./search-topic.php?q=" + txtsearch; 
}

_createSearchFilterTopic = function(type, value, id, catid){
	var iF = -1;
	for(c = 0; c < p.length; c++){
		if(p[c][0] == type){
			iF = c;
			break;
		}
	}
	if(document.getElementById(id)){
		var cObj = document.getElementById(id);
		switch(cObj.type){
			case "checkbox":
				var objName = cObj.name;
				var allObj = document.getElementsByName(objName);
				var strVal = "";
				for(c = 0; c < allObj.length; c++){
					if(allObj[c].checked == true)
						strVal += strVal == "" ? allObj[c].value : "," + allObj[c].value;
				}
				if(strVal != ""){
					if(iF <= -1)
						p.push(new Array(type, strVal));
					else{
						p[iF][1] = strVal;
					}
				}
				else
					p.splice(iF, 1);
			break;
			case "select-one":
				p.push(new Array(type, value));
			break;
		}
	}
	_applySearchFilterTopic(catid);
};
_applySearchFilterTopic = function(catid){
		var aj = new _ajax(WEBROOT + "/ajax/filter-search-topic.php?q=" + catid , "post",p,function(){_waitApplysearchFilterTopic},function(r){_responseApplysearchFilterTopic(r)});
		aj._query();
}
_waitApplysearchFilterTopic = function(){
		document.getElementById("dimensionresource").innerHTML = "<img src=\"" + WEBROOT + "/image/image.gif\" style=\"left:60%;top:50%;position:absolute;\" id=\"imgajax\">";
}
_responseApplysearchFilterTopic = function(resp){
		document.getElementById("dimensionresource").innerHTML = "";
		var disp = resp;
		var regspl = disp.split("#/#");
		if(regspl[0] != "" && regspl[0] == 1){
			document.getElementById("dimensionresource").innerHTML = regspl[1];
                        document.getElementById("dimensionresource").innerHTML = regspl[1].replace(/\|\!\|/g,'"');
		}
		if(regspl[0] != "" && regspl[0] == 0){
			document.getElementById("dimensionresource").innerHTML = "<H3 style='margin:100px 0px 0px 300px'>No resource found</H3>";
		}
}


//--------Filter for lessontime---------


_createFilterLesson= function(type,id){

	var iF = -1;
	for(c = 0; c < p.length; c++){
		if(p[c][0] == type){
			iF = c;
			break;
		}
	}
	if(document.getElementById(id)){
		var cObj = document.getElementById(id);
		switch(cObj.type){
			case "checkbox":
				var objName = cObj.name;
				var allObj = document.getElementsByName(objName);
				var strVal = "";
				for(c = 0; c < allObj.length; c++){
					if(allObj[c].checked == true)
						strVal += strVal == "" ? allObj[c].value : "," + allObj[c].value;
				}
				if(strVal != ""){
					if(iF <= -1)
						p.push(new Array(type, strVal));
					else{
						p[iF][1] = strVal;
					}
				}
				else
					p.splice(iF, 1);
			break;
			case "select-one":
				p.push(new Array(type, value));
			break;
		}
	}
	_applyFilterLesson(currID);
};
_applyFilterLesson = function(currID){
         var aj = new _ajax(WEBROOT + "/ajax/filter-chapter.php?currID=" + currID , "post",p, function(){_waitApplyFilterLesson()},  function(r){_responseApplyFilterLesson(r)});
         aj._query();
}
_waitApplyFilterLesson = function(){  
         document.getElementById("dimension").innerHTML = "<img src=\"" + WEBROOT + "/images/image.gif\" style=\"left:60%;top:50%;position:absolute;\" id=\"imgajax\">";
}

_responseApplyFilterLesson = function(resp){
         document.getElementById("dimension"). innerHTML = "";
         var disp = resp;
         var regspl = disp.split("#/#");
         if(regspl[0] != "" && regspl[0] == 1){
                 document.getElementById("dimension").innerHTML = regspl[1].replace(/\|\!\|/g,'"');
         }
         if(regspl[0] != "" && regspl[0] == 0){
                 document.getElementById("dimension").innerHTML = "<H3 style='margin:100px 0px 0px 300px'>No resource found</H3>";
         }
}

//---------load more---------

_loadMore = function(currID,maxid){
         var id = currID;	
         var p = new Array();
         p[0] = new Array("chkcurriculum", currID);
         p[1] = new Array("maxid", maxid);
         var aj = new _ajax(WEBROOT + "/ajax/filter-chapter.php?currID=" + currID , "post",p,function(){_waitGetrespLoad()}, function(r){_responseGetrespLoad(r)});
         aj._query();
}
_waitGetrespLoad = function()
{
    document.getElementById('showmore').innerHTML = "";
	document.getElementById('showmore').innerHTML = "<H3 style='margin:0px 0px 0px 300px'>Loading more Chapters...</H3><img src=\"" + WEBROOT + "/images/image.gif\" style=\"left:50%;top:70%;position:relative;\" id=\"imgajax\">";
};
_responseGetrespLoad = function(resp)
{
	var respons = resp;
	var splitres = respons.split("#/#");
	if(splitres[1] != ""){
		if(document.getElementById('columdiv'))               
		document.getElementById('columdiv').innerHTML += splitres[1];
	}
	else
                  document.getElementById('showmore').style.display = "none";
        if (splitres[4] != ""){
                  document.getElementById("showmore").innerHTML = "";
                  document.getElementById('showmore').innerHTML = "<a href='javascript:void(0);' onclick='javascript: _loadMore(" + splitres[3] + "," + splitres[4] + ")'>SHOW MORE</a>";
        }
        else
                  document.getElementById('showmore').style.display = "none";
         
         
         if (splitres[5] == 1){
                  document.getElementById("showmore").innerHTML = "";
                  document.getElementById('showmore').innerHTML = "<a href='javascript:void(0);' onclick='javascript: _loadMore(" + splitres[3] + "," + splitres[4] + ")'>SHOW MORE</a>";
        }
        else
                  document.getElementById('showmore').style.display = "none";
};

_loadMoreTopic = function(currID,maxtpid,chpID){
         var id = currID;	
         var p = new Array();
         p[0] = new Array("chkcurriculum", currID);
         p[1] = new Array("maxtpid", maxtpid);
         p[2] = new Array("chpID", chpID);
         var aj = new _ajax(WEBROOT + "/ajax/filter-topic.php?currID=" + currID + "&chpID=" + chpID , "post",p,function(){_waitGetrespLoadTopic()}, function(r){_responseGetrespLoadTopic(r)});
         aj._query();
}
_waitGetrespLoadTopic = function()
{
         document.getElementById('showmoretopic').innerHTML = "";
	document.getElementById('showmoretopic').innerHTML = "<H3 style='margin:0px 0px 0px 300px'>Loading more Chapters...</H3><img src=\"" + WEBROOT + "/images/image.gif\" style=\"left:54%;top:70%;position:relative;\" id=\"imgajax\">";
};
_responseGetrespLoadTopic = function(resp)
{
	var respons = resp;
	var splitres = respons.split("#/#");
	if(splitres[1] != ""){
		if(document.getElementById('columdiv'))               
		document.getElementById('columdiv').innerHTML += splitres[1];
	}
	else
                  document.getElementById('showmoretopic').style.display = "none";
        if (splitres[4] != ""){
                  document.getElementById("showmoretopic").innerHTML = "";
                  document.getElementById('showmoretopic').innerHTML = "<a href='javascript:void(0);' onclick='javascript: _loadMoreTopic(" + splitres[3] + "," + splitres[4] + "," + splitres[6] + ")'>SHOW MORE</a>";
        }
        else
            document.getElementById('showmoretopic').style.display = "none";
        if (splitres[5] == 1){
			document.getElementById("showmoretopic").innerHTML = "";
			document.getElementById('showmoretopic').innerHTML = "<a href='javascript:void(0);' onclick='javascript: _loadMoreTopic(" + splitres[3] + "," + splitres[4] + "," + splitres[6] + ")'>SHOW MORE</a>";
        }
        else
            document.getElementById('showmoretopic').style.display = "none";
};

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

_setTopicID = function(tpID)
{
    document.getElementById("hdTopicID").value = tpID;
}
_searchdata = function()
{
	//var cType = document.getElementById('ddlType').options[document.getElementById('ddlType').selectedIndex].value;
	var srcQ = document.getElementById('textsearch').value;
	if (srcQ != "") {
		var p = new Array();
		//p.push(new Array("ddlType", cType));
		p.push(new Array("textsearch", srcQ));
		var aj = new _ajax(WEBROOT + "/ajax/searchdata.php", "post",p,function(){_waitSearchdata()}, function(r){_responseSearchdata(r)});
		aj._query();
		//document.getElementById('ddlType').disabled = true;
		document.getElementById('search').disabled = true;
		document.getElementById('textsearch').disabled = true;
	}
	return false;
}
_waitSearchdata = function()
{
	document.getElementById("columdiv").innerHTML = "<img src=\"" + WEBROOT + "/images/image.gif\" style=\"left:50%;top:70%;position:relative;\" id=\"imgajax\">";
};
_responseSearchdata = function(resp)
{
	document.getElementById('columdiv').innerHTML = "";
	document.getElementById('columdiv').style.display = 'block';
	document.getElementById('textsearch').disabled = false;

	if(resp != "")
		document.getElementById('columdiv').innerHTML += resp;
	else
		document.getElementById('columdiv').innerHTML = "No Data Found";
};

_chkEntersearch = function(ev) {
	var kc = null;
	if (window.event)
		kc = window.event.keyCode;
	else if (ev)
		kc = ev.which;
	if (kc == 13)
	_searchdata();
}

