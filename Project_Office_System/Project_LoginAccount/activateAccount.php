<?php
require_once "includes/config.php";

$insertedCode = "";
$codeErr = "";

$sql = "SELECT email FROM users WHERE UID = ".$_SESSION['uid'].";"; 
$query = $connection->query($sql);
$row = $query->fetch_assoc();
$email = $row['email'];


echo $_SESSION['uid'] . " "; //changed from email
echo $email;
$uid = $_SESSION['uid'];
			
if(isset($_GET['action'])){
	switch(strtolower($_GET['action'])){
		case "activate":		
			if(empty($_POST['activateCode'])){
				$codeErr = "the field is empty";
			}
			if($codeErr == ""){
			$insertedCode = formData_process($_POST['activateCode']);
			$activationCode = retrieveActivationCode($connection, $uid);
			validateActivationCode($connection, $uid, $activationCode, $insertedCode);
				redirect("dashboard.php");
			}
			
		break;
		case "reg":
			if(!empty($_POST['requestCode'])){
				
				$sql = "SELECT ACTIVATION_CODE FROM users WHERE UID = ".$_SESSION['uid'].";"; 
				$query = $connection->query($sql);
				$row = $query->fetch_assoc();
				$genCode = $row['ACTIVATION_CODE'];
				sendMail($email, $genCode);
				echo "The code has been resent.";
			}
				
		break;
	}
}

?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="css/index.css" /></head>
<body>
<div id = "activate">
<form method = "post" action = <?php echo $_SERVER['PHP_SELF'] . "?action=activate";?>>
Please enter the activation code<input type = "text" name = "activateCode" value = "" />
<span class="error">* <?php echo $codeErr;?> </span>(Sent to your email address)<br>
<input type = "submit" name = "submit" value = "Accept"/>
</form>
</div>
<div id = "reg">
<form method = "post" action  = <?php echo $_SERVER['PHP_SELF'] . "?action=reg";?>>
<input type = "submit" name = "requestCode" value = "re-request code"/>
</div>
click <a href = "login.php">here</a> to return home.
</body>
</html>

