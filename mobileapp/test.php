<?php
	require_once 'DB_Functions.php';
	$db = new DB_Functions();
	
	
	$issues = $db->getWaterpoints(1558);
	$response["success"] = 1;
	if ($issues != false) {
		echo $issues;
	}
	else {
		$response["error"] = 0;
		$response["error_msg"] = "Could Not Get Waterpoints Count!";
		echo json_encode($response);
    }
?>