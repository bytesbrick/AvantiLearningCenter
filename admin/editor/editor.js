var bsrName = "";
var prjPath = "http://localhost:8080/au-cms/images/editor";
//var prjPath = "http://cms.amarujala.com/images/editor";
//var prjPath = "http://www.amarujala.com/admin/images/bb-editor";
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
		document.write("<td><select id=\"ddlFontName\" name=\"ddlFontName\" style=\"border:solid 1px #9BB7E0;margin:0;background-color:#CADCF0;padding:2px; font-family:verdana; font-size:11px\" onChange=\"javascript: _executeCommand('" + edNameId + "', 'fontname', this.value);\"><option value=\"Arial\">Arial<option value=\"Comic Sans MS\">Comic Sans MS<option value=\"Courier New\">Courier New<option value=\"Garamond\">Garamond<option value=\"Georgia\">Georgia<option value=\"Narrow\">Narrow<option value=\"Sans Serif\">Sans Serif<option value=\"Serif\">Serif<option value=\"Tahoma\">Tahoma<option value=\"Times New Roman\">Times New Roman<option value=\"Trebuchet MS\">Trebuchet MS<option value=\"Verdana\" selected>Verdana<option value=\"Wide\">Wide</select></td>");
		document.write("<td>&nbsp;<select id=\"ddlFontSize\" name=\"ddlFontSize\" style=\"border:solid 1px #9BB7E0;margin:0;background-color:#CADCF0;padding:2px; font-family:verdana; font-size:11px\" onChange=\"javascript: _executeCommand('" + edNameId + "', 'fontsize', this.value);\"><option value=\"1\">Small<option value=\"2\" selected>Normal<option value=\"3\">Large<option value=\"4\">Larger<option value=\"5\">Largest<option value=\"6\">Big<option value=\"7\">Bigger<option value=\"8\">Biggest</select></td>");	

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

		document.writeln("<iframe name=\"" + edNameId + "\" id=\"" + edNameId + "\" width=\"" + w + "px\" height=\"" + h + "px\" style=\"margin-top:5px;border:solid 1px #a2a2a2;\"></iframe>");
		document.writeln("<input type=\"hidden\" name=\"hd" + edNameId + "\" id=\"hd" + edNameId + "\" value=\"\">");
		document.getElementById("hd" + edNameId).value = "";

		//if(htmlContent.indexOf("<style>p{margin: 0; padding: 0; font-family: Verdana; font-size: 12px;}</style>") <= -1)
		//	htmlContent = "<style>p{margin: 0; padding: 0; font-family: Verdana; font-size: 12px;}</style>" + htmlContent;
		if(htmlContent.indexOf("&lsquo;") > -1)
			htmlContent = htmlContent.replace(/&lsquo;/g, "'");
		//if(htmlContent.indexOf("'") > -1)
		//	htmlContent = htmlContent.replace(/'/g, "''");

		var defaultContent = "<html><head></head><body style=\"font-family: Mangal, Verdana; font-size:15px;\">" + htmlContent + "</body></html>";
		var iFrameSrc = document.getElementById(edNameId).contentWindow.document;
		iFrameSrc.open();
		iFrameSrc.write(defaultContent);
		iFrameSrc.close();
		iFrameSrc.designMode = "On";

		if(document.contentDocument)
			document.getElementById(edNameId).contentDocument.designMode = "on";
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

	var iFrameSrc = document.getElementById(edNameId).contentWindow;
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
		if(arrPNames == "_blank" || arrPNames == "_self")
		{
			var a = iFrameSrc.document.getElementsByTagName('a');
			for(i = 0; i <= a.length; i++){
				if(a[i].innerHTML == aText){
					a[i].setAttribute("target", arrPNames);
					break;
				}
			}
		}
		iFrameSrc.focus();

		switch(command.toString().toLowerCase()){
			case "insertimage":
				var allImg = iFrameSrc.document.getElementsByTagName("img");
				iFrameSrc.document.getElementsByTagName("img")[allImg.length-1].border = "0";
				for(i = 0; i < arrPN.length; i++){
					iFrameSrc.document.getElementsByTagName("img")[allImg.length-1].setAttribute(arrPN[i], arrPV[i]);
				}
				break;
			case "createlink":
				for(i = 0; i < arrPN.length; i++){
					iFrameSrc.document.getElementsByTagName("img")[allImg.length-1].setAttribute(arrPN[i], arrPV[i]);
				}
				break;
			default:

				break;
		}
	}
	catch(e)
	{}
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

function _showImageLibrary(ed)
{
	//window.open('./image-url-upload.php?type=image','imgUpload','width=520px,height=500px,toolbar=no,menubar=no,scrollbars=yes');
	var p = new Array();
	p[0] = new Array("ed", ed);
	p[1] = new Array("pg", 1);
	p[2] = new Array("nor", 100);
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
	else
	{
		var hLinkHTML = "<table width=\"300px\" cellpacing=\"2\" cellpadding=\"3\" border=\"0\" style=\"font-family: verdana; font-size:12px\">";
		hLinkHTML += "<tr><td colspan=\"2\">Type in the URL</td></tr>";
		hLinkHTML += "<tr><td colspan=\"2\"><input type=\"text\" name=\"txtHLink\" id=\"txtHLink\" class=\"textbox\" size=\"60\"></td></tr>";
		hLinkHTML += "<tr><td width=\"50%\"><input type=\"radio\" name=\"rdoLink\" id=\"rdoLinkSame\" value=\"_self\" />Same Window</td>";
		hLinkHTML += "<td width=\"50%\"><input type=\"radio\" name=\"rdoLink\" id=\"rdoLinkBlank\" value=\"_blank\" checked />New Window</td></tr>";
		hLinkHTML += "<tr><td colspan=\"2\"><input type=\"button\" name=\"btnHLink\" id=\"btnHLink\" class=\"btn btnc w100 fl\" value=\"Insert link\" onClick=\"javascript: if(document.getElementById('txtHLink').value != '') {var tg = '_self';if(_$('rdoLinkBlank').checked){tg = '_blank';}_executeCommand('" + edNameId + "', 'createLink', _$('txtHLink').value, tg);}_$('disableLayer').click();\">&nbsp;<input type=\"button\" name=\"btnClose\" id=\"btnClose\" class=\"ml10 btn btnc w100 fl\" value=\"Close\" onClick=\"javascript: _$('disableLayer').click();\"><br /><br /></td></tr>";
		hLinkHTML += "</table>";
		_showPopUp('html', hLinkHTML, 'imagePopUp', 600, 150, false);
		_$('txtHLink').focus();
	}
};

function _disableThisPage()
{
	var tranDiv;
	var isFound = false;
	for(i = 0; i < document.body.getElementsByTagName("IFRAME").length; i++)
	{
		if(document.body.getElementsByTagName("IFRAME")[i].id == "disableDiv")
			isFound = true;
	}
	if(isFound == false)
	{
		try{
			tranDiv = document.createElement("<IFRAME id=\"disableDiv\" style=\"background-color:#626262;z-index:99;top:0;left:0;position:absolute;width:100%\">");
			hDiv = document.createElement("<div id=\"lastItem\"></div>");
		}
		catch(e)
		{
			tranDiv = document.createElement("IFRAME");
			tranDiv.id = "disableDiv";
			tranDiv.style.backgroundColor = "#626262";
			tranDiv.style.zIndex = "99";
			tranDiv.style.top = 0;
			tranDiv.style.left = 0;
			tranDiv.style.position = "absolute";

			hDiv = document.createElement("div");
			hDiv.id = "lastItem";
		}
	}
	else
		tranDiv = document.getElementById("disableDiv");
	
	if(isFound == false)
		document.body.appendChild(hDiv);

	var brsName = navigator.appName;
	var scrWidth = screen.availWidth;
	var scrHeight = document.getElementById("lastItem").offsetTop;
    if(brsName == "Microsoft Internet Explorer")
		tranDiv.style.width = (scrWidth - 20) + "px";
	else
		tranDiv.style.width = (scrWidth - 16)  + "px";

	tranDiv.style.opacity = (50 / 100); 
    tranDiv.style.MozOpacity = (20 / 100); 
    tranDiv.style.KhtmlOpacity = (50 / 100);
    tranDiv.style.filter = "alpha(opacity=" + 60 + ")";
	tranDiv.style.display = "block";
	
	tranDiv.style.height = (scrHeight + 20) + "px";
	
	if(isFound == false)
		document.body.appendChild(tranDiv);
};

function _enableThisPage()
{
	var tranDiv = document.getElementById("disableDiv");
	tranDiv.style.display = "none";
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