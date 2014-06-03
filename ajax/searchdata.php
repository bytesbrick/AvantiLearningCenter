<?php
    $resp = "";
    $html = "";
    $sql = "";

    include("../includes/config.php");		
    include("../classes/cor.mysql.class.php");
    $db = new MysqlConnection(CONNSTRING);
    $db->open();
    
    $table = "";
    $arrTables = array();
    $arrFields = array();
    $arrHeadings = array();
    $arrNames = array();
    $arrAction = array();
    $arrURLs = array();
    if(isset($_POST["textsearch"]) && trim($_POST["textsearch"]) != ""){
        $type = $_POST["textsearch"];
        
        $arrTables[] = "avn_curriculum_master acm";
        $arrTables[] = "ltf_category_master lcm";
        $arrTables[] = "avn_chapter_master achm";
        $arrTables[] = "avn_topic_master atm";
        //$arrTables[] = "avn_resources_detail ard INNER JOIN avn_topic_master atm ON ard.topic_id = atm.unique_id";
           
        $arrFields[] = array("curriculum_name" , "curriculum_slug as slug");
        $arrFields[] = array("category_name as title", "category_slug as slug");
        $arrFields[] = array("chapter_name as title", "chapter_desc as description", "chapter_image as image", "chapter_slug as slug");
        $arrFields[] = array("topic_image as image","topic_name as title","topic_desc as description", "topic_slug as slug");
        //$arrFields[] = array("title as title", "text as description", "resource_slug as slug");
        
        $arrWhereFields[] = array("acm.curriculum_name" , "acm.curriculum_slug");
        $arrWhereFields[] = array("lcm.category_name", "lcm.category_slug");
        $arrWhereFields[] = array("achm.chapter_name", "achm.chapter_desc");
        $arrWhereFields[] = array("atm.topic_name", "atm.topic_desc");
        //$arrWhereFields[] = array("ard.title", "ard.resource_slug");
        
        $arrNames[] = array("Curriculum Name");
        $arrNames[] = array("Category Name");
        $arrNames[] = array("Chapter Name");
        $arrNames[] = array("Topic Name");
        //$arrNames[] = array("Topic", "Resources");
        
        $arrHeadings[] = "Curriculums";
        $arrHeadings[] = "Subjects";
        $arrHeadings[] = "Chapters";
        $arrHeadings[] = "Topics";
        //$arrHeadings[] = "Resources";
             
        for($d = 0; $d < count($arrTables); $d++){
            $where = "";
            $fields = "";
            for($w = 0; $w < count($arrWhereFields[$d]); $w++)
                $where .= $where == "" ? $arrWhereFields[$d][$w] . " LIKE '%". $_POST["textsearch"] . "%'" : " OR " .$arrWhereFields[$d][$w] . " LIKE '%".$_POST["textsearch"]."%'";
            for($f = 0; $f < count($arrFields[$d]); $f++)
                $fields .= $fields == "" ? $arrFields[$d][$f] : ", " . $arrFields[$d][$f];
            
            $sql = "SELECT " . $fields . " FROM " . $arrTables[$d] . " WHERE (" .  $where . ")";
            //print_r($sql);
            $r = $db->query("query",$sql);
            if(!isset($r["response"])){
                if(count($r) > 0){
                    $resp = 1;
                    if(!isset($r['response'])){
                        $html .= "<h3 style='text-align:left;color:#A74242;margin:15px 0px 2px 13px;'>" . $arrHeadings[$d] . " (" . count($r) . ")</h3>";
                        $html .= "<table border='0' cellpadding='0' cellspacing='0' width='100%'>";
                        for($i=0; $i< count($r); $i++)
                        {
                            $html .="<tr>";
                            $vals = $arrFields[$d];
                            $html .="<td style='width: 100px;'>";
                            $html .="<div class='presondiv' style='margin-right:15px;'><a href='" . __WEBROOT__ . "/curriculum/" . trim($r[$i]["slug"]) . "/" . trim($r[$i]["slug"]) . "/" . trim($r[$i]["slug"]) . "/' class='fl'><img src='" . __WEBROOT__ . "/admin/images/upload-image/" . $r[$i]["image"] . "' width='80' height='70' class='noborder' style='padding:10px;'></a></div>";
                            $html.="</td>";
                            $html.="<td valign='top'><div class='titteldiv'><span class='enterlessonsdiv'><a href='" . __WEBROOT__ . "/curriculum/" . trim($r[$i]["curriculum_slug"]) . "/" . trim($r[$i]["category_slug"]) . "/" . trim($r[$i]["chapter_slug"]) . "/' >" . ucwords($r[$i]["title"]) . "</a></span></div>";
                            $html.="<span class='enterclassdiv'>" . ucwords($r[$i]["description"]) . "</span>";
                            $html.="</td>";
                            $html.="</tr>";
                            $html .="<tr>";
                            $html .="<td colspan='2'>";
                            $html .="<span style='border-bottom: 1px solid #ccc;margin-bottom: 10px;float: left;width: 100%;'></span>";
                            $html .="</td>";
                            $html .="</tr>";
                        }
                        $html .= "</table>";
                    }
                }else
                    $resp = 0;
            }
        }
    }
    echo $html;
?>