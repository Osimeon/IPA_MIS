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
	$required_fields = array('dep_name','dep_desc');
	$errors=check_required_fields($required_fields);

		$query="SELECT * FROM department WHERE dep_name = '{$_POST['dep_name']}' LIMIT 1";
		$check_dep=mysql_query($query);
		$rows=mysql_num_rows($check_dep);

		if((empty($errors))&&($rows==0))
		{
			$dep_name=$_POST['dep_name'];
			$dep_desc=$_POST['dep_desc'];
			
			
			$query = "INSERT INTO department (dep_name,dep_desc) ".
	"VALUES ('$dep_name','$dep_desc')";
	mysql_query($query) or die('Error, query failed');
	$messageToUser="Department Added Succesfuly.<p>";
	} 
	else
	{
	//Errors exist so building error message
	$dep_name=$_POST['dep_name'];
	$dep_desc=$_POST['dep_desc'];
	
	if(!empty($errors))
	{
	$error_message.="Please review the feilds with an asterix(*) beside them.<br/>";
	}
	if($rows==1)
	{
	$error_message.="Department Exists.";
	}
	}
	}
	else
	{
	$errors=array();
	$dep_name="";
	$dep_desc="";
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
	  <legend align="center"><h2>ADD DEPARTMENT</h2></legend>
		<?php include("includes/messageBox.php");?>
		<form id="reg_form" name="reg_form" method="post" action="">
	    <table align="center">
		  <tr>
            <td><strong>Department :</strong> <strong>*</strong></td>
            <td><input name="dep_name" type="text" id="dep_name" onkeydown="capitaliseName()"/><?php display_error("dep_name",$errors);?></td>
          </tr>
		  <tr>
            <td><strong>Description:</strong> <strong>*</strong></td>
            <td><textarea name="dep_desc" id="dep_desc"></textarea><?php display_error("dep_desc",$errors);?></td>
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