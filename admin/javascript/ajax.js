_ajax = function(fileName, callMethod, callParam, aWFunc, aRFunc){
    this.flName = fileName.toLowerCase();
    this.cMethod = callMethod.toLowerCase();
    this.cParam = new Array();
    for(i = 0; i < callParam.length; i++)
        this.cParam[i] = callParam[i].join("=");
    this.strParam = this.cParam.join("&");
	this._query = function(){
        var aj;
        if (window.XMLHttpRequest)
            aj = new XMLHttpRequest;
        else if (window.ActiveXObject)
            aj = new ActiveXObject("Microsoft.XMLHTTP");
        if (this.cMethod == "get")
            this.flName = this.flName + "?" + this.strParam;
	aj.onreadystatechange = function() {
            if (aj.readyState < 4){
                    aWFunc();
            }
            else if (aj.readyState == 4) {
                var r = "";
                if(aj.status == 200){
                    r = aj.responseText;
                    aj = null;
                }
                else
                    r = "ERROR " + aj.readyState + ": " + aj.statusText;
                var rf = function(rs) { aRFunc(rs); }
                rf(r);
            }
        };
        aj.open(this.cMethod, this.flName, true);
        if (this.cMethod == "post")
            aj.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        aj.onerror = function(){
            //alert("Request can not be processed right now. Please try again later.");
        }
        
	if (this.cMethod == "post")
            aj.send(this.strParam);
        else
            aj.send(true);
    };
};