<title>Reportr Web | 10:08:00 am</title>
<link href="main.css" rel="stylesheet" type="text/css" />
<link href="styles/actionBar.css" rel="stylesheet" type="text/css" />
<link href="styles/clock_confirm.css" rel="stylesheet" type="text/css" />
<link href="styles/clock_in_page.css" rel="stylesheet" type="text/css" />
<link href="styles/express_clock.css" rel="stylesheet" type="text/css" />
<link href="styles/express_clock_p2.css" rel="stylesheet" type="text/css" />
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
<link href="styles/settingsPage.css" rel="stylesheet" type="text/css" />
<link href="styles/sidebar.css" rel="stylesheet" type="text/css" />
<script src="functions.js" type="text/javascript"></script>
<!-- UPDATED 01/09/2013 06:55 pm -->
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<meta charset=utf-8>

<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

<script>
$(document).mouseup(function (e)
{
    var container = $("#newOverflow")
	var container2 = $("#editOverflow");

    if (container.has(e.target).length === 0)
    {
        container.hide();
    }
	if (container2.has(e.target).length === 0)
    {
        container2.hide();
    }
});
$(document).ready(function() {
$("#datepicker").datepicker();
});
</script>

