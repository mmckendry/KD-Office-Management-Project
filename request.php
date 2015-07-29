<?php

include 'includes/config.php';
if(isset($_GET['action'])){
	if($_GET['action']=="submit"){
		$_SESSION['username']="2";
		$data=array("uid"=>$_SESSION['username'],"start_date"=>$_POST['start_date'],"end_date"=>$_POST['end_date'],"info"=>$_POST['info']);
		echo $_POST['end_date'];
		insertRequest($connection, $data);
		echo $GLOBALS['connection']->insert_id;
		importToCalendar($connection, $GLOBALS['connection']->insert_id);

	}
}
echo "Today's date is:  " . date("d/m/y");

?>

<html>

<head>
<link rel="stylesheet" type="text/css" href="css/index.css" />
</head>
<body>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?action=submit'?>">
<input type="date" name="start_date" value="<?php echo date("Y-m-d");?>">
<input type="date" name="end_date" value="<?php echo date("Y-m-d");?>">
<br>
<br>
<textarea name="info" rows="4" cols="50">
</textarea>
<br>
<input type="submit">
</form>
back to <a href = "dashboard.php">home</a>
</body>
</html>