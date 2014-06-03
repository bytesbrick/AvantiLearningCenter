<?php
     include_once("./includes/config.php");  
     include("./classes/cor.mysql.class.php");
     include_once("./includes/checklogin.php");
     $db = new MySqlConnection(CONNSTRING);
     $db->open();
     $fURL = "";
     $userType = $arrUserInfo["user_type"];
     if($arrUserInfo["user_type"] == "Manager" || $arrUserInfo["user_type"] == "Teacher"){
         $fURL = __WEBROOT__ . "/batches/";
     }
     elseif($arrUserInfo["user_type"] == "Student"){
         $fURL = __WEBROOT__ . "/lesson-plan/";
     } 
     $url = $fURL;
     header('Location: ' . $url);
?>