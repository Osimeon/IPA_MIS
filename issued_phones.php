<?php error_reporting (E_ALL ^ E_NOTICE); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('includes/conn.php'); ?>
<?php require_once('includes/css_js_links.php'); ?>
<?php require_once('includes/auth.php'); ?>
<title><?php require_once('includes/title.php'); ?></title>
<script type="text/javascript">  
    function submitOnEnter(inputElement, event) {  
        if (event.keyCode == 13) { // No need to do browser specific checks. It is always 13.  
            inputElement.form.submit();  
        }  
    }  
</script>
<script type="text/javascript">
function un_check(){
for (var i = 0; i < document.frmactive.elements.length; i++) {
var e = document.frmactive.elements[i];
if ((e.name != 'allbox') && (e.type == 'checkbox')) {
e.checked = document.frmactive.allbox.checked;
}}}
</script>
<script type="text/javascript">

function popup(){
  cuteLittleWindow = window.open("update_issue_phone.php", "littleWindow", "location=no,width=320,height=200"); 
}

</script>
<style type="text/css">
<!--
.style1 {color: #FE1407}
-->
</style>
</head>
<body>
    <table class="container">
    <tr>
      <td colspan="3">
	  <fieldset name="reg_user" id="reg_user">
	  <legend align="center"><h2>ISSUED PHONES LIST</h2></legend>
	  <div align="center">
	    <?php include("includes/messageBox.php");?>
	    </div>
	  <div style="height:520px; overflow:scroll">
	  	<table class="gridtable" align="center" width="100%">
		  <tr>
			<th>No.</th>
			<th>Phone Serial No</th>
			<th>IME No</th>
			<th>Battery Serial No</th>
			<th>Manufacture</th>
			<th>Make</th>
			<th>Purchase Date</th>
			<th>Date Issued</th>
			<th>Staff Name</th>
			<th>Staff No</th>
			<th>Status</th>
			<th></th>
		  </tr>
		<?php
		// Get page data
			$sel = "SELECT * FROM phone_inventory,make,manufacture,users WHERE
			phone_inventory.status ='In Possession' AND 
			phone_inventory.make_id =make.make_id AND
			phone_inventory.staff_no =users.emp_no AND			
			make.manufacture_id=manufacture.manufacture_id ORDER BY date_issued DESC";
			$result=mysql_query($sel);
			$count=mysql_num_rows($result);
			$indexcounter = 1;
			while($rows=mysql_fetch_array($result))
				{
		?>
			<tr >
			<td><?php echo $indexcounter ?></td>
			<td><?php echo $rows['serial_no']; ?></td>
			<td><?php echo $rows['ime_no']; ?></td>
			<td><?php echo $rows['battery_serial_no']; ?></td>
			<td><?php echo $rows['manufacture']; ?></td>
			<td><?php echo $rows['make_name']; ?></td>
			<td><?php echo $rows['purchase_date']; ?></td>
			<td><?php echo $rows['date_issued']; ?></td>
			<td><?php echo $rows['staff_name']; ?></td>
			<td><?php echo $rows['emp_no']; ?></td>
			<td><?php echo $rows["status"]; ?></td>
			<td><a href="edit_phone_details.php?phone_id=<?php echo $rows["phone_id"]; ?>" onclick="javascript:void window.open('edit_phone_details.php?phone_id=<?php echo $rows["phone_id"]; ?>','1390461620844','width=400,height=350,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,left=450,top=50');return false;"><img border='0' src='images/edit.png' width='16' height='16' /></a></td>			
		  </tr>
		<?php 
		$indexcounter++;
		} ?>
	    </table>
      </div>
		<p />
	  </fieldset>
	  </td>
    </tr>
  </table>
</body>
</html>