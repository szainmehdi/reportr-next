<?php 
//login.blade.php

require_once 'includes/global.inc.php';

//initialize php variables used in the form
$welcome = "";
$id = "";
$card = "";
$fname = "";
$lname = "";
$error = "";
$success = false;


if (isset($_POST['id']))  {
	
	//retrieve the $_POST variables
	$id = $_POST['id'];
	$card = $_POST['cardID'];
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$name = $fname . " " . $lname;
	
	
	//initialize variables for form validation
	$valid = true;
	$employeeTools = new EmployeeTools();
	
	if(preg_match($wordPattern, $fname)===0) {
		$error .= '-1;'; //First name invalid!<br />";
		$valid = false;	
	}
	if(preg_match($wordPattern, $lname)===0) {
		$error .= '-2;'; //Last name invalid!<br />";
		$valid = false;	
	}
	if(isset($_POST['delete'])) {
		$del = $_POST['delete'];
		if($del == "delete") {
			$employeeTools->deleteEmployee($id);
			$success = true;
			$query = "?editEmployee=success&name=" . $name . "&msg=deleted";
			$valid = false;
		}
	}
	if($valid)
	{
		//prep the data for saving in a new user object
	    $data['card'] = $card;
	    $data['fname'] = $fname; 
	    $data['lname'] = $lname;
		$updatedEmployee = new Employee($data);
		$updatedEmployee->id=$id;
		if($updatedEmployee->save()) {
			$success = true;
			$query = "?editEmployee=success&name=" . $name . "&msg=updated";
		}
		else {
			$success=false;
			$error.="-3;"; //Error updating user.";
		}
	}
	if($success==false) {
		$query = "?editEmployee=failed&error=" . $error;
	}
	$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
	header('HTTP/1.1 303 See Other');
	$next_page = "index.php";
	header('Location: http://' . $server_dir . $next_page . $query);

}
?>
