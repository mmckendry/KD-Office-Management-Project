<?php
function formData_process($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function redirect($url){
	header_remove("location");
	header("location: ".$url);
}

function scopedInclude($file, $referer){
    global $includerFile;
	$includerFile = $referer;
    include $file;
}

?>