<?php 
require_once 'includes/global.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>What's New | Reportr Web</title>
        <link href="main.css" rel="stylesheet" type="text/css" />
        <link href="styles/actionBar.css" rel="stylesheet" type="text/css" />
        <link href="styles/clock_confirm.css" rel="stylesheet" type="text/css" />
        <link href="styles/clock_in_page.css" rel="stylesheet" type="text/css" />
        <link href="styles/editEmployeePage.css" rel="stylesheet" type="text/css" />
        <link href="styles/editJobPage.css" rel="stylesheet" type="text/css" />
        <link href="styles/endJob.css" rel="stylesheet" type="text/css" />
        <link href="styles/home.css" rel="stylesheet" type="text/css" />
        <link href="styles/loginPage.css" rel="stylesheet" type="text/css" />
        <link href="styles/changelogPage.css" rel="stylesheet" type="text/css" />
        <link href="styles/popup_createReportForm.css" rel="stylesheet" type="text/css" />
        <link href="styles/popup_editEmployeeForm.css" rel="stylesheet" type="text/css" />
        <link href="styles/popup_editJobForm.css" rel="stylesheet" type="text/css" />
        <link href="styles/popup_msgBox.css" rel="stylesheet" type="text/css" />
        <link href="styles/popup_newEmployeeForm.css" rel="stylesheet" type="text/css" />
        <link href="styles/popup_newJobForm.css" rel="stylesheet" type="text/css" />
        <link href="styles/sidebar.css" rel="stylesheet" type="text/css" />
        <!-- UPDATED 01/13/2013 06:55 pm -->
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
        <link rel="icon" href="images/favicon.ico" type="image/x-icon">
        <meta charset=utf-8>		
		<script src="functions.js" type="text/javascript"></script>
    </head>
    <body>
    	<div id="wrapper">
            <div id="preActionBarWrapper">
            <div id="header"></div>
            <div id="body">
                <div id="logo"></div>
                <div id="content">	
                    <div class="editableContent changelog" id="editableContent">
                        <?php require 'includes/ReportrHTML_msgBox.inc.php'; ?>
                        <h1>What's New</h1>
                        <div class="divTable">
                        	<!--
                            ||||||||||     TEMPLATE FOR NEW ENTRIES     |||||||||||||
                            
							<div class="divRow">
                            	<span class="version">v0.9.5 beta</span> - Released on <span class="date">February 04, 2013</span>
                                <ul>
                                    <li class="n"><span class="type">New:&nbsp;</span></li>
                                    <li class="b"><span class="type">Fixed:&nbsp;</span></li>
                                    <li class="r"><span class="type">Refined:&nbsp;</span></li>
                                    <li class="dev"><span class="type">dev:&nbsp;</span><em class="buildNum">005&nbsp;&mdash;&nbsp;</em></li>
                                </ul>
                            </div>
                            
                            |||||||||		END TEMPLATE   	||||||||||||||
                            -->
                            <div class="divRow">
                                <span class="version">v1.2</span> - Released on <span class="date">August 14, 2013</span>
                                <ul>
                                    <li class="n"><span class="type">New:&nbsp;</span>By default, 30 minutes of lunch
                                        time is deducted for any employee who works more than 6 hours on a given day.
                                        This will become a configurable option soon, hang tight!</li>
                                </ul>
                            </div>
                            <div class="divRow">
                            	<span class="version">v1.1</span> - Released on <span class="date">April 08, 2013</span>
                                <ul>
                                	<!-- 
                                    <li class="dev"><span class="type">dev:&nbsp;</span><em class="buildNum">001&nbsp;&mdash;&nbsp;</em>Made changes to Changelog page to display build revisions.</li>
                                    <li class="dev break"><span class="type">dev:&nbsp;</span><em class="buildNum">001&nbsp;&mdash;&nbsp;</em>Fixed HTML errors on <code>changelog.php</code> [removed unnecessary <code>&lt;p&gt;</code> tags.]</li>
                                    <li class="dev"><span class="type">dev:&nbsp;</span><em class="buildNum">002&nbsp;&mdash;&nbsp;</em>Added <code>require</code> code to include <code>settings.inc.php; strings.inc.php</code> in <code>global.inc.php</code>.</li>
                                    <li class="dev"><span class="type">dev:&nbsp;</span><em class="buildNum">002&nbsp;&mdash;&nbsp;</em>Fixed the php <code>require</code> statements to include <code>settings.inc.php; strings.inc.php</code> in <code>global.inc.php</code>.</li>
                                    <li class="dev break"><span class="type">dev:&nbsp;</span><em class="buildNum">002&nbsp;&mdash;&nbsp;</em>Merged recent changes from stable channel, including <code>new regex patterns, newJob.php, ...newJobForm.inc.php, and changelog.php</code>.</li>
                                    <li class="dev break"><span class="type">dev:&nbsp;</span><em class="buildNum">003&nbsp;&mdash;&nbsp;</em>Merged recent changes from stable channel 1.0.2.</li>
                                    <li class="dev"><span class="type">dev:&nbsp;</span><em class="buildNum">004&nbsp;&mdash;&nbsp;</em>Changed <em>Action Bar</em> behavior to better suit touchscreens and small screens.</li>
                                    <li class="dev"><span class="type">dev:&nbsp;</span><em class="buildNum">004&nbsp;&mdash;&nbsp;</em>Added Settings link to Sidebar.</li>
                                    <li class="dev"><span class="type">dev:&nbsp;</span><em class="buildNum">004&nbsp;&mdash;&nbsp;</em>Merged <code>settings.inc.php | settings.php | settingsPage.css</code></li>
                                    <li class="dev break"><span class="type">dev:&nbsp;</span><em class="buildNum">004&nbsp;&mdash;&nbsp;</em>Added working code to <em>Settings</em> form.</li>
                                    <li class="dev"><span class="type">dev:&nbsp;</span><em class="buildNum">005&nbsp;&mdash;&nbsp;</em>Substituted variable strings for input method on all applicable pages.</li>
                                    <li class="dev break"><span class="type">dev:&nbsp;</span><em class="buildNum">005&nbsp;&mdash;&nbsp;</em>Updated the REGEX patterns to reflect changes in settings</li>
									<li class="dev"><span class="type">dev:&nbsp;</span><em class="buildNum">006&nbsp;&mdash;&nbsp;</em>Split Clock IN functions to 2 pages | UI and Script | to prevent warnings and errors in CGI Logs.</li>
                                    <li class="dev break"><span class="type">dev:&nbsp;</span><em class="buildNum">006&nbsp;&mdash;&nbsp;</em>Added variable declarations to prevent undecared or undefined var errors.</li>
                                    <li class="dev break"><span class="type">dev:&nbsp;</span><em class="buildNum">006&nbsp;&mdash;&nbsp;</em>Changed stylesheet sidebar.css to show long usernames in the User Box.</li>
                                    
                                    -->
                                    <li class="n"><span class="type">New:&nbsp;</span>Customization of Reportr<sup>web</sup> begins with a simple option: input method. Select from Timecard + Cardreader (preferred) and Keyboard Input methods. <br /><strong>Warning: </strong> By changing this option, you will not be able to clock existing employees in or out until Z Computers Support has generated temporary ID values for each employee. Call our support team if you have any questions.</li>
                                    <li class="b"><span class="type">Fixed:&nbsp;</span>Multiple critical bug fixes and stability improvements.</li>
                                    <li class="r"><span class="type">Refined:&nbsp;</span>Action Bar buttons now keep your position on page, making them easier to work with on small screens and tablets!</li>
                                    <li class="r"><span class="type">Refined:&nbsp;</span>The status bar above the clock (<em>Logged in as ....</em>) was expanded to include a settings link.</li>
                                </ul>
                            </div>
                            <div class="divRow">
                            	<p><span class="version">v1.0.2</span> - Released on <span class="date">March 28, 2013</span>
                                <ul>
                                    <li class="b"><span class="type">Fixed:&nbsp;</span>Edit Job form styling fixed.</li>
                                    <li class="b"><span class="type">Fixed:&nbsp;</span>Employee Times Batch Report now gives error message when no employees worked during the selected week.</li>
                                    <li class="b"><span class="type">Fixed:&nbsp;</span>Employee Times Batch Report now gives error message when no date was selected.</li>
                                    <li class="b"><span class="type">Fixed:&nbsp;</span>Edit Job form now correctly validates Description field. Previous validation was too picky.</li>
                                </ul>
                            </div>
                            <div class="divRow">
                            	<span class="version">v1.0.1</span> - Released on <span class="date">March 25, 2013</span>
                                <ul>
                                    <li class="b"><span class="type">Fixed:&nbsp;</span>Critical bug fixes, including fixes in <code>new job</code>.</li>
                                </ul>
                            </div>
                            <div class="divRow">
                            	<span class="version">v1.0</span> - Released on <span class="date">March 05, 2013</span>
                                <ul>
                                    <li class="n"><span class="type">New:&nbsp;</span>Reportr<sup>web</sup> graduates out of beta!</li>
                                    <li class="r"><span class="type">Refined:&nbsp;</span>Codebase cleaned up and minor bugs cleaned.</li>
                                    <li class="r"><span class="type">Refined:&nbsp;</span>Search boxes now styled to a non-bold font for less emphasis.</li>                                    
                                </ul>
                            </div>
                            <div class="divRow">
                            	 <span class="version">v0.9.9.5 beta</span> - Released on <span class="date">March 1, 2013</span>
                                <ul>
                                    <li class="b"><span class="type">Fixed:&nbsp;</span>Custom scrollbars are now fixed.</li>
                                </ul>
                            </div>
                            <div class="divRow">
                            	 <span class="version">v0.9.9.4 beta</span> - Released on <span class="date">February 26, 2013</span>
                                <ul>
                                    <li class="b"><span class="type">Fixed:&nbsp;</span><em>Express Clock In & Out's add to queue field</em> now hides the tip when selected.</li>
                                    <li class="r"><span class="type">Refined:&nbsp;</span><em>Express Clock In & Out</em> now automatically removes duplicates.</li>
                                    <li class="r"><span class="type">Refined:&nbsp;</span>Custom minimalist scrollbars in Webkit-based browsers (i.e. Chrome, Safari, ...)</li>
                                    <li class="r"><span class="type">Refined:&nbsp;</span>Sidebar now shows employees in order of <em>clock in time</em>, with most recent first.</li>
                                </ul>
                            </div>
                            <div class="divRow">
                            	 <span class="version">v0.9.9.3 beta</span> - Released on <span class="date">February 20, 2013</span> 
                                <ul>
                                    <li class="b"><span class="type">Fixed:&nbsp;</span>Added some compatability fixes for Internet Explorer. <strong>Note:&nbsp;</strong>Reportr<sup>web</sup> recommends using Mozilla Firefox or Google Chrome for best compatability.</li>
                                    <li class="b"><span class="type">Fixed:&nbsp;</span>When trying to create an employee timesheet report, a bug, caused when no date was selected, that crashed Reportr is now fixed.</li>
                                    <li class="b"><span class="type">Fixed:&nbsp;</span>Some typos were fixed.</li>
                                    <li class="r"><span class="type">Refined:&nbsp;</span>Employee names and customer codes (in most places) are now automatically capitalized.</li>
                                </ul>
                            </div>
                            <div class="divRow">
                            	 <span class="version">v0.9.9.2 beta</span> - Released on <span class="date">February 19, 2013</span>
                                <ul>
	                                <li class="b"><span class="type">Fixed:&nbsp;</span>When creating another report from any report page, the popup form is now styled correctly.</li>
                                </ul>
                            </div>
                            <div class="divRow">
                            	 <span class="version">v0.9.9.1 beta</span> - Released on <span class="date">February 18, 2013</span>
                                <ul>
	                                <li class="r"><span class="type">Refined:&nbsp;</span>Added extra padding to the changelog page for a better look.</li>
                                    <li class="b"><span class="type">Fixed:&nbsp;</span>All search boxes now correctly hide the search hint when the field is active.</li>
                                </ul>
                            </div>
                            <div class="divRow">
                            	 <span class="version">v0.9.9 beta</span> - Released on <span class="date">February 18, 2013</span>
                                <ul>
                                    <li class="n"><span class="type">New:&nbsp;</span>Search through jobs when creating a report, in addtion to the pre-existing search functions when <em>clocking in</em> and <em>using Express Clock In & Out (new in v0.9.8)</em>.</li>
                                    <li class="b"><span class="type">Fixed:&nbsp;</span>Added error-handling to Express Clock In & Out.</li>
                                    <li class="b"><span class="type">Fixed:&nbsp;</span>Website now displays correctly in Internet Explorer as well.</li>
                                    <li class="r"><span class="type">Refined:&nbsp;</span>Some text styles changed to improve consistency.</li>
                                </ul>
                            </div>
                            <div class="divRow">
                            	 <span class="version">v0.9.8 beta</span> - Released on <span class="date">February 17, 2013</span>
                                <ul>
                                    <li class="n"><span class="type">New:&nbsp;</span>Express Clock In & Out! Select a job and clock many employees at one time! Click the Express Button on the main screen to get started.</li>
                                    <li class="b"><span class="type">Fixed:&nbsp;</span>Popup boxes now have a higher z-index to prevent any other elements from appearing on top of them.</li>
                                    <li class="b"><span class="type">Fixed:&nbsp;</span>Account Status <em>(Logged in as __________)</em> now shows on one line, even for longer Company IDs.</li>
                                    <li class="r"><span class="type">Refined:&nbsp;</span>Some text styles changed to improve consistency.</li>
                                </ul>
                            </div>
                            <div class="divRow">
                            	 <span class="version">v0.9.7.1 beta</span> - Released on <span class="date">February 13, 2013</span>
                                <ul>
                                    <li class="b"><span class="type">Fixed:&nbsp;</span>Dollar calculations now round off to two decimal places.</li>
                                </ul>
                            </div>
                            <div class="divRow">
                            	 <span class="version">v0.9.7 beta</span> - Released on <span class="date">February 07, 2013</span>
                                <ul>
                                    <li class="n"><span class="type">New:&nbsp;</span>Filter jobs using the search box when <em>clocking in</em>.</li>
                                    <li class="n"><span class="type">New:&nbsp;</span>Added an option to deduct setup time from a shift. The deducted time will be used to calculate the <em>productivity score</em>.</li>
                                    <li class="r"><span class="type">Refined:&nbsp;</span>When creating an employee report, inactive employees are now pushed to the end and are easily identifiable.</li>
                                </ul>
                            </div>
                            <div class="divRow">
                            	 <span class="version">v0.9.6 beta</span> - Released on <span class="date">February 06, 2013</span>
                                <ul>
                                    <li class="n"><span class="type">New:</span> Changelog created.</li>
                                    <li class="b"><span class="type">Fixed:</span> Reportrs with no comments now have the comments section hidden.</li>
                                    <li class="b"><span class="type">Fixed:</span> Comments now print correctly on <em>Job Shift Reports</em>.</li>
                                </ul>
                            </div>
                            <div class="divRow">
                            	 <span class="version">v0.9.5 beta</span> - Released on <span class="date">February 04, 2013</span>
                                <ul>
                                    <li class="n"><span class="type">New:</span> Add comments to a job shift when ending a job. Comments will show up on <em>Job Shift Reports</em>.</li>
                                    <li class="b"><span class="type">Fixed:</span> Main text field is now automatically selected after clocking in or out.</li>
                                    <li class="r"><span class="type">Refined:</span> To create another report while viewing a report, use the link on the top-left labeled <em>create another report</em>.</li>
                                </ul>
                            </div>
                            <div id="buttons" class="buttonsDiv">
                                <a class="back" href="index.php">&lt; back</a>
                            </div>
                        </div>
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
