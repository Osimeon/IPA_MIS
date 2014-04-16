<?php error_reporting (E_ALL ^ E_NOTICE); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('includes/conn.php'); ?>
<?php require_once('includes/css_js_links.php'); ?>
<?php require_once('includes/auth.php'); ?>
<?php
$f_country_name = $_GET['country_name'];
$f_regional_office_id = $_GET['regional_office_id'];
$f_staff_name = $_GET['staff_name'];
$f_emp_no = $_GET['emp_no'];
$f_email = $_GET['email'];
$f_role_id = $_GET['role_id'];
$f_level_id = $_GET['level_id'];
?>
<title><?php require_once('includes/title.php'); ?></title>
<script type="text/javascript">  
    function submitOnEnter(inputElement, event) {  
        if (event.keyCode == 13) { // No need to do browser specific checks. It is always 13.  
            inputElement.form.submit();  
        }  
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
</head>
<body>
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
	  <legend align="center"><h2>SYSTEM USERS LIST</h2></legend>
	  <div align="center">
	    <?php include("includes/messageBox.php");?>
	    </div>
	  <div style="height:530px; overflow:scroll">
		<form action="" method="GET">
	  	<table class="gridtable" align="center" width="100%">
		<tr><td colspan="10">
		<div>
		<strong>Country: </strong>
		<select name="country_name" id="country_name" onkeypress="submitOnEnter(this, event);">
			<option value="<?php echo $session_country_name; ?>">----</option>
			<?php		 
			$query_country = mysql_query("SELECT * FROM country ORDER BY country_name ASC") or die("Query failed: ".mysql_error());
			while($countries = mysql_fetch_array($query_country)): ?>
			<option value="<?php echo $countries['country_name']; ?>"><?php echo $countries['country_name']; ?></option>
			<?php endwhile; ?>
			</select>
		<strong>Office: </strong>		
		<select name="regional_office_id" id="regional_office_id" onkeypress="submitOnEnter(this, event);"></select>
		<p /></div>
		</td></tr>
		  <tr>
			<th>ID</th>
			<th>Staff Name</th>
			<th>Staff No</th>
			<th>Email</th>
			<th>Country</th>
			<th>Office</th>
			<th>Role</th>
			<th>User Level</th>
			<th colspan="2"></th>
		  </tr>
		  <tr>
			<td></td>
			<td><input name="staff_name" type="text" id="staff_name" onkeypress="submitOnEnter(this, event);"/></td>
			<td><input name="emp_no" type="text" id="emp_no" onkeypress="submitOnEnter(this, event);"/></td>
			<td><input name="email" type="text" id="email" onkeypress="submitOnEnter(this, event);"/></td>
			<td colspan="2"></td>
			<td>
			<select name="role_id" id="role_id" onkeypress="submitOnEnter(this, event);">
			<option value="">----</option>
				<?php 
					$query_role = mysql_query("SELECT * FROM users,user_roles WHERE users.role_id=user_roles.role_id GROUP BY job_title ORDER BY job_title ASC") or die("Query failed: ".mysql_error());
					while($role = mysql_fetch_array($query_role)): ?>
					<option value="<?php echo $role['role_id']; ?>"><?php echo $role['job_title']; ?></option>
					<?php endwhile; ?>
			</select>
			</td>
			<td>
			<select name="level_id" id="level_id" onkeypress="submitOnEnter(this, event);">
			<option value="">----</option>
				<?php 
					$query_level = mysql_query("SELECT * FROM users,user_levels WHERE users.level_id=user_levels.level_id GROUP BY user_level ORDER BY user_level ASC") or die("Query failed: ".mysql_error());
					while($level = mysql_fetch_array($query_level)): ?>
					<option value="<?php echo $level['level_id']; ?>"><?php echo $level['user_level']; ?></option>
					<?php endwhile; ?>
			</select>
			</td>
			<td colspan="2"></td>
			</tr>
		<?php
		// Get page data
			$sel = "SELECT * FROM users,country,regional_office,user_roles,user_levels WHERE
			users.regional_office_id=regional_office.regional_office_id AND 
			regional_office.country_name=country.country_name AND 
			users.role_id=user_roles.role_id AND 
			users.level_id=user_levels.level_id AND 
			users.country_name LIKE'%$f_country_name%' AND
			users.regional_office_id LIKE'%$f_regional_office_id%' AND 
			users.staff_name LIKE'%$f_staff_name%' AND 
			users.emp_no LIKE'%$f_emp_no%' AND 
			users.email LIKE'%$f_email%' AND 
			users.role_id LIKE'%$f_role_id%' AND 
			users.level_id LIKE'%$f_level_id%'";
			
			$result=mysql_query($sel);
			$count=mysql_num_rows($result);
			while($rows=mysql_fetch_array($result))
				{
		?>
			<tr >
			<td><?php echo $rows['user_id']; ?></td>
			<td><?php echo $rows['staff_name']; ?></td>
			<td><?php echo $rows['emp_no']; ?></td>
			<td><?php echo $rows['email']; ?></td>
			<td><?php echo $rows['country']; ?></td>
			<td><?php echo $rows["office_name"]; ?></td>
			<td><?php echo $rows["job_title"]; ?></td>
			<td><?php echo $rows["user_level"]; ?></td>
			<td><a href="edit_user.php?user_id=<?php echo $rows["user_id"]; ?>"><img src='images/edit.png ' alt="Edit" width="16" height="16" border="0" /></td>
			<td><a href="delete_user.php?user_id=<?php echo $rows["user_id"]; ?>" onclick="return confirm('<?php echo $rows["staff_name"]; ?> Will be Deleted Completely From the System.');"><img src='images/delete.png ' alt="Delete" width="16" height="16" border="0" /></td>			
		  </tr>
		<?php 
		} ?>
	    </table>
		</form>
		<p />
      </div>
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