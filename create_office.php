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
	var str = document.getElementById("office_name").value;
    document.getElementById("office_name").value = str.charAt(0).toUpperCase() + str.slice(1);

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
	$required_fields = array('country_name','office_name');
	$errors=check_required_fields($required_fields);

		$query="SELECT * FROM regional_office WHERE country_name = '{$_POST['country_name']}' AND office_name = '{$_POST['office_name']}' LIMIT 1";
		$check_make=mysql_query($query);
		$rows=mysql_num_rows($check_make);

		if((empty($errors))&&($rows==0))
		{
			$country_name=$_POST['country_name'];
			$office_name=$_POST['office_name'];

			$query = "INSERT INTO regional_office (country_name,office_name) ".
	"VALUES ('$country_name','$office_name')";
	mysql_query($query) or die('Error, query failed');
	$messageToUser="Office Added Succesfuly.<p>";
	} 
	else
	{
	//Errors exist so building error message
	$country_name=$_POST['country_name'];
	$office_name=$_POST['office_name'];
	if(!empty($errors))
	{
	$error_message.="Please review the feilds with an asterix(*) beside them.<br/>";
	}
	if($rows==1)
	{
	$error_message.="Similar Office Name Exists.";
	}
	}
	}
	else
	{
	$errors=array();
	$country_name="";
	$office_name="";
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
	  <legend align="center"><h2>ADD NEW OFFICE</h2></legend>
		<?php include("includes/messageBox.php");?>
		<form id="make_form" name="make_form" method="post" action="">
	    <table align="center">
		  <tr>
			<td><strong>Country:</strong></td>
			<td>
			<select name="country_name" id="country_name">
				<option value=""></option>
				<?php 
				$query_country = mysql_query("SELECT * FROM country ORDER BY country_name ASC") or die("Query failed: ".mysql_error());
				while($row = mysql_fetch_array($query_country)): ?>
				<option value="<?php echo $row['country_name']; ?>"><?php echo $row['country_name']; ?></option>
				<?php endwhile; ?>
			</select><?php display_error("country_name",$errors);?>
			</td>
		  </tr>
		  <tr>
            <td><strong>Office Name:</strong></td>
            <td><input name="office_name" type="text" id="office_name" /><?php display_error("office_name",$errors);?></td>
          </tr>
          <tr>
            <td colspan="2" align="center"><input type="submit" name="Submit" value="Add New Office" class="btn-style"/></td>
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