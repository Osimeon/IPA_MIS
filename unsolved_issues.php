<?php error_reporting (E_ALL ^ E_NOTICE); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('includes/conn.php'); ?>
<?php require_once('includes/css_js_links.php'); ?>
<?php require_once('includes/auth.php'); ?>
<title>Unsolved Issues</title>
<script type="text/javascript" src="js/picnet.table.filter.min.js"></script>
<script> 
	$(document).ready(function() {
		$('#tablesorter').tableFilter();
	});
</script>
<style type="text/css">
<!--
.style1 {color: #FE1407}
-->
</style>
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
                      <?php 
                        if ($session_level_id <= "2"){ 
                            require_once('includes/left_column.php'); 
                        }
                      ?>
                </div>
                
                <fieldset name="reg_user" id="reg_user"> 
                    <legend align="center"><h2>ISSUES ASSIGNED BUT NOT SOLVED</h2></legend>
                    <div align="center"><?php include("includes/messageBox.php");?></div>
                    <div style="height:540px; overflow:scroll">
                    
                    	<table class="gridtable" align="center" width="100%" id="tablesorter">
                            <colgroup>
                                <col id="No" />
                                <col id="Regional Office" />
                                <col id="District Name" />
                                <col id="Sublocation/Parish" />
                                <col id="Village Name" />
                                <col id="Waterpoint Name" />
                                <col id="Waterpoint ID" />
                                <col id="Date Assigned" />
                                <col id="Staff Assigned" />
                                <col id="Issue Type" />
                                <col id="D.F?" />
                                <col id="Solved?" />
                            </colgroup>
                        <thead id="statsHead">
                            <tr>
                                <th filter='false'>No</th>
                                <th filter-type='ddl'>Regional Office</th>
                                <th filter='false'>District Name</th>
                                <th filter='false'>Sublocation/Parish</th>
                                <th filter='false'>Village Name</th>
                                <th filter='false'>Waterpoint Name</th>
                                <th filter='false'>Waterpoint ID</th>
                                <th filter='false'>Date Assigned</th>
                                <th filter='false'>Staff Assigned</th>
                                <th filter-type='ddl'>Issue Type</th>
                                <th filter-type='ddl'>D.F?</th>
                                <th filter='false'>Solved?</th>
                                <th filter='false'>S</th>
                                <th filter='false'>E</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT * FROM 
											issue,waterpoints,program,regional_office,issue_type,users 
											WHERE issue.user_assigned !='0' 
											AND issue.solved ='No' 
											AND issue.waterpoint_id = waterpoints.waterpoint_id 
											AND issue.issuetype_id = issue_type.issuetype_id 
											AND issue.user_assigned = users.emp_no 
											AND waterpoints.program_code = program.program_code 
											AND program.regional_office_id = regional_office.regional_office_id";
                                $result = mysql_query($sql);
                                $count = mysql_num_rows($result);
                                $indexcounter = 1;
                                while($rows = mysql_fetch_array($result)){
                            ?>
                                    <tr>
                                        <td><?php echo $indexcounter ?></td>
                                        <td><?php echo $rows['office_name']; ?></td>
                                        <td><?php echo $rows['district_name']; ?></td>
                                        <td><?php echo $rows['sublocation_parish']; ?></td>
                                        <td><?php echo $rows['village']; ?></td>
                                        <td><?php echo $rows['waterpoint_name']; ?></td>
                                        <td><?php echo $rows['waterpoint_id']; ?></td>
                                        <td><?php echo $rows['date_assigned']; ?></td>
                                        <td><?php echo $rows['staff_name']; ?></td>
                                        <td><?php echo $rows["issue_name"]; ?></td>
                                        <td><?php echo $rows["dispenser_functional"]; ?></td>
                                        <td><?php echo $rows["solved"]; ?></td>
                                        <td>
                                            <a href="solve_issue.php?issueid=<?php echo $rows["issueid"]; ?>">
                                                <img src='images/solve_issue.jpg ' alt="Solve Issue" width="16" height="16" border="0" />
                                            </a>
                                        </td>
                                        <td>
                                            <a href="edit_issue.php?issueid=<?php echo $rows["issueid"]; ?>&&redirect_link=unsolved_issues.php">
                                                <img src='images/edit.png' alt="Edit Issue" width="16" height="16" border="0" />
                                            </a>
                                        </td>  
                                    </tr>
                            <?php
                                    $indexcounter++;
                                }
                            ?>
                        </tbody>
                    </table>
                    </div>
        		</fieldset>
            </td>
        <tr>
        	<td colspan="3" class="footer"><?php require_once('includes/footer.php'); ?></td>
   		</tr>
    </table>
</body>
</html>