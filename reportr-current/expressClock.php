<?php 
require_once 'includes/global.inc.php';

//initialize php variables used in the form
$jobTools = new JobTools();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require 'includes/ReportrHTML_head.inc.php'; ?>
        <script type="text/javascript">
			$(document).ready(function () {
				$('#searchBox').bind('keydown keypress keyup change', function() {
					var search = this.value;
					var $li = $("#data label").hide();
					$li.filter(function() {
						return $(this).text().toLowerCase().indexOf(search.toLowerCase()) >= 0;
					}).show();
				});
			});
		</script>
    </head>
    <body> 
    	<?php require 'includes/ReportrHTML_wrappersTop.inc.php'; ?>
            <div class="editableContent expressClockPage">
                <div class="instructions">
                    Select a job to begin using Express Clock In or Out.
                </div>
                <div id="formBox">
                    <a href="#" id="newJobButton" onClick="openBox('newJobForm');dimButtonBar();">new</a>
                    <div id="searchDiv">
                    	<img id="searchIcon" src="images/actionBar/2_action_search.png" /> 
                        <div id="searchInputDiv" class="inputWrapper">
                            <div id="searchInputBox" class="textbox-small">
                                <input id="searchBox" class="input-text-small" type="text" onFocus="focusTextField('searchInputBox', 'small', 1);focusSearchField('searchInputBox', 'searchBox', 'searchHelp', 1);" onBlur="focusTextField('searchInputBox', 'small', 0);focusSearchField('searchInputBox', 'searchBox', 'searchHelp',0)" />
                                <div id="searchHelp">search jobs...</div>
                            </div>
                        </div>
                    </div>
                    <div class="selectAJob">
                        <form name="jobNumForm" id="jobNumForm" action="expressClockP2.php" method="get">
							<div id="data">
								<?php $jobTools->listAllJobs_RADIO(); ?>
                            </div>
                      </form>
                    </div>
                </div>
                <?php require 'includes/ReportrHTML_newJobForm.inc.php'; ?>
                <?php require 'includes/ReportrHTML_msgBox.inc.php'; ?>
                <div id="buttons" class="buttonsDiv">
                    <a class="back" href="index.php">&lt; back</a>
                    <a class="forward" href="#" onClick="submitForm();">next &gt;</a>
                </div>
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
