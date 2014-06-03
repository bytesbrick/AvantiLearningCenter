_getChapterTable = function(currid, catgid,page,sf,sd){
    var p = new Array();
    p.push(new Array("catgid", catgid));
    p.push(new Array("page", page));
    p.push(new Array("sf", sf));
    p.push(new Array("sd", sd));
    p.push(new Array("currid", currid));
    var aj = new _ajax("./ajax/get-chapters-table.php", "post",p,function(){_waitGetChapterTable()}, function(r){_responseGetChapterTable(r)});
    aj._query();
};

_waitGetChapterTable = function(){
    document.getElementById('disableDiv').style.height = _getHeight('displayUser') + 'px';
    document.getElementById('disableDiv').style.display = 'block';
};

_responseGetChapterTable = function(r){
    document.getElementById('displayUser').innerHTML = r;
    document.getElementById('disableDiv').style.display = 'none';
    document.getElementById('disableText').innerHTML = "<br /><br /><img src=\"./images/avn-loader.gif\" /><br />Please wait while sorting is being done...";
};

//----------------to delete chapter---------
var cachedTableData = "";
_deletechapter = function(currid, uId, catgid, page){
    var cnf = false;
    cnf = confirm("Are you sure you want to delete this chapter?");
    if (cnf) {
        cnf = confirm("Just to remind you that deleted chapter could not be retrieved.\nDO YOU STILL WANT TO CONTINUE?");
        if (cnf) {
            var rID = 0;
            var tab = document.getElementById('tabChapters');
            var chptID = "";
            var chk = document.getElementsByName("chkChapter[]");
            var chkCount = chk.length;
            if (uId > -1)
            document.getElementById('chk-' + uId).checked = true;
            for (i = 0; i < chkCount; i++){
                if(chk[i].checked == true){
                    chptID += chptID == "" ? chk[i].value : "," + chk[i].value;
                }
            }
            if (chptID != "") {
               var p = new Array();
                p.push(new Array("uniqueid", chptID));
                p.push(new Array("catgid", catgid));
                p.push(new Array("page", page));
                p.push(new Array("currid", currid));
                var aj = new _ajax("./ajax/delete-chapter.php" , "post",p,function(){_waitdeleteChapter()}, function(r){_responsedeleteChapter(r)});
                aj._query(); 
            }   
        }
    }		
}
_waitdeleteChapter = function()
{
    document.getElementById('disableDiv').style.height = _getHeight('displayUser') + 'px';
    document.getElementById('disableDiv').style.display = 'block';
    document.getElementById('disableText').innerHTML = "<br /><br /><img src=\"./images/avn-loader.gif\" /><br />Please wait while chapter is being deleted...";
};
_responsedeleteChapter = function(r)
{
    document.getElementById('disableDiv').style.display = 'none';
    if (r != "") {
        if (r.indexOf("|#|") > -1) {
            var resp = r.split("|#|");
            if (parseInt(resp[0]) == 1){                
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Chapter deleted successfully.";
            }
            else if(parseInt(resp[0]) == 3){
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Please delete the topics,resources & questions related to this chapter.";
            }
            else if(parseInt(resp[0]) == 0 || parseInt(resp[0]) > 1 && parseInt(resp[0]) < 3) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "SORRY! chapter could not be deleted.";
            }
            else if(parseInt(resp[0]) == 4) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All selected subjects deleted successfully.";
            }
            else if(parseInt(resp[0]) == 5) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "SORRY! all/some of selected chapter(s) could not be deleted.<br />Please delete the topics of those chapter(s).";
            }
            document.getElementById('bulkAct').style.display = "none";
            _getChapterTable(resp[1],resp[2],resp[3]);
        }
    }
};

_checked = function(c, rid){
    var chk = document.getElementsByName("chkChapter[]");
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
        var tab = document.getElementById('tabChapters');
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
            document.getElementById('chpdatarow-' + rid).className = 'selectedRow';
        } else {
            if (rid % 2 == 0)
                document.getElementById('chpdatarow-' + rid).className = 'lightyellow';
            else
                document.getElementById('chpdatarow-' + rid).className = 'darkyellow';
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
    if (anyChecked)
        document.getElementById('bulkAct').style.display = 'block';
    else
        document.getElementById('bulkAct').style.display = 'none';
};
