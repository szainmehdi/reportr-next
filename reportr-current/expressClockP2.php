<?php 
require_once 'includes/global.inc.php';

//initialize php variables used in the form
$jobTools = new JobTools();
$jobNum = "";
$db = new DB("");
if(isset($_GET['jobID'])) {
	$jobID = $_GET['jobID'];
	$job = $jobTools->get($jobID);
	$jobNum = $job->number;
}
else {
	$query="?express=failed&error=-1"; //NO job selected.
	$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
	header('HTTP/1.1 303 See Other');
	$next_page = 'expressClock.php';
	header('Location: http://' . $server_dir . $next_page . $query);	
}
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
				$('#searchBox2').bind('keydown keypress keyup change', function() {
					var search = this.value;
					var $li = $("#data2 label").hide();
					$li.filter(function() {
						return $(this).text().toLowerCase().indexOf(search.toLowerCase()) >= 0;
					}).show();
				});
			});
			
		</script>
        <script> 
			function showUser(id) {
			var str = document.getElementById(id).value;
			clearTextField(id);
			if (str=="")
			  {
			  //document.getElementById("queue").innerHTML="";
			  return;
			  } 
			if (window.XMLHttpRequest)
			  {// code for IE7+, Firefox, Chrome, Opera, Safari
			  xmlhttp=new XMLHttpRequest();
			  }
			else
			  {// code for IE6, IE5
			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			  }
			xmlhttp.onreadystatechange=function()
			  {
			  if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
				document.getElementById("queue").innerHTML+=xmlhttp.responseText;
				var objDiv = document.getElementById("queue");
				objDiv.scrollTop = objDiv.scrollHeight;
				}
			  }
			xmlhttp.open("GET","expressClock_getEmployee.php?q="+str,true);
			xmlhttp.send();
			}
			
		</script>
    </head>
    <body> 
    	<?php require 'includes/ReportrHTML_wrappersTop.inc.php'; ?>
            <div class="editableContent expressClockPage2">
            	
                <div class="instructions">
                    <?php echo $string_inputMethod_expressClockInstructions; ?> to clock in or out from
                    <br /><span class="jobSpan">Job <?php if($jobNum!="") { echo $jobNum; } ?></span> 
                </div>
                <div id="queueBox">
                	<div id="searchDiv">
                    	<img id="searchIcon" src="images/actionBar/6_social_add_group.png" /> 
                        <div id="searchInputDiv" class="inputWrapper">
                          <div id="searchInputBox" class="textbox-small">
                                <input id="searchBox" class="input-text-small" type="text" onFocus="focusTextField('searchInputBox', 'small', 1);focusSearchField('searchInputBox', 'searchBox', 'searchHelp', 1);" onBlur="focusTextField('searchInputBox', 'small', 0);focusSearchField('searchInputBox', 'searchBox', 'searchHelp', 0);" onkeydown="if (event.keyCode == 13) { showUser('searchBox'); }" onChange="$('#error').delay(1500).fadeOut('fast');" />
                              <div id="searchHelp" on>add to queue...</div>
                            </form>
                            </div>
                        </div>
                    </div><a href="#" id="newJobButton" onClick="showUser('searchBox');">add</a>
                    <form id="expressClock" name="expressClock" action="expressClock_script.php" method="get">
                   	<input type="hidden" name="jobID" value="<?php if($jobID!="") { echo $jobID; } ?>" />
                    <div id="queue">
                        
                    </div> 
                    </form>
                </div>
                <?php require 'includes/ReportrHTML_newJobForm.inc.php'; ?>
                <?php require 'includes/ReportrHTML_msgBox.inc.php'; ?>
                <div id="buttons" class="buttonsDiv">
                    <a class="back" href="expressClock.php">&lt; back</a>
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
	selectTextFieldById('searchBox');
	</script>

    </body>
</html>
