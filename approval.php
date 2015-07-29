<?php

include 'includes/config.php';

	
	$sql = "SELECT RID FROM REQUESTS WHERE PENDING = TRUE";
	$query = $connection->query($sql);
	$row = $query->fetch_assoc();
	$rid = $row['RID'];

	$action = $_GET['action'];
	
	
	receiveApproval($connection, $action, $rid);
	



?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="css/index.css" />
</head>
<body>
view <a href ="calendar.php">calendar</a>
<br><br>
back to <a href = "dashboard.php">home</a>
</body>
</html>