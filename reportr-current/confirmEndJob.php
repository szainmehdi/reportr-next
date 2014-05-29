<?php 
require_once 'includes/global.inc.php';
$msg = "No form was submitted.<br /><span class='sub'>Try again or contact support.</span>";
$img = "images/clockInConfirm_visualaid_error.jpg";
//get GET variables
if(isset($_GET['error'])) {
	$msg = "An error occured. The job was not ended.<br />\n<span class='sub'>Make sure everyone is clocked out and try again.</span>";
}
else if(isset($_GET['jobLogRef']) && ($_GET['jobLogRef']!="")) {
	$jlr = $_GET['jobLogRef'];
	$result=$db->select("jobLog", "referenceNum='$jlr'");
	$prodScore = $result['productivityScore'];
	$qty = $result['qtyProduced'];
	$totalHrs = $result['totalHours'];
	$jobID = $result['jobID'];
	$jobTools = new JobTools();
	$job = $jobTools->get($jobID);
	$jobNum = $job->number; 
	
	$msg = "<span class='job'>Job $jobNum</span> was successfully ended. <br />\n<span class='sub'><strong id='qtyLabel'>QTY Produced:</strong><span id='qty'> $qty </span><br /><strong id='hrsLabel'>Total Hours:</strong><span id='hrs'> $totalHrs hrs </span><br />
<strong id='prodScoreLabel'>Productivity Score:</strong> <span id='prodScore'>$prodScore %</span></span>";	
	$img = "images/clockInConfirm_visualaid.jpg";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php require 'includes/ReportrHTML_head.inc.php'; ?>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="refresh" content="3;URL='index.php'">
    </head>
    <body>
    	<?php require 'includes/ReportrHTML_wrappersTop.inc.php'; ?>
          <div class="editableContent endJobConfirmPage">
                <div class="instructions">
                    <?php echo $msg; ?>
                    <p id="countdownP">Returning to the home screen in <span id="countdown">4 seconds</span>...</p>
                    <img src="<?php echo $img; ?>" width="236" height="239" class="visualAid" />
                    
                </div>
            </div>
            <div id="buttons" class="buttonsDiv">
                        <a class="forward" href="jobReport.php?jobLogRef=<?php if(isset($jlr) && ($jlr!="")) { echo $jlr; }?>" onClick="">create report</a>
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
	checkProdScore();
	countdown();
	//clock();

	</script>

    </body>
</html>
