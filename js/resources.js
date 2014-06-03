var WEBROOT = "http://localhost:8080/avanti/";
//var WEBROOT = "http://beta.peerlearning.com/";

_changeURL = function(priority){
    if(priority != ""){
        var cURL = document.URL;
        if (cURL.indexOf("#") > -1) {
            cURL = cURL.substr(0, cURL.indexOf("#"));
        }
        window.location = cURL + "#" + priority;
    }
}
_link = function(topicID, priority){
    if (topicID != ""){
        var p = new Array();
        var cURL = document.URL;
        if (cURL.indexOf("#") > -1) {
            priority = cURL.substr((cURL.indexOf("#") + 1), (cURL.length - 1));
            p.push(new Array("priority", priority));
        } else
            p.push(new Array("priority", priority));

        p.push(new Array("topicID", topicID));
        var aj = new _ajax(WEBROOT + "ajax/show-resources.php" , "post",p,function(){_waitshowresources()}, function(r){_responseshowresources(r)});
        aj._query();  
    }
}
_waitshowresources = function()
{
    document.getElementById('disableDiv').style.height = _getHeight('displayUser') + 'px';
    document.getElementById('disableDiv').style.display = 'block';
};
_responseshowresources = function(r)
{
    document.getElementById('disableDiv').style.display = 'none';
     document.getElementById('ResourcesDiv').style.display = 'none';
    if (r != ""){
        var resp = r.split("|#|");
        if (resp[0] == 1) {
            document.getElementById('displayUser').innerHTML = resp[1];
                document.getElementById('content_1').innerHTML = resp[2];
                $("#content_1").mCustomScrollbar({
                scrollButtons:{
                    enable:true
                }
            });
            $(".total-scroll-offset").text($("#content_1").data("onTotalScroll_Offset"));
            $(".total-scroll-back-offset").text($("#content_1").data("onTotalScrollBack_Offset"));
            /* Get the slug of current resource and concatinate on Address Bar */
            if(document.getElementById('hdnCurrP')){
                var curP = document.getElementById('hdnCurrP').value;
                if(curP != ""){
                    var cURL = document.URL;
                    if (cURL.indexOf("#") > -1) {
                        cURL = cURL.substr(0, cURL.indexOf("#"));
                    }
                    window.location = cURL + "#" + curP;
                }
            }
            /* check if Next resource item is available with a priority */
            if(document.getElementById('hdnNextP')){
                var nxt = document.getElementById('hdnNextP').value;
                if(nxt != ""){
                    if (parseInt(nxt) > 0) {
                        document.getElementById('nextLink').style.display = 'block';
                    }
                    else if(nxt == 0){
                        document.getElementById('nextLink').style.display = 'none';
                    }
                }
                
            } 
            /* check if Previous resource item is available with a priority */
            if(document.getElementById('hdnPrevP')){
                var prv = document.getElementById('hdnPrevP').value;
                if(prv != ""){
                    if (parseInt(prv) > 0) {
                        document.getElementById('prevLink').style.display = 'block';
                    }
                    else if(prv == 0) {
                        document.getElementById('prevLink').style.display = 'none';
                    }
                }
            } 
        }
    }
};  