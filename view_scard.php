<?php error_reporting (E_ALL ^ E_NOTICE); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('includes/conn.php'); ?>
<?php require_once('includes/css_js_links.php'); ?>
<?php require_once('includes/auth.php'); ?>
<title><?php require_once('includes/title.php'); ?></title>
</head>
<body>
	<?php
	$perf_period_id = $_GET['perf_period_id'];
	$regional_office_id = $_GET['regional_office_id'];
	?>
    <table class="container">
    <tr>
        <td colspan="3">
		<div id='top_menu'><?php require_once('includes/top_nav.php'); ?></div>
		</td>
    </tr>
    <tr>
      <td colspan="3">
	  <div id="left_menu">
	  <?php if ($session_level_id <= "2")
		//System Middle Access Level 
		{ 
		require_once('includes/left_column.php'); 
		}
		?>
	  </div>
	  <div id="content_area">
	  <fieldset name="reg_user" id="reg_user">
	  <legend align="center"><h2>EDIT PERFORMANCE</h2></legend>
				<?php  
				$result_set=mysql_query("SELECT * FROM performance_period,regional_office WHERE performance_period.perf_period_id='$perf_period_id' AND regional_office.regional_office_id='$regional_office_id'");
				while($row=mysql_fetch_array($result_set))
				{
				echo "
				<strong>
				<table align='right' cellpadding='5'>
				<tr><td>Area/Program:</td><td>{$row['office_name']}</td></tr>
				<tr><td>Performance Period Start:</td><td>{$row['start_date']}</td></tr>
				<tr><td>Performance Period End:</td><td>{$row['end_date']}</td></tr>
				</table>
				</strong>";
				}
				?><p />
	    <table class="gridtable" align="center" width="100%">
		<tr>
		<th>ID</th>
		<th>Indicator</th>
		<th>Target</th>
		<th>Achieved</th>
		<th>Notes</th>
		</tr>
		<?php
			$sql = "SELECT * FROM  score_card,regional_office,performance_period,performance_indicators WHERE score_card.perf_period_id=performance_period.perf_period_id AND score_card.regional_office_id=regional_office.regional_office_id AND score_card.indicator_id=performance_indicators.indicator_id AND performance_period.perf_period_id='$perf_period_id' AND regional_office.regional_office_id='$regional_office_id'"; 
			$result = mysql_query($sql) or die($sql."<br/><br/>".mysql_error()); 
			$i = 0;
			$count+=1;			
			while ($incicators = mysql_fetch_array($result)) {
				echo '<tr>';
				echo "<td><label>{$incicators['indicator_id']}</label></td>";
				echo "<td><label>{$incicators['indicator']}</label></td>";
				echo "<td><label>{$incicators['target']}</label></td>";
				echo "<td><label>{$incicators['achieved']}</label></td>";
				echo "<td><label>{$incicators['notes']}</label></td>";
				echo '</tr>';
				++$i;
			}
			?>
		<tr>
		<td colspan="6"><div align="center"><strong>Notes - Financial Sustainability Indicators</strong></div></td>
		</tr>
		<tr>
		    <td colspan="6">-Direct field costs exclude DSW management costs, overhead and general expenses not attributable to operations in a specific area.  They correspond to the breakdown between field costs and general costs in the accounting guidelines.<br />
			-Major capital expenses should be excluded - vehicle purchases, initial office set-up/furnishing costs<br />
			-All direct costs for a given field office should be attributed either to dispenser establishment or ongoing costs.  
			(Per-Dispenser Establishment Cost) * (Number of New Dispensers Installed) + (Per-Dispenser Ongoing Cost) * (Number of Dispenser-Days of Operation) = Total of Field Office Expenses<br />
			-For partnership programs - indicators should include combined DSW cost and estimated partner direct costs.  Provide a rough disaggregation between the two in the "Notes" section."			</td>
		</tr>
		<tr>
		    <td colspan="6"><div align="right">
		    <a href="edit_scard.php?perf_period_id=<?php echo $perf_period_id; ?>&&regional_office_id=<?php echo $regional_office_id; ?>"><img src='images/edit.png ' alt="Edit" width="16" height="16" border="0" /></a>
	        </div></td>
		</tr>
		</table>
	  </fieldset>
	  </div>
	  <div id="right_menu">
		<?php if ($session_level_id == "1")
		//System Admin Access Level
		{ 
		require_once('includes/right_column.php'); 
		}
		?>
	  </div>
	  </td>
    </tr>
    <tr>
      <td colspan="3" class="footer"><?php require_once('includes/footer.php'); ?></td>
    </tr>
  </table>
</body>
</html>