<?php

class DB_Functions {
	private $db;	
	
	function __construct(){
		require_once 'DB_Connect.php';
		$this->db = new DB_Connect();
		$this->db->connect();
	}
	
	function __destruct(){
	
	}	
	 
	/**
	 * Adding an issue
	 * @param int $waterpoint id
	 * @param date $date
	 * @param String $dispenser functional
	 * @param int $issue type id
	 * @param int $user id
	 * @param String $comments
	 */
	function addIssue($wpId, $type, $user, $comments, $status, $assigned, $solved){
		$date = date('Y-m-d');
		//$status = "No";		
		$response = array();
		$sql = "INSERT INTO issue (waterpoint_id, date_created, dispenser_functional, issuetype_id,createdby,user_comments, user_assigned, solved, solvedby)".
				"VALUES ('$wpId','$date','$status','$type','$user','$comments','$assigned','$solved','$assigned')";
		if(mysql_query($sql) or die(mysql_error())){
			$response["create"] = array();
			$response["tag"] = 'createissue';
			$response["success"] = 1;			
			$response["error"] = 0;
			return json_encode($response);
		}
		else{
			return FALSE;
		}
	}
	/**
	 * Resolving an issue
	 * @param int issue id
	 * @param date $date
	 * @param int $employee id
	 */
	function resolveIssue($issueid, $emp_no){
		$date = date('Y-m-d');
		$response = array();
		$sql = "UPDATE issue SET solved = 'Yes', date_resolved = '$date',solvedby = '$emp_no',
				dispenser_functional='Yes' WHERE issueid = '$issueid'";
		if(mysql_query($sql) or die(mysql_error())){
			$response["resolve"] = array();
			$response["tag"] = 'resolveissue';
			$response["success"] = 1;			
			$response["error"] = 0;
			return json_encode($response);
		}
		else{
			return FALSE;
		}
	}
	
	/**
	 * Authenticate user 
	 * @param int $staff number
	 * @param String $password
	 */
	function userAuthentication($staffId, $password){
		$password_new = md5($password);
		$sql = "SELECT emp_no, email FROM users WHERE users.emp_no='$staffId' and users.password='$password_new'";
		$result = mysql_query($sql) or die(mysql_error());
		$count = mysql_num_rows($result);
		if($count > 0){
			$result = mysql_fetch_array($result);
			return $result;
		}
		else{
			return FALSE;
		}
	}
	
	/**
	 * Get sing user record
	 * @param int $staff id
	 */
	function getUsers($staffId){
		$response = array();
		$sql = "SELECT emp_no, email FROM users WHERE emp_no = '$staffId' LIMIT 1";
		$result = mysql_query($sql) or die(mysql_error());
		$count = mysql_num_rows($result);
		if($count > 0){
			$response["users"] = array();
			$response["tag"] = 'users';
			$response["success"] = 1;			
			$response["error"] = 0;
			
			while($row = mysql_fetch_array($result)){
				$user = array();
				$user["emp_no"] = $row["emp_no"];
				$user["email"] = $row["email"];
				array_push($response["users"], $user);
			}
			
			return json_encode($response);
		}
		else{
			return FALSE;
		}
	}	
	
	/**
	 * Get waterpoints count
	 * This ensures that the waterpoints count of dsw_is 
	 * Matches with the phone count 
	 * If not sync waterpoints
	 */
	function getWaterpointsCount($staffId){
		$userSql = "SELECT regional_office_id FROM users WHERE emp_no = '$staffId' LIMIT 1";
		$userResult = mysql_query($userSql) or die(mysql_error());
		$userRow = mysql_fetch_array($userResult);
		$currentUser = $userRow["regional_office_id"];
		
		$response = array();
		$sql = "SELECT count(waterpoint_id) as wpcount FROM waterpoints WHERE regional_office_id = '$currentUser'";
		$result = mysql_query($sql) or die(mysql_error());
		if($result){
			$row = mysql_fetch_array($result);
			$count = mysql_num_rows($result);
			$response["waterpointCount"] = array();
			$count = array();
			$count["count"] = $row["wpcount"];
			array_push($response["waterpointCount"], $count);
			$response["tag"] = 'waterpointCount';
			$response["success"] = 1;			
			$response["error"] = 0;
			return json_encode($response);
		}
		else{
			return FALSE;
		}
	}
	
	/**
	 * Get all waterpoints
	 */
	function getWaterpoints($staffId){
		$userSql = "SELECT regional_office_id FROM users WHERE emp_no = '$staffId' LIMIT 1";
		$userResult = mysql_query($userSql) or die(mysql_error());
		$userRow = mysql_fetch_array($userResult);
		$currentUser = $userRow["regional_office_id"];
		
		$response = array();
		$sql = "SELECT waterpoint_id, waterpoint_name, district_name, sublocation_parish, village FROM waterpoints  
				WHERE regional_office_id = '$currentUser' 
				ORDER BY waterpoint_name ASC";
		$result = mysql_query($sql) or die(mysql_error());
		$count = mysql_num_rows($result);
		if($count > 0){
			$response["waterpoints"] = array();
			$response["tag"] = 'waterpoints';
			$response["success"] = 1;			
			$response["error"] = 0;
			
			while($row = mysql_fetch_array($result)){
				$waterpoint = array();
				$waterpoint["waterpoint_id"] = $row["waterpoint_id"];
				$waterpoint["waterpoint_name"] = $row["waterpoint_name"];
				$waterpoint["district_name"] = $row["district_name"];
				$waterpoint["sublocation"] = $row["sublocation_parish"];
				$waterpoint["village"] = $row["village"];
				array_push($response["waterpoints"], $waterpoint);
			}
						
			return json_encode($response);
		}
		else{
			return FALSE;
		}
	}
	/**
	 * Check Server Issue Type Count
	 */
	function getServerIssueTypeCount(){
		$response = array();
		$sql = "SELECT count(issuetype_id) as issuecount FROM issue_type";
		$result = mysql_query($sql) or die(mysql_error());
		if($result){
			$row = mysql_fetch_array($result);
			$count = mysql_num_rows($result);
			$response["issueTypeCount"] = array();
			$count = array();
			$count["count"] = $row["issuecount"];
			array_push($response["issueTypeCount"], $count);
			$response["tag"] = 'issueTypeCount';
			$response["success"] = 1;			
			$response["error"] = 0;
			return json_encode($response);
		}
		else{
			return FALSE;
		}
	}
	
	/**
	 * Get all issue types
	 */
	function getIssueTypes(){
		$response = array();
		$sql = "SELECT issuetype_id, issue_type, issue_name FROM issue_type ORDER BY issue_name ";
		$result = mysql_query($sql) or die(mysql_error());
		$count = mysql_num_rows($result);
		if($count > 0){
			$response["issuetypes"] = array();
			$response["tag"] = 'issuetype';
			$response["success"] = 1;			
			$response["error"] = 0;
			
			while($row = mysql_fetch_array($result)){
				$type = array();
				$type["issuetype_id"] = $row["issuetype_id"];
				$type["issue_type"] = $row["issue_type"];
				$type["issue_name"] = $row["issue_name"];
				array_push($response["issuetypes"], $type);
			}			
						
			return json_encode($response);
		}
		else{
			return FALSE;
		}
	}
	
	/**
	 * Get issues assigned to a specific user
	 * @param int $userid
	 * @param String $status
	 */
	function getIssues($user){
		$status = 'No';		
		$response = array();
		$sql = "SELECT issueid, waterpoint_id, date_created, solved, issuetype_id FROM issue
				WHERE user_assigned = '$user' AND solved = '$status' ORDER BY issueid";
		$result = mysql_query($sql) or die(mysql_error());
		$count = mysql_num_rows($result);
		if($count > 0){			
			$response["issues"] = array();	
			$response["tag"] = 'issues';
			$response["success"] = 1;			
			$response["error"] = 0;
				
			while($row = mysql_fetch_array($result)){
				$issue = array();
				$issue["issueid"] = $row["issueid"];
				$issue["waterpoint_id"] = $row["waterpoint_id"];
				$issue["date_created"] =  $row["date_created"];
				$issue["resolved"] =  $row["solved"];
				$issue["issuetype_id"] =  $row["issuetype_id"];
				array_push($response["issues"], $issue);
			}
			
			
			return json_encode($response);
		}
		else{
			return FALSE;
		}
	}	
}
?>