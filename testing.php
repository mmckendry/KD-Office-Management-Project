<?php
require_once "includes/functions.php";
require_once "includes/config.php";

echo "storeCode ";
$CODE = storeCode();
var_dump($CODE);
echo "<br>" . $GLOBALS['aCode'];
echo "<br>";
echo " retrieve code: ";
$code = "58232";
$genCode = "87733";
//echo retrieveCode($CODE, $code);
$sql=  "SELECT * FROM `users` WHERE aCode = '".$genCode."';";
	$query = mysqli_query($GLOBALS['connection'], $sql);
	
	$count = mysqli_num_rows($query);
	if($count >= 1 ){
		$row = $query->fetch_assoc();
		$GLOBALS['string'] = $row['aCode'];
	
		echo "<br><br>this should be the code " . $GLOBALS['string'] . ".";
	
		}


?>
<html>
<head></head>
<body>

<p>This is only a test script</p>

</body>
</html>

