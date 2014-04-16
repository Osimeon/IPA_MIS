<?php error_reporting (E_ALL ^ E_NOTICE); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php 
$login_fail = $_GET['message'];
?>
<?php require_once('includes/css_js_links.php'); ?>
<title><?php require_once('includes/title.php'); ?></title>
</head>
<body>
    <div class="container">
    <form id="login_form" name="login_form" method="post" action="login.php"> 
	<table id="login" width="20%" align="center" cellpadding="5" cellspacing="5">
	  <tr>
		<td colspan="2" align="center"><span style="color:#FF2222"><b><?php echo"$login_fail" ?></b></span></td>
	  </tr>
	  <tr>
		<td colspan="2" align="center"><h3>System Login</h3></td>
	  </tr>
	  <tr>
		<td><strong>Email:</strong></td>
		<td><input name="email" type="text" id="email" /></td>
	  </tr>
	  <tr>
		<td><strong>Password:</strong></td>
		<td><input name="password" type="password" id="password" /></td>
	  </tr>
	  <tr>
		<td colspan="2" align="center"><a href='edit_password.php'><strong>Forgot/Change Password?</strong></a></td>
	  </tr>
	  <tr>
		<td colspan="2"><div align="center">
		  <input name="Submit" type="submit" id="Submit" value="Login" class="btn-style"/>
		</div></td>
	  </tr>
	</table>
    </form>
	</div>
</body>
</html>