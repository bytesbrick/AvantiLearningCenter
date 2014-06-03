var aj;
_checkcat = function(name){
	if(name != "")
	{
		if(window.XMLHttpRequest)
			aj = new XMLHttpRequest;
		else if(window.ActiveXobject)
			aj = new ActiveXobject("MicroSoft.XMLHTTP");
		aj.open("POST", "check-category.php", true);
		aj.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		aj.onreadystatechange = _httpCheckgall;
		aj.send("CatName=" + name);
	}
	else
	{
		document.getElementById("errMessage1").innerHTML = "";
		document.getElementById("hdCat").value = "1";
	}
 };
_httpCheckcat = function(){
 
	if(aj.readyState == 4)
	{ 			
		var disp = aj.responseText.trim();
		if(disp != "" && disp != undefined)
		{
			document.getElementById("hdCat").value = disp;
			if(disp == 0)
			{
				document.getElementById("errMessage1").innerHTML = "Available";
				document.getElementById("txtcategory").focus();
				
			}
			else
			{
				document.getElementById("errMessage1").innerHTML = "Gallery name Already in use.";
				document.getElementById("txtcategory").focus();
			}
		}
	}
};
// gallery
