<?php 
require_once 'includes/global.inc.php';
$msg = "No form was submitted.<br /><span class='sub'>Try again or contact support.</span>";
$img = "images/clockInConfirm_visualaid_error.jpg";
//get GET variables
if(isset($_GET['error'])) {
	$msg = "An error occured. You were not clocked in.<br />\n<span class='sub'>Try again or ask for help.</span>";
}
if(isset($_GET['job'])) {
	$out = (isset($_GET['clockedOut']) ? $_GET['clockedOut'] : "");
	$in = (isset($_GET['clockedIn']) ? $_GET['clockedIn'] : "");
	$job = (isset($_GET['job']) ? $_GET['job'] : "");
	$count = (isset($_GET['count']) ? $_GET['count'] : "0");
	
	$msg = "<span class='name'>Job $job</span><br />Express Clock In & Out successful. <br /><span id='count'>Total Count: $count</span><br /><br />\n<span class='sub'><strong>Clocked In:</strong><div id='clockedInDiv'>$in</div><br /><strong>Clocked Out:</strong><div id='clockedOutDiv'>$out</div></span>";	
	$img = "images/clockInConfirm_visualaid.jpg";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php require 'includes/ReportrHTML_head.inc.php'; ?>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="refresh" content="5;URL='index.php'">
    </head>
    <body>
    	<?php require 'includes/ReportrHTML_wrappersTop.inc.php'; ?>
          <div class="editableContent expressConfirmPage">
                <div class="instructions">
                    <?php echo $msg; ?>
                    <p id="countdownP">Returning to the home screen in <span id="countdown">6 seconds</span>...</p>
                </div>
            </div>
        </div>
        <?php require 'includes/ReportrHTML_sidebar.inc.php'; ?>
        </div>
        </div>
    	<?php require 'includes/ReportrHTML_footer.inc.php'; ?>
   	</div>
    <script type="text/javascript">

    //On pageload
	window.onload = start();
	countdown();

	</script>

    </body>
</html>
