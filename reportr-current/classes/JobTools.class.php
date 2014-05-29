<?php
//JobTools.class.php
//start the session


require_once 'DB.class.php';
require_once 'Employee.class.php';
require_once 'Job.class.php';

class JobTools {
	
	//Check to see if a job exists.
	public function checkJobExists($number) {
		$result = mysql_query("select id from jobs where number='$number'");
    	if(mysql_num_rows($result) == 0)
    	{
			return false;
	   	}else{
	   		return true;
		}
	}
	//Check to see if a job exists.
	public function checkJobExistsUsingID($id) {
		$result = mysql_query("select * from jobs where id=$id");
    	if(mysql_num_rows($result) == 0)
    	{
			return false;
	   	}else{ 
	   		return true;
		}
	}
	
	//check to see if a job exists on the openJobStack using openJobStackRef
	//return, if true, and associative array of the result from mysql query.
	public function checkJobOpen($ref, $return=false) {
		$db = new DB("");
		$result = mysql_query("select * from openJobStack where referenceNum='$ref'");
    	if(mysql_num_rows($result) == 0)
    	{
			return false;
	   	}
		else if(mysql_num_rows($result) == 1){
	   		if($return==false) {
				return true;
			}
			else{
				return $db->processRowSet($result, true);
			}
		}
	}
	//Checks to see if a job exits on the openJobStack using jobID
	//return, if true, and associative array of the result from mysql query.
	public function checkJobOpenUsingID($jobID, $return=false) {
		$db = new DB("");
		$result = mysql_query("select * from openJobStack where jobID='$jobID'");
    	if(mysql_num_rows($result) == 0)
    	{
			return false;
	   	}
		else if(mysql_num_rows($result) == 1){
	   		if($return==false) {
				return true;
			}
			else{
				return $db->processRowSet($result, true);
			}
		}
	}
	//check to see if a person is clocked in to an open job
	public function isOpenJobActive($ref) {
		$db = new DB("");
		$result = mysql_query("select * from clockInStack where openJobRef='$ref'");
    	if(mysql_num_rows($result) == 0)
    	{
			return false;
	   	}
		else{
			return true;
		}
	}
	
	//get a user
	//returns a job object. Takes the job id as an input
	public function get($id)
	{
		$db = new DB("");
		$result = $db->select('jobs', "id = $id");
		
		return new Job($result);
	}
	
	//Ends an open job from the openJobStack and puts the record on the jobLog
	public function endJob($ref, $qty, $setup, $comments) {
		$db = new DB("");
		$error = "";
		
		//Check if Job is Open and retrieve the row
		$OJResult = $this->checkJobOpen($ref, true);
		
		//$OJResult=$db->select('openJobStack', "referenceNum='$ref'");
		
		$jobID = "";
		$date = "";
		$totalHours="";
		$prodPerHour="";
		$peopleReq="";
		

		//make sure that no one is clocked in to
		//this open job.
		if($this->isOpenJobActive($ref)) {
			//Someone is still clocked in to job.
			$error += "Someone is still clocked in to this job.\n";
			return -2;
		}
		
		$jobID = $OJResult['jobID'];
		$date = $OJResult['date'];
		
		$job = $this->get($jobID);
		
		$prodPerHour=$job->productionPerHour;
		$peopleReq=$job->peopleRequired;
		
		$result=$db->select('clockLog', "jobID='$jobID' and date='$date' and jobLogRef IS NULL");
		$count = count($result);
		$countRec = count($result, COUNT_RECURSIVE);
		
		if ($count == $countRec) //i.e. $result has one row
		{
		  $totalHours += $result['totalHours'];	
		}
		else //i.e. $result has multiple rows
		{
		  for($i = 0; $i < $count; $i++) {
				$totalHours+=$result[$i]['totalHours'];
			}
		}
		
		//FORMULA:
		/* 
			GIVEN AT JOB ENTRY:
			  peopleReq
			  prodPerHour
			  
			GIVEN AT END OF JOB:
			  qtyProduced
			  setupTime
			  
			CALCULATED AT END OF JOB
			  estManHours = prodPerHour/peopleReq
			  totalHours (+= every employees time on the job) - setupTime
			  actualManHours = qtyProduced/totalHours
			  productivityScore = actualManHours/estManHours
			  
		*/
		//Deduct setup time
		$finalHours=$totalHours - $setup;
		
		//Perform the calculations	
		$estManHours = $prodPerHour/$peopleReq;
		$actualManHours = $qty/$finalHours;
		$productivityScore = round((($actualManHours/$estManHours)*100), 2);
		
		//Prepare the Data array
		$data = array(
			"jobID" => "'$jobID'",
			"date" => "'$date'",
			"qtyProduced" => "'$qty'",
			"totalHours" => "'$totalHours'",
			"setupTime" => "'$setup'",
			"productivityScore" => "'$productivityScore'",
			"comments" => "'$comments'"
		);		
		
		$jobLogRef = $db->insert($data, 'jobLog');
		if($jobLogRef>0) {
			$db->delete('openJobStack', "referenceNum='$ref'");
			if ($count == $countRec) //i.e. $result has one row
			{
				$refCL=$result['referenceNum'];
				$data = array("jobLogRef"=>$jobLogRef);
				$db->update($data, 'clockLog', "referenceNum='$refCL' and jobLogRef IS NULL");
			}
			else //i.e. $result has multiple rows
			{
			  for($i = 0; $i < $count; $i++) {
				$refCL=$result[$i]['referenceNum'];
				$data = array("jobLogRef"=>$jobLogRef);
				$db->update($data, 'clockLog', "referenceNum='$refCL' and jobLogRef IS NULL");
	
				}
			}
			return $jobLogRef;	
		}
			
			
	}
	//Lists jobs in a dropdown menu
	function listAllJobs() { //for DropDown Menu
		$db = new DB("");
		$result = $db->selectAll('jobs');
		$num=count($result);
		$i=0;
		//echo $result[$i]['number'];
		while($i < $num) {
			echo "<option value=\"" . $result[$i]['id'] . "\"> " . $result[$i]['number'] . " - " . $result[$i]['description'] . " </option>";
			$i++;
		}
	}
	
	//lists openJobs in a dropdown menu
	function listOpenJobs() { //for DropDown Menu
		$db = new DB("");
		$result = $db->selectAll('openJobStack');
		$num=count($result);
		$i=0;
		if (count($result) == count($result, COUNT_RECURSIVE)) //i.e. $result has one row
		{
			$job=$this->get($result['jobID']);
			echo "<option value=\"" . $result['referenceNum'] . "\"> " . $job->number . " - " . $job->description . " </option>";
		}
		else //i.e. $result has multiple rows
		{
			 while($i < $num) {
				$job=$this->get($result[$i]['jobID']);
				echo "<option value=\"" . $result[$i]['referenceNum'] . "\"> " . $job->number . " - " . $job->description . " </option>";
				$i++;
			}
		}
	}
	//list all ended jobs
	function listEndedJobs() { //for DropDown Menu
		$db = new DB("");
		$result = $db->selectAll('jobLog');
		$num=count($result);
		$i=0;
		if (count($result) == count($result, COUNT_RECURSIVE)) //i.e. $result has one row
		{
			$job=$this->get($result['jobID']);
			echo "<option value=\"" . $result['referenceNum'] . "\"> " . $job->number . " - " . $result['date'] . " </option>";
		}
		else //i.e. $result has multiple rows
		{
			 while($i < $num) {
				$job=$this->get($result[$i]['jobID']);
				echo "<option value=\"" . $result[$i]['referenceNum'] . "\"> " . $job->number . " - " . $result[$i]['date'] . " </option>";
				$i++;
			}
		}
	}
	//Lists jobs in a dropdown menu
	function listAllJobs_RADIO() { //for DropDown Menu
		$db = new DB("");
		$result = $db->selectAllOrdered('jobs', "number asc");
		$num=count($result);
		$i=0;
		if($num == 0) {
			echo "<strong>No jobs have been added yet.</strong>";	
		}
		else if($num == count($result, COUNT_RECURSIVE)) {
			$tempDesc = $result['description'];
			$strLength = strlen($tempDesc);
			if($strLength>=36) {
				$subStr = substr($tempDesc, 0, 33);
				$jobDesc = $subStr . "...";
			}
			else {
				$jobDesc = $tempDesc;
			}
			echo "<input type='radio' name='jobID' value='" . $result['id'] . "' id='jobNum_" . $result['number'] . "' onchange='checkedBox(\"jobNumForm\");' />
					<label class='deselected' id='jobNum_" . $result['number'] . "_label' for='jobNum_" . $result['number'] . "'>Job " . $result['number'] . "<br />
					<span class='sub'>" . $jobDesc . "</span></label>";
			$i++;
		}
		else {
			while($i < $num) {
				$tempDesc = $result[$i]['description'];
				$strLength = strlen($tempDesc);
				if($strLength>=36) {
					$subStr = substr($tempDesc, 0, 33);
					$jobDesc = $subStr . "...";
				}
				else {
					$jobDesc = $tempDesc;	
				}
				echo "<input type='radio' name='jobID' value='" . $result[$i]['id'] . "' id='jobNum_" . $result[$i]['number'] . "' onchange='checkedBox(\"jobNumForm\");' />
						<label class='deselected' id='jobNum_" . $result[$i]['number'] . "_label' for='jobNum_" . $result[$i]['number'] . "'>Job " . $result[$i]['number'] . "<br />
						<span class='sub'>" . $jobDesc . "</span></label>";
				$i++;
			}
		}
	}
	
	//Lists jobs in a dropdown menu
	function listAllJobs_report_RADIO($form) { //for DropDown Menu
		$db = new DB("");
		$result = $db->selectAllOrdered('jobs', "number asc");
		$num=count($result);
		$i=0;
		if($num == 0) {
			echo "<strong>No jobs have been added yet.</strong>";	
		}
		else if($num == count($result, COUNT_RECURSIVE)) {
			$tempDesc = $result['description'];
			$strLength = strlen($tempDesc);
			if($strLength>=36) {
				$subStr = substr($tempDesc, 0, 33);
				$jobDesc = $subStr . "...";
			}
			else {
				$jobDesc = $tempDesc;	
			}
			echo "<input type='radio' name='jobID' value='" . $result['id'] . "' id='jobNum_" . $result['number'] . "_" . $form . "' onchange='checkedBox(\"" . $form . "\");' />
					<label class='deselected' id='jobNum_" . $result['number'] . "_" . $form . "_label' for='jobNum_" . $result['number'] . "_" . $form . "'>Job " . $result['number'] . "<br />
					<span class='sub'>" . $jobDesc . "</span></label>";
			$i++;
		}
		else {
			while($i < $num) {
				$tempDesc = $result[$i]['description'];
				$strLength = strlen($tempDesc);
				if($strLength>=36) {
					$subStr = substr($tempDesc, 0, 33);
					$jobDesc = $subStr . "...";
				}
				else {
					$jobDesc = $tempDesc;	
				}
				echo "<input type='radio' name='jobID' value='" . $result[$i]['id'] . "' id='jobNum_" . $result[$i]['number'] . "_" . $form . "' onchange='checkedBox(\"" . $form . "\");' />
						<label class='deselected' id='jobNum_" . $result[$i]['number'] . "_" . $form . "_label' for='jobNum_" . $result[$i]['number'] . "_" . $form . "'>Job " . $result[$i]['number'] . "<br />
						<span class='sub'>" . $jobDesc . "</span></label>";
				$i++;
			}
		}
	}
	
	function listOpenJobs_RADIO() { //for DropDown Menu
		$db = new DB("");
		$result = $db->selectAll('openJobStack');
		$num=count($result);
		$i=0;
		if($num == 0) {
			echo "<strong>No jobs are open at this time.</strong>";	
		}
		else if($num == count($result, COUNT_RECURSIVE)) {
			$job=$this->get($result['jobID']);
			$tempDesc = $job->description;
			$strLength = strlen($tempDesc);
			if($strLength>=36) {
				$subStr = substr($tempDesc, 0, 33);
				$jobDesc = $subStr . "...";
			}
			else {
				$jobDesc = $tempDesc;	
			}
			echo "<input type='radio' name='open-job-ref' value='" . $result['referenceNum'] . "' id='jobNum_" . $job->number . "' onchange='checkedBox(\"endJobForm\");' />
					<label class='deselected' id='jobNum_" . $job->number . "_label' for='jobNum_" . $job->number . "'>Job " . $job->number . "<br />
					<span class='sub'>" . $jobDesc . "</span></label> <br />";
			$i++;
		}
		else {
			while($i < $num) {
				$job=$this->get($result[$i]['jobID']);
				$tempDesc = $job->description;
				$strLength = strlen($tempDesc);
				if($strLength>=36) {
					$subStr = substr($tempDesc, 0, 33);
					$jobDesc = $subStr . "...";
				}
				else {
					$jobDesc = $tempDesc;	
				}
				echo "<input type='radio' name='open-job-ref' value='" . $result[$i]['referenceNum'] . "' id='jobNum_" . $job->number . "' onchange='checkedBox(\"endJobForm\");' />
						<label class='deselected' id='jobNum_" . $job->number . "_label' for='jobNum_" . $job->number . "'>Job " . $job->number . "<br />
						<span class='sub'>" . $jobDesc . "</span></label> <br />";
				$i++;
			}
		}
		return $num;
	}
	//list all ended jobs
	function listEndedJobs_RADIO() { //for DropDown Menu
		$db = new DB("");
		$result = $db->selectAll('jobLog');
		$num=count($result);
		$i=$num-1;
		if($num == 0) {
			echo "<strong>No jobs have been ended yet.</strong>";	
		}
		else if (count($result) == count($result, COUNT_RECURSIVE)) //i.e. $result has one row
		{
			$job=$this->get($result['jobID']);
			$tempDesc = $job->description;
			$strLength = strlen($tempDesc);
			if($strLength>=36) {
				$subStr = substr($tempDesc, 0, 33);
				$jobDesc = $subStr . "...";
			}
			else {
				$jobDesc = $tempDesc;	
			}
			$dateT = strtotime($result['date']);
			$dateF = date("M d, Y", $dateT);
			echo "<input type='radio' name='jobLogRef' value='" . $result['referenceNum'] . "' id='refNum_" . $result['referenceNum'] . "' onchange='checkedBox(\"jobReportOTF\");' />
						<label class='deselected' id='refNum_" . $result['referenceNum'] . "_label' for='refNum_" . $result['referenceNum'] . "'>[" . $result['referenceNum'] . "] Job " . $job->number . " on " . $dateF . "<br />
						<span class='sub'>" . $jobDesc . "</span></label>";
		}
		else //i.e. $result has multiple rows
		{
			 while($i >= 0) {
				$job=$this->get($result[$i]['jobID']);
				$tempDesc = $job->description;
				$strLength = strlen($tempDesc);
				if($strLength>=36) {
					$subStr = substr($tempDesc, 0, 33);
					$jobDesc = $subStr . "...";
				}
				else {
					$jobDesc = $tempDesc;	
				}
				$dateT = strtotime($result[$i]['date']);
				$dateF = date("M d, Y", $dateT);
				echo "<input type='radio' name='jobLogRef' value='" . $result[$i]['referenceNum'] . "' id='refNum_" . $result[$i]['referenceNum'] . "' onchange='checkedBox(\"jobReportOTF\");' />
							<label class='deselected' id='refNum_" . $result[$i]['referenceNum'] . "_label' for='refNum_" . $result[$i]['referenceNum'] . "'>[" . $result[$i]['referenceNum'] . "] Job " . $job->number . " on " . $dateF . "<br />
							<span class='sub'>" . $jobDesc . "</span></label>";
				$i--;
			}
		}
	}
	function getNumOfOpenJobs() {
		$db = new DB("");
		$result = $db->selectAll('openJobStack');
		$num=count($result);
		return $num;	
	}
}
?>
