<?php 
require_once 'includes/global.inc.php';

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require 'includes/ReportrHTML_head.inc.php'; ?>
    </head>
    <body>
    	<?php require 'includes/ReportrHTML_wrappersTop.inc.php'; ?>
            <div class="editableContent homePage" id="editableContent">
                <div id="screen">
                  
				</div>
                <div class="instructions">
                    <?php echo $string_inputMethod_instructions; ?><br>
					to clock in or out. <img src="<?php echo $string_inputMethod_visualAid; ?>" class="visualAid" alt="Timecard Image" />
                </div>
                <div id="cardIDinputBox">
                    <form action="switch.php" method="post" id="submit-form" name="submit-form" onSubmit="return validateForm()">
                        <input id="cardID" name="cardID" type="password" class="textField" maxlength="10" onFocus="focusTextField('cardIDinputBox', 'large', 1)" onBlur="focusTextField('cardIDinputBox', 'large', 0)" />
                  	</form>
                </div>
                <div id="buttons" class="buttonsDiv">
                    <a class="back" href="javascript:clearTextField('cardID');">&lt; clear</a>
                    <a class="forward" href="#" onClick="javascript:submitForm();">next &gt;</a>
                </div>
                <?php require 'includes/ReportrHTML_msgBox.inc.php'; ?>
                <?php require 'includes/ReportrHTML_newJobForm.inc.php'; ?>
                <?php require 'includes/ReportrHTML_newEmployeeForm.inc.php'; ?>
                <?php require 'includes/ReportrHTML_editEmployeeForm.inc.php'; ?>
                <?php require 'includes/ReportrHTML_editJobForm.inc.php'; ?>
                <?php require 'includes/ReportrHTML_createReportForm.inc.php'; ?>
                
          </div>
        </div>
        <?php require 'includes/ReportrHTML_sidebar.inc.php'; ?>
        </div>
        </div>
        <?php require 'includes/ReportrHTML_actionBarNew.inc.php'; ?>
    	<?php require 'includes/ReportrHTML_footer.inc.php'; ?>
   	</div>
    <script type="text/javascript">

    //On pageload
	window.onload = start();selectTextField();

	</script>

    </body>
</html>
