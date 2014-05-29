<?php 
require_once 'includes/global.inc.php';

//initialize php variables used in the form
$jtools = new JobTools();
$numOJ = $jtools->getNumOfOpenJobs();
if($numOJ==0) {
	$class = "disabled";
}
else {
	$class="enabled";	
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require 'includes/ReportrHTML_head.inc.php'; ?>
    </head>
    <body>
    	<?php require 'includes/ReportrHTML_wrappersTop.inc.php'; ?>
            <div class="editableContent endJobPage">
                <div class="instructions">End a job.</div>
                <form name="endJobForm" id="endJobForm" action="endJobScript.php" method="post">
                <div id="jobBox" class="inputWrapper">
                  <label for="">Open Job</label>
                </div>
                <div id="formBox">
                    <div class="selectAJob">
							<?php $num = $jtools->listOpenJobs_RADIO(); ?>
                    </div>
                </div>
                <div id="formFields" class="<?php echo $class; ?>">
                	<div id="qtyBox" class="inputWrapper">
                    	<label for="qtyInput">Total Quantity Produced</label><br />
                    	<div id="qtyInputBox" class="textbox-small">
                            <input id="qtyInput" name="qtyProduced" class="input-text-small" type="text" onFocus="focusTextField('qtyInputBox', 'small', 1)" onBlur="focusTextField('qtyInputBox', 'small', 0)" />
                        </div>
                        <span class="helpText">(in this run only)</span>
                    </div>
                    <div id="setupTimeBox" class="inputWrapper">
                    	<label for="setupTimeInput">Setup Time</label><br />
                    	<div id="setupTimeInputBox" class="textbox-small">
                            <input id="setupTimeInput" name="setupTime" class="input-text-small" type="text" onFocus="focusTextField('setupTimeInputBox', 'small', 1)" onBlur="focusTextField('setupTimeInputBox', 'small', 0)" />
                        </div>
                        <span class="helpText">(time, in man-hours, spent on setup)</span> 
                    </div>
                    <div id="commentsBox" class="inputWrapper">
                        <label for="commentsInput">Comments</label>
                        <div id="commentsInputBox" class="textbox-textarea">
                            <textarea id="commentsInput" name="comments" class="input-textarea" onFocus="focusTextField('commentsInputBox', 'large', 1)" onBlur="focusTextField('commentsInputBox', 'large', 0)"></textarea>
                        </div>
                        <!-- <span class="helpText">(eg. Shadow Sticks - Sort and Shrink Wrap)</span> -->
                    </div>
                </div>
                </form>
                
                <div id="buttons" class="buttonsDiv">
                    <a class="back" href="index.php">&lt; back</a>
                    <?php if($numOJ!=0) { echo "<a class='forward' href='#' onClick='submitForm();'>next &gt;</a>"; } ?>
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

	</script>

    </body>
</html>
