<?php
	session_start();
	$projpath= "";
	$result = 0;
	if(isset($_POST["btnSave"]) && $_POST["btnSave"] != "")
	{
            include("./includes/config.php");		
            include("./classes/cor.mysql.class.php");
            $db = new MySqlConnection(CONNSTRING);
            $db->open();		
            $datatosave = array();
	    $datatowhere = array();
	    $datatowhere["unique_id"] = $_POST['hdnbatchid'];
            $datatosave["batch_name"] = $_POST['txtbatchname'];
            $datatosave["batch_id"] = strtoupper($_POST['txtbatchid']);
            $datatosave["facilitator_id"] = $_POST['ddlfacilitator'];
	    $datatosave["curriculum_id"] = $_POST['ddlcurriculum'];
            $datatosave["city_id"] = $_POST['ddlcity'];
            $datatosave["strength"] = $_POST['txtstrength'];
            $datatosave["learning_center"] = $_POST['ddlcenter'];
            $datatosave["entry_date"] = "NOW()";
            $r = $db->update("avn_batch_master",$datatosave, $datatowhere);
            if($r["response"] != "ERROR"){
                $rURL ="./batch.php";
                $_SESSION["resp"] = "up";
            }
            $db->close();
	}
	else{
            $rURL = './batch.php';
            $_SESSION["resp"] = "invp";
	}
	unset($r);
	header('Location: ' . $rURL);
?>