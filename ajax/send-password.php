<?php
   $resp = 0;
   if(isset($_POST['txtforgetemailid'])){
      include("../includes/config.php");		
      include("../classes/cor.mysql.class.php"); 
      $db = new MysqlConnection(CONNSTRING);
      $db->open();

      $timezone = "Asia/Kolkata";
      date_default_timezone_set($timezone);
      function randomString($inputString = '', $length = 5){
	 $randomString = '';
	 if($inputString == '')
	    $inputString = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	 for($i = 0; $i < $length; $i++)
	    $randomString .= $inputString[rand(0, strlen($inputString) - 1)];
	 return $randomString;
      }
      $txtforgetemailid = $_POST['txtforgetemailid'];
      $r = $db->query("query","select userid, emailid,password as apassword from avn_login_master where emailid ='".$txtforgetemailid."'");
      
      if(!isset($r['response'])){
	      $uid['userid'] = $r[0]['userid'];
	      $uid['token'] = randomString('', 20);
	      $uid['entrydate'] = "now()";
	      $emailid['emailid'] = $txtforgetemailid;
	      $s = $db->update("avn_login_master", $uid,$emailid);
	      
	       if($s['count'] ==1){
		     $from = "admin@avanti.com";
		     $to = "" . $r[0]['emailid'] . "";
		     $subject = "Reset Your Password";
		     $mailbody = '<table border="0" width="400px" cellspacing="0" cellpadding="0" align="center">
				       <tr>
					  <td align="center" style="border:solid 3px #cecece">
					  <table border="0" width="700px" cellspacing="0" cellpadding="0" align="center">
					     <tr>
						<td align="left" style="color:#A95F5F;font-family:Georgia;font-size:14px;padding:10px;">Dear Student/Teacher,<br/><br/>
						   You have requested for your password retrieval.In order to reset your password please copy and paste the following URL in your browser.<br/><br/>
							
							 http://beta.peerlearning.com/resetpassword/'. $uid['userid'] . '/' . $uid['token'] . '/<br/><br/>
							 Incase of any trouble, get in touch with <i>info@avantifellows.org/+91-XXXXXXXXXXX</i><br /><br />
							 Sincerely,<br/>
							 Avanti Learning Centre Team<br/>
							 http://www.peerlearning.com<br/>								
							       
							 Note: For security reasons,the URL given above is valid for one time only. <br /><br /><br />
						       
						</td>
					     </tr>
					  </table>
					  </td>
				       </tr>
			       </table>';
		     $headers ='From:Avanti <admin@avanti.com>'. "\r\n";
		     $headers .= "MIME-Version: 1.0\r\n";
		     $headers .= "Reply-To:avanti <admin@avanti.com>" ."\r\n";
		     $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		     mail($to, $subject, $mailbody, $headers);
		     $resp =1;
	       }
      }else
	      $resp = 0;
   }
   echo $resp;
?>