<?php
	if (isset($_POST['tag']) && $_POST['tag'] != '') {
		 $tag = $_POST['tag'];
		  require_once 'DB_Functions.php';
		  $db = new DB_Functions();
    	  $response = array("tag" => $tag, "success" => 0, "error" => 0);
		  
    	  if ($tag == 'login') {
				$staffId = $_POST['staffid'];
				$password = $_POST['password'];
				$user = $db->userAuthentication($staffId,$password);
				if ($user != false) {
					$response["success"] = 1;
					$response["user"]["staffId"] = $user["emp_no"];
					$response["user"]["email"] = $user["email"];
					echo json_encode($response);
				}
				else {
					$response["error"] = 1;
					$response["error_msg"] = "Incorrect email or password!";
					echo json_encode($response);
    			}
		  }
		  else if($tag == 'waterpoints'){
				$staffId = $_POST['staffId'];
		  		$waterpoints = $db->getWaterpoints($staffId);
				if($waterpoints != false){
					echo($waterpoints);
				}
				else{
					$response["error"] = 1;
					$response["error_msg"] = "Failed To Get Waterpoints!";
					echo json_encode($response);
				}
		  }
		  else if($tag == 'issuetypes'){
		  		$types = $db->getIssueTypes();
				if($types != false){
					echo($types);
				}
				else{
					$response["error"] = 1;
					$response["error_msg"] = "Failed To Get Waterpoints!";
					echo json_encode($response);
				}
		  }
		  else if($tag == 'issues'){
		  		$staffNumber = $_POST['staff_number'];
		  		$issues = $db->getIssues($staffNumber);
				if($issues != false){
					echo($issues);
				}
				else{
					$response["error"] = 1;
					$response["error_msg"] = "Could Not Get Issues For User $staffNumber!";
					echo json_encode($response);
				}
		  }
		  else if($tag == 'users'){
		  		$staffNumber = $_POST['staff_id'];
				$user = $db->getUsers($staffNumber);
				if($user != false){
					echo($user);
				}
				else{
					$response["error"] = 1;
					$response["error_msg"] = "Failed To Get User $staffNumber!";
					echo json_encode($response);
				}
		  }
		  else if($tag == 'waterpointscount'){
				$staffId = $_POST['staffId'];
		  		$count = $db->getWaterpointsCount($staffId);
				if($count != false){
					echo($count);
				}
				else{
					$response["error"] = 1;
					$response["error_msg"] = "Could Not Get Waterpoints Count!";
					echo json_encode($response);
				}
		  }
		  else if($tag == 'issuetypecount'){
		  		$count = $db->getServerIssueTypeCount();
				if($count != false){
					echo($count);
				}
				else{
					$response["error"] = 1;
					$response["error_msg"] = "Could Not Get Issue Type Count!";
					echo json_encode($response);
				}
		  }
		  else if($tag == 'resolve'){
		  		$issueid = $_POST['issue_id'];
				$emp_no = $_POST['emp_no'];
		  		$resolve = $db->resolveIssue($issueid, $emp_no);
				if($resolve != false){
					echo($resolve);
				}
				else{
					$response["error"] = 1;
					$response["error_msg"] = "Could Not Resolve Issue!!";
					echo json_encode($response);
				}
		  }
		  else if($tag == 'createissue'){
		  		$wpId = $_POST['wpId'];
				$typeId = $_POST['typeId'];
				$user = $_POST['user'];
				$comments = $_POST['comments'];
				$status = $_POST['status'];
				$user_assigned = $_POST['user_assigned'];
				$resolved = $_POST['resolved'];
				
				$create = $db->addIssue($wpId, $typeId, $user, $comments, $status, $user_assigned, $resolved);
				if($create != false){
					echo($create);
				}
				else{
					$response["error"] = 1;
					$response["error_msg"] = "Could Create Issue!!";
					echo json_encode($response);
				}
		  }
		  else if($tag == 'createresolve'){
				$wpId = $_POST['wpId'];
				$typeId = $_POST['typeId'];
				$user = $_POST['user'];
				$comments = $_POST['comments'];
				$status = $_POST['status'];
				$user_assigned = $_POST['user_assigned'];
				$resolved = $_POST['resolved'];
				
				$create = $db->addIssueResolved($wpId, $typeId, $user, $comments, $status, $user_assigned, $resolved);
				if($create != false){
					echo($create);
				}
				else{
					$response["error"] = 1;
					$response["error_msg"] = "Could Create Issue!!";
					echo json_encode($response);
				}
		  }
		  
		  else {
		  		echo "Invalid Request";
		  }
	}
	else {
		echo "Access Denied";
	}
?>