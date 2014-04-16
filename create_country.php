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
	$required_fields = array('country_code','country_name','tel_code');
	$errors=check_required_fields($required_fields);

		$query="SELECT * FROM country WHERE country_code = '{$_POST['country_code']}' AND country_name = '{$_POST['country_name']}' LIMIT 1";
		$check_country=mysql_query($query);
		$rows=mysql_num_rows($check_country);

		if((empty($errors))&&($rows==0))
		{
			$country_code=$_POST['country_code'];
			$country_name=$_POST['country_name'];
			$tel_code=$_POST['tel_code'];
			
			
			$query = "INSERT INTO country (country_code,country_name,tel_code) ".
	"VALUES ('$country_code','$country_name','$tel_code')";
	mysql_query($query) or die('Error, query failed');
	$messageToUser="Country $country_name. Has Been Registered Succesfuly.<p>";
	} 
	else
	{
	//Errors exist so building error message
	$country_code=$_POST['country_code'];
	$country_name=$_POST['country_name'];
	$tel_code=$_POST['tel_code'];
	
	if(!empty($errors))
	{
	$error_message.="Please review the feilds with an asterix(*) beside them.<br/>";
	}
	if($rows==1)
	{
	$error_message.="Country Exists.";
	}
	}
	}
	else
	{
	$errors=array();
	$country_code="";
	$country_name="";
	$tel_code="";
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
	  <legend align="center"><h2>ADD NEW COUNTRY</h2></legend>
		<?php include("includes/messageBox.php");?>
		<form id="reg_form" name="reg_form" method="post" action="">
	    <table align="center">
          <tr>
            <td><strong>Country Code:</strong> <strong>*</strong></td>
            <td><input name="country_code" type="text" id="country_code" /><?php display_error("country_code",$errors);?></td>
          </tr>
		  <tr>
            <td><strong>Country :</strong> <strong>*</strong></td>
            <td><input name="country_name" type="text" id="country_name" onkeydown = "capitaliseName()" autocomplete="off"/><?php display_error("country_name",$errors);?></td>
          </tr>
		  <tr>
            <td><strong>Mobile Code:</strong> <strong>*</strong></td>
            <td><input name="tel_code" type="text" id="tel_code" placeholder="+254"/><?php display_error("tel_code",$errors);?></td>
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