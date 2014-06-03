<?php
	$userType = $_COOKIE['cUserType'];
	if($userType == ""){
		header('Location: ./index.php');
	}
	else
	{
		if($userType == 4)
			header('Location: ./dashboard.php');
	}
?>