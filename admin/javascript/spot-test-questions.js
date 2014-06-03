_getSpotQesTable  = function(currid,topicid, catgid, chptid,page,sf,sd){
    var p = new Array();
    p.push(new Array("topicid", topicid));
    p.push(new Array("catgid", catgid));
    p.push(new Array("chptid", chptid));
    p.push(new Array("page", page));
    p.push(new Array("currid", currid));
    p.push(new Array("sf", sf));
    p.push(new Array("sd", sd));
    var aj = new _ajax("./ajax/spot-test-table.php", "post",p,function(){_waitGetSpotQesTable()}, function(r){_responseGetSpotQesTable(r)});
    aj._query();
};

_waitGetSpotQesTable = function(){
    document.getElementById('disableDiv').style.height = _getHeight('displayUser') + 'px';
    document.getElementById('disableDiv').style.display = 'block';
};

_responseGetSpotQesTable = function(r){
    document.getElementById('displayUser').innerHTML = r;
    document.getElementById('disableDiv').style.display = 'none';
    document.getElementById('disableText').innerHTML = "<br /><br /><img src=\"./images/avn-loader.gif\" /><br />Please wait while sorting is being done...";
};

_deletequestion = function(currid,uId,topicid,chptid,catgid,type,page){
    var cnf = false;
    cnf = confirm("Are you sure you want to delete this question?");
    if (cnf) {
        cnf = confirm("Just to remind you that deleted question could not be retrieved.\nDO YOU STILL WANT TO CONTINUE?");
        if (cnf) {
            var rID = 0;
            var tab = document.getElementById('tabspotquestions');
            var QesID = "";
            var chk = document.getElementsByName("chkspotqes[]");
            var chkCount = chk.length;
            if (uId > -1)
            document.getElementById('chk-' + uId).checked = true;
            for (i = 0; i < chkCount; i++){
                if(chk[i].checked == true){
                    QesID += QesID == "" ? chk[i].value : "," + chk[i].value;
                }
            }
            if (QesID != "") {
                var p = new Array();
                p.push(new Array("uniqueid", QesID));
                p.push(new Array("topicid", topicid));
                p.push(new Array("chptid", chptid));
                p.push(new Array("catgid", catgid));
                p.push(new Array("type", type));
                p.push(new Array("page", page));
                p.push(new Array("currid", currid));
                var aj = new _ajax("./ajax/delete-spot-test.php" , "post",p,function(){_waitDeletequestion()}, function(r){_responseDeletequestion(r)});
                aj._query();
            }
        }
    }
}
_waitDeletequestion = function()
{
    document.getElementById('disableDiv').style.height = _getHeight('displayUser') + 'px';
    document.getElementById('disableDiv').style.display = 'block';
    document.getElementById('disableText').innerHTML = "<br /><br /><img src=\"./images/avn-loader.gif\" /><br />Please wait while question is being deleted...";
};
_responseDeletequestion = function(r)
{
    document.getElementById('disableDiv').style.display = 'none';
    if (r != "") {
        if (r.indexOf("|#|") > -1) {
            var resp = r.split("|#|");
            if (parseInt(resp[0]) == 1) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Question deleted successfully.";
            }
            else if(parseInt(resp[0]) == 0) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "SORRY! question could not be deleted.";
            }
            else if(parseInt(resp[0]) == 3) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All the selected questions deleted successfully.";
            }
            else if(parseInt(resp[0]) == 4 || parseInt(resp[0]) == 5) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All/some of the selected questions coundn't deleted successfully.";
            }
            document.getElementById('bulkAct').style.display = "none";
            document.getElementById('bulkActive').style.display = "none";
            _getSpotQesTable(resp[1], resp[2], resp[3], resp[4], resp[5]);
        }         
    }    
};

/*function to change the status of a question*/

_chngQesStatus = function(currid,uId,tpid,chptid,catgid,status,qtype,page){
    var QesID = "";
    var chk = document.getElementsByName("chkspotqes[]");
    var chkCount = chk.length;
    if (uId > -1)
    document.getElementById('chk-' + uId).checked = true;
    for (i = 0; i < chkCount; i++){
        if(chk[i].checked == true){
            QesID += QesID == "" ? chk[i].value : "," + chk[i].value;
        }
    }
    if (QesID != "") {
        var p = new Array();
        p.push(new Array("uniqueid", QesID));
        p.push(new Array("topic_id", tpid));
        p.push(new Array("chptid", chptid));
        p.push(new Array("catgid", catgid));
        p.push(new Array("status", status));
        p.push(new Array("qtype", qtype));
        p.push(new Array("page", page));
        p.push(new Array("currid", currid));
        var aj = new _ajax("./ajax/question-status.php" , "post",p,function(){_waitGetrespchngQesStatus()}, function(r){_responseGetrespchngQesStatus(r)});
        aj._query();    
    }  
}
_waitGetrespchngQesStatus = function()
{
    document.getElementById('disableDiv').style.height = _getHeight('displayUser') + 'px';
    document.getElementById('disableDiv').style.display = 'block';
    document.getElementById('disableText').innerHTML = "<br /><br /><img src=\"./images/avn-loader.gif\" /><br />Please wait while question's status is being updated...";
};
_responseGetrespchngQesStatus = function(r)
{
    document.getElementById('disableDiv').style.display = 'none';
    if (r != "") {
        if (r.indexOf("|#|") > -1) {
            var resp = r.split("|#|");
            if (parseInt(resp[0]) == 1) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Question's status updated successfully.";
            }
            else if(parseInt(resp[0]) == 0) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "SORRY! Question's status could not be updated.";
            }
            else if(parseInt(resp[0]) == 3) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All/some question's status updated succesfully.";
            }
            else if(parseInt(resp[0]) == 4) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All/some question's status could not be updated."; 
            }
            document.getElementById('bulkAct').style.display = 'none';
            document.getElementById('bulkActive').style.display = 'none';
            _getSpotQesTable(resp[1], resp[2], resp[3], resp[4],resp[5],resp[6]);
        }         
    }
};
_setqnspriority = function(currid,catgid,chptid,uid,action,tpid,type,page){
        var id = uid;	
        var p = new Array();
        p.push(new Array("chptid", chptid));
        p.push(new Array("catgid", catgid));
        p.push(new Array("uniqueid", uid));
        p.push(new Array("action", action));
        p.push(new Array("tpid", tpid));
        p.push(new Array("type", type));
        p.push(new Array("page", page));
        p.push(new Array("currid", currid));
        var aj = new _ajax("./ajax/questions-priority.php" , "post",p,function(){_waitGetrespQnsPriority()}, function(r){_responseGetrespQnsPriority(r)});
        aj._query();
}
_waitGetrespQnsPriority = function()
{
    document.getElementById('disableDiv').style.height = _getHeight('displayUser') + 'px';
    document.getElementById('disableDiv').style.display = 'block';
    document.getElementById('disableText').innerHTML = "<br /><br /><img src=\"./images/avn-loader.gif\" /><br />Please wait while question's priority is being updated...";
        
};
_responseGetrespQnsPriority = function(r)
{
    document.getElementById('disableDiv').style.display = 'none';
    if (r != "") {
        if (r.indexOf("|#|") > -1) {
            var resp = r.split("|#|");
            if (parseInt(resp[0]) == 1) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Question's priority updated successfully.";
            }
            else if(parseInt(resp[0]) == 0) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "SORRY! Question's priority could not be updated.";
                document.getElementById('tabspotquestions').innerHTML = cachedTableData;
            }
            _getSpotQesTable(resp[1], resp[2], resp[3], resp[4], resp[5]);
        }         
    }
};

_checked = function(c, rid){
    var chk = document.getElementsByName("chkspotqes[]");
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
        var tab = document.getElementById('tabspotquestions');
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
            document.getElementById('Qesdatarow-' + rid).className = 'selectedRow';
        } else {
            if (rid % 2 == 0)
                document.getElementById('Qesdatarow-' + rid).className = 'lightyellow';
            else
                document.getElementById('Qesdatarow-' + rid).className = 'darkyellow';
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