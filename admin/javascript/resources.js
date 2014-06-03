_getResourceTable = function(currid, topicid, catgid, chptid,page,sf,sd){
    var p = new Array();
    p.push(new Array("topicid", topicid));
    p.push(new Array("catgid", catgid));
    p.push(new Array("chptid", chptid));
    p.push(new Array("page", page));
    p.push(new Array("sf", sf));
    p.push(new Array("sd", sd));
    p.push(new Array("currid", currid));
    var aj = new _ajax("./ajax/get-resources-table.php", "post",p,function(){_waitGetResourceTable()}, function(r){_responseGetResourceTable(r)});
    aj._query();
};

_waitGetResourceTable = function(){
    document.getElementById('disableDiv').style.height = _getHeight('displayUser') + 'px';
    document.getElementById('disableDiv').style.display = 'block';
};

_responseGetResourceTable = function(r){
    document.getElementById('displayUser').innerHTML = r;
    document.getElementById('disableDiv').style.display = 'none';
     document.getElementById('disableText').innerHTML = "<br /><br /><img src=\"./images/avn-loader.gif\" /><br />Please wait while sorting is being done...";
};

//----------------to delete resource---------
var cachedTableData = "";
_deleteresource = function(currid,uId,tpid,catgid,chptid,page){
	var cnf = false;
	cnf = confirm("Are you sure you want to delete this resource?");
	if (cnf) {
            cnf = confirm("Just to remind you that deleted resource could not be retrieved.\nDO YOU STILL WANT TO CONTINUE?");
            if (cnf) {
                var rID = 0;
                var tab = document.getElementById('tabResources');
                var resourceID = "";
                var chk = document.getElementsByName("chkResource[]");
                var chkCount = chk.length;
                if (uId > -1)
                document.getElementById('chk-' + uId).checked = true;
                for (i = 0; i < chkCount; i++){
                    if(chk[i].checked == true){
                        resourceID += resourceID == "" ? chk[i].value : "," + chk[i].value;
                    }
                }
                if (resourceID != "") {
                    var p = new Array();
                    p.push(new Array("uniqueid", resourceID));
                    p.push(new Array("topic_id", tpid));
                    p.push(new Array("catg_id", catgid));
                    p.push(new Array("chap_id", chptid));
                    p.push(new Array("page", page));
		    p.push(new Array("currid", currid));
                    var aj = new _ajax("./ajax/delete-resource.php" , "post",p,function(){_waitdeleteResource()}, function(r){_responsedeleteResource(r)});
                    aj._query();  
                }
            }
	}
}
_waitdeleteResource = function()
{
    document.getElementById('disableDiv').style.height = _getHeight('displayUser') + 'px';
    document.getElementById('disableDiv').style.display = 'block';
    document.getElementById('disableText').innerHTML = "<br /><br /><img src=\"./images/avn-loader.gif\" /><br />Please wait while resource is being deleted...";
};
_responsedeleteResource = function(r)
{
    document.getElementById('disableDiv').style.display = 'none';
    if (r != ""){
        if (r.indexOf("|#|") > -1) {
            var resp = r.split("|#|");
            if (parseInt(resp[0]) == 1) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Please delete the questions related to this resource.";
            }else if (parseInt(resp[0]) == 2) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = ""; 
            }
            else if(parseInt(resp[0]) == 0) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "SORRY! resource could not be deleted."; 
            }
            else if(parseInt(resp[0]) == 3) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Resource deleted successfully."; 
            }
            else if(parseInt(resp[0]) == 4) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "SORRY! resource could not be deleted."
            }
            else if(parseInt(resp[0]) == 5) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All/some of the selected resources coundn't deleted successfully.<br />Please delete the questions related to those resource(s)."; 
            }
            else if(parseInt(resp[0]) == 6) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All/some of the selected resources deleted successfully."; ; 
            }
            else if(parseInt(resp[0]) == 7) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All/some of the selected resources coundn't deleted successfully.<br />Please delete the questions related to those resource(s)."; ; 
            }
            document.getElementById('bulkAct').style.display = "none";
            document.getElementById('bulkActive').style.display = "none";
            _getResourceTable(resp[1], resp[2], resp[3], resp[4], resp[5], resp[6]);
        }         
    }    
};

/*function to change the status of a resource*/

_chngResStatus = function(currid,uId,tpid,status,catgid, chptid ,page){
    _getHeight('displayUser');
    var id = uId;
    var rID = 0;
    var tab = document.getElementById('tabResources');
    var resourceID = "";
    var chk = document.getElementsByName("chkResource[]");
    var chkCount = chk.length;
    if (uId > -1)
    document.getElementById('chk-' + uId).checked = true;
    for (i = 0; i < chkCount; i++){
        if(chk[i].checked == true){
            resourceID += resourceID == "" ? chk[i].value : "," + chk[i].value;
        }
    }
    if (resourceID != ""){
        var p = new Array();
        p.push(new Array("resid", resourceID));
        p.push(new Array("topic_id", tpid));
        p.push(new Array("status", status));
        p.push(new Array("catg_id", catgid));
        p.push(new Array("chap_id", chptid));
        p.push(new Array("page", page));
	p.push(new Array("currid", currid));
        var aj = new _ajax("./ajax/resource-status.php" , "post",p,function(){_waitGetrespchngResStatus()}, function(r){_responseGetrespchngResStatus(r)});
        aj._query();
    }
}
_waitGetrespchngResStatus = function(){
    document.getElementById('disableDiv').style.height = _getHeight('displayUser') + 'px';
    document.getElementById('disableDiv').style.display = 'block';
    document.getElementById('disableText').innerHTML = "<br /><br /><img src=\"./images/avn-loader.gif\" /><br />Please wait while resource's status is being updated...";
};
_responseGetrespchngResStatus = function(r)
{
    document.getElementById('disableDiv').style.display = 'none';
    if (r != "") {
        if (r.indexOf("|#|") > -1) {
            var resp = r.split("|#|");
            if (parseInt(resp[0]) == 1) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Resource's status updated successfully.";
            }
            else if(parseInt(resp[0]) == 0) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "SORRY! Resource's status could not be updated.";
                //document.getElementById('tabResources').innerHTML = cachedTableData;
            }
            else if(parseInt(resp[0]) == 3) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All/some resource's status are updated successfully.";
                //document.getElementById('tabResources').innerHTML = cachedTableData;
            }
            else if(parseInt(resp[0]) == 4) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All/some resource's status could not be updated.";
                //document.getElementById('tabResources').innerHTML = cachedTableData;
            }
            document.getElementById('bulkAct').style.display = 'none';
            document.getElementById('bulkActive').style.display = 'none';
            _getResourceTable(resp[1], resp[2], resp[3], resp[4],resp[5]);
        }         
    }
};
//function to set resource priority

_setpriority = function(currid,catgid,chptid,uid,tpid,action,page){
    var id = uid;	
    var p = new Array();
    p.push(new Array("catgid", catgid));
    p.push(new Array("chptid", chptid));
    p.push(new Array("uniqueid", uid));
    p.push(new Array("topic_id", tpid));
    p.push(new Array("action",action));
    p.push(new Array("page", page));
    p.push(new Array("currid", currid));
    var aj = new _ajax("./ajax/priority.php" , "post",p,function(){_waitGetrespPriority()}, function(r){_responseGetrespPriority(r)});
    aj._query();
}
_waitGetrespPriority = function()
{
    document.getElementById('disableDiv').style.height = _getHeight('displayUser') + 'px';
    document.getElementById('disableDiv').style.display = 'block';
    document.getElementById('disableText').innerHTML = "<br /><br /><img src=\"./images/avn-loader.gif\" /><br />Please wait while resource's priority is being updated...";
};
_responseGetrespPriority = function(r)
{
    document.getElementById('disableDiv').style.display = 'none';
    if (r != "") {
        if (r.indexOf("|#|") > -1) {
            var resp = r.split("|#|");
            if (parseInt(resp[0]) == 1) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Resource's priority updated successfully.";
            }
            else if(parseInt(resp[0]) == 0) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "SORRY! Resource's priority could not be updated.";
                document.getElementById('tabResources').innerHTML = cachedTableData;
            }
	     _getResourceTable(resp[1], resp[2], resp[3], resp[4],resp[5]);
        }         
    }
};


_checked = function(c, rid){
    var chk = document.getElementsByName("chkResource[]");
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
        var tab = document.getElementById('tabResources');
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
            document.getElementById('rdatarow-' + rid).className = 'selectedRow';
        } else {
            if (rid % 2 == 0)
                document.getElementById('rdatarow-' + rid).className = 'lightyellow';
            else
                document.getElementById('rdatarow-' + rid).className = 'darkyellow';
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