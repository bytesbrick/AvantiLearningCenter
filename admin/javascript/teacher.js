_getTeacherTable = function(page,sf,sd){
    var p = new Array();
    p.push(new Array("page", page));
    p.push(new Array("sf", sf));
    p.push(new Array("sd", sd));
    var aj = new _ajax("./ajax/get-teacher-table.php", "post",p,function(){_waitGetTeacherTable()}, function(r){_responseGetTeacherTable(r)});
    aj._query();
}
_waitGetTeacherTable = function(){
    document.getElementById('disableDiv').style.height = _getHeight('displayUser') + 'px';
    document.getElementById('disableDiv').style.display = 'block';
}
_responseGetTeacherTable = function(r){
    document.getElementById('displayUser').innerHTML = r;
    document.getElementById('disableDiv').style.display = 'none';
    document.getElementById('disableText').innerHTML = "<br /><br /><img src=\"./images/avn-loader.gif\" /><br />Please wait while sorting is being done...";
}
cachedTableData = "";
_deleteteacher = function(uId,page){
    var cnf = false;
    cnf = confirm("Are you sure you want to delete this teacher?");
    if (cnf) {
        cnf = confirm("Just to remind you that deleted teacher could not be retrieved.\nDO YOU STILL WANT TO CONTINUE?");
        if (cnf) {
            var rID = 0;
            var tab = document.getElementById('tabTeacher');
            var userID = "";
            var chk = document.getElementsByName("chkTeacher[]");
            var chkCount = chk.length;
            if (uId > -1)
            document.getElementById('chk-' + uId).checked = true;
            for (i = 0; i < chkCount; i++){
                if(chk[i].checked == true){
                    userID += userID == "" ? chk[i].value : "," + chk[i].value;
                }
            }
            if (userID != "") {
                var p = new Array();
                p.push(new Array("uId", userID));
                p.push(new Array("page", page));
                var aj = new _ajax("./ajax/delete-teacher.php" , "post",p,function(){_waitdeleteteacher()}, function(r){_responsedeleteteacher(r)});
                aj._query(); 
            }   
        }
    }		
}

_waitdeleteteacher = function(){
    document.getElementById('disableDiv').style.height = _getHeight('displayUser') + 'px';
    document.getElementById('disableDiv').style.display = 'block';
    document.getElementById('disableText').innerHTML = "<br /><br /><img src=\"./images/avn-loader.gif\" /><br />Please wait while teacher is being deleted...";
}
_responsedeleteteacher = function(r){
    document.getElementById('disableDiv').style.display = 'none';
    if (r != "") {
        if (r.indexOf("|#|") > -1) {
            var resp = r.split("|#|");
            if (parseInt(resp[0]) == 1) {                
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Teacher deleted successfully.";
            }
            else if(parseInt(resp[0]) == 0) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "SORRY! teacher could not be deleted.";
            }
            else if(parseInt(resp[0]) == 3) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All/some of the teachers deleted successfully.";
            }
             else if(parseInt(resp[0]) == 4) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All/some of the Teachers not deleted successfully.";
            }
            document.getElementById('bulkAct').style.display = 'none';
            document.getElementById('bulkActive').style.display = 'none';
            _getTeacherTable(resp[1]);
        }
    }
}

_changeteacherstatus =  function(uId,action,page){
     _getHeight('displayUser');
    var userID = "";
    var chk = document.getElementsByName("chkTeacher[]");
    var chkCount = chk.length;
    if (uId > -1)
    document.getElementById('chk-' + uId).checked = true;
    for (i = 0; i < chkCount; i++){
        if(chk[i].checked == true){
            userID += userID == "" ? chk[i].value : "," + chk[i].value;
        }
    }
    if (userID != "") {
        var p = new Array();
        p.push(new Array("uniqueid", userID));
        p.push(new Array("page", page));
        p.push(new Array("action", action));
        var aj = new _ajax("./ajax/teacher-status.php" , "post",p,function(){_waitGetrespchngteacherstatus()}, function(r){_responseGetrespchngteacherstatus(r)});
        aj._query();    
    }
    
}
_waitGetrespchngteacherstatus = function()
{
    document.getElementById('disableDiv').style.height = _getHeight('displayUser') + 'px';
    document.getElementById('disableDiv').style.display = 'block';
    document.getElementById('disableText').innerHTML = "<br /><br /><img src=\"./images/avn-loader.gif\" /><br />Please wait while teacher's status is being updated...";
};
_responseGetrespchngteacherstatus = function(r)
{
    document.getElementById('disableDiv').style.display = 'none';
    if (r != "") {
        if (r.indexOf("|#|") > -1) {
            var resp = r.split("|#|");
            if (parseInt(resp[0]) == 1) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Teacher's status updated successfully.";
                
            }
            else if(parseInt(resp[0]) == 0) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "SORRY! teacher's status could not be updated.";
            }
            else if (parseInt(resp[0]) == 3) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All/some teacher's status updated successfully.";
            }
            else if(parseInt(resp[0]) == 4) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All/some teacher's status could not be updated.";
            }
            document.getElementById('bulkAct').style.display = 'none';
            document.getElementById('bulkActive').style.display = 'none';
             _getTeacherTable(resp[1]);
        }         
    }
};

_checked = function(c, rid){
    var chk = document.getElementsByName("chkTeacher[]");
    var chkCount = chk.length;
    var anyChecked = false;
    if (c.id == 'chpAll') {
        var m = false;
        if (c.checked == true){
            m = true;
            anyChecked = true;
        }
        for (i = 0; i < chkCount; i++)
            chk[i].checked = m;
        var tab = document.getElementById('tabTeacher');
        var rCount = tab.rows.length;
        if (m) {
            for (i = 1; i < rCount; i++)
                tab.rows[i].className = 'selectedRow';  
        } else {
            for (i = 1; i < rCount; i++){
                if (i % 2 == 0)
                tab.rows[i].className = 'darkyellow';
                else
                tab.rows[i].className = 'lightyellow';
            }
        }
        
    } else {
        if (c.checked == true) {
            document.getElementById('TeacherRow-' + rid).className = 'selectedRow';
        } else {
            if (rid % 2 == 0)
                document.getElementById('TeacherRow-' + rid).className = 'lightyellow';
            else
                document.getElementById('TeacherRow-' + rid).className = 'darkyellow';
        }
        var chkAll = document.getElementById("chpAll");
        var chkCounter = 0;
        for (i = 0; i < chkCount; i++) {
            if (chk[i].checked == true) {
                chkCounter++;
            }
        }
        if (chkCounter == chkCount) {
            chkAll.checked = true;
        } else {
            chkAll.checked = false;
        }
        if (chkCounter > 0)
        anyChecked = true;
    }
    if (anyChecked){
        document.getElementById('bulkAct').style.display = 'block';
        document.getElementById('bulkActive').style.display = 'block';
    }
    else{
        document.getElementById('bulkAct').style.display = 'none';
        document.getElementById('bulkActive').style.display = 'none';
    }
};

_batchAssigntoTeacher = function(city_id, teacher_id)
{
    if (teacher_id != "") {
        document.getElementById('TabheadingBatch').innerHTML = "";
        var p = new Array();
        p[0] = new Array("teacher_id", teacher_id);
        p[1] = new Array("city_id", city_id);
        var aj = new _ajax("./ajax/assign-batch-teacher.php", "post",p,function(){_waitassignbatchToteacher()}, function(r){_responseassignbatchToteacher(r)});
        aj._query();	
    } else {
        document.getElementById('txtbatchid').value = "";
    }
}
_waitassignbatchToteacher = function()
{
    document.getElementById('TabheadingBatch').innerHTML = "Please wait...";
};
_responseassignbatchToteacher = function(resp)
{
    resps = resp.split("|#|");
    var html = resps[1];
    var selectbatch = resps[2];
    document.getElementById('TabheadingBatch').value = "";
    document.getElementById('TabheadingBatch').style.display = 'block';
    if(resps[0] == 1)
    {
        document.getElementById('TabheadingBatch').innerHTML =  html;
        chkCounter = resps[0];
    }
    else if (resps[0] == 2) {
       document.getElementById('selectbatch').innerHTML = selectbatch;
    }
};
_saveChaptersForBatch = function(){
    var chpIDs = "";
    var chpPrio = "";
    var prio = 0;
    var chk = document.getElementsByName("chk[]");
    for (i = 0; i < chk.length; i++) {
        if (chk[i].checked == true){
            chpIDs += chpIDs == "" ? chk[i].value : "," + chk[i].value;
        }
    }
    if (chpIDs != "") {
        var p = new Array();
        p[0] = new Array("manager_id", document.getElementById('hdBatchID').value);
        p[1] = new Array("center_id", chpIDs);
        var aj = new _ajax("./ajax/assign-batch-teacher.php", "post",p,function(){_waitSaveChaptersForBatch()}, function(r){_responseSaveChaptersForBatch(r)});
        aj._query();    
    }
    else{
        alert("Please select atleast one center.");
    }
};

_waitSaveChaptersForBatch = function(){
    document.getElementById('TabheadingBatch').innerHTML = "Please wait...";
};

_responseSaveChaptersForBatch = function(r){
    _batchAssigntoTeacher(r);
};
_saveChaptersForBatch = function(){
    var chpIDs = "";
    var chk = document.getElementsByName("chk[]");
    for (i = 0; i < chk.length; i++) {
        if (chk[i].checked == true){
            chpIDs += chpIDs == "" ? chk[i].value : "," + chk[i].value;
        }
    }
    if (chpIDs != "") {
        var p = new Array();
        p[0] = new Array("teacher_id", document.getElementById('hdTeacherID').value);
        p[1] = new Array("city_id", document.getElementById('hdCityID').value);
        p[2] = new Array("batch_id", chpIDs);
        p[3] = new Array("center_id", document.getElementById('ddlSubject').value);
        var aj = new _ajax("./ajax/save-batch-teacher-mapping.php", "post",p,function(){_waitSaveChaptersForBatch()}, function(r){_responseSaveChaptersForBatch(r)});
        aj._query();    
    }
    else {
        chpIDs = "";
        alert("Please assign batches for the selected center.");
        return;
    }
};

_waitSaveChaptersForBatch = function(){
    document.getElementById('TabheadingBatch').innerHTML = "Please wait...";
};

_responseSaveChaptersForBatch = function(r){
    resps = r.split("|#|");
    _batchchapters(resps[0], resps[1] ,resps[2]);
};
_batchchapters = function (city_id, teacher_id, center_id){
    if (center_id != "") {
        if (center_id != "0") {
            //document.getElementById('TabheadingBatch').innerHTML = "";
            var p = new Array();
            p[0] = new Array("city_id", city_id);
            p[1] = new Array("center_id", center_id);
            p[2] = new Array("teacher_id", teacher_id);
            var aj = new _ajax("./ajax/assign-batch-teacher.php", "post",p,function(){_waitGetbatchchapters()}, function(r){_responsebatchchapters(r)});
            aj._query();	
        } else
        _batchAssigntoTeacher(teacher_id);
    } 
}
_waitGetbatchchapters = function()
{
    document.getElementById('TabheadingBatch').innerHTML = "Please wait...";
};
_responsebatchchapters = function(resp)
{
    document.getElementById('TabheadingBatch').innerHTML = "";
    resps = resp.split("|#|");
    var html = resps[1];
    if(resps[0] != "" && resps[0] >= 0)
    {
        document.getElementById('TabheadingBatch').innerHTML = html;
    }
};