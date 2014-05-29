<?php 
require_once 'includes/global.inc.php';


if(isset($_POST['companyID'])) {
    
    $id = $_POST['companyID'];
    $idMethod = $_POST['idMethod'];

	$data['setInputMethod'] = $idMethod; 

	$db_r = new DB("reportr_web");
	$db_r->connect();
    $db_r->update($data, "companies", "companyID='$id'");
	
	$query = "?settings=success";
	$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
	header('HTTP/1.1 303 See Other');
	$next_page = "index.php";
	header('Location: http://' . $server_dir . $next_page . $query);

 
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require 'includes/ReportrHTML_head.inc.php'; ?>
    </head>
    <body>
    	<?php require 'includes/ReportrHTML_wrappersTop.inc.php'; ?>
            <div class="editableContent settingsPage">
                <div class="instructions">Company Settings</div>
                <div id="form">
                    <form name="editEmployee" id="editEmployee" action="settings.php" method="post">
                    <div id="cardBox" class="inputWrapper">
                        <label for="companyID">Company ID</label>
                        <div id="companyIDInputBox" class="textbox-small">
                            <input id="companyID" name="companyID" class="input-text-small" type="text" value="<?php echo $companyID; ?>" readonly />
                        </div>
                        <span class="helpText"></span>
                    </div>
                    <div id="idMethodBox" class="inputWrapper">
                        <label for="idMethod">Employee ID Entry Method</label><br />
                            <input type="radio" name="idMethod" id="timecardRadio" value="0" <?php if ($setInputMethod==0) { echo "checked"; } ?> /><label class="radio" for="timecardRadio">Timecard + Card Reader</label> <br />
                            <input type="radio" name="idMethod" id="keyboardRadio" value="1" <?php if ($setInputMethod==1) { echo "checked"; } ?>><label class="radio" for="keyboardRadio">Keyboard Entry</label>
                        <span class="helpText"></span>
                    </div>
                    </form>
                </div>
                <div id="buttons" class="buttonsDiv">
                    <a class="back" href="index.php">&lt; back</a>
                    <a class='forward' href='#' onClick='submitForm();'>save</a>
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
