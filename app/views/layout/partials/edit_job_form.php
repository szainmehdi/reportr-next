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
if($file=="reportr_dev") {
    $file="index.php";
}
?>
<div id="editJobForm">
    <a id="close" href="#" onClick="closeBox('editJobForm');closeBox('screen');undimButtonBar();<?php if($file=='index.php') { echo 'undimActionBar();undimContent();';} ?>">x</a>
    <div id="editJobFormHeader">edit a <strong>job</strong></div>
    <div id="EJFcontent">
        <form name="editJobOTF" method="get" action="editJob.php" id="editJobOTF">
            <input type="hidden" name="return-page" value="<?php echo $file; ?>" />
            <input type="hidden" name="return-query" value="<?php echo $query; ?>" />
            <input type="hidden" name="form-type" value="edit-job" />
            <p>Select a job you wish to edit.</p>

            <div id="jobFormBox">
                <div class="selectAJob">
<!--                    --><?php //$jobTools->listAllJobs_report_RADIO("editJobOTF"); ?>
                </div>
            </div>
            <a href="#" onClick="submitFormUsingID('editJobOTF');" id="submit">submit</a>
        </form>
    </div>
</div>