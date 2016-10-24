<?php	
	header('Content-Type: text/html; charset=utf-8');

	// see the note below regarding CORS. (Cross-Origin Resource Sharing) header.
	header("Access-Control-Allow-Origin: *");
	
	// database connection
	require_once("include/db_connect.php");
	
	// select database
	$connection = dbConnection();

	date_default_timezone_set('Europe/Budapest');
	
	mysqli_set_charset($connection, "UTF8");
	mysqli_query($connection, "SET NAMES UTF8");
	
	//To store passed value
	$dataOut = array();
	$clientKey = 'ADD-YOUR-OWN-KEY'; // fake API key -- THIS IS NOT SECURE AUTHENTICATION MECHANISM
	
	// Check the DB connection
	if($connection === false) {
		$all_member = 'database error';
		$dataOut[] = $all_member;	
	}
	
	//Get data from phonegap's app
	if (!empty($_POST['dataOut'])) {
		$dataOut = $_POST['dataOut'];
	}
	// Add one month to starting date fo membership, including february and leap year calculation
	$dataOut[6] = calculateEndOfMembership($dataOut[4]);
	

	
	// Looping through to check unwanted chars within user's input
	for($i = 0; $i < count($dataOut); $i++) {
		$dataOut[$i] = prepare_data($dataOut[$i]);
	}

	//Update a new date into a data into DB
	if($dataOut > 0){
		if(strcasecmp($dataOut[0], $clientKey) == 0 ){ 
			$query = "UPDATE `members` SET 
					  `name`='$dataOut[2]'
					, `key_number`='$dataOut[3]'
					, `membership_start_date`='$dataOut[4]'
					, `membership_expire_date`='$dataOut[6]'
					, `comment`='$dataOut[5]'
					WHERE `id`='$dataOut[1]'";
		}
		else {
			$dataOut[] = 'update statement else part';
		}
		
		if(mysqli_query($connection, $query)) {
			$dataOut[] = 'sql statment ok';
		}
		else {
			$dataOut[] = 'sql statement not ok';
		}
	}
	else {
		echo '<h1>Error</h1>';
		$dataOut[] = 'passed parameter is incorrect';
	}
	echo json_encode($dataOut);
	// clean up
	mysqli_close($connection);
	
//*************************************************
	// Remove unwanted malicious characters  
	function prepare_data($data) {
		$data = trim($data);
		$data = stripcslashes($data);
		$data = htmlspecialchars($data);
		
		return $data;
	}
	/* The method takes one parameter which represents the starting date of the actual membership. 
	*  From that date the algorithm calculates the expire date of the membership 
	*  which would be the following month same day minus one day. 
	*  The algorithm also handles few exceptions, such as leap year, January 30, 31.  
	*/ 
	function calculateEndOfMembership($str) {
		
		$tempDate = explode('-', $str);

		if($tempDate[1] == 1 && $tempDate[2] > 29) {
			$dataOut[6] = date('Y-m-t', strtotime("10days", strtotime($str)));
		}
		else if($tempDate[1] == 4 || $tempDate[1] == 6 || $tempDate[1] == 9 || $tempDate[1] == 11) {
			$dataOut[6] = date('Y-m-d', strtotime("+29days", strtotime($str)));
		}
		else {
			$dataOut[6] = date('Y-m-d', strtotime("+30days", strtotime($str)));
		}
		
		return $dataOut[6];
	}
	
	
?>
