<?php error_reporting (E_ALL ^ E_NOTICE); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('includes/conn.php'); ?>
<?php require_once('includes/css_js_links.php'); ?>
<?php require_once('includes/auth.php'); ?>
<title><?php require_once('includes/title.php'); ?></title>
</head>
<body>
<script language="javascript" type="text/javascript">
function capitaliseName()
{
    var str = document.getElementById("district_name").value;
    document.getElementById("district_name").value = str.charAt(0).toUpperCase() + str.slice(1);
	var str = document.getElementById("division_county").value;
    document.getElementById("division_county").value = str.charAt(0).toUpperCase() + str.slice(1);
	var str = document.getElementById("location_subcounty").value;
    document.getElementById("location_subcounty").value = str.charAt(0).toUpperCase() + str.slice(1);
	var str = document.getElementById("sublocation_parish").value;
    document.getElementById("sublocation_parish").value = str.charAt(0).toUpperCase() + str.slice(1);
	var str = document.getElementById("village").value;
    document.getElementById("village").value = str.charAt(0).toUpperCase() + str.slice(1);
	var str = document.getElementById("contactname").value;
    document.getElementById("contactname").value = str.charAt(0).toUpperCase() + str.slice(1);
	var str = document.getElementById("waterpoint_name").value;
    document.getElementById("waterpoint_name").value = str.charAt(0).toUpperCase() + str.slice(1);
}
</script>
<?php
require_once("includes/functions.php");
require_once("includes/form_functions.php");
require_once("includes/messageBox.php");
//checks if the form has been submited
if(isset($_POST['Submit']))
	{
	//Check if not empty
	$errors=array();
	$required_fields = array('district_name','division_county','location_subcounty','sublocation_parish','village','contactname','contactnumber','waterpoint_name','waterpoint_id','installation_date');
	$errors=check_required_fields($required_fields);

		$query="SELECT * FROM waterpoints WHERE waterpoint_id = '{$_POST['waterpoint_id']}' LIMIT 1";
		$check_waterpoint=mysql_query($query);
		$rows=mysql_num_rows($check_waterpoint);

		if((empty($errors))&&($rows==0))
		{
			$district_name=$_POST['district_name'];
			$division_county=$_POST['division_county'];
			$location_subcounty=$_POST['location_subcounty'];
			$sublocation_parish=$_POST['sublocation_parish'];
			$village=$_POST['village'];
			$contactname=$_POST['contactname'];
			$contactnumber=$_POST['contactnumber'];
			$waterpoint_name=$_POST['waterpoint_name'];
			$waterpoint_id=$_POST['waterpoint_id'];
			$installation_date=$_POST['installation_date'];
			
			
			$query = "INSERT INTO waterpoints (country_code,regional_office_id,district_name,division_county,location_subcounty,sublocation_parish,village,contactname,contactnumber,waterpoint_name,waterpoint_id,installation_date) ".
	"VALUES ('$session_country_code','$session_regional_office_id','$district_name','$division_county','$location_subcounty','$sublocation_parish','$village','$contactname','$contactnumber','$waterpoint_name','$waterpoint_id','$installation_date')";
	mysql_query($query) or die('Error, query failed');
	$messageToUser="Waterpoint $waterpoint_name Added Successfully!<p>";
	} 
	else
	{
	//Errors exist so building error message
	$district_name=$_POST['district_name'];
	$division_county=$_POST['division_county'];
	$location_subcounty=$_POST['location_subcounty'];
	$sublocation_parish=$_POST['sublocation_parish'];
	$village=$_POST['village'];
	$contactname=$_POST['contactname'];
	$contactnumber=$_POST['contactnumber'];
	$waterpoint_name=$_POST['waterpoint_name'];
	
	if(!empty($errors))
	{
	$error_message.="Please review the feilds with an asterix(*) beside them.<br/>";
	}
	if($rows==1)
	{
	$error_message.="Waterpoint With Similar ID Exists.";
	}
	}
	}
	else
	{
	$errors=array();
	$district_name="";
	$division_county="";
	$location_subcounty="";
	$sublocation_parish="";
	$village="";
	$contactname="";
	$contactnumber="";
	$waterpoint_name="";
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
	  <legend align="center"><h2>ADD NEW WATERPOINT</h2></legend>
	<?php include("includes/messageBox.php");?>
	  <form id="reg_form" name="reg_form" method="post" action="">
	    <table align="center">
			<tr>
			  <td><strong>District Name: </strong></td>
			  <td><input name="district_name" type="text" id="district_name" onkeyup = "capitaliseName()"/><?php display_error("district_name",$errors);?></td>
			</tr>
			<tr>
			  <td><strong>Division/County:</strong></td>
			  <td><input name="division_county" type="text" id="division_county" onkeyup = "capitaliseName()"/><?php display_error("division_county",$errors);?></td>
			</tr>
			<tr>
			  <td><strong>Location/Subcounty:</strong></td>
			  <td><input name="location_subcounty" type="text" id="location_subcounty" onkeyup = "capitaliseName()"/><?php display_error("location_subcounty",$errors);?></td>
			</tr>
			<tr>
			  <td><strong>Sublocation/Parish:</strong></td>
			  <td><input name="sublocation_parish" type="text" id="sublocation_parish" onkeyup = "capitaliseName()"/><?php display_error("sublocation_parish",$errors);?></td>
			</tr>
			<tr>
			  <td><strong>Village:</strong></td>
			  <td><input name="village" type="text" id="village" onkeyup = "capitaliseName()"/><?php display_error("village",$errors);?></td>
			</tr>
			<tr>
			  <td><strong>Contact Person: </strong></td>
			  <td><input name="contactname" type="text" id="contactname" onkeyup = "capitaliseName()"/><?php display_error("contactname",$errors);?></td>
			</tr>
			<tr>
			  <td><strong>Phone No: </strong></td>
			  <td><input name="contactnumber" type="text" id="contactnumber" /><?php display_error("contactnumber",$errors);?></td>
			</tr>
			<tr>
			  <td><strong>Waterpoint Name: </strong></td>
			  <td><input name="waterpoint_name" type="text" id="waterpoint_name" onkeyup = "capitaliseName()"/><?php display_error("waterpoint_name",$errors);?></td>
			</tr>
			<tr>
			  <td><strong>Waterpoint ID: </strong></td>
			  <td><input name="waterpoint_id" type="text" id="waterpoint_id" maxlength="8"/><?php display_error("waterpoint_id",$errors);?></td>
			</tr>
			<tr>
			  <td><strong>Installation Date: </strong></td>
			  <td><input name="installation_date" type="text" id="installation_date" placeholder="YYYY-MM-DD"/><?php display_error("installation_date",$errors);?></td>
			</tr>
			<tr>
			  <td colspan="2"><div align="center">
				<input type="submit" name="Submit" value="Submit Waterpoint" />
			  </div></td>
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