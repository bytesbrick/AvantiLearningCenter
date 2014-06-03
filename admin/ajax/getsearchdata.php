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
    if(isset($_POST["ddlType"]) && trim($_POST["ddlType"]) != ""){
        $type = $_POST["ddlType"];
        switch($type){
            case "curriculums":
                $arrTables[] = "avn_curriculum_master";
                $arrFields[] = array("curriculum_name");
                $arrHeadings[] = "Curriculums";
                $arrNames[] = "Curriculum Name";
                $arrURLs[] = "edit-curriculum";
                break;
            case "subjects":
                $arrTables[] = "ltf_category_master";
                $arrFields[] = array("category_name");
                $arrHeadings[] = "Subjects";
                $arrNames[] = "Subject Name";
                $arrURLs[] = "edit-category";
                break;
            case "chapters":
                $arrTables[] = "avn_chapter_master";
                $arrFields[] = array("chapter_name", "chapter_desc", "chapter_code");
                $arrHeadings[] = "Chapters";
                $arrNames[] = "Chapter Name";
                $arrURLs[] = "edit-chapter";
                break;
            case "topics":
                $arrTables[] = "avn_topic_master";
                $arrFields[] = array("topic_name");
                $arrHeadings[] = "Topics";
                $arrNames[] = "Topic Name";
                $arrURLs[] = "edit-topic";
                break;
            case "resources":
                $arrTables[] = "ltf_resources_master";
                $arrFields[] = array("resource_title");
                $arrHeadings[] = "Resources";
                $arrNames[] = "Resource";
                $arrURLs[] = "edit-resource";
                break;
            case "tests":
                $arrTables[] = "avn_question_master";
                $arrFields[] = array("question_name");
                $arrHeadings[] = "Questions";
                $arrNames[] = "Question";
                $arrURLs[] = "edit-spot-test";
                break;
            case "tags":
                $arrTables[] = "ltf_tags_master";
                $arrFields[] = array("tag_name");
                $arrHeadings[] = "Tags";
                $arrNames[] = "Tag Name";
                $arrURLs[] = "add-tag";
                break;
            case "editors":
                $arrTables[] = "ltf_admin_usermaster";
                $arrFields[] = array("username");
                $arrHeadings[] = "Editors";
                $arrNames[] = "Editor Name";
                $arrURLs[] = "edit-editor";
                break;
            case "users":
                $arrTables[] = "avn_login_master";
                $arrFields[] = array("username");
                $arrHeadings[] = "Users";
                $arrNames[] = "User Name";
                $arrURLs[] = "edit-user";
                break;
            case "all":
                $arrTables[] = "avn_curriculum_master acm";
                $arrTables[] = "ltf_category_master lcm";
                $arrTables[] = "avn_chapter_master achm";
                $arrTables[] = "avn_topic_master atm";
                $arrTables[] = "avn_resources_detail ard INNER JOIN avn_topic_master atm ON ard.topic_id = atm.unique_id";
                $arrTables[] = "avn_question_master aqm";
                $arrTables[] = "ltf_tags_master ltm";
                $arrTables[] = "ltf_admin_usermaster lau";
                $arrTables[] = "avn_login_master alm";
                
                $arrFields[] = array("curriculum_name");
                $arrFields[] = array("category_name");
                $arrFields[] = array("chapter_name", "chapter_desc", "chapter_code");
                $arrFields[] = array("topic_name");
                $arrFields[] = array("topic_name", "title");
                $arrFields[] = array("question_name");
                $arrFields[] = array("tag_name");
                $arrFields[] = array("username");
                $arrFields[] = array("username");
                
                $arrWhereFields[] = array("acm.curriculum_name");
                $arrWhereFields[] = array("lcm.category_name");
                $arrWhereFields[] = array("achm.chapter_name", "achm.chapter_desc", "achm.chapter_code");
                $arrWhereFields[] = array("atm.topic_name");
                $arrWhereFields[] = array("ard.title");
                $arrWhereFields[] = array("aqm.question_name");
                $arrWhereFields[] = array("ltm.tag_name");
                $arrWhereFields[] = array("lau.username");
                $arrWhereFields[] = array("alm.username");
                
                $arrHeadings[] = "Curriculums";
                $arrHeadings[] = "Subjects";
                $arrHeadings[] = "Chapters";
                $arrHeadings[] = "Topics";
                $arrHeadings[] = "Resources";
                $arrHeadings[] = "Questions";
                $arrHeadings[] = "Tags";
                $arrHeadings[] = "Editors";
                $arrHeadings[] = "Users";
                
                $arrNames[] = array("Curriculum Name");
                $arrNames[] = array("Category Name");
                $arrNames[] = array("Chapter Name");
                $arrNames[] = array("Topic Name");
                $arrNames[] = array("Topic", "Resources");
                $arrNames[] = array("Question");
                $arrNames[] = array("Tags");
                $arrNames[] = array("Editor Name");
                $arrNames[] = array("User Name");
                
                $arrAction[] = array("Edit");
                $arrAction[] = array("Edit");
                $arrAction[] = array("Edit");
                $arrAction[] = array("Edit");
                $arrAction[] = array("Edit", "Questions");
                $arrAction[] = array("Edit");
                $arrAction[] = array("Edit");
                $arrAction[] = array("Edit");
                $arrAction[] = array("Edit");
                
                $arrURLs[] = array("edit-curriculum.php?cid=['unique_id']");
                $arrURLs[] = array("edit-category.php?cid=['unique_id']");
                $arrURLs[] = array("edit-chapter.php?cid=['unique_id']");
                $arrURLs[] = array("edit-topic.php?cid=['unique_id']");
                $arrURLs[] = array("edit-resource.php?cid=['unique_id']", "");
                $arrURLs[] = array("edit-spot-test.php?cid=['unique_id']");
                $arrURLs[] = array("add-tag.php?cid=['unique_id']");
                $arrURLs[] = array("edit-editor.php?cid=['unique_id']");
                $arrURLs[] = array("edit-user.php?cid=['unique_id']");
                break;
        }
        for($d = 0; $d < count($arrTables); $d++){
            $where = "";
            for($w = 0; $w < count($arrWhereFields[$d]); $w++)
                $where .= $where == "" ? $arrWhereFields[$d][$w] . " LIKE '%". $_POST["txtsearch"] . "%'" : " OR " .$arrWhereFields[$d][$w] . " LIKE '%".$_POST["txtsearch"]."%'";
                
            $sql = "SELECT * FROM " . $arrTables[$d] . " WHERE (" .  $where . ")";
            $r = $db->query("query",$sql);
            if(!isset($r["response"])){
                if(count($r) > 0){
                    $resp = 1;
                    
                    if(!isset($r['response'])){
                        $html .= "<h3 style='text-align:left;color:#A74242;margin:15px 0px 2px 0px;'>" . $arrHeadings[$d] . " (" . count($r) . ")</h3>";
                        $html .= "<table border='0' cellpadding='3' cellspacing='1' width='100%'>";
                        $html .="<tr style='background-color:#A74242;color:#ffffff;'>";
                        //$html .= "<td><b>S.No.</b></td>";
                        $flds = $arrNames[$d];
                        for($f = 0; $f < count($flds); $f++)
                        $html .="<td><b>$flds[$f]</b></td>";
                        $html .= "<td>&nbsp;</td>";
                        $html .="</tr>";
                        
                        $srno = 0 ;
                        for($i=0; $i< count($r); $i++)
                        {
                            $srno++;
                            if($i % 2 == 0)
                                $class = "lightyellow";
                            else
                                $class = "darkyellow";
                            $html .="<tr class=".$class.">";
                            //$html .="<td>$srno</td>";
                            $vals = $arrFields[$d];
                            for($v = 0; $v < count($vals); $v++)
                            $html .="<td>". $r[$i][$vals[$v]] . "</td>";
                            $acts = $arrAction[$d];
                            $html .="<td>";
                            for($a = 0; $a < count($acts); $a++)
                            $html .="<a href='./" . $arrURLs[$d][$a] . "'>". $acts[$a] . "</a>";
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