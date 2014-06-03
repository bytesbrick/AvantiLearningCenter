<style>
    ul#imgupload,  ul#allimages{
        margin: 10px 10px;
        padding: 0;
        list-style-type: none;
        height: 11px;
    }
    ul#imgupload li{
        float: left;
        margin-right: 2px;
    }
    ul#imgupload li a{
        background-color: #FADFAD;
        text-decoration: none;
        padding: 5px 40px;
        color: #a74242;
        border-radius: 5px 5px 0 0;
    }
    ul#imgupload li a:hover{
        background-color: #f7d38d;
    }
    ul#imgupload li a.active{
        background-color: #a74242;
        color: #fff;
    }
    #imgupload0, #imgupload1, #imgupload2{
        border:solid 1px #a74242;
        padding: 10px;
        height: 540px;
        width: 977px;
    }
    #imgupload0{
        display: block;
    }
    #imgupload1, #imgupload2, #divSettings{
        display: none;
    }
    
    ul#allimages li{
        list-style-type: none;
    }
    div#allimg{
        width:100%;
        height: 400px;
        overflow: scroll;
    }
    div.libimg{
        width: 150px;
        height: 150px;
        float: left;
        overflow: hidden;
    }
    div.divLibSettings{
        display: block;
    }
    div.libdiv{
        width: 150px;
        height: 20px;
        float: left;
    }
</style>
<?php
    error_reporting(0);
    $uploaddir = "../images/upload";
?>
<ul id="imgupload">
    <li><a href="javascript: void(0);" class="active" onclick="javascript: _setImgSelMode(0);" title="From your computer" >From your computer</a></li>
    <li><a href="javascript: void(0);" onclick="javascript: _setImgSelMode(1);" title="From Media library" >From Media library</a></li>
    <li class="last"><a href="javascript: void(0);" onclick="javascript: _setImgSelMode(2);" title="From Web/Internet" >From Web/Internet</a></li>
</ul>
<div style="clear: both"></div>
<div id="imgupload0">
<form id="uploadform" action="uploadPhoto.php" method="post" enctype="multipart/form-data" target="uploadframe">
    <input type="hidden" name="hdImgURL" id="hdImgURL" value="" />
  <table cellpadding="5" cellspacing="0" border="0" width="100%">
    <tr>
        <td>Pick image from your computer</td>
    </tr>
    <tr>
        <td><input type="file" id="myfile" name="myfile" onchange="uploadimg(this.form); return false" /></td>
    </tr>
    <tr>
        <td>
            <div id="showimg"></div>
            <div style="clear: both"></div>
            <div id="divSettings"><br /><input type="radio" id="rdoWidth1" name="rdoWidth" value="1" onclick="javascript: _widthBox(this.id, '');" checked="checked" />Default Size <input type="radio" id="rdoWidth2" name="rdoWidth" value="1" onclick="javascript: _widthBox(this.id, 'txtWidth');" />Custom Size <input type="text" id="txtWidth" name="widTextBox" placeholder="Width of image in pixel" readonly="readonly" onkeypress="javascript: return _allowNumeric(event);" maxlength="3" /> pixel<br /><br /><input type="button" id="btnInsert" name="btnInsert" value="Insert Image" onclick="javascript: _setImage('<?php echo $_GET["ed"]; ?>');" /></div>
            <div id="divSettings"></div>
        </td>
    </tr>
    <tr>
        <td><iframe id="uploadframe" name="uploadframe" src="uploadPhoto.php" width="8" height="8" scrolling="no" frameborder="0"></iframe></td>
    </tr>
  </table>
</form>
</div> 
<div id="imgupload1">
  <table cellpadding="5" cellspacing="0" border="0" width="100%">
    <tr>
        <td>Media Library</td>
    </tr>
    <tr>
        <td>You are here: <span id="bcrum"><a href="javascript: void(0);" onclick="javascript: _showDirContent('allimg', '<?php echo $uploaddir; ?>', 'Upload');" title="Upload">Upload</a> &raquo; <a href="javascript: void(0);" onclick="javascript: _showDirContent('allimg', '<?php echo $uploaddir; ?>/<?php echo date("Y"); ?>', 'Upload|<?php echo date("Y"); ?>');" title="<?php echo date("Y"); ?>"><?php echo date("Y"); ?></a> &raquo; <a href="javascript: void(0);" onclick="javascript: _showDirContent('allimg', '<?php echo $uploaddir; ?>/<?php echo date("Y"); ?>/<?php echo date("m"); ?>', 'Upload|<?php echo date("Y"); ?>|<?php echo date("m"); ?>');" title="<?php echo date("m"); ?>"><?php echo date("m"); ?></a> &raquo; <a href="javascript: void(0);" onclick="javascript: _showDirContent('allimg', '<?php echo $uploaddir; ?>/<?php echo date("Y"); ?>/<?php echo date("m"); ?>/<?php echo date("d"); ?>', 'Upload|<?php echo date("Y"); ?>|<?php echo date("m"); ?>|<?php echo date("d"); ?>');" title="<?php echo date("d"); ?>"><?php echo date("d"); ?></a></span></td>
    </tr>
    <tr>
        <td>
            <div id="allimg">
<?php
    $dir = "../../images/upload/" . date("Y") . "/" . date("m") . "/" . date("d");
    if ($handle = opendir($dir)) {
        $iCount = 0;
        while (false !== ($entry = readdir($handle))) {
            if($entry != "." && $entry != ".."){
                if(!is_dir($dir . "/" . $entry)){
                    $image_info = getimagesize($dir . "/" . $entry);
                    $image_width = $image_info[0];
                    if($image_width < 140)
                    $imgW = $image_width;
                    else
                    $imgW = 140;
?>
            <div style="float: left;">
                <table cellpadding="5" cellspacing="0" border="0">
                    <tr>
                        <td><div class="libimg"><img width="<?php echo $imgW; ?>px" src="<?php echo str_ireplace("../../", "../", $dir . "/" . $entry); ?>" border="0" style="max-width:200px;" /></div></td>
                    </tr>
                    <tr>
                        <td><input type="radio" name="rdoImages" id="rdoImages<?php echo $iCount; ?>" value="<?php echo str_ireplace("../../", "../", $dir . "/" . $entry); ?>" />&nbsp;<?php echo strtoupper($entry) ?></td>
                    </tr>
                </table>
            </div>
<?php
                    $iCount++;
                }
            }
        }
    }
?>
            </div>
            <div style="clear: both"></div>
            <div id="divLibSettings"><br /><input type="radio" id="rdoWidth3" name="rdoWidth" value="1" onclick="javascript: _widthBox(this.id, '');" checked="checked" />Default Size <input type="radio" id="rdoWidth4" name="rdoWidth" value="1" onclick="javascript: _widthBox(this.id, 'txtWidth1');" />Custom Size <input type="text" id="txtWidth1" name="widTextBox" placeholder="Width of image in pixel" readonly="readonly" onkeypress="javascript: return _allowNumeric(event);" maxlength="3" /> pixel<br /><br /><input type="button" id="btnLibInsert" name="btnLibInsert" value="Insert Image" onclick="javascript: _insLibImage('<?php echo $_GET["ed"]; ?>');" /></div>
        </td>
    </tr>
  </table>
</div>
<div id="imgupload2">
  <table cellpadding="5" cellspacing="0" border="0">
    <tr>
        <td>Write image URL</td>
    </tr>
    <tr>
        <td><input type="text" id="imgURL" name="imgURL" class="inputseacrh" style="width:500px !important;margin-left: 0px !important;" /></td>
    </tr>
    <tr>
        <td>
            <input type="button" id="btnInsertURL" name="btnInsertURL" value="Insert Image" onclick="javascript: _insImageURL('<?php echo $_GET["ed"]; ?>');" />
        </td>
    </tr>
  </table> 
</div>