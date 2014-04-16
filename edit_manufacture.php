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
$manufacture_id = $_GET['manufacture_id'];
if(isset($_POST['Submit'])){
	$manufacture = $_POST['manufacture'];	
	mysql_query("UPDATE manufacture SET manufacture ='$manufacture' WHERE manufacture_id = '$manufacture_id'")or die(mysql_error());
	header("Location: view_manufactures.php");				
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
	    <table align="center">
		  <tr>
            <td><strong>Product Manufacture:</strong></td>
			<?php
			// Get page data
			$sel = "SELECT * FROM manufacture WHERE manufacture_id='$manufacture_id'";
			$result = mysql_query ($sel);
			while ($row = mysql_fetch_assoc($result)){
			?>
            <td><input name="manufacture" type="text" id="manufacture" value="<?php echo $row['manufacture']; ?>"/></td>
			<?php 
			} ?>
          </tr>
          <tr>
            <td colspan="2" align="center"><input type="submit" name="Submit" value="Update Manufacture" class="btn-style"/></td>
          </tr>
		  <tr>
			<td></td><td><p></td>
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