<?php error_reporting (E_ALL ^ E_NOTICE); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('includes/conn.php'); ?>
<?php require_once('includes/css_js_links.php'); ?>
<?php require_once('includes/auth.php'); ?>
<?php
$f_country_code = $_GET['country_code'];
$f_regional_office_id = $_GET['regional_office_id'];
$f_ime_no = $_GET['ime_no'];
$f_manufacture_id = $_GET['manufacture_id'];
$f_make_id = $_GET['make_id'];
$f_emp_no = $_GET['emp_no'];
$f_date_issued = $_GET['date_issued'];
$f_status = $_GET['status'];

//Update Checked Check Boxes
$user_assigned = $_GET['user_assigned'];
if(isset($_GET['checkbox'])){$checkbox = $_GET['checkbox'];
if(isset($_GET['Submit']))
$phone_id = "('" . implode( "','", $checkbox ) . "');" ;
$sql="UPDATE issue SET user_assigned = '$user_assigned', date_assigned='$date' WHERE phone_id IN $phone_id" ;
$result = mysql_query($sql) or die(mysql_error());
header("Location: unassigned_issues.php?country_code=$session_country_code");
}
?>
<title><?php require_once('includes/title.php'); ?></title>
<script type="text/javascript">  
    function submitOnEnter(inputElement, event) {  
        if (event.keyCode == 13) { // No need to do browser specific checks. It is always 13.  
            inputElement.form.submit();  
        }  
    }  
</script>
<script type="text/javascript">
$(document).ready(function() {
	$("#country_code").change(function() {
		$.get('loadoffice.php?country_code=' + $(this).val(), function(data) {
			$("#regional_office_id").html(data);
			$('#loader').slideUp(200, function() {
				$(this).remove();
			});
		});	
    });
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
<script type="text/javascript">
function un_check(){
for (var i = 0; i < document.frmactive.elements.length; i++) {
var e = document.frmactive.elements[i];
if ((e.name != 'allbox') && (e.type == 'checkbox')) {
e.checked = document.frmactive.allbox.checked;
}}}
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
	  <legend align="center"><h2>PHONE LIST</h2></legend>
	  <div align="center">
	    <?php include("includes/messageBox.php");?>
	    </div>
	  <div style="height:530px; overflow:scroll">
		<form action="" method="GET">
	  	<table class="gridtable" align="center" width="100%">
		<tr><td colspan="9">
		<div>
		<strong>Country: </strong>
		<select name="country_code" id="country_code" onkeypress="submitOnEnter(this, event);">
		<option value="">----</option>
			<?php		 
			$query_country = mysql_query("SELECT * FROM country ORDER BY country ASC") or die("Query failed: ".mysql_error());
			while($country = mysql_fetch_array($query_country)): ?>
			<option value="<?php echo $country['country_code']; ?>"><?php echo $country['country']; ?></option>
			<?php endwhile; ?>
		</select>
		<strong>Office: </strong>		
		<select name="regional_office_id" id="regional_office_id" onkeypress="submitOnEnter(this, event);"></select>
		<p /></div>
		</td></tr>
		  <tr>
			<th>ID</th>
			<th>IME No</th>
			<th>Manufacture</th>
			<th>Make</th>
			<th>Staff Name</th>
			<th>Date Issued</th>
			<th>Status</th>
			<th></th>
			<th></th>
		  </tr>
		<tr>
			<td></td>
			<td><input name="ime_no" type="text" id="ime_no" onkeypress="submitOnEnter(this, event);"/></td>
			<td>
			<select name="manufacture_id" id="manufacture_id" onkeypress="submitOnEnter(this, event);">
			<option value="">----</option>
				<?php 
					$query_manufacture = mysql_query("SELECT * FROM manufacture ORDER BY manufacture ASC") or die("Query failed: ".mysql_error());
					while($row = mysql_fetch_array($query_manufacture)): ?>
					<option value="<?php echo $row['manufacture_id']; ?>"><?php echo $row['manufacture']; ?></option>
					<?php endwhile; ?>
			</select>
			</td>
			<td>
			<select name="make_id" id="make_id" onkeypress="submitOnEnter(this, event);"></select>
			</td>
			<td>
			<select name="emp_no" id="emp_no" onkeypress="submitOnEnter(this, event);">
			<option value="">----</option>
				<?php 
					$query_staff = mysql_query("SELECT * FROM users WHERE country_code='$session_country_code' ORDER BY staff_name ASC") or die("Query failed: ".mysql_error());
					while($row = mysql_fetch_array($query_staff)): ?>
					<option value="<?php echo $row['emp_no']; ?>"><?php echo $row['staff_name']; ?></option>
					<?php endwhile; ?>
			</select>
			</td>
			<td><input name="date_issued" type="text" id="date_issued" onkeypress="submitOnEnter(this, event);"/></td>
			<td>
			<select name="status" id="status" onkeypress="submitOnEnter(this, event);">
			<option value="">----</option>
				<?php 
					$query_status = mysql_query("SELECT status FROM phone_inventory GROUP BY status ORDER BY status ASC") or die("Query failed: ".mysql_error());
					while($row = mysql_fetch_array($query_status)): ?>
					<option value="<?php echo $row['status']; ?>"><?php echo $row['status']; ?></option>
					<?php endwhile; ?>
			</select>
			</td>
			<td></td>
			<td></td>
			</tr>
		<?php
		// Get page data
			$sel = "SELECT * FROM phone_inventory,make,manufacture,users,regional_office,country WHERE
			phone_inventory.make_id =make.make_id AND 
			make.manufacture_id=manufacture.manufacture_id AND
			phone_inventory.emp_no=users.emp_no AND
			users.regional_office_id=regional_office.regional_office_id AND
			users.country_code=country.country_code AND
			phone_inventory.ime_no LIKE'%$f_ime_no%' AND 
			phone_inventory.manufacture_id LIKE'%$f_manufacture_id%' AND
			phone_inventory.make_id LIKE'%$f_make_id%' AND
			phone_inventory.emp_no LIKE'%$f_emp_no%' AND
			phone_inventory.date_issued LIKE'%$f_date_issued%' AND
			phone_inventory.status LIKE'%$f_status%' AND
			users.country_code LIKE'%$f_country_code%' AND
			users.regional_office_id LIKE'%$f_regional_office_id%'";
			$result=mysql_query($sel);
			$count=mysql_num_rows($result);
			while($rows=mysql_fetch_array($result))
				{
		?>
			<tr >
			<td><?php echo $rows['phone_id']; ?></td>
			<td><?php echo $rows['ime_no']; ?></td>
			<td><?php echo $rows['manufacture']; ?></td>
			<td><?php echo $rows['make_name']; ?></td>
			<td><?php echo $rows['staff_name']; ?></td>
			<td><?php echo $rows["date_issued"]; ?></td>
			<td><?php echo $rows["status"]; ?></td>
			<td><a href="view_phone_details.php?phone_id=<?php echo $rows["phone_id"]; ?>"><img src='images/view.jpg ' alt="View" width="16" height="16" border="0" /></td>
			<td><a href="edit_phone_details.php?phone_id=<?php echo $rows["phone_id"]; ?>"><img src='images/edit.png ' alt="Edit" width="16" height="16" border="0" /></td>   
		  </tr>
		<?php 
		} ?>
	    </table>
		</form>
		<p />
      </div>
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