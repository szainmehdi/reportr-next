<?php 

require_once "includes/global.inc.php";

//Prepare the JobTools object
$jTools = new JobTools();
$empTools = new EmployeeTools();
$success = true;
$error = "";


//retrieve the $_POST variables
$card = $_GET['q'];

/* if($card=="") {
	$success=false;
	$error.="-1;"; //Blank card
} */
$emp = $empTools->getWithCard($card);
if($emp->id!="") {
	echo "<div id='expressBox" . $emp->id . "' class='expressBox'><input type='checkbox' name='express[]' id='express" . $emp->id . "' value='" . $emp->id ."' checked='checked' /><span class='label'>" . $emp->lname . ", " . $emp->fname . "&nbsp;</span><a class='expressRemove' href='#' onclick=\"removeExpressEntry('expressBox" . $emp->id . "');\" >x</a></div>";
}
else {
	echo "<div id='error' class='expressBox'>Error: Invalid $string_inputMethod_type ($card).<a class='expressRemove' href='#' onclick=\"removeExpressEntry('error');\" >x</a></div>";
}


?>