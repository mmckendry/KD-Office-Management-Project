<?php
include "includes/class.phpmailer.php";  
$mail = new PHPMailer(); 
$mail->IsSMTP(); 
$mail->SMTPDebug = 1;
$mail->SMTPAuth = true; 

$mail->SMTPSecure = "tls";

$mail->Host = "smtp.live.com"; 

$mail->Port = 587;
$mail->IsHTML(true);
$mail->Username = "martinmckendry@live.ie";
$mail->Password = "xxxxxxxxxxx"; // replace with own password
$mail->SetFrom("martinmckendry93@gmail.com");
$mail->Subject = "Your live SMTP Mail";
$mail->Body = "Your activation code is: 58232";
$mail->AddAddress("martinmckendry@live.ie");
 if(!$mail->Send()){
	echo "testing";
	
}
else{
	echo "Message has been sent";
}
?>