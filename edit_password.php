<?php error_reporting (E_ALL ^ E_NOTICE); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
include('includes/conn.php');
require_once('includes/css_js_links.php');
require_once("includes/functions.php");
require_once("includes/form_functions.php");
?>
<title><?php require_once('includes/title.php'); ?></title>
</head>
<body>
<?php
$email = $_GET['email'];
$emp_no = $_GET['emp_no'];
if(isset($_POST['Submit']))
{
//Check if not empty
$errors=array();
$required_fields = array('password','confirm_password');
$errors=check_required_fields($required_fields);
//Check if passwords match
$password_match=check_password_match($_POST['password'],$_POST['confirm_password']);

if((empty($errors))&&$password_match)
{
//Check if Fields are not blank
$errors=array();
$password=mysql_prep($_POST['password']);
$hashed_password=md5($password);
$query="UPDATE users SET password='$hashed_password' WHERE email='$email' AND emp_no='$emp_no'";
$update_password=get_result_set($query);
$messageToUser="Your Password Has Been Changed Succesfuly!<br /><a href='index.php'><strong>PROCEED TO LOGIN</strong></a>";
}
else
{
//If Errors Exist Building error message
$password=$_POST['password'];
$error_message="<strong>Please review the following errors.</strong><br/>";
if(!empty($errors))
{
$error_message.="Please review the feilds with an asterix(*) beside them.<br/>";
}
if(!$password_match)
{
$error_message.="Password and Confirmation password do not match.<br/>";
}
}
}
else
{
$errors=array();
$password="";
}
?>
    <div class="container">
    <form method="GET" action=""> 
	<table id="login" width="20%" align="center" cellpadding="5" cellspacing="5">
	  <tr>
		<td colspan="2" align="center"><h3>Provide your Email Address and Staff No to Change password</h3></td>
	  </tr>
	  <tr>
		<td><strong>Email:</strong></td>
		<td><input name="email" type="text" id="email" /></td>
	  </tr>
	  <tr>
		<td><strong>Staff No:</strong></td>
		<td><input name="emp_no" type="text" id="emp_no" /></td>
	  </tr>
	  <tr>
		<td colspan="2" align="center">
		  <input name="Submit" type="submit" id="Submit" value="Proceed" class="btn-style"/>
		</td>
	  </tr>
	</table>
    </form>
			<?php
				// Get page data
				$sel = "SELECT * FROM users WHERE email='$email' AND emp_no='$emp_no'";
				$result = mysql_query ($sel);
				while ($row = mysql_fetch_assoc($result)){
			?>	
		<?php include("includes/messageBox.php");?>
		<form id="edit_user" name="edit_user" method="post" action="edit_password.php?email=<?php echo $email; ?>&&emp_no=<?php echo $emp_no; ?>">
	    <table width="20%" align="center" cellpadding="5" cellspacing="5">
		   <tr>
            <td><strong>Name:</strong></td>
            <td><?php echo $row['staff_name']; ?></td>
          </tr>
		  <tr>
            <td><strong>Email:</strong></td>
            <td><?php echo $row['email']; ?></td>
          </tr>
          <tr>
            <td><strong>Staff No:</strong></td>
            <td><?php echo $row['emp_no']; ?></td>
          </tr>
		  <tr>
            <td><strong>Country:</strong></td>
            <td><?php echo $row['country_name']; ?></td>
          </tr>		  
		  <tr>
            <td><strong>Office:</strong></td>
            <td><?php echo $row['office_name']; ?></td>
          </tr>
		  <tr>
            <td><strong>Job Title:</strong> </td>
            <td><?php echo $row['job_title']; ?></td>
          </tr>
		  <tr>
            <td><strong>Level:</strong></td>
            <td><?php echo $row['user_level']; ?></td>
          </tr>
		  <tr>
		<td><strong>Password:</strong></td>
		<td><input name="password" type="password" id="password"/><?php display_error("password",$errors);?></td>
	  </tr>
	  <tr>
		<td><strong>Confirm Password:</strong></td>
		<td><input name="confirm_password" type="password" id="confirm_password"/><?php display_error("confirm_password",$errors);?></td>
	  </tr>
          <tr>
            <td colspan="2" align="center"><input type="submit" name="Submit" value="Reset Password" class="btn-style"/></td>
          </tr>
        </table>
		</form>
		  <?php 
		  } ?>	
	</div>
</body>
</html>