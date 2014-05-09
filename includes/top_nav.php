<ul>
   <li class='active'>
   		<a href='home.php'>
        	<span>
            	Home
            </span>
        </a>
   </li>
   
   <li class='has-sub'>
   		<a href='#'>
        	<span>
            	Waterpoints
            </span>
        </a>
      	<ul>
         	<li class='has-sub'>
                <a href='manage_waterpoints.php?regional_office_id=<?php echo $session_regional_office_id; ?>' target='_blank'>	
                    <span>View Waterpoint List</span>
                </a>
            </li>
      	</ul>
   </li>
   
   <li class='has-sub'>
   		<a href='#'>
        	<span>
            	Issue Tracker
            </span>
        </a>
      	<ul>
         	<li class='has-sub'>
            	<a href='create_issue.php'>
                	<span>
                    	Create Issue
                    </span>
                </a>
            </li>
         	<li class='has-sub'>
            	<a href='unassigned_issues.php?regional_office_id=<?php echo $session_regional_office_id; ?>'>
                	<span>
                    	Assign CSA/FA
                    </span>
                </a>
            </li>
		 	<li class='has-sub'>
            	<a href='unsolved_issues.php?regional_office_id=<?php echo $session_regional_office_id; ?>'>
                	<span>
                    	Unsolved Issue
                    </span>
                </a>
            </li>
		 	<li class='has-sub'>
            	<a href='solved_issues.php?regional_office_id=<?php echo $session_regional_office_id; ?>'>
                	<span>
                    	Solved Issues
                    </span>
                </a>
            </li>
            <li class='has-sub'>
            	<a href='prototype.php?regional_office_id=<?php echo $session_regional_office_id; ?>'>
             		<span>
                    	Prototype
                    </span>
                </a>
            </li>
         	<li class='has-sub'>
            	<a href='all_cases.php?regional_office_id=<?php echo $session_regional_office_id; ?>'>
             		<span>
                    	All Cases
                    </span>
                </a>
            </li>
      	</ul>
	</li>
	
    <li class='has-sub'>
    	<a href='#'>
        	<span>
            	Chlorine Delivery
            </span>
        </a>
      	<ul>
         	<li class='has-sub'>
            	<a href='#'>
                	<span>
                    	Delivery Form
                    </span>
                </a>
            </li>
         	<li class='has-sub'>
            	<a href='#'>
                	<span>
                    	View/Edit Deliveries
                    </span>
                </a>
            </li>
      	</ul>
	 </li>   
   <li class='last'><a href='logout.php'><span>Logout</span></a></li>
</ul>