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
<?php
//Update User Details
$user_id = $_GET['user_id'];
if(isset($_POST['Submit'])){
	$staff_name = $_POST['staff_name'];
	$email = $_POST['email'];
	$emp_no = $_POST['emp_no'];
	$country_name = $_POST['country_name'];
	$regional_office_id = $_POST['regional_office_id'];
	$role_id = $_POST['role_id'];
	$level_id = $_POST['level_id'];
	mysql_query("UPDATE users SET 
	staff_name ='$staff_name',
	email ='$email',
	emp_no ='$emp_no',
	country_name ='$country_name',
	regional_office_id ='$regional_office_id',
	role_id ='$role_id',
	level_id ='$level_id' WHERE user_id = '$user_id'")or die(mysql_error());
	header("Location: users_list.php");				
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
	  <legend align="center"><h2>EDIT USER DETAILS</h2></legend>
	  <form id="edit_user" name="edit_user" method="post" action="">
	    <table align="center">
			<?php
				// Get page data
				$sel = "SELECT * FROM users,country,regional_office,user_roles,user_levels WHERE
					users.regional_office_id=regional_office.regional_office_id AND 
					regional_office.country_name=country.country_name AND 
					users.role_id=user_roles.role_id AND 
					users.level_id=user_levels.level_id AND user_id='$user_id'";
				$result = mysql_query ($sel);
				while ($row = mysql_fetch_assoc($result)){
			?>
		   <tr>
            <td><strong>Name:</strong></td>
            <td><input name="staff_name" type="text" id="staff_name" value="<?php echo $row['staff_name']; ?>"/></td>
          </tr>
		  <tr>
            <td><strong>Email:</strong></td>
            <td><input name="email" type="text" id="email" value="<?php echo $row['email']; ?>"/></td>
          </tr>
          <tr>
            <td><strong>Staff No:</strong></td>
            <td><input name="emp_no" type="text" id="emp_no" value="<?php echo $row['emp_no']; ?>"/></td>
          </tr>
		  <tr>
            <td><strong>Country:</strong></td>
            <td>
			<select name="country_name" id="country_name">
					<option value="<?php echo $row['country_name']; ?>"><?php echo $row['country_name']; ?></option>
					<?php 
					$query_country = mysql_query("SELECT * FROM country ORDER BY country_name ASC") or die("Query failed: ".mysql_error());
					while($sel_country = mysql_fetch_array($query_country)): ?>
					<option value="<?php echo $sel_country['country_name']; ?>"><?php echo $sel_country['country_name']; ?></option>
					<?php endwhile; ?>
				</select>
			</td>
          </tr>		  
		  <tr>
            <td><strong>Regional Office:</strong></td>
            <td>
			<select name="regional_office_id" id="regional_office_id">
					<option value="<?php echo $row['regional_office_id']; ?>"><?php echo $row['office_name']; ?></option>
					<?php 
					$query_office = mysql_query("SELECT * FROM regional_office ORDER BY office_name ASC") or die("Query failed: ".mysql_error());
					while($sel_office = mysql_fetch_array($query_office)): ?>
					<option value="<?php echo $sel_office['regional_office_id']; ?>"><?php echo $sel_office['office_name']; ?></option>
					<?php endwhile; ?>
				</select>
			</td>
          </tr>
		  <tr>
            <td><strong>Job Title:</strong> </td>
            <td>
			<select name="role_id" id="role_id">
					<option value="<?php echo $row['role_id']; ?>"><?php echo $row['job_title']; ?></option>
					<?php 
					$query_role = mysql_query("SELECT * FROM user_roles ORDER BY job_title ASC") or die("Query failed: ".mysql_error());
					while($sel_role = mysql_fetch_array($query_role)): ?>
					<option value="<?php echo $sel_role['role_id']; ?>"><?php echo $sel_role['job_title']; ?></option>
					<?php endwhile; ?>
				</select>
			</td>
          </tr>
		  <tr>
            <td><strong>Access Level:</strong></td>
            <td>
			<select name="level_id" id="level_id">
					<option value="<?php echo $row['level_id']; ?>"><?php echo $row['user_level']; ?></option>
					<?php 
					$query_level = mysql_query("SELECT * FROM user_levels ORDER BY user_level ASC") or die("Query failed: ".mysql_error());
					while($sel_level = mysql_fetch_array($query_level)): ?>
					<option value="<?php echo $sel_level['level_id']; ?>"><?php echo $sel_level['user_level']; ?></option>
					<?php endwhile; ?>
				</select>
			</td>
          </tr>
		  <?php 
		  } ?>
          <tr>
			<td></td>
            <td align="center"><input type="submit" name="Submit" value="Update User Details" class="btn-style"/></td>
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