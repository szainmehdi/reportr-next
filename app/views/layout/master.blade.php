<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset=utf-8>

        <title>Reportr Web | 10:08:00 am</title>
        <link href="/css/main.css" rel="stylesheet" type="text/css" />
        <script src="/js/functions.js" type="text/javascript"></script>

        <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/images/favicon.ico" type="image/x-icon">

    </head>
<body>
<div id="wrapper">
    <div id="preActionBarWrapper">
        <div id="header"></div>
        <div id="body">
            <div id="logo"></div>
            <div id="content">
                <div class="editableContent homePage" id="editableContent">
                    <div id="screen">

                    </div>

                    @yield('content')

                    @include('layout.partials.msgbox')
                    @include('layout.partials.new_job_form')
                    @include('layout.partials.new_employee_form')
                    @include('layout.partials.edit_job_form')
                    @include('layout.partials.edit_employee_form')
                    @include('layout.partials.create_report_form')
                </div>
            </div>
            @include('layout.partials.sidebar')
        </div>
    </div>
    @include('layout.partials.actionbar')
    @include('layout.partials.footer')
</div>

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
<script type="text/javascript">

    //On pageload
    window.onload = start();selectTextField();

</script>
<script type="text/javascript">
    <!--
    window.onload = messageBox();
    -->
</script>
</body>
</html>
