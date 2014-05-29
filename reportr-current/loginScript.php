<?php 
session_start();
//login.blade.php

require_once 'classes/DB.class.php';
require_once 'classes/Employee.class.php';
require_once 'classes/EmployeeTools.class.php';
require_once 'classes/Job.class.php';
require_once 'classes/JobTools.class.php';

date_default_timezone_set("America/Los_Angeles");

$numberPattern = "/([0-9]{1,})|([0-9]{1,}\.[0-9]{1,})|(\.[0-9]{1,})/";
$wordPattern = "/(^[a-zA-Z0-9_\. ]{2,}$){1,}/";
$cardPattern = "/\;[0-9]{3,}\?/";

//initialize php variables used in the form

$db = new DB("reportr_web");
$db->connect();
$cID = "";
$pwd = "";
$error = "";
$success = true;

//check to see that the form has been submitted

if(isset($_GET['companyID'])) { 

	//retrieve the $_POST variables
	$cID = $_GET['companyID'];
	$pwd = $_GET['password'];
	
	//initialize variables for form validation
	
	//validate that the form was filled out correctly
	//check to see if user name already exists
	if($cID=="") {
		$error .= "-1;"; //companyID is blank
		$success = false;	
	}
	if($pwd=="") {
		$error .= "-2;"; //password is blank
		$success = false;	
	}
	$exists = $db->doesThisExist("*", "companies", "companyID='$cID'");
	if(!$exists) {
		$error .= "-3;";
		$success = false; //companyID does not exist	
	}
	else {
		$password = $db->selectOne("password", "companies", "companyID='$cID'");
		if($pwd!=$password['password']) {
			$error .= "-4;";
			$success = false; //password does not match
		}
		else {
			$success = true;	
		}
	}
	if($success)
	{	
		$_SESSION["companyID"] = $cID;
		$_SESSION["login_time"] = time();
		$_SESSION["logged_in"] = 1;
		$query = "?login=success&companyID=" . $_SESSION['companyID'];
		$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
		header('HTTP/1.1 303 See Other');
		$next_page = "index.php";
		header('Location: http://' . $server_dir . $next_page . $query);
	}
	else {
		$query = "?login=failed&error=" . $error;
		$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
		header('HTTP/1.1 303 See Other');
		$next_page = "login.php";
		header('Location: http://' . $server_dir . $next_page . $query);
	
	}
}
else {
	$query = "?login=failed&error=-5;"; //No form submitted
	$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
	header('HTTP/1.1 303 See Other');
	$next_page = "login.php";
	header('Location: http://' . $server_dir . $next_page . $query);

}
?>