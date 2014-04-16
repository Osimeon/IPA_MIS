<option value=''>----</option>
<?php 
include('includes/conn.php');

$village = $_GET['village'];

$query = mysql_query("SELECT * FROM  waterpoints WHERE village = '$village' ORDER BY waterpoint_name ASC");
while($row = mysql_fetch_array($query)) {
echo "<option value='$row[waterpoint_id]'>$row[waterpoint_name]</option>";
}
?>