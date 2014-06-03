<?php
	include("./includes/config.php");	
	setcookie('userInfo', '', time()-60, "/");
	header('Location: ' . __WEBROOT__ . '/?resp=O');
?>