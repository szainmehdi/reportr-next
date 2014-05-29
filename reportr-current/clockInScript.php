<?php 
require_once 'includes/global.inc.php';

//initialize php variables used in the form
$card = "";
$jobID = "";
$error = "";
$name = "";

if(isset($_POST['empID'])) {
	//retrieve the $_POST variables
	$empID = (isset($_POST['empID']) ? $_POST['empID'] : "");
	$jobID = (isset($_POST['jobID']) ? $_POST['jobID'] : "");
	$success=true;
	$error="";
	$query="";
	
	if($empID=="") {
		$success=false;
		$error.="-1;"; //No employee
	}
	if($jobID=="") {
		$success=false;
		$error.="-2;"; //No job selected
	}
	if($success) {
		//Prepare the Employee Object
		$eTools = new EmployeeTools();
		$employee = $eTools->get($empID);
		$jTools = new JobTools();
		$job=$jTools->get($jobID);
		
		$name = $employee->fname . " " . $employee->lname;
		$jobNumber = $job->number;
		
		if($employee->clockIn($jobID)) {
			$query = "?name=$name&job=$jobNumber";
		}
		else {
			$$error .= "-3";
		}
	}
	else {
		$query="?error=$error";	
	}
	$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
	header('HTTP/1.1 303 See Other');
	$next_page = 'confirmClockIn.php';
	header('Location: http://' . $server_dir . $next_page . $query);	
	
}