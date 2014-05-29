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
?>
<div id="editEmployeeForm">
<a id="close" href="#" onClick="closeBox('editEmployeeForm');undimButtonBar();<?php if($file=='index.php') { echo 'undimActionBar();';} ?>">x</a>
<div id="editEmployeeFormHeader">edit <strong>employee</strong></div>
<div id="EEFcontent">
<form name="editEmployeeForm" method="get" action="editEmployee.php" id="editEmployeeOTF">
    <input type="hidden" name="return-page" value="<?php echo $file; ?>" />
    <input type="hidden" name="return-query" value="<?php echo $query; ?>" />
    <p>Which employee do you wish to edit?</p>
    <div id="empCardBox" class="inputWrapper">
        <label for="empCardInput"><?php echo $string_inputMethod_instructions; ?>. </label>
        <div id="empCardInputBox" class="textbox-small">
            <input id="empCardInput" name="card" class="input-text-small" type="text" onFocus="focusTextField('empCardInputBox', 'small', 1)" onBlur="focusTextField('empCardInputBox', 'small', 0)" />
        </div>
        <span class="helpText">(<?php echo $string_inputMethod_hint; ?>)</span>
    </div>
    <a href="#" onClick="submitFormUsingID('editEmployeeOTF');" id="submit">submit</a>
</form>
</div>
</div>