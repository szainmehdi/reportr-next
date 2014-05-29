<?php 
require_once 'includes/global.inc.php';

//initialize php variables used in the form


$empID = "";
$empName = "";
$cardID = "";
$weekNum = "";
$friday = "";
$countJobs = 0;
$success=false;
$totalHours = 0;

$empTools = new EmployeeTools();
$jTools = new JobTools();
$next_page = (isset($_GET['return-page']) ? $_GET['return-page'] : "index.php");
$return_query = "?";
if($next_page != "index.php") {
	$return_query = (isset($_GET['return-query']) ? $_GET['return-query'] . "&" : "?");	
}
$now = date("M d, Y h:i:s a T"); 


//check to see that the form has been submitted
if(isset($_GET['date']) && isset($_GET['empID'])) { 
	
	//--------------- BEGIN WORK ------------------
	
	//get the jobLogRef from the form
	$empID = $_GET['empID'];
	$weekNum = date("W", strtotime($_GET['date']));
    $year = date("Y", strtotime($_GET['date']));

    $week = strtotime($year . "W" . $weekNum);
	$monday = date("m/d/y", $week);
	$friday = date("m/d/y", strtotime("next friday", $week));

	
	
	if($empID!="" && $_GET['date']) {
		if($empID=='all') {
			$allClockLog = $db->select("clockLog", "weekNum='$weekNum'  and YEAR(`date`)='$year'");
			$activeEmployees = array();
			
			if(count($allClockLog)==0) {
					$query = "?createReport=failed&error=-4";
					$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
					header('HTTP/1.1 303 See Other');
					header('Location: http://' . $server_dir . $next_page . $query);

			}
		}
		if($empID!='all') {
			//get employee object
			$employee = $empTools->get($empID);
			
			//assign employee variables
			$empName = $employee->lname . ", " . $employee->fname;
			$cardID = $employee->card;
            $days = array();
            $daily_hours = array();
			$lunch = 0.5;

			//pull the data array from the clockLog table
			$result = $db->select("clockLog", "employeeID='$empID' and weekNum='$weekNum' and YEAR(`date`)='$year'");
			if(count($result)==0) {
				$query = $return_query .  "createReport=failed&error=-3";
				$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
				header('HTTP/1.1 303 See Other');
				header('Location: http://' . $server_dir . $next_page . $query);
			}
			//countJobs 
			else if (count($result) == count($result, COUNT_RECURSIVE))
			{ //i.e. only one employee
                $date = date("Ymd", strtotime($result['date']));
				$countJobs++;
				$totalHours+=$result['totalHours'];
                array_push($days, $date);
                if(isset($daily_hours[$date])) {
                    $daily_hours[$date] += (float)$result['totalHours'];
                }
                else {
                    $daily_hours[$date] = (float)$result['totalHours'];
                }
			}
			else {
				$i=0;
				while($i<count($result)) {
                    $date = date("Ymd", strtotime($result[$i]['date']));
					$countJobs++;
					$totalHours+=$result[$i]['totalHours'];
                    array_push($days, $date);
                    if(isset($daily_hours[$date])) {
                        $daily_hours[$date] += (float)$result[$i]['totalHours'];
                    }
                    else {
                        $daily_hours[$date] = (float)$result[$i]['totalHours'];
                    }
					$i++;
				}

			}
            //var_dump($daily_hours);
            //deduct lunch from total hours
            $days = array_unique($days);
            $num_days = 0;
            foreach($days as $x) {
                if($daily_hours[$x]>6.0) {
                    $num_days++;
                }
            }
            //$num_days = count($days);
            $total_lunch = $num_days * $lunch;

            $totalHours -= $total_lunch;


            //round hours to nearest tenth
			$totalHoursRound = round($totalHours, 1);


			
			$success=true;
		}
	}
	else { 
		$query = $return_query . "createReport=failed&error=-1";
		$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
		header('HTTP/1.1 303 See Other');
		header('Location: http://' . $server_dir . $next_page . $query);	
		
	}
}
else {
	$query = $return_query . "createReport=failed&error=-2";
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
        <title>Reportr Employee Reports | Week <?php echo $weekNum; ?></title>
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
            <div class="report employeeReport">
            <div id="createReportFormLink">
              	<a href="#" onClick="openBox('screen');openBox('createReportForm');dimButtonBar();">create another report</a> 
              </div>
              <div id="screen">
              
              </div>
           	  <?php 
			  if(($success) && ($empID!="all")) {
				  echo "
				  <div class='reportEntry'>
				  <div id='heading'>
						<h3 id='employeeName'><strong>Employee Report: </strong>$empName</h3>
						<h3 id='date'>Week ending $friday</h3>
					</div>
					<table border='0' cellpadding='0' cellspacing='0' id='employeeInfo'>
						<tr>
							<th style=\"text-transform: capitalize; \">$string_inputMethod_type</th>
							<td>$cardID</td>
						</tr>
						<tr>
							<th>Working Dates</th>
							<td>$monday &mdash; $friday</td>
						</tr>
						<tr>
							<th>Week Number</th>
							<td>$weekNum</td>
						</tr>
						<tr>
							<th>Total Jobs Worked</th>
							<td>$countJobs</td>
						</tr>
						<tr>
							<th></th>
							<td></td>
						</tr>
					</table>
					
					<div id='tablehead'>
							<div class='date'>Date</div>
							<div class='job'>Job Number</div>
							<div class='in'>Time In</div>
							<div class='out'>Time Out</div>
							<div class='hrs'>Hours Worked</div>
					</div>
					<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" id=\"clockLog\">";


							if (count($result) == count($result, COUNT_RECURSIVE))
								{ //i.e. only one employee timecard entry
									$job = $jTools->get($result['jobID']);


									echo '<tr>';
									echo 	"<td class='date'>" . date("m/d/y", strtotime($result['date'])) . "</td>";
									echo 	"<td class='job'>" . $job->number . "</td>";
									echo 	"<td class='in'>" . date("h:i a", strtotime($result['clockIn'])) . "</td>";
									echo 	"<td class='out'> " . date("h:i a", strtotime($result['clockOut'])) . "</td>";
									echo 	"<td class='hrs'> " . $result['totalHours'] . " hrs </td>";
									echo "</tr>";

                                    echo '<tr class="lunch">';
                                    echo 	"<td class='date'></td>";
                                    echo 	"<td class='job'>Lunch</td>";
                                    echo 	"<td class='in'>" . $num_days . " days</td>";
                                    echo 	"<td class='out'> (" . number_format($lunch,2) . " hrs) ea.</td>";
                                    echo 	"<td class='hrs'> (" . $total_lunch . " hrs) </td>";
                                    echo "</tr>";
								}
								else {
									$i=0;
									while($i<count($result)) {
										$job = $jTools->get($result[$i]['jobID']);
										echo "<tr>\n";
										echo 	"<td class='date'>" . date("m/d/y", strtotime($result[$i]['date'])) . "</td>\n";
										echo 	"<td class='job'>" . $job->number . "</td>\n";
										echo 	"<td class='in'>" . date("h:i a", strtotime($result[$i]['clockIn'])) . "</td>\n";
										echo 	"<td class='out'> " . date("h:i a", strtotime($result[$i]['clockOut'])) . "</td>\n";
										echo 	"<td class='hrs'> " . $result[$i]['totalHours'] . " hrs </td>\n";
										echo "</tr>\n";
										$i++;
									}
                                    echo '<tr class="lunch">';
                                    echo 	"<td class='date'></td>";
                                    echo 	"<td class='job'>Lunch</td>";
                                    echo 	"<td class='in'>" . $num_days . " days</td>";
                                    echo 	"<td class='out'> (" . number_format($lunch,2) . " hrs) ea.</td>";
                                    echo 	"<td class='hrs'> (" . $total_lunch . " hrs) </td>";
                                    echo "</tr>";
				 
								}
					echo "</table>
					
					<div id=\"tablefoot\">
						<div class=\"totalHrs\">
							<strong>Total Hours: </strong>$totalHours hrs
						</div>
					</div>
					<div id=\"genDateBox\">
						<p>Report generated on <span id=\"genDate\">$now</span></p>
					</div>
					<div id=\"prodBox\">
						<span class=\"label\">Total Hours</span>
						<span class=\"score\" id=\"score\">$totalHoursRound</span>
					</div>
					</div>
					<hr />";
			  }
			  else if($empID=="all") {
				//preparation for loop
				$allClockLog = $db->select("clockLog", "weekNum='$weekNum' and YEAR(`date`)='$year'");
				$activeEmployees = array();
				
				if(count($allClockLog)==0) {
				}
				if (count($allClockLog) == count($allClockLog, COUNT_RECURSIVE)) { //one result
					array_push($activeEmployees, $allClockLog['employeeID']);
				}
				else {
					$i = 0;
					while($i<count($allClockLog)) {
						$eID = $allClockLog[$i]['employeeID'];
						array_push($activeEmployees, $eID);
						$i++;
					}
				}
				
				$activeEmployees = array_unique($activeEmployees);	
				$activeEmployees = array_values($activeEmployees);	
				$x=0;
				$count=count($activeEmployees);
				if(($activeEmployees[0]=="" && $count==1)){
					$query = "?createReport=failed&error=-4";
					$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
					header('HTTP/1.1 303 See Other');
					header('Location: http://' . $server_dir . $next_page . $query);
					
				}
				while($x<$count) {
					
					//get employee object
					$empID = $activeEmployees[$x];
					$employee = $empTools->get($empID);
					$empName = $employee->lname . ", " . $employee->fname;
					$cardID = $employee->card;
					$totalHours = 0; 
					$totalHoursRound = 0;
					$countJobs = 0;
                    $days = array();
                    $daily_hours = array();
                    $lunch = 0.5;
					
					//pull the data array from the clockLog table
					$result = $db->select("clockLog", "employeeID='$empID' and weekNum='$weekNum' and YEAR(`date`)='$year'");
					if(count($result)==0) {
						$query = "?createReport=failed&error=-3";
						$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
						header('HTTP/1.1 303 See Other');
						header('Location: http://' . $server_dir . $next_page . $query);
					}
					//countJobs 
					else if (count($result) == count($result, COUNT_RECURSIVE))
					{ //i.e. only one employee
						$countJobs++;
						$totalHours+=$result['totalHours'];

                        $date = date("Ymd", strtotime($result['date']));
                        array_push($days, $date);
                        if(isset($daily_hours[$date])) {
                            $daily_hours[$date] += (float)$result['totalHours'];
                        }
                        else {
                            $daily_hours[$date] = (float)$result['totalHours'];
                        }
					}
					else {
						$i=0;
						while($i<count($result)) {
							$countJobs++;
							$totalHours+=$result[$i]['totalHours'];


                            $date = date("Ymd", strtotime($result[$i]['date']));
                            array_push($days, $date);
                            if(isset($daily_hours[$date])) {
                                $daily_hours[$date] += (float)$result[$i]['totalHours'];
                            }
                            else {
                                $daily_hours[$date] = (float)$result[$i]['totalHours'];
                            }

                            $i++;
						}
			
					}
                    //var_dump($daily_hours);

                    $days = array_unique($days);
                    $num_days = 0;
                    foreach($days as $xbsd) {
                        if($daily_hours[$xbsd]>6.0) {
                            $num_days++;
                        }
                    }
                    //$num_days = count($days);
                    $total_lunch = $num_days * $lunch;

                    $totalHours -= $total_lunch;



                    $totalHoursRound = round($totalHours, 1);
					
					
					echo "
					<div class='reportEntry'>
					<div id='heading'>
						<h3 id='employeeName'><strong>Employee Report: </strong>$empName</h3>
						<h3 id='date'>Week ending $friday</h3>
					</div>
					<table border='0' cellpadding='0' cellspacing='0' id='employeeInfo'>
						<tr>
							<th>$string_inputMethod_type</th>
							<td>$cardID</td>
						</tr>
						<tr>
							<th>Working Dates</th>
							<td>$monday &mdash; $friday</td>
						</tr>
						<tr>
							<th>Week Number</th>
							<td>$weekNum</td>
						</tr>
						<tr>
							<th>Total Jobs Worked</th>
							<td>$countJobs</td>
						</tr>
						<tr>
							<th></th>
							<td></td>
						</tr>
					</table>
					
					<div id='tablehead'>
							<div class='date'>Date</div>
							<div class='job'>Job Number</div>
							<div class='in'>Time In</div>
							<div class='out'>Time Out</div>
							<div class='hrs'>Hours Worked</div>
					</div>
					<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" id=\"clockLog\">";
							if (count($result) == count($result, COUNT_RECURSIVE))
								{ //i.e. only one employee
									$job = $jTools->get($result['jobID']);
									echo '<tr>';
									echo 	"<td class='date'>" . date("m/d/y", strtotime($result['date'])) . "</td>";
									echo 	"<td class='job'>" . $job->number . "</td>";
									echo 	"<td class='in'>" . date("h:i a", strtotime($result['clockIn'])) . "</td>";
									echo 	"<td class='out'> " . date("h:i a", strtotime($result['clockOut'])) . "</td>";
									echo 	"<td class='hrs'> " . $result['totalHours'] . " hrs </td>";
									echo "</tr>";

                                    echo '<tr class="lunch">';
                                    echo 	"<td class='date'></td>";
                                    echo 	"<td class='job'>Lunch</td>";
                                    echo 	"<td class='in'>" . $num_days . " days</td>";
                                    echo 	"<td class='out'> (" . number_format($lunch,2) . " hrs) ea.</td>";
                                    echo 	"<td class='hrs'> (" . $total_lunch . " hrs) </td>";
                                    echo "</tr>";
								}
								else {
									$i=0;
									while($i<count($result)) {
										$job = $jTools->get($result[$i]['jobID']);
										echo "<tr>\n";
										echo 	"<td class='date'>" . date("m/d/y", strtotime($result[$i]['date'])) . "</td>\n";
										echo 	"<td class='job'>" . $job->number . "</td>\n";
										echo 	"<td class='in'>" . date("h:i a", strtotime($result[$i]['clockIn'])) . "</td>\n";
										echo 	"<td class='out'> " . date("h:i a", strtotime($result[$i]['clockOut'])) . "</td>\n";
										echo 	"<td class='hrs'> " . $result[$i]['totalHours'] . " hrs </td>\n";
										echo "</tr>\n";
										$i++;
									}
                                    echo '<tr class="lunch">';
                                    echo 	"<td class='date'></td>";
                                    echo 	"<td class='job'>Lunch</td>";
                                    echo 	"<td class='in'>" . $num_days . " days</td>";
                                    echo 	"<td class='out'> (" . number_format($lunch,2) . " hrs) ea.</td>";
                                    echo 	"<td class='hrs'> (" . $total_lunch . " hrs) </td>";
                                    echo "</tr>";
				 
								}
					echo "</table>
					<div id=\"tablefoot\">
						<div class=\"totalHrs\">
							<strong>Total Hours: </strong>$totalHours hrs
						</div>
					</div>
					<div id=\"genDateBox\">
						<p>Report generated on <span id=\"genDate\">$now</span></p>
					</div>
					<div id=\"prodBox\">
						<span class=\"label\">Total Hours</span>
						<span class=\"score\" id=\"score\">$totalHoursRound</span>
					</div>
					</div>
					<hr />";
					
					$x++;
				}
			  }
			  ?>
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
