<?php
require_once 'includes/config.php';

if(loggedIn()){
	redirect("dashboard.php");
}
else{
	redirect("login.php");
}
?>


