<?php 

function createAccount($connection,$email,$password,$firstname,$lastname){
	if(!empty($email) && !empty($password)){
		$pLen = strlen($password);
		$email = $connection->real_escape_string($email);
		
		$sql= "SELECT EMAIL FROM USERS WHERE EMAIL = '" . $email. "' LIMIT 1";
		$query = $connection->query($sql);
		
		if(!preg_match("/[\w\-]+\@[\w\-]+\.[\w\-]+/",$email)) {
			$_SESSION['error'] = " Invalid Email Format";
		}elseif ($pLen < PASSWORDLIMIT) {
			$_SESSION['error'] = "Passwords must be longer than ". PASSWORDLIMIT ." characters.";
		}elseif ($query->num_rows == 1) {
			$_SESSION['error'] = "The email address is already registered.";
		
			}else{
			$genCode = generateActivationCode();
			sendMail($email, $genCode);
			$sql="INSERT INTO users (`UID`,`EMAIL`,`PASSWORD`,`FIRSTNAME`,`LASTNAME`,`PRIVILEGE`,`ACTIVATED`,`ACTIVATION_CODE`) VALUES ( NULL,'" . $email . "', '" . hashPassword($password) . "','".$firstname."','".$lastname."','Staff','FALSE','".$genCode."')";
			$query = $connection->query($sql);
			return $query;
}
		  
	}
	return false;
}

function loggedIn() {
	if (isset($_SESSION['loggedIn']) && isset($_SESSION['uid'])) {
		return true;
	}
	return false;
}

function hashPassword($password) {
	return sha1(md5($password . SALT1 . SALT2));
}

function logOut(){
	unset($_SESSION['uid']);
	unset($_SESSION['loggedIn']);
	return true;
}

function validateUser($connection,$email,$password){
	$sql = "SELECT UID FROM USERS WHERE email = '" . $connection->real_escape_string($email) . "' AND PASSWORD = '" . hashPassword($password) . "' LIMIT 1";
	$query = $connection->query($sql);
	if($query->num_rows == 1){
		$row = $query->fetch_assoc();
		$_SESSION['uid'] = $row['UID'];
		$_SESSION['loggedIn'] = true;
		return true;
	}
	return false;
}

function generateActivationCode(){

	$code = "";
	$charList = "0123456789";
	$charLimit = 5;

	$count = strlen($charList);
	while ($charLimit--) {
			$code .= $charList[mt_rand(0, $count-1)];
	}
	return $code;
}

function retrieveActivationCode($connection,$uid){

	$sql=  "SELECT * FROM USERS WHERE UID = ". $uid .";";
	$query = $connection->query($sql);
	$count = $query->num_rows;
	
	if($count == 1 ){
		$row = $query->fetch_assoc();
		return $row['ACTIVATION_CODE'];
	}
	return false;
}

function validateActivationCode($connection,$uid,$activationCode,$insertedCode){
	
	if($insertedCode == $activationCode){
		$sql=  "UPDATE USERS SET `ACTIVATED` = TRUE WHERE `UID` = '". $uid ."';";
		$query = $connection->query($sql);
		return $query;
		}
	return false;			
}
?>

