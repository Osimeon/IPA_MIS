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
require_once("includes/functions.php");
require_once("includes/form_functions.php");
require_once("includes/messageBox.php");
//checks if the form has been submited
if(isset($_POST['Submit']))
{
		//Check if not empty
		$errors=array();
		$required_fields = array('perf_period_id','regional_office_id');
		$errors=check_required_fields($required_fields);
	
		$query="SELECT * FROM score_card WHERE perf_period_id = '{$_POST['perf_period_id']}' AND regional_office_id = '{$_POST['regional_office_id']}' LIMIT 1";
		$check_scorecard=mysql_query($query);
		$rows=mysql_num_rows($check_scorecard);
		if((empty($errors))&&($rows==0))
		{
		$size = count($_POST['indicator_id']);
		$i = 0;
		$count = 0;
		while ($i < $size) 
		{
		$indicator_id=$_POST['indicator_id'][$i];
		$perf_period_id = $_POST['perf_period_id'];
		$regional_office_id= $_POST['regional_office_id'];
		$target= $_POST['target'][$i];
 
		$query = "INSERT INTO score_card (perf_period_id,regional_office_id,indicator_id,target) 
		VALUES('{$perf_period_id}','{$regional_office_id}','{$indicator_id}','{$target}')";
		mysql_query($query) or die ("Error in query: $query");
		++$i;
		}
		$messageToUser="Score Card Submited Succesfuly.<p>";
		}
			else
		{
		//Errors exist so building error message
		$perf_period_id=$_POST['perf_period_id'];
		$regional_office_id=$_POST['regional_office_id'];
		
		if(!empty($errors))
		{
		$error_message.="Please fill all the fields with an asterix(*) beside them.<br/>";
		}
		if($rows==1)
		{
		$error_message.="Similar Score Card has been Submited <u>Go to Manage Score Card</u> to Edit.";
		}
		}
}
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
	  <legend align="center"><h2>PERFORMANCE SCORE CARD</h2></legend>
		<?php include("includes/messageBox.php");?>
		<form id="scard_form" name="scard_form" method="post" action="">
		<strong>Performance Period:</strong>
		<select name="perf_period_id" id="perf_period_id">
				<?php  
				$result_set=mysql_query("SELECT * FROM performance_period ORDER BY perf_period_id DESC");
				while($row=mysql_fetch_array($result_set))
				{
				echo "<option value='{$row['perf_period_id']}'>{$row['perf_period_id']}</option>";
				}
				?>
		</select>*
		<strong>Area/Program:</strong>
		<select name="regional_office_id" id="regional_office_id">
		<option value=""></option>
				<?php  
				$result_set=mysql_query("SELECT * FROM regional_office ORDER BY office_name ASC");
				while($row=mysql_fetch_array($result_set))
				{
				echo "<option value='{$row['regional_office_id']}'>{$row['office_name']}</option>";
				}
				?>
		</select>*<p />
	    <table class="gridtable" align="center" width="100%">
		<tr>
		<th>ID</th>
		<th>Indicator</th>
		<th>Description</th>
		<th width='15%'>Target</th>
		</tr>
		<?php
			$sql = "SELECT * FROM  performance_indicators,department WHERE performance_indicators.dep_id=department.dep_id"; 
			$result = mysql_query($sql) or die($sql."<br/><br/>".mysql_error()); 
			$i = 0;
			$count+=1;			
			while ($incicators = mysql_fetch_array($result)) {
				echo '<tr>';
				echo "<td>{$incicators['indicator_id']}<input type='hidden' name='indicator_id[$i]' value='{$incicators['indicator_id']}' size='1' readonly/><input type='hidden' name='dep_id[$i]' value='{$incicators['dep_id']}' size='1' readonly/></td>";
				echo "<td>{$incicators['indicator']}</td>";
				echo "<td>{$incicators['description']}</td>";
				echo "<td>*<input type='text' name='target[$i]' value='' size='1'/></td>";
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
		    <td colspan="6"><div align="center">
		    <input type="submit" name="Submit" value="Submit Score Card" class="btn-style"/>
	        </div></td>
		</tr>
		</table>
		</form>
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