<?php error_reporting (E_ALL ^ E_NOTICE); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('includes/conn.php'); ?>
<?php require_once('includes/css_js_links.php'); ?>
<?php require_once('includes/auth.php'); ?>
<?php
	$redirect_link=$_GET['redirect_link'];
	$issueid =$_GET['issueid'];
	if(isset($_POST['Submit'])){;
	$user_assigned= $_POST['user_assigned'];
	$issuetype_id = $_POST['issuetype_id'];
	$dispenser_functional = $_POST['dispenser_functional'];
	$user_comments = $_POST['user_comments'];
	mysql_query("UPDATE issue SET user_assigned='$user_assigned',issuetype_id='$issuetype_id',user_comments='$user_comments',dispenser_functional='$dispenser_functional' WHERE issueid = '$issueid'")or die(mysql_error());
	header("Location: $redirect_link?country_name=$session_country_name");
	$messageToUser="Issue Updated Succesfuly!<p>";
}
?>
<title>View Issue</title>
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
	  <legend align="center"><h2>VIEW ISSUE #<?php echo $issueid; ?></h2></legend>
		<?php
			$sql = "SELECT * FROM issue,waterpoints,issue_type,users WHERE issue.issueid='$issueid' AND issue.waterpoint_id=waterpoints.waterpoint_id AND issue.issuetype_id=issue_type.issuetype_id AND issue.createdby=users.emp_no";  
			$rs_result = mysql_query ($sql);
			while ($row = mysql_fetch_assoc($rs_result)) {  
			?> 
			<form method="post" action="" name="assign_user">
	    <table cellpadding="3" align="center" width="50%">
          <tr>
            <td><strong>Issue ID:</strong></td>
            <td><?php echo $row["issueid"]; ?></td>
          </tr>
		   <tr>
            <td><strong>Waterpoint ID:</strong></td>
            <td><?php echo $row["waterpoint_id"]; ?></td>
          </tr>
		  <tr>
            <td><strong>Waterpoint Name:</strong></td>
            <td><?php echo $row["waterpoint_name"]; ?></td>
          </tr>
		  <tr>
            <td><strong>Date Created:</strong></td>
            <td><?php echo $row["date_created"]; ?></td>
          </tr>
		   <tr>
            <td><strong>Created By:</strong></td>
            <td>
			<?php		 
			$query = mysql_query("SELECT * FROM  issue,users WHERE issue.createdby=users.emp_no AND issue.issueid='$issueid'") or die("Query failed: ".mysql_error());
			while($result_createdby= mysql_fetch_array($query)):
			echo $result_createdby['staff_name'];
			endwhile; 
			?>
			</td>
          </tr>
		  <tr>
            <td><strong>Date Assigned:</strong></td>
            <td><?php echo $row["date_assigned"]; ?></td>
          </tr>
		  <tr>
            <td><strong>Staff Assigned:</strong></td>
            <td>
			<select name="user_assigned" id="user_assigned">
			<?php		 
			$query = mysql_query("SELECT * FROM  issue,users WHERE issue.user_assigned=users.emp_no AND issue.issueid='$issueid'") or die("Query failed: ".mysql_error());
			while($staffassigned = mysql_fetch_array($query)): ?>
			<option value="<?php echo $staffassigned['emp_no']; ?>"><?php echo $staffassigned['staff_name']; ?></option>
			<?php endwhile; ?>
			<?php		 
			$query = mysql_query("SELECT * FROM  users WHERE regional_office_id='$session_regional_office_id' ORDER BY staff_name ASC") or die("Query failed: ".mysql_error());
			while($staffassigned = mysql_fetch_array($query)): ?>
			<option value="<?php echo $staffassigned['emp_no']; ?>"><?php echo $staffassigned['staff_name']; ?></option>
			<?php endwhile; ?>
			</select></td>
          </tr>
		  <tr>
            <td><strong>Issue Type:</strong></td>
            <td>
			<select name="issuetype_id" id="issuetype_id">
			<option value="<?php echo $row["issuetype_id"]; ?>"><?php echo $row["issue_name"]; ?></option>
			<?php		 
			$query = mysql_query("SELECT * FROM  issue_type ORDER BY issue_name ASC") or die("Query failed: ".mysql_error());
			while($issuetype = mysql_fetch_array($query)): ?>
			<option value="<?php echo $issuetype['issuetype_id']; ?>"><?php echo $issuetype['issue_name']; ?></option>
			<?php endwhile; ?>
			</select></td>
          </tr>
		  <tr>
            <td><strong>Disp Functional?:</strong></td>
            <td>
			<label>
			<select name="dispenser_functional" id="dispenser_functional">
			  <option value="<?php echo $row["dispenser_functional"]; ?>"><?php echo $row["dispenser_functional"]; ?></option>
			  <option value="Yes">Yes</option>
			  <option value="No">No</option>
			  </select>
			</label></td>
		  </tr>
		  <tr>
            <td valign="top"><strong>Comments:</strong></td>
            <td>
              <textarea name="user_comments" id="user_comments"><?php echo $row["user_comments"]; ?></textarea></td>
		  </tr>
		  <tr>
            <td><strong>Issue Solved?:</strong></td>
            <td><?php echo $row["solved"]; ?></td>
          </tr>
		  <tr>
            <td><strong>Date Solved:</strong></td>
            <td><?php echo $row["date_solved"]; ?></td>
          </tr>
		  <tr>
            <td><strong>Solved By:</strong></td>
            <td>
			<?php		 
			$query = mysql_query("SELECT * FROM  issue,users WHERE issue.solvedby=users.emp_no AND issue.issueid='$issueid'") or die("Query failed: ".mysql_error());
			while($result_solvedby= mysql_fetch_array($query)):
			echo $result_solvedby['staff_name'];
			endwhile; 
			?>
			</td>
          </tr>
          <tr>
            <!--<td colspan="2" align="center"><input type="submit" name="Submit" value="Update Issue Record" class="btn-style"/></td>-->
          </tr>
        </table>
		</form>
			<?php  
			};  
			?>
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