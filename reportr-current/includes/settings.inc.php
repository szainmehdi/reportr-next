<?php

$db_super = new DB("reportr_web");
$db_super->connect();
$companyID=$_SESSION['companyID'];
$resultVar=$db_super->select("companies", "companyID='$companyID'");
$setInputMethod = $resultVar['setInputMethod'];    //0 = timecard | 1 = keyboard\


// --- SETTINGS ASSIGNED --- ///
//REGEX Patterns
$numberPattern = "/([0-9]{1,})|([0-9]{1,}\.[0-9]{1,})|(\.[0-9]{1,})/";
$wordPattern = "/(^[a-zA-Z0-9_\. ]{1,}$){1,}/";
$multiWordPattern = "/(^.{1,}$){1,}/";
$cardPattern = "/\;[0-9]{3,}\?/";


//input method
if($setInputMethod==0) {
    $string_inputMethod_instructions = 
		$string_inputMethod_instructions_0;
		
    $string_inputMethod_type = 
		$string_inputMethod_type_0;
	
	$string_inputMethod_actionPast = 
		$string_inputMethod_actionPast_0;
		
    $string_inputMethod_expressClockInstructions = 
		$string_inputMethod_expressClockInstructions_0;
		
    $string_inputMethod_hint = 
		$string_inputMethod_hint_0;
		
    $cardPattern = 
		$string_inputMethod_cardPatternRegEx_0;
		
	$string_inputMethod_visualAid =
		$string_inputMethod_visualAid_0;
}
else if($setInputMethod==1) {
	
    $string_inputMethod_instructions = 
		$string_inputMethod_instructions_1;
		
    $string_inputMethod_type = 
		$string_inputMethod_type_1;
		
	$string_inputMethod_actionPast = 
		$string_inputMethod_actionPast_1;
		
    $string_inputMethod_expressClockInstructions = 
		$string_inputMethod_expressClockInstructions_1;
		
    $string_inputMethod_hint = 
		$string_inputMethod_hint_1;
		
    $cardPattern = 
		$string_inputMethod_cardPatternRegEx_1;
		
	$string_inputMethod_visualAid =
		$string_inputMethod_visualAid_1;
}

// <?php echo $string_inputMethod_instructions; ?

?>
