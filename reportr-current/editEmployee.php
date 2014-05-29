<?php 
require_once 'includes/global.inc.php';

//initialize php variables used in the form
$eTools = new EmployeeTools();
$empID= "";
$empFname = "";
$empLname = "";
$card = "";
$employee = new stdClass();
$success = true;

if(isset($_GET['card'])) {
	$card = $_GET['card'];
	if(preg_match($cardPattern, $card) === 0) {
		$success=false;
	}
	if($eTools->checkCardExists($card) == false) {
		$success=false;	
	}
	if($success) {
		$employee = $eTools->getWithCard($card);
		
		$empFname = $employee->fname;
		$empLname = $employee->lname;
		$empID	  = $employee->id;
	}
	else {
		$query = "?editEmployee=failed&error=-4;";
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
            <div class="editableContent editEmployeePage">
                <div class="instructions">Edit an employee.</div>
                <div id="form">
                    <form name="editEmployee" id="editEmployee" action="editEmployeeScript.php" method="post">
                    <input type="hidden" id="id" name="id" value="<?php echo $empID; ?>" />
                    <div id="cardBox" class="inputWrapper">
                        <label for="cardID"><?php echo $string_inputMethod_type; ?></label>
                        <div id="cardIDInputBox" class="textbox-small">
                            <input id="cardID" name="cardID" class="input-text-small" type="text" value="<?php echo $card; ?>" readonly />
                        </div>
                        <span class="helpText"></span>
                    </div>
                    <div id="fnameBox" class="inputWrapper">
                        <label for="fname">First Name</label>
                        <div id="fnameInputBox" class="textbox-small">
                            <input id="fname" name="fname" class="input-text-small" type="text" autofocus value="<?php echo $empFname; ?>" onFocus="focusTextField('fnameInputBox', 'small', 1)" onBlur="focusTextField('fnameInputBox', 'small', 0)" />
                        </div>
                        <span class="helpText"></span>
                    </div>
                    <div id="lnameBox" class="inputWrapper">
                        <label for="lname">Last Name</label>
                        <div id="lnameInputBox" class="textbox-small">
                            <input id="lname" name="lname" class="input-text-small" type="text" value="<?php echo $empLname; ?>" onFocus="focusTextField('lnameInputBox', 'small', 1)" onBlur="focusTextField('lnameInputBox', 'small', 0)" />
                        </div>
                        <span class="helpText"></span>
                    </div>
                    <div id="deleteBox" class="inputWrapper">
                    	<input type="checkbox" id="delete" name="delete" value="delete" onChange="deleteEmployee();" />
                    	<label for="delete"><img src="images/actionBar/ic_action_delete.png" id="deleteIcon" /> delete employee</label>
                        
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

	</script>

    </body>
</html>
