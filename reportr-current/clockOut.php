<?php 
//clockOut.php

require_once 'includes/global.inc.php';

//initialize php variables used in the form
//$welcome = "";
$card = "";
$empID = "";
$msg = "";
//check to see that the form has been submitted
if(isset($_GET['cardID'])) { 

	//retrieve the $_POST variables
	$card = $_GET['cardID'];
	
	//initialize variables for form validation
	$success = true;
	$eTools = new EmployeeTools();
	
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
		$empID=$result['id'];
		$employee = $eTools->get($empID);
		$hours = $employee->clockOut();
		$name = $employee->fname . " " . $employee->lname;
		
		if($hours>=0) {
			$query = "?name=" . $name . "&hours=" .	$hours;
		}
		else {
			$query = "?error=1";	
		}
		
		$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
		header('HTTP/1.1 303 See Other');
		$next_page = 'confirmClockOut.php';
		header('Location: http://' . $server_dir . $next_page . $query);
	}
}	
?>

<html>
<head>
	<title>Clocking Out...</title>
</head>
<body>
</body>
</html>