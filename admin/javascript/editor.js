var bsrName = "";
var webVirPath = "http://localhost:8080/avanti/";
var prjPath = "http://localhost:8080/avanti/admin/images/editor";
//var webVirPath = "http://bytesbrick.com/app-test/avanti/";
//var prjPath = "http://bytesbrick.com/app-test/avanti/admin/images/editor";
//var webVirPath = "http://beta.peerlearning.com/";
//var prjPath = "http://beta.peerlearning.com/admin/images/editor";

function _showEditor(edNameId, w, h, htmlContent)
{
	htmlContent = htmlContent.replace(/{rn}/g, "\r\n");
	htmlContent = htmlContent.replace(/{r}/g, "\r");
	htmlContent = htmlContent.replace(/{n}/g, "\n");
	bsrName = _checkBrowser();
	if(bsrName == "msie" || bsrName == "gecko")
	{
		document.write("<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin:0 !important;\">");
		document.write("<tr>");
		document.write("<td><a href=\"javascript: _executeCommand('" + edNameId + "', 'bold', '');" + "\"><img src=\"" + prjPath + "/bold.gif\" height=\"22px\" width=\"22px\" alt=\"Bold\" title=\"Bold\" border=\"0\" id=\"imgBtnBold\" onMouseOver=\"javascript: _showColBtn('" + prjPath + "/bold_s.gif', this.id);\" onMouseOut=\"javascript: _showColBtn('" + prjPath + "/bold.gif', this.id);\"></a></td>");
		document.write("<td><a href=\"javascript: _executeCommand('" + edNameId + "', 'italic', '');" + "\"><img src=\"" + prjPath + "/italics.gif\" height=\"22px\" width=\"22px\" alt=\"Italics\" title=\"Italics\" border=\"0\" id=\"imgBtnItalic\" onMouseOver=\"javascript: _showColBtn('" + prjPath + "/italics_s.gif', this.id);\" onMouseOut=\"javascript: _showColBtn('" + prjPath + "/italics.gif', this.id);\"></a></td>");
		document.write("<td><a href=\"javascript: _executeCommand('" + edNameId + "', 'underline', '');" + "\"><img src=\"" + prjPath + "/underline.gif\" height=\"22px\" width=\"22px\" alt=\"Underline\" title=\"Underline\" border=\"0\" id=\"imgBtnUnderline\" onMouseOver=\"javascript: _showColBtn('" + prjPath + "/underline_s.gif', this.id);\" onMouseOut=\"javascript: _showColBtn('" + prjPath + "/underline.gif', this.id);\"></a></td>");
		document.write("<td><a href=\"javascript: _executeCommand('" + edNameId + "', 'strikethrough', '');" + "\"><img src=\"" + prjPath + "/striket.gif\" height=\"22px\" width=\"22px\" alt=\"Strikethrough\" title=\"Strikethrough\" border=\"0\" id=\"imgBtnStrikeT\" onMouseOver=\"javascript: _showColBtn('" + prjPath + "/striket_s.gif', this.id);\" onMouseOut=\"javascript: _showColBtn('" + prjPath + "/striket.gif', this.id);\"></a></td>");
		document.write("<td><a href=\"javascript: _executeCommand('" + edNameId + "', 'subscript', '');" + "\"><img src=\"" + prjPath + "/subscript.gif\" height=\"22px\" width=\"22px\" alt=\"Subscript\" title=\"Subscript\" border=\"0\" id=\"imgBtnSubscript\" onMouseOver=\"javascript: _showColBtn('" + prjPath + "/subscript_s.gif', this.id);\" onMouseOut=\"javascript: _showColBtn('" + prjPath + "/subscript.gif', this.id);\"></a></td>");
		document.write("<td><a href=\"javascript: _executeCommand('" + edNameId + "', 'superscript', '');" + "\"><img src=\"" + prjPath + "/supscript.gif\" height=\"22px\" width=\"22px\" alt=\"Superscript\" title=\"Superscript\" border=\"0\" id=\"imgBtnSuperscript\" onMouseOver=\"javascript: _showColBtn('" + prjPath + "/supscript_s.gif', this.id);\" onMouseOut=\"javascript: _showColBtn('" + prjPath + "/supscript.gif', this.id);\"></a></td>");
		document.write("<td><a href=\"javascript: _showColorPellete('" + edNameId + "', 'backcolor', '', 'imgBtnBackcolor');" + "\"><img src=\"" + prjPath + "/backcolor.gif\" height=\"22px\" width=\"22px\" alt=\"Highlight text\" title=\"Highlight text\" border=\"0\" id=\"imgBtnBackcolor\" onMouseOver=\"javascript: _showColBtn('" + prjPath + "/backcolor_s.gif', this.id);\" onMouseOut=\"javascript: _showColBtn('" + prjPath + "/backcolor.gif', this.id);\"></a></td>");
		document.write("<td><a href=\"javascript: _showColorPellete('" + edNameId + "', 'forecolor', '', 'imgBtnFColor');" + "\"><img src=\"" + prjPath + "/fontcolor.gif\" height=\"22px\" width=\"22px\" alt=\"Font color\" title=\"Font color\" border=\"0\" id=\"imgBtnFColor\"></a></td>");
		
		document.write("<td>&nbsp;</td>");
		//document.write("<td><select id=\"ddlFontName\" name=\"ddlFontName\" style=\"border:solid 1px #9BB7E0;margin:0;background-color:#CADCF0;padding:2px; font-family:verdana; font-size:11px\" onChange=\"javascript: _executeCommand('" + edNameId + "', 'fontname', this.value);\"><option value=\"Arial\">Arial<option value=\"Comic Sans MS\">Comic Sans MS<option value=\"Courier New\">Courier New<option value=\"Garamond\">Garamond<option value=\"Georgia\">Georgia<option value=\"Narrow\">Narrow<option value=\"Sans Serif\">Sans Serif<option value=\"Serif\">Serif<option value=\"Tahoma\">Tahoma<option value=\"Times New Roman\">Times New Roman<option value=\"Trebuchet MS\">Trebuchet MS<option value=\"Verdana\" selected>Verdana<option value=\"Wide\">Wide</select></td>");
		//document.write("<td>&nbsp;<select id=\"ddlFontSize\" name=\"ddlFontSize\" style=\"border:solid 1px #9BB7E0;margin:0;background-color:#CADCF0;padding:2px; font-family:verdana; font-size:11px\" onChange=\"javascript: _executeCommand('" + edNameId + "', 'fontsize', this.value);\"><option value=\"1\">Small<option value=\"2\" selected>Normal<option value=\"3\">Large<option value=\"4\">Larger<option value=\"5\">Largest<option value=\"6\">Big<option value=\"7\">Bigger<option value=\"8\">Biggest</select></td>");	

		document.write("<td>&nbsp;</td>");
		document.write("<td><a href=\"javascript: _executeCommand('" + edNameId + "', 'undo', '');" + "\"><img src=\"" + prjPath + "/undo.gif\" height=\"22px\" width=\"22px\" alt=\"Undo\" title=\"Undo\" border=\"0\" id=\"imgBtnUndo\" onMouseOver=\"javascript: _showColBtn('" + prjPath + "/undo_s.gif', this.id);\" onMouseOut=\"javascript: _showColBtn('" + prjPath + "/undo.gif', this.id);\"></a></td>");
		document.write("<td><a href=\"javascript: _executeCommand('" + edNameId + "', 'redo', '');" + "\"><img src=\"" + prjPath + "/redo.gif\" height=\"22px\" width=\"22px\" alt=\"Redo\" title=\"Redo\" border=\"0\" id=\"imgBtnRedo\" onMouseOver=\"javascript: _showColBtn('" + prjPath + "/redo_s.gif', this.id);\" onMouseOut=\"javascript: _showColBtn('" + prjPath + "/redo.gif', this.id);\"></a></td>");

		document.write("<td>&nbsp;</td>");
		document.write("<td><a href=\"javascript: _executeCommand('" + edNameId + "', 'insertunorderedlist', '');" + "\"><img src=\"" + prjPath + "/ul.gif\" height=\"22px\" width=\"22px\" alt=\"Bullet list\" title=\"Bullet list\" border=\"0\" id=\"imgBtnUL\" onMouseOver=\"javascript: _showColBtn('" + prjPath + "/ul_s.gif', this.id);\" onMouseOut=\"javascript: _showColBtn('" + prjPath + "/ul.gif', this.id);\"></a></td>");
		document.write("<td><a href=\"javascript: _executeCommand('" + edNameId + "', 'insertorderedlist', '');" + "\"><img src=\"" + prjPath + "/ol.gif\" height=\"22px\" width=\"22px\" alt=\"Numbered list\" title=\"Numbered list\" border=\"0\" id=\"imgBtnOL\" onMouseOver=\"javascript: _showColBtn('" + prjPath + "/ol_s.gif', this.id);\" onMouseOut=\"javascript: _showColBtn('" + prjPath + "/ol.gif', this.id);\"></a></td>");
		document.write("<td><a href=\"javascript: _executeCommand('" + edNameId + "', 'indent', '');" + "\"><img src=\"" + prjPath + "/indent.gif\" height=\"22px\" width=\"22px\" alt=\"Indent\" title=\"Indent\" border=\"0\" id=\"imgBtnIndent\" onMouseOver=\"javascript: _showColBtn('" + prjPath + "/indent_s.gif', this.id);\" onMouseOut=\"javascript: _showColBtn('" + prjPath + "/indent.gif', this.id);\"></a></td>");
		document.write("<td><a href=\"javascript: _executeCommand('" + edNameId + "', 'outdent', '');" + "\"><img src=\"" + prjPath + "/outdent.gif\" height=\"22px\" width=\"22px\" alt=\"Outdent\" title=\"Outdent\" border=\"0\" id=\"imgBtnOutdent\" onMouseOver=\"javascript: _showColBtn('" + prjPath + "/outdent_s.gif', this.id);\" onMouseOut=\"javascript: _showColBtn('" + prjPath + "/outdent.gif', this.id);\"></a></td>");
		document.write("<td><a href=\"javascript: void(0);\" onclick=\"javascript: _showImageLibrary('" + edNameId + "');" + "\"><img src=\"" + prjPath + "/img.gif\" height=\"22px\" width=\"22px\" alt=\"Insert Image\" title=\"Insert Image\" border=\"0\" id=\"imgBtnImg\" onMouseOver=\"javascript: _showColBtn('" + prjPath + "/img_s.gif', this.id);\" onMouseOut=\"javascript: _showColBtn('" + prjPath + "/img.gif', this.id);\"></a></td>");
		document.write("<td><a href=\"javascript: _showHyperlink('" + edNameId + "', 'createlink', '');" + "\"><img src=\"" + prjPath + "/hyperlink.gif\" height=\"22px\" width=\"22px\" alt=\"Hyperlink\" title=\"Hyperlink\" border=\"0\" id=\"imgBtnCreatelink\" onMouseOver=\"javascript: _showColBtn('" + prjPath + "/hyperlink_s.gif', this.id);\" onMouseOut=\"javascript: _showColBtn('" + prjPath + "/hyperlink.gif', this.id);\"></a></td>");

		document.write("<td>&nbsp;</td>");
		document.write("<td><a href=\"javascript: _executeCommand('" + edNameId + "', 'justifyleft', '');" + "\"><img src=\"" + prjPath + "/alignleft.gif\" height=\"22px\" width=\"22px\" alt=\"Align left\" title=\"Align left\" border=\"0\" id=\"imgBtnAlignLeft\" onMouseOver=\"javascript: _showColBtn('" + prjPath + "/alignleft_s.gif', this.id);\" onMouseOut=\"javascript: _showColBtn('" + prjPath + "/alignleft.gif', this.id);\"></a></td>");
		document.write("<td><a href=\"javascript: _executeCommand('" + edNameId + "', 'justifycenter', '');" + "\"><img src=\"" + prjPath + "/aligncenter.gif\" height=\"22px\" width=\"22px\" alt=\"Align center\" title=\"Align center\" border=\"0\" id=\"imgBtnAlignCenter\" onMouseOver=\"javascript: _showColBtn('" + prjPath + "/aligncenter_s.gif', this.id);\" onMouseOut=\"javascript: _showColBtn('" + prjPath + "/aligncenter.gif', this.id);\"></a></td>");
		document.write("<td><a href=\"javascript: _executeCommand('" + edNameId + "', 'justifyright', '');" + "\"><img src=\"" + prjPath + "/alignright.gif\" height=\"22px\" width=\"22px\" alt=\"Align right\" title=\"Align right\" border=\"0\" id=\"imgBtnAlignRight\" onMouseOver=\"javascript: _showColBtn('" + prjPath + "/alignright_s.gif', this.id);\" onMouseOut=\"javascript: _showColBtn('" + prjPath + "/alignright.gif', this.id);\"></a></td>");
		document.write("<td><a href=\"javascript: _executeCommand('" + edNameId + "', 'justifyfull', '');" + "\"><img src=\"" + prjPath + "/alignjustify.gif\" height=\"22px\" width=\"22px\" alt=\"Align justify\" title=\"Align justify\" border=\"0\" id=\"imgBtnAlignJustify\" onMouseOver=\"javascript: _showColBtn('" + prjPath + "/alignjustify_s.gif', this.id);\" onMouseOut=\"javascript: _showColBtn('" + prjPath + "/alignjustify.gif', this.id);\"></a></td>");
		document.write("</tr>");
		document.write("</table>");

		document.writeln("<iframe name=\"IF" + edNameId + "\" id=\"IF" + edNameId + "\" width=\"" + w + "px\" height=\"" + h + "px\" style=\"margin-top:5px;border:1px solid #8D8D8D;\"></iframe>");
		document.writeln("<input type=\"hidden\" name=\"" + edNameId + "\" id=\"" + edNameId + "\" value=\"\">");
		document.getElementById(edNameId).value = htmlContent;

		//if(htmlContent.indexOf("<style>p{margin: 0; padding: 0; font-family: Verdana; font-size: 12px;}</style>") <= -1)
		//	htmlContent = "<style>p{margin: 0; padding: 0; font-family: Verdana; font-size: 12px;}</style>" + htmlContent;
		if(htmlContent.indexOf("&lsquo;") > -1)
			htmlContent = htmlContent.replace(/&lsquo;/g, "'");
		//if(htmlContent.indexOf("'") > -1)
		//	htmlContent = htmlContent.replace(/'/g, "''");

		//var defaultContent = "<html><head></head><body style=\"font-family: Mangal, Verdana; font-size:15px;\">" + htmlContent + "</body></html>";
		var defaultContent = htmlContent;	
		var iFrameSrc = document.getElementById('IF' + edNameId).contentWindow.document;
		iFrameSrc.open();
		iFrameSrc.write(defaultContent);
		iFrameSrc.close();
		iFrameSrc.designMode = "On";
		document.getElementById('IF' + edNameId).contentWindow.document.onkeyup = function(){document.getElementById(edNameId).value = document.getElementById('IF' + edNameId).contentWindow.document.body.innerHTML.trim();}

		if(document.contentDocument)
			document.getElementById('IF' + edNameId).contentDocument.designMode = "on";
	}
	else
	{
		document.writeln('<textarea name="' + editor + '" id="' + editor + '" cols="39" rows="10">' + html + '</textarea>');
	}
};

function _checkBrowser()
{
	var bUAgent = navigator.userAgent.toLowerCase();
	if(bUAgent.indexOf("msie") > -1)
		return "msie";
	else if(bUAgent.indexOf("gecko") > -1)
		return "gecko";
};

function _executeCommand(edNameId, command, option, arrPNames, arrPValues)
{
	//alert(edNameId + " " + command + " " + option);
	var arrPN = new Array();
	var arrPV = new Array();
	if(arrPNames != null && arrPNames != undefined)
	arrPN = arrPNames.split(",");
	if(arrPValues != null && arrPValues != undefined)
	arrPV = arrPValues.split(",");
	var iFrameSrc = document.getElementById('IF' + edNameId).contentWindow;
	try{
		iFrameSrc.focus();
		var aText = "";
		try{
			aText = iFrameSrc.document.getSelection();
		}
		catch(e){
			aText = iFrameSrc.document.selection.createRange();
		}
		if(command.toString().toLowerCase() == "createlink")
			iFrameSrc.document.execCommand('unlink', false, null);
		var newLink = iFrameSrc.document.execCommand(command, false, option);
		//if(arrPNames == "_blank" || arrPNames == "_self")
		//{
			var a = iFrameSrc.document.getElementsByTagName('a');
			for(i = 0; i < a.length; i++){
				//if(a[i].innerHTML == aText){
					a[i].setAttribute("target", "_blank");
					break;
				//}
			}
		//}
		iFrameSrc.focus();
		switch(command.toString().toLowerCase()){
			case "insertimage":
				var allImg = iFrameSrc.document.getElementsByTagName("img");
				iFrameSrc.document.getElementsByTagName("img")[allImg.length-1].border = "0";
				for(i = 0; i < arrPN.length; i++){
					iFrameSrc.document.getElementsByTagName("img")[allImg.length-1].setAttribute(arrPN[i], arrPV[i]);
				}
				break;
			//case "createlink":
			//	var allImg = iFrameSrc.document.getElementsByTagName("img");
			//	iFrameSrc.document.getElementsByTagName("img")[allImg.length-1].border = "0";
			//	for(i = 0; i < arrPN.length; i++){
			//		iFrameSrc.document.getElementsByTagName("img")[allImg.length-1].setAttribute(arrPN[i], arrPV[i]);
			//	}
			//	break;
			default:

				break;
		}
		document.getElementById(edNameId).value = document.getElementById('IF' + edNameId).contentWindow.document.body.innerHTML.trim();
	}
	catch(e)
	{alert(e);}
};

function _showColBtn(imgName, srcId)
{
	document.getElementById(srcId).src = imgName;
};

function _showColorPellete(edNameId, command, option, btnId)
{
	var isFound = false;
	var colorDiv;
	for(i=0; i<document.getElementsByTagName("div").length; i++)
		if(document.getElementsByTagName("div")[i].id == "colorPellete")
			isFound = true;

	if(isFound == false)
	{
		try{
			colorDiv = document.createElement("<div id=\"colorPellete\" style=\"background-color:#ffffff;z-index:100;top:0;left:0;position:absolute;width:124px;border:solid 2px #A2A2A2;\">");
		}
		catch(e)
		{
			colorDiv = document.createElement("div");
			colorDiv.id = "colorPellete";
			colorDiv.style.backgroundColor = "#ffffff";
			colorDiv.style.zIndex = "100";
			colorDiv.style.top = 0;
			colorDiv.style.left = 0;
			colorDiv.style.position = "absolute";
			colorDiv.style.width = "124px";
		}
	}
	else
	{
		colorDiv = document.getElementById("colorPellete");
	}

	var hexColCode = new Array('#ffffff','#cccccc','#c0c0c0','#9999993','#666666','#333333','#000000','#ffcccc','#ff6666','#ff0000','#cc0000','#990000','#660000','#330000','#ffcc99','#ff9966','#ff9900','#ff6600','#cc6600','#993300','#663300','#ffff99','#ffff66','#ffcc00','#ffcc33','#cc9933','#996633','#663333','#ffffcc','#ffff33','#ffff00','#ffcc00','#999900','#666600','#333300','#99ff99','#66ff99','#33ff33','#33cc00','#009900','#006600','#003300','#99ffff','#33ffff','#66cccc','#00cccc','#339999','#336666','#003333','#ccffff','#66ffff','#33ccff','#3366ff','#3333ff','#000099','#000066','#ccccff','#9999ff','#6666cc','#6633ff','#6600cc','#333399','#330099','#ffccff','#ff99ff','#cc66cc','#cc33cc','#993399','#663366','#330033');
	var colorPHTML = "<table width=\"124px\" cellpacing=\"2\" cellpadding=\"0\" border=\"0\" bgcolor=\"#A2A2A2\">";
	for(i=1; i<=hexColCode.length; i++)
	{
		if((i-1) % 7 == 0)
		{
			if(i == 0)
				colorPHTML += "<tr>";
			else
				colorPHTML += "</tr><tr>";
		}
		colorPHTML += "<td width=\"14px\" bgcolor=\"" + hexColCode[i-1] + "\"><img src=\"" + prjPath + "/trans.gif\" width=\"14px\" height=\"12px\" border=\"0\" onClick=\"javascript: _executeCommand('" + edNameId + "','" + command + "','" + hexColCode[i-1] + "');_closeColorPellete('colorPellete');\" style=\"cursor: pointer\"></td>";
	}
	colorPHTML += "</table>";
	colorDiv.innerHTML = colorPHTML;

	document.body.appendChild(colorDiv);

	var cpObj = document.getElementById(btnId);
	var pParentObj = cpObj.offsetParent;
	var pTop = 0;
	var pLeft = 0;
	while (pParentObj.tagName != 'BODY')
	{
		pTop += pParentObj.offsetTop;
		pLeft += pParentObj.offsetLeft;
		pParentObj = pParentObj.offsetParent;
	}
	var oHeight = cpObj.offsetHeight;
	colorDiv.style.top = (pTop + oHeight + 4) + "px";
	colorDiv.style.left = pLeft + "px";

	document.onmousedown = _hideColorPellete;
	document.onmouseup = _hideColorPellete;
	window.onmousedown = _hideColorPellete;
	window.onmouseup = _hideColorPellete;
};

function _closeColorPellete(edNameId)
{
	var divMe = document.getElementById(edNameId);
	divMe.style.display='none';
	document.body.removeChild(divMe);
};

function _hideColorPellete(ev)
{
	if(!ev) var ev = window.event;
	var sender = (typeof( window.event ) != "undefined" ) ? ev.srcElement : ev.target;
	var senderTagName = sender.tagName.toString().toLowerCase();
	if(senderTagName != "img")
	{
		try{
		document.body.removeChild(document.getElementById("colorPellete"));
		}
		catch(e){}
	}
};
_closePopUp = function(){
    document.body.removeChild(_$('disableLayer'));
    document.body.removeChild(_$('popupContainer'));
};
 
function _$(id){
    if(typeof(id) == "string"){
        if(document.getElementById(id))
            return document.getElementById(id);
        else{
            if(document.getElementsByName(id))
                return document.getElementsByName(id);
            else {
                if(document.getElementsByTagName(id))
                    return document.getElementsByTagName(id);
                else
                    return null;
            }
        }
    }
    else {
        if(id)
            return id;
        else
            return null;
    }
};
function _disablePage(){
    if(_$('disableLayer').length <= 0){
        var d;
        try{
            d = document.createElement("<div id='disableLayer' style='background-color:#000;position:fixed;opacity:0.2;z-index:99;top:0;left:0;position:fixed;cursor:pointer;'></div>");
        }
        catch(e){
            d = document.createElement("div");
            d.id = "disableLayer";
            d.style.position = "fixed";
            d.style.height = "100%";
            d.style.width = "100%";
                    d.style.left = "0";
            d.style.top = "0";
            d.style.backgroundColor = "#000";
            d.style.opacity = 0.2;
            d.style.zIndex = 0;
            d.style.cursor = 'pointer';
        }
        document.body.appendChild(d);
    }   
};
 
function _showPopUp(mode, urlhtml, divid, w, h, isModal, param){
    _disablePage();
    if(!isModal){
        _$('disableLayer').onclick = (function(){
            document.body.removeChild(_$('disableLayer'));
            document.body.removeChild(_$('popupContainer'));
        });
    }
   
    var postop = 10;
    var posleft = ((screen.availWidth) - w)/2;
    var d;
    try{
        d = document.createElement("<div id='popupContainer' style='background-color:#fff;opacity:1;position:relative;z-index:100;'></div>");
    }
    catch(e){
        d = document.createElement("div");
        d.id = "popupContainer";
        d.style.position = "fixed";
        d.style.backgroundColor = "#fff";
        d.style.top = postop + "px";
        d.style.left = posleft + "px";
    }
    document.body.appendChild(d);
   
    try{
        d = document.createElement("<div id='popupPage' style='background-color:#fff;opacity:1;position:absolute;z-index:100;'></div>");
    }
    catch(e){
        d = document.createElement("div");
        d.id = "popupPage";
        d.style.position = "absolute";
        d.style.height = h + "px";
        d.style.width = w + "px";
        d.style.backgroundColor = "#fff";
        d.style.borderRadius = "5px";
        d.style.padding = "10px";
        d.style.boxShadow = "2px 5px 10px #333333";      
        d.style.opacity = 1;
        d.style.zIndex = "100";
    }
    _$('popupContainer').appendChild(d);
   
    if(mode.toLowerCase() == "iframe"){
        try{
            d = document.createElement("<iframe id=\"" + divid + "\" border=\"0\" frameborder=\"0\" framespacing=\"0\" style=\"z-index:100;top:0;left:0;position:absolute;\" src=\"./" + urlhtml + "\" ></iframe>");
        }
        catch(e)
        {
            d = document.createElement("IFRAME");
            d.id = divid;
            d.frameBorder = 0;
            d.frameSpacing = 0;
            d.style.height = (h - 5) + "px";
            d.style.width = (w - 5) + "px";
            d.style.zIndex = "100";
            d.src = urlhtml;
        }
        _$('popupPage').appendChild(d);
    }
    else if(mode.toLowerCase() == "ajax"){
        try{
            d = document.createElement("<div id=\"" + divid + "\" style=\"z-index:100;top:0;left:0;position:absolute;\" ></div>");
        }
        catch(e)
        {
            d = document.createElement("div");
            d.id = divid;
            d.style.height = (h - 5) + "px";
            d.style.width = (w - 5) + "px";
            d.style.zIndex = "100";
        }
               
        _$('popupPage').appendChild(d);
               
                _waitGetData = function(){
            _$(divid).innerHTML = "Please wait";
        };
        _responseGetData = function(str){
            _$(divid).innerHTML = str;
            _$(divid).style.top = postop + "px";
            _$(divid).style.left = posleft + "px";
        };
	
	var ajx;
	if (window.XMLHttpRequest)
	    ajx = new XMLHttpRequest;
	else if (window.ActiveXObject)
	    ajx = new ActiveXObject("Microsoft.XMLHTTP");	 
	ajx.onreadystatechange = function()
	{
	    if (ajx.readyState < 4){
		_$(divid).innerHTML = "<b style='color:#DB4A28;'>Loading...</b>";
	    }
	    else if (ajx.readyState == 4) {
		if(ajx.status == 200){
		    _$(divid).innerHTML = ajx.responseText;
		    ajx = null;
		}
	    }
	};
	var pr = param[0].join("=");
	ajx.open("GET", urlhtml + "?" + pr, true);
	ajx.send(null);
              
    }
    else if(mode.toLowerCase() == "html"){
        try{
            d = document.createElement("<div id=\"" + divid + "\" style=\"z-index:100;top:0;left:0;position:absolute;\" ></div>");
        }
        catch(e)
        {
            d = document.createElement("div");
            d.id = divid;
            d.style.height = (h - 5) + "px";
            d.style.width = (w - 5) + "px";
            d.style.zIndex = "100";
        }
        _$('popupPage').appendChild(d);
        _$(divid).innerHTML = urlhtml;
    }
};

function _showImageLibrary(ed)
{
	var p = new Array();
	p[0] = new Array("ed", ed);
	_showPopUp('ajax', './ajax/show-photos-list.php', 'imagePopUp', 1000, 600, false, p);
};

function _showHyperlink(edNameId, command, option)
{
	if(bsrName == "msie")
	{
		var hLinkURL = prompt("Type in the destination URL", "http://");
		if(hLinkURL != "http://")
			_executeCommand(edNameId, 'createLink', hLinkURL);
	}
	else{
		var hLinkHTML = "<table width=\"100%\" cellpacing=\"2\" cellpadding=\"3\" border=\"0\" style=\"font-family: verdana; font-size:12px\">";
		hLinkHTML += "<tr><td colspan=\"2\">Type in the URL</td></tr>";
		hLinkHTML += "<tr><td colspan=\"2\"><input type=\"text\" name=\"txtHLink\" id=\"txtHLink\" class=\"textbox\" size=\"60\" style=\"width:99% !important;\"></td></tr>";
		hLinkHTML += "<tr><td width=\"50%\"><input type=\"radio\" name=\"rdoLink\" id=\"rdoLinkSame\" value=\"_self\" />Same Window</td>";
		hLinkHTML += "<td width=\"50%\"><input type=\"radio\" name=\"rdoLink\" id=\"rdoLinkBlank\" value=\"_blank\" checked />New Window</td></tr>";
		hLinkHTML += "<tr><td colspan=\"2\"><input type=\"button\" name=\"btnHLink\" id=\"btnHLink\" class=\"btn btnc w100 fl\" value=\"Insert link\" onClick=\"javascript: if(document.getElementById('txtHLink').value != '') {var tg = '_self';if(_$('rdoLinkBlank').checked){tg = '_blank';}_executeCommand('" + edNameId + "', 'createLink', _$('txtHLink').value, tg);}_$('disableLayer').click();\">&nbsp;<input type=\"button\" name=\"btnClose\" id=\"btnClose\" class=\"ml10 btn btnc w100 fl\" value=\"Close\" onClick=\"javascript: _$('disableLayer').click();\"><br /><br /></td></tr>";
		hLinkHTML += "</table>";
		_showPopUp('html', hLinkHTML, 'imagePopUp', 600, 150, false);
		_$('txtHLink').focus();
	}
};

_toggleMBody = function(lnk){
    var mailHTML;
    htmlMode = lnk;
    if(lnk == "rtxt")
    {
        document.getElementById("rtxt").style.color = "#323232";
        document.getElementById("ahtml").style.color = "#d5043b";
        mailHTML = document.getElementById("ctl00_ContentPlaceHolder1_txtMailer").value;
        document.getElementById("divrtxt").style.display = "block";
        document.getElementById("divahtml").style.display = "none";        
        document.getElementById("rtxMailer").contentWindow.document.body.innerHTML = mailHTML;
    }
    else
    {
        document.getElementById("rtxt").style.color = "#d5043b";
        document.getElementById("ahtml").style.color = "#323232";
        mailHTML = document.getElementById("rtxMailer").contentWindow.document.body.innerHTML;
        if(mailHTML.indexOf("'") > -1)
			mailHTML = mailHTML.replace(/\'/g, "&lsquo;");
			
        document.getElementById("divahtml").style.display = "block";
        document.getElementById("divrtxt").style.display = "none";
        
        document.getElementById("ctl00_ContentPlaceHolder1_txtMailer").value = mailHTML;
    }
};
    function _setImgSelMode(sIndx) {
        var allMenus = document.getElementById('imgupload').getElementsByTagName('a');
        for (m = 0; m < allMenus.length; m++) {
            allMenus[m].className = "";
        }
		allMenus[allMenus.length - 1].className = "last ";
		allMenus[sIndx].className += "active";
		document.getElementById('imgupload0').style.display = "none";
		document.getElementById('imgupload1').style.display = "none";
		document.getElementById('imgupload2').style.display = "none";
		document.getElementById('imgupload' + sIndx).style.display = "block";
    }
	
	// gets data from the form and sumbit it
    function uploadimg(theform){
		document.getElementById('divSettings').style.display = "none";
      theform.submit();
    
      // calls the function to display Status loading
      setStatus("Uploading image...", "showimg");
      return false;
    }
    
    // this function is called from the iframe when the php return the result
    function doneloading(rezultat) {
      // decode (urldecode) the parameter wich is encoded in PHP with 'urlencode'
      rezultat = decodeURIComponent(rezultat.replace(/\+/g,  " "));
    
      // add the value of the parameter inside tag with 'id=showimg'
      
	  if (rezultat.indexOf("../images/upload/") > -1) {
		rezultat = rezultat.replace("../", webVirPath);
		document.getElementById('showimg').innerHTML = "<img src='" + rezultat + "' style='max-width:400px;' />";
		document.getElementById('myfile').value = "";
		document.getElementById('hdImgURL').value = rezultat;
		document.getElementById('divSettings').style.display = "block";
	  }
    }
    
    // displays status loading
    function setStatus(theStatus, theloc) {
      var tag = document.getElementById(theloc);
    
      // if there is "tag"
      if (tag) {
        // adds 'theStatus' inside it
        tag.innerHTML = '<b>'+ theStatus + "</b>";
      }
    }
_widthBox = function(wd, txtWd){
        //alert(wd);
	var rd = document.getElementsByName("widTextBox");
	for (r = 0; r < rd.length; r ++) {
		rd[r].readOnly = true;
	}
	if (txtWd != "")
        document.getElementById(txtWd).readOnly = false;
    }
_setImage = function(ed){
	if (document.getElementById("rdoWidth1").checked){
		_insImage(ed);
		document.body.removeChild(_$('disableLayer'));
		document.body.removeChild(_$('popupContainer'));
	} else {
		if (document.getElementById('txtWidth').value != "") {
			_insImage(ed, "width", document.getElementById('txtWidth').value);
			document.body.removeChild(_$('disableLayer'));
			document.body.removeChild(_$('popupContainer'));
		} else {
			alert("Please define width of image");
			document.getElementById('txtWidth').focus();
		}
	}	
}
function _insImage(edNameId, a, v) {
	if (document.getElementById('hdImgURL').value != "") {
		_executeCommand(edNameId, 'insertimage', document.getElementById('hdImgURL').value, a, v);
	}
}

function _insImageURL(edNameId) {
	if (document.getElementById('imgURL').value != "") {
		_executeCommand(edNameId, 'insertimage', document.getElementById('imgURL').value);
	}
}

function _insLibImage(edNameId) {
	var libImgLoc = "";
	var allImg = document.getElementsByName('rdoImages');
	for (g = 0; g < allImg.length; g++) {
		if (allImg[g].checked) {
			libImgLoc = allImg[g].value;
			break;
		}
	}
	if (libImgLoc != "") {
		libImgLoc = libImgLoc.replace("../", webVirPath);
		if (document.getElementById("rdoWidth3").checked){
			_executeCommand(edNameId, 'insertimage', libImgLoc);
			document.body.removeChild(_$('disableLayer'));
			document.body.removeChild(_$('popupContainer'));
		} else if (document.getElementById("rdoWidth4").checked){
			if (document.getElementById('txtWidth1').value != "") {
				_executeCommand(edNameId, 'insertimage', libImgLoc, "width", document.getElementById('txtWidth1').value);
				document.body.removeChild(_$('disableLayer'));
				document.body.removeChild(_$('popupContainer'));
			} else {
				alert("Please define width of image");
				document.getElementById('txtWidth1').focus();
			}
		}
		
	} else {
		alert("No image selected.");
	}
}

function _showDirContent(divid, dir, bc) {
	var bcrum = "";
	var bDir = "";
	var bDirPath = "../images";
	var allDirs = bc.split("|");
	for (d = 0; d < allDirs.length; d++) {
		bDir += bDir == "" ? allDirs[d] : "|" + allDirs[d];
		bDirPath += "/" + allDirs[d].toLowerCase();
		bcrum += bcrum == "" ? "<a href=\"javascript: void(0);\" onclick=\"javascript: _showDirContent('allimg', '" + bDirPath + "', '" + bDir + "');\" title=\"" + allDirs[d] + "\">" + allDirs[d] + "</a>" : " &raquo; <a href=\"javascript: void(0);\" onclick=\"javascript: _showDirContent('allimg', '" + bDirPath + "', '" + bDir + "');\" title=\"" + allDirs[d] + "\">" + allDirs[d] + "</a>";
	}
	
	var ajx;
	if (window.XMLHttpRequest)
	    ajx = new XMLHttpRequest;
	else if (window.ActiveXObject)
	    ajx = new ActiveXObject("Microsoft.XMLHTTP");	 
	ajx.onreadystatechange = function()
	{
	    if (ajx.readyState < 4){
		_$('bcrum').innerHTML = "<b style='color:#DB4A28;'>Loading...</b>";
		_$(divid).innerHTML = "<b style='color:#DB4A28;'>Loading...</b>";
	    }
	    else if (ajx.readyState == 4) {
		if(ajx.status == 200){
		    _$('bcrum').innerHTML = bcrum;
		    _$(divid).innerHTML = ajx.responseText;
		    ajx = null;
		}
	    }
	};
	ajx.open("GET", "./ajax/getdircontent.php" + "?dir=" + "../" + dir, true);
	ajx.send(null);
}