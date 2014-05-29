<?php 
require_once 'includes/global.inc.php';

$error = "";
$success=true;

//check to see that the form has been submitted
if(isset($_POST['prevQuery'])) { 
	
	$next_page = (isset($_POST['prevPage']) ? $_POST['prevPage'] : "jobReport.php");
	$prev_query = $_POST['prevQuery'];
	
	//OOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO//
	//        ERROR HANDLING			//
	//OOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO//
	
	//get POSTDATA
	$qty = $_POST['qty'];
	$eaCost = $_POST['eaCost'];
	$rate = $_POST['incentiveRate'];
	$hrs = $_POST['totalHrs'];
	
	if($rate=="") {
		//Empty rate
		$error .= "-1;";
		$success=false;
	}
	if($rate=="") {
		//qty blank
		$error .= "-2;";
		$success=false;
	}
	if($eaCost=="") {
		//cost blank
		$error .= "-3;";
		$success=false;
	}
	//OOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO//
	//    CALCULATE AND RETURN			//
	//OOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO//
	if($success) {
		$rate = $rate/100;
		$totalCost = $eaCost * $qty;
		$totalIncentive = $rate * $totalCost;
		$hourlyIncentive = $totalIncentive/$hrs;
		
		$query = $prev_query . "&calcIncentive=success&totalIncentive=" . $totalIncentive;
		$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
		header('HTTP/1.1 303 See Other');
		header('Location: http://' . $server_dir . $next_page . $query);
	}
	else {
		$query = $prev_query . "&calcIncentive=failed&error=" . $error;
		$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
		header('HTTP/1.1 303 See Other');
		header('Location: http://' . $server_dir . $next_page . $query);	
	}
}
else {
	$query = "?calcIncentive=failed&error=-4;";
	$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
	header('HTTP/1.1 303 See Other');
	header('Location: http://' . $server_dir . "index.php" . $query);
}
?>