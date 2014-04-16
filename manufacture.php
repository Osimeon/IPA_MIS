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
	var str = document.getElementById("manufacture").value;
    document.getElementById("manufacture").value = str.charAt(0).toUpperCase() + str.slice(1);

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
	$required_fields = array('manufacture');
	$errors=check_required_fields($required_fields);

		$query="SELECT * FROM manufacture WHERE manufacture = '{$_POST['manufacture']}' LIMIT 1";
		$check_manufacture=mysql_query($query);
		$rows=mysql_num_rows($check_manufacture);

		if((empty($errors))&&($rows==0))
		{
			$manufacture=$_POST['manufacture'];

			$query = "INSERT INTO manufacture (manufacture) ".
	"VALUES ('$manufacture')";
	mysql_query($query) or die('Error, query failed');
	$messageToUser="Product Manufacture Added Succesfuly.<p>";
	} 
	else
	{
	//Errors exist so building error message
	$manufacture=$_POST['manufacture'];
	if(!empty($errors))
	{
	$error_message.="Please review the feilds with an asterix(*) beside them.<br/>";
	}
	if($rows==1)
	{
	$error_message.="Product Manufacture Exists.";
	}
	}
	}
	else
	{
	$errors=array();
	$manufacture="";
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
	  <legend align="center"><h2>ADD PRODUCT MANUFACTURE</h2></legend>
		<?php include("includes/messageBox.php");?>
		<form id="manufacture_form" name="manufacture_form" method="post" action="">
	    <table align="center">
		  <tr>
            <td><strong>Product Manufacture:</strong></td>
            <td><input name="manufacture" type="text" id="manufacture"/><?php display_error("manufacture",$errors);?></td>
          </tr>
          <tr>
            <td colspan="2" align="center"><input type="submit" name="Submit" value="Add Manufacture" class="btn-style"/></td>
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