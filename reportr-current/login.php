<?php 
//require_once 'includes/global.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Reportr Web | Log-In</title>
        <link href="main.css" rel="stylesheet" type="text/css" />
        <link href="styles/actionBar.css" rel="stylesheet" type="text/css" />
        <link href="styles/clock_confirm.css" rel="stylesheet" type="text/css" />
        <link href="styles/clock_in_page.css" rel="stylesheet" type="text/css" />
        <link href="styles/editEmployeePage.css" rel="stylesheet" type="text/css" />
        <link href="styles/editJobPage.css" rel="stylesheet" type="text/css" />
        <link href="styles/endJob.css" rel="stylesheet" type="text/css" />
        <link href="styles/home.css" rel="stylesheet" type="text/css" />
        <link href="styles/loginPage.css" rel="stylesheet" type="text/css" />
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
                    <div class="editableContent signInPage" id="editableContent">
                        <?php require 'includes/ReportrHTML_msgBox.inc.php'; ?>
                        <p id="subtitle"><strong>Time tracking and productivity reporting, tailor made for your business.</strong></p>
                      <p>Reportr was made to be simple, elegant, and effective. With all the features you need, and even a few you didn't know you wanted, Reportr makes tracking your production shifts easier than ever!</p>
                      <div class="li-box">
                        <div class="li-img"><img src="images/clockIcon.png" width="75" height="75"></div>
                        <div class="li-txt">Reportr centers around a<strong> real-time clock in solution</strong>, allowing<strong> reliable and accurate numbers</strong> without any additional work. The clock is safe from tampering because it works off of our server instead of your machine. Using our <strong>timecards</strong>, you can begin using Reportr in no time!</div>
                      </div>
                        <br />
                      <div class="li-box">
                        <div  class="li-img"><img src="images/quarterly-report.jpg" width="75" height="75"></div>
                        <div class="li-txt">As the name implies, Reportr's main feature is <strong>built-in productivity reports</strong>. In just 3 clicks, you can pull a report for any production run. The whole system is<strong> customized </strong>at the time of purchase to <strong>best suit your business</strong>.</div>
                      </div>
                      <div class="li-box">
                        <div  class="li-img"><img src="images/updates.png" width="75" height="75"></div>
                        <div class="li-txt">As part of an<strong> optional monthly subscription,</strong> Reportr will be guaranteed <strong>monthly bug-fixes and feature updates.</strong> The best part: no annoying update notifications, no downtime, and no problems! We'll triple check and make sure everything still works before we publish an update. </div>
                      </div>
                      <p id="learnMore"><a href="http://zcomputers.org/software/reportr.html" target="_blank">Learn more about Reportr<sup>web</sup></a></p>
                  </div>
                </div>
                <div id="login-box">
                    <div id="login-box-title">log <strong>in</strong></div>
                    <form id="login" action="loginScript.php" method="get">
                    <div id="companyIDBox" class="inputWrapper">
                        <label for="companyID">Company ID</label>
                        <div id="companyIDInputBox" class="textbox-small">
                            <input id="companyID" name="companyID" class="input-text-small" type="text" onFocus="focusTextField('companyIDInputBox', 'small', 1)" onBlur="focusTextField('companyIDInputBox', 'small', 0)" />
                        </div>
                        <br />
                        <span class="helpText">&nbsp;&nbsp;(supplied in welcome email)</span>
                    </div>
                    <div id="passwordBox" class="inputWrapper">
                        <label for="password">Password</label> 
                        <div id="passwordInputBox" class="textbox-small">
                            <input id="password" name="password" class="input-text-small" type="password" onFocus="focusTextField('passwordInputBox', 'small', 1)" onBlur="focusTextField('passwordInputBox', 'small', 0)" />
                        </div>
                    </div>
                    <!-- #BeginLibraryItem "/Library/submitButton.lbi" -->
                    <input type="submit" style="position: absolute; left: -9999px; width: 1px; height: 1px;"/>
                    <!-- #EndLibraryItem -->
                    </form>
                    <a href="#" onClick="submitForm();" id="submit">submit</a>
                </div>
        	</div>
        </div>
    	<div id="footer">
            <p>Copyright &copy; <span id="footerYear">2013</span> <a href="http://zcomputers.org/?referral=reportrweb" target="_blank">Z Computers</a>. All rights reserved. Any unauthorized use of code, images, etc will be penalized pursuant to the DMCA. 
        </div>
   	</div>
	<script type="text/javascript">
		
		window.onload = selectTextField();
	
	</script>
    </body>
</html>
