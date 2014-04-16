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
$make_id = $_GET['make_id'];
if(isset($_POST['Submit'])){
	$make_name = $_POST['make_name'];	
	mysql_query("UPDATE make SET make_name ='$make_name' WHERE make_id = '$make_id'")or die(mysql_error());
	header("Location: view_make.php");				
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
	  <legend align="center"><h2>EDIT MANUFACTURE</h2></legend>
		<?php include("includes/messageBox.php");?>
		<form id="manufacture_form" name="manufacture_form" method="post" action="">
	    <table class="gridtable" align="center" width="50%">
		<thead>
		  <tr> 
			<td><strong>Manufacture</strong></td>
			<td><strong>Make</strong></td> 
		  </tr>
		</thead>
		  <tr>
			<?php
			// Get page data
			$sel = "SELECT * FROM make,manufacture WHERE make.manufacture_id=manufacture.manufacture_id AND make_id='$make_id'";
			$result = mysql_query ($sel);
			while ($row = mysql_fetch_assoc($result)){
			?>
			<td valign="top"><?php echo $row['manufacture']; ?></td>
            <td><textarea name="make_name" id="make_name"><?php echo $row["make_name"]; ?></textarea></td>
			<?php 
			} ?>
          </tr>
          <tr>
            <td colspan="2" align="center"><input type="submit" name="Submit" value="Update Make" class="btn-style"/></td>
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