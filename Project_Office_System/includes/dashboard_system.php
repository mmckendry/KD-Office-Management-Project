<?php


function insertRequest($connection,$data){
	extract($data);
	$sql= "INSERT INTO REQUESTS (`RID`,`UID`,`START_DATE`,`END_DATE`,`INFO`,`APPROVAL`,`PENDING`) VALUES( NULL,'" . $uid. "','".$start_date."','". $end_date."','" . $info."', FALSE,TRUE);";
	$query = $connection->query($sql);
	return $query;
}

function generateLink($rid){
	$yesLink = $_SERVER['SERVER_NAME'] . "/KongDigitalProject/approval.php?rid=". $rid ."&action=approve";
	$noLink = $_SERVER['SERVER_NAME'] . "/KongDigitalProject/approval.php?rid=". $rid ."&action=disapprove";
	return array("yesLink"=>$yesLink,"noLink"=>$noLink);
}

function notifyAdminMail($link){
	extract($link);
	$body = "<a href='http://".$yesLink."'><button type='button'>YES</button></a><a href='http://".$noLink."'><button type='button'>NO</button></a> ";
	return $body;
}

function receiveApproval($connection,$action,$rid){
	if($action=="approve"){
		$result="TRUE";
	}else{
		$result="FALSE";
	}
	$sql="UPDATE REQUESTS SET APPROVAL=". $result ." WHERE RID='". $rid ."';"
		."UPDATE REQUESTS SET PENDING=FALSE WHERE RID='". $rid ."';";
		echo $sql;
	$query = $connection->multi_query($sql);
	return $query;
}

function importToCalendar($connection,$rid){
	$sql="SELECT * FROM REQUESTS WHERE RID='" .$rid."'";
	$query = $connection->query($sql);
	if(($query->num_rows)==1){
		$row= $query->fetch_assoc();
		$username = $row['UID'];
		$start_date = new DateTime($row['START_DATE']);
		$end_date= new DateTime($row['END_DATE']);
		$days= $start_date->diff($end_date)->days+1;
		for($i=0;$i<$days;$i++){	
			$date = $start_date->format('d/m/y');
			$sql = "INSERT INTO CALENDAR (`FIRSTNAME`,`LASTNAME`,`OFF_DATE`) VALUES ((SELECT FIRSTNAME FROM USERS WHERE UID = '". $row['UID']."'),(SELECT LASTNAME FROM USERS WHERE UID = '". $row['UID']."'),'".$date ."')";
			$query = $connection->query($sql);
			$start_date->modify("+1 day");
		}
		return true;
	}
	return false;
}

function generateCalendar($connection,$start_date){	
	$html="<table id='calendar' width='600'><tr>";
	$date= new DateTime($start_date);
	$date_range=array();

	for($col=0;$col<7;$col++){
		$date_range[$col]=$date->format("d/m/y");
		$date->modify("+1 day");
		$html .= "<th>".$date_range[$col]."</th>";
	}
	$html .="</tr><tr>";
	
	for($col=0;$col<7;$col++){
		$html.="<td>";
		$sql="SELECT * FROM CALENDAR WHERE OFF_DATE='". $date_range[$col]."'";
		$query = $connection->query($sql);
		while($row=$query->fetch_assoc()){
			$html .= $row['FIRSTNAME']." ". $row['LASTNAME']."<br>";
		}
		$html.="</td>";
	}
	$html .="</tr></table>";
	return $html;
}

function getPendingRequests($connection){
	
		$sql = "SELECT * FROM REQUESTS WHERE PENDING = TRUE; ";
		$query = $connection->query($sql);
		if($query->num_rows != 0){	//Checks for a pending request						
	echo "The query has been succesful <br>";		



		$row= $query->fetch_assoc();
		
		$info = $row['INFO'];
		$startDate = $row['START_DATE'];
		$endDate = $row['END_DATE'];
			
		$sql = "SELECT * FROM USERS WHERE UID = ". $row['UID'].";";
		$sRow = $row['UID'];
		$query = $connection->query($sql);
		$row = $query->fetch_assoc();
		$name = $row['FIRSTNAME']; 
		
		$sql = "SELECT LASTNAME FROM USERS WHERE UID = ".$sRow.";";
		$query = $connection->query($sql);
		$row = $query->fetch_assoc();
		$secondName = $row['LASTNAME'];
		

		$sql = "SELECT RID FROM REQUESTS WHERE PENDING = TRUE;";
		$query = $connection->query($sql);
		$row  = $query->fetch_assoc();
		$rid = $row['RID'];
		$link = generateLink($rid);
		$responseLink = notifyAdminMail($link);
		
		
		var_dump($info);
		var_dump($startDate);
		var_dump($endDate);
		$email = "martinmckendry@live.ie"; // this will be set as the admins email(manager)
		sendAdminMail($email, $info, $startDate, $endDate, $name, $secondName, $responseLink);
		
	}
	else{
	echo "There is no new requests pending <br>" . mysqli_connect_error();
}
	

}

function sendAdminMail($email, $info, $startDate, $endDate, $name, $secondName, $responseLink){
	$port = 0;
	$security = "";
	$webHost = "";
	$suffix = "";

	$port = 587;
	$security = "tls";
	$webHost = "smtp.live.com";
	
	$mail = new PHPMailer(); 
	$mail->IsSMTP(); 
	$mail->SMTPDebug = 1;
	$mail->SMTPAuth = true; 

	$mail->SMTPSecure = $security;

	$mail->Host = $webHost; 

	$mail->Port = $port;
	$mail->IsHTML(true);
	$mail->Username = "martinmckendry@live.ie";
	$mail->Password = "xxxxxxx"; // replace with own password
	$mail->SetFrom("no-reply@smee-again.com");
	$mail->Subject = "Request for time off";
	$mail->Body = "Time off has been requested by ". $name ." ". $secondName . ", for the following times: '" . $startDate . "' to the '" . $endDate . "'. <br><br>
	 The reason(s) for the request are as outlined: '" . $info . "'. <br><br> To approve or deny the request follow one of the links below.<br><br>" . $responseLink . "" ;
	$mail->AddAddress($email);
	if(!$mail->send()){
		echo "testing";
	}
	else{
		echo "Message has been sent<br>";
	}
}
?>