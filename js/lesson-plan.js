var WEBROOT = "http://localhost:8080/avanti/";
//var WEBROOT = "http://beta.peerlearning.com/";
_checked = function(c, rid, mode){
    var chk = document.getElementsByName("chkUser[]");
    var chkCount = chk.length;
    var anyChecked = false;
    if (mode == 2) {
        var act = false;
        if (c.innerHTML == 'Select All'){
            act = true;
            document.getElementById("chpAll").innerHTML = "Unselect All";
            document.getElementById("linkAct").style.display = "block";
        } else {
            document.getElementById("chpAll").innerHTML = "Select All";
            document.getElementById("linkAct").style.display = "none";
        }
    
        for (i = 0; i < chkCount; i++)
            chk[i].checked = act;   
    } else if (mode == 1) {
        var tC = 0;
        for (i = 0; i < chkCount; i++){
            if (chk[i].checked)
               tC++;
        }
        if (tC > 0)
            document.getElementById("linkAct").style.display = "block";
        else
            document.getElementById("linkAct").style.display = "none";
            
        if (tC >= chkCount)
            document.getElementById("chpAll").innerHTML = "Unselect All";
        else
            document.getElementById("chpAll").innerHTML = "Select All";
    }
};

_complete = function(uId, value){
    var chk = document.getElementsByName("chkUser[]");
    var chkCount = chk.length;
    var tC = 0;
    for (i = 0; i < chkCount; i++){
        if (chk[i].checked)
            tC++;
    }   
    if (tC > 0){
        if (value > -1){
            var rID = 0;
            var tab = document.getElementById('tabLeadusers');
            var topicID = "";
            var chk = document.getElementsByName("chkUser[]");
            var chkCount = chk.length;
            if (uId > -1)
            document.getElementById('chk-' + uId).checked = true;
            for (i = 0; i < chkCount; i++){
                if(chk[i].checked == true){
                    topicID += topicID == "" ? chk[i].value : "," + chk[i].value;
                }
            }
            if (topicID != ""){
                var p = new Array();
                p.push(new Array("uniqueid", topicID));
                p.push(new Array("value", value));
                var aj = new _ajax(WEBROOT + "ajax/save-lesson-plan.php" , "post",p,function(){_waitCompleteTopic()}, function(r){_responseCompleteTopic(r)});
                aj._query();  
            }
        }
    }
    else{
        var cnf = false;
        cnf = confirm("Please choose atleast one topic.");
    }
}
_waitCompleteTopic = function()
{
    document.getElementById('tabLeadusers').innerHTML = "<img src=\"" + WEBROOT + "/images/image.gif\" style=\"left:54%;top:50%;position:absolute;\" id=\"imgajax\">";
};
_responseCompleteTopic = function(r)
{
    document.getElementById('ErrMsg').innerHTML  = "";
    if (r != "") {
        var resp = r.split("|#|");
        if (resp[1] == 1) {
            if (resp[0] == 1) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Topic marked completed successfully.";
            }else if (resp[0] == 2) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Topics marked completed successfully.";
            }
            else if(resp[0] == 3){
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All the selected topics marked completed successfully.";
            }
            else if(resp[0] == 4) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All the topics marked completed successfully.";
            }   
        }
        else if (resp[1] == 0) {
            if (resp[0] == 1) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Topic marked incompleted successfully.";
            }else if (resp[0] == 2) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Topics marked incompleted successfully.";
            }
            else if(resp[0] == 3){
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All the selected topics marked incompleted successfully.";
            }
            else if(resp[0] == 4) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All the topics marked incompleted successfully.";
            } 
        }
        document.getElementById('linkAct').style.display = "none";
        _applyFilter();
    }
};

var aj;
var p = new Array();
_updateParam = function(k, v){
    var iF = -1;
    for(c = 0; c < p.length; c++){
        if(p[c][0] == k){
            iF = c;
            break;
        }
    }
    if(iF <= -1)
        p.push(new Array(k, v));
    else{
        p[iF][1] = v;
    }
}
_subjectFilter = function(chkAllsubject,type, id, value, action, mode){
    var name = document.getElementsByName(type);
    var iF = -1;
    for(c = 0; c < p.length; c++){
        if(p[c][0] == type){
            iF = c;
            break;
        }
    }
    if (mode == "all") {
        if (document.getElementById(value).checked == true) {
            var allSub = document.getElementsByName(type);
            for(c = 0; c < allSub.length; c++)
            allSub[c].checked = false;
        } 
    }
    //} else {
    //    if (iF > -1)
    //    p.splice(iF, 1);
    //}
    if(document.getElementById(id)){
        var cObj = document.getElementById(id);
        switch(cObj.type){
            case "checkbox":
                var objName = cObj.name;
                var allObj = document.getElementsByName(objName);
                var strVal = "";
                var tc= 0;
                for(c = 0; c < allObj.length; c++){
                    if(allObj[c].checked == true){
                        tc++;
                        strVal += strVal == "" ? allObj[c].value : "," + allObj[c].value;
                    }
                }
                if (tc == allObj.length)
                    document.getElementById(chkAllsubject).checked = true;
                else {
                    if (tc > 0)
                        document.getElementById(chkAllsubject).checked = false;
                    else
                        document.getElementById(chkAllsubject).checked = true;
                }
                if(strVal != ""){
                    if(iF <= -1)
                        p.push(new Array(type, strVal));
                    else{
                        p[iF][1] = strVal;
                    }
                }
                else{
                    p.splice(iF, 1);
                    if (mode == "single")
                        document.getElementById(chkAllsubject).checked = true;
                    else {
                        if (document.getElementById(chkAllsubject).checked == true){
                            if (p.length <= 0) {
                                if (action == "Starred") {
                                    p.push(new Array("action", "Starred"));
                                }
                                else if (action == "Incomplete") {
                                    p.push(new Array("action", "Incomplete"));
                                }
                                else if (action == "Complete") {
                                    p.push(new Array("action", "Complete"));
                                }
                            }
                        }
                    }
                }
            break;
            case "select-one":
                p.push(new Array(type, value));
            break;
        }
    }
    _applyFilter();
};
_applyFilter = function(){
    var aj = new _ajax(WEBROOT + "ajax/filter-subject.php" , "post",p, function(){_waitSubjectApplyFilter()},  function(r){_responseSubjectApplyFilter(r)});
    aj._query();    
}
_waitSubjectApplyFilter = function(){
    document.getElementById("loader").innerHTML = "<img src=\"" + WEBROOT + "/images/image.gif\" style=\"left:54%;top:52%;position:absolute;\" id=\"imgajax\">";
}
_responseSubjectApplyFilter = function(r){
    document.getElementById('ErrMsg').innerHTML  = "";
    document.getElementById("loader").innerHTML = "";
    var resp = r;
    var regspl = resp.split("|#|");
    var pg = -1;
    for (i = 0; i < p.length; i++) {
        if (p[i][0] == "page") {
            pg = p[i][1];
        }
    }
    if(regspl[0] != "" && regspl[0] == 1){
        var row =  document.getElementById("tabLeadusers").rows.length;
        if (pg > 1) {
            document.getElementById("tabLeadusers").deleteRow(row - 1);
            document.getElementById("topicsList").innerHTML += regspl[1];
        } else {
            document.getElementById("topicsList").innerHTML = regspl[1];
        }
        
    }
    else if (regspl[0] == 0) {
        if (pg > 1) {
            document.getElementById("tabLeadusers").deleteRow(row - 1);
            document.getElementById("topicsList").innerHTML += regspl[1];
        } else {
            document.getElementById("topicsList").innerHTML = regspl[1];
        }
    }
}

_starred = function(uId, value){
    var chk = document.getElementsByName("chkUser[]");
    var chkCount = chk.length;
    var tC = 0;
    for (i = 0; i < chkCount; i++){
        if (chk[i].checked) 
            tC++;
    }   
    if (tC > 0){
        if (value > -1){
            var rID = 0;
            var tab = document.getElementById('tabLeadusers');
            var topicID = "";
            var chk = document.getElementsByName("chkUser[]");
            var chkCount = chk.length;
            if (uId > -1)
            document.getElementById('chk-' + uId).checked = true;
            for (i = 0; i < chkCount; i++){
                if(chk[i].checked == true){
                    topicID += topicID == "" ? chk[i].value : "," + chk[i].value;
                }
            }
            if (topicID != ""){
                var p = new Array();
                p.push(new Array("uniqueid", topicID));
                p.push(new Array("value", value));
                var aj = new _ajax(WEBROOT + "ajax/starred-lesson-plan.php" , "post",p,function(){_waitStarredTopic()}, function(r){_responseStarredTopic(r)});
                aj._query();  
            }
        }
    }
    else{
        var cnf = false;
        cnf = confirm("Please choose atleast one topic.");
    }
}
_waitStarredTopic = function()
{
    document.getElementById('tabLeadusers').innerHTML = "<img src=\"" + WEBROOT + "/images/image.gif\" style=\"left:54%;top:54%;position:absolute;\" id=\"imgajax\">";
};
_responseStarredTopic = function(r)
{
    document.getElementById('ErrMsg').innerHTML  = "";
    if (r != "") {
        var resp = r.split("|#|");
        if (resp[1] == 1) {
            if (resp[0] == 1) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Topic marked starred successfully.";
            }else if (resp[0] == 2) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Topics marked starred successfully.";
            }
            else if(resp[0] == 3){
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All the selected topics starred completed successfully.";
            }
            else if(resp[0] == 4) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All the topics marked starred successfully.";
            }   
        }
        else if (resp[1] == 0) {
            if (resp[0] == 1) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Topic marked Unstarred successfully.";
            }else if (resp[0] == 2) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "Topics marked Unstarred successfully.";
            }
            else if(resp[0] == 3){
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All the selected topics Unstarred incompleted successfully.";
            }
            else if(resp[0] == 4) {
                document.getElementById('ErrMsg').style.display = "block";
                document.getElementById('ErrMsg').innerHTML = "All the topics marked Unstarred successfully.";
            } 
        }
        document.getElementById('linkAct').style.display = "none";
        _applyFilter();
    }
};

_singleStarred = function(uid, act, t){
    if (uid != "" && parseInt(uid) > 0){
        var p = new Array();
        p.push(new Array("uniqueid", uid));
        p.push(new Array("value", act));
        var aj = new _ajax(WEBROOT + "ajax/starred-lesson-plan.php" , "post",p,function(){_waitSingleStarred()}, function(r){_responseSingleStarred(r)});
        aj._query();
        var st = new Image();
        if (act == 0){
            st.src = WEBROOT + "images/unstar.png";
            t.onclick = function (){_singleStarred(uid, 1, t);}
        }
        else if(act == 1){
            st.src = WEBROOT + "images/star.png";
            t.onclick = function (){_singleStarred(uid, 0, t);}
        }
        document.getElementById('btnStar-' + uid).src = st.src;
    }
};
_waitSingleStarred = function(){};
_responseSingleStarred = function(r){}