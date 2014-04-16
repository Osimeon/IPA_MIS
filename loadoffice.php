<option value=''>----</option>
<?php 
include('includes/conn.php');
$country_name = $_GET['country_name'];
$query = mysql_query("SELECT * FROM regional_office WHERE country_name='$country_name' ORDER BY office_name");
while($office = mysql_fetch_array($query)) {
echo "<option value='$office[regional_office_id]'>$office[office_name]</option>";
}
?>