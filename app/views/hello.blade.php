@extends('layout.master')

@section('content')

    <div class="instructions">
        Swipe your timecard<br>
        to clock in or out. <img src="/images/readyscreen_visualaid_timecard.png" class="visualAid" alt="Timecard Image" />
    </div>
    <div id="cardIDinputBox">
        <form action="switch.php" method="post" id="submit-form" name="submit-form" onSubmit="return validateForm()">
            <input id="cardID" name="cardID" type="password" class="textField" maxlength="10" onFocus="focusTextField('cardIDinputBox', 'large', 1)" onBlur="focusTextField('cardIDinputBox', 'large', 0)" />
        </form>
    </div>
    <div id="buttons" class="buttonsDiv">
        <a class="back" href="javascript:clearTextField('cardID');">&lt; clear</a>
        <a class="forward" href="#" onClick="javascript:submitForm();">next &gt;</a>
    </div>

@stop