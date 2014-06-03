_getCurriculumTable = function(page, sf, sd){
    var p = new Array();
    p.push(new Array("page", page));
    p.push(new Array("sf", sf));
    p.push(new Array("sd", sd));
    var aj = new _ajax("./ajax/get-curriculum-table.php", "post",p,function(){_waitGetCurriculumTable()}, function(r){_responseGetCurriculumTable(r)});
    aj._query();
};

_waitGetCurriculumTable = function(){
    document.getElementById('disableDiv').style.height = '150px';
    document.getElementById('disableDiv').style.display = 'block';
};

_responseGetCurriculumTable = function(r){
    document.getElementById('displayUser').innerHTML = r;
    document.getElementById('disableDiv').style.display = 'none';
};

//----------------to delete resource---------
var cachedTableData = "";
_deleteCurriculum = function(uId,page){
	var cnf = false;
	cnf = confirm("Are you sure you want to delete this curriculum?");
	if (cnf) {
            cnf = confirm("Just to remind you that deleted curriculum could not be retrieved.\nDO YOU STILL WANT TO CONTINUE?");
            if (cnf) {
                var rID = 0;
                var tab = document.getElementById('tabCurriculums');
                var currID = "";
                var chk = document.getElementsByName("chkCurriculum[]");
                var chkCount = chk.length;
                if (uId > -1)
                document.getElementById('chk-' + uId).checked = true;
                for (i = 0; i < chkCount; i++){
                    if(chk[i].checked == true){
                        currID += currID == "" ? chk[i].value : "," + chk[i].value;
                    }
                }
                if (currID != "") {
                    var p = new Array();
                    p.push(new Array("uniqueid", currID));
                    p.push(new Array("page", page));
                    var aj = new _ajax("./ajax/delete-curriculum.php" , "post",p,function(){_waitdeleteCurriculum()}, function(r){_responsedeleteCurriculum(r)});
                    aj._query();  
                }
            }
	}
}
_waitdeleteCurriculum = function()
{
        document.getElementById('disableDiv').style.height = _getHeight('displayUser') + 'px';
        document.getElementById('disableDiv').style.display = 'block';
        document.getElementById('disableText').innerHTML = "<br /><br /><img src=\"./images/avn-loader.gif\" /><br />Please wait while curriculum is being deleted...";
};
_responsedeleteCurriculum = function(r)
{
    document.getElementById('disableDiv').style.display = 'none';
    if (r != ""){
        if (r.indexOf("|#|") > -1) {
            var resp = r.split("|#|");
            if (parseInt(resp[0]) == 1) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Curriculum deleted successfully.";
            }
            else if(parseInt(resp[0]) == 0) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "SORRY! curriculum could not be deleted.";
            }
            else if(parseInt(resp[0]) == 3) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All/some of the selected curriculums deleted successfully.";
            }
            else if(parseInt(resp[0]) == 4) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All/some of the selected curriculums  are not deleted successfully.<br /> Please delete the topics of that curriculum.";
            }
            document.getElementById('bulkAct').style.display = 'none';
             _getCurriculumTable(resp[1]);
        }         
    }    
};

_checked = function(c, rid){
    var chk = document.getElementsByName("chkCurriculum[]");
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
        var tab = document.getElementById('tabCurriculums');
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
            document.getElementById('curdatarow-' + rid).className = 'selectedRow';
        } else {
            if (rid % 2 == 0)
                document.getElementById('curdatarow-' + rid).className = 'lightyellow';
            else
                document.getElementById('curdatarow-' + rid).className = 'darkyellow';
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
_paging = function(page){
    var p = new Array();
    p.push(new Array("page", page));
    var aj = new _ajax("./ajax/get-curriculum-table.php", "post",p,function(){_waitGetCurriculumPaging()}, function(r){_responseGetCurriculumPaging(r)});
    aj._query();
}
_waitGetCurriculumPaging = function(){
    
}
_responseGetCurriculumPaging = function(r){
    
    _getCurriculumTable(resp[1]);
}