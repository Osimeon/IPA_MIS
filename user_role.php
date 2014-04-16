<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('includes/conn.php'); ?>
<?php require_once('includes/css_js_links.php'); ?>
<?php require_once('includes/auth.php'); ?>
<title><?php require_once('includes/title.php'); ?></title>
<script language="javascript" type="text/javascript">
function capitaliseName()
{
	var str = document.getElementById("job_title").value;
    document.getElementById("job_title").value = str.charAt(0).toUpperCase() + str.slice(1);

}
</script>
</head>
<body>
<?php
require_once("includes/functions.php");
require_once("includes/form_functions.php");
require_once("includes/messageBox.php");
//checks if the form has been submited
if(isset($_POST['Submit']))
	{
	//Check if not empty
	$errors=array();
	$required_fields = array('job_title');
	$errors=check_required_fields($required_fields);

		$query="SELECT * FROM user_roles WHERE job_title = '{$_POST['job_title']}' LIMIT 1";
		$check_manufacture=mysql_query($query);
		$rows=mysql_num_rows($check_manufacture);

		if((empty($errors))&&($rows==0))
		{
			$job_title=$_POST['job_title'];

			$query = "INSERT INTO user_roles (job_title) ".
	"VALUES ('$job_title')";
	mysql_query($query) or die('Error, query failed');
	$messageToUser="Role Added Succesfuly.<p>";
	} 
	else
	{
	//Errors exist so building error message
	$job_title=$_POST['job_title'];
	if(!empty($errors))
	{
	$error_message.="Please review the feilds with an asterix(*) beside them.<br/>";
	}
	if($rows==1)
	{
	$error_message.="Role Exists.";
	}
	}
	}
	else
	{
	$errors=array();
	$job_title="";
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
	  <legend align="center"><h2>ADD USER ROLE</h2></legend>
		<?php include("includes/messageBox.php");?>
		<form id="manufacture_form" name="manufacture_form" method="post" action="">
	    <table align="center">
		  <tr>
            <td><strong>Job Title:</strong></td>
            <td><input name="job_title" type="text" id="job_title"/><?php display_error("job_title",$errors);?></td>
          </tr>
          <tr>
            <td colspan="2" align="center"><input type="submit" name="Submit" value="Add Role" class="btn-style"/></td>
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