String.prototype.trim = function() {

	var x=this;
  x=x.replace(/^\s*(.*)/, "$1");
  x=x.replace(/(.*?)\s*$/, "$1");
  return x;
}

function isEmailAddr(email, errMsg, errDispObjId)
{
  var result = false;
  var theStr = new String(email.value);
  var index = theStr.indexOf("@");
  if (index > 0)
  {
    var pindex = theStr.indexOf(".",index);
    if ((pindex > index+1) && (theStr.length > pindex+1))
	result = true;
  }
  if(result == false)
  {
	  if(errDispObjId != "" && errDispObjId != null && document.getElementById(errDispObjId))
        document.getElementById(errDispObjId).innerHTML = errMsg;
	  else
		alert(errMsg);
	email.focus();
  }
  return result;
}
function isNumeric(st, errMsg)
{
	// Function to check if user input is Numeric.
	// For example, user enters 1232s324 OR sw23232 OR 2342343sdhs OR asgshsgd, it would return FALSE.
	var Char;
	sText = st.value;
	var IsNumeric = true;
	var blnk = "0123456789.-";
	var blnkcnt = 0;
	for (i = 0; i < sText.length; i++)
	{
		Char = sText.charAt(i);
		if (blnk.indexOf(Char) == -1)
		{
			IsNumeric = false;
		}
	}
	if(IsNumeric == false)
	{
		if(errMsg != '')
		{
			alert(errMsg);
			st.value="";
			st.focus();
		}
	}
	return IsNumeric;
}
function isAnyNumeric(st, mode, errMsg)
{
	// Function to check if user input has any Numeric value.
	// For example, user enters 1232s324 OR sw23232 OR 2342343sdhs, it would return TRUE.
	// But if user enters "asgshsgd", it would return FALSE
	var Char;
	var chkMode = mode;
	sText = st.value;
	var IsNumeric = false;
	var blnk = "0123456789.-";
	var blnkcnt = 0;
	for (i = 0; i < sText.length; i++)
	{
		Char = sText.charAt(i);
		if (blnk.indexOf(Char) > -1)
		{
			IsNumeric = true;
		}
	}
	if(IsNumeric == chkMode)
	{
		if(errMsg != '')
		{
			alert(errMsg);
			st.focus();
		}
		return false;
	}
	else
	{
		return true;
	}	
}
function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		//selectbox.options.remove(i);
		selectbox.remove(i);
	}
}
function addOption(selectbox, value, text )
{
	var optn = document.createElement("OPTION");
	optn.text = text;
	optn.value = value;

	selectbox.options.add(optn);
}
function isFilledText(textbox, spStr, errMsg, errDispObjId)
{
	var strVal;
	strVal = textbox.value;
	strVal = strVal.trim();
	if((strVal=='') || (strVal==spStr))
	{
		if(errMsg != '')
		{
		    if(errDispObjId != "" && errDispObjId != null && document.getElementById(errDispObjId))
		    {
		        document.getElementById(errDispObjId).innerHTML = errMsg;
			}
			else
			    alert(errMsg);
			textbox.focus();
		}
		return false;
	}
	else
		return true;
}
function isFilledSelect(selectbox, spStr, errMsg, cmpOpt, errDispObjId)
{
	// Possible values for cmpOpt are
	// 0 when values are supposed to be compared but in numbers, variable spStr is mentioned in number
	// 1 when text needs to be compared, variable spStr is mentioned in text
	// 2 when values are supposed to be compared but in text, variable spStr is mentioned in text
	var strVal;
	if(cmpOpt == 0)
	{
		strVal = selectbox.selectedIndex;
		if(strVal==spStr)
		{
		    if(errDispObjId != "" && errDispObjId != null && document.getElementById(errDispObjId))
		    {
		        document.getElementById(errDispObjId).innerHTML = errMsg;
			}
			else
			    alert(errMsg);
			selectbox.focus();
			return false;
		}
		else
			return true;
	}
	else if(cmpOpt == 1)
	{
		strVal = selectbox.options[selectbox.selectedIndex].text;
		spStr = spStr.trim();
		if(strVal==spStr)
		{
		    if(errDispObjId != "" && errDispObjId != null && document.getElementById(errDispObjId))
		    {
		        document.getElementById(errDispObjId).innerHTML = errMsg;
			}
			else
			    alert(errMsg);
			selectbox.focus();
			return false;
		}
		else
			return true;
	}
	else if(cmpOpt == 2)
	{
		strVal = selectbox.options[selectbox.selectedIndex].value;
		spStr = spStr.trim();
		if(strVal==spStr)
		{
		    if(errDispObjId != "" && errDispObjId != null && document.getElementById(errDispObjId))
		    {
		        document.getElementById(errDispObjId).innerHTML = errMsg;
			}
			else
			    alert(errMsg);
			selectbox.focus();
			return false;
		}
		else
			return true;
	}
}
function isCBoxChecked(checkBox, numChecked, errMsg, countCBox, errDispObjId)
{
	var numCBox, chkTemp, chkCount;	
	if(countCBox == 1)
	{
		if(checkBox.checked == false)
		{
			if(errMsg != "")
			{
				if(errDispObjId != "" && errDispObjId != null && document.getElementById(errDispObjId))
				{
					document.getElementById(errDispObjId).innerHTML = errMsg;
				}
				else
					alert(errMsg);
				checkBox.focus();
			}
			return false;
		}
		else
			return true;
	}
	else
	{
		chkTemp = false;
		chkCount = 0;
		numCBox = checkBox.length;
		for(i=0;i<numCBox;i++)
		{
			if(checkBox[i].checked == true)
			{
				chkCount++;
				if(chkCount==numChecked)
				{
					chkTemp = true;
				}
			}
		}
		if(chkTemp==false)
		{
			if(errMsg != "")
			{
				if(errDispObjId != "" && errDispObjId != null && document.getElementById(errDispObjId))
				{
					document.getElementById(errDispObjId).innerHTML = errMsg;
				}
				else
					alert(errMsg);
			}
		}
		return chkTemp;
	}
}
function compareString(strObject1, strObject2, objType)
{
	var str1, str2;
	var isEqual = false;
	if(objType == "Text")
	{
		str1 = strObject1.value;
		str1 = str1.trim();
		str2 = strObject2.value;
		str2 = str2.trim();
		if(str1 == str2)
			isEqual = true;
	}
	else if(objType == "Select")
	{
		str1 = strObject1.options[strObject1.selectedIndex].text;
		str1 = str1.trim();
		str2 = strObject2.options[strObject2.selectedIndex].text;
		str2 = str2.trim();
		if(str1 == str2)
			isEqual = true;
	}
	return isEqual;
}
function createStrSubmit(frmName)
{
	var strSubmit = "";
	var currElement, lstElement;
	lstElement = "";
	for(i=0; i<frmName.elements.length; i++)
	{
		currElement = frmName.elements[i];
		switch(currElement.type)
		{
			case 'text':
            case 'select-one':
            case 'hidden':
            case 'password':
            case 'textarea':
            strSubmit += currElement.name + '=' + escape(currElement.value) + '&'
            break;
			case 'checkbox':
				if(currElement.checked == true)
				{
					if(lstElement != currElement.name)
					{
						strSubmit += currElement.name + '=' + escape(currElement.value) + '&'
					}
					else
					{
						if(strSubmit.substring(strSubmit.length - 1, strSubmit.length) == '&')
						strSubmit = strSubmit.substring(0, strSubmit.length - 1)
						strSubmit += ',' + escape(currElement.value)
					}
				lstElement = currElement.name
				}				
			break;
		}
		if(strSubmit.substring(strSubmit.length - 1, strSubmit.length) != '&')
		strSubmit += '&';
	}
	if(strSubmit.substring(strSubmit.length - 1, strSubmit.length) == '&')
	strSubmit = strSubmit.substring(0,strSubmit.length-1);
	return strSubmit;
}

function checkFormAllFields(frmName)
{
	var strSubmit = true;
	var currElmVal;
	var currI = -1;
	for(i=0; i<frmName.elements.length; i++)
	{
		currElement = frmName.elements[i];
		switch(currElement.type)
		{
			case 'text':
            case 'select-one':
            case 'password':
            case 'textarea':
			case 'checkbox':
				currElmVal = currElement.value;
				currElmVal = currElmVal.trim();
				if(escape(currElmVal) == "")
				{
					if(strSubmit == true)
					currI = i;
					strSubmit = false;
				}
            break;
		}
		
	}	
	if(strSubmit == false)
	{
		alert('No field can be left blank.');
		currElement = frmName.elements[currI];
		currElement.focus();
	}
	return strSubmit;
};

function _allowNumeric(e)
{
	var keyp;
	var ddl = document.getElementById('ddlState').options[document.getElementById('ddlState').selectedIndex].value;
	if(ddl == 0)
	document.getElementById('ddlState').focus();
	keyp = getKeyCode(e);
	if(keyp >= 48 && keyp <= 57 || keyp >= 96 && keyp <= 105)
		return true;
	else if(keyp == null)
		return true;
	else
	{
		if(keyp == 8 || keyp == 0 || keyp == 46 || keyp == 9)
			return true;
		else
			return false;
	}
};

function _allowAlpha(e)
{
	var keyp;
	var ddl = document.getElementById('ddlState').options[document.getElementById('ddlState').selectedIndex].value;
	if(ddl == 0)
	document.getElementById('ddlState').focus();
	keyp = getKeyCode(e);
	//alert (ddl);
	if(keyp >= 60 && keyp <= 95 )
		return true;
	else if(keyp == null)
		return true;
	else
	{
		if(keyp == 8 || keyp == 0 || keyp == 46 || keyp == 32 || keyp == 9)
			return true;
		else
			return false;
	}
};

function getKeyCode(e)
{
	if (window.event)
		return window.event.keyCode;
	 else if (e)
		return e.which;
	 else
		return null;
};

function _setCookie(c_name,value,expiredays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+expiredays);
	document.cookie=c_name+ "=" +escape(value)+	((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
};

function _getCookie(c_name)
{
	if (document.cookie.length>0)
	{
		c_start=document.cookie.indexOf(c_name + "=");
		if (c_start!=-1)
		{ 
			c_start=c_start + c_name.length+1; 
			c_end=document.cookie.indexOf(";",c_start);
			if (c_end==-1) c_end=document.cookie.length;
			return unescape(document.cookie.substring(c_start,c_end));
		} 
	}
	return "";
};

function _getDDLValue(ddlObjID)
{
    var ddlVal = "";
    if(document.getElementById(ddlObjID))
        ddlVal = document.getElementById(ddlObjID).options[document.getElementById(ddlObjID).selectedIndex].value;
    return ddlVal;
};

function _getDDLText(ddlObjID)
{
    var ddlText = "";
    if(document.getElementById(ddlObjID))
        ddlText = document.getElementById(ddlObjID).options[document.getElementById(ddlObjID).selectedIndex].text;
    return ddlText;
};

_fillNextDDL = function(curDDL, nxtDDL)
{
    if(nxtDDL)
    {
        removeAllOptions(nxtDDL);
        for(i=0 ; i < curDDL.options.length; i++)
            addOption(nxtDDL, curDDL.options[i].value, curDDL.options[i].text);
    }
};

_disableFormElements = function(frmID){
	var frmElemCount = document.getElementById(frmID).elements.length;
	for(i = 0; i < frmElemCount; i++)
	{
		cElement = document.getElementById(frmID).elements[i];
		cElement.disabled = true;
	}
};

_enableFormElements = function(frmID){
	var frmElemCount = document.getElementById(frmID).elements.length;
	for(i = 0; i < frmElemCount; i++)
	{
		cElement = document.getElementById(frmID).elements[i];
		cElement.disabled = false;
	}
};

_clearFormElements = function(frmID){
	var frmElemCount = document.getElementById(frmID).elements.length;
	for(i = 0; i < frmElemCount; i++)
	{
		cElement = document.getElementById(frmID).elements[i];
		switch(cElement.type)
		{
			case "text":
			case "password":
			case "hidden":
			case "textarea":
				cElement.value = "";
				break;
			case "select-one":
				cElement.selectedIndex = 0;
				break;
			case "checkbox":
			case "radio":
				cElement.checked = false;
				break;
			default:
				break;
		}
	}
};

_selAllUsers = function(){
	for(i = 0;  i < document.getElementsByName("chkUsers[]").length; i++)
	{
		document.getElementsByName("chkUsers[]")[i].checked = document.getElementById("chkAllUsers").checked;
	}
};

 function isNumberKey(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57) )
	return false;
	return true;
}