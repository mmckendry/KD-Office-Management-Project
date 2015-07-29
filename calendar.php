<?php
include 'includes/config.php';

global $data;
global $start_date;

if(!isset($_POST['start_date'])){
	$start_date=date("d-m-y");
}

if(isset($_GET['action'])){
	if($_GET['action']=="submit"){
		
		$start_date = $_POST['start_date'];
		
	}
}

getPendingRequests($connection);

?>

<html>

<head>
<link rel="stylesheet" type="text/css" href="css/index.css" />
</head>
<body>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?action=submit'?>">
<input type="date" name="start_date" value="<?php echo date("d-m-y");?>">
<br>
<br>
<input type="submit">
</form>
<div id="calendar">
<?php echo generateCalendar($connection, $start_date);?>
</div>
back <a href = "dashboard.php">home</a>
</body>
</html>