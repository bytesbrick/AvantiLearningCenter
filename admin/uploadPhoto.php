<?php
ini_set("post_max_size", "15M");
ini_set('upload_max_filesize', '15M');
if(!is_dir("../images/upload/" . date('Y')))
mkdir("../images/upload/" . date('Y'), 0775);
if(!is_dir("../images/upload/" . date('Y') . "/" . date('m')))
mkdir("../images/upload/" . date('Y') . "/" . date('m'), 0775);
if(!is_dir("../images/upload/" . date('Y') . "/" . date('m') . "/" . date('d')))
mkdir("../images/upload/" . date('Y') . "/" . date('m') . "/" . date('d'), 0775);
$uploaddir = "../images/upload/" . date('Y') . "/" . date('m') . "/" . date('d') . "/"; 
$file = $uploaddir . basename($_FILES['myfile']['name']); 
$file_name= $_FILES['myfile']['name'];
$arrFormat = array(".jpg", ".jpeg", ".gif", ".png");
$arrUpdateFormat = array("-" . mktime() . ".jpg", "-" . mktime() . ".jpeg", "-" . mktime() . ".gif", "-" . mktime() . ".png");
$file = str_ireplace($arrFormat, $arrUpdateFormat, $file);

if (move_uploaded_file($_FILES['myfile']['tmp_name'], $file)) {
  $rezultat = $file;
} else {
  $rezultat = ''; 
}
//echo $rezultat;
$rezultat = urlencode($rezultat);
echo '<body onload="javacript: parent.doneloading(\''.$rezultat.'\')"></body>';
?>
  