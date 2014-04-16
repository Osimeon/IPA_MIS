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
require_once("includes/functions.php");
require_once("includes/form_functions.php");
require_once("includes/messageBox.php");
//checks if the form has been submited
if(isset($_POST['Submit']))
	{
	//Check if not empty
	$errors=array();
	$required_fields = array('start_date','end_date');
	$errors=check_required_fields($required_fields);

		$query="SELECT * FROM performance_period WHERE end_date >= '{$_POST['start_date']}' AND start_date <= '{$_POST['end_date']}' LIMIT 1";
		$check_country=mysql_query($query);
		$rows=mysql_num_rows($check_country);

		if((empty($errors))&&($rows==0))
		{
			$start_date=$_POST['start_date'];
			$end_date=$_POST['end_date'];
			
			
			$query = "INSERT INTO performance_period (start_date,end_date) ".
	"VALUES ('$start_date','$end_date')";
	mysql_query($query) or die('Error, query failed');
	$messageToUser="Performance Period Added Succesfuly.<p>";
	} 
	else
	{
	//Errors exist so building error message
	$start_date=$_POST['start_date'];
	$end_date=$_POST['end_date'];
	
	if(!empty($errors))
	{
	$error_message.="Please review the feilds with an asterix(*) beside them.<br/>";
	}
	if($rows==1)
	{
	$error_message.="Performance Period Exists.";
	}
	}
	}
	else
	{
	$errors=array();
	$start_date="";
	$end_date="";
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
	  <legend align="center"><h2>ADD PERFORMANCE PERIOD</h2></legend>
		<?php include("includes/messageBox.php");?>
		<form id="issue_form" name="issue_form" method="post" action="">
	    <table align="center">
		  <tr>
            <td><strong>Performance Period Start Date:</strong></td>
            <td><input name="start_date" type="text" id="start_date" placeholder="YYYY-MM-DD"/><?php display_error("start_date",$errors);?></td>
          </tr>
		  <tr>
			<td><strong>Performance Period End Date:</strong></td>
            <td><input name="end_date" type="text" id="end_date" placeholder="YYYY-MM-DD"/><?php display_error("end_date",$errors);?></td>
          </tr>
          <tr>
            <td colspan="2" align="center"><input type="submit" name="Submit" value="Create Performance Period" class="btn-style"/></td>
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