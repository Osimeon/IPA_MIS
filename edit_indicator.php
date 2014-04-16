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
$indicator_id = $_GET['indicator_id'];
if(isset($_POST['Submit'])){
	$dep_id = $_POST['dep_id'];
	$indicator = $_POST['indicator'];
	$description = $_POST['description'];	
	mysql_query("UPDATE performance_indicators SET dep_id='$dep_id', indicator ='$indicator',description='$description' WHERE indicator_id = '$indicator_id'")or die(mysql_error());
	header("Location: view_indicators.php");				
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
	  <legend align="center"><h2>EDIT INDICATOR</h2></legend>
		<?php include("includes/messageBox.php");?>
		<form id="edit_department" name="edit_department" method="post" action="">
	    <table class="gridtable" align="center" width="50%">
		  <tr>
			<?php
			// Get page data
			$sel = "SELECT * FROM performance_indicators,department WHERE performance_indicators.dep_id=department.dep_id AND indicator_id='$indicator_id'";
			$result = mysql_query ($sel);
			while ($row = mysql_fetch_assoc($result)){
			?>
			<tr><td><strong>Department</strong></td><td>
			<select name="dep_id" id="dep_id">
				<option value="<?php echo $row['dep_id']; ?>"><?php echo $row['dep_name']; ?></option>
				<?php 
				$query_dep = mysql_query("SELECT * FROM department ORDER BY dep_name ASC") or die("Query failed: ".mysql_error());
				while($dep = mysql_fetch_array($query_dep)): ?>
				<option value="<?php echo $dep['dep_id']; ?>"><?php echo $dep['dep_name']; ?></option>
				<?php endwhile; ?>
			</select>			
			</td></tr>
			<tr><td><strong>Indicator</strong></td><td><input name="indicator" type="text" id="indicator" value="<?php echo $row['indicator']; ?>"/></td></tr>
            <tr><td><strong>Description</strong></td><td><textarea name="description" id="description"><?php echo $row["description"]; ?></textarea></td></tr>
			<?php 
			} ?>
          </tr>
          <tr>
            <td colspan="2" align="center"><input type="submit" name="Submit" value="Update Indicator" class="btn-style"/></td>
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