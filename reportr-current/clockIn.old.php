<?php 
//clockIn.php

require_once 'includes/global.inc.php';

//initialize php variables used in the form
$welcome = "";
$card = "";
$jobID = "";
$error = "";
//check to see that the form has been submitted
if(isset($_POST['cardID'])) { 

	//retrieve the $_POST variables
	$card = $_POST['cardID'];
	
	//initialize variables for form validation
	$success = true;
	$employeeTools = new EmployeeTools();
	
	//validate that the form was filled out correctly
	//check to see if user name already exists
	if($card=="") {
		$error .= "The card number was blank!<br />";
		$success = false;	
	}
	if($success)
	{	
		$where = "card = '$card'";
		$result = $db->select('employees', $where);
		
		$name = $result['fname'] . " " .  $result['lname'];

	}
	
}
else if(isset($_POST['clock-in'])) {
	//retrieve the $_POST variables
	$empID = $_POST['employee-ID'];
	$jobID = $_POST['job-number'];
	
	//Prepare the Employee Object
	$eTools = new EmployeeTools();
	$employee = $eTools->get($empID);
	
	$employee->clockIn($jobID);
	header("Location: index.php");
	
}
else {
	$error = "No form submitted.";	
}
?>
<html>
<head>
	<title>Login</title>
</head>
<body>
	<h1><?php echo ($welcome != "") ? $welcome : ""; ?></h1>
	<?php echo ($error != "") ? $error : ""; ?>
	
    <h3>Welcome, <?php echo $name; ?>. Select a Job to clock in to:</h3>
    
 
    <a href="newJob.php">New Job</a><br /><br />
    
    <form action="clockIn.php" method="post">    
	Job Number<br>
    <input type="text" name="employee-ID" value="<?php echo $result['id']; ?>" readonly style="display: none;" />
	<select name="job-number">
    	<?php $jtools = new JobTools(); 
				$jtools->listAllJobs(); ?>
    </select>
	<button type="submit" name="clock-in" value="clock-in">Clock In</button>
	</form>
</body>
</html>