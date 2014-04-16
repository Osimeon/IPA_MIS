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
$dep_id = $_GET['dep_id'];
if(isset($_POST['Submit'])){
	$dep_name = $_POST['dep_name'];
	$dep_desc = $_POST['dep_desc'];	
	mysql_query("UPDATE department SET dep_name ='$dep_name',dep_desc='$dep_desc' WHERE dep_id = '$dep_id'")or die(mysql_error());
	header("Location: view_department.php");				
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
	  <legend align="center"><h2>EDIT DEPARTMENT</h2></legend>
		<?php include("includes/messageBox.php");?>
		<form id="edit_department" name="edit_department" method="post" action="">
	    <table class="gridtable" align="center" width="50%">
		  <tr>
			<?php
			// Get page data
			$sel = "SELECT * FROM department WHERE dep_id='$dep_id'";
			$result = mysql_query ($sel);
			while ($row = mysql_fetch_assoc($result)){
			?>
			<tr><td><strong>Department</strong></td><td><input name="dep_name" type="text" id="dep_name" value="<?php echo $row['dep_name']; ?>"/></td></tr>
            <tr><td><strong>Description</strong></td><td><textarea name="dep_desc" id="dep_desc"><?php echo $row["dep_desc"]; ?></textarea></td></tr>
			<?php 
			} ?>
          </tr>
          <tr>
            <td colspan="2" align="center"><input type="submit" name="Submit" value="Update Department" class="btn-style"/></td>
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