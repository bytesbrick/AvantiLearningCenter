var doObjectID = "";
var moObjectID = "";	
	function _setDivPos(divElem)
	{
		var divX, divY;
		var scrWidth, scrHeight;
		var scrollX, scrollY;
		divX = divY = 0;
		scrollX = scrollY = 0;
		var brsName;
		var brsVer;
		var brsDetails = navigator.userAgent;
		var cssItem;
		if(brsDetails.toLowerCase().indexOf("msie") >= 0)
		{
			brsName = "msie";
			brsVers = brsDetails.split(";");
			brsShortName = brsVers[1];
			brsShortName = brsShortName.split(" ");
			brsVer = parseInt(brsShortName[2]);
		}
		else if(brsDetails.toLowerCase().indexOf("firefox") >= 0)
		{
			brsName = "firefox";
			brsVers = brsDetails.split(" ");
			brsShortName = brsVers[brsVers.length - 1];
			brsShortName = brsShortName.split("/");
			brsVer = parseInt(brsShortName[1]);
		}
		if(brsName == "firefox")
		{
			scrollX = window.pageXOffset;
			scrollY = window.pageYOffset;
		}
		else if(brsName == "msie" && brsVer>6)
		{
			scrollX = document.documentElement.scrollLeft;
			scrollY = document.documentElement.scrollTop;
		}
		else
		{
			scrollX = document.body.scrollLeft;
			scrollY = document.body.scrollTop;
		}
		scrWidth = screen.availWidth;
		scrHeight =  screen.availHeight;
		
		if(typeof (divElem) == "string")
        {
            if(document.getElementById(divElem))
                divElem = document.getElementById(divElem);
        }
        else
            divElem = divElem;

		divElem.style.display = "block";
		var divW = parseInt(divElem.style.width);
		if(isNaN(divW) == true)
			divW = parseInt(divElem.offsetWidth);
		if(isNaN(divW) == true)
			divW = 0;
	
		var divH = parseInt(divElem.style.height);
		if(isNaN(divH) == true)
			divH = parseInt(divElem.offsetHeight);
		if(isNaN(divH) == true)
			divH = 0;

		divX = (parseInt(scrWidth/2) + scrollX) - parseInt(divW/2);
		divY = (parseInt(scrHeight/3) + scrollY) - parseInt(divH/2);
		if(divX < scrollX)
			divX = scrollX + 10;
		if(divY < scrollY)
			divY = scrollY + 10;

		divElem.style.left = divX + "px";
		divElem.style.top =	divY + "px";
	};
	
	_findXYPosInBody = function(objID)
    {
        var objTagName = "";
        var objectID;
        //alert(objID);
        if(typeof (objID) == "string")
        {
            if(document.getElementById(objID))
            {
                objectID = document.getElementById(objID);
                objTagName = objectID.tagName;
            }
        }
        else
        {
            objectID = objID;
            objTagName = objID.tagName;
        }
        var posX = posY = 0
        while(objTagName.toString().toLowerCase() != "body" && objTagName.toString().toLowerCase() != "html")
        {
            posX += objectID.offsetLeft;
            posY += objectID.offsetTop;
            objectID = objectID.offsetParent;
            objTagName = objectID.tagName;
        }
        return (posX + "," + posY);
    };

    _showFloatingObject = function(refObjId, dispObjId, addX, addY, calMode){
        doObjectID = dispObjId;
        var dispObj = document.getElementById(dispObjId);
        dispObj.style.display = dispObj.style.display == "block" ? "none" : "block";
        if(dispObj.style.display == "block")
        {
            var coord = _findXYPosInBody(refObjId);
            var coords = coord.split(",");
            var xA = parseInt(coords[0]);
            var yA = parseInt(coords[1]);
            dispObj.style.left = (xA + (addX)) + "px";
            dispObj.style.top = (yA + (addY)) + "px";
        }
        if(calMode == 1)
        {
            document.onmousedown = _hideFloatingObject;
            document.onmouseup = _hideFloatingObject;
            window.onmousedown = _hideFloatingObject;
            window.onmouseup = _hideFloatingObject;
        }
    };

	_hideFloatingObject = function(ev1){
        if(!ev1) var ev1 = window.event;
	    var sender = (typeof( window.event ) != "undefined" ) ? ev1.srcElement : ev1.target;
	    var senderTagName = sender.tagName.toString().toLowerCase();
        var isClickable = false;
        while(senderTagName.toString().toLowerCase() != "body" && senderTagName.toString().toLowerCase() != "html")
        {
            if(sender.id.toString().toLowerCase() == doObjectID.toString().toLowerCase())
                isClickable = true;
            sender = sender.offsetParent;
            senderTagName = sender.tagName;
        }
	    if(!isClickable)
	    {
	        try
	        {
                var dispObj = document.getElementById(doObjectID);
                dispObj.style.display = "none";
            }
            catch(e){}
        }
    };

	_showMouseOverObject = function(refObjId, dispObjId, addX, addY, calMode){
		if(doObjectID != "" && doObjectID != undefined)
			_hideFloatingObjectWithID(doObjectID);
		doObjectID = dispObjId;
        moObjectID = refObjId;
		if(document.getElementById(moObjectID).className == "")
			document.getElementById(moObjectID).className = "moverMenu";
        var dispObj = document.getElementById(dispObjId);
        dispObj.style.display = dispObj.style.display == "block" ? "none" : "block";
        if(dispObj.style.display == "block")
        {
            var coord = _findXYPosInBody(refObjId);
            var coords = coord.split(",");
            var xA = parseInt(coords[0]);
            var yA = parseInt(coords[1]);
            dispObj.style.left = (xA + (addX)) + "px";
            dispObj.style.top = (yA + (addY)) + "px";
        }
        if(calMode == 1)
        {
            document.onmousedown = _hideMouseOverObject;
            document.onmouseup = _hideMouseOverObject;
			document.onmouseover = _hideMouseOverObject;
            window.onmousedown = _hideMouseOverObject;
            window.onmouseup = _hideMouseOverObject;
			window.onmouseover = _hideMouseOverObject;
        }
	 };

	_hideMouseOverObject = function(ev1){
        if(!ev1) var ev1 = window.event;
	    var sender = (typeof( window.event ) != "undefined" ) ? ev1.srcElement : ev1.target;
	    var senderTagName = sender.tagName.toString().toLowerCase();
        var isMouseOver = false;
        while(senderTagName.toString().toLowerCase() != "body" && senderTagName.toString().toLowerCase() != "html")
        {
            if(sender.id.toString().toLowerCase() == moObjectID.toString().toLowerCase() || sender.id.toString().toLowerCase() == doObjectID.toString().toLowerCase())
                isMouseOver = true;
            sender = sender.offsetParent;
            senderTagName = sender.tagName;
        }
	    if(!isMouseOver)
	    {
	        try
	        {
                var dispObj = document.getElementById(doObjectID);
                dispObj.style.display = "none";
				if(document.getElementById(moObjectID).className == "moverMenu")
					document.getElementById(moObjectID).className = "";
            }
            catch(e){}
        }
    };
    
    _hideFloatingObjectWithID = function(objID){
        try
        {
            var dispObj = document.getElementById(objID);
            dispObj.style.display = "none";
            document.onmousedown = null;
            document.onmouseup = null;
            window.onmousedown = null;
            window.onmouseup = null;
			if(document.getElementById(moObjectID).className == "moverMenu")
				document.getElementById(moObjectID).className = "";
        }
        catch(e){}
    };


