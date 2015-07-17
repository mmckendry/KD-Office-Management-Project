<?php
require_once 'includes/config.php';


$username=$password=$firstname=$lastname=$usernameErr=$passwordErr="";
   
if(isset($_GET['action'])){
	switch (strtolower($_GET['action'])) {
		
		case "register":
			if(empty($_POST['username'])){
			
				$usernameErr = 'username is required';
			}
			if(empty($_POST['password'])){
		
				$passwordErr = 'Password is required';
			}
			
			$username = formData_process($_POST['username']);
			$password = formData_process($_POST['password']);
			$firstname = formData_process($_POST['firstname']);
			$lastname = formData_process($_POST['lastname']);
			
			if($usernameErr == $passwordErr){
				if(createAccount($connection, $username, $password, $firstname, $lastname)){
					validateUser($connection, $username,$password, $firstname, $lastname);
					redirect("activateAccount.php");		
					
				}
			}
			break;
	}
	
}


?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="css/index.css" />
</head> 
<body>

<div id = "registerForm">
<h2>Register</h2>

<div id="register">
<form method="post" action="<?php echo $_SERVER['PHP_SELF'] . "?action=register";?>"> 
   
   Name: <input type="text" name="username" value="<?php echo $username;?>">
   <span class="error">* <?php echo $usernameErr;?></span>
   <br><br>
   
   Password: <input type="password" name="password" value="<?php echo $password;?>">
   <span class="error">* <?php echo $passwordErr;?></span>
   <br><br>
   
   First Name: <input type="text" name="firstname" value="<?php echo $firstname;?>">
   <span class="error">* <?php echo $passwordErr;?></span> 
   <br><br>
   
   Last Name: <input type="text" name="lastname" value="<?php echo $lastname;?>"> 
   <span class="error">* <?php echo $passwordErr;?></span> <br><br>
   
   <input type="submit" name="submit" value="Register" "> 
   <br><br>
   <span class="error"><?php echo $_SESSION['error'];?></span>
</form>
</div>
</div>

Back to <a href = "dashboard.php">home</a>

</body>
</html>