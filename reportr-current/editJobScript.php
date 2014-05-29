<?php 
//login.blade.php

require_once 'includes/global.inc.php';

//initialize php variables used in the form
$welcome = "";
$id = "";
$number = "";
$description = "";
$customer = "";
$location = "";
$productionPerHour = "";
$peopleRequired = "";
$error = "" ;
$returnPage="editJob.php";
//check to see that the form has been submitted
if (isset($_POST['id']))  {
	//retrieve the $_POST variables
	$number = $_POST['jobNum'];
	$description = $_POST['description'];
	$customer = $_POST['customer'];
	$location = $_POST['location'];
	$productionPerHour = $_POST['prodPerHour'];
	$peopleRequired = $_POST['peopleReq'];
	$id = $_POST['id'];
	
	$returnQuery = "?jobID=$id";
	
	//initialize variables for form validation
	$success = true;
	$jobTools = new jobTools();

	//validate that the form was filled out correctly
	//check to see if user name already exists
	if(preg_match($multiWordPattern,$description)===0) {
		$error .= "-3;"; //"The description was blank!<br />";
		$success = false;	
	}
	if(preg_match($wordPattern,$customer)===0) {
		$error .= "-4;"; //"The customer was blank!<br />";
		$success = false;	
	}
	if(preg_match($wordPattern,$location)===0) {
		$error .= "-5;"; //"The location was blank!<br />";
		$success = false;	
	}
	if(preg_match($numberPattern,$productionPerHour)===0) {
		$error .= "-6;"; //"The productivity per hour was blank!<br />";
		$success = false;	
	}
	if(preg_match($numberPattern,$peopleRequired)===0) {
		$error .= "-7;"; //"The number of people required was blank!<br />";
		$success = false;	
	} 
	if($success)
	{
	    //prep the data for saving in a new user object
	    $data['number'] = $number;
		$data['description'] = $description;
		$data['customer'] = $customer;
		$data['location'] = $location;
		$data['productionPerHour'] = $productionPerHour;
		$data['peopleRequired'] = $peopleRequired;

	    //create the new user object
	    $newJob = new Job($data);
		$newJob->id=$id;

	    //save the new user to the database
		if($newJob->save()) {
			$returnPage="index.php";
			if($returnPage=="index.php") {
				$query="?editJob=success&jobNum=$number";
			}
			else {
				$query = $returnQuery . "&editJob=success&jobNum=$number";
			}
			$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
			header('HTTP/1.1 303 See Other');
			$next_page = $returnPage;
			header('Location: http://' . $server_dir . $next_page . $query);
		}
		

	}
	else {
		if($returnPage=="index.php") {
			$query="?editJob=failed&error=" . $error;
		}
		else {
			$query = $returnQuery . "&editJob=failed&error=" . $error;
		}
		$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
		header('HTTP/1.1 303 See Other');
		$next_page = $returnPage;
		header('Location: http://' . $server_dir . $next_page . $query);	 
	}

}
else {
	$error="-9;";
	$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
	$query = "?editJob=failed&error=" . $error;
	header('HTTP/1.1 303 See Other');
	$next_page = "index.php";
	header('Location: http://' . $server_dir . $next_page . $query);	
}
?>