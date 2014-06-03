_getTagTable = function(page,sf,sd){
    var p = new Array();
    p.push(new Array("page", page));
    p.push(new Array("sf", sf));
    p.push(new Array("sd", sd));
    var aj = new _ajax("./ajax/get-tag-table.php", "post",p,function(){_waitGetTagTable()}, function(r){_responseGetTagTable(r)});
    aj._query();
};

_waitGetTagTable = function(){
    document.getElementById('disableDiv').style.height = '150px';
    document.getElementById('disableDiv').style.display = 'block';
};

_responseGetTagTable = function(r){
    document.getElementById('displayUser').innerHTML = r;
    document.getElementById('disableDiv').style.display = 'none';
};
_deletetag = function(uId,page){
var cnf = false;
    cnf = confirm("Are you sure you want to delete this grade?");
    if (cnf) {
        cnf = confirm("Just to remind you that deleted tag could not be retrieved.\nDO YOU STILL WANT TO CONTINUE?");
        if (cnf) {
            var rID = 0;
            var tab = document.getElementById('tabTag');
            var tagID = "";
            var chk = document.getElementsByName("chkTag[]");
            var chkCount = chk.length;
            if (uId > -1)
            document.getElementById('chk-' + uId).checked = true;
            for (i = 0; i < chkCount; i++){
                if(chk[i].checked == true){
                    tagID += tagID == "" ? chk[i].value : "," + chk[i].value;
                }
            }
            if (tagID != "") {
               var p = new Array();
                p.push(new Array("uniqueid", tagID));
                p.push(new Array("page", page));
                var aj = new _ajax("./ajax/delete-tag.php" , "post",p,function(){_waitdeletetag()}, function(r){_responsedeletetag(r)});
                aj._query(); 
            }   
        }
    }		
}
_waitdeletetag = function()
{
    document.getElementById('disableDiv').style.height = _getHeight('displayUser') + 'px';
    document.getElementById('disableDiv').style.display = 'block';
    document.getElementById('disableText').innerHTML = "<br /><br /><img src=\"./images/avn-loader.gif\" /><br />Please wait while tag is being deleted...";
};
_responsedeletetag = function(r)
{
    document.getElementById('disableDiv').style.display = 'none';
    if (r != "") {
        if (r.indexOf("|#|") > -1) {
            var resp = r.split("|#|");
            if (parseInt(resp[0]) == 1) {                
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Tag deleted successfully.";
            }
            else if(parseInt(resp[0]) == 0) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "SORRY! tag could not be deleted.";
            }
            else if(parseInt(resp[0]) == 2) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "SORRY! tag could not be deleted.";
            }
            else if(parseInt(resp[0]) == 3) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "SORRY! tag could not be deleted.<br />Please delete the resources of this tag.";
            }
            else if(parseInt(resp[0]) == 4) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All/some selected tags deleted successfully.";
            }
            else if(parseInt(resp[0]) == 5) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All/some selected tags not deleted successfully.";
            }
            else if(parseInt(resp[0]) == 6) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All/some selected tags not deleted successfully.<br />Please delete the resources of those tags.";
            }
            document.getElementById('bulkAct').style.display = 'none';
            _getTagTable(resp[1]);
        }
    }
};

_checked = function(c, rid){
    var chk = document.getElementsByName("chkTag[]");
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
        var tab = document.getElementById('tabTag');
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
            document.getElementById('tagrow-' + rid).className = 'selectedRow';
        } else {
            if (rid % 2 == 0)
                document.getElementById('tagrow-' + rid).className = 'lightyellow';
            else
                document.getElementById('tagrow-' + rid).className = 'darkyellow';
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