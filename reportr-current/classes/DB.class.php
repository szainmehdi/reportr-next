<?php
//DB.class.php


class DB {
	//Protected Variables of the DB class. Always pre-intitiallized to the correct values.
	public $db_name = 'phplearning';
	protected $db_user = 'zcomputers';
	protected $db_pass = 'Zcomp92667!';
	protected $db_host = 'localhost';
	
	function __construct($dbName) {
		if($dbName!="") {
			$this->db_name = $dbName;
		}
		else {
			$this->db_name = "reportr_" . $_SESSION["companyID"];
		}
	}
	
	//open a connection to the database. Make sure this is called
	//on every page that needs to use the database.
	public function connect() {
		$connection = mysql_connect($this->db_host, $this->db_user, $this->db_pass);
		mysql_select_db($this->db_name);
 
		return true;
	}
	

	//takes a mysql row set and returns an associative array, where the keys
	//in the array are the column names in the row set. If singleRow is set to
	//true, then it will return a single row instead of an array of rows.
	public function processRowSet($rowSet, $singleRow=false)
	{
		$resultArray = array();
		while($row = mysql_fetch_assoc($rowSet))
		{
			array_push($resultArray, $row);
		}

		if($singleRow === true)
			return $resultArray[0];

		return $resultArray;
	}
	//Takes a string time and converts it to a date/time format with HH:MM:SS AM format
	function strToTime($strtime) {
		$unFtime = strtotime($strtime);
		$time = date("h:i:s a", $unFtime);
		
		return $time;
	}
	//takes a string date and converts it to a date/time format with YYYY-MM-DD format
	function strToDate($strdate) {
		$unFdate = strtotime($strdate);
		$date = date("Y-m-d", $unFdate);
		
		return $date;
	}
	//Select rows from the database.
	//returns a full row or rows from $table using $where as the where clause.
	//return value is an associative array with column names as keys.
	public function select($table, $where) {
		$sql = "SELECT * FROM $table WHERE $where";
		$result = mysql_query($sql);
		if(mysql_num_rows($result)) {
			if(mysql_num_rows($result) == 1) {
				return $this->processRowSet($result, true);
			}
	
			return $this->processRowSet($result);
		}
		else {
			return NULL;	
		}
	}
	public function selectOrdered($table, $where, $order) {
		$sql = "SELECT * FROM $table WHERE $where ORDER BY $order";
		$result = mysql_query($sql);
		if(mysql_num_rows($result) == 1)
			return $this->processRowSet($result, true);

		return $this->processRowSet($result);
	}
	//Selects all rows of a specified table from the database.
	//returns a full row or rows from $table using $where as the where clause.
	//return value is an associative array with column names as keys.
	public function selectAll($table) {
		$sql = "SELECT * FROM $table";
		$result = mysql_query($sql);
		if(mysql_num_rows($result) == 1)
			return $this->processRowSet($result, true);

		return $this->processRowSet($result);
	}
	
	public function selectAllOrdered($table, $order) {
		$sql = "SELECT * FROM $table ORDER BY $order";
		$result = mysql_query($sql);
		if(mysql_num_rows($result) == 1)
			return $this->processRowSet($result, true);

		return $this->processRowSet($result);
	}
	//Select rows from the database.
	//returns a full row or rows from $table using $where as the where clause.
	//return value is an associative array with column names as keys.
	public function selectOne($what, $table, $where) {
		$sql = "SELECT * FROM $table WHERE $where";
		$result = mysql_query($sql);
		if(mysql_num_rows($result) == 1)
			return $this->processRowSet($result, true);

		return $this->processRowSet($result);
	}

	
	//Displays database as a table using a switch statement.
	public function showDatabase($table) {
		
		$sql = "SELECT * FROM $table";
		$result = mysql_query($sql);
		$num = mysql_num_rows($result);
		
		$i=0;
		if($table=='employees') {
			while($i < $num) {
				$id = mysql_result($result, $i, "id");
				$card=mysql_result($result,$i,"card");
				$fname=mysql_result($result,$i,"fname");
				$lname=mysql_result($result,$i,"lname");
				
				echo "<tr>" .
						"<td>$id</td>" . 
						"<td>$card</td>" .
						"<td>$fname</td>" .
						"<td>$lname</td>" .
					  "</tr>";
					  
				$i++;	
			}
		}
		else if($table=='jobs') {
			while($i < $num) {
				$id          			= mysql_result($result, $i, "id");
				$number      			= mysql_result($result, $i, "number");
				$description 			= mysql_result($result, $i, "description");
				$customer    			= mysql_result($result, $i, "customer");
				$location    			= mysql_result($result, $i, "location");
				$productionPerHour 		= mysql_result($result, $i, "productionPerHour");
				$peopleRequired			= mysql_result($result, $i, "peopleRequired");
				
				echo "<tr>" .
						"<td>$id</td>" . 
						"<td>$number</td>" . 
						"<td>$description</td>" . 
						"<td>$customer</td>" . 
						"<td>$location</td>" . 
						"<td>$productionPerHour</td>" . 
						"<td>$peopleRequired</td>" . 
					  "</tr>";
				$i++;	
			}
		}
		else if($table=='clockInStack') {
			while($i < $num) {
				$employeeID    			= mysql_result($result, $i, "employeeID");
				$jobRef     			= mysql_result($result, $i, "openJobRef");
				$date		 			= mysql_result($result, $i, "date");
				$time					= $this->strToTime(mysql_result($result, $i, "timeIn"));
				
				
				
				echo "<tr>" .
						"<td>$employeeID</td>" . 
						"<td>$jobRef</td>" . 
						"<td>$date</td>" . 
						"<td>$time</td>" . 
					  "</tr>";
				$i++;	
			}
		}
		else if($table=='clockLog') {
			while($i < $num) {
				$reference				= mysql_result($result, $i, "referenceNum");
				$employeeID    			= mysql_result($result, $i, "employeeID");
				$jobID      			= mysql_result($result, $i, "jobID");
				$date 					= mysql_result($result, $i, "date");
				$clockIn	 			= $this->strToTime(mysql_result($result, $i, "clockIn"));
				$clockOut	 			= $this->strToTime(mysql_result($result, $i, "clockOut"));
				$totalHours				= mysql_result($result, $i, "totalHours");
				$weekNum				= mysql_result($result, $i, "weekNum");
				echo "<tr>" .
						"<td>$reference</td>" . 
						"<td>$employeeID</td>" . 
						"<td>$jobID</td>" . 
						"<td>$date</td>" .
						"<td>$clockIn</td>" . 
						"<td>$clockOut</td>" .
						"<td>$totalHours</td>" . 
						"<td>$weekNum</td>" . 
					  "</tr>";
				$i++;	
			}
		}
		else if($table=='openJobStack') {
			while($i < $num) {
				$reference				= mysql_result($result, $i, "referenceNum");
				$jobID	    			= mysql_result($result, $i, "jobID");
				$date	      			= mysql_result($result, $i, "date");
				echo "<tr>" .
						"<td>$reference</td>" .
						"<td>$jobID</td>" . 
						"<td>$date</td>" .
					  "</tr>";
				$i++;	
			}
		}
		else if($table=='jobLog') {
			while($i < $num) {
				$reference				= mysql_result($result, $i, "referenceNum");
				$jobID	    			= mysql_result($result, $i, "jobID");
				$date	      			= mysql_result($result, $i, "date");
				$qty					= mysql_result($result, $i, "qtyProduced");
				$totalHrs				= mysql_result($result, $i, "totalHours");
				$prodScore				= mysql_result($result, $i, "productivityScore");
				echo "<tr>" .
						"<td>$reference</td>" .
						"<td>$jobID</td>" . 
						"<td>$date</td>" .
						"<td>$qty</td>" .
						"<td>$totalHrs</td>" .
						"<td>$prodScore %</td>" . 
					  "</tr>";
				$i++;	
			}
		}

	}	
	
	function listEmployees_RADIO() { //for DropDown Menu
		$result = $this->selectAllOrdered('employees', "lname ASC");
		$num=count($result);
		$i=0;
		if($num == 0) {
			echo "<strong>No employees have been added yet.</strong>";	
		}
		else if($num == count($result, COUNT_RECURSIVE)) {
			echo "<input type='radio' name='empID' value='" . $result['id'] . "' id='employeeID_" . $result['id'] . "' onchange='checkedBox(\"employeeReportOTF\");' />
					<label class='deselected' id='employeeID_" . $result['id'] . "_label' for='employeeID_" . $result['id'] . "'> " . $result['lname'] . ", " . $result['fname'] . "<br />
					<span class='sub'>" . $result['card'] . "</span></label>";
		}
		else {
			$deleted = array();
			echo "<input type='radio' name='empID' value='all' id='employeeID_all' onchange='checkedBox(\"employeeReportOTF\");' />
					<label class='deselected' id='employeeID_all_label' for='employeeID_all'> - ALL EMPLOYEES - <br />
					<span class='sub'>Batch create a report for all employees</span></label>";
			while($i < $num) {
				//$result = $this->msort($result, array('lname'));
				if($result[$i]['card']=="[DEL]") {
					array_push($deleted, $i);
				}
				else {
					echo "<input type='radio' name='empID' value='" . $result[$i]['id'] . "' id='employeeID_" . $result[$i]['id']  . "' onchange='checkedBox(\"employeeReportOTF\");' />
						<label class='deselected' id='employeeID_" . $result[$i]['id'] . "_label' for='employeeID_" . $result[$i]['id'] . "'> " . $result[$i]['lname'] . ", " . $result[$i]['fname'] . "<br />
						<span class='sub'>" . $result[$i]['card'] . "</span></label>";
				}
				$i++;
			}
			
			if(count($deleted)>0) {
				$count = 0;
				while($count < count($deleted)) {
					$i = $deleted[$count];
					echo "<div class='inactive'>
							<input type='radio' name='empID' value='" . $result[$i]['id'] . "' id='employeeID_" . $result[$i]['id']  . "' onchange='checkedBox(\"employeeReportOTF\");' />
							<label class='deselected' id='employeeID_" . $result[$i]['id'] . "_label' for='employeeID_" . $result[$i]['id'] . "'> " . $result[$i]['lname'] . ", " . $result[$i]['fname'] . "<br />
							<span class='sub'>" . $result[$i]['card'] . "</span></label></div>";
					$count++;
				}
			}
		}
	}
	
	function listEmployees_express ($jobID, $status, $form) { //for DropDown Menu
		$result = $this->selectAllOrdered('employees', "lname ASC");
		$num=count($result);
		$i=0;
		if($num == 0) {
			echo "<strong>No employees have been added yet.</strong>";	
		}
		else if($num == count($result, COUNT_RECURSIVE)) {
			echo "<input type='radio' name='empID' value='" . $result['id'] . "' id='employeeID_" . $result['id'] . "' onchange='checkedBox(\"$form\");' />
					<label class='deselected' id='employeeID_" . $result['id'] . "_label' for='employeeID_" . $result['id'] . "'> " . $result['lname'] . ", " . $result['fname'] . "<br />
					<span class='sub'>" . $result['card'] . "</span></label>";
		}
		else {
			$deleted = array();
			/* echo "<input type='radio' name='empID' value='all' id='employeeID_all' onchange='checkedBox(\"$form\");' />
					<label class='deselected' id='employeeID_all_label' for='employeeID_all'> - ALL EMPLOYEES - <br />
					<span class='sub'>Batch create a report for all employees</span></label> <br />";
			*/
			while($i < $num) {
				//$result = $this->msort($result, array('lname'));
				if($result[$i]['card']=="[DEL]") {
					array_push($deleted, $i);
				}
				else {
					echo "<input type='radio' name='empID' value='" . $result[$i]['id'] . "' id='employeeID_" . $result[$i]['id']  . "' onchange='checkedBox(\"$form\");' />
						<label class='deselected' id='employeeID_" . $result[$i]['id'] . "_label' for='employeeID_" . $result[$i]['id'] . "'> " . $result[$i]['lname'] . ", " . $result[$i]['fname'] . "<br />
						<span class='sub'>" . $result[$i]['card'] . "</span></label>";
				}
				$i++;
			}
			/*
			if(count($deleted)>0) {
				$count = 0;
				while($count < count($deleted)) {
					$i = $deleted[$count];
					echo "<div class='inactive'>
							<input type='radio' name='empID' value='" . $result[$i]['id'] . "' id='employeeID_" . $result[$i]['id']  . "' onchange='checkedBox(\"$form\");' />
							<label class='deselected' id='employeeID_" . $result[$i]['id'] . "_label' for='employeeID_" . $result[$i]['id'] . "'> " . $result[$i]['lname'] . ", " . $result[$i]['fname'] . "<br />
							<span class='sub'>" . $result[$i]['card'] . "</span></label></div><br />";
					$count++;
				}
			}
			*/
		}
	}

	//Updates a current row in the database.
	//takes an array of data, where the keys in the array are the column names
	//and the values are the data that will be inserted into those columns.
	//$table is the name of the table and $where is the sql where clause.
	public function update($data, $table, $where) {
		foreach ($data as $column => $value) {
			$sql = "UPDATE $table SET $column = $value WHERE $where";
			mysql_query($sql) or die(mysql_error());
		}
		return true;
	}

	//Inserts a new row into the database.
	//takes an array of data, where the keys in the array are the column names
	//and the values are the data that will be inserted into those columns.
	//$table is the name of the table.
	public function insert($data, $table) {

		$columns = "";
		$values = "";

		foreach ($data as $column => $value) {
			$columns .= ($columns == "") ? "" : ", ";
			$columns .= $column;
			$values .= ($values == "") ? "" : ", ";
			$values .= $value;
		}

		$sql = "insert into $table ($columns) values ($values)";

		mysql_query($sql) or die(mysql_error());

		//return the ID of the user in the database.
		return mysql_insert_id();

	}
	
	public function doesThisExist($select, $from, $where) {
		$result = mysql_query("select $select from $from where $where");
    	if(mysql_num_rows($result) == 0)
    	{
			return false;
	   	}else{
	   		return true;
		}
	}
	
	//Deletes a row from the database.
	//Takes a string for table and a where clause, both are required.
	public function delete($table, $where) {
		if($where!="") {
			$sql = "DELETE FROM $table WHERE $where";
			mysql_query($sql) or die(mysql_error());
			return true;
		}	
		
	}
	
		/**
	 * Sort a 2 dimensional array based on 1 or more indexes.
	 * 
	 * msort() can be used to sort a rowset like array on one or more
	 * 'headers' (keys in the 2th array).
	 * 
	 * @param array        $array      The array to sort.
	 * @param string|array $key        The index(es) to sort the array on.
	 * @param int          $sort_flags The optional parameter to modify the sorting 
	 *                                 behavior. This parameter does not work when 
	 *                                 supplying an array in the $key parameter. 
	 * 
	 * @return array The sorted array.
	 */
	function msort($array, $key, $sort_flags = SORT_REGULAR) {
		if (is_array($array) && count($array) > 0) {
			if (!empty($key)) {
				$mapping = array();
				foreach ($array as $k => $v) {
					$sort_key = '';
					if (!is_array($key)) {
						$sort_key = $v[$key];
					} else {
						// @TODO This should be fixed, now it will be sorted as string
						foreach ($key as $key_key) {
							$sort_key .= $v[$key_key];
						}
						$sort_flags = SORT_STRING;
					}
					$mapping[$k] = $sort_key;
				}
				asort($mapping, $sort_flags);
				$sorted = array();
				foreach ($mapping as $k => $v) {
					$sorted[] = $array[$k];
				}
				return $sorted;
			}
		}
		return $array;
	}

}

?>