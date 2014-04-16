<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('includes/conn.php'); ?>
<?php require_once('includes/css_js_links.php'); ?>
<?php require_once('includes/auth.php'); ?>
<title><?php require_once('includes/title.php'); ?></title>
<script language="JavaScript" type="text/javascript">
function CloseAndRefresh()
{
opener.location.reload(true);
self.close();
}
</script>
</head>
<body>
<?php
require_once("includes/functions.php");
require_once("includes/form_functions.php");
require_once("includes/messageBox.php");
$date = date("Y-m-d");
$phone_id = $_GET['phone_id'];
//checks if the form has been submited
if(isset($_POST['Submit']))
{
//Check if not empty
$errors=array();
$required_fields = array('extra_battery','staff_no');
$errors=check_required_fields($required_fields);

$query="SELECT * FROM phone_inventory WHERE staff_no = '{$_POST['staff_no']}' AND status !='Returned' LIMIT 1";
$check_staff=mysql_query($query);
$rows=mysql_num_rows($check_staff);


if((empty($errors))&&($rows==0))
{
//Okay so add user
$errors=array();
$memcard_size=mysql_prep($_POST['memcard_size']);
$extra_battery=mysql_prep($_POST['extra_battery']);
$no_of_batteries=mysql_prep($_POST['no_of_batteries']);
$ebattery_serial_nos=mysql_prep($_POST['ebattery_serial_nos']);
$staff_no=mysql_prep($_POST['staff_no']);

$sql="UPDATE phone_inventory SET memcard_size = '$memcard_size', extra_battery='$extra_battery',no_of_batteries='$no_of_batteries',ebattery_serial_nos='$ebattery_serial_nos',staff_no='$staff_no',date_issued='$date',status='In Possession' WHERE phone_id=$phone_id" ;
$result = mysql_query($sql) or die(mysql_error());
$messageToUser="Phone Issued Successfully!";
}
else
{
//Errors exist so building error message
$extra_battery=$_POST['extra_battery'];
$staff_no=$_POST['staff_no'];

$error_message="<strong>Please review the following errors.</strong><br/>";
if(!empty($errors))
{
$error_message.="Please review the fields with an aster-ix(*) beside them.<br/>";
}
if($rows==1)
{
$error_message.="Staff has already been Issued with Another Phone.";
}

}
}
else
{
$errors=array();
$extra_battery="";
$staff_no="";
}
?>
	  <fieldset name="reg_user" id="reg_user">
	  <legend align="center"><h2>ASSIGN PHONE TO STAFF</h2></legend>
		<?php include("includes/messageBox.php");?>
		<form id="issuephone_form" name="issuephone_form" method="post" action="">
			<table cellspacing="3" align="center">		
			  <tr>
				<td><strong>Staff Name: </strong></td>
				<td>
				<select name="staff_no" id="staff_no">
						<option value=""></option>
						<?php		 
						$query = mysql_query("SELECT * FROM  users WHERE country_name='$session_country_name' ORDER BY staff_name ASC") or die("Query failed: ".mysql_error());
						while($staffassigned = mysql_fetch_array($query)): ?>
						<option value="<?php echo $staffassigned['emp_no']; ?>"><?php echo $staffassigned['staff_name']; ?></option>
						<?php endwhile; ?>
						</select><?php display_error("staff_no",$errors);?>
				</td>
			  </tr>
			  <tr>
				<td><strong>Memory Card Size: </strong></td>
				<td><input name="memcard_size" type="text" id="memcard_size" placeholder="E.g 4GB"/></td>
			  </tr>
			  <tr>
				<td><strong>Extra Battery: </strong></td>
				<td>
					<label><input type="radio" name="extra_battery" value="No" />No</label>
					<label><input type="radio" name="extra_battery" value="Yes" />Yes</label>
					<?php display_error("extra_battery",$errors);?>
				</td>
			  </tr>
			  <tr>
				<td><strong>No of Batteries:</strong> </td>
				<td><input name="no_of_batteries" type="text" id="no_of_batteries" /></td>
			  </tr>
			  <tr>
				<td valign="top"><strong>Extra Battery(s) SNs:</strong></td>
				<td><textarea name="ebattery_serial_nos" id="ebattery_serial_nos" placeholder="E.g.1234567890,0987654321"></textarea></td>
			  </tr
			  <tr>
				<td colspan="2" align="center"><input type="submit" name="Submit" value="Issue Phone" class="btn-style" onClick="CloseAndRefresh(); return:true;"/><input type="button" value="Exit Window" class="btn-style" onClick="CloseAndRefresh();"></td>
			  </tr>
			</table>
		</form>
	  </fieldset>
</body>
</html>