<?php 
require_once 'includes/global.inc.php';
error_reporting(0);
ini_set('display_errors', '0');

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
$dates = array();
$qty = 0;
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

//check to see that the form has been submitted
if(isset($_GET['jobID'])) { 
	
	$next_page = (isset($_GET['return-page'])) ? $_GET['return-page'] : "index.php";
	
	//--------------- BEGIN WORK ------------------
	
	//get the jobLogRef from the form
	$jobID = $_GET['jobID'];
	if(isset($_GET['totalIncentive'])) {
		$incentiveClass="active";
	}
	if($jobID!="") {
		//pull the data array from the jobLog table
		$result = $db->select("jobLog", "jobID=$jobID");
		$setup=0;
		
		if (count($result) == count($result, COUNT_RECURSIVE)) { //single row
			$totalHours += $result['totalHours'];
			$setup=$result['setupTime'];
			$qty +=$result['qtyProduced'];
			$dates = $result['date'];	
			$singleJob=true;
		}
		else {
			$i=0;
			$singleJob=false;
			while($i<count($result)) {
				$totalHours += $result[$i]['totalHours'];
				$setup+=$result[$i]['setupTime'];
				$qty +=$result[$i]['qtyProduced'];
				array_push($dates, $result[$i]['date']);	
				$i++;
			}
		}
		
		
		if(!$singleJob) {
			$endCount = count($dates) - 1;
			$beginDate = date("m/d/y", strtotime($dates[0])); 
			$endDate = date("m/d/y", strtotime($dates[$endCount]));
			$dateF = $beginDate . " &mdash; " . $endDate;
		}
		else {
			$dateF = date("m/d/y", strtotime($dates));
		}
		
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
		
		//Perform the calculations	
		$estManHours = $jobProd/$jobPEO;
		$actualManHours = $qty/$totalHours;
		$prodScore = round((($actualManHours/$estManHours)*100));
		
		if($prodScore>=80) {
			$prodClass = "good";
		}
		else if ($prodScore<80) {
			$prodClass = "bad";	
		}
		
		//find and get all records clocked in to this job on this day
		$clockLog = $db->select("clockLog", "jobID='$jobID'");
			 
		/*
		if(count($result)!=0) {
			
			//find and get all records clocked in to this job on this day
			$clockLog = $db->select("clockLog", "jobID='$jobID' and date='$date' and jobLogRef='$jobLogRef'");
			
			
		}*/
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
        <title>Job <?php echo $jobNum . " Summary"; ?> | Reportr Web</title>
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
                    <h3 id="jobNumber"><strong>Job Number</strong> <?php echo $jobNum; ?> Summary</h3>
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
                		<div class="date">Date</div>
                    	<div class="emp">Employee Name</div>
                        <div class="in">Time In</div>
                        <div class="out">Time Out</div>
                        <div class="hrs">Hours</div>
              </div>
                <table border="0" cellpadding="0" cellspacing="0" id="clockLog">
                     <?php
						if(isset($_GET['jobID'])) {
							if (count($clockLog) == count($clockLog, COUNT_RECURSIVE))
							{ //i.e. only one employee
								$empTools = new EmployeeTools();
								$empOBJ = $empTools->get($clockLog['employeeID']);
								echo "<tr>\n";
								echo 	"<td class=\"date\"> " . date("m/d/y", strtotime($clockLog['date'])) . "</td>\n";
								echo 	"<td class=\"emp\"> " . $empOBJ->fname . " " . $empOBJ->lname . "</td>\n";
								echo 	"<td class=\"in\"> " . date("h:i a", strtotime($clockLog['clockIn'])) . "</td>\n";
								echo 	"<td class=\"out\"> " . date("h:i a", strtotime($clockLog['clockOut'])) . "</td>\n";
								echo 	"<td class=\"hrs\"> " . $clockLog['totalHours'] . "</td>\n";
								echo "</tr>\n";
							}
							else {
								$i=0;
								$empTools = new EmployeeTools();
                                $prevDate = null;
								while($i<count($clockLog)) {

									$empOBJ = $empTools->get($clockLog[$i]['employeeID']);
									echo "<tr>\n";
									echo 	"<td class=\"date\"> " . date("m/d/y", strtotime($clockLog[$i]['date'])) . "</td>\n";
									echo 	"<td class=\"emp\"> " . $empOBJ->fname . " " . $empOBJ->lname . "</td>\n";
									echo 	"<td class=\"in\"> " . date("h:i a", strtotime($clockLog[$i]['clockIn'])) . "</td>\n";
									echo 	"<td class=\"out\"> " . date("h:i a", strtotime($clockLog[$i]['clockOut'])) . "</td>\n";
									echo 	"<td class=\"hrs\"> " . $clockLog[$i]['totalHours'] . "</td>\n";
									echo "</tr>\n";

                                    $prevDate = $clockLog[$i]['date'];
									$i++;

                                    if(empty($clockLog[$i]) || ($prevDate!= null &&  $prevDate != $clockLog[$i]['date'])) {
                                        //If a new date, get the qty produced so far.
                                        $cur_qty = $db->select('jobLog', 'jobID=' . $_GET['jobID'] . ' AND date=\'' . $prevDate . '\'');
                                        if(isset($cur_qty['qtyProduced']))
                                            echo "<td class='qty-so-far' colspan='5'>Quantity Produced on " . date("m/d/y", strtotime($prevDate)) . ": " . $cur_qty['qtyProduced'] . "</td>";
                                    }
								}
							}
							if($setup>0) {
								echo "<tr>\n";
								echo 	"<td class=\"date\"></td>\n";
								echo 	"<td class=\"emp\"><span class=\"setup\">Total Setup Time</span></td>\n";
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
                        <input type="hidden" id="prevPage" name="prevPage" value="<?php echo $file; ?>" />
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
                                    echo 	"<td class=\"bonusIL\"> $" . round($empIncentive, 2) . "</td>\n";
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
                                        echo 	"<td class=\"bonusIL\"> $" . round($empIncentive, 2) . "</td>\n";
                                        echo "</tr>\n";
                                        
                                        $i++;
                                    }
                                }
                            }
                        ?>
                        </table>                            
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
