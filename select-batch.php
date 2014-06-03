<?php
    include_once("./includes/config.php");  
    include("./classes/cor.mysql.class.php");
    include_once("./includes/checklogin.php");
?>
<!DOCTYPE HTML>
<html xml:lang="en" lang="en" itemscope="" itemtype="http://schema.org">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Avanti Learning Centres | Select Batch</title>
<?php
    $db = new MySqlConnection(CONNSTRING);
    $db->open();
    include_once("./includes/header-meta.php");
    
?>
<script type="text/javascript" src="<?php echo __WEBROOT__;?>/js/select-batch.js"></script>
</head>
<body style="background: #fff;">
    <div class="mainbody">
	<div style="float: left;width:100%;background: #BD2728;">
	    <div style="margin: 0 auto;width:975px;">
		<?php include_once("./includes/header.php");?>
	    </div>
	</div>
	<div class="clb"></div>
        <div class="center">
            <div class="whole mid">
                <form id="formbatch" id="formbatch" method="post" action="<?php echo __WEBROOT__; ?>/save-batch.php" onsubmit="javascript: return _selectbatch();">
                    <table cellpadding="0" cellspacing="0" border="0" width="50%">
			<tr>
			    <td colspan="2" style="height: 18px;"><span id="errormsg"></span></td>
			</tr>
			<?php
			    if($arrUserInfo["user_type"] == "Teacher"){
				$Tuid = "SELECT unique_id,city_id FROM avn_teacher_master WHERE teacher_id = '" .  $arrUserInfo["teacher_id"] ."'";
				$TuidRS = $db->query("query", $Tuid);
				$uid = $TuidRS[0]["unique_id"];
				$TeacherCity = $TuidRS[0]["city_id"];
				unset($MuidRS);
				
				$SelTeacherBatch = "SELECT bm.batch_name,bm.unique_id FROM avn_learningcenter_master acm INNER JOIN avn_teacher_batch_mapping atbm ON atbm.center_id = acm.unique_id INNER JOIN avn_batch_master bm ON bm.learning_center = atbm.center_id WHERE atbm.teacher_id = " . $uid;
				$SelTeacherBatchRS = $db->query("query",$SelTeacherBatch);
			?>
			     <tr>
				<td>Select Batch</td>
				<td>
				    <select id="ddlbatch" name="ddlbatch"  style="width: 160px;padding: 5px;">
					<option>Select One</option>
					<?php
					    if(!array_key_exists("response", $SelTeacherBatchRS)){
						for($i = 0; $i < count($SelTeacherBatchRS); $i++){
					?>
						    <option value="<?php echo $SelTeacherBatchRS[$i]["unique_id"]; ?>"><?php echo $SelTeacherBatchRS[$i]["batch_name"]; ?></option>
					<?php
						}
					    }
					?>
				    </select>
				</td>
			    </tr>
			     <tr>
				<td style="height: 20px;" colspan="2"></td>
			     </tr>
			<?php
			    }else{			
				$Muid = "SELECT unique_id,city_id FROM avn_centermanager_master WHERE center_manager_id = '" .  $arrUserInfo["manager_id"] ."'";
				$MuidRS = $db->query("query", $Muid);
				$uid = $MuidRS[0]["unique_id"];
				$managerCity = $MuidRS[0]["city_id"];
				unset($MuidRS);
				
				$SelmanagerBatch = "SELECT acm.unique_id,acm.center_name,acm.center_code FROM avn_learningcenter_master acm INNER JOIN avn_manager_center_mapping amcm ON  acm.unique_id = amcm.center_id WHERE acm.city_id = " . $managerCity . " AND amcm.manager_id = " . $uid;
				$SelmanagerBatchRS = $db->query("query",$SelmanagerBatch);
			    ?>
			    <tr>
				<td>Select Center</td>
				<td>
				    <select id="ddlcenter" name="ddlcenter" onchange="javascript: _getcenter(this.value);"  style="width: 160px;padding: 5px;">
					<option>Select One</option>
					<?php
					    if(!array_key_exists("response", $SelmanagerBatchRS)){
						for($i = 0; $i < count($SelmanagerBatchRS); $i++){
					?>
						    <option value="<?php echo $SelmanagerBatchRS[$i]["unique_id"]; ?>"><?php echo $SelmanagerBatchRS[$i]["center_name"]; ?></option>
					<?php
						}
					    }
					?>
				    </select>
				</td>
			    </tr>
			    <tr>
				<td style="height: 20px;" colspan="2"></td>
			    </tr>
			    <tr>
				<td>Select Batch</td>
				<td>
				    <select id="ddlbatch" name="ddlbatch" style="width: 160px;padding: 5px;">
					<option>Select One</option>
				    </select>
				</td>
			    </tr>
			    <tr>
				<td style="height: 20px;" colspan="2"></td>
			     </tr>
			<?php
			    }
			?>
                        <tr>
                            <td colspan="2"><input type="submit" name="btnsubmit" id="btnsubmit" value="Submit" class="cursor"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <?php
	    unset($SelmanagerBatchRS);
	    include_once("./includes/footer.php");
            $db->close();
	?>
    </div>
</body>
</html>