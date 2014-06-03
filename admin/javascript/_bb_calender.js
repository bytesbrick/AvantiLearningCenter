	var startDate = 0;
	var startMonth = 0;
	var startYear = 0;
	var bsrName = "";
	function _showCalender(cDate, dFormat, calMode, valObj, posObj)
	{
		var usrAgent = navigator.userAgent;
		if(usrAgent.indexOf("MSIE 6.0") > -1)
			bsrName = "msie6";
		else
			bsrName = "others";

		if(cDate.indexOf("/") > -1)
			cDates = cDate.split("/");
		else if(cDate.indexOf("-") > -1)
			cDates = cDate.split("-");
		
		var cDt = new Date();
		var cDay = cDates[2];
		if(cDay <= 0)
			cDay = cDt.getDate();
		var cMonth = cDates[1] - 1;
		if(cMonth <= 0)
			cMonth = cDt.getMonth();
		var cYear = cDates[0];
		if(cYear <= 0)
			cYear = cDt.getFullYear();
		
		cDt.setDate(cDay);
		cDt.setMonth(cMonth);
		cDt.setYear(cYear);
		if(calMode == 1)
		{
			startDate = cDay;
			startMonth = cMonth;
			startYear = parseInt(cYear);
		}

		var fDtOfMonth = new Date();
		fDtOfMonth.setDate(1);
		fDtOfMonth.setMonth(cMonth);
		fDtOfMonth.setYear(cYear);

		var isFound = false;
		var calDiv;
		for(i=0; i<document.getElementsByTagName("div").length; i++)
			if(document.getElementsByTagName("div")[i].id == "calDiv")
				isFound = true;
		
		if(isFound == false)
		{
			try{
				if(bsrName == "msie6")
					calIFrame = document.createElement("<iframe id=\"calIFrame\" style=\"position:absolute;z-index:101;border:solid 0 #ffffff\" scrolling=\"no\" frameborder=\"0\" marginwidth=\"0\"  marginheight=\"0\">");
				calDiv = document.createElement("<div id=\"calDiv\" style=\"position:absolute;z-index:102;\">");
			}
			catch(e)
			{
				if(bsrName == "msie6")
				{
					calIFrame = document.createElement("iframe");
					calIFrame.id = "calIFrame";
					calIFrame.zIndex = 101;
					calIFrame.frameborder = 0;
					calIFrame.style.position = "absolute";
					calIFrame.style.border = "solid 0 #ffffff";
				}

				calDiv = document.createElement("div");
				calDiv.style.backgroundColor = "#ffffff";
				calDiv.id = "calDiv";
				calDiv.zIndex = 102;
				calDiv.style.position = "absolute";
			}
		}
		else
		{
			calDiv = document.getElementById("calDiv");
			calIFrame = document.getElementById("calIFrame");
		}

		var arrMonthName = new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");

		strCalHTML = "<table border=\"0\" cellspacing=\"1\" cellpadding=\"3\" width=\"175px\" bgcolor=\"#323232\" style=\"color: #323232;font-family: verdana, arial;font-size:12px;font-weight:normal\">";
		strCalHTML += "<tr>";
		strCalHTML += "<td bgcolor=\"#ffffff\" width=\"125px\" align=\"left\" colspan=\"6\">";
		strCalHTML += "<select id=\"ddlMonth\" style=\"font-family:verdana;font-size:11px;border:solid 1px #626262;padding:1px;\" onChange=\"javascript: _showCalender('1/' + this.value + '/' + document.getElementById('ddlYear').value, 'dd/mm/yyyy', 2, '" + valObj + "', '" + posObj + "');\">";
		for(i = 1; i<=arrMonthName.length; i++)
		{
			if((i - 1) == cMonth)
				strCalHTML += "<option value=\"" + i + "\" selected>" + arrMonthName[i-1];
			else
				strCalHTML += "<option value=\"" + i + "\">" + arrMonthName[i-1];
		}
		strCalHTML += "</select>";
		strCalHTML += "<select id=\"ddlYear\" style=\"font-family:verdana;font-size:11px;border:solid 1px #626262;padding:1px;\" onChange=\"javascript: _showCalender('1/' + document.getElementById('ddlMonth').value + '/' + this.value, 'dd/mm/yyyy', 2,  '" + valObj + "', '" + posObj + "');\">";
		for(i = startYear; i<=(startYear+2); i++)
		{
			if(i == cYear)
				strCalHTML += "<option value=\"" + i + "\" selected>" + i;
			else
				strCalHTML += "<option value=\"" + i + "\">" + i;
		}
		strCalHTML += "</select>";
		strCalHTML += "</td>";
		strCalHTML += "<td bgcolor=\"#ffffff\" align=\"center\"><a style=\"cursor:pointer;font-weight:bold\" onClick=\"javascript: document.body.removeChild(document.getElementById('calDiv'));\">X</a></td>";
		strCalHTML += "</tr>";
		//strCalHTML += "</table>";

		//strCalHTML += "<table border=\"0\" cellspacing=\"1\" cellpadding=\"3\" width=\"175px\" bgcolor=\"323232\">";
		strCalHTML += "<tr>";
		strCalHTML += "<td bgcolor=\"#ffffff\" width=\"35px\">S</td>";
		strCalHTML += "<td bgcolor=\"#ffffff\" width=\"35px\">M</td>";
		strCalHTML += "<td bgcolor=\"#ffffff\" width=\"35px\">T</td>";
		strCalHTML += "<td bgcolor=\"#ffffff\" width=\"35px\">W</td>";
		strCalHTML += "<td bgcolor=\"#ffffff\" width=\"35px\">T</td>";
		strCalHTML += "<td bgcolor=\"#ffffff\" width=\"35px\">F</td>";
		strCalHTML += "<td bgcolor=\"#ffffff\" width=\"35px\">S</td>";
		strCalHTML += "</tr>";

		// Set first date of the month		
		var fWDayOfMonth = fDtOfMonth.getDay();
		var lDayOfMonth = 0;
		cMonth = cDt.getMonth();
		if(cMonth == 0 || cMonth == 2 || cMonth == 4 || cMonth == 6 || cMonth == 7 || cMonth == 9 || cMonth == 11) // Jan Mar May Jul Aug Oct Dec
			lDayOfMonth = 31;
		else if(cMonth == 3 || cMonth == 5 || cMonth == 8 || cMonth == 10) // Apr Jun Sep Nov
			lDayOfMonth = 30;
		else if(cMonth == 1) // Feb
		{
			if(cYear % 4 == 0)
				lDayOfMonth = 29;
			else
				lDayOfMonth = 28;
			
			if(cYear % 100 == 0)
			{
				if(cYear % 400 == 0)
					lDayOfMonth = 29;
				else
					lDayOfMonth = 28;
			}
		}

		var tmpDate = new Date();		
		for(i=1 ; i<=lDayOfMonth; i++)
		{
			tmpDate.setMonth(cMonth);
			tmpDate.setYear(cYear);
			tmpDate.setDate(i);
			if(tmpDate.getDay() == 0 || i == 1)
				strCalHTML += "<tr>";
			var wDCount = 0;
			if(i == 1)
			{
				while(wDCount != fWDayOfMonth)
				{
					strCalHTML += "<td bgcolor=\"#e2e2e2\" width=\"35px\">&nbsp;</td>";
					wDCount++;
				}
			}
			if(startYear == (cDt.getYear() + 1900) && startMonth == cDt.getMonth() && startDate == i)
				strCalHTML += "<td bgcolor=\"#ffffff\" width=\"35px\" style=\"color: #ff0000;font-weight:bold\"><a style=\"cursor:pointer;font-weight:bold\" onClick=\"javascript: _setCalDate('" + valObj + "', '" + cYear + "-" + (cMonth + 1) + "-" + i + "');\" id=\"cCalDate\">" + i + "</a></td>";
			else
				strCalHTML += "<td bgcolor=\"#ffffff\" width=\"35px\"><a style=\"cursor:pointer;font-weight:bold\" onClick=\"javascript: _setCalDate('" + valObj + "', '" + cYear + "-" + (cMonth + 1) + "-" + i + "');\" id=\"cCalDate\">" + i + "</a></td>";
			if(tmpDate.getDay() == 6)
				strCalHTML += "</tr>";
		}
		i--;
		tmpDate.setDate(i);
		if(i == lDayOfMonth && tmpDate.getDay() < 6)
		{
			for(i=tmpDate.getDay() ; i<6; i++)
				strCalHTML += "<td bgcolor=\"#e2e2e2\" width=\"35px\">&nbsp;</td>";
		}
		strCalHTML += "</table>";

		calDiv.innerHTML = strCalHTML
		calDiv.style.display = "block";

		if(isFound == false)
		{
			document.body.appendChild(calDiv);
			if(bsrName == "msie6")
			{
				document.body.appendChild(calIFrame);
				calIFrame.style.height = calDiv.offsetHeight;
				calIFrame.style.width = calDiv.offsetWidth;
			}
		}
		if(calMode == 1)
		{
			if(bsrName == "msie6")
			{
				calIFrame = document.getElementById("calIFrame");
				_setCalPosition(calIFrame, posObj);
			}
			calDiv = document.getElementById("calDiv");
			_setCalPosition(calDiv, posObj);
			document.onmousedown = _hideCal;
			document.onmouseup = _hideCal;
			window.onmousedown = _hideCal;
			window.onmouseup = _hideCal;
		}
		document.getElementById("calDiv").style.zIndex = 102;
	};

	function _setCalPosition(calObj, pObj)
	{
		var cpObj = document.getElementById(pObj);
		//alert(cpObj.type);
		var pParentObj = cpObj.offsetParent;
	    var pTop = cpObj.offsetTop;
		var pLeft = cpObj.offsetLeft;
		var oHeight;
		if(cpObj.type == "text")
		{
		    oHeight = cpObj.offsetHeight;
			while (pParentObj.tagName.toString().toLowerCase() != 'body' && pParentObj.tagName.toString().toLowerCase() != "html")
			{
				pTop += pParentObj.offsetTop;
				pLeft += pParentObj.offsetLeft;
				pParentObj = pParentObj.offsetParent;
			}			
			calObj.style.top = (pTop + oHeight + 4) + "px";
			calObj.style.left = pLeft + "px";
		}
		else
		{
		    oHeight = calObj.offsetHeight;
			while (pParentObj.tagName.toString().toLowerCase() != 'body' && pParentObj.tagName.toString().toLowerCase() != "html")
			{
				pTop += pParentObj.offsetTop;
				pLeft += pParentObj.offsetLeft;
				pParentObj = pParentObj.offsetParent;
			}
			calObj.style.top = (pTop - oHeight + 40) + "px";
			calObj.style.left = pLeft + "px";
		}
	};

	function _setCalDate(vObjId, val)
	{
		document.getElementById(vObjId).value = val;
		document.body.removeChild(document.getElementById("calDiv"));
		if(bsrName == "msie6")
			document.body.removeChild(document.getElementById("calIFrame"));
	    //_showNoOfDays();
	};

	function _hideCal(ev)
	{
		if(!ev) var ev = window.event;
		var sender = (typeof( window.event ) != "undefined" ) ? ev.srcElement : ev.target;
		var senderTagName = sender.tagName.toString().toLowerCase();
		if(senderTagName != "img" && sender.id != "cCalDate" && sender.id != "ddlMonth" && sender.id != "ddlYear" && senderTagName != "option")
		{
			try{
			document.body.removeChild(document.getElementById("calDiv"));
			if(bsrName == "msie6")
					document.body.removeChild(document.getElementById("calIFrame"));
			}
			catch(e){}
		}
	};