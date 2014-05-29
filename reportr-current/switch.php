<?php 

require_once "includes/global.inc.php";

$error="";
$card = "";
$exists="";
$clockedIn = false;

//check for form submission
if(isset($_POST['cardID'])) {
	//get PHP Post Variable
	$card = $_POST['cardID'];
	if($card=="") {
		$error .= "-1;";
		$next_page="index.php";
	}
	else if(preg_match($cardPattern,$card)===0) {
		$error .= "-2;";
		$next_page="index.php";
	}
	else {
		//check if employee associated with card is clocked in
		$empTools = new EmployeeTools();
		$exists = $empTools->checkCardExists($card);
		
		if($exists) {
			$clockedIn = $empTools->isClockedIn($card);
			if($clockedIn==true) {
				$next_page = 'clockOut.php';
			}
			else if($clockedIn==false) {
				$next_page = 'clockIn.php';
			}
			$query="?cardID=$card";	
		}
		else {
			$error .= "-2;";
			$next_page = 'index.php';
		}
	}
	if($error!="") {
		$query="?clockInOut=failed&error=$error";	
	}
	$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
	header('HTTP/1.1 303 See Other');
	header('Location: http://' . $server_dir . $next_page . $query);
	
	
	
}
?>