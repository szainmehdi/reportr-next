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
if($file=='expressClock.php') {
    $query = "";
}
?>
<div id="newJobForm">
    <a id="close" href="#" onClick="closeBox('newJobForm');undimButtonBar();<?php if($file=='index.php') { echo 'undimActionBar();';} ?>">x</a>
    <div id="newJobFormHeader">new <strong>job</strong></div>
    <div id="NJFcontent">
        <form name="newJobOTF" method="get" action="newJob.php" id="newJobOTF">
            <input type="hidden" name="return-page" value="<?php echo $file; ?>" />
            <input type="hidden" name="return-query" value="<?php echo $query; ?>" />
            <p>Fill out the fields below to add a new job.</p>
            <div id="jobNumBox" class="inputWrapper">
                <label for="jobNumInput">Job Number</label>
                <div id="jobNumInputBox" class="textbox-small">
                    <input id="jobNumInput" name="number" class="input-text-small" type="text" onFocus="focusTextField('jobNumInputBox', 'small', 1)" onBlur="focusTextField('jobNumInputBox', 'small', 0)" />
                </div>
                <span class="helpText">(eg. 123456, A1234, 123456C, etc.)</span>
            </div>
            <div id="jobCustBox" class="inputWrapper">
                <label for="jobCustInput">Customer Code</label>
                <div id="jobCustInputBox" class="textbox-small">
                    <input id="jobCustInput" name="customer" class="input-text-small" type="text" onFocus="focusTextField('jobCustInputBox', 'small', 1)" onBlur="focusTextField('jobCustInputBox', 'small', 0)" />
                </div>
                <span class="helpText">(eg. ABI, WALMART, DFI)</span>
            </div>
            <div id="jobLocBox" class="inputWrapper">
                <label for="jobLocInput">Location</label>
                <div id="jobLocInputBox" class="textbox-small">
                    <input id="jobLocInput" name="location" class="input-text-small" type="text" onFocus="focusTextField('jobLocInputBox', 'small', 1)" onBlur="focusTextField('jobLocInputBox', 'small', 0)" />
                </div>
                <span class="helpText">(eg. Los Angeles, NYC, Building A)</span>
            </div>
            <div id="jobDescBox" class="inputWrapper">
                <label for="jobDescInput">Description</label>
                <div id="jobDescInputBox" class="textbox-large">
                    <input id="jobDescInput" name="description" class="input-text-large" type="text" onFocus="focusTextField('jobDescInputBox', 'large', 1)" onBlur="focusTextField('jobDescInputBox', 'large', 0)" />
                </div>
                <!-- <span class="helpText">(eg. Shadow Sticks - Sort and Shrink Wrap)</span> -->
            </div>
            <div id="jobProdBox" class="inputWrapper">
                <label for="jobProdInput">Production Per Hour</label>
                <div id="jobProdInputBox" class="textbox-tiny">
                    <input id="jobProdInput" name="prodPerHour" class="input-text-tiny" type="text" onFocus="focusTextField('jobProdInputBox', 'tiny', 1)" onBlur="focusTextField('jobProdInputBox', 'tiny', 0)" />
                </div>
                <span class="helpText">(Projected quantity produced in 1 hour)</span>
            </div>
            <div id="jobPEOBox" class="inputWrapper">
                <label for="jobPEOInput"># of People Required</label>
                <div id="jobPEOInputBox" class="textbox-tiny">
                    <input id="jobPEOInput" name="peopleReq" class="input-text-tiny" type="text" onFocus="focusTextField('jobPEOInputBox', 'tiny', 1)" onBlur="focusTextField('jobPEOInputBox', 'tiny', 0)" />
                </div>
                <span class="helpText">(# of people needed to meet production goal)</span>
            </div>
            <!-- #BeginLibraryItem "/Library/submitButton.lbi" -->
            <input type="submit" style="position: absolute; left: -9999px; width: 1px; height: 1px;"/>
            <!-- #EndLibraryItem -->
            <a href="#" onClick="submitFormUsingID('newJobOTF');" id="submit">submit</a>
        </form>
    </div>
</div>