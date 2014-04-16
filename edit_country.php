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
//Update Country
$country_id = $_GET['country_id'];
if(isset($_POST['Submit'])){
	$country = $_POST['country'];
	$tel_code = $_POST['tel_code'];	
	mysql_query("UPDATE country SET country ='$country',tel_code='$tel_code' WHERE country_id = '$country_id'")or die(mysql_error());
	header("Location: manage_countries.php");				
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
	  <legend align="center"><h2>EDIT COUNTRY</h2></legend>
		<?php include("includes/messageBox.php");?>
		<form id="edit_country" name="edit_country" method="post" action="">
	    <table align="center">
		<?php
			$sql = "SELECT * FROM country WHERE country_id='$country_id'";  
			$rs_result = mysql_query ($sql);
			while ($row = mysql_fetch_assoc($rs_result)) {  
			?>
		  <tr>
            <td>Country ID:</td>
            <td><input name="country_id" type="text" value="<?php echo $row["country_id"]; ?>" readonly /></td>
          </tr>
		  <tr>
            <td>Country Code:</td>
            <td><input name="country_code" type="text" value="<?php echo $row["country_code"]; ?>" readonly />
            </td>
          </tr>
		  <tr>
            <td>Country Name:</td>
            <td><input name="country" type="text" value="<?php echo $row["country"]; ?>" />
            </td>
          </tr>
		   <tr>
            <td>Mobile Code:</td>
            <td><input name="tel_code" type="text" value="<?php echo $row["tel_code"]; ?>" />
            </td>
          </tr>
			<?php  
			};  
			?>
          <tr>
			<td></td>
            <td align="right"><input type="submit" name="Submit" value="Update Country" class="btn-style"/></td>
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