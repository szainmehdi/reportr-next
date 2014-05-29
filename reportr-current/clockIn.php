<?php 
require_once 'includes/global.inc.php';

//initialize php variables used in the form
$card = "";
$jobID = "";
$error = "";
$name = "";
//check to see that the form has been submitted
if(isset($_GET['cardID'])) { 

	//retrieve the $_POST variables
	$card = $_GET['cardID'];
	
	//initialize variables for form validation
	$success = true;
	$employeeTools = new EmployeeTools();
	$jobTools = new JobTools();
	
	//validate that the form was filled out correctly
	//check to see if user name already exists
	if($card=="") {
		$error .= "The card number was blank!<br />";
		$success = false;	
	}
	if($success)
	{	
		$emp = $employeeTools->getWithCard($card);
		
		$name = $emp->lname . ", " .  $emp->fname;
		$totalHours = $emp->getWeeklyHours();

	}
	
}
else {
	$error = "No form submitted.";	
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require 'includes/ReportrHTML_head.inc.php'; ?>
        <script type="text/javascript">
			$(document).ready(function () {
				$('#searchBox').bind('keydown keypress keyup change', function() {
					var search = this.value;
					var $li = $("#data label").hide();
					$li.filter(function() {
						return $(this).text().toLowerCase().indexOf(search.toLowerCase()) >= 0;
					}).show();
				});
			});
		</script>
    </head>
    <body> 
    	<?php require 'includes/ReportrHTML_wrappersTop.inc.php'; ?>
            <div class="editableContent clockInPage">
                <div id="personBox">
                	<div class="employeePic"></div>
                	<p class="employeeName"><?php echo $name; ?></p>
                    <p class="employeeCard"><span class="label">ID </span><?php echo $card; ?><!-- <span class="prefix">;</span>007<span class="postfix">? --></span></p>
                    <p class="employeeHours"><span class="label">Total Hours</span> <span class="hours"><?php echo $totalHours; ?> hrs</span></p>
                </div>
                <div class="instructions">
                    Select a job to clock in.
                </div>
                <div id="formBox">
                    <a href="#" id="newJobButton" onClick="openBox('newJobForm');dimButtonBar();">new</a>
                    <div id="searchDiv">
                    	<img id="searchIcon" src="images/actionBar/2_action_search.png" /> 
                        <div id="searchInputDiv" class="inputWrapper">
                            <div id="searchInputBox" class="textbox-small">
                                <input id="searchBox"  class="input-text-small" type="text" onFocus="focusTextField('searchInputBox', 'small', 1);focusSearchField('searchInputBox', 'searchBox', 'searchHelp', 1);" onBlur="focusTextField('searchInputBox', 'small', 0);focusSearchField('searchInputBox', 'searchBox', 'searchHelp', 0);" />
                                <div id="searchHelp">search jobs...</div>
                            </div>
                        </div>
                    </div>
                    <div class="selectAJob">
                        <form name="jobNumForm" id="jobNumForm" action="clockInScript.php" method="post">
                            <input type="hidden" name="empID" id="empID" value="<?php echo $emp->id; ?>" />
							<div id="data">
								<?php $jobTools->listAllJobs_RADIO(); ?>
                            </div>
                      </form>
                    </div>
                </div>
                <?php require 'includes/ReportrHTML_newJobForm.inc.php'; ?>
                <?php require 'includes/ReportrHTML_msgBox.inc.php'; ?>
                <div id="buttons" class="buttonsDiv">
                    <a class="back" href="index.php">&lt; back</a>
                    <a class="forward" href="#" onClick="submitForm();">next &gt;</a>
                </div>
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

	</script>

    </body>
</html>
