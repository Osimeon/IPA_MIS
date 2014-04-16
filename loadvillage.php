<option value=''>----</option>
<?php 
include('includes/conn.php');

$sublocation_parish = $_GET['sublocation_parish'];

$query = mysql_query("SELECT * FROM  waterpoints WHERE sublocation_parish = '$sublocation_parish'GROUP BY village ORDER BY village ASC");
while($row = mysql_fetch_array($query)) {
echo "<option value='$row[village]'>$row[village]</option>";
}
?>