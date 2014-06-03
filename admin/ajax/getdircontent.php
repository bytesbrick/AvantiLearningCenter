<?php
    error_reporting(0);
    $html = "";
    $dir = $_GET["dir"];
    if ($handle = opendir($dir)) {
        $iCount = 0;
        
        while (false !== ($entry = readdir($handle))) {
            $dirPath = $dir;
            $dirNames = explode("/upload/", $dir);
            $dirName = "Upload|" . str_ireplace("/", "|", $dirNames[1]);
            if($entry != "." && $entry != ".."){
                if(!is_dir($dir . "/" . $entry)){
                    $image_info = getimagesize($dir . "/" . $entry);
                    $image_width = $image_info[0];
                    if($image_width < 140)
                    $imgW = $image_width;
                    else
                    $imgW = 140;
                    $html .= "<div style=\"float: left;\">";
                        $html .= "<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\">";
                            $html .= "<tr>";
                                $html .= "<td><div class=\"libimg\"><img width=\"" . $imgW . "px\" src=\"" . str_ireplace("../../", "../", $dir . "/" . $entry) . "\" border=\"0\" /></div></td>";
                            $html .= "</tr>";
                            $html .= "<tr>";
                                $html .= "<td><input type=\"radio\" name=\"rdoImages\" id=\"rdoImages" . $iCount . "\" value=\"" . str_ireplace("../../", "../", $dir . "/" . $entry) . "\" />&nbsp;" . strtoupper($entry) . "</td>";
                            $html .= "</tr>";
                        $html .= "</table>";
                    $html .= "</div>";
                } else {
                    $dirPath .= "/" . $entry;                   
                    $dirName .= "|" . $entry;
                    $html .= "<div style=\"float: left;\">";
                        $html .= "<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\">";
                            $html .= "<tr>";
                                $html .= "<td><div class=\"libdiv\"><a href=\"javascript: void(0);\" onclick=\"javascript: _showDirContent('allimg', '" . str_ireplace("../../", "../", $dirPath) . "', '" . $dirName . "');\">" . $entry . "</a></div></td>";
                            $html .= "</tr>";
                        $html .= "</table>";
                    $html .= "</div><div style=\"clear: both\"></div>";
                }
            }
        }
    }
    echo $html;
?>