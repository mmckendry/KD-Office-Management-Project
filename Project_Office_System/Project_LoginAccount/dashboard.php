<?php
include 'includes/config.php';


//scopedInclude('common_script.php', array("includerFile" => __FILE__));


if(!loggedIn()){
	header_remove("location");
	header('Location: index.php');
	
}
if(isset($_GET['action'])){
	logOut();
	header_remove("location");
	header('Location: index.php');
$query;
$sql = 'SELECT * FROM `users` ORDER BY `email` DESC LIMIT 1';
	$query = $GLOBALS['connection']->query($sql);	
}

echo $_SESSION['uid'];



?>
<html>
<header>
<link rel="stylesheet" type="text/css" href="css/index.css">
</header>
<body>
<div id="container"
<div id="banner">
	<h2>Dashboard</h2>
</div>
<div id="info">
	<h3>This will be some information</h3>
</div>

<div id="allowance">
	<h4>My Leave Allowance</h4>
</div>

<div id="request_form">
	<h4>Submit Leave Request</h4>
</div>
<div id="calendar">
	<h4>Next 7 days</h4>
</div>

<form method="post">
	<input type="submit" name="submit" value="Request" formaction="request.php"> 
	<input type="submit" name="submit" value="Calendar" formaction="calendar.php">
	<input type="submit" name="submit" value="Log Out" formaction="<?php echo $_SERVER['PHP_SELF'] . "?action=logout";?>">
	
	
</form>
</div>
</div>
</body>
</html>