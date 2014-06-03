_getBatchTable = function(page,sf,sd){
    var p = new Array();
    p.push(new Array("page", page));
    p.push(new Array("sf", sf));
    p.push(new Array("sd", sd));
    var aj = new _ajax("./ajax/get-batch-table.php", "post",p,function(){_waitGetBatchTable()}, function(r){_responseGetBatchTable(r)});
    aj._query();
};

_waitGetBatchTable = function(){
    document.getElementById('disableDiv').style.height = _getHeight('displayUser') + 'px';
    document.getElementById('disableDiv').style.display = 'block';
};

_responseGetBatchTable = function(r){
    document.getElementById('displayUser').innerHTML = r;
    document.getElementById('disableDiv').style.display = 'none';
    document.getElementById('disableText').innerHTML = "<br /><br /><img src=\"./images/avn-loader.gif\" /><br />Please wait while sorting is being done..."
};
_deletebatch = function(uId,page){
var cnf = false;
    cnf = confirm("Are you sure you want to delete this batch?");
    if (cnf) {
        cnf = confirm("Just to remind you that deleted batch could not be retrieved.\nDO YOU STILL WANT TO CONTINUE?");
        if (cnf) {
            var rID = 0;
            var tab = document.getElementById('tabBatch');
            //var cachedTableData = document.getElementById('tabCategory').innerHTML;
            var catgID = "";
            var chk = document.getElementsByName("chkBatch[]");
            var chkCount = chk.length;
            if (uId > -1)
            document.getElementById('chk-' + uId).checked = true;
            for (i = 0; i < chkCount; i++){
                if(chk[i].checked == true){
                    catgID += catgID == "" ? chk[i].value : "," + chk[i].value;
                    //document.getElementById('tabCategory').deleteRow(eval(i+1));
                }
            }
            if (catgID != "") {
                var p = new Array();
                p.push(new Array("uniqueid", catgID));
                p.push(new Array("page", page));
                var aj = new _ajax("./ajax/delete-batch.php" , "post",p,function(){_waitdeleteBatch()}, function(r){_responsedeleteBatch(r)});
                aj._query();    
            }
        }
    }		
}
_waitdeleteBatch = function()
{
    document.getElementById('disableDiv').style.height = _getHeight('displayUser') + 'px';
    document.getElementById('disableDiv').style.display = 'block';
    document.getElementById('disableText').innerHTML = "<br /><br /><img src=\"./images/avn-loader.gif\" /><br />Please wait while batch is being deleted...";
};
_responsedeleteBatch = function(r)
{
    document.getElementById('disableDiv').style.display = 'none';
    if (r != "") {
        if (r.indexOf("|#|") > -1) {
            var resp = r.split("|#|");
            if (parseInt(resp[0]) == 1) {                
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Batch deleted successfully.";
            }
            else if (parseInt(resp[0]) == 3) {                
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Please delete the learning centers of this batch.";
            }
            else if(parseInt(resp[0]) == 0 || parseInt(resp[0]) > 1 && parseInt(resp[0]) < 3) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "SORRY! batch could not be deleted.";
            }
            else if(parseInt(resp[0]) == 4) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All selected batches deleted successfully.";
            }
            else if(parseInt(resp[0]) == 5) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "SORRY! all/some of selected batches could not be deleted.<br />Please delete the learning centers of those batches.";
            }
            document.getElementById('bulkAct').style.display = "none";
            _getBatchTable(resp[1]);
        }
    }
};

_checked = function(c, rid){
    var chk = document.getElementsByName("chkBatch[]");
    var chkCount = chk.length;
    var anyChecked = false;
    if (c.id == 'catgAll') {
        var m = false;
        if (c.checked == true){
            m = true;
            anyChecked = true;
        }
        for (i = 0; i < chkCount; i++)
            chk[i].checked = m;
        var tab = document.getElementById('tabBatch');
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
            document.getElementById('batchRow-' + rid).className = 'selectedRow';
        } else {
            if (rid % 2 == 0)
                document.getElementById('batchRow-' + rid).className = 'lightyellow';
            else
                document.getElementById('batchRow-' + rid).className = 'darkyellow';
        }
        var chkAll = document.getElementById("catgAll");
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
    if (anyChecked)
        document.getElementById('bulkAct').style.display = 'block';
    else
        document.getElementById('bulkAct').style.display = 'none';
};

//-----------AssignChapters in batch---->

_checkChapter = function(c, rid){
    var chk = document.getElementsByName("chk[]");
    var chkCount = 0;
    var anyChecked = false;
    var ccT = chkCounter;
    if (c.checked == true){
        chkCounter++;
        document.getElementById('chapterRow-' + rid).className = 'selectedRow';
        document.getElementById('ddlpriority-' + rid).disabled = false;
        k = document.getElementById('ddlpriority-' + rid).options.length;
        for (i = 0; i < chk.length; i++) {
            addOption(document.getElementById('ddlpriority-' + i), chkCounter, chkCounter);   
        }
    } else {
        chkCounter--;
        for (i = 0; i < document.getElementsByName('ddlpriority').length; i++)
        removeOption(document.getElementById('ddlpriority-' + i), (document.getElementById('ddlpriority-' + i).length - 1));
        
        document.getElementById('ddlpriority-' + rid).disabled = true;
        document.getElementById('ddlpriority-' + rid).selectedIndex = 0;
        
        if (rid % 2 == 0)                                                                                                                                                                          
            document.getElementById('chapterRow-' + rid).className = 'lightyellow';
        else
            document.getElementById('chapterRow-' + rid).className = 'darkyellow';
    }
    
    //for (i = 0; i < chk.length; i++) {        
    //    if (document.getElementById('ddlpriority-' + i).options.length <= 1) {
    //        removeAllOptions(document.getElementById('ddlpriority-' + i));
    //        addOption(document.getElementById('ddlpriority-' + i), "0", "Choose one");
    //        k = 1;
    //    } else {
    //        k = document.getElementById('ddlpriority-' + i).options.length;
    //    }
    //    
    //}
    
}

_saveChaptersForBatch = function(){
    var chpIDs = "";
    var chpPrio = "";
    var prio = 0;
    var chk = document.getElementsByName("chk[]");
    for (i = 0; i < chk.length; i++) {
        if (chk[i].checked == true){
            chpIDs += chpIDs == "" ? chk[i].value : "," + chk[i].value;
            prio = document.getElementById('ddlpriority-' + i).value;
            if (prio != "" && prio != "0") {
                chpPrio += chpPrio == "" ? prio : "," + prio;
            } else {
                chpIDs = "";
                alert("Please assign priority for all selected chapter.");
                return;
            }
        }
    }
    if (chpIDs != "") {
        var p = new Array();
        p[0] = new Array("batch_id", document.getElementById('hdBatchID').value);
        p[1] = new Array("chapter_id", chpIDs);
        p[2] = new Array("priority", chpPrio);
        p[3] = new Array("subject_id", document.getElementById('ddlSubject').value);
        var aj = new _ajax("./ajax/save-batch-chapter-mapping.php", "post",p,function(){_waitSaveChaptersForBatch()}, function(r){_responseSaveChaptersForBatch(r)});
        aj._query();    
    }
};

_waitSaveChaptersForBatch = function(){
    document.getElementById('TabheadingBatch').innerHTML = "Please wait...";
};

_responseSaveChaptersForBatch = function(r){
    resps = r.split("|#|");
    _batchchapters(resps[0], resps[1]);
};