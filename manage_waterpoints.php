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
$f_program_code = $_GET['program_code'];
$f_district_name = $_GET['district_name'];
$f_sublocation_parish = $_GET['sublocation_parish'];
$f_village = $_GET['village'];
$f_waterpoint_name = $_GET['waterpoint_name'];
$f_waterpoint_id = $_GET['waterpoint_id'];
$f_installation_date = $_GET['installation_date'];
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
	$("#country_name").change(function() {
		$.get('loadoffice.php?country_name=' + $(this).val(), function(data) {
			$("#regional_office_id").html(data);
			$('#loader').slideUp(200, function() {
				$(this).remove();
			});
		});	
    });
	$("#regional_office_id").change(function() {
		$.get('loadprogram.php?regional_office_id=' + $(this).val(), function(data) {
			$("#program_code").html(data);
			$('#loader').slideUp(200, function() {
				$(this).remove();
			});
		});	
    });
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
</head>
<body>
<div>
  <div align="center"><strong>WATERPOINT LIST  </strong></div><hr  />
  <div style="height:520px; width:100%; overflow:scroll; margin:0 auto;">
	  	<table class="gridtable" align="center" width="100%">
		<form action="" method="GET">
		  <tr>
		  <td></td>
			<td>
			<select name="country_name" id="country_name" onkeypress="submitOnEnter(this, event);">
			<option value="<?php echo $session_country_name; ?>">----</option>
			<?php		 
			$query_country = mysql_query("SELECT * FROM program GROUP BY country_name ORDER BY country_name ASC") or die("Query failed: ".mysql_error());
			while($countries = mysql_fetch_array($query_country)): ?>
			<option value="<?php echo $countries['country_name']; ?>"><?php echo $countries['country_name']; ?></option>
			<?php endwhile; ?>
			</select>
			</td>
			<td>
			<select name="regional_office_id" id="regional_office_id" onkeypress="submitOnEnter(this, event);"></select>
			</td>
			<td>
			<select name="program_code" id="program_code" onkeypress="submitOnEnter(this, event);"></select>
			</td>
			<td>
			<select name="district_name" id="district_name" onkeypress="submitOnEnter(this, event);"></select>
			</td>
			<td>
			<select name="sublocation_parish" id="sublocation_parish" onkeypress="submitOnEnter(this, event);"></select>
			</td>
			<td>
			<select name="village" id="village" onkeypress="submitOnEnter(this, event);"></select>
			</td>
			<td>
			<input name="waterpoint_name" type="text" id="waterpoint_name" placeholder="Optional" onkeypress="submitOnEnter(this, event);"/>
			</td>
			<td>
			<input name="waterpoint_id" type="text" id="waterpoint_id" placeholder="Optional" onkeypress="submitOnEnter(this, event);"/>
			</td>
			<td>
			<input name="installation_date" type="text" id="installation_date" placeholder="Optional" onkeypress="submitOnEnter(this, event);"/>
			</td>
		  </tr>		
		  <tr>
			<th>No.</th>
			<th>Country</th>
			<th>Regional Office</th>
			<th>Program Code</th>
			<th>District Name</th>
			<th>Sub location/Parish</th>
			<th>Village Name</th>
			<th>Waterpoint Name</th>
			<th>Waterpoint ID</th>
			<th>Install Date</th>
		  </tr>
		<?php
		// Get page data
			$sel = "SELECT * FROM waterpoints,program,regional_office WHERE
			waterpoints.program_code=program.program_code AND program.regional_office_id=regional_office.regional_office_id AND 			 
			program.country_name ='$f_country_name' AND 
			program.program_code LIKE'%$f_program_code%' AND
			program.regional_office_id LIKE'%$f_regional_office_id%' AND
			district_name LIKE'%$f_district_name%' AND
			sublocation_parish LIKE'%$f_sublocation_parish%' AND
			village LIKE'%$f_village%' AND 
			waterpoint_name LIKE'%$f_waterpoint_name%' AND
			waterpoint_id LIKE'%$f_waterpoint_id%' AND
			installation_date LIKE'%$f_installation_date%'
			ORDER BY waterpoint_id ASC";
			$result=mysql_query($sel);
			$count=mysql_num_rows($result);
			$indexcounter = 1;
			while($rows=mysql_fetch_array($result)){
				?>
				<tr >
					<td><?php echo $indexcounter ?></td>
					<td><?php echo $rows["country_name"]; ?></td>
					<td><?php echo $rows["office_name"]; ?></td> 
					<td><?php echo $rows["program_code"]; ?></td> 			
					<td><?php echo $rows['district_name']; ?></td>
					<td><?php echo $rows['sublocation_parish']; ?></td>
					<td><?php echo $rows['village']; ?></td>
					<td><?php echo $rows['waterpoint_name']; ?></td>
					<td><?php echo $rows["waterpoint_id"]; ?></td>
					<td><?php echo $rows["installation_date"]; ?></td>
		  </tr>
				<?php 
				$indexcounter++;
			} 
			?>
	    </table>
		</form>
		<p />
  </div>
</div>
</body>
</html>