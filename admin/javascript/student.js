_getStudentTable = function(page,sf,sd){
    var p = new Array();
    p.push(new Array("page", page));
    p.push(new Array("sf", sf));
    p.push(new Array("sd", sd));
    var aj = new _ajax("./ajax/get-student-table.php", "post",p,function(){_waitGetStudentTable()}, function(r){_responseGetStudentTable(r)});
    aj._query();
}
_waitGetStudentTable = function(){
    document.getElementById('disableDiv').style.height = _getHeight('displayUser') + 'px';
    document.getElementById('disableDiv').style.display = 'block';
    document.getElementById('disableText').innerHTML = "<br /><br /><img src=\"./images/avn-loader.gif\" /><br />Please wait while sorting is being done...";
}
_responseGetStudentTable = function(r){
    document.getElementById('displayUser').innerHTML = r;
    document.getElementById('disableDiv').style.display = 'none';    
    document.getElementById("ErrMsg").style.display = "none";
}
cachedTableData = "";
_deletestudent = function(uId,page){
    var cnf = false;
    cnf = confirm("Are you sure you want to delete this student?");
    if (cnf) {
        cnf = confirm("Just to remind you that deleted student could not be retrieved.\nDO YOU STILL WANT TO CONTINUE?");
        if (cnf) {
            var rID = 0;
            var tab = document.getElementById('tabStudent');
            var userID = "";
            var chk = document.getElementsByName("chkStudent[]");
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
                var aj = new _ajax("./ajax/delete-student.php" , "post",p,function(){_waitdeleteStudent()}, function(r){_responsedeleteStudent(r)});
                aj._query(); 
            }   
        }
    }		
}

_waitdeleteStudent = function(){
    document.getElementById('disableDiv').style.height = _getHeight('displayUser') + 'px';
    document.getElementById('disableDiv').style.display = 'block';
    document.getElementById('disableText').innerHTML = "<br /><br /><img src=\"./images/avn-loader.gif\" /><br />Please wait while user is being deleted...";
}
_responsedeleteStudent = function(r){
    document.getElementById('disableDiv').style.display = 'none';
    if (r != "") {
        if (r.indexOf("|#|") > -1) {
            var resp = r.split("|#|");
            if (parseInt(resp[0]) == 1) {                
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Student deleted successfully.";
            }
            else if(parseInt(resp[0]) == 0) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "SORRY! student could not be deleted.";
            }
            else if(parseInt(resp[0]) == 3) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All/some of the students deleted successfully.";
            }
             else if(parseInt(resp[0]) == 4) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All/some of the students not deleted successfully.";
            }
            document.getElementById('bulkAct').style.display = 'none';
            document.getElementById('bulkActive').style.display = 'none';
            _getStudentTable(resp[1]);
        }
    }
}

_changestudentstatus =  function(uId,action,page){
     _getHeight('displayUser');
    var userID = "";
    var chk = document.getElementsByName("chkStudent[]");
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
        var aj = new _ajax("./ajax/student-status.php" , "post",p,function(){_waitGetrespchngstudentstatus()}, function(r){_responseGetrespchngstudentstatus(r)});
        aj._query();    
    }
    
}
_waitGetrespchngstudentstatus = function()
{
    document.getElementById('disableDiv').style.height = _getHeight('displayUser') + 'px';
    document.getElementById('disableDiv').style.display = 'block';
    document.getElementById('disableText').innerHTML = "<br /><br /><img src=\"./images/avn-loader.gif\" /><br />Please wait while student's status is being updated...";
};
_responseGetrespchngstudentstatus = function(r)
{
    document.getElementById('disableDiv').style.display = 'none';
    if (r != "") {
        if (r.indexOf("|#|") > -1) {
            var resp = r.split("|#|");
            if (parseInt(resp[0]) == 1) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Student's status updated successfully.";
                
            }
            else if(parseInt(resp[0]) == 0) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "SORRY! student's status could not be updated.";
            }
            else if (parseInt(resp[0]) == 3) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All/some student's status updated successfully.";
            }
            else if(parseInt(resp[0]) == 4) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All/some student's status could not be updated.";
            }
            document.getElementById('bulkAct').style.display = 'none';
            document.getElementById('bulkActive').style.display = 'none';
             _getStudentTable(resp[1]);
        }         
    }
};

_checked = function(c, rid){
    var chk = document.getElementsByName("chkStudent[]");
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
        var tab = document.getElementById('tabStudent');
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
            document.getElementById('StudentRow-' + rid).className = 'selectedRow';
        } else {
            if (rid % 2 == 0)
                document.getElementById('StudentRow-' + rid).className = 'lightyellow';
            else
                document.getElementById('StudentRow-' + rid).className = 'darkyellow';
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