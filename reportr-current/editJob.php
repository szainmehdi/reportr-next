<?php 
require_once 'includes/global.inc.php';

//initialize php variables used in the form
$jTools = new JobTools();
$job = new stdClass();
$success = true;

if(isset($_GET['jobID'])) {
	$jobID = $_GET['jobID'];
	if($jTools->checkJobExistsUsingID($jobID) == false) {
		$success=false;	
	}
	if($success) {
		$job = $jTools->get($jobID);
	}
	else {
		$query = "?editJob=failed&error=-1;";
		$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
		header('HTTP/1.1 303 See Other');
		$next_page = "index.php";
		header('Location: http://' . $server_dir . $next_page . $query);
	}
	
	
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require 'includes/ReportrHTML_head.inc.php'; ?>
    </head>
    <body>
    	<?php require 'includes/ReportrHTML_wrappersTop.inc.php'; ?>
            <div class="editableContent editJobPage">
                <div class="instructions">Edit a job.</div>
                <div id="form">
                    <form name="editJob" id="editJob" action="editJobScript.php" method="post">
                    <input type="hidden" id="id" name="id" value="<?php echo $jobID; ?>" />
                    <div id="jobNumBox" class="inputWrapper">
                        <label for="jobNum">Job Number</label>
                        <div id="jobNumInputBox" class="textbox-small">
                            <input id="jobNum" name="jobNum" class="input-text-small" type="text" value="<?php echo $job->number; ?>" readonly />
                        </div>
                        <span class="helpText">(You cannot change this.)</span>
                    </div>
                     <div id="jobCustBox" class="inputWrapper">
                        <label for="jobCustInput">Customer Code</label>
                        <div id="jobCustInputBox" class="textbox-small">
                            <input id="jobCustInput" name="customer" class="input-text-small" value="<?php echo $job->customer; ?>" type="text" onFocus="focusTextField('jobCustInputBox', 'small', 1)" onBlur="focusTextField('jobCustInputBox', 'small', 0)" />
                        </div>
                        <span class="helpText">(eg. ABI, WALMART, DFI)</span>
                    </div>
                    <div id="jobLocBox" class="inputWrapper">
                        <label for="jobLocInput">Location</label>
                        <div id="jobLocInputBox" class="textbox-small">
                            <input id="jobLocInput" name="location" class="input-text-small"  value="<?php echo $job->location; ?>" type="text" onFocus="focusTextField('jobLocInputBox', 'small', 1)" onBlur="focusTextField('jobLocInputBox', 'small', 0)" />
                        </div>
                        <span class="helpText">(eg. Los Angeles, NYC, Building A)</span>
                    </div>
                    <div id="jobDescBox" class="inputWrapper">
                        <label for="jobDescInput">Description</label>
                        <div id="jobDescInputBox" class="textbox-large">
                            <input id="jobDescInput" name="description" class="input-text-large" value="<?php echo $job->description; ?>" type="text" onFocus="focusTextField('jobDescInputBox', 'large', 1)" onBlur="focusTextField('jobDescInputBox', 'large', 0)" />
                        </div>
                        <!-- <span class="helpText">(eg. Shadow Sticks - Sort and Shrink Wrap)</span> -->
                    </div>
                  <div id="jobProdBox" class="inputWrapper">
                        <label for="jobProdInput">Production Per Hour</label>
                    <div id="jobProdInputBox" class="textbox-tiny">
                            <input id="jobProdInput" name="prodPerHour" class="input-text-tiny" value="<?php echo $job->productionPerHour; ?>" type="text" onFocus="focusTextField('jobProdInputBox', 'tiny', 1)" onBlur="focusTextField('jobProdInputBox', 'tiny', 0)" />
                        </div>
                      <span class="helpText">(Projected quantity produced in 1 hour)</span>
                    </div>
                    <div id="jobPEOBox" class="inputWrapper">
                        <label for="jobPEOInput"># of People Required</label>
                        <div id="jobPEOInputBox" class="textbox-tiny">
                            <input id="jobPEOInput" name="peopleReq" class="input-text-tiny" value="<?php echo $job->peopleRequired; ?>" type="text" onFocus="focusTextField('jobPEOInputBox', 'tiny', 1)" onBlur="focusTextField('jobPEOInputBox', 'tiny', 0)" />
                        </div>
                        <span class="helpText">(# of people needed to meet production goal)</span>
                    </div>
                    </form>
                </div>
                <div id="buttons" class="buttonsDiv">
                    <a class="back" href="index.php">&lt; back</a>
                    <a class='forward' href='#' onClick='submitForm();'>submit</a>
                </div>
                <?php require 'includes/ReportrHTML_msgBox.inc.php'; ?>
            </div>
        </div>
        <?php require 'includes/ReportrHTML_sidebar.inc.php'; ?>
      </div>
        </div>
        <?php //require 'includes/ReportrHTML_actionBar.inc.php'; ?>
    	<?php require 'includes/ReportrHTML_footer.inc.php'; ?>
   	</div>
    <script type="text/javascript">

    //On pageload
	window.onload = start();
	clock();
	selectTextFieldById('jobCustInput');

	</script>

    </body>
</html>
