<?php
//register.php
require_once 'includes/global.inc.php';

//initialize php variables used in the form
$number = "";
$description = "";
$customer = "";
$location = "";
$productionPerHour = "";
$peopleRequired = "";
$error = "" ;

//check to see that the form has been submitted
if(isset($_POST['submit-form'])) { 

	//retrieve the $_POST variables
	$number = $_POST['number'];
	$description = $_POST['description'];
	$customer = $_POST['customer'];
	$location = $_POST['location'];
	$productionPerHour = $_POST['prodPerHour'];
	$peopleRequired = $_POST['peopleReq'];

	//initialize variables for form validation
	$success = true;
	$jobTools = new jobTools();

	//validate that the form was filled out correctly
	//check to see if user name already exists
	if($jobTools->checkJobExists($number))
	{
	    $error .= "That job number has already been entered. Enter a different job number or go to the edit page to make changes.<br/> \n\r";
	    $success = false;
	}
	if($number=="") {
		$error .= "The job number was blank!<br />";
		$success = false;	
	}
	if($description=="") {
		$error .= "The description was blank!<br />";
		$success = false;	
	}
	if($customer=="") {
		$customer .= "The customer was blank!<br />";
		$success = false;	
	}
	if($location=="") {
		$error .= "The location was blank!<br />";
		$success = false;	
	}
	if($productionPerHour=="") {
		$error .= "The productivity per hour was blank!<br />";
		$success = false;	
	}
	if($peopleRequired=="") {
		$error .= "The number of people required was blank!<br />";
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

	    //save the new user to the database
	    $newJob->save(true);

	    //redirect them to a welcome page
	    header("Location: index.php");

	}

}
else if(isset($_GET['return-page'])) {
	//retrieve the $_POST variables
	$number = $_GET['number'];
	$description = $_GET['description'];
	$customer = $_GET['customer'];
	$location = $_GET['location'];
	$productionPerHour = $_GET['prodPerHour'];
	$peopleRequired = $_GET['peopleReq'];
	$returnPage = $_GET['return-page'];
	$returnQuery = $_GET['return-query'];
	
	

	//initialize variables for form validation
	$success = true;
	$jobTools = new jobTools();

	//validate that the form was filled out correctly
	//check to see if user name already exists
	if($jobTools->checkJobExists($number))
	{
	    $error .= "-1;"; //That job number has already been entered. Enter a different job number or go to the edit page to make changes.<br/> \n\r";
	    $success = false;
	}
	if(preg_match($wordPattern,$number)===0) {
		$error .= "-2;"; //"The job number was blank or is invalid!<br />";
		$success = false;	
	}
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

	    //save the new user to the database
	    $newJob->save(true);
		if($returnPage=="index.php") {
			$query="?newJob=success&jobNum=$number";
		}
		else if ($returnQuery=="") {
			$query="?newJob=success&jobNum=$number";
		}
		else {
			$query = $returnQuery . "&newJob=success&jobNum=$number";
		}
		$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
		header('HTTP/1.1 303 See Other');
		$next_page = $returnPage;
		header('Location: http://' . $server_dir . $next_page . $query);

	}
	else {
		if($returnPage=="index.php") {
			$query="?newJob=failed&error=" . $error;
		}
		else if ($returnQuery=="") {
			$query="?newJob=failed&error=" . $error;
		}
		else {
			$query = $returnQuery . "&newJob=failed&error=" . $error;
		}
		$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
		header('HTTP/1.1 303 See Other');
		$next_page = $returnPage;
		header('Location: http://' . $server_dir . $next_page . $query);	
	}
	
}

//If the form wasn't submitted, or didn't validate
//then we show the registration form again
?>

<html>
<head>
	<title>Registration</title>
</head>
<body>
	<h1> New Job </h1>
	
	<?php echo ($error != "") ? $error : ""; ?>
	
    
    <form action="newJob.php" method="post">

	Job #:<br>
	<input type="text" value="" name="number" /><br/>
	Description:<br>
	 <input type="text" value="" name="description" /><br/>
	Customer:<br>
	 <input type="text" value="" name="customer" /><br/>
	Location: <br>
	<input type="text" value="" name="location" /><br/>
	Productivity Per Hour: <br>
	<input type="text" value="" name="prodPerHour" /><br/>
	Number People Required: <br>
	<input type="text" value="" name="peopleReq" /><br/>


	<input type="submit" value="Save" name="submit-form" />

	</form>
</body>
</html>