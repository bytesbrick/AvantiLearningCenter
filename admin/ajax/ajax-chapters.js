_checkData = function()
{
	var txtemailid = document.getElementById('txtemailid').value;
	
	var urlhdnipaddress = document.getElementById('urlhdnipaddress').value;
	
	var urlhdnuseragent = document.getElementById('urlhdnuseragent').value;
	
	var p = new Array();
	p[0] = new Array("txtemailid", txtemailid);
	p[1] = new Array("urlhdnipaddress", urlhdnipaddress);
	p[2] = new Array("urlhdnuseragent", urlhdnuseragent);
	var aj = new _ajax(webroot + "/ajax/save-mail.php", "post",p,function(){_waitGetresp()}, function(r){_responseGetresp(r)});
	aj._query();
}
_waitGetresp = function()
{
	document.getElementById('savesuccmsg').style.color = "#00CCFF";
	document.getElementById('savesuccmsg').style.display = 'block';
	document.getElementById('savesuccmsg').innerHTML = 'processing...';
};
_responseGetresp = function(resp)
{
	document.getElementById('savesuccmsg').style.display = 'block';
	if(resp == "exist")
	{
		document.getElementById('savesuccmsg').innerHTML = 'you have already subscribed!';
		document.getElementById('txtemailid').value ="";
	}
	if(resp == "saved")
	{
		document.getElementById('savesuccmsg').innerHTML = 'successfully submitted!';
		document.getElementById('txtemailid').value ="";
		document.getElementById('savesuccmsg').className = 'succolor';
	}
};