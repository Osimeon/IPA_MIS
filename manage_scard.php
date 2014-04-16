<?php error_reporting (E_ALL ^ E_NOTICE); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('includes/conn.php'); ?>
<?php require_once('includes/css_js_links.php'); ?>
<?php require_once('includes/auth.php'); ?>
<title><?php require_once('includes/title.php'); ?></title>
<script type="text/javascript">  
    function submitOnEnter(inputElement, event) {  
        if (event.keyCode == 13) { // No need to do browser specific checks. It is always 13.  
            inputElement.form.submit();  
        }  
    }  
</script>
</head>
<body>
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
	  <legend align="center"><h2>MANAGE PERFORMANCE SCORE CARDS</h2></legend>
		<div style="height:100%; overflow:scroll">
	  	<table class="gridtable" align="center" width="60%">
		<thead>
		  <tr>
			<th scope="col">Period ID</th>
			<th scope="col">Start Date</th>
			<th scope="col">End Date</th>
			<th scope="col">Area/Program</th>
			<th colspan="2"></th>
		</thead>
		  </tr>
		<tr>
		<form action="" method="POST">
			<td>&nbsp;</td>
			<td colspan="2">
			<select name="perf_period_id" id="perf_period_id" onkeypress="submitOnEnter(this, event);">
			<option value="">Select Period</option>
				<?php  
				$result_set=mysql_query("SELECT * FROM performance_period ORDER BY perf_period_id DESC");
				while($row=mysql_fetch_array($result_set))
				{
				echo "<option value='{$row['perf_period_id']}'>{$row['start_date']}-{$row['end_date']} </option>";
				}
				?>
			</select>
			</td>
			<td>
			<select name="regional_office_id" id="regional_office_id" onkeypress="submitOnEnter(this, event);">
			<option value="">Select Program</option>
				<?php  
				$result_set=mysql_query("SELECT * FROM score_card,regional_office WHERE score_card.regional_office_id=regional_office.regional_office_id GROUP BY office_name ORDER BY office_name ASC");
				while($row=mysql_fetch_array($result_set))
				{
				echo "<option value='{$row['regional_office_id']}'>{$row['office_name']}</option>";
				}
				?>
			</select>
			</td>
			<td colspan="2">&nbsp;</td>
		</form>
		</tr>
			<?php
			$perf_period_id = $_POST['perf_period_id'];
			$regional_office_id = $_POST['regional_office_id'];		
			// Get page data
			$sel = mysql_query("SELECT * FROM  score_card,performance_period,regional_office WHERE score_card.perf_period_id=performance_period.perf_period_id AND score_card.regional_office_id=regional_office.regional_office_id AND score_card.perf_period_id LIKE '%$perf_period_id%' AND score_card.regional_office_id LIKE '%$regional_office_id%' GROUP BY score_card.perf_period_id,score_card.regional_office_id ORDER BY score_card.perf_period_id DESC");
			while($row=mysql_fetch_array($sel))
				{
					?>
					<tr >
			<td><?php echo $row['perf_period_id']; ?></td>
			<td><?php echo $row['start_date']; ?></td>
			<td><?php echo $row['end_date']; ?></td>
			<td><?php echo $row['office_name']; ?></td>
			<td><a href="view_scard.php?perf_period_id=<?php echo $row["perf_period_id"]; ?>&&regional_office_id=<?php echo $row["regional_office_id"]; ?>"><img src='images/view.jpg ' alt="View" width="16" height="16" border="0" /></td>
			<td><a href="edit_scard.php?perf_period_id=<?php echo $row["perf_period_id"]; ?>&&regional_office_id=<?php echo $row["regional_office_id"]; ?>"><img src='images/edit.png ' alt="Edit" width="16" height="16" border="0" /></td>     
		  </tr>
		  <?php  } ?>
	      </table><p />
      </div>
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