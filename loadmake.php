<option value=''>----</option>
<?php 
include('includes/conn.php');

$manufacture_id = $_GET['manufacture_id'];

$query = mysql_query("SELECT * FROM  make WHERE manufacture_id = '$manufacture_id' ORDER BY make_name ASC");
while($row = mysql_fetch_array($query)) {
echo "<option value='$row[make_id]'>$row[make_name]</option>";
}
?>