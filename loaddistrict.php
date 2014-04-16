<option value='' selected="selected">----</option>
<?php 
include('includes/conn.php');
$program_code = $_GET['program_code'];
$regional_office_id = $_GET['regional_office_id'];
$query = mysql_query("SELECT * FROM waterpoints,program WHERE waterpoints.program_code=program.program_code AND program.regional_office_id='$regional_office_id' GROUP BY district_name ORDER BY district_name ASC");
while($district = mysql_fetch_array($query)) {
echo "<option value='$district[district_name]'>$district[district_name]</option>";
}
?>