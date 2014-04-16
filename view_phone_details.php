<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('includes/conn.php'); ?>
<?php require_once('includes/css_js_links.php'); ?>
<?php require_once('includes/auth.php'); ?>
<title><?php require_once('includes/title.php'); ?></title>
</head>
<body>
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
		<legend align="center"><h2>PHONE DETAILS</h2></legend>
		<table width="40%" cellspacing="3" align="center">
			<?php
				// Get page data
				$phone_id = $_GET['phone_id'];
				$sel = "SELECT * FROM phone_inventory,manufacture,make,users WHERE phone_inventory.manufacture_id=manufacture.manufacture_id AND phone_inventory.make_id=make.make_id AND phone_inventory.emp_no=users.emp_no AND phone_id='$phone_id'";
				$result = mysql_query ($sel);
				while ($row = mysql_fetch_assoc($result)){
			?>
		  <tr>
			<td><strong>Serial Number : </strong></td>
			<td><?php echo $row['serial_no']; ?></td>
		  </tr>
		  <tr>
			<td><strong>IME Number: </strong></td>
			<td><?php echo $row['ime_no']; ?></td>
		  </tr>
		  <tr>
			<td><strong>Battery Serial No: </strong></td>
			<td><?php echo $row['battery_serial_no']; ?></td>
		  </tr>
		 <tr>
			<td><strong>Manufacture:</strong></td>
			<td><?php echo $row['manufacture']; ?></td>
		  </tr>
		  <tr>
			<td><strong>Make:</strong></td>
			<td><?php echo $row['make_name']; ?></td>
		  </tr>
		  <tr>
			<td><strong>Date Issued: </strong></td>
			<td><?php echo $row['date_issued']; ?></td>
		  </tr>
		  <tr>
			<td><strong>Memory Card: </strong></td>
			<td><?php echo $row['memory_card']; ?></td>
		  </tr>
		  <tr>
			<td><strong>Card Size: </strong></td>
			<td><?php echo $row['memcard_size']; ?></td>
		  </tr>
		  <tr>
			<td><strong>Extra Battery: </strong></td>
			<td><?php echo $row['extra_battery']; ?></td>
		  </tr>
		  <tr>
			<td><strong>No of Batteries:</strong> </td>
			<td><?php echo $row['no_of_batteries']; ?></td>
		  </tr>
		  <tr>
			<td valign="top"><strong>Extra Battery(s) SNs:</strong></td>
			<td><?php echo $row['ebattery_serial_nos']; ?></td>
		  </tr>
		  <tr>
			<td><strong>Staff Name: </strong></td>
			<td><?php echo $row['staff_name']; ?></td>
		  </tr>
		  <tr>
			<td valign="top"><strong>Status:</strong></td>
			<td><?php echo $row['status']; ?></td>
		  </tr>
		  <tr>
			<td valign="top"><strong>Comments:</strong></td>
			<td><?php echo $row['comments']; ?></td>
		  </tr>
		  <?php 
		  } ?>
		</table>
		<div align="right"><a href="phone_list.php">BACK
	    </a> </div>
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