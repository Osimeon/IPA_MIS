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
//Update Manufacture
$role_id = $_GET['role_id'];
if(isset($_POST['Submit'])){
	$job_title = $_POST['job_title'];	
	mysql_query("UPDATE user_roles SET job_title ='$job_title' WHERE role_id = '$role_id'")or die(mysql_error());
	header("Location: view_roles.php");				
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
	  <legend align="center"><h2>EDIT ROLE</h2></legend>
		<?php include("includes/messageBox.php");?>
		<form id="edit_role" name="edit_role" method="post" action="">
	    <table align="center">
		  <tr>
            <td><strong>Job Title:</strong></td>
			<?php
			// Get page data
			$sel = "SELECT * FROM user_roles WHERE role_id='$role_id'";
			$result = mysql_query ($sel);
			while ($row = mysql_fetch_assoc($result)){
			?>
            <td><input name="job_title" type="text" id="job_title" value="<?php echo $row['job_title']; ?>"/></td>
			<?php 
			} ?>
          </tr>
          <tr>
            <td colspan="2" align="center"><input type="submit" name="Submit" value="Update Role" class="btn-style"/></td>
          </tr>
		  <tr>
			<td></td><td><p></td>
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