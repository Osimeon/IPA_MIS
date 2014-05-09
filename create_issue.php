<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('includes/conn.php'); ?>
<?php require_once('includes/css_js_links.php'); ?>
<?php require_once('includes/auth.php'); ?>
<title>Create Issue</title>
</head>
<body>
<script type="text/javascript">
$(document).ready(function() {
    $("#district_name").change(function() {
		$.get('loadsublocation.php?district_name=' + $(this).val(), function(data) {
			$("#sublocation_parish").html(data);
			$('#loader').slideUp(200, function() {
				$(this).remove();
			});
		});	
    });
	$("#sublocation_parish").change(function() {
		$.get('loadvillage.php?sublocation_parish=' + $(this).val(), function(data) {
			$("#village").html(data);
			$('#loader').slideUp(200, function() {
				$(this).remove();
			});
		});	
    });
	$("#village").change(function() {
		$.get('loadwaterpoint.php?village=' + $(this).val(), function(data) {
			$("#waterpoint_id").html(data);
			$('#loader').slideUp(200, function() {
				$(this).remove();
			});
		});	
    });

});
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
	$required_fields = array('waterpoint_id','dispenser_functional','issuetype_id');
	$errors=check_required_fields($required_fields);

		$query="SELECT * FROM issue WHERE waterpoint_id = '{$_POST['waterpoint_id']}' AND date_created = '$date' LIMIT 1";
		$check_village=mysql_query($query);
		$rows=mysql_num_rows($check_village);

		if((empty($errors))&&($rows==0))
		{
			$waterpoint_id=$_POST['waterpoint_id'];
			$dispenser_functional=$_POST['dispenser_functional'];
			$issuetype_id=$_POST['issuetype_id'];
			$user_comments=$_POST['user_comments'];
			$prototype = $_POST['disp_prototype'];
			
			
			$query = "INSERT INTO issue (waterpoint_id,date_created,dispenser_functional,issuetype_id,createdby,user_comments, prototype) ".
	"VALUES ('$waterpoint_id','$date','$dispenser_functional','$issuetype_id','$session_emp_no','$user_comments','$prototype')";
	mysql_query($query) or die('Error, query failed');
	$messageToUser="Issue for $waterpoint_id. Created Succesfuly!<p>";
	} 
	else
	{
	//Errors exist so building error message
	$waterpoint_id=$_POST['waterpoint_id'];
	$dispenser_functional=$_POST['dispenser_functional'];
	$issuetype_id=$_POST['issuetype_id'];
	
	if(!empty($errors))
	{
	$error_message.="Please review the feilds with an asterix(*) beside them.<br/>";
	}
	if($rows==1)
	{
	$error_message.="Issue for $waterpoint_id created today you can only edit.";
	}
	}
	}
	else
	{
	$errors=array();
	$waterpoint_id="";
	$dispenser_functional="";
	$issuetype_id="";
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
	  <legend align="center"><h2>CREATE ISSUE</h2></legend>
		<?php include("includes/messageBox.php");?>
		<form id="issue_form" name="issue_form" method="post" action="">
	    <table align="center">
		  <tr>
			<td><strong>District:</strong></td>
			<td>
			<select name="district_name" id="district_name">
				<option value=""></option>
				<?php 
				$query_district = mysql_query("SELECT * FROM waterpoints,program WHERE waterpoints.program_code=program.program_code AND program.regional_office_id='$session_regional_office_id' GROUP BY district_name ORDER BY district_name ASC") or die("Query failed: ".mysql_error());
				while($districts = mysql_fetch_array($query_district)): ?>
				<option value="<?php echo $districts['district_name']; ?>"><?php echo $districts['district_name']; ?></option>
				<?php endwhile; ?>
			</select>
			</td>
		  </tr>
		  <tr>
            <td><strong>Sub location:</strong></td>
            <td><select name="sublocation_parish" id="sublocation_parish"></select></td>
          </tr>
		  <tr>
            <td><strong>Village:</strong></td>
            <td><select name="village" id="village"></select></td>
          </tr>
		  <tr>
            <td><strong>Waterpoint:</strong></td>
            <td><select name="waterpoint_id" id="waterpoint_id"></select><?php display_error("waterpoint_id",$errors);?></td>
          </tr>
		  <tr>
			<td><strong>Dispenser Functional:</strong></td>
            <td>
                <div align="center">
				Yes<input type="radio" name="dispenser_functional" value="Yes" />
                No<input type="radio" name="dispenser_functional" value="No" /><?php display_error("dispenser_functional",$errors);?>
			    </div>
			</td>
          </tr>
          <tr>
			<td><strong>Prototype:</strong></td>
            <td>
                <div align="center">
				Yes<input type="radio" name="disp_prototype" value="Yes" />
                No<input type="radio" name="disp_prototype" value="No" /><?php display_error("disp_prototype",$errors);?>
			    </div>
			</td>
          </tr>
		  <tr>
			<td><strong>Issue Type:</strong></td>
            <td>
			<select name="issuetype_id" id="issuetype_id">
			<option value=''></option>
				<?php  
				$result_set=mysql_query("SELECT * FROM  issue_type ORDER BY issue_name ASC");
				while($row=mysql_fetch_array($result_set))
				{
				echo "<option value=\"{$row['issuetype_id']}\">{$row['issue_name']}</option>";
				}
				?>
			</select><?php display_error("issuetype_id",$errors);?>
			</td>
          </tr>
		  <tr>
			<td><strong>User Comment:</strong></td>
            <td><textarea name="user_comments" id="user_comments"></textarea></td>
          </tr>
          <tr>
			<td></td>
            <td align="center"><input type="submit" name="Submit" value="Create" class="btn-style"/></td>
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