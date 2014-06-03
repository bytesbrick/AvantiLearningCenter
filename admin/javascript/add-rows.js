------------By Iqbal Sir (to add dynamic rows)------------

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
	