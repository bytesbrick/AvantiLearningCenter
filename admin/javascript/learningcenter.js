_getCentertable = function(page,sf,sd){
    var p = new Array();
    p.push(new Array("page", page));
    p.push(new Array("sf", sf));
    p.push(new Array("sd", sd));
    var aj = new _ajax("./ajax/get-center-table.php", "post",p,function(){_waitGetCenterTable()}, function(r){_responseGetCenterTable(r)});
    aj._query();
};

_waitGetCenterTable = function(){
    document.getElementById('disableDiv').style.height = _getHeight('displayUser') + 'px';
    document.getElementById('disableDiv').style.display = 'block';
};

_responseGetCenterTable = function(r){
    document.getElementById('displayUser').innerHTML = r;
    document.getElementById('disableDiv').style.display = 'none';
    document.getElementById('disableText').innerHTML = "<br /><br /><img src=\"./images/avn-loader.gif\" /><br />Please wait while sorting is being done..."
};
_deletecenter = function(uId,page){
var cnf = false;
    cnf = confirm("Are you sure you want to delete this center?");
    if (cnf) {
        cnf = confirm("Just to remind you that deleted center could not be retrieved.\nDO YOU STILL WANT TO CONTINUE?");
        if (cnf) {
            var rID = 0;
            var tab = document.getElementById('tabCenter');
            //var cachedTableData = document.getElementById('tabCategory').innerHTML;
            var catgID = "";
            var chk = document.getElementsByName("chkCenter[]");
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
                var aj = new _ajax("./ajax/delete-center.php" , "post",p,function(){_waitdeleteCity()}, function(r){_responsedeleteCity(r)});
                aj._query();    
            }
        }
    }		
}
_waitdeleteCity = function()
{
    document.getElementById('disableDiv').style.height = _getHeight('displayUser') + 'px';
    document.getElementById('disableDiv').style.display = 'block';
    document.getElementById('disableText').innerHTML = "<br /><br /><img src=\"./images/avn-loader.gif\" /><br />Please wait while city is being deleted...";
};
_responsedeleteCity = function(r)
{
    document.getElementById('disableDiv').style.display = 'none';
    if (r != "") {
        if (r.indexOf("|#|") > -1) {
            var resp = r.split("|#|");
            if (parseInt(resp[0]) == 1) {                
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Center deleted successfully.";
            }
            else if (parseInt(resp[0]) == 3) {                
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Please delete the learning centers of this center.";
            }
            else if(parseInt(resp[0]) == 0 || parseInt(resp[0]) > 1 && parseInt(resp[0]) < 3) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "SORRY! center could not be deleted.";
            }
            else if(parseInt(resp[0]) == 4) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All selected centers deleted successfully.";
            }
            else if(parseInt(resp[0]) == 5) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "SORRY! all/some of selected centers could not be deleted.<br />Please delete the curriculums of those cities(s).";
            }
            document.getElementById('bulkAct').style.display = "none";
            _getCentertable(resp[1]);
        }
    }
};

_checked = function(c, rid){
    var chk = document.getElementsByName("chkCenter[]");
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
        var tab = document.getElementById('tabCenter');
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
            document.getElementById('centerRow-' + rid).className = 'selectedRow';
        } else {
            if (rid % 2 == 0)
                document.getElementById('centerRow-' + rid).className = 'lightyellow';
            else
                document.getElementById('centerRow-' + rid).className = 'darkyellow';
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