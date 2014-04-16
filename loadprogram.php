<option value=''>----</option>
<?php 
include('includes/conn.php');
$regional_office_id = $_GET['regional_office_id'];
$query = mysql_query("SELECT * FROM program WHERE regional_office_id='$regional_office_id' ORDER BY program_code");
while($program = mysql_fetch_array($query)) {
echo "<option value='$program[program_code]'>$program[program_code]</option>";
}
?>