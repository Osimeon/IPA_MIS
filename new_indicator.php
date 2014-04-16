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
	var str = document.getElementById("indicator").value;
    document.getElementById("indicator").value = str.charAt(0).toUpperCase() + str.slice(1);

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
	$required_fields = array('dep_id','indicator','description');
	$errors=check_required_fields($required_fields);

		$query="SELECT * FROM performance_indicators WHERE dep_id = '{$_POST['dep_id']}' AND indicator = '{$_POST['indicator']}' LIMIT 1";
		$check_make=mysql_query($query);
		$rows=mysql_num_rows($check_make);

		if((empty($errors))&&($rows==0))
		{
			$dep_id=$_POST['dep_id'];
			$indicator=$_POST['indicator'];
			$description=$_POST['description'];

			$query = "INSERT INTO performance_indicators (dep_id,indicator,description) ".
	"VALUES ('$dep_id','$indicator','$description')";
	mysql_query($query) or die('Error, query failed');
	$messageToUser="Perfomance Indicator Added Succesfuly.<p>";
	} 
	else
	{
	//Errors exist so building error message
	$dep_id=$_POST['dep_id'];
	$indicator=$_POST['indicator'];
	$description=$_POST['description'];
	if(!empty($errors))
	{
	$error_message.="Please review the feilds with an asterix(*) beside them.<br/>";
	}
	if($rows==1)
	{
	$error_message.="Perfomance Indicator Exists.";
	}
	}
	}
	else
	{
	$errors=array();
	$dep_id="";
	$indicator="";
	$description="";
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
	  <legend align="center"><h2>ADD PERFORMANCE INDICATOR</h2></legend>
		<?php include("includes/messageBox.php");?>
		<form id="make_form" name="make_form" method="post" action="">
	    <table align="center">
		  <tr>
			<td><strong>Department:</strong></td>
			<td>
			<select name="dep_id" id="dep_id">
				<option value=""></option>
				<?php 
				$query_dep = mysql_query("SELECT * FROM department ORDER BY dep_name ASC") or die("Query failed: ".mysql_error());
				while($row = mysql_fetch_array($query_dep)): ?>
				<option value="<?php echo $row['dep_id']; ?>"><?php echo $row['dep_name']; ?></option>
				<?php endwhile; ?>
			</select><?php display_error("dep_id",$errors);?>
			</td>
		  </tr>
		  <tr>
            <td><strong>Indicator Name:</strong></td>
            <td><input name="indicator" type="text" id="indicator" /><?php display_error("indicator",$errors);?></td>
          </tr>
		  <tr>
            <td valign="top"><strong>Description:</strong> <strong>*</strong></td>
            <td><textarea name="description" id="description"></textarea><?php display_error("description",$errors);?></td>
          </tr>
          <tr>
            <td colspan="2" align="center"><input type="submit" name="Submit" value="Add Indicator" class="btn-style"/></td>
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