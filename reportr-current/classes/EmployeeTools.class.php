<?php
//EmployeeTools.class.php

require_once 'DB.class.php';
require_once 'Employee.class.php';


class EmployeeTools {

	//Log the user in. First checks to see if the 
	//username and password match a row in the database.
	//If it is successful, set the session variables
	//and store the user object within.
	/* public function login($username, $password)
	{

		$hashedPassword = md5($password);
		$result = mysql_query("SELECT * FROM users WHERE username = '$username' AND password = '$hashedPassword'");

		if(mysql_num_rows($result) == 1)
		{
			$_SESSION["user"] = serialize(new User(mysql_fetch_assoc($result)));
			$_SESSION["login_time"] = time();
			$_SESSION["logged_in"] = 1;
			return true;
		}else{
			return false;
		}
	}
	*/
	
	//Log the user out. Destroy the session variables.
	/* public function logout() {
		unset($_SESSION['user']);
		unset($_SESSION['login_time']);
		unset($_SESSION['logged_in']);
		session_destroy();
	} */

	//Check to see if a username exists.
	//This is called during registration to make sure all user names are unique.
	public function checkCardExists($card) {
		$result = mysql_query("select id from employees where card='$card'");
    	if(mysql_num_rows($result) == 0)
    	{
			return false;
	   	}else{
	   		return true;
		}
	}
	
	//get a user
	//returns an Employee object. Takes the id as an input
	public function get($id)
	{
		$db = new DB("");
		$result = $db->select('employees', "id = $id");
		
		return new Employee($result);
	}
	public function getWithCard($card)
	{
		$db = new DB("");
		$result = $db->select('employees', "card = '$card'");
		if($result!=-1) {		
			return new Employee($result);
		}
		else {
			return NULL;
		}
	}
	
	public function isClockedIn($card) {
		$clockedIn = false;
		
		//Get the employee object associated with the card number
		$db = new DB("");
		$employee = $db->select('employees', "card = '$card'");
		$empID = $employee['id'];
		
		//Check where employee is on clockInStack
		$result = $db->select("clockInStack", "employeeID = '$empID'");
		if($result) {
			$clockedIn = true;	
		}
		else {
			$clockedIn = false;	
		}
		
		return $clockedIn;
	}
	public function isClockedIn_ID($empID) {
		$clockedIn = false;
		
		//Get the employee object associated with the card number
		$db = new DB("");
		
		//Check where employee is on clockInStack
		$result = $db->select("clockInStack", "employeeID = '$empID'");
		if($result) {
			$clockedIn = true;	
		}
		else {
			$clockedIn = false;	
		}
		
		return $clockedIn;
	}
	public function isClockedInToThisJob($card, $jobID) {
		$clockedIn = false;
		
		//Get the employee object associated with the card number
		$db = new DB("");
		$employee = $db->select('employees', "card = '$card'");
		$empID = $employee['id'];
		
		//Check where employee is on clockInStack
		$result = $db->select("clockInStack", "employeeID = '$empID'");
		if($result) {
			$clockedIn = true;	
		}
		else {
			$clockedIn = false;	
		}
		
		return $clockedIn;
	}
	public function deleteEmployee($id) {
		$db = new DB("");
		$data = array(
			"card" => "'[DEL]'"
		);
		$where = "id = '" . $id . "'";
		$db->update($data,'employees', $where);
		
		return true;
	}
}


?>
