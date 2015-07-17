<?php


//This is a simple gmail configuration for using smtp

include "includes/class.phpmailer.php"; 
$mail = new PHPMailer(); 
$mail->IsSMTP(); 
$mail->SMTPDebug = 1; 
$mail->SMTPAuth = true; 
$mail->SMTPSecure = 'ssl'; 
$mail->Host = "smtp.gmail.com";
$mail->Port = 465; 
$mail->IsHTML(true);
$mail->Username = "martinmckendry93@gmail.com"; // your the address you're sending to.
$mail->Password = "xxxxxxxxx"; // put in your own password
$mail->SetFrom("martinmckendry@live.ie");
$mail->Subject = "Your Gmail SMTP Mail";
$mail->Body = "¦¦¦¦¦¦¦¦¦¦¦¦_¦
¦¦¦¦¦¦___¦¦_¦¦_
¦¦¦¦¦¦¯¦¯¦¦¦¦¦¯¦_
¦¦¦¦¦¦¦_¦¦¦¦¦¦¦¦¯¦_
¦¦¦¦¦¦¯_¯¦¦¦_____¯¯
¦¦¦¦___¦¦¯¯¯¯
¦¦¦¦¯___¦¦¯¯
¦¦¦¦¦___¦¦¯¯¯
_¦¦¦¦¦__¦¦¦¯¯ U HAVE BEEN SPOOKED BY THE
¯¦¦¦¦¦_¦¯¦¯¦¯
¦¦¦¦¦¦¦__¦¦__
¦¦¦¦¦¦¦¯¦¦¦¯¦¦_
¦¦¦¦¦¦¦¦¯_¯_¯¦_SPOOKY SKILENTON
¦¦¦¦¦¦¦¯¦¦¦¦¦¦¦¦
¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦
¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦
¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦";
$mail->AddAddress("martinmckendry@live.ie");
 if(!$mail->Send()){
	echo "testing";
	
}
else{
	echo "Message has been sent";
}


?>
