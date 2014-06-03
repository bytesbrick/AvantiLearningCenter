var chkCounter = 0;
_showtopic = function(cid)
{
	document.getElementById('ddlcategory').style.display = 'block';
	var p = new Array();
	p[0] = new Array("unique_id", cid);
	var aj = new _ajax("./ajax/chapter-select.php", "post",p,function(){_waitGetTopics()}, function(r){_responseGetTopics(r)});
	aj._query();
}
_waitGetTopics = function()
{
	document.getElementById("loadchapters").innerHTML = "<img src=\"./images/loading.gif\" width=\"20px\" style=\"left:69.5%;top:26.2%;position:absolute;z-index:1001;\" id=\"imgajax\">";
};
_responseGetTopics = function(resp)
{
	document.getElementById('ddlchapter').innerHTML = "";
	document.getElementById('ddlchapter').style.display = 'block';
	document.getElementById("loadchapters").innerHTML = "";
	
	resps = resp.split("|#|");
	html = resps[0];
	category_name = resps[1];
	chapter_code = resps[2];
	topic_code = resps[3];
	if (resp == "") {
		document.getElementById('ddlchapter').innerHTML += html;
	}
	if (resp[2] == "") {
		document.getElementById('txtchaptercode').innerHTML += html;
	}
	if (resp[3] == "") {
		document.getElementById('txttopiccode').innerHTML += html;
	}
	if(resp != "" && resp != "Invalid Topic")
	{
		document.getElementById('ddlchapter').innerHTML += html;
	}	
	document.getElementById('ddlchapter').value = resps[1];
	if(resp != "" && resp != "Invalid Chapter Code")
	{
		document.getElementById('txtchaptercode').innerHTML += html;
	}	
	//document.getElementById('txtchaptercode').value = resps[1];
	//document.getElementById('CodeChapter').innerHTML = resps[1];
	
	if(resps[2] != "" && resps[2] != "Invalid Topic Code")
	{
		document.getElementById('txttopiccode').innerHTML += html;
	}	
	//document.getElementById('txttopiccode').value = resps[2];
	//document.getElementById('CodeTopic').innerHTML = resps[2];
};


_showchapter = function(cid)
{
	document.getElementById('ddlchapter').style.display = 'block';
	var p = new Array();
	p[0] = new Array("unique_id", cid);
	var aj = new _ajax("./ajax/get-chapter.php", "post",p,function(){_waitGetchapter()}, function(r){_responseGetchapter(r)});
	aj._query();
}
_waitGetchapter = function()
{
	//document.getElementById('ddlchapter').style.color = "#333333";
	//document.getElementById('ddlchapter').style.display = 'block';
	document.getElementById("loadchapters").innerHTML = "<img src=\"./images/loading.gif\" width=\"20px\" style=\"left:69.5%;top:26.3%;;position:absolute;z-index:1001;\" id=\"imgajax\">";
};
_responseGetchapter = function(resp)
{
	document.getElementById("loadchapters").innerHTML  = "";
	document.getElementById('txtchaptercode').style.display = 'block';
	
	resps = resp.split("|#|");
	html = resps[0];
	chapter_code = resps[1];
	topic_code = resps[2];
	if(resp != "" && resp != "Invalid Chapter Code")
	{
		document.getElementById('txtchaptercode').innerHTML += html;
	}	
	document.getElementById('txtchaptercode').value = resps[1];
	document.getElementById('CodeChapter').value = resps[1];
	
	if(resps[2] != "" && resps[2] != "Invalid Topic Code")
	{
		document.getElementById('txttopiccode').innerHTML += html;
	}	
	document.getElementById('txttopiccode').value = resps[2];
	document.getElementById('CodeTopic').value = resps[2];
};

_gettopics = function(cid)
{
	document.getElementById('ddlchapter').style.display = 'block';
	var p = new Array();
	p[0] = new Array("unique_id", cid);
	var aj = new _ajax("./ajax/get-topics.php", "post",p,function(){_waitGetTopic()}, function(r){_responseGetTopic(r)});
	aj._query();
}
_waitGetTopic = function()
{
	//document.getElementById('ddltopic').style.color = "#333333";
	//document.getElementById('ddltopic').style.display = 'block';
	//document.getElementById("loadchapters").innerHTML = "<img src=\"./images/loading.gif\" width=\"20px\" style=\"left:35%;top:35.3%;position:absolute;z-index:1001;\" id=\"imgajax\">";
};
_responseGetTopic = function(resp)
{
	document.getElementById('loadchapters').innerHTML = "";
	document.getElementById('ddltopic').innerHTML = "";
	document.getElementById('ddltopic').style.display = 'block';
	
	resps = resp.split("|#|");
	html = resps[0];
	category_name = resps[1];
	if(resp != "" && resp != "Invalid Topic")
	{
		document.getElementById('ddltopic').innerHTML += html;
	}	
	document.getElementById('ddltopic').value = resps[1];
};


_getsearchdata = function()
{
	var cType = document.getElementById('ddlType').options[document.getElementById('ddlType').selectedIndex].value;
	var srcQ = document.getElementById('txtsearch').value;
	if (srcQ != "") {
		var p = new Array();
		p.push(new Array("ddlType", cType));
		p.push(new Array("txtsearch", srcQ));
		var aj = new _ajax("./ajax/getsearchdata.php", "post",p,function(){_waitGetSearchdata()}, function(r){_responseGetSearchdata(r)});
		aj._query();
		document.getElementById('ddlType').disabled = true;
		document.getElementById('txtsearch').disabled = true;
	}
	return false;
}
_waitGetSearchdata = function()
{
	document.getElementById("searchData").innerHTML = "<img src=\"./images/loading.gif\" width=\"20px\" style=\"left:85%;top:35.3%;position:absolute;z-index:1001;\" id=\"imgajax\">";
};
_responseGetSearchdata = function(resp)
{
	document.getElementById('searchData').innerHTML = "";
	document.getElementById('searchData').style.display = 'block';
	document.getElementById('ddlType').disabled = false;
	document.getElementById('txtsearch').disabled = false;

	if(resp != "")
		document.getElementById('searchData').innerHTML += resp;
	else
		document.getElementById('searchData').innerHTML = "No Data Found";
};

_getchaptercode = function(ddlcategory){
	var p = new Array();
	p.push(new Array("unique_id", ddlcategory));
	var aj = new _ajax("./ajax/getchaptercode.php", "post",p,function(){_waitGetchaptercode()}, function(r){_responseGetchaptercode(r)});
	aj._query();
}
_waitGetchaptercode = function(){
	document.getElementById("getchpcode").innerHTML = "<img src=\"./images/loading.gif\" width=\"20px\" style=\"left:32%;top:32.3%;position:absolute;z-index:1001;\" id=\"imgajax\">";
}
_responseGetchaptercode = function(resp){
	document.getElementById('chaptercode').innerHTML = "";
	document.getElementById("getchpcode").innerHTML = "";
	document.getElementById('chaptercode').style.display = 'block';
	if(resp != ""){
		document.getElementById('chaptercode').value = resp;
		document.getElementById('txtChaptercode').value = resp;
	}
	else
		document.getElementById('chaptercode').innerHTML = "No Data Found";
}

//----------------to add test---------

_addTest = function(tpid,action){
	var p = new Array();
	p.push(new Array("topicid", tpid));
	p.push(new Array("action", action));
	var aj = new _ajax("./ajax/add-test.php" , "post",p,function(){_waitAddTest()}, function(r){_responseAddTest(r)});
	aj._query();
}
_waitAddTest = function()
{
	document.getElementById('ErrMsg').style.display = "block";
	document.getElementById('ErrMsg').innerHTML = "Please wait while system is adding this test...";
};
_responseAddTest = function(r)
{
	if (parseInt(r) == 1) {
		document.getElementById('ErrMsg').style.display = "block";
		document.getElementById('ErrMsg').innerHTML = "This test is successfully added.";
		document.location.reload(true);	
	}
	else if (parseInt(r) == 0) {
		document.getElementById('ErrMsg').style.display = "block";
		document.getElementById('ErrMsg').innerHTML = "SORRY! This test could not be added.";
	}
};

//_deletequestion = function(uId,resid,topicid,type){
//	var cnf = false;
//	cnf = confirm("Are you sure you want to delete this question?");
//	if (cnf) {
//		cnf = confirm("Just to remind you that deleted question could not be retrieved.\nDO YOU STILL WANT TO CONTINUE?");
//		if (cnf) {
//			var p = new Array();
//			p.push(new Array("uniqueid", uId));
//			p.push(new Array("resid", resid));
//			p.push(new Array("topicid", topicid));
//			p.push(new Array("type", type));
//			var aj = new _ajax("./ajax/delete-spot-test.php" , "post",p,function(){_waitDeletequestion()}, function(r){_responseDeletequestion(r)});
//			aj._query();	
//		}
//	}
//}


_getcenter = function(cid)
{
	document.getElementById('ddlcity').style.display = 'block';
	if (document.getElementById('txtbatchid'))
	document.getElementById('txtbatchid').value = "";	
	var p = new Array();
	p[0] = new Array("unique_id", cid);
	var aj = new _ajax("./ajax/get-centers.php", "post",p,function(){_waitGetCenter()}, function(r){_responseGetCenter(r)});
	aj._query();	
}
_waitGetCenter = function()
{
	document.getElementById('ddlcenter').innerHTML = "<option value=''>Please wait...</option>";
};
_responseGetCenter = function(resp)
{
	document.getElementById('loadcenters').innerHTML = "";
	document.getElementById('ddlcenter').innerHTML = "";
	document.getElementById('ddlcenter').style.display = 'block';
	
	resps = resp.split("|#|");
	html = resps[0];
	category_name = resps[1];
	if(resp != "" && resp != "Invalid Center")
		document.getElementById('ddlcenter').innerHTML += html;
};

_createStudentId = function(cid)
{
	var p = new Array();
	p[0] = new Array("unique_id", cid);
	var aj = new _ajax("./ajax/createstudentid.php", "post",p,function(){_waitGetcreatestudentId()}, function(r){_responsecreatestudentId(r)});
	aj._query();
}
_waitGetcreatestudentId = function()
{
	document.getElementById('txtstudentID').value = "Please wait...";
};
_responsecreatestudentId = function(resp)
{
	
	resps = resp.split("|#|");
	document.getElementById('txtstudentID').innerHTML = "";
	document.getElementById('txtstudentID').style.display = 'block';
	if(resps[0] != "" && resps[0] == 1)
	{
		document.getElementById('txtstudentID').value =  resps[1];
	}
	else{
		document.getElementById('txtstudentID').value =  "Student Id cound not be created";
	}
};
_createBatchId = function(cid)
{
	if (cid != "") {
		var p = new Array();
		p[0] = new Array("unique_id", cid);
		var aj = new _ajax("./ajax/createbatchid.php", "post",p,function(){_waitGetcreateBatchId()}, function(r){_responsecreateBatchId(r)});
		aj._query();	
	} else {
		document.getElementById('txtbatchid').value = "";
	}
	
}
_waitGetcreateBatchId = function()
{
	document.getElementById('txtbatchid').value = "Please wait...";
};
_responsecreateBatchId = function(resp)
{
	
	resps = resp.split("|#|");
	document.getElementById('txtbatchid').value = "";
	document.getElementById('txtbatchid').style.display = 'block';
	if(resps[0] != "" && resps[0] == 1)
	{
		document.getElementById('txtbatchid').value =  resps[1];
	}
	else{
		document.getElementById('txtbatchid').value =  "Batch ID cound not be created";
	}
};

_assignChapter = function(batch_id)
{
	if (batch_id != "") {
		document.getElementById('TabheadingBatch').innerHTML = "";
		var p = new Array();
		p[0] = new Array("batch_id", batch_id);
		var aj = new _ajax("./ajax/select-batch.php", "post",p,function(){_waitAssignChapter()}, function(r){_responseAssignChapter(r)});
		aj._query();	
	} else {
		document.getElementById('txtbatchid').value = "";
	}
}
_waitAssignChapter = function()
{
	document.getElementById('TabheadingBatch').innerHTML = "Please wait...";
};
_responseAssignChapter = function(resp)
{
	resps = resp.split("|#|");
	var html = resps[1];
	document.getElementById('TabheadingBatch').value = "";
	document.getElementById('TabheadingBatch').style.display = 'block';
	if(resps[0] != "" && resps[0] >= 0)
	{
		document.getElementById('TabheadingBatch').innerHTML =  html;
		chkCounter = resps[0];
	}
};
_batchchapters = function (batch_id, subject_id){
	if (batch_id != "") {
		if (subject_id != "0") {
			document.getElementById('TabheadingBatch').innerHTML = "";
			var p = new Array();
			p[0] = new Array("batch_id", batch_id);
			p[1] = new Array("subject_id", subject_id);
			var aj = new _ajax("./ajax/select-batch.php", "post",p,function(){_waitGetbatchchapters()}, function(r){_responsebatchchapters(r)});
			aj._query();	
		} else
		_assignChapter(batch_id);
	} 
}
_waitGetbatchchapters = function()
{
	document.getElementById('TabheadingBatch').innerHTML = "Please wait...";
};
_responsebatchchapters = function(resp)
{
	resps = resp.split("|#|");
	var html = resps[1];
	document.getElementById('TabheadingBatch').value = "";
	document.getElementById('TabheadingBatch').style.display = 'block';
	if(resps[0] != "" && resps[0] >= 0)
	{
		document.getElementById('TabheadingBatch').innerHTML =  html;
		chkCounter = resps[0];
	}
};