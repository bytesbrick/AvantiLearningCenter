_getEditorTable =function(page,sf,sd){
    var p = new Array();
    p.push(new Array("page", page));
    p.push(new Array("sf", sf));
    p.push(new Array("sd", sd));
    var aj = new _ajax("./ajax/get-editor-table.php", "post",p,function(){_waitGetEditorTable()}, function(r){_responseGetEditorTable(r)});
    aj._query();
};

_waitGetEditorTable = function(){
    document.getElementById('disableDiv').style.height = _getHeight('displayUser') + 'px';
    document.getElementById('disableDiv').style.display = 'block';
};

_responseGetEditorTable = function(r){
    document.getElementById('displayUser').innerHTML = r;
    document.getElementById('disableDiv').style.display = 'none';
    document.getElementById('disableText').innerHTML = "<br /><br /><img src=\"./images/avn-loader.gif\" /><br />Please wait while sorting is being done...";
};


_deleteEditor = function(uId,page){
    var cnf = false;
    cnf = confirm("Are you sure you want to delete this editor?");
    if (cnf) {
        cnf = confirm("Just to remind you that deleted editor could not be retrieved.\nDO YOU STILL WANT TO CONTINUE?");
        if (cnf) {
            var rID = 0;
            var tab = document.getElementById('tabEditor');
            var editorID = "";
            var chk = document.getElementsByName("chkEditor[]");
            var chkCount = chk.length;
            if (uId > -1)
            document.getElementById('chk-' + uId).checked = true;
            for (i = 0; i < chkCount; i++){
                if(chk[i].checked == true){
                    editorID += editorID == "" ? chk[i].value : "," + chk[i].value;
                }
            }
            if (editorID != "") {
                var p = new Array();
                p.push(new Array("uniqueid", editorID));
                p.push(new Array("page", page));
                var aj = new _ajax("./ajax/delete-editor.php" , "post",p,function(){_waitdeleteEditor()}, function(r){_responsedeleteEditor(r)});
                aj._query();  
            }
        }
    }
}

_waitdeleteEditor = function()
{
        document.getElementById('disableDiv').style.height = _getHeight('displayUser') + 'px';
        document.getElementById('disableDiv').style.display = 'block';
        document.getElementById('disableText').innerHTML = "<br /><br /><img src=\"./images/avn-loader.gif\" /><br />Please wait while topic is being deleted...";
};
_responsedeleteEditor = function(r)
{
    document.getElementById('disableDiv').style.display = 'none';
    if (r != ""){
        if (r.indexOf("|#|") > -1) {
            var resp = r.split("|#|");
            if (parseInt(resp[0]) == 1){
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Editor deleted successfully.";
            }
            else if(parseInt(resp[0]) == 0){
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "SORRY! editor could not be deleted.";
            }
            else if(parseInt(resp[0]) == 3) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All/some of the editor deleted successfully.";
            }
             else if(parseInt(resp[0]) == 4) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All/some of the editor not deleted successfully.";
            }
            document.getElementById('bulkAct').style.display = 'none';
            document.getElementById('bulkActive').style.display = 'none';
            _getEditorTable(resp[1]);
        }         
    }
};

/*function to change the status of a editor*/

_chngEditorStatus = function(uId,status,page){
    _getHeight('displayUser');
    var editorID = "";
    var chk = document.getElementsByName("chkEditor[]");
    var chkCount = chk.length;
    if (uId > -1)
    document.getElementById('chk-' + uId).checked = true;
    for (i = 0; i < chkCount; i++){
        if(chk[i].checked == true){
            editorID += editorID == "" ? chk[i].value : "," + chk[i].value;
        }
    }
    if (editorID != "") {
        var p = new Array();
        p.push(new Array("uniqueid", editorID));
        p.push(new Array("status", status));
        p.push(new Array("page", page));
        var aj = new _ajax("./ajax/editor-status.php" , "post",p,function(){_waitGetrespchngEditorStatus()}, function(r){_responseGetrespchngEditorStatus(r)});
        aj._query();
    }
}
_waitGetrespchngEditorStatus = function(){
    document.getElementById('disableDiv').style.height = _getHeight('displayUser') + 'px';
    document.getElementById('disableDiv').style.display = 'block';
    document.getElementById('disableText').innerHTML = "<br /><br /><img src=\"./images/avn-loader.gif\" /><br />Please wait while editor's status is being updated...";
};
_responseGetrespchngEditorStatus = function(r)
{
    document.getElementById('disableDiv').style.display = 'none';
    if (r != "") {
        if (r.indexOf("|#|") > -1) {
            var resp = r.split("|#|");
            if (parseInt(resp[0]) == 1) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Editor's status updated successfully.";
            }
            else if(parseInt(resp[0]) == 0) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "SORRY! Editor's status could not be updated.";
                document.getElementById('tabEditor').innerHTML = cachedTableData;
            }
            else if (parseInt(resp[0]) == 3) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All/some editor's status updated successfully.";
            }
            else if(parseInt(resp[0]) == 4) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All/some editor's status could not be updated.";
            }
            document.getElementById('bulkAct').style.display = 'none';
            document.getElementById('bulkActive').style.display = 'none';
             _getEditorTable(resp[1]);
        }         
    }
};

_checked = function(c, rid){
    var chk = document.getElementsByName("chkEditor[]");
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
        var tab = document.getElementById('tabEditor');
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
            document.getElementById('editorRow-' + rid).className = 'selectedRow';
        } else {
            if (rid % 2 == 0)
                document.getElementById('editorRow-' + rid).className = 'lightyellow';
            else
                document.getElementById('editorRow-' + rid).className = 'darkyellow';
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