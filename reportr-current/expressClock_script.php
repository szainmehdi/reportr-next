<?php 

require_once "includes/global.inc.php";

//Prepare the JobTools object
$jTools = new JobTools();
$empTools = new EmployeeTools();
$success = true;
$error = "";
$clockedInEmployees="";
$clockedOutEmployees="";
$successcount=0;

if(isset($_GET['express'])) {
	//retrieve the $_POST variables
	$jobID = $_GET['jobID'];
	$job = $jTools->get($jobID);
	$jobNum = $job->number;
	$employees = $_GET['express'];
	$employees = array_unique($employees);
	for($i=0; $i<count($employees); $i++) {
		$empObj = $empTools->get($employees[$i]);
		$clockedIn=$empTools->isClockedIn_ID($employees[$i]);
		if($clockedIn) {
			$empObj->clockOut();
			$clockedOutEmployees .= $empObj->lname . ", " . $empObj->fname . "<br />";
		}
		else if(!$clockedIn) {
			$empObj->clockIn($jobID);
			$clockedInEmployees .= $empObj->lname . ", " . $empObj->fname . "<br />";
		}
		$successcount++;
	}
	$query="?express=success&clockedIn=$clockedInEmployees&clockedOut=$clockedOutEmployees&job=$jobNum&count=$successcount";
	$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
	header('HTTP/1.1 303 See Other');
	$next_page = 'confirmExpress.php';
	header('Location: http://' . $server_dir . $next_page . $query);
	
}
else {
	$query = isset($_GET['jobID']) ? "?jobID=" . $_GET['jobID'] . "&" : "?";
	$query.="express=failed&error=-2"; //No employees added to queue.
	$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
	header('HTTP/1.1 303 See Other');
	$next_page = 'expressClockP2.php';
	header('Location: http://' . $server_dir . $next_page . $query);
}
?>