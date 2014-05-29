<?php 
require_once 'includes/global.inc.php';

//initialize php variables used in the form
$file="";
$prev_query="";
$result = basename($_SERVER['REQUEST_URI']);
$length = strlen($result);
$index=stripos($result, "?");
if($index==false) {
	 $file = $result;	
}
else{
	$prev_query = substr($result, $index);
	$file = substr($result, 0, $index);
}
if($file=="phplearning") {
	$file="index.php";
}

$jobNum = "";
$jobLogRef = "";
$jobID = "";
$date = strtotime("0000-00-00");
$qty = "";  
$totalHours = 0;
$prodScore = "";
$prodClass = "";
$employees = "";
$timestamp = strtotime("0000-00-00");
$next_page = "index.php";
$now = date("M d, Y h:i:s a T");
$incentiveClass = "empty";

//Job Variables
$jobNum = "";
$jobDesc = "";
$jobCust = "";
$jobLoc = "";
$jobProd = "";
$jobPEO = "";
$clockLog = "";
$commentsDisplay = "show";
//check to see that the form has been submitted
if(isset($_GET['jobLogRef'])) { 
	
	$next_page = (isset($_GET['return-page'])) ? $_GET['return-page'] : "index.php";
	
	//--------------- BEGIN WORK ------------------
	
	//get the jobLogRef from the form
	$jobLogRef = $_GET['jobLogRef'];
	if(isset($_GET['totalIncentive'])) {
		$incentiveClass="active";
	}
	if($jobLogRef!="") {
		//pull the data array from the jobLog table
		$result = $db->select("jobLog", "referenceNum='$jobLogRef'");
		
		if(count($result)!=0) {
		
			//assign data to created variables
			$jobID		= 	$result['jobID'];
			$timestamp 	=   strtotime($result['date']);
			$dateF		=	date("M d, Y", $timestamp);
			$date 		= 	date("Y-m-d", $timestamp);
			$qty		=	$result['qtyProduced'];
			$totalHours = 	$result['totalHours'];
			$setup		=	$result['setupTime'];
			$prodScore  =	round($result['productivityScore']);
			$comments   = 	$result['comments'];
			if($comments==NULL) {
				$commentsDisplay = "hide";	
			}
			
			//format date
			
			
			//Create a JOB object
			$jobTools = new JobTools();
			$job = $jobTools->get($jobID);
			
			//Assign Job Variables
			$jobNum	 = $job->number;
			$jobDesc = $job->description;
			$jobCust = $job->customer;
			$jobLoc  = $job->location;
			$jobProd = $job->productionPerHour;
			$jobPEO  = $job->peopleRequired;
			
			if($prodScore>=80) {
				$prodClass = "good";
			}
			else if ($prodScore<80) {
				$prodClass = "bad";	
			}
			
			//find and get all records clocked in to this job on this day
			$clockLog = $db->select("clockLog", "jobID='$jobID' and date='$date' and jobLogRef='$jobLogRef'");
		}
	}
	else {
		$query = "?createReport=failed&error=-1";
		$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
		header('HTTP/1.1 303 See Other');
		header('Location: http://' . $server_dir . $next_page . $query);	
	}
}
else {
	$query = "?createReport=failed&error=-2";
	$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
	header('HTTP/1.1 303 See Other');
	header('Location: http://' . $server_dir . $next_page . $query);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="report.css" rel="stylesheet" />
		<script src="functions.js" type="text/javascript"></script>
        <!-- UPDATED 12/20/12 5:26 pm -->
        <meta charset=utf-8>
        <title>Job <?php echo $jobNum . " on " . $dateF; ?> | Reportr Web</title>
		<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
		<script>
		$(document).ready(function() {
		$("#datepicker").datepicker();
		});
		</script>
    </head>
    <body>
    	<?php require 'includes/ReportrHTML_wrappersTop.inc.php'; ?>
            <div class="report">
           	  <div id="heading">
                    <h3 id="jobNumber"><strong>Job Number</strong> <?php echo $jobNum; ?></h3>
                    <h3 id="date"><!-- Date: --><?php echo $dateF; ?></h3>
              </div>
              <div id="createReportFormLink">
              	<a href="#" onClick="openBox('screen');openBox('createReportForm');dimButtonBar();">create another report</a> 
              </div>
              <div id="screen">
              
              </div>
                <table border="0" cellpadding="0" cellspacing="0" id="jobInfo">
                	<tr>
                    	<th>Customer Code</th>
                        <td class="custcode"><?php echo $jobCust; ?></td>
                    </tr>
                    <tr>
                    	<th>Description</th>
                        <td><?php echo $jobDesc; ?></td>
                    </tr>
                    <tr>
                    	<th>Location</th>
                        <td><?php echo $jobLoc; ?></td>
                    </tr>
                    <tr>
                    	<th>Production Per Hour</th>
                        <td><?php echo $jobProd; ?></td>
                    </tr>
                    <tr>
                    	<th># of People Required</th>
                        <td><?php echo $jobPEO; ?></td>
                    </tr>
                </table>
                
                <div id='tablehead'>
                    	<div class="emp">Employee Name</div>
                        <div class="in">Time In</div>
                        <div class="out">Time Out</div>
                        <div class="hrs">Hours Worked</div>
              </div>
                <table border="0" cellpadding="0" cellspacing="0" id="clockLog">
                     <?php
						if(isset($_GET['jobLogRef'])) {
							if (count($clockLog) == count($clockLog, COUNT_RECURSIVE))
							{ //i.e. only one employeew
								$empTools = new EmployeeTools();
								$empOBJ = $empTools->get($clockLog['employeeID']);
								echo "<tr>\n";
								echo 	"<td class=\"emp\"> " . $empOBJ->fname . " " . $empOBJ->lname . "</td>\n";
								echo 	"<td class=\"in\"> " . date("h:i a", strtotime($clockLog['clockIn'])) . "</td>\n";
								echo 	"<td class=\"out\"> " . date("h:i a", strtotime($clockLog['clockOut'])) . "</td>\n";
								echo 	"<td class=\"hrs\"> " . $clockLog['totalHours'] . "</td>\n";
								echo "</tr>\n";
							}
							else {
								$i=0;
								$empTools = new EmployeeTools();
								while($i<count($clockLog)) {
									$empOBJ = $empTools->get($clockLog[$i]['employeeID']);
									echo "<tr>\n";
									echo 	"<td class=\"emp\"> " . $empOBJ->fname . " " . $empOBJ->lname . "</td>\n";
									echo 	"<td class=\"in\"> " . date("h:i a", strtotime($clockLog[$i]['clockIn'])) . "</td>\n";
									echo 	"<td class=\"out\"> " . date("h:i a", strtotime($clockLog[$i]['clockOut'])) . "</td>\n";
									echo 	"<td class=\"hrs\"> " . $clockLog[$i]['totalHours'] . "</td>\n";
									echo "</tr>\n";
									$i++;
								}
							}
							if($setup>0) {
								echo "<tr>\n";
								echo 	"<td class=\"emp\"><span class=\"setup\">Setup Time</span></td>\n";
								echo 	"<td class=\"in\"></td>\n";
								echo 	"<td class=\"out\"></td>\n";
								echo 	"<td class=\"hrs\"><span class=\"setup\">(" . $setup . ")</span></td>\n";
								echo "</tr>\n";
							}	
						}
					?>  
                </table>
                
                <div id="tablefoot">
                	<div class="finProd">
                    	<strong>Finished Product: </strong> <?php echo $qty; ?>
                    </div>
                    <div class="totalHrs">
                    	<strong>Total Hours: </strong> <?php echo ($totalHours - $setup); ?> hrs
                    </div>
                </div>
                <div id="incentive">
                	
                	<a id="incentiveLink" href="#" onClick="openBox('incentiveForm');">calculate incentive</a>
                  <div id="incentiveForm">
                  	<form id="incentiveCalculator" action="incentiveCalculator.php" method="post">
                   		<input type="hidden" id="prevQuery" name="prevQuery" value="<?php echo $prev_query; ?>" />
                        <input type="hidden" id="qty" name="qty" value="<?php echo $qty; ?>" />
                        <input type="hidden" id="totalHrs" name="totalHrs" value="<?php echo $totalHours; ?>" />
                        <label for="eaCost">Each Cost</label>
					  	$<input id="eaCost" name="eaCost" type="text" size="5" /><br />
                        <label for="incentiveRate">Incentive Rate</label>
					  	(%)<input id="incentiveRate" name="incentiveRate" type="text" size="5" /><br />
                     </form>
                        <a href="#" class="submit" onClick="submitFormUsingID('incentiveCalculator');" >calculate ></a>
                    </div>
                </div>
                <div id="incentiveList" class="<?php echo $incentiveClass; ?>">
                    <div id="ILhead">
                        <div class="empIL">Employee Name</div>
                        <div class="bonusIL">Incentive</div>
                    </div>
                    <table border="0" cellpadding="0" cellspacing="0" id="incentiveLog">
                        <?php
                            if(isset($_GET['totalIncentive'])) {
                                $totalIncentive = $_GET['totalIncentive'];
                                $hourlyIncentive = $totalIncentive/$totalHours;
                                
                                if (count($clockLog) == count($clockLog, COUNT_RECURSIVE))
                                { //i.e. only one employee
                                    $empTools = new EmployeeTools();
                                    $empOBJ = $empTools->get($clockLog['employeeID']);
                                    $hours = $clockLog['totalHours'];
                                    $empIncentive = $hours * $hourlyIncentive;
                                    echo "<tr>\n";
                                    echo 	"<td class=\"empIL\"> " . $empOBJ->fname . " " . $empOBJ->lname . "</td>\n";
                                    echo 	"<td class=\"bonusIL\"> $" . round($empIncentive,2) . "</td>\n";
                                    echo "</tr>\n";
                                    $incentiveClass = "";
                                }
                                else {
                                    $i=0;
                                    $empTools = new EmployeeTools();
                                    while($i<count($clockLog)) {
                                        $empOBJ = $empTools->get($clockLog[$i]['employeeID']);
                                        $hours = $clockLog[$i]['totalHours'];
                                        $empIncentive = $hours * $hourlyIncentive;
                                        echo "<tr>\n";
                                        echo 	"<td class=\"empIL\"> " . $empOBJ->fname . " " . $empOBJ->lname . "</td>\n";
                                        echo 	"<td class=\"bonusIL\"> $" . round($empIncentive,2) . "</td>\n";
                                        echo "</tr>\n";
                                        
                                        $i++;
                                    }
                                }
                            }
                        ?>
                        </table>                            
                </div>
                <div id="commentsBox" class="<?php echo $commentsDisplay; ?>">
                	<h3>Comments</h3>
                	<p><?php echo $comments; ?></p>
                </div>
                <div id="genDateBox">
                	<p>Report generated on <span id="genDate"><?php echo $now; ?></span></p>
                </div>
                
                <div id="prodBox" class="<?php echo $prodClass; ?>">
                	<span class="label">Productivity Score</span>
                    <span class="score" id="score"><?php echo $prodScore; ?></span>
                </div>
            <!-- 
            	
                END OF REPORT
                
            -->
                <div id="buttons" class="buttonsDiv">
                    <a class="back" href="index.php">&lt; back</a>
                    <a class="forward" href="#" onClick="window.print();">print</a>
                </div>
                <?php require 'includes/ReportrHTML_msgBox.inc.php'; ?>
                <?php require 'includes/ReportrHTML_createReportForm.inc.php'; ?>
            </div>
        </div>
      </div>
        </div>
    	<?php require 'includes/ReportrHTML_footer.inc.php'; ?>
   	</div>
    <script type="text/javascript">
		window.onload = updateYear();
	</script>

    </body>
</html>
