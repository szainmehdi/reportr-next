<?php
//Employee.class.php

require_once 'DB.class.php';
require_once 'Job.class.php';

class Employee {
	
	//Public variables for Employee class
	public $id;
	public $card;
	public $fname;
	public $lname;
	

	//Constructor is called whenever a new object is created.
	//Takes an associative array with the DB row as an argument.
	function __construct($data) {
		$this->id = (isset($data['id'])) ? $data['id'] : "";
		$this->card = (isset($data['card'])) ? $data['card'] : "";
		$this->fname = (isset($data['fname'])) ? $data['fname'] : "";
		$this->lname = (isset($data['lname'])) ? $data['lname'] : "";
		
	}
	//Updates or adds the employee to the table
	public function save($isNewEmployee = false) {
		//create a new database object.
		$db = new DB("");
		
		//if the user is already registered and we're
		//just updating their info.
		if(!$isNewEmployee) {
			//set the data array
			$data = array(
				"card" => "'$this->card'",
				"fname" => "'$this->fname'",
				"lname" => "'$this->lname'"
			);
			
			//update the row in the database
			$db->update($data, 'employees', 'id = '.$this->id);
		}else {
		//if the user is being registered for the first time.
			$data = array(
				"card" => "'$this->card'",
				"fname" => "'$this->fname'",
				"lname" => "'$this->lname'"
			);
	
			$this->id = $db->insert($data, 'employees');
		}
		return true;
	}
	//Performs the necessary steps to clock in the employee.
	/************************************************************
	*              OVERVIEW OF CLOCK IN FUNCTION				*
	*************************************************************
	This function performs the following steps.
		1. Take the jobID as an arguement for the function
		2. Get the current date and time, well formated.
		3. Check if jobID is on the openJobStack.
			If yes:
			 a. Prepare array for data to be sent to DB->insert();
			 b. Send data to DB->insert();
			If no:
			 a. Retrieve the reference number from the openJobStack
			    for the jobID sent.
		4. Prepare an array for the clockInStack table.
		5. Insert the data into the clockInStack table.
		6. Verify and return.
	______________________________________________________________*/
	public function clockIn($jobID) {
		//Get the current time
		$now = time();
		$time = date("H:i:s");
		$date = date("Y-m-d");
		
		$db = new DB("");
		
		
		//Add the job to the Open Job Stack
		//New JobTools Class
		$jTools = new JobTools();
		$openJob = $jTools->checkJobOpenUsingID($jobID, true);
		if($openJob == false) {
			//Prepare the info to be send in the array...
			$stackData = array(
				"jobID" => "'$jobID'",
				"date" => "'$date'"
			);
			$openJobRef = $db->insert($stackData, 'openJobStack');
		}
		else {
			$openJobRef = $openJob['referenceNum'];
		}
		
		//Prepare clock table array
		$data = array(
				"employeeID" => "'$this->id'",
				"openJobRef" => "'$openJobRef'",
				"date" => "'$date'",
				"timeIn" => "'$time'",
			);
		
		//Create a Status Variable
		$status = "";
		
		//Insert the new clockin entry to the table
		$db->insert($data, 'clockInStack');
		
		return true;
	}
	
	/************************************************************
	*              OVERVIEW OF CLOCK OUT FUNCTION				*
	*************************************************************
	This function performs the following steps.
		1. Get the current date and time and weekNum, well formated.
		2. Retrieve an associative array for the corresponding
			clockInStack row of this employee object.
		3. Assign values from associative array to local variables.
		4. Use the clockInTime and clockOutTime to calculate hours.
		5. Delete the selected row in the clockInStack table.
		6. Send the data required to the clockLog, marking the end.
		7. Return.
	______________________________________________________________*/
	public function clockOut() {
		//Get the current time
		$clockOutTime = date("H:i:s");
		$weekNum = date("W");
		$date = date("Y-m-d");
		
		//Read the entry from the clock in table
		$db = new DB("");
		$where = "employeeID = '$this->id'";
		$result = $db->select('clockInStack', $where);
		
		//Assign Values to local variables
		$openJobRef = $result['openJobRef'];
		$openJobQuery = $db->select('openJobStack', "referenceNum='$openJobRef'");
		$clockInTime = $result['timeIn'];
		$jobID = $openJobQuery['jobID'];
		
		//Get total hours
		$start = explode(':', $clockInTime);
		$end = explode(':', $clockOutTime);
		$total_hours = ($end[0] - $start[0]) + round((($end[1] - $start[1])/60),2);
		if($total_hours == 0) {
				$total_hours=0.01;
		}
		
		//Delete the clock-in table row
		$db->delete('clockInStack', $where);
		
		//Prepare the Data array
		$data = array(
			"employeeID" => "'$this->id'",
			"jobID" => "'$jobID'",
			"date" => "'$date'",
			"clockIn" => "'$clockInTime'",
			"clockOut" => "'$clockOutTime'",
			"totalHours" => "'$total_hours'",
			"weekNum" => "'$weekNum'"
		);
		
		if($db->insert($data, 'clockLog')) {	
			return $total_hours;
		}
		else {
			return -1;	
		}

	}
	
	function getWeeklyHours() {
		$db = new DB("");
		$weekNum = date("W");
		
		$sql = "SELECT * FROM clockLog where weekNum = '$weekNum' and employeeID='$this->id'";
		$result = mysql_query($sql);
		$num = mysql_num_rows($result);
		$i=0;
		
		$weeklyHours = 0;
		while($i < $num) {
			$totalHours= mysql_result($result, $i, "totalHours");
			$weeklyHours+=$totalHours;
			$i++;	
		}
		
		return $weeklyHours;
	}
	
	
}

?>
