<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('includes/conn.php'); ?>
<?php require_once('includes/css_js_links.php'); ?>
<?php require_once('includes/auth.php'); ?>
<title><?php require_once('includes/title.php'); ?></title>
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
	  <legend align="center"><h2>COUNTRY LIST</h2></legend>
	  <div style="height:100%; overflow:scroll">
		<table class="gridtable" align="center" width="50%">
		<thead>
		  <tr>
			<th>Country Code</th> 
			<th>Country Name</th>  
			<th>Mobile Code</th>
			<th></th>
		</thead>
		  </tr>
			<?php			
			// Get page data
			$sel = mysql_query("SELECT * FROM country ORDER BY country ASC");
			while($row=mysql_fetch_array($sel))
				{
					?>
					<tr >
						<td><?php echo $row["country_code"]; ?></td> 
						<td><?php echo $row["country"]; ?></td>  
						<td><?php echo $row["tel_code"]; ?></td>
						<td><a href="edit_country.php?country_id=<?php echo $row["country_id"]; ?>"><img src='images/edit.png ' alt="Edit" width="16" height="16" border="0" /></td>    
		  </tr>
		  <?php  } ?>
	      </table>
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