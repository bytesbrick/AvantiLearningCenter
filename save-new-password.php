<?php
    include_once("./includes/config.php");  
	include("./classes/cor.mysql.class.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();

    $resp = "0";
    $uid = "";
    $webRoot = "http://beta.peerlearning.com";
    $uid = $_POST["uid"];
    $token = $_POST["tkn"];
    $pwd = "";
    if(isset($_POST["txtNPassword"]))
		$pwd = trim($_POST["txtNPassword"]);
		
    $cpwd = "";
    if(isset($_POST["txtNCPassword"]))
		$cpwd = trim($_POST["txtNCPassword"]);
    if($uid != "" && $token != "" && ($pwd == $cpwd)){
       $r = $db->query("query","SELECT userid FROM avn_login_master WHERE userid = '" . $uid . "' AND token = '" . $token . "' AND entrydate >= DATE_ADD(Now(), INTERVAL '-120' MINUTE)");
	   if($r['response'] != "ERROR"){
		   $dataToUpdate['password'] = "AES_ENCRYPT('" . $pwd . "', '" . ENCKEY . "')";
		   $dataToWhere['userid'] = $uid;
		   $s = $db->update("avn_login_master", $dataToUpdate, $dataToWhere);
           $resp = "1";
        }
    }
    
    $url = $webRoot."/resetpassword/".$uid."/".$token;
    if($resp == "1")
        $url .= "/?r=s";
    else
        $url .= "/?r=e";
    header('Location: ' .$url);
?>