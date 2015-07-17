<?php
#This is the functions page
include_once '/config.php';
require "includes/phpMailer/class.phpmailer.php";

function createAccount($Email, $password){
	
	if(!empty($Email) && !empty($password)){
	
		$pLen = strlen($password);
		
		$Email = $GLOBALS['connection']->real_escape_string($Email);
		$sql= "SELECT email FROM users WHERE email = '" . $Email. "' LIMIT 1";
	
		$query = $GLOBALS['connection']->query($sql);
	
	
		if ($pLen < 3) {
			$_SESSION['error'] = "Passwords must be longer then 6 characters.";
		}elseif ($query->num_rows == 1) {
			$_SESSION['error'] = "Email/Username already exists.";
		}else{
			$genCode = generateActivationCode();
			
			$sql="INSERT INTO users (`email`,`password`, `aCode`) VALUES ('" . $Email . "', '" . hashPassword($password, $pSalt1="2345#$%@3e", $pSalt2="taesa%#@2%^#") . "', '" . $genCode ."');";
			$query = $GLOBALS['connection']->query($sql);
			//test
			sendMail($Email, $genCode);

			redirect("activateAccount.php");		
		}
		if ($query) {
			return true;
		}	  
	}
	return false;
}

function hashPassword($pPassword, $pSalt1="2345#$%@3e", $pSalt2="taesa%#@2%^#") {
	return sha1(md5($pSalt2 . $pPassword . $pSalt1));
}

function loggedIn() {
	// check both loggedin and email to verify user.
	if (isset($_SESSION['loggedin']) && isset($_SESSION['email'])) {
		return true;
	}
	
	return false;
}

function logoutUser() {
	// using unset will remove the variable
	// and thus logging off the user.
	unset($_SESSION['email']);
	unset($_SESSION['loggedin']);
	
	return true;
}

function validateUser($Email, $pPassword) {
	$sql = "SELECT email FROM users WHERE email = '" . mysqli_real_escape_string($GLOBALS['connection'], $Email) . "'AND password = '" . hashPassword($pPassword, SALT1, SALT2) . "';";
	
	$query = mysqli_query($GLOBALS['connection'], $sql);
	if(mysqli_connect_errno($query)){
		echo "The connection has failed" . mysqli_connect_error();
	}
		
	$count = mysqli_num_rows($query);
	// If one row was returned, the user was logged in!
		$_SESSION['email']=$sql;
		if($count == 1){
		
		$row = $query->fetch_assoc();
		$_SESSION['email'] = $row['email'];
		
		$_SESSION['loggedin'] = true;
		return true;
	}
	return false;

}

function sendMail($Email, $genCode){
$port = 0;
$security = "";
$webHost = "";
$suffix = "@gmail";


if(strpos($Email, $suffix)!= false){
	$port = 465;
	$security = "ssl";
	$webHost = "smtp.gmail.com";
	echo "The email address contains the suffix" . $suffix . "";

}

else{
	$port = 587;
	$security = "tls";
	$webHost = "smtp.live.com";
}
  
$mail = new PHPMailer(); 
$mail->IsSMTP(); 
$mail->SMTPDebug = 1;
$mail->SMTPAuth = true; 

$mail->SMTPSecure = $security;

$mail->Host = $webHost; 

$mail->Port = $port;
$mail->IsHTML(true);
$mail->Username = "martinmckendry@live.ie";
$mail->Password = "Lemonclock93"; // replace with own password
$mail->SetFrom("no-reply@smee-again.com");
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

function generateActivationCode(){

$string = "";
$charList = "0123456789";
$charLimit = 5;

$count = strlen($charList);
 while ($charLimit--) {
        $string .= $charList[mt_rand(0, $count-1)];
 }

return $string;
}
//this takes over the role of validate code
function retrieveCode($code){

	$sql=  "SELECT * FROM `users` WHERE aCode = '". $code ."';";
	$query = mysqli_query($GLOBALS['connection'], $sql);
	
	$count = mysqli_num_rows($query);
	if($count >= 1 ){
		$row = $query->fetch_assoc();
		$GLOBALS['string'] = $row['aCode'];

		return true;
}
return false;

	}


	






 
?>