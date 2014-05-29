<?php
//Employee.class.php

require_once 'DB.class.php';
require_once 'Employee.class.php';

class Job {
	public $id;
	public $number;
	public $description;
	public $customer;
	public $location;
	public $productionPerHour;
	public $peopleRequired;
	
	//Constructor is called whenever a new object is created.
	//Takes an associative array with the DB row as an argument.
	function __construct($data) {
		$this->id = (isset($data['id'])) ? $data['id'] : "";
		$this->number = (isset($data['number'])) ? $data['number'] : "";
		$this->description = (isset($data['description'])) ? $data['description'] : "";
		$this->customer = (isset($data['customer'])) ? $data['customer'] : "";
		$this->location = (isset($data['location'])) ? $data['location'] : "";
		$this->productionPerHour = (isset($data['productionPerHour'])) ? $data['productionPerHour'] : "";
		$this->peopleRequired = (isset($data['peopleRequired'])) ? $data['peopleRequired'] : "";

	}
	//Updates or adds job to database.
	public function save($isNewJob = false) {
		//create a new database object.
		$db = new DB("");
		
		//if the user is already registered and we're
		//just updating their info.
		if(!$isNewJob) {
			//set the data array
			$data = array(
				"number" => "$this->number",
				"description" => "'$this->description'",
				"customer" => "'$this->customer'",
				"location" => "'$this->location'",
				"productionPerHour" => "'$this->productionPerHour'",
				"peopleRequired" => "'$this->peopleRequired'",
				
			);
			//update the row in the database
			$where = "id='$this->id'";
			$db->update($data, 'jobs', $where);
		}else {
		//if the user is being registered for the first time.
			$data = array(
				"number" => "'$this->number'",
				"description" => "'$this->description'",
				"customer" => "'$this->customer'",
				"location" => "'$this->location'",
				"productionPerHour" => "'$this->productionPerHour'",
				"peopleRequired" => "'$this->peopleRequired'",
			);
	
			$this->id = $db->insert($data, 'jobs');
		}
		return true;
	}
	
}

?>
