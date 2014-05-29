<?php
	$file="";
	$query="";
	$result = basename($_SERVER['REQUEST_URI']);
	$length = strlen($result);
	$index=stripos($result, "?");
	if($index==false) {
		 $file = $result;	
	}
	else{
		$exploded = explode("&",substr($result, $index));
		$query = $exploded[0];
		$file = substr($result, 0, $index);
	}
	if($file=="phplearning") {
		$file="index.php";
	}
	$jobTools = new JobTools();
?>
<script type="text/javascript">
	$(document).ready(function () {
		$('#searchBox_jobSum').bind('keydown keypress keyup change', function() {
			var search = this.value;
			var $li = $("#jobSum label").hide();
			$li.filter(function() {
				return $(this).text().toLowerCase().indexOf(search.toLowerCase()) >= 0;
			}).show();
		});
		$('#searchBox_jobShift').bind('keydown keypress keyup change', function() {
			var search = this.value;
			var $li = $("#jobShift label").hide();
			$li.filter(function() {
				return $(this).text().toLowerCase().indexOf(search.toLowerCase()) >= 0;
			}).show();
		});
        $('#searchBox_Employee').bind('keydown keypress keyup change', function() {
            var search = this.value;
            var $li = $("#employeesBox label").hide();
            $li.filter(function() {
                return $(this).text().toLowerCase().indexOf(search.toLowerCase()) >= 0;
            }).show();
        });
	});
</script>
<div id="createReportForm">
<a id="close" href="#" onClick="closeBox('createReportForm');closeBox('screen');undimButtonBar();<?php if($file=='index.php') { echo 'undimActionBar();undimContent();';} ?>">x</a>
<div id="createReportFormHeader">create <strong>report</strong></div>
<div id="CRFcontent">
	<div id="buttonBar">
    	<a id="jobButton" href="#" class="selected" onclick="reportFormButton(this.id);">Job Shifts</a><a id="employeeButton" href="#" onclick="reportFormButton(this.id);">Employee Times</a><a id="jobSumButton" href="#" onclick="reportFormButton(this.id);">Job Summary</a>
    </div>
	<div id="jobReports">
        <form name="jobReportOTF" method="get" action="jobReport.php" id="jobReportOTF">
            <input type="hidden" name="return-page" value="<?php echo $file; ?>" />
            <input type="hidden" name="return-query" value="<?php echo $query; ?>" />
            <input type="hidden" name="form-type" value="jobReport" />
            <p>Select a record below to create a job report.</p>
            <div id="jobFormBox">
                <div class="searchDiv">
                    <img class="searchIcon" src="images/actionBar/2_action_search.png" /> 
                    <div class="searchInputDiv inputWrapper">
                        <div id="searchInputBox" class="searchInputBox textbox-small">
                            <input id="searchBox_jobShift" class="input-text-small searchField" type="text" onFocus="focusTextField('searchInputBox', 'small', 1);focusSearchField('searchInputBox', 'searchBox_jobShift', 'searchHelp_jobShift', 1);" onBlur="focusTextField('searchInputBox', 'small', 0);focusSearchField('searchInputBox', 'searchBox_jobShift', 'searchHelp_jobShift', 0);" />
                            <div class="searchHelp" id="searchHelp_jobShift">search jobs...</div> 
                        </div>
                    </div>
                </div>
                <div class="selectAJob">
                    <div id="jobShift">
                        <?php $jobTools->listEndedJobs_RADIO(); ?>
                    </div>
                </div>
            </div>
            <!--
            <div id="jobFormBox">
                <div class="selectAJob">
                    <?php //$jobTools->listEndedJobs_RADIO(); ?>
                </div>
            </div>
            -->
            <a href="#" onClick="submitFormUsingID('jobReportOTF');" id="submit">submit</a>
        </form>
     </div>
     <div id="jobSummaryReports">
        <form name="jobSummaryOTF" method="get" action="jobSummaryReport.php" id="jobSummaryOTF">
            <input type="hidden" name="return-page" value="<?php echo $file; ?>" />
            <input type="hidden" name="return-query" value="<?php echo $query; ?>" />
            <input type="hidden" name="form-type" value="jobSummaryReport" />
            <p>Select a record below to create a job summary report.</p>
            <div id="jobFormBox">
                <div class="searchDiv">
                    <img class="searchIcon" src="images/actionBar/2_action_search.png" /> 
                    <div class="searchInputDiv inputWrapper">
                        <div id="searchInputBox" class="searchInputBox textbox-small">
                            <input id="searchBox_jobSum" class="input-text-small searchField" type="text" onFocus="focusTextField('searchInputBox', 'small', 1);focusSearchField('searchInputBox', 'searchBox_jobSum', 'searchHelp_jobSum', 1);" onBlur="focusTextField('searchInputBox', 'small', 0);focusSearchField('searchInputBox', 'searchBox_jobSum', 'searchHelp_jobSum', 0);" />
                            <div class="searchHelp" id="searchHelp_jobSum">search jobs...</div>
                        </div>
                    </div>
                </div>
                <div class="selectAJob">
                    <div id="jobSum">
                        <?php $jobTools->listAllJobs_report_RADIO("jobSummaryOTF"); ?>
                    </div>
                </div>
            </div>
            <a href="#" onClick="submitFormUsingID('jobSummaryOTF');" id="submit">submit</a>
        </form>
     </div>
     <div id="employeeReports">
        <form name="employeeReportOTF" method="get" action="employeeReport.php" id="employeeReportOTF">
            <input type="hidden" name="return-page" value="<?php echo $file; ?>" />
            <input type="hidden" name="return-query" value="<?php echo $query; ?>" />
            <input type="hidden" name="form-type" value="employeeReport" />
            <p>Select a date below to create timesheet report for all working employees. </p>
            <div id="dateBox" class="inputWrapper">
                <label for="date">Week of </label>
                <div id="dateInputBox" class="textbox-small">
                    <input id="datepicker" name="date" class="input-text-small" type="text" onFocus="focusTextField('dateInputBox', 'small', 1)" onBlur="focusTextField('dateInputBox', 'small', 0)" />
                </div>

                <br /><span class="helpText">(click for a date-picker)</span>
            </div>
            <div id="employeeBox" class="inputWrapper">
                <label>Employee</label>
                <div class="searchDiv">
                    <img class="searchIcon" src="images/actionBar/2_action_search.png" />
                    <div class="searchInputDiv inputWrapper">
                        <div id="searchInputBox" class="searchInputBox textbox-small">
                            <input id="searchBox_Employee" class="input-text-small searchField" type="text" onFocus="focusTextField('searchInputBox', 'small', 1);focusSearchField('searchInputBox', 'searchBox_Employee', 'searchHelp_Employee', 1);" onBlur="focusTextField('searchInputBox', 'small', 0);focusSearchField('searchInputBox', 'searchBox_Employee', 'searchHelp_Employee', 0);" />
                            <div class="searchHelp" id="searchHelp_Employee">search employees...</div>
                        </div>
                    </div>
                </div>
                <div id="employeesBox">
                    <div class="selectEmployee">
                        <?php $db->listEmployees_RADIO(); ?>
                    </div>
                </div>
             </div>
            <a href="#" onClick="submitFormUsingID('employeeReportOTF');" id="submit">submit</a>
        </form>
     </div>
</div>
</div>