<link rel="stylesheet" type="text/css" href="./css/style.css?v=<?php echo mktime(); ?>"/>
<link rel="stylesheet" type="text/css" href="./css/general.css?v=<?php echo mktime(); ?>"/>
<!-- <link rel="shortcut icon" href="./favicon.png" type="image/x-icon" /> -->
<script type="text/javascript" language="javascript" src="./javascript/_bb_general_v3.js?v=<?php echo mktime(); ?>"></script>
<script type="text/javascript" language="javascript" src="./javascript/_bb_elmpos.js"></script>
<script type="text/javascript" language="javascript" src="./javascript/_bb_disablepage.js"></script>
<script type="text/javascript" language="javascript" src="./javascript/_cmh_chkPassword.js"></script>
<script type="text/javascript" language="javascript" src="./javascript/ajax.js"></script>
<script type="text/javascript" language="javascript" src="./javascript/resourseData.js?v=<?php echo mktime(); ?>"></script>
<script type="text/javascript" language="javascript" src="./javascript/resourseAjax.js?v=<?php echo mktime(); ?>"></script>
<script type="text/javascript" language="javascript" src="./javascript/formValidate.js?v=<?php echo mktime(); ?>"></script>
<script type="text/javascript" language="javascript" src="./javascript/ajax-chapters.js?v=<?php echo mktime(); ?>"></script>
<script type="text/javascript" language="javascript" src="./javascript/editor.js?v=<?php echo mktime(); ?>"></script>
<?php
    function filter_querystring($query_string, $arrFields, $arrValues){
        if($query_string != ""){
            $qString = "";
            if(count($arrFields) > 0 && count($arrFields) == count($arrValues)){
                $qsParams = explode("&", $query_string);
                for($f = 0; $f < count($arrFields); $f++){
                    $iF = -1;
                    for($q = 0; $q < count($qsParams); $q++){
                        $qsParam = explode("=", $qsParams[$q]);
                        if($qsParam[0] == $arrFields[$f]){
                            $qsParams[$q] = str_ireplace("=" . $qsParam[1], "=" . $arrValues[$f], $qsParams[$q]);
                            $iF = $f;
                            break;
                        }
                    }
                    if($iF == -1 && $arrValues[$f] != "")
                    $qString .= $qString == "" ? $arrFields[$f] . "=" . $arrValues[$f] : "&" . $arrFields[$f] . "=" . $arrValues[$f];
                }
                for($q = 0; $q < count($qsParams); $q++){
                    $qsParam = explode("=", $qsParams[$q]);
                    if($qsParam[0] != "" && $qsParam[1] != "") 
                       $qString .= $qString == "" ? $qsParam[0] . "=" . $qsParam[1] : "&" . $qsParam[0] . "=" . $qsParam[1];
                }
            } else {
                $qString = $query_string;
            }
        } else {
            $qString = "";
            if(count($arrFields) > 0 && count($arrFields) == count($arrValues)){
                for($f = 0; $f < count($arrFields); $f++){
                    if($arrValues[$f] != "")
                    $qString .= $qString == "" ? $arrFields[$f] . "=" . $arrValues[$f] : "&" . $arrFields[$f] . "=" . $arrValues[$f];
                }
            }
        }
        if($qString != "")
            $qString ="?" . $qString;
        return $qString;
    }
?>