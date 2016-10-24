<?php
	
	header('Content-Type: text/html; charset=utf-8');
	
	// see the note below regarding CORS. (Cross-Origin Resource Sharing) header.
	header("Access-Control-Allow-Origin: *");
	
	// database connection
	require_once("include/db_connect.php");
	
	// select database
	$connection = dbConnection();

	//Time zone setting
	date_default_timezone_set('Europe/Budapest');
	
	mysqli_set_charset($connection, "UTF8");
	mysqli_query($connection, "SET NAMES UTF8");

	$dataOut = array();
	$clientKey = 'ADD-YOUR-OWN-KEY'; // fake API key -- THIS IS NOT SECURE AUTHENTICATION MECHANISM
	/*
	$dataOut[0] = 'akos1977071111071977';
	$dataOut[1] = 'belépő kártya szám';
	$dataOut[2] = '1234567890';
	$dataOut[3] = '2016-01-30';
	$dataOut[4] = '06703660340';
	$dataOut[5] = 'TEszt mentes';
	$dataOut[6] = ''; // store last day of membership
	*/
	if($connection === false) {
		$all_member = 'database error';
		$dataOut[] = $all_member;	
	}
	
	//Get data from phonegap's app
	if (!empty($_POST['dataOut'])) {
		$dataOut = $_POST['dataOut'];
	}
	// Add one month to starting date fo membership, including february and leap year calculation
	$dataOut[5] = calculateEndOfMembership($dataOut[3]);
	
	// Looping through to check unwanted chars within user's input
	for($i = 0; $i < count($dataOut); $i++) {
		$dataOut[$i] = prepare_data($dataOut[$i]);
	}

	//Insert data into DB
	if($dataOut > 0){
		if(strcasecmp($dataOut[0], $clientKey) == 0 ){ 
			$query = "INSERT INTO `members` (`name`
										, `key_number`
										, `membership_start_date`
										, `membership_expire_date`
										, `comment`)
				VALUES('$dataOut[1]', '$dataOut[2]'
						,'$dataOut[3]', '$dataOut[5]'
						,'$dataOut[4]');";

		//$result = mysqli_query($connection, $query);
		}
		else {
			
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
	
	/* Generate one month time gap for indicating membership expire date */
	function calculateEndOfMembership($str) {
		
		$tempDate = explode('-', $str);
	
		if($tempDate[1] == 1 && $tempDate[2] > 29) {
			$dataOut[5] = date('Y-m-t', strtotime("10days", strtotime($str)));
		}
		else if($tempDate[1] == 4 || $tempDate[1] == 6 || $tempDate[1] == 9 || $tempDate[1] == 11) {
			$dataOut[5] = date('Y-m-d', strtotime("+29days", strtotime($str)));
		}
		else {
			$dataOut[5] = date('Y-m-d', strtotime("+30days", strtotime($str)));
		}
		return $dataOut[5];
	}
	
	
?>
