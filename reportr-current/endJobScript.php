<?php 

require_once "includes/global.inc.php";

//Prepare the JobTools object
$jTools = new JobTools();
$success = true;
$error = "";


//retrieve the $_POST variables
$openJobRef = (isset($_POST['open-job-ref'])) ? $_POST['open-job-ref'] : "";
$qty = (isset($_POST['qtyProduced'])) ? $_POST['qtyProduced'] : "";
$comments = (isset($_POST['comments'])) ? $_POST['comments'] : NULL;
$setup = (isset($_POST['setupTime'])) ? $_POST['setupTime'] : 0;

if($openJobRef=="") {
	$success=false;
	$error.="-1;"; //No Job Selected	
}
if(preg_match($numberPattern,$qty)===0) {
	$success=false;
	$error.="-2;"; //no qty entered	
}
if($jTools->isOpenJobActive($openJobRef)) {
	$success=false;
	$error .= "-3"; //"Someone is still clocked in to this job.\n";
}
if($success) {
	$next_page = 'confirmEndJob.php';
	
	//send the variables to the function endJob();
	$result = $jTools->endJob($openJobRef, $qty, $setup, $comments);
	if($result<0) {
		$query = "?error=$result";
	}
	else if($result>0) {
		$query="?jobLogRef=$result";
	}
}
else {
	$next_page = "endJob.php";
	$query = "?endJob=failed&error=$error";
}
$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
header('HTTP/1.1 303 See Other');
header('Location: http://' . $server_dir . $next_page . $query);

?>