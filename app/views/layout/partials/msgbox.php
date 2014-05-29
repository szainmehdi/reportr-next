<div id="msgBox">
    <a id="close" href="#" onClick="closeBox('msgBox');">x</a>
    <?php
    $boxType = "empty";
    if(isset($_GET['newEmployee'])) {
        $val = $_GET['newEmployee'];
        if(isset($_GET['error'])) {
            $boxType = "error";
            $errVal = $_GET['error'];
            $errors = explode(";", $errVal);
            $num = count($errors);
            if($num>0) {
                echo "<strong>The following error(s) occured when adding the new employee:</strong><br />";
                $i=0;
                while($i<$num) {
                    switch($errors[$i]) {
                        case "-1":
                            //Duplicate Card Number
                            echo "That $string_inputMethod_type has already been assigned to another employee. Try another $string_inputMethod_type.<br />\n";
                            break;
                        case "-2":
                            //Card Number Blank
                            echo "The $string_inputMethod_type was not read correctly. Try again.<br />\n";
                            break;
                        case "-3":
                            //Card Number Blank
                            echo "The first name was left blank or is invalid.<br />\n";
                            break;
                        case "-4":
                            //Card Number Blank
                            echo "The last name was left blank or is invalid.<br />\n";
                            break;
                    }
                    $i++;
                }
            }
        }
        else if($val == "success") {
            $boxType="success";
            $fname = (isset($_GET['fname'])) ? $_GET['fname'] : "The";
            $lname = (isset($_GET['lname'])) ? $_GET['lname'] : "employee";
            echo "<strong>$fname $lname</strong> was successfully added.<br />\n";
        }

    }
    else if(isset($_GET['newJob'])) {
        $val = $_GET['newJob'];
        if(isset($_GET['error'])) {
            $boxType = "error";
            $errVal = $_GET['error'];
            $errors = explode(";", $errVal);
            $num = count($errors);
            if($num>0) {
                echo "<strong>The following error(s) occured when adding the new job:</strong><br />";
                $i=0;
                while($i<$num) {
                    switch($errors[$i]) {
                        case "-1":
                            //Duplicate Jobnum
                            echo "That job number is already in use. Enter a different job number.<br />\n";
                            break;
                        case "-2":
                            //jobnum Blank
                            echo "Job Number was left blank or is invalid.<br />\n";
                            break;
                        case "-3":
                            //description Blank
                            echo "Description was left blank or is invalid.<br />\n";
                            break;
                        case "-4":
                            //customer Blank
                            echo "Customer was left blank or is invalid.<br />\n";
                            break;
                        case "-5":
                            //location Blank
                            echo "Location was left blank or is invalid.<br />\n";
                            break;
                        case "-6":
                            //PROD/HR Blank
                            echo "Productivity Per Hour was left blank or is invalid.<br />\n";
                            break;
                        case "-7":
                            //#PEO REQ Blank
                            echo "# of People Required was left blank or is invalid.<br />\n";
                            break;
                    }
                    $i++;
                }
            }
        }
        else if($val == "success") {
            $boxType="success";
            $jobNum = (isset($_GET['jobNum'])) ? "Job " . $_GET['jobNum'] : "The job";
            echo "<strong>$jobNum</strong> was successfully added.<br />\n";
        }

    }
    else if(isset($_GET['clockInOut'])) {
        if(isset($_GET['error'])) {
            $boxType = "error";
            $errVal = $_GET['error'];
            $errors = explode(";", $errVal);
            $num = count($errors);
            if($num>0) {
                echo "<strong>The following error(s) occured when clocking in or out:</strong><br />";
                $i=0;
                while($i<$num) {
                    switch($errors[$i]) {
                        case "-1":
                            //Blank Card Number
                            echo "The $string_inputMethod_type was left blank.<br />\n";
                            break;
                        case "-2":
                            //Card Number Does Not Exist
                            echo "The $string_inputMethod_type you $string_inputMethod_actionPast was misread or has not been assigned to an employee. Try again or click 'New Employee' to assign this $string_inputMethod_type to an employee.<br />\n";
                            break;
                    }
                    $i++;
                }
            }
        }

    }
    else if(isset($_GET['endJob'])) {
        if(isset($_GET['error'])) {
            $boxType = "error";
            $errVal = $_GET['error'];
            $errors = explode(";", $errVal);
            $num = count($errors);
            if($num>0) {
                echo "<strong>The following error(s) occured when ending the job:</strong><br />";
                $i=0;
                while($i<$num) {
                    switch($errors[$i]) {
                        case "-1":
                            //No Job Selected
                            echo "No job was selected.<br />\n";
                            break;
                        case "-2":
                            //No QTY entered
                            echo "Total Quantity Produced was left blank.<br />\n";
                            break;
                        case "-3":
                            //Someone clocked into job
                            echo "Someone is clocked into this job. Make sure everyone is clocked out, then try again.<br />\n";
                            break;
                    }
                    $i++;
                }
            }
        }

    }
    else if(isset($_GET['createReport'])) {
        $val = $_GET['createReport'];
        if(isset($_GET['error'])) {
            $boxType = "error";
            $errVal = $_GET['error'];
            $errors = explode(";", $errVal);
            $num = count($errors);
            if($num>0) {
                echo "<strong>The following error(s) occured when creating the report:</strong><br />";
                $i=0;
                while($i<$num) {
                    switch($errors[$i]) {
                        case "-1":
                            echo "No job was selected for the report. Try again.<br />\n";
                            break;
                        case "-2":
                            echo "No form was submitted for the report. Try again.<br />\n";
                            break;
                        case "-3":
                            echo "The selected employee did not work for the entered week.<br />\n";
                            break;
                        case "-4":
                            echo "No employees worked for the selected week.<br />";
                            break;
                    }
                    $i++;
                }
            }
        }

    }
    else if(isset($_GET['express'])) {
        $val = $_GET['express'];
        if(isset($_GET['error'])) {
            $boxType = "error";
            $errVal = $_GET['error'];
            $errors = explode(";", $errVal);
            $num = count($errors);
            if($num>0) {
                echo "<strong>The following error(s) occured in Express Clock In & Out:</strong><br />";
                $i=0;
                while($i<$num) {
                    switch($errors[$i]) {
                        case "-1":
                            echo "No job was selected for Express Clock In & Out. Try again.<br />\n";
                            break;
                        case "-2":
                            echo "No employees were added to the queue for Express Clock In & Out. Try again.<br />\n";
                            break;
                    }
                    $i++;
                }
            }
        }

    }
    else if(isset($_GET['login'])) {
        $val = $_GET['login'];
        if(isset($_GET['error'])) {
            $boxType = "error";
            $errVal = $_GET['error'];
            $errors = explode(";", $errVal);
            $num = count($errors);
            if($num>0) {
                echo "<strong>The following error(s) occured when logging in:</strong><br />";
                $i=0;
                while($i<$num) {
                    switch($errors[$i]) {
                        case "-1":
                            //Company ID Blank
                            echo "Company ID was left blank.<br />\n";
                            break;
                        case "-2":
                            //Password Blank
                            echo "Password was left blank.<br />\n";
                            break;
                        case "-3":
                            //Company ID does not exist
                            echo "Company ID does not match any we have on file. Try again or contact us for help.<br />\n";
                            break;
                        case "-4":
                            //Password does not match.
                            echo "Password is incorrect. Try again or contact support.<br />\n";
                            break;
                        case "-5":
                            //NO form submitted
                            echo "No form was submitted.<br />\n";
                            break;
                    }
                    $i++;
                }
            }
        }
        else if($val == "success") {
            $boxType="success";
            $companyID = (isset($_SESSION['companyID'])) ? $_SESSION['companyID'] : $_GET['companyID'];
            echo "Logged in successfully to <strong>$companyID</strong>.<br />\n";
        }

    }
    else if(isset($_GET['editEmployee'])) {
        $val = $_GET['editEmployee'];
        $msg = (isset($_GET['msg']) ? $_GET['msg'] : "");
        $name = (isset($_GET['name']) ? $_GET['name'] : "");
        if(isset($_GET['error'])) {
            $boxType = "error";
            $errVal = $_GET['error'];
            $errors = explode(";", $errVal);
            $num = count($errors);
            if($num>0) {
                echo "<strong>The following error(s) occured when saving your changes:</strong><br />";
                $i=0;
                while($i<$num) {
                    switch($errors[$i]) {
                        case "-1":
                            //Company ID Blank
                            echo "First Name was blank or invalid.<br />\n";
                            break;
                        case "-2":
                            //Password Blank
                            echo "Last Name was blank or invalid.<br />\n";
                            break;
                        case "-3":
                            //Company ID does not exist
                            echo "Unknown error occurred. Please contact support.<br />\n";
                            break;
                        case "-4":
                            //Company ID does not exist
                            echo "The $string_inputMethod_type you $string_inputMethod_actionPast was misread or has not been assigned to an employee. Try again or click 'New Employee' to assign this $string_inputMethod_type to an employee.<br />\n";
                            break;

                    }
                    $i++;
                }
            }
        }
        else if($val == "success") {
            $boxType="success";
            if($msg=="updated") {
                echo "<strong>$name</strong> was successfully updated.<br />\n";
            }
            else if($msg=="deleted") {
                echo "<strong>$name</strong> was successfully deleted.<br />\n";
            }
        }

    }
    else if(isset($_GET['editJob'])) {
        $val = $_GET['editJob'];
        $num = (isset($_GET['jobNum']) ? "Job " . $_GET['jobNum'] : "The job");
        if(isset($_GET['error'])) {
            $boxType = "error";
            $errVal = $_GET['error'];
            $errors = explode(";", $errVal);
            $num = count($errors);
            if($num>0) {
                echo "<strong>The following error(s) occured when saving your changes:</strong><br />";
                $i=0;
                while($i<$num) {
                    switch($errors[$i]) {
                        case "-3":
                            //description Blank
                            echo "Description was left blank or is invalid.<br />\n";
                            break;
                        case "-4":
                            //customer Blank
                            echo "Customer was left blank or is invalid.<br />\n";
                            break;
                        case "-5":
                            //location Blank
                            echo "Location was left blank or is invalid.<br />\n";
                            break;
                        case "-6":
                            //PROD/HR Blank
                            echo "Productivity Per Hour was left blank or is invalid.<br />\n";
                            break;
                        case "-7":
                            //#PEO REQ Blank
                            echo "# of People Required was left blank or is invalid.<br />\n";
                            break;
                        case "-9":
                            //No form submitted
                            echo "No form was submitted. Try again.<br />\n";

                    }
                    $i++;
                }
            }
        }
        else if($val == "success") {
            $boxType="success";
            echo "<strong>$num</strong> was successfully updated.<br />\n";
        }

    }
    else if(isset($_GET['settings'])) {
        $val = $_GET['settings'];
        if($val == "success") {
            $boxType="success";
            echo "<strong>Settings</strong> successfully updated.<br />\n";
        }
    }
    else if(isset($_GET['logout'])) {
        $val = $_GET['logout'];
        if($val == "success") {
            $boxType="success";
            $companyID = (isset($_GET['companyID'])) ? $_GET['companyID'] : "-user-";
            echo "Logged out successfully from <strong>$companyID</strong>.<br />\n";
        }
    }
    ?>
    <span id="boxType"><?php echo $boxType; ?></span>
</div>