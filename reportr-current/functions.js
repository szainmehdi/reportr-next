// JavaScript Document
function checkedBox(form) {
	console.log(form);
	var elements = document.getElementById(form);
	for(var i=0; i<elements.length; i++){
		var str = elements[i].id;
		if(str.search("Num")!=-1) {
			var idLabel = elements[i].id + "_label";
			if(elements[i].checked==true) {
				document.getElementById(idLabel).className="selected";
			}
			else if(elements[i].checked==false) {
				document.getElementById(idLabel).className="deselected";	
			}
		}
		else if(str.search("employee")!=-1) {
			var idLabel = elements[i].id + "_label";
			if(elements[i].checked==true) {
				document.getElementById(idLabel).className="selected";
			}
			else if(elements[i].checked==false) {
				document.getElementById(idLabel).className="deselected";	
			}
		}
	}
}
function updateYear() {
		var date = new Date();
		var year=date.getFullYear();
		document.getElementById("footerYear").innerHTML=year;
}
function checkLength(i) {
	if(i<10) {
		i = "0" + i;	
	}
	return i;
}
function refreshPage() {
	window.location.href = window.location.href;	
}
function clock(){
	var now=new Date();
	var hours = checkLength(now.getHours());
	var minutes = checkLength(now.getMinutes());
	var seconds = checkLength(now.getSeconds());
	var format=1; //1 for 12 hour, 0 for 24 hour
	var time;
	var timeS;
	
	if(format==1) {
		if(hours >=12) {
			if(hours==12) {
				hours=12;	
			}
			else {
				hours = hours-12;
			}
			time = hours + ':' + minutes + ':' + seconds + ' pm';
			timeS = '<span class="clockHours">' + hours + '</span>:<span class="clockMinutes">' + minutes + '</span>:<span class="clockSeconds">' + seconds + '</span> <span class="ampm">pm</span>';
		}
		else if(hours < 12) {
			if(hours==0) {
				hours=12;	
			}
			time = hours + ':' + minutes + ':' + seconds + ' am';
			timeS = '<span class="clockHours">' + hours + '</span>:<span class="clockMinutes">' + minutes + '</span>:<span class="clockSeconds">' + seconds + '</span> <span class="ampm">am</span>';
		}
	}
	else if (format == 0) {
		time = hours + ':' + minutes + ':' + seconds;
	}
	document.title = "Reportr Web | " + time;
	document.getElementById("clock").innerHTML = timeS;
	setTimeout("clock();", 500);
}
function clockForTitleOnly(){
	var now=new Date();
	var hours = checkLength(now.getHours());
	var minutes = checkLength(now.getMinutes());
	var seconds = checkLength(now.getSeconds());
	var format=1; //1 for 12 hour, 0 for 24 hour
	var time;
	var timeS;
	
	if(format==1) {
		if(hours >=12) {
			if(hours==12) {
				hours=12;	
			}
			else {
				hours = hours-12;
			}
			time = hours + ':' + minutes + ':' + seconds + ' pm';
			timeS = '<span class="clockHours">' + hours + '</span>:<span class="clockMinutes">' + minutes + '</span>:<span class="clockSeconds">' + seconds + '</span> <span class="ampm">pm</span>';
		}
		else if(hours < 12) {
			if(hours==0) {
				hours=12;	
			}
			time = hours + ':' + minutes + ':' + seconds + ' am';
			timeS = '<span class="clockHours">' + hours + '</span>:<span class="clockMinutes">' + minutes + '</span>:<span class="clockSeconds">' + seconds + '</span> <span class="ampm">am</span>';
		}
	}
	else if (format == 0) {
		time = hours + ':' + minutes + ':' + seconds;
	}
	document.title = "Reportr Web | " + time;
	setTimeout("clockForTitleOnly();", 500);
}
function focusTextField(id,size,i) {
	 
	if(i==1 || i=="1")
	{
		var url = "url(images/textfield_" + size + "_selected.jpg";
	}
	else if (i==0 || i=="0") {
		var url = "url(images/textfield_" + size + ".jpg";
	}
	document.getElementById(id).style.backgroundImage=url;
	/*
	if(id=="searchInputBox" && i==1) {
		document.getElementById("searchHelp").style.display="none";
	}	
	else if(id=="searchInputBox" && i==0) {
		if(document.getElementById("searchBox").value=="") {
			document.getElementById("searchHelp").style.display="block";
		}
	}
	*/
}
function focusSearchField(fieldID, searchBoxID, searchHelpID, i) {
	if(fieldID=="searchInputBox" && i==1) {
		document.getElementById(searchHelpID).style.display="none";
	}	
	else if(fieldID=="searchInputBox" && i==0) {
		if(document.getElementById(searchBoxID).value=="") {
			document.getElementById(searchHelpID).style.display="block";
		}
	}
}
function selectTextField() {
	document.forms[0][0].focus();
}
function selectTextFieldById (id) {
	// focus on the input field for easy access...
	var input = document.getElementById(id);
	input.focus();
}
function clearTextField(id) {
	document.getElementById(id).value="";
}
function submitFormUsingID(id) {
	document.getElementById(id).submit();	
}
function validateForm() {
var field = document.forms["submit-form"]["cardID"];
if(field.value=="") {
	alert("Fields cannot be blank!");
	return false;
}
}
function submitForm() {
	document.forms[0].submit();
}
function reportFormButton(id) {
	var button = document.getElementById(id);
	if(id=="jobButton") {
		var boxID = "jobReports";	
		var otherBoxID = "employeeReports";
		var otherBox2ID = "jobSummaryReports";
		var otherButtonID = "employeeButton";
		var otherButton2ID = "jobSumButton";
	}
	else if(id=="employeeButton") {
		var boxID = "employeeReports";	
		var otherBoxID = "jobReports";
		var otherBox2ID = "jobSummaryReports";
		var otherButtonID = "jobButton";
		var otherButton2ID = "jobSumButton";
	}
	else if(id=="jobSumButton") {
		var boxID = "jobSummaryReports";	
		var otherBoxID = "jobReports";
		var otherBox2ID = "employeeReports";
		var otherButtonID = "jobButton";
		var otherButton2ID = "employeeButton";
	}
	var box = document.getElementById(boxID);
	var otherBox = document.getElementById(otherBoxID);
	var otherBox2 = document.getElementById(otherBox2ID);
	var otherButton = document.getElementById(otherButtonID);
	var otherButton2 = document.getElementById(otherButton2ID);
	if(button.className!="selected") {
		button.className="selected";
		otherBox.style.display="none";
		otherBox2.style.display="none";
		box.style.display="block";
		
	}
	if(otherButton.className=="selected") {
		otherButton.className="";
	}
	if(otherButton2.className=="selected") {
		otherButton2.className="";
	}
}
function openBox(id) {
	console.log(id);
	var box=document.getElementById(id);
	if(box==null) {
		console.log("No such box as " + id);
		return false;
			
	}
	else if(box.style.display=="block") {
		closeBox(id);
	}
	else {
		if(id!="newOverflow" && id!="editOverflow") {
			box.className="show";
			setTimeout(function() {
				box.className="shown";
				box.style.display="block";
			}, 250);
		}
		else {
			box.style.display="block";
		}
	}
}
function closeBox(id) {
	console.log(id);
	var box=document.getElementById(id);
	if(box==null) {
		console.log("No such box as " + id);
		return false;
			
	}
	else {
		box.className="hide";
		if(id!="newOverflow" && id!="editOverflow") {
			setTimeout(function() {
			box.style.display="none";
			box.className="";
		}, 250);
		}
		else {
			box.style.display="none";
		}
	}
}
function dimButtonBar() {
	document.getElementById("buttons").style.opacity="0.2";
}
function undimButtonBar() {
	document.getElementById("buttons").style.opacity="1.0";	
}
function dimActionBar() {
	document.getElementById("actionBar").style.opacity="0.2";
}
function undimActionBar() {
	document.getElementById("actionBar").style.opacity="1.0";	
}
function dimContent() {
	document.getElementById("editableContent").style.opacity="0.2";
}
function undimContent() {
	document.getElementById("editableContent").style.opacity="1.0";	
}
function checkProdScore() {
	var scoreDOM = document.getElementById('prodScore');
	var score = scoreDOM.innerHTML;
	var index = score.indexOf(" ");
	console.log(index);
	var scoreVal = score.substr(0, index);
	console.log("score = " + scoreVal + ";");
	if(scoreVal<80) {
		scoreDOM.style.color="red";	
	}
	else if(scoreVal>=80) {
		scoreDOM.style.color="green";	
	}
}
function checkProdScoreOnReport() {
	var scoreBox = document.getElementById('prodBox');
	var score = document.getElementById('score').innerHTML;
	if(score<80) {
		scoreBox.style.backgroundColor="red";	
	}
	else if(score>=80) {
		scoreBox.style.backgroundColor="green";	
	}
}
function countdown() {
	var countOut = document.getElementById('countdown');
	var countStr = countOut.innerHTML;
	var counter = countStr.charAt(0);
	
	if(counter >= 0) {
		counter--;
		var msg = "";
		if(counter>1) {
			msg = counter + " seconds";
			countOut.innerHTML=msg;
			setTimeout("countdown();", 1000);
		}
		else if(counter==1) {
			msg = counter + " second";
			countOut.innerHTML=msg;
			setTimeout("countdown();", 1000);
		}
		else if(counter==0) {
			msg = counter + " seconds";
			countOut.innerHTML=msg;
		}	
		
	}
	
}
function messageBox() {
	var boxType = document.getElementById('boxType');
	var box = document.getElementById('msgBox')
	if(boxType.innerHTML!="empty") {
		if(boxType.innerHTML=="error") {
			openBox('msgBox');
			box.style.backgroundColor="red";	
		}
		else if(boxType.innerHTML=="success") {
			openBox('msgBox');
			box.style.backgroundColor="green";	
		}
		setTimeout("closeBox('msgBox');", 4000);
	}
}
function deleteEmployee() {
	var r = window.confirm("Do you really wish to delete this employee? This action is permanent.");
	if(r == true) {
		console.log("Deleting employee...");
		document.getElementById('editEmployee').submit();
		
	}
	else {
		document.getElementById('delete').checked = false;
		console.log("Delete box unchecked.");
	}
}
function removeExpressEntry(id) {
	var entry = document.getElementById(id);
	entry.parentNode.removeChild(entry);
}

function start() {
	updateYear();
	clock();	
}