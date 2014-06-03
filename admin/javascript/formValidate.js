_selAllUsers = function(){
	for(i = 0;  i < document.getElementsByName("chkUser[]").length; i++)
	{
		document.getElementsByName("chkUser[]")[i].checked = document.getElementById("chkall").checked;
	}
};

_pageChanger = function(dllp,link){
	var pageNo = document.getElementById(dllp).value;
	window.location.href=link+'?pageNo=' + pageNo ;

};
_pageChangerimg = function(dllp,hdproid,link){
	var pageNo = document.getElementById(dllp).value;
	var hdproid = document.getElementById(hdproid).value;
	window.location.href=link+'?pageNo=' + pageNo + '&pId=' + hdproid;

};

_deleteconsumer = function(uId)
{
	var chk = false;
	chk = confirm("Do you want to delete this Best For");
	if(chk == true){
		var chk2 = false;
		chk2 = confirm("Are you sure to delete this Best For Data????");
	}
	if(chk2 == true)
	{
		window.location = "./delete-consumer.php?uId=" + uId;
	}
}


//_deleteresource = function(uId,tpid){
//       var chk = false;
//       chk = confirm("Do you want to Delete this Resource");
//       if(chk == true){
//		   var chk2 = false;
//           chk2 = confirm("Are you sure to Delete this Resource Data");
//       }
//	   if(chk2 == true){
//               window.location = "./delete-Resource.php?uId=" + uId + " &tpid=" + tpid;
//       }
//}

_deletecost = function(uId){
       var chk = false;
       chk = confirm("Do you want to Delete this Cost");
       if(chk == true){
		   var chk2 = false;
           chk2 = confirm("Are you sure to Delete this Cost Data");
       }
       if(chk2 == true){
               window.location = "./delete-cost.php?uId=" + uId;
       }
}

_deleteduration = function(uId){
       var chk = false;
       chk = confirm("Do you want to Delete this Duration");
       if(chk == true){
		   var chk2 = false;
           chk2 =  confirm("Are you sure to Delete this Duration Data");
       }
       if(chk2 == true){
               window.location = "./delete-duration.php?uId=" + uId;
       }
}

_deletegrade = function(uId){
	
       var chk = false;
       chk = confirm("Do you want to Delete this Grade");
       if(chk == true){
		   var chk2 = false;
           chk2 = confirm("Are you sure to Delete this Grade Data");
       }
       if(chk2 == true){
               window.location = "./delete-grade.php?uId=" + uId;
       }
}

_deletemedia = function(uId){
       var chk = false;
       chk = confirm("Do you want to Delete this Media Type");
       if(chk == true){
		   var chk2 = false;
           chk2 = confirm("Are you sure to Delete this Media Type Data");
       }
       if(chk2 == true){
               window.location = "./delete-media.php?uId=" + uId;
       }
}

//_deletetopic = function(uId){
//       var chk = false;
//       chk = confirm("Do you want to Delete this Topic");
//       if(chk == true){
//		   var chk2 = false;
//              chk2 = confirm("Are you sure to Delete this Topic Data");
//       }
//       if(chk2 == true){
//               window.location = "./delete-topic.php?uId=" + uId;
//       }
//}

//_deletesubject = function(uId){
//       var chk = false;
//       chk = confirm("Do you want to Delete this Subject");
//       if(chk == true){
//		   var chk2 = false;
//           chk2 = confirm("Are you sure to Delete this Subject Data");
//       }
//       if(chk2 == true){
//               window.location = "./subject-delete.php?uId=" + uId;
//       }
//}

_deletestandard = function(uId){
       var chk = false;
       chk = confirm("Do you want to Delete this Standard");
       if(chk == true){
		   var chk2 = false;
           chk2 = confirm("Are you sure to Delete this Standard Data");
       }
       if(chk2 == true){
               window.location = "./delete-standard.php?uId=" + uId;
       }
}

_deletemskillset = function(uId){
       var chk = false;
       chk = confirm("Do you want to Delete this Skill");
       if(chk == true){
		   var chk2 = false;
              chk2 = confirm("Are you sure to Delete this Skill Data");
       }
       if(chk2 == true){
               window.location = "./delete-skillset.php?uId=" + uId;
       }
}



//------------edited by shariq------------

_deletesubject = function(uId){
       var chk = false;
       chk = confirm("Do you want to Delete this Subject");
       if(chk == true){
		   var chk2 = false;
              chk2 = confirm("Are you sure to delete this Subject");
       }
       if(chk2 == true){
               window.location = "./subject-delete.php?uId=" + uId;
       }
}

//_deletechapter = function(uId){
//       var chk = false;
//       chk = confirm("Do you want to Delete this Chapter");
//       if(chk == true){
//		   var chk2 = false;
//              chk2 = confirm("Are you sure to delete this Chapter Data");
//       }
//       if(chk2 == true){
//               window.location = "./delete-chapter.php?uId=" + uId;
//       }
//}
//_deletetopic = function(uId){
//       var chk = false;
//       chk = confirm("Do you want to Delete this Topic");
//       if(chk == true){
//		   var chk2 = false;
//              chk2 = confirm("All the resources of this topic will be deleted permanently");
//       }
//       if(chk2 == true){
//               window.location = "./delete-topic.php?uId=" + uId;
//       }
//}
_deletecurriculum = function(uId){
       var chk = false;
       chk = confirm("Do you want to Delete this Curriculum");
       if(chk == true){
		   var chk2 = false;
              chk2 = confirm("Are you sure to this Curriculum");
       }
       if(chk2 == true){
               window.location = "./delete-curriculum.php?uId=" + uId;
       }
}
_deletetag = function(uId){
       var chk = false;
       chk = confirm("Do you want to Delete this Tag");
       if(chk == true){
		   var chk2 = false;
              chk2 = confirm("Are you sure to this Tag");
       }
       if(chk2 == true){
               window.location = "./delete-tag.php?uId=" + uId;
       }
}
//_deletequestion = function(uId,resid,cid,type){
//	var chk = false;
//       chk = confirm("Do you want to Delete this Question");
//       if(chk == true){
//		   var chk2 = false;
//              chk2 = confirm("Are you sure to delete this Question");
//       }
//       if(chk2 == true){
//               window.location = "./delete-spot-test.php?uId=" + uId +"&resid=" + resid +"&cid=" + cid +"&type=" + type;
//       }
//}
//------------By Iqbal Sir (to add dynamic rows)------------

    var rID = 1;
        var arrRows = new Array();
        arrRows.push(rID);
        _addNewField = function(pid){
            var tab = document.getElementById('dTab');
            
            var oldBtn = document.getElementById(pid);
            oldBtn.src = "./images/minus.png";
            oldBtn.setAttribute ("onclick", "javascript: _removeField(" + rID + ");");
            oldBtn.id = "minus-" + eval(tab.rows.length - 1);
            
            tab.insertRow(tab.rows.length);
            var newRow = tab.rows[tab.rows.length - 1];
            newRow.id = "row-" + rID;
            //newRow.setAttribute("id", "row-" + rCount);
            newRow.insertCell(0);
            var newCell = newRow.cells[0];
            var tBox = document.createElement("input");
            tBox.name = "txtFlds[]";
	     tBox.className = "txtwdh";
            tBox.id = "txtFlds-" + eval(tab.rows.length - 1);
            //tBox.value = eval(rID + 1);
            newCell.appendChild(tBox);
            
	    newRow.insertCell(1);
            newCell = newRow.cells[1];
            var plusBtn = document.createElement("img");
            plusBtn.src = "./images/plus.png";
            plusBtn.id = "plus";
            plusBtn.setAttribute ("onclick", "javascript: _addNewField(this.id);");
            newCell.appendChild(plusBtn);
            
            rID++;
            
            arrRows.push(rID);
        };
        
        _removeField = function(rowid){
            var tab = document.getElementById('dTab');
            var iF = -1;
            for (i = 0; i < arrRows.length; i++) {
                if (rowid == arrRows[i]) {
			
                    iF = i;
                    break;
                }
            }
            if (iF > -1) {
                tab.deleteRow(iF);
                arrRows.splice(iF, 1);
            }            
        };
	
	
	
	var rVID = 1;
        var arrRows = new Array();
        arrRows.push(rVID);
        _addNewVideoField = function(pid){
            var tab = document.getElementById('dVideoTab');
            
            var oldBtn = document.getElementById(pid);
            oldBtn.src = "./images/minus.png";
            oldBtn.setAttribute ("onclick", "javascript: _removeVideoField(" + rVID + ");");
            oldBtn.id = "Videominus-" + eval(tab.rows.length - 1);
            
            tab.insertRow(tab.rows.length);
            var newRow = tab.rows[tab.rows.length - 1];
            newRow.id = "row-" + rVID;
            //newRow.setAttribute("id", "row-" + rCount);
            newRow.insertCell(0);
            var newCell = newRow.cells[0];
            var tBox = document.createElement("input");
            tBox.name = "txtVideoFlds[]";
	     tBox.className = "txtwdh";
            tBox.id = "txtVideoFlds-" + eval(tab.rows.length - 1);
            //tBox.value = eval(rID + 1);
            newCell.appendChild(tBox);
            
	    newRow.insertCell(1);
            newCell = newRow.cells[1];
            var plusBtn = document.createElement("img");
            plusBtn.src = "./images/plus.png";
            plusBtn.id = "videoplus";
            plusBtn.setAttribute ("onclick", "javascript: _addNewVideoField(this.id);");
            newCell.appendChild(plusBtn);
            
            rVID++;
            
            arrRows.push(rVID);
        };
        
        _removeVideoField = function(rowid){
            var tab = document.getElementById('dVideoTab');
            var iF = -1;
            for (i = 0; i < arrRows.length; i++) {
                if (rowid == arrRows[i]) {
                    iF = i;
                    break;
                }
            }
            if (iF > -1) {
                tab.deleteRow(iF);
                arrRows.splice(iF, 1);
            }            
        };
	
/*for display div height*/
_getHeight = function(eID){
	if(document.getElementById(eID).offsetHeight < 150){
		return 200;
	} else {
		return parseInt(document.getElementById(eID).offsetHeight) + 100;
	}
}
/*----------function to create slug-----------*/
_createSlug = function(s, d, f, t){
    s = s.toLowerCase();
    s = s.replace(/[^a-z0-9]+/g, "-");
    s = s.replace(/^-|-$&/g, "");    
    document.getElementById(d).value = s;
    if (document.getElementById("hdCurrentSlug")) {
	if (document.getElementById("hdCurrentSlug").value != s) {
		setTimeout("_checkslug('" + d + "', '" + f + "', '" + t + "')", 500);
	}
    }
    if (document.getElementById("hdIsSlugAdd")) {
	if (document.getElementById("hdIsSlugAdd").value == 0) {
		setTimeout("_checkslug('" + d + "', '" + f + "', '" + t + "')", 500);
	}
    }
};
/*----------function to check slug-----------*/
_checkslug = function(sltxt,field,table){
    var slug = document.getElementById(sltxt).value;
    if (slug != ""){
	if (document.getElementById("hdCurrentSlug")) {
		if (document.getElementById("hdCurrentSlug").value != slug) {
			var p = new Array();
			p.push(new Array("slug", slug));
			p.push(new Array("field", field));
			p.push(new Array("table", table));
			var aj = new _ajax("./ajax/createslug.php", "post",p,function(){_waitcreateslug()}, function(r){_responsecreateslug(r)});
			aj._query();	
		}	
	}
	if (document.getElementById("hdIsSlugAdd")){
		if(document.getElementById("hdIsSlugAdd").value == 0) {
			var p = new Array();
			p.push(new Array("slug", slug));
			p.push(new Array("field", field));
			p.push(new Array("table", table));
			var aj = new _ajax("./ajax/createslug.php", "post",p,function(){_waitcreateslug()}, function(r){_responsecreateslug(r)});
			aj._query();
		}
	}
    } 
};

_waitcreateslug = function(){
   document.getElementById('imgslug').style.display = 'none';
   document.getElementById('msg').style.display = 'none';
};

_responsecreateslug = function(r){
    if (r == 2) {
        document.getElementById('imgslug').style.display = 'block';
        document.getElementById('imgslug').innerHTML = "<img src=\"./images/correct-ans.png\" width=\"17px\" style=\" margin-left:5px;\" />";
        document.getElementById('hdIsValidSlug').value = "1";
    }
    else if(r == 1){
        document.getElementById('imgslug').style.display = 'block';
        document.getElementById('msg').style.display = 'block';
        document.getElementById('imgslug').innerHTML = "<img src=\"./images/wrong-ans.png\" width=\"17px\" style=\" margin-left:5px;\" />";
        document.getElementById('msg').innerHTML = "Slug already exists.";
        document.getElementById('hdIsValidSlug').value = "0";
	document.getElementById('btnSave').disabled = true;
	document.getElementById('btnUpdate').disabled = true;
    }
    document.getElementById('btnSave').value = "Save";
    document.getElementById('btnSave').disabled = false;
    document.getElementById('btnUpdate').value = "Update";
    document.getElementById('btnUpdate').disabled = false;
};
_checkduplicacy = function(code, field, table){
	var centercode = document.getElementById(code).value;
	if (centercode != "") {
		if (document.getElementById("hdCurrentdulicacy")){
				if (document.getElementById("hdCurrentdulicacy").value != centercode) {
				var p =  new Array();
				p.push(new Array("code", centercode));
				p.push(new Array("field", field));
				p.push(new Array("table", table));
				var aj = new _ajax("./ajax/checkduplicacy.php", "post",p,function(){_waitcheckduplicacy()}, function(r){_responsecheckduplicacy(r)});
				aj._query();
			}
		}
		if(document.getElementById("hdIsduplicacyAdd")){
			if(document.getElementById("hdIsduplicacyAdd").value == 0){
				var p =  new Array();
				p.push(new Array("code", centercode));
				p.push(new Array("field", field));
				p.push(new Array("table", table));
				var aj = new _ajax("./ajax/checkduplicacy.php", "post",p,function(){_waitcheckduplicacy()}, function(r){_responsecheckduplicacy(r)});
				aj._query();
			}
		}
	}
}
_waitcheckduplicacy = function(){
   document.getElementById('imgchk').style.display = 'none';
   document.getElementById('msgchk').style.display = 'none';
   document.getElementById('btnSave').value = "Checking ...";
   document.getElementById('btnSave').disabled = true;
   document.getElementById('btnUpdate').value = "Checking ...";
   document.getElementById('btnUpdate').disabled = true;
};

_responsecheckduplicacy = function(r){ 
    if (r == 2){
        document.getElementById('msgchk').style.display = 'block';
        document.getElementById('msgchk').innerHTML = "<img src=\"./images/correct-ans.png\" width=\"17px\" style=\" margin-left:5px;\" />";
        document.getElementById('hdIsValidSlug').value = "1";
    }
    else if(r == 1){
        document.getElementById('imgchk').style.display = 'block';
	document.getElementById('msgchk').style.display = 'block';
        document.getElementById('imgchk').innerHTML = "<img src=\"./images/wrong-ans.png\" width=\"17px\" style=\" margin-left:5px;\" />";
        document.getElementById('msgchk').innerHTML = "This is already exist.";
        document.getElementById('hdIsValidSlug').value = "0";
	document.getElementById('btnSave').disabled = true;
	document.getElementById('btnUpdate').disabled = true;
    }
    document.getElementById('btnSave').value = "Save";
    document.getElementById('btnSave').disabled = false;
    document.getElementById('btnUpdate').value = "Update";
    document.getElementById('btnUpdate').disabled = false;
};

_uploadCSV = function(flName){
	document.getElementById("bkUpload").innerHTML = flName;
	document.getElementById("uploadform").submit();
	document.getElementById("ErrMsg").style.display = "block";
	document.getElementById("ErrMsg").innerHTML = "Please wait while file is getting uploaded...";
}

function doneCSVUpload(rezultat) {
// decode (urldecode) the parameter wich is encoded in PHP with 'urlencode'
rezultat = decodeURIComponent(rezultat.replace(/\+/g,  " "));

// add the value of the parameter inside tag with 'id=showimg'
//alert(rezultat);
    if (rezultat.indexOf("./csv/") > -1) {
	rezultat = rezultat.replace("./", webVirPath);
	_getStudentTable(1,'','');
	document.getElementById("ErrMsg").innerHTML = "File has been uploaded successfully. Refreshing table now...";
    }
}