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
	  <legend align="center"><h2>REGIONAL OFFICE LIST</h2></legend>
		<div style="height:100%; overflow:scroll">
	  	<table class="gridtable" align="center" width="50%">
		<thead>
		  <tr>
			<th>ID</th> 
			<th>Country</th>
			<th>Office Name</th>
			<th></th> 
		</thead>
		  </tr>
			<?php
			// Get page data
			$sel = mysql_query("SELECT * FROM regional_office,country WHERE regional_office.country_name=country.country_name ORDER BY country.country_name,office_name");
			while($row=mysql_fetch_array($sel))
				{
					?>
					<tr >
						<td width="2%"><?php echo $row["regional_office_id"]; ?></td> 
						<td><?php echo $row["country_name"]; ?></td> 
						<td><?php echo $row["office_name"]; ?></td> 
						<td width="1%"><a href="edit_office.php?regional_office_id=<?php echo $row["regional_office_id"]; ?>"><img src='images/edit.png ' alt="Edit" width="16" height="16" border="0" /></td>     
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