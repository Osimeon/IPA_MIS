<?php error_reporting (E_ALL ^ E_NOTICE); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('includes/conn.php'); ?>
<?php require_once('includes/css_js_links.php'); ?>
<?php require_once('includes/auth.php'); ?>
<title><?php require_once('includes/title.php'); ?></title>
</head>
<body>
<script language="javascript" type="text/javascript">
function capitaliseName()
{
    var str = document.getElementById("staff_name").value;
    document.getElementById("staff_name").value = str.charAt(0).toUpperCase() + str.slice(1);
}
</script>
<script type="text/javascript">
$(document).ready(function() {
    
	$("#country_name").change(function() {
		$.get('loadoffice.php?country_name=' + $(this).val(), function(data) {
			$("#regional_office_id").html(data);
			$('#loader').slideUp(200, function() {
				$(this).remove();
			});
		});	
    });

});
</script>
<?php
require_once("includes/functions.php");
require_once("includes/form_functions.php");
require_once("includes/messageBox.php");
//checks if the form has been submited
if(isset($_POST['Submit']))
	{
	//Check if not empty
	$errors=array();
	$required_fields = array('staff_name','email','emp_no','country_name','regional_office_id','role_id','level_id','password');
	$errors=check_required_fields($required_fields);
	
	//Check if email is valid
		$valid_email=valid_email($_POST['email']);

		$query="SELECT * FROM users WHERE email = '{$_POST['email']}' LIMIT 1";
		$check_email=mysql_query($query);
		$rows=mysql_num_rows($check_email);

		if((empty($errors))&&$valid_email&&($rows==0))
		{
			$staff_name=$_POST['staff_name'];
			$email=$_POST['email'];
			$emp_no=$_POST['emp_no'];
			$country_name=$_POST['country_name'];
			$regional_office_id=$_POST['regional_office_id'];
			$role_id=$_POST['role_id'];
			$level_id=$_POST['level_id'];
			$password=md5($_POST['password']);
			
			
			$query = "INSERT INTO users (staff_name,email,emp_no,country_name,regional_office_id,role_id,level_id,password) ".
	"VALUES ('$staff_name','$email','$emp_no','$country_name','$regional_office_id','$role_id','$level_id','$password')";
	mysql_query($query) or die('Error, query failed');
	$messageToUser="User $staff_name has Been Registered Succesfuly!<p>";
	} 
	else
	{
	//Errors exist so building error message
	$staff_name=$_POST['staff_name'];
	$email=$_POST['email'];
	$emp_no=$_POST['emp_no'];
	$country_name=$_POST['country_name'];
	$regional_office_id=$_POST['regional_office_id'];
	$role_id=$_POST['role_id'];
	$level_id=$_POST['level_id'];
	$password=$_POST['password'];
	
	if(!empty($errors))
	{
	$error_message.="Please review the feilds with an asterix(*) beside them.<br/>";
	}
	if(!$valid_email)
	{
	$error_message.="The email you provided is not valid email address.";
	}
	if($rows==1)
	{
	$error_message.="The email address you provided is already associated to another account. Please provide another one.";
	}
	}
	}
	else
	{
	$errors=array();
	$staff_name="";
	$email="";
	$emp_no="";
	$country_name="";
	$regional_office_id="";
	$role_id="";
	$level_id="";
	$password="";
	}
?>
    <table class="container">
    <tr>
        <td colspan="3">
		<div id='top_menu'><?php require_once('includes/top_nav.php'); ?></div>
		</td>
    </tr>
    <tr>
      <td colspan="3">
	  <div id="left_menu">
	  <?php if ($session_level_id <= "2")
		//System Middle Access Level 
		{ 
		require_once('includes/left_column.php'); 
		}
		?>
	  </div>
	  <div id="content_area">
	  <fieldset name="reg_user" id="reg_user">
	  <legend align="center"><h2>REGISTER NEW USER</h2></legend>
	<?php include("includes/messageBox.php");?>
	  <form id="reg_form" name="reg_form" method="post" action="">
	    <table align="center">
		   <tr>
            <td><strong>Name:</strong> <strong>*</strong></td>
            <td><input name="staff_name" type="text" id="staff_name" onkeyup = "capitaliseName()" autocomplete="off"/><?php display_error("staff_name",$errors);?></td>
          </tr>
		  <tr>
            <td><strong>Email:</strong> <strong>*</strong></td>
            <td><input name="email" type="text" id="email" placeholder="cnyarongi@poverty-action.org"/><?php display_error("email",$errors);?></td>
          </tr>
          <tr>
            <td><strong>Staff No:</strong> <strong>*</strong></td>
            <td><input name="emp_no" type="text" id="emp_no" /><?php display_error("emp_no",$errors);?></td>
          </tr>
		  <tr>
            <td><strong>Country:*</strong> </td>
            <td>
			<select name="country_name" id="country_name" onkeypress="submitOnEnter(this, event);">
			<option value="<?php echo $session_country_name; ?>">----</option>
			<?php		 
			$query_country = mysql_query("SELECT * FROM country ORDER BY country_name ASC") or die("Query failed: ".mysql_error());
			while($countries = mysql_fetch_array($query_country)): ?>
			<option value="<?php echo $countries['country_name']; ?>"><?php echo $countries['country_name']; ?></option>
			<?php endwhile; ?>
			</select><?php display_error("country_name",$errors);?>
			</td>
          </tr>		  
		  <tr>
            <td><strong>Regional Office:*</strong> </td>
            <td>
			<select name="regional_office_id" id="regional_office_id" onkeypress="submitOnEnter(this, event);"></select><?php display_error("regional_office_id",$errors);?>
			</td>
          </tr>
		  <tr>
            <td><strong>Job Title:*</strong> </td>
            <td>
			<select name="role_id" id="role_id">
			<option value=''></option>
				<?php  
				$result_set=mysql_query("SELECT * FROM user_roles ORDER BY job_title ASC");
				while($row=mysql_fetch_array($result_set))
				{
				echo "<option value=\"{$row['role_id']}\">{$row['job_title']}</option>";
				}
				?>
			</select><?php display_error("role_id",$errors);?>
			</td>
          </tr>
		  <tr>
            <td><strong>Access Level:*</strong> </td>
            <td>
			<select name="level_id" id="level_id">
				<?php  
				$result_set=mysql_query("SELECT * FROM user_levels ORDER BY level_id DESC");
				while($row=mysql_fetch_array($result_set))
				{
				echo "<option value=\"{$row['level_id']}\">{$row['user_level']}</option>";
				}
				?>
			</select><?php display_error("level_id",$errors);?>
			</td>
          </tr>
		  <tr>
            <td><strong>Password:</strong> <strong>*</strong></td>
            <td><input name="password" type="password" id="password" value="12345" /><?php display_error("password",$errors);?></td>
          </tr>
          <tr>
			<td></td>
            <td align="center"><input type="submit" name="Submit" value="Submit" class="btn-style"/></td>
          </tr>
        </table>
      </form>	
	  </fieldset>
	  </div>
	  <div id="right_menu">
		<?php if ($session_level_id == "1")
		//System Admin Access Level
		{ 
		require_once('includes/right_column.php'); 
		}
		?>
	  </div>
	  </td>
    </tr>
    <tr>
      <td colspan="3" class="footer"><?php require_once('includes/footer.php'); ?></td>
    </tr>
  </table>
</body>
</html>