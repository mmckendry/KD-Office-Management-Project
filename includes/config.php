<?php
session_start();

global $connection;

//database variables
//define("ROOT", "Project");

define("HOST", "localhost");
define("USER", "root");
define("PASSWORD", "");
define("DATABASE", "login"); //This 'login' is the name of the database. Change to your own database.

define('SALT1', '24859f@#$#@$');
define('SALT2', '^&@#_-=+Afda$#%');
define('PASSWORDLIMIT',6);

// require the function file
require_once("user_system.php");
require_once("dashboard_system.php");
require_once("email.php");
require_once("utility.php");
require_once("phpMailer/class.phpmailer.php");

$connection = new mysqli(HOST, USER, PASSWORD, DATABASE);

// default the error variable
$_SESSION["error"] = "";

?>