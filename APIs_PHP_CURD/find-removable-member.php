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
	
	// Retrieve data from phonegap's app
	if (!empty($_POST['dataOut'])) {
		$dataOut = $_POST['dataOut'];
	}
	
	if($connection === false) {
		$find_member = 'database error';
		$profile[] = $find_member;	
	}
	
	// ----------------------------------------------------------------------------------------------------------------------------------
	//Search for particular member based on id value 
	if(strcasecmp($dataOut[0], $clientKey) == 0 ) {
		$find_member_query = "SELECT * FROM members WHERE id = ". $dataOut[1];
		$find_member_result = mysqli_query($connection, $find_member_query);
		$find_member = '';
		
		while ($row = mysqli_fetch_array($find_member_result) ){
			$find_member .= '<form id="delete_' . $row['id'] . '">';
				$find_member .= '<ul class="deleteFormBtn" data-role="listview" data-inset="true">';
					$find_member .= '<li class="ui-field-contain">';
						$find_member .= 'Név:<input style="background-color:#b5a397;" readonly name="name_' . $row['id'] . '" id="name_' . $row['id'] . '" value="' . $row['name'] . '" type="text" data-mini="true">';
					$find_member .= '</li>';
					$find_member .= '<li class="ui-field-contain">';
						$find_member .= 'Biléta szám:<input style="background-color:#ede9ce;" readonly name="key_' . $row['id'] . '" id="key_' . $row['id'] . '" value="' . $row['key_number'] . '" type="text" data-mini="true">';
					$find_member .= '</li>';
					$find_member .= '<li class="ui-field-contain">';
						$find_member .= 'Bérlet kezdete:<input style="background-color:#ede9ce;" readonly name="start_' . $row['id'] . '" id="start_' . $row['id'] . '" value="' . $row['membership_start_date'] . '" type="text" data-mini="true">';
					$find_member .= '</li>';
					$find_member .= '<li class="ui-field-contain">';
						$find_member .= 'Bérlet lejárta:<input style="background-color:#ede9ce;" readonly name="expire_' . $row['id'] . '" id="expire_' . $row['id'] . '" value="' . $row['membership_expire_date'] . '" type="text" data-mini="true">';
					$find_member .= '</li>';
					$find_member .= '<li class="ui-field-contain">';
						$find_member .= 'Megjegyzés:<input style="background-color:#ede9ce;" readonly name="comment_' . $row['id'] . '" id="comment_' . $row['id'] . '" value="' . $row['comment'] . '" type="text" data-mini="true">';
					$find_member .= '</li>';
					$find_member .= '<li class="ui-field-contain">';
						$find_member .= '<label for="doubleCheck">Biztosan Törli?</label>';
						$find_member .= '<select name="doubleCheck" id="doubleCheck" class="doubleCheckSwitch" data-role="slider">';
							$find_member .= '<option value="no">Nem</option>';
							$find_member .= '<option value="yes">Igen</option>';
						$find_member .= '</select>';
					$find_member .= '</li>';
				//	$find_member .= '<li class="ui-field-contain">';
						$find_member .= '<div class="ui-grid-a">';
							$find_member .= '<a href="#" class="ui-btn ui-icon-back ui-btn-icon-top ui-corner-all backMembershipBtn" style="background:yellow; font-size:3.0vw;" id="backDeleteMembershipBtn">Mégsé</a>';
						$find_member .= '</div>';						
						$find_member .= '<div class="ui-grid-b">';
							$find_member .= '<a href="#" class="ui-state-disabled ui-btn ui-icon-delete ui-btn-icon-top ui-corner-all deleteMembershipBtn" style="background:#FFA0A0; font-size:3.0vw;" id="deleteMembershipBtn_' . $row['id'] . '">Törlés</a>';
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

	// -------------------------------------------------------------
	mysqli_close($connection);
?>