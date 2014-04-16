<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('includes/conn.php'); ?>
<?php require_once('includes/css_js_links.php'); ?>
<?php require_once('includes/auth.php'); ?>
<title><?php require_once('includes/title.php'); ?></title>
</head>
<body>
<script type="text/javascript">
$(document).ready(function() {
    $("#manufacture_id").change(function() {
		$.get('loadmake.php?manufacture_id=' + $(this).val(), function(data) {
			$("#make_id").html(data);
			$('#loader').slideUp(200, function() {
				$(this).remove();
			});
		});	
    });
});
</script>
<?php
require_once("includes/functions.php");
require_once("includes/form_functions.php");
require_once("includes/messageBox.php");
$date = date("Y-m-d");
//checks if the form has been submited
if(isset($_POST['Submit']))
{
//Check if not empty
$errors=array();
$required_fields = array('serial_no','ime_no','battery_serial_no','manufacture_id','make_id');
$errors=check_required_fields($required_fields);

$query="SELECT * FROM phone_inventory WHERE serial_no = '{$_POST['serial_no']}' AND ime_no = '{$_POST['ime_no']}' AND manufacture_id = '{$_POST['manufacture_id']}' AND make_id = '{$_POST['make_id']}' LIMIT 1";
$check_phone=mysql_query($query);
$rows=mysql_num_rows($check_phone);


if((empty($errors))&&($rows==0))
{
//Okay so add user
$errors=array();
$serial_no=mysql_prep($_POST['serial_no']);
$ime_no=mysql_prep($_POST['ime_no']);
$battery_serial_no=mysql_prep($_POST['battery_serial_no']);
$manufacture_id=mysql_prep($_POST['manufacture_id']);
$make_id=mysql_prep($_POST['make_id']);

$query="INSERT INTO phone_inventory (serial_no,ime_no,battery_serial_no,manufacture_id,make_id,purchase_date,status) 
VALUES ('{$serial_no}','{$ime_no}','{$battery_serial_no}','{$manufacture_id}','{$make_id}','{$date}','In Store')";
$register=get_result_set($query);
$messageToUser="Phone Added to Store Successfully!";
}
else
{
//Errors exist so building error message
$serial_no=$_POST['serial_no'];
$ime_no=$_POST['ime_no'];
$battery_serial_no=$_POST['battery_serial_no'];
$manufacture_id=$_POST['manufacture_id'];
$make_id=$_POST['make_id'];

$error_message="<strong>Please review the following errors.</strong><br/>";
if(!empty($errors))
{
$error_message.="Please review the feilds with an asterix(*) beside them.<br/>";
}
if($rows==1)
{
$error_message.="Phone With Same Serial No & IME No Exists in Store.";
}

}
}
else
{
$errors=array();
$serial_no="";
$ime_no="";
$battery_serial_no="";
$manufacture_id="";
$make_id="";
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
	  <legend align="center"><h2>ADD NEW PHONE</h2></legend>
		<?php include("includes/messageBox.php");?>
		<form id="issuephone_form" name="issuephone_form" method="post" action="">
	    <table width="50%" cellspacing="3" align="center">
  <tr>
    <td><strong>Serial Number : </strong></td>
    <td><input name="serial_no" type="text" id="serial_no" /><?php display_error("serial_no",$errors);?></td>
  </tr>
  <tr>
    <td><strong>IME Number: </strong></td>
    <td><input name="ime_no" type="text" id="ime_no" /><?php display_error("ime_no",$errors);?></td>
  </tr>
  <tr>
    <td><strong>Battery Serial No: </strong></td>
    <td><input name="battery_serial_no" type="text" id="battery_serial_no" /><?php display_error("battery_serial_no",$errors);?></td>
  </tr>
 <tr>
	<td><strong>Manufacture:</strong></td>
	<td>
		<select name="manufacture_id" id="manufacture_id">
			<option value=""></option>
				<?php 
				$query_manufacture = mysql_query("SELECT * FROM manufacture ORDER BY manufacture ASC") or die("Query failed: ".mysql_error());
				while($row = mysql_fetch_array($query_manufacture)): ?>
				<option value="<?php echo $row['manufacture_id']; ?>"><?php echo $row['manufacture']; ?></option>
				<?php endwhile; ?>
		</select><?php display_error("manufacture_id",$errors);?>
	</td>
  </tr>
  <tr>
    <td><strong>Make:</strong></td>
    <td><select name="make_id" id="make_id"></select><?php display_error("make_id",$errors);?></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="submit" name="Submit" value="Submit Record" class="btn-style"/></td>
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