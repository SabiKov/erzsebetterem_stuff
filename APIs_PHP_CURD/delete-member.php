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
	
	if($connection === false) {
		$all_member = 'database connection error';
		$dataOut[] = $all_member;	
	}
	
	//Get data from phonegap's app
	if (!empty($_POST['dataOut'])) {
		$dataOut = $_POST['dataOut'];
	}

	// Looping through to check unwanted chars within user's input
	for($i = 0; $i < count($dataOut); $i++) {
		$dataOut[$i] = prepare_data($dataOut[$i]);
	}
	
	//Insert data into DB
	if($dataOut > 0){	
		if(strcasecmp($dataOut[0], $clientKey) == 0 ){
			//Search for particular member based on id value 
			$delete_member_query = "DELETE FROM members WHERE id = ". $dataOut[1];
		}

		if(mysqli_query($connection, $delete_member_query)) {
			$dataOut[] = 'sql statement ok, profile was succesfuly removed from database';
		}
		else {
			$dataOut[] = 'sql statement not ok';
		}
	}
	else {
		echo '<h1>Error</h1>';
	}
	// see the note below regarding CORS. (Cross-Origin Resource Sharing) header.
	header("Access-Control-Allow-Origin: *");

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
?>