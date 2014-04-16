<option value=''>----</option>
<?php 
include('includes/conn.php');

$district_name = $_GET['district_name'];

$query = mysql_query("SELECT * FROM  waterpoints WHERE district_name = '$district_name' GROUP BY sublocation_parish ORDER BY sublocation_parish ASC");
while($row = mysql_fetch_array($query)) {
echo "<option value='$row[sublocation_parish]'>$row[sublocation_parish]</option>";
}
?>