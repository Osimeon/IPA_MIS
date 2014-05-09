<?php error_reporting (E_ALL ^ E_NOTICE); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('includes/conn.php'); ?>
<?php require_once('includes/css_js_links.php'); ?>
<?php require_once('includes/auth.php'); ?>
<?php
	$issueid =$_GET['issueid'];
	if(isset($_POST['Submit'])){;
	$user_comments = $_POST['user_comments'];
	$investigated = $_POST['investigated'];
	$reason_unsolved = $_POST['reason_unsolved'];
	$solved = $_POST['solved'];
	mysql_query("UPDATE issue SET solved ='$solved',date_solved='$date',solvedby='$session_emp_no',user_comments='$user_comments',dispenser_functional='Yes', issue_investigated = '$investigated', reason_unsolved = '$reason_unsolved' WHERE issueid = '$issueid'")or die(mysql_error());
	header("Location: unsolved_issues.php?regional_office_id=$session_regional_office_id");				
}
?>
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
	  <legend align="center"><h2>SOLVE SELECTED ISSUE</h2></legend>
		<?php
			$issueid = $_GET['issueid'];
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
            <td><?php echo $row["staff_name"]; ?></td>
          </tr>
		  <tr>
            <td><strong>Date Assigned:</strong></td>
            <td><?php echo $row["date_assigned"]; ?></td>
          </tr>
		  <tr>
            <td><strong>Staff Assigned:</strong></td>
            <td><?php echo $row["staff_name"]; ?></td>
          </tr>
		  <tr>
            <td><strong>Issue Type:</strong></td>
            <td><?php echo $row["issue_name"]; ?></td>
          </tr>
		  <tr>
            <td><strong>Disp Functional?:</strong></td>
            <td><?php echo $row["dispenser_functional"]; ?></td>
		  </tr>
                    
          
          <tr>
            <td><strong>Investigated?:</strong></td>
            <td>
			<label><input type="radio" name="investigated" value="Yes" /> Yes </label>
			<label><input type="radio" name="investigated" value="No" /> No </label>			</td>
          </tr>
                    
          <tr>
            <td valign="top"><strong>Reason Unsolved?:</strong></td>
            <td>
              <textarea name="reason_unsolved" id="reason_unsolved"><?php echo $row["reason_unsolved"]; ?></textarea></td>
		  </tr>
          
		  <tr>
            <td valign="top"><strong>Comments:</strong></td>
            <td>
              <textarea name="user_comments" id="user_comments"><?php echo $row["user_comments"]; ?></textarea></td>
		  </tr>
		  <tr>
            <td><strong>Issue Solved?:</strong></td>
            <td>
			<label><input type="radio" name="solved" value="Yes" /> Yes </label>
			<label><input type="radio" name="solved" value="No" /> No </label>			</td>
          </tr>
          <tr>
            <td colspan="2" align="center"><input type="submit" name="Submit" value="Update Issue Record" class="btn-style"/></td>
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