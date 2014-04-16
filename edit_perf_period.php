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
//Update Manufacture
$perf_period_id = $_GET['perf_period_id'];
if(isset($_POST['Submit'])){
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];	
	mysql_query("UPDATE  performance_period SET start_date ='$start_date',end_date='$end_date' WHERE perf_period_id = '$perf_period_id'")or die(mysql_error());
	header("Location: view_perf_period.php");				
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
	  <legend align="center"><h2>EDIT PERFORMANCE PERIOD</h2></legend>
		<?php include("includes/messageBox.php");?>
		<form id="edit_department" name="edit_department" method="post" action="">
	    <table class="gridtable" align="center" width="50%">
		  <tr>
			<?php
			// Get page data
			$sel = "SELECT * FROM  performance_period WHERE perf_period_id='$perf_period_id'";
			$result = mysql_query ($sel);
			while ($row = mysql_fetch_assoc($result)){
			?>
			<tr><td><strong>Start Date:</strong></td><td><input name="start_date" type="text" id="start_date" value="<?php echo $row['start_date']; ?>"/></td></tr>
            <tr><td><strong>End Date:</strong></td><td><input name="end_date" type="text" id="end_date" value="<?php echo $row['end_date']; ?>"/></td></tr>
			<?php 
			} ?>
          </tr>
          <tr>
            <td colspan="2" align="center"><input type="submit" name="Submit" value="Update Period" class="btn-style"/></td>
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