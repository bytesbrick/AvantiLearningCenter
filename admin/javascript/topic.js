_getTopicTable = function(currid, chptid,catgid,page,sf,sd){
    var p = new Array();
    p.push(new Array("chptid", chptid));
    p.push(new Array("catgid", catgid));
    p.push(new Array("page", page));
    p.push(new Array("sf", sf));
    p.push(new Array("sd", sd));
    p.push(new Array("currid", currid));
    var aj = new _ajax("./ajax/get-topics-table.php", "post",p,function(){_waitGetTopicTable()}, function(r){_responseGetTopicTable(r)});
    aj._query();
};

_waitGetTopicTable = function(){
    document.getElementById('disableDiv').style.height = _getHeight('displayUser') + 'px';
    document.getElementById('disableDiv').style.display = 'block';
};

_responseGetTopicTable = function(r){
    document.getElementById('displayUser').innerHTML = r;
    document.getElementById('disableDiv').style.display = 'none';
    document.getElementById('disableText').innerHTML = "<br /><br /><img src=\"./images/avn-loader.gif\" /><br />Please wait while sorting is being done...";
};

var cachedTableData = "";
_deletetopic = function(currid, uId,chptid,catgid,page){
    var cnf = false;
    cnf = confirm("Are you sure you want to delete this topic?");
    if (cnf) {
        cnf = confirm("Just to remind you that deleted topic could not be retrieved.\nDO YOU STILL WANT TO CONTINUE?");
        if (cnf) {
            var rID = 0;
            var tab = document.getElementById('tabTopics');
            var topicID = "";
            var chk = document.getElementsByName("chkTopic[]");
            var chkCount = chk.length;
            if (uId > -1)
            document.getElementById('chk-' + uId).checked = true;
            for (i = 0; i < chkCount; i++){
                if(chk[i].checked == true){
                    topicID += topicID == "" ? chk[i].value : "," + chk[i].value;
                }
            }
            if (topicID != "") {
                var p = new Array();
                p.push(new Array("uniqueid", topicID));
                p.push(new Array("chptid", chptid));
                p.push(new Array("catgid", catgid));
                p.push(new Array("page", page));
                p.push(new Array("currid", currid));
                var aj = new _ajax("./ajax/delete-topic.php" , "post",p,function(){_waitdeleteTopic()}, function(r){_responsedeleteTopic(r)});
                aj._query();  
            }
        }
    }
}
_waitdeleteTopic = function()
{
    document.getElementById('disableDiv').style.height = _getHeight('displayUser') + 'px';
    document.getElementById('disableDiv').style.display = 'block';
    document.getElementById('disableText').innerHTML = "<br /><br /><img src=\"./images/avn-loader.gif\" /><br />Please wait while topic is being deleted...";
};
_responsedeleteTopic = function(r)
{
    document.getElementById('disableDiv').style.display = 'none';
    if (r != "") {
        if (r.indexOf("|#|") > -1){
            var resp = r.split("|#|");
            if (parseInt(resp[0]) == 1) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Topic deleted successfully.";
                
            }else if (parseInt(resp[0]) == 2) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Please delete the resources related to this topic.";
                //document.getElementById('tabTopics').innerHTML = cachedTableData;
            }
            else if(parseInt(resp[0]) == 0 || parseInt(resp[0]) > 1 && parseInt(resp[0]) < 3) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "SORRY! topic could not be deleted.";
                //document.getElementById('tabTopics').innerHTML = cachedTableData;
            }
            else if(parseInt(resp[0]) == 3){
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Please delete the resources & questions related to this topic.";
                //document.getElementById('tabChapters').innerHTML = cachedTableData;
            }
            else if(parseInt(resp[0]) == 8) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "SORRY! all/some of selected topic(s) could not be deleted.<br />Please delete the resources of those topic(s).";
            }
            else if(parseInt(resp[0]) == 10) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All selected subjects deleted successfully.";
            }
            document.getElementById('bulkAct').style.display = "none";
            document.getElementById('bulkActive').style.display = "none";
            _getTopicTable(resp[1], resp[2], resp[3]);
        }         
    }
};


/*function to change status of a topic*/

_changestatus = function(currid,uId,status,chptid,catgid,page){
     _getHeight('displayUser');
    var topicID = "";
    var chk = document.getElementsByName("chkTopic[]");
    var chkCount = chk.length;
    if (uId > -1)
    document.getElementById('chk-' + uId).checked = true;
    for (i = 0; i < chkCount; i++){
        if(chk[i].checked == true){
            topicID += topicID == "" ? chk[i].value : "," + chk[i].value;
        }
    }
    if (topicID != "") {
        var p = new Array();
        p.push(new Array("topicid", topicID));
        p.push(new Array("status", status));
        p.push(new Array("chptid", chptid));
        p.push(new Array("catgid", catgid));
        p.push(new Array("page", page));
        p.push(new Array("currid", currid));
        var aj = new _ajax("./ajax/topic-status.php" , "post",p,function(){_waitGetrespchngStatus()}, function(r){_responseGetrespchngStatus(r)});
        aj._query() 
    }
   ;
}
_waitGetrespchngStatus = function()
{
    document.getElementById('disableDiv').style.height = _getHeight('displayUser') + 'px';
    document.getElementById('disableDiv').style.display = 'block';
    document.getElementById('disableText').innerHTML = "<br /><br /><img src=\"./images/avn-loader.gif\" /><br />Please wait while topic's status is being updated...";
};
_responseGetrespchngStatus = function(r)
{
    document.getElementById('disableDiv').style.display = 'none';
    if (r != "") {
        if (r.indexOf("|#|") > -1) {
            var resp = r.split("|#|");
            if (parseInt(resp[0]) == 1) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Topic's status updated successfully.";
            }
            else if(parseInt(resp[0]) == 0) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "SORRY! Topic's status could not be updated.";
            }
            else if (parseInt(resp[0]) == 3) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All/some topic's status updated successfully.";
            }
            else if(parseInt(resp[0]) == 4) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All/some topic's status could not be updated.";
            }
            document.getElementById('bulkAct').style.display = "none";
            document.getElementById('bulkActive').style.display = "none";
            _getTopicTable(resp[1], resp[2], resp[3], resp[4]);
        }         
    }
};

//function to set topic priority

_topicpriority = function(currid,chptid,catgid,uid,action,page){
    var id = uid;	
    var p = new Array();
    p.push(new Array("catgid", catgid));
    p.push(new Array("chptid", chptid));
    p.push(new Array("uniqueid", uid));
    p.push(new Array("action",action));
    p.push(new Array("page", page))
    p.push(new Array("currid", currid))
    var aj = new _ajax("./ajax/topic-priority.php" , "post",p,function(){_waitTopicPriority()}, function(r){_responseTopicPriority(r)});
    aj._query();
}
_waitTopicPriority = function()
{
    document.getElementById('disableDiv').style.height = _getHeight('displayUser') + 'px';
    document.getElementById('disableDiv').style.display = 'block';
    document.getElementById('disableText').innerHTML = "<br /><br /><img src=\"./images/avn-loader.gif\" /><br />Please wait while topic's priority is being updated...";
};
_responseTopicPriority = function(r)
{
    document.getElementById('disableDiv').style.display = 'none';
    if (r != "") {
        if (r.indexOf("|#|") > -1) {
            var resp = r.split("|#|");
            if (parseInt(resp[0]) == 1) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Topic's priority updated successfully.";
                
            }
            else if(parseInt(resp[0]) == 0) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "SORRY! Topic's priority could not be updated.";
                document.getElementById('tabTopics').innerHTML = cachedTableData;
            }
            _getTopicTable(resp[1], resp[2], resp[3], resp[4]);
        }         
    }
};

_checked = function(c, rid){
    var chk = document.getElementsByName("chkTopic[]");
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
        var tab = document.getElementById('tabTopics');
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
            document.getElementById('topicdatarow-' + rid).className = 'selectedRow';
        } else {
            if (rid % 2 == 0)
                document.getElementById('topicdatarow-' + rid).className = 'lightyellow';
            else
                document.getElementById('topicdatarow-' + rid).className = 'darkyellow';
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