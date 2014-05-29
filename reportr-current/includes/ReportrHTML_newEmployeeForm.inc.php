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
<div id="newEmployeeForm">
<a id="close" href="#" onClick="closeBox('newEmployeeForm');undimButtonBar();<?php if($file=='index.php') { echo 'undimActionBar();';} ?>">x</a>
<div id="newEmployeeFormHeader">new <strong>employee</strong></div>
<div id="NEFcontent">
<form name="newEmployeeOTF" method="get" action="newEmployee.php" id="newEmployeeOTF">
    <input type="hidden" name="return-page" value="<?php echo $file; ?>" />
    <input type="hidden" name="return-query" value="<?php echo $query; ?>" />
    <p>Fill out the fields below to register a new employee.</p>
    <div id="empFNameBox" class="inputWrapper">
        <label for="empFNameInput">First Name</label>
        <div id="empFNameInputBox" class="textbox-small">
            <input id="empFNameInput" name="fname" class="input-text-small" type="text" onFocus="focusTextField('empFNameInputBox', 'small', 1)" onBlur="focusTextField('empFNameInputBox', 'small', 0)" />
        </div>
        <span class="helpText">(first name of registering employee.)</span>
    </div>
    <div id="empLNameBox" class="inputWrapper">
        <label for="empLNameInput">Last Name</label>
        <div id="empLNameInputBox" class="textbox-small">
            <input id="empLNameInput" name="lname" class="input-text-small" type="text" onFocus="focusTextField('empLNameInputBox', 'small', 1)" onBlur="focusTextField('empLNameInputBox', 'small', 0)" />
        </div>
        <span class="helpText">(last name of registering employee.)</span>
    </div>
    <div id="empCardBox" class="inputWrapper">
        <label for="empCardInput"><?php echo $string_inputMethod_instructions; ?>. </label>
        <div id="empCardInputBox" class="textbox-small">
            <input id="empCardInput" name="card" class="input-text-small" type="text" onFocus="focusTextField('empCardInputBox', 'small', 1)" onBlur="focusTextField('empCardInputBox', 'small', 0)" />
        </div>
        <span class="helpText">(<?php echo $string_inputMethod_hint;?>)</span>
    </div>
    <input type="submit" style="position: absolute; left: -9999px; width: 1px; height: 1px;"/>
    <a href="#" onClick="submitFormUsingID('newEmployeeOTF');" id="submit">submit</a>
</form>
</div>
</div>