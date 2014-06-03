function _disableThisPage()
{
	var d;
        try{
            d = document.createElement("<div id='_bbdl' style='background-color:#000;position:fixed;opacity:0.50;z-index:99;top:0;left:0;position:fixed;cursor:pointer;'></div>");
        }
        catch(e){
            d = document.createElement("div");
            d.id = "_bbdl";
            d.style.position = "fixed";
            d.style.height = "100%";
            d.style.width = "100%";
            d.style.backgroundColor = "#000";
            d.style.opacity = 0.50;
			d.style.left = 0;
			d.style.top = 0;
            d.style.zIndex = 99;
            d.style.cursor = 'pointer';
        }
        document.body.appendChild(d);
};

function _enableThisPage()
{
	try{
		var d = document.getElementById("_bbdl");
		document.body.removeChild(d);
	}
	catch(e){}
};