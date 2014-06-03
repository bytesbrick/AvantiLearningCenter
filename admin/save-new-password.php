<?php
    include_once("./includes/config.php");  
	include("./classes/cor.mysql.class.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();

    $resp = "0";
    $uid = "";

    $uid = $_POST["uid"];
    //echo $uid;
    $token = $_POST["tkn"];
    //echo $token;
    $pwd = "";
    if(isset($_POST["txtNPassword"]))
		$pwd = trim($_POST["txtNPassword"]);
		
    $cpwd = "";
    if(isset($_POST["txtNCPassword"]))
		$cpwd = trim($_POST["txtNCPassword"]);
    if($uid != "" && $token != "" && ($pwd == $cpwd)){
       $r = $db->query("query","SELECT userid FROM ltf_admin_usermaster WHERE userid = '" . $uid . "' AND token = '" . $token . "' AND entrydate >= DATE_ADD(Now(), INTERVAL '-120' MINUTE)");
       
	   if($r['response'] != "ERROR"){
		   $dataToUpdate['password'] = $pwd;
		   $dataToWhere['userid'] = $uid;
		   $s = $db->update("ltf_admin_usermaster", $dataToUpdate, $dataToWhere);
		   
           $resp = "1";
        }
    }
    
    $url = "resetpassword.php?ud=".$uid."&tk=".$token;
    if($resp == "1")
        $url .= "&r=s";
    else
        $url .= "&r=e";
	$db->close();
    header('Location: ' .$url);
?>