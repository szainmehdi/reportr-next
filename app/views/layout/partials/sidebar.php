<div id="sidebar">
    <div id="userBox">Logged in as <strong><?=Auth::user()->username; ?></strong> | <a href="settings">Settings</a> | <a href="logout">Logout</a></div>
    <div id="clockDiv"><span id="clock">10:08:00 am</span></div>
    <div id="sidebarTitle">employees <span class="strong">clocked in</span></div>
    <div id="clockedIn">
        <?php
        //Show clocked in users on the sidebar

        /*$db = new DB("");
        $sql = "SELECT * FROM clockInStack ORDER BY timeIn DESC";
        $result = mysql_query($sql);
        if($result) {
            $num = mysql_num_rows($result);

            $i=0;
            while($i < $num) {
                $employeeID = mysql_result($result, $i, "employeeID");
                $jobRef = mysql_result($result, $i, "openJobRef");
                $date = mysql_result($result, $i, "date");
                $time = $db->strToTime(mysql_result($result, $i, "timeIn"));

                $eTools = new EmployeeTools();
                $empOBJ = $eTools->get($employeeID);
                $name = $empOBJ->fname . " " . $empOBJ->lname;

                $jobResult = mysql_query("SELECT * FROM openJobStack WHERE referenceNum='$jobRef'");
                $jobID = mysql_result($jobResult, 0, "jobID"); //
                $jTools = new JobTools();
                $jobOBJ = $jTools->get($jobID);
                $jobNum = $jobOBJ->number;
                echo "<div id='empID-" . $employeeID . "' class='clockedInEntry'>" .
                    "<span class='name'>$name</span>" .
                    "<span class='jobNum'>Job $jobNum</span>" .
                    "<span class='clockIn'>Clocked in at $time</span>" .
                    "</div>";
                $i++;
            }
        }*/


        ?>

    </div>
    <div id="openJobsTitle">
        open <strong>jobs</strong>
    </div>
    <div id="openJobs">
        <?php
        //Show Open Jobs

        /*$db = new DB("");

        $sql = "SELECT * FROM openJobStack";
        $result = mysql_query($sql);
        if($result) {
            $num = mysql_num_rows($result);

            $i=0;
            while($i < $num) {
                $ref = mysql_result($result, $i, "referenceNum");
                $jobID = mysql_result($result, $i, "jobID");
                $jTools = new JobTools();
                $jobOBJ = $jTools->get($jobID);
                $jobNum = $jobOBJ->number;
                $jobDesc = "";
                $tempDesc = $jobOBJ->description;
                $strLength = strlen($tempDesc);
                if($strLength>=15) {
                    $subStr = substr($tempDesc, 0, 12);
                    $jobDesc = $subStr . "...";
                }
                else {
                    $jobDesc = $tempDesc;
                }
                echo "<div class='openJobEntry' id='openJob-ID$jobID'><div class='centered'>" .
                    "<span class='openJobEntry_JobNumber'>$jobNum</span>" .
                    "<span class='openJobEntry_JobDescription'>$jobDesc</span>" .
                    "</div></div>";
                $i++;
            }
        }*/
        ?>
        <!-- EXAMPLE CODE

        <div class="openJobEntry" id="openJob-ID4">
               <span class="openJobEntry_JobNumber">100000</span>
            <span class="openJobEntry_JobDescription">Test Job for Z...</span>
        </div>
        <div class="openJobEntry" id="openJob-ID4">
               <span class="openJobEntry_JobNumber">100000</span>
            <span class="openJobEntry_JobDescription">Test Job for Z...</span>
        </div>
        <div class="openJobEntry" id="openJob-ID4">
               <span class="openJobEntry_JobNumber">100000</span>
            <span class="openJobEntry_JobDescription">Test Job for Z...</span>
        </div>

        -->
    </div>
</div>