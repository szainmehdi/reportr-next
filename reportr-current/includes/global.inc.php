<?php


//ini_set("display_errors", 1);
//ini_set("track_errors", 1);
//ini_set("html_errors", 1);
//error_reporting(E_ALL);


require_once 'classes/DB.class.php';
require_once 'classes/Employee.class.php';
require_once 'classes/EmployeeTools.class.php';
require_once 'classes/Job.class.php';
require_once 'classes/JobTools.class.php';
require_once 'classes/JobTools.class.php';
require 'includes/strings.inc.php';

session_start();
//$_SESSION["companyID"]= "twpackaging";
 
//refresh session variables if logged in
if(isset($_SESSION['companyID'])) {
	require 'includes/settings.inc.php';
    $db = new DB("");
	$db->connect();
}
else { 
	header("Location: login.php");	
}

date_default_timezone_set("America/Los_Angeles");
$Reportr_version = "1.2";

/* KNOWN ISSUES

	1000 - EMP CLOCKS OUT EVEN WHEN ERROR OCCURS, ERROR WHEN USER IS ON CLOCK FOR TWO DATES
	1001 - VARIOUS HIDDEN ERRORS, NEED TO BE CLEANED UP

*/

?>
