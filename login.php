
<?php
require_once("includes/config.php");


$username=$password="";
$usernameErr=$passwordErr="";

// let soo know that this might be handy to have.
// Also that he should be refactoring all his php scripts to be at the very
//top of the file before the html
if(loggedIn()){
	header_remove("location");
	header("Location: dashboard.php");
}

if(isset($_GET['action'])){
	switch (strtolower($_GET['action'])) {
		case 'login':
			if(empty($_POST['username'])){
				$usernameErr = 'Username is required';
			}	
			if(empty($_POST['password'])){
				$passwordErr = 'Password is required';
			}
			if($usernameErr == $passwordErr){
				$username = formData_process($_POST['username']);
				$password = formData_process($_POST['password']);
				if(validateUser($connection, $username,$password)){
					
					header_remove("location");
					header('Location: dashboard.php');
		
				}
			else{
				$_SESSION['error'] = "Invalid Username/ Password";
			}	
				unset($_GET['action']);
			}
			break;
			
			$_SESSION['error'] .=htmlspecialchars($_SERVER["PHP_SELF"]) . "?action='login'";
	  }
}

?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="css/index.css" />
</head> 
<body>
<div id="index-body">
<div id = "loginForm">
<h3>Login</h3>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'] . "?action=login";?>"> 
   Email: <input type="text" name="username" value="<?php echo $username;?>">
   <span class="error">* <?php echo $usernameErr;?></span>
   <br><br>
   
   Password: <input type="password" name="password" value="">
   <span class="error">* <?php echo $passwordErr;?></span>
   <br><br>
   
   <input type="submit" name="submit" value="Login"> 
   <br><br>
   <span class="error"><?php echo $_SESSION['error'];?></span>
</form>
</div>
 New? register an account <a href = "register.php" >register</a>
</div>
</body>
</html>


