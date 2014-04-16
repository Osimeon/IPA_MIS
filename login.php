<?php
include('includes/conn.php');

if (isset($_POST['Submit'])) {
$email=$_POST['email'];
$password=md5($_POST['password']);
$result=mysql_query("SELECT * FROM users,regional_office,country WHERE users.email='$email' and users.password='$password' AND users.regional_office_id=regional_office.regional_office_id AND regional_office.country_name=country.country_name LIMIT 1")or die (mysql_error()); 
		
$count=mysql_num_rows($result);
$row=mysql_fetch_array($result);
		
		if ($count > 0){
		session_start();
		$_SESSION['user_id']=$row['user_id'];
		$_SESSION['staff_name']=$row['staff_name'];
		$_SESSION['emp_no']=$row['emp_no'];
		$_SESSION['email']=$row['email'];
		$_SESSION['role_id']=$row['role_id'];
		$_SESSION['level_id']=$row['level_id'];
		$_SESSION['regional_office_id']=$row['regional_office_id'];
		$_SESSION['office_name']=$row['office_name'];
		$_SESSION['country_code']=$row['country_code'];
		$_SESSION['country_name']=$row['country_name'];
		$_SESSION['tel_code']=$row['tel_code'];
		header('location:home.php');
		}
		else{
		header('location:index.php?message=Login Failed! Incorrect Email or Password');
		}
}
?>

