<?php error_reporting (E_ALL ^ E_NOTICE); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('includes/conn.php'); ?>
<?php require_once('includes/css_js_links.php'); ?>
<?php require_once('includes/auth.php'); ?>
<?php
$f_country_name = $_GET['country_name'];
$f_regional_office_id = $_GET['regional_office_id'];
$f_district_name = $_GET['district_name'];
$f_sublocation_parish = $_GET['sublocation_parish'];
$f_village = $_GET['village'];
$f_waterpoint_id = $_GET['waterpoint_id'];
$f_waterpoint_name = $_GET['waterpoint_name'];
$f_date_assigned = $_GET['date_assigned'];
$f_user_assigned = $_GET['user_assigned'];
$f_issuetype_id = $_GET['issuetype_id'];
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
	$("#regional_office_id").change(function() {
		$.get('loaddistrict.php?regional_office_id=' + $(this).val(), function(data) {
			$("#district_name").html(data);
			$('#loader').slideUp(200, function() {
				$(this).remove();
			});
		});	
    });
	$("#district_name").change(function() {
		$.get('loadsublocation.php?district_name=' + $(this).val(), function(data) {
			$("#sublocation_parish").html(data);
			$('#loader').slideUp(200, function() {
				$(this).remove();
			});
		});	
    });
	$("#sublocation_parish").change(function() {
		$.get('loadvillage.php?sublocation_parish=' + $(this).val(), function(data) {
			$("#village").html(data);
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
	  <fieldset name="reg_user" id="reg_user">
	  <legend align="center"><h2>ISSUES ASSIGNED BUT NOT SOLVED</h2></legend>
	  <div align="center"><?php include("includes/messageBox.php");?></div>
	  <div style="height:540px; overflow:scroll">
	  	<table class="gridtable" align="center" width="100%">
		<form action="" method="GET">
		  <tr>
			<th>No.</th>
			<th>Regional Office</th>
			<th>District Name</th>
			<th>Sub location/Parish</th>
			<th>Village Name</th>
			<th>Waterpoint Name</th>
			<th>Waterpoint ID</th>
			<th>Date Assigned</th>
			<th>Staff Assigned</th>
			<th>Issue Type</th>
			<th>D.F?</th>
			<th>Solved</th>
			<th colspan="2"></th>
		  </tr>
		<tr>
			<td></td>
			<td><select name="regional_office_id" id="regional_office_id" onkeypress="submitOnEnter(this, event);"><option value="">Select Region</option>
			<?php		 
			$query_office = mysql_query("SELECT * FROM regional_office,program WHERE regional_office.regional_office_id=program.regional_office_id AND program.country_name='$session_country_name' GROUP BY program.regional_office_id ORDER BY office_name") or die("Query failed: ".mysql_error());
			while($office = mysql_fetch_array($query_office)): ?>
			<option value="<?php echo $office['regional_office_id']; ?>"><?php echo $office['office_name']; ?></option>
			<?php endwhile; ?>
			</select></td>
			<td><select name="district_name" id="district_name" onkeypress="submitOnEnter(this, event);"><option value='' selected="selected">Select Region First</option></select></td>
			<td><select name="sublocation_parish" id="sublocation_parish" onkeypress="submitOnEnter(this, event);"></select></td>
			<td><select name="village" id="village" onkeypress="submitOnEnter(this, event);"></select></td>
			<td><input name="waterpoint_name" type="text" id="waterpoint_name" onkeypress="submitOnEnter(this, event);"/></td>
			<td><input name="waterpoint_id" type="text" id="waterpoint_id" onkeypress="submitOnEnter(this, event);"/></td>
			<td><input name="date_assigned" type="text" id="date_assigned" onkeypress="submitOnEnter(this, event);"/></td>
			<td>
			<select name="user_assigned" id="user_assigned" onkeypress="submitOnEnter(this, event);">
			<option value=''></option>
				<?php  
				$result_set=mysql_query("SELECT * FROM  users WHERE regional_office_id='$session_regional_office_id' ORDER BY staff_name ASC");
				while($row=mysql_fetch_array($result_set))
				{
				echo "<option value='{$row['emp_no']}'>{$row['staff_name']}</option>";
				}
				?>
			</select>			</td>
			<td>
			<select name="issuetype_id" id="issuetype_id" onkeypress="submitOnEnter(this, event);">
			<option value=''></option>
				<?php  
				$result_set=mysql_query("SELECT * FROM  issue_type ORDER BY issue_name ASC");
				while($row=mysql_fetch_array($result_set))
				{
				echo "<option value='{$row['issuetype_id']}'>{$row['issue_name']}</option>";
				}
				?>
			</select>			</td>
			<td></td>
			<td></td>
			<td>S</td>
			<td>E</td>
			</tr>
		<?php
		// Get page data
			$sel = "SELECT * FROM issue,waterpoints,program,regional_office,issue_type,users WHERE
			issue.user_assigned !='0' AND 
			issue.solved ='No' AND
			issue.waterpoint_id=waterpoints.waterpoint_id AND 
			issue.issuetype_id=issue_type.issuetype_id AND 
			issue.user_assigned=users.emp_no AND 
			waterpoints.program_code=program.program_code AND
			program.regional_office_id=regional_office.regional_office_id AND
			program.regional_office_id='$f_regional_office_id' AND
			waterpoints.district_name LIKE'%$f_district_name%' AND
			waterpoints.sublocation_parish LIKE'%$f_sublocation_parish%' AND
			waterpoints.village LIKE'%$f_village%' AND
			waterpoints.waterpoint_id LIKE'%$f_waterpoint_id%' AND
			waterpoints.waterpoint_name LIKE'%$f_waterpoint_name%' AND
			issue.date_assigned LIKE'%$f_date_assigned%' AND
			issue.user_assigned LIKE'%$f_user_assigned%' AND
			issue.issuetype_id LIKE'%$f_issuetype_id%'";
			$result=mysql_query($sel);
			$count=mysql_num_rows($result);
			$indexcounter = 1;
			while($rows=mysql_fetch_array($result))
				{
		?>
			<tr >
			<td><?php echo $indexcounter ?></td>
			<td><?php echo $rows['office_name']; ?></td>
			<td><?php echo $rows['district_name']; ?></td>
			<td><?php echo $rows['sublocation_parish']; ?></td>
			<td><?php echo $rows['village']; ?></td>
			<td><?php echo $rows['waterpoint_name']; ?></td>
			<td><?php echo $rows['waterpoint_id']; ?></td>
			<td><?php echo $rows['date_assigned']; ?></td>
			<td><?php echo $rows['staff_name']; ?></td>
			<td><?php echo $rows["issue_name"]; ?></td>
			<td><?php echo $rows["dispenser_functional"]; ?></td>
			<td><?php echo $rows["solved"]; ?></td>
			<td><a href="solve_issue.php?issueid=<?php echo $rows["issueid"]; ?>"><img src='images/solve_issue.jpg ' alt="Solve Issue" width="16" height="16" border="0" /></td>
			<td><a href="edit_issue.php?issueid=<?php echo $rows["issueid"]; ?>&&redirect_link=unsolved_issues.php"><img src='images/edit.png' alt="Edit Issue" width="16" height="16" border="0" /></td>    
		  </tr>
		<?php 
		$indexcounter++;
		} ?>
	    </table>
		<p />
      </div>
	  </fieldset>
	  </td>
    </tr>
  </table>
</body>
</html>