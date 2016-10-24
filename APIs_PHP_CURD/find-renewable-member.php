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
	
	//Create container for storing query result
	$profile = array();
	
	//To store passed value
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

		// ----------------------------------------------------------------------------------------------------------------------------------
	//Search for particular member based on id value 
	if(strcasecmp($dataOut[0], $clientKey) == 0 ) {
		$find_member_query = "SELECT * FROM members WHERE id = ". $dataOut[1];
		$find_member_result = mysqli_query($connection, $find_member_query);
		$find_member = '';
		
		while ($row = mysqli_fetch_array($find_member_result) ){
			$find_member .= '<form id="renewForm">';
			$find_member .= '<ul class="deleteFormBtn" data-role="listview" data-inset="true">';
				$find_member .= '<li class="ui-field-contain">';
					$find_member .= '<span class="name_error error"></span>';
					$find_member .= ' Név:<input style="background-color:#b5a397;" name="renewName" id="renewName" value="' . $row['name'] . '" type="text" data-mini="true">';
				$find_member .= '</li>';
				$find_member .= '<li class="ui-field-contain">';
					$find_member .= '<span class="key_error error"></span>';
					$find_member .= ' Biléta szám:<input style="background-color:#ede9ce;" name="renewKey" id="renewKey" value="' . $row['key_number'] . '" type="text" data-mini="true">';
				$find_member .= '</li>';
				$find_member .= '<li class="ui-field-contain">';
					$find_member .= '<span class="date_error error"></span>';
					$find_member .= ' Új Bérlet kezdete:<input type="date" data-date-format="yy-mm-dd" style="background-color:#ede9ce;" id="renewDate" value="' . $row['membership_expire_date'] . '" data-mini="true">';
				$find_member .= '</li>';
				$find_member .= '<li class="ui-field-contain">';
					$find_member .= 'Bérlet lejárta:<input style="background-color:#ede9ce;" readonly name="expire_' . $row['id'] . '" id="expire_' . $row['id'] . '" value="' . $row['membership_expire_date'] . '" type="text" data-mini="true">';
				$find_member .= '</li>';
				$find_member .= '<li class="ui-field-contain">';
					$find_member .= 'Megjegyzés:<input style="background-color:#ede9ce;" name="renewComment" id="renewComment" value="' . $row['comment'] . '" type="text" data-mini="true">';
				$find_member .= '</li>';
				$find_member .= '<li class="ui-field-contain">';
					$find_member .= '<label for="renewCheck">Menti az új dátumot?</label>';
					$find_member .= '<select name="renewCheck" id="renewCheck" class="renewCheck" data-role="slider">';
						$find_member .= '<option value="no">Nem</option>';
						$find_member .= '<option value="yes">Igen</option>';
					$find_member .= '</select>';
				$find_member .= '</li>';
			//	$find_member .= '<li class="ui-field-contain">';
					$find_member .= '<div class="ui-grid-a">';
						$find_member .= '<a href="#" class="ui-btn ui-icon-back ui-btn-icon-top ui-corner-all renewBackMembershipBtn" style="background:yellow; font-size:3.0vw;" id="renewBackMembershipBtn">Mégsé</a>';
					$find_member .= '</div>';						
					$find_member .= '<div class="ui-grid-b">';
						$find_member .= '<a href="#" class="ui-state-disabled ui-btn ui-icon-recycle ui-btn-icon-top ui-corner-all renewMembershipBtn" style="background:#A0FFA0; font-size:3.0vw;" id="renewMembershipBtn">Megújítás Mentés</a>';
					$find_member .= '</div>';	
			//	$find_member .= '</li>';
			$find_member .= '</ul>';	// end list	
		$find_member .= '</form>'; // end form
		} // end while loop
		$profile[] = $find_member;
	}
	else {
		$find_member = 'database error';
		$profile[] = $find_member;
	}
	// data is JSON-formatted
	header("Content-type: application/json");
	echo json_encode($profile);
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