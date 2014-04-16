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
//Update Phone Details
$phone_id = $_GET['phone_id'];
if(isset($_POST['Submit'])){
	$memory_card = $_POST['memory_card'];
	$memcard_size = $_POST['memcard_size'];
	$extra_battery = $_POST['extra_battery'];
	$no_of_batteries = $_POST['no_of_batteries'];
	$ebattery_serial_nos = $_POST['ebattery_serial_nos'];
	$staff_no = $_POST['staff_no'];
	$status = $_POST['status'];
	$comments = $_POST['comments'];	
	mysql_query("UPDATE phone_inventory SET
	memory_card ='$memory_card',
	memcard_size ='$memcard_size',
	extra_battery ='$extra_battery',
	no_of_batteries ='$no_of_batteries',
	ebattery_serial_nos ='$ebattery_serial_nos',
	staff_no ='$staff_no',
	status ='$status',
	comments ='$comments' WHERE phone_id = '$phone_id'")or die(mysql_error());
	$messageToUser="Record Updated Successfully!";			
}
?>
    <table class="container">
    <tr>
      <td colspan="3">
		<fieldset name="reg_user" id="reg_user">
		<legend align="center"><h2>EDIT PHONE DETAILS</h2></legend>
		<form id="edit_phone_details" name="edit_phone_details" method="POST" action="">
		<table width="100%" cellspacing="3" align="center">
			<?php
				// Get page data
				$sel = "SELECT * FROM phone_inventory,manufacture,make,users WHERE phone_inventory.manufacture_id=manufacture.manufacture_id AND phone_inventory.make_id=make.make_id AND phone_inventory.staff_no=users.emp_no AND phone_id='$phone_id'";
				$result = mysql_query ($sel);
				while ($row = mysql_fetch_assoc($result)){
			?>
		    <tr>
			<td><strong>Issue Memory Card: </strong></td>
			<td>
				<select name="memory_card" id="memory_card">
				<option value="<?php echo $row['memory_card']; ?>"><?php echo $row['memory_card']; ?></option>
				<option value="No">No</option>
				<option value="Yes">Yes</option>
			</td>
		  </tr>
		  <tr>
			<td><strong>Card Size: </strong></td>
			<td><input name="memcard_size" type="text" id="memcard_size" value="<?php echo $row['memcard_size']; ?>" placeholder="E.g 4GB"/></td>
		  </tr>
		  <tr>
			<td><strong>Issue Extra Battery(s): </strong></td>
			<td>
				<select name="extra_battery" id="extra_battery">
				<option value="<?php echo $row['extra_battery']; ?>"><?php echo $row['extra_battery']; ?></option>
				<option value="No">No</option>
				<option value="Yes">Yes</option>
			</select>
			</td>
		  </tr>
		  <tr>
			<td><strong>No of Batteries:</strong> </td>
			<td><input name="no_of_batteries" type="text" id="no_of_batteries" value="<?php echo $row['no_of_batteries']; ?>"/></td>
		  </tr>
		  <tr>
			<td valign="top"><strong>Extra Battery(s) SNs:</strong></td>
			<td><textarea name="ebattery_serial_nos" id="ebattery_serial_nos" placeholder="E.g.1234567890,0987654321"><?php echo $row['ebattery_serial_nos']; ?></textarea></td>
		  </tr>
		  <tr>
			<td><strong>Staff Name: </strong></td>
			<td>
			<select name="staff_no" id="staff_no">
					<option value="<?php echo $row['staff_no']; ?>"><?php echo $row['staff_name']; ?></option>
					<?php		 
					$query = mysql_query("SELECT * FROM  users WHERE country_name='$session_country_name' ORDER BY staff_name ASC") or die("Query failed: ".mysql_error());
					while($staffassigned = mysql_fetch_array($query)): ?>
					<option value="<?php echo $staffassigned['emp_no']; ?>"><?php echo $staffassigned['staff_name']; ?></option>
					<?php endwhile; ?>
					</select>
			</td>
		  </tr>
		  <tr>
			<td valign="top"><strong>Status:</strong></td>
			<td>
			<select name="status" id="status">
				<option value="<?php echo $row['status']; ?>"><?php echo $row['status']; ?></option>
				<option value="In Possession">In Possession</option>
				<option value="Lost">Lost</option>
				<option value="Spoilt">Spoilt</option>
				<option value="Returned">Returned</option>
			</select>
			</td>
		  </tr>
		  <tr>
			<td valign="top"><strong>Comments:</strong></td>
			<td><textarea name="comments" id="comments"><?php echo $row['comments']; ?></textarea></td>
		  </tr>
		  <?php 
		  } ?>
		  <tr>
			<td colspan="2" align="center"><input type="submit" name="Submit" value="Update Record" class="btn-style" onClick="CloseAndRefresh(); return:true;"/><input type="button" value="Exit Window" class="btn-style" onClick="CloseAndRefresh();"></td>
		  </tr>
		</table>
		</form>
		</fieldset>
	  </td>
    </tr>
  </table>
</body>
</html>