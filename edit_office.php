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
$regional_office_id = $_GET['regional_office_id'];
if(isset($_POST['Submit'])){
	$office_name = $_POST['office_name'];	
	mysql_query("UPDATE regional_office SET office_name ='$office_name' WHERE regional_office_id = '$regional_office_id'")or die(mysql_error());
	header("Location: view_office.php");				
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
			<td><strong>Country</strong></td>
			<td><strong>Office Name</strong></td> 
		  </tr>
		</thead>
		  <tr>
			<?php
			// Get page data
			$sel = "SELECT * FROM regional_office,country WHERE regional_office.country_name=country.country_name AND regional_office_id='$regional_office_id'";
			$result = mysql_query ($sel);
			while ($row = mysql_fetch_assoc($result)){
			?>
			<td valign="top"><?php echo $row['country_name']; ?></td>
            <td><textarea name="office_name" id="office_name"><?php echo $row["office_name"]; ?></textarea></td>
			<?php 
			} ?>
          </tr>
          <tr>
            <td colspan="2" align="center"><input type="submit" name="Submit" value="Update Office" class="btn-style"/></td>
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