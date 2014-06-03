var WEBROOT = "http://localhost:8080/avanti";
//var WEBROOT = "http://beta.peerlearning.com";
_getcenter = function(cid)
{
	document.getElementById('ddlbatch').style.display = 'block';	
	var p = new Array();
	p[0] = new Array("unique_id", cid);
	var aj = new _ajax(WEBROOT +"/ajax/get-batches.php", "post",p,function(){_waitGetCenter()}, function(r){_responseGetCenter(r)});
	aj._query();	
}
_waitGetCenter = function()
{
	document.getElementById('ddlbatch').innerHTML = "<option value=''>Please wait...</option>";
};
_responseGetCenter = function(resp)
{
	//document.getElementById('loadcenters').innerHTML = "";
	document.getElementById('ddlbatch').innerHTML = "";
	document.getElementById('ddlbatch').style.display = 'block';
	
	resps = resp.split("|#|");
	html = resps[0];
	category_name = resps[1];
	if(resp != "" && resp != "Invalid Center")
		document.getElementById('ddlbatch').innerHTML += html;
};