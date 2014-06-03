<?php
	include("./includes/config.php");
	setcookie('userInfo', '', time()-60, "/");
	header('Location: ./index.php?resp=O');
?>