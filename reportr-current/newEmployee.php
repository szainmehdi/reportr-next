<?php
ini_set("display_errors", 1);
ini_set("track_errors", 1);
ini_set("html_errors", 1);
error_reporting(E_ALL);

//register.php
require_once 'includes/global.inc.php';

//initialize php variables used in the form
$card = "";
$fname = "";
$lname = "";
$error = "";
$query = "";

//check to see that the form has been submitted
if(isset($_GET['card'])) { 

	//retrieve the $_POST variables
	$card = $_GET['card'];
	$fname = $_GET['fname'];
	$lname = $_GET['lname'];
	$returnPage = $_GET['return-page'];
	$returnQuery = $_GET['return-query'];

	//initialize variables for form validation
	$success = true;
	$employeeTools = new EmployeeTools();

	//validate that the form was filled out correctly
	//check to see if user name already exists
	if(preg_match($cardPattern,$card)===0) {
		$error .= "-2;"; //"The card number was blank!<br />";
		$success = false;	
	}
	if($employeeTools->checkCardExists($card))
	{
	    $error .= "-1;"; //"That card number has already been taken. Use a different card.<br/> \n\r";
	    $success = false;
	}
	if(preg_match($wordPattern,$fname)===0) {
		$error .= "-3;"; //"The first name was blank!<br />";
		$success = false;	
	}
	if(preg_match($wordPattern,$lname)===0) {
		$error .= "-4;"; //"The last name was blank!<br />";
		$success = false;	
	}
	if($success)
	{
	    //prep the data for saving in a new user object
	    $data['card'] = $card;
	    $data['fname'] = $fname; 
	    $data['lname'] = $lname;

	    //create the new user object
	    $newEmployee = new Employee($data);

	    //save the new user to the database
	    $newEmployee->save(true);
		
		if($returnPage=="index.php") {
			$query="?newEmployee=success&fname=$fname&lname=$lname";
		}
		else {
			$query = $returnQuery . "?newEmployee=success&fname=$fname&lname=$lname";
		}
		$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
		header('HTTP/1.1 303 See Other');
		$next_page = $returnPage;
		header('Location: http://' . $server_dir . $next_page . $query);

	}
	else {
		if($returnPage=="index.php") {
			$query="?newEmployee=failed&error=" . $error;
		}
		else {
			$query = $returnQuery . "?newEmployee=failed&error=" . $error;
		}
		$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
		header('HTTP/1.1 303 See Other');
		$next_page = $returnPage;
		header('Location: http://' . $server_dir . $next_page . $query);
	}

}