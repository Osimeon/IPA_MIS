<?php
include('includes/conn.php');
require_once('includes/auth.php');
include("lib/phpgraphlib.php");
$graph=new PHPGraphLib(900,400);
$dataArray=array();
//get data from database
$sql="SELECT waterpoints.regional_office_id,regional_office.office_name, COUNT(*) AS 'waterpoints.waterpoint_id' FROM waterpoints,regional_office GROUP BY office_name";
$result = mysql_query($sql) or die('Query failed: ' . mysql_error());
if ($result) {
  while ($row = mysql_fetch_assoc($result)) {
      $office_name=$row["office_name"];
      $waterpoint_id=$row["waterpoint_id"];
      //add to data areray
      $dataArray[$office_name]=$waterpoint_id;
  }
} 
//configure graph
$graph->addData($dataArray);
$graph->setTitle("Waterpoints by Programs");
$graph->setGradient("lime", "blue");
$graph->setBarOutlineColor("black");
$graph->createGraph();
$chart->setYAxis("Sales");
?>
<html>
<h3>This is where I want to display my graph</h3>
<img src="index.php" />
</html>