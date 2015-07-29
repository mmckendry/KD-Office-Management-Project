	<?php 
	
	function sendMail($Email, $genCode){
	
$port = 0;
$security = "";
$webHost = "";

$parts = explode('@', $Email);
$suffix = "@" . $parts[1];
echo $suffix;

	switch($suffix){
	case "@live.ie":
		$port = 587;
		$security = "tls";
		$webHost = "smtp.live.com";
		
	break;
	case "@gmail.com":
		$port = 465;
		$security = "ssl";
		$webHost = "smtp.gmail.com";
	break;
	
	default:
		echo "unable to detect sever";
	break;

	}
	
	$mail = new PHPMailer(); 
	$mail->IsSMTP(); 
	$mail->SMTPDebug = 1;
	$mail->SMTPAuth = true; 

	$mail->SMTPSecure = $security;

	$mail->Host = $webHost; 

	$mail->Port = $port;
	$mail->IsHTML(true);
	$mail->Username = "martinmckendry93@gmail.com";//who its from
	$mail->Password = "XXXXXXXXX"; // replace with own password
	$mail->SetFrom("no-reply@KongDigital.com");
	$mail->Subject = "Your activation code";
	$mail->Body = "Your activation code is: " . $genCode . ".";
	$mail->AddAddress($Email);
	 if(!$mail->Send()){
		echo "testing";
		
	}
	else{
		echo "Message has been sent<br>";
	}
	}
	?>