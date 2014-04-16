<?php
  require ("includes/conn.php");
	$user_id =$_REQUEST['user_id'];
	// sending query
	mysql_query("DELETE FROM users WHERE user_id = '$user_id'")
	or die(mysql_error());  	
	header("Location: users_list.php");
?>