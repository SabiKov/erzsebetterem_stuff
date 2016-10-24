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
	
	//Create container for storing query result
	$menuList = array();
	
	//To store passed value
	$dataOut = array();
	$clientKey = 'ADD-YOUR-OWN-KEY'; // fake API key -- THIS IS NOT SECURE AUTHENTICATION MECHANISM
	
	//Get data from phonegap's app
	if (!empty($_POST['dataOut'])) {
		$dataOut = $_POST['dataOut'];
	}

//	$dataOut[0] = 'akos1977071111071977';
	//echo 'dataout: ' . $dataOut[0];
	if($connection === false) {
		$all_member = 'database error';
		$menuList[] = $all_member;	
	}
	
	if(strcasecmp($_POST['dataOut'], $clientKey) == 0 ){
		$all_member_query = "SELECT * FROM members ORDER BY name";
		$all_member_result = mysqli_query($connection, $all_member_query);// or die( "Could not execute SQL all_member query" );
		$all_member = '';
		$all_member .= '<div data-role="collapsibleset" data-theme="a" data-content-theme="a" data-min="true">';
		while ($row = mysqli_fetch_array($all_member_result) ){
			$all_member .= '<div data-role="collapsible" data-mini="true">';
				//$all_member .= '<form id="member_' . $row['id'] . '">';
					//Function retrives a corresponding collapsible header
					$all_member .= calculateElapsedDays($row['membership_start_date'], $row['membership_expire_date'], $row['name']);
					$all_member .= '<ul class="memberBtn" data-role="listview" data-inset="true">';
						$all_member .= '<li class="ui-field-contain ui-grid-b myBtn">';
							$all_member .= '<div class="ui-grid-solo">';
								$all_member .= 'Név:<input style="background-color:#b5a397;" readonly name="name_' . $row['id'] . '" id="name_' . $row['id'] . '" value="' . $row['name'] . '" type="text" data-mini="true">';
							$all_member .= '</div>';
							$all_member .= '<div class="ui-grid-solo">';
								$all_member .= 'Biléta szám:<input style="background-color:#ede9ce;" readonly name="key_' . $row['id'] . '" id="key_' . $row['id'] . '" value="' . $row['key_number'] . '" type="text" data-mini="true">';
							$all_member .= '</div>';
							$all_member .= '<div class="ui-grid-solo">';
								$all_member .= 'Bérlet kezdete:<input style="background-color:#ede9ce;" readonly name="start_' . $row['id'] . '" id="start_' . $row['id'] . '" value="' . $row['membership_start_date'] . '" type="text" data-mini="true">';
							$all_member .= '</div>';
							$all_member .= '<div class="ui-grid-solo">';
								$all_member .= 'Bérlet lejárta:<input style="background-color:#ede9ce;" readonly name="expire_' . $row['id'] . '" id="expire_' . $row['id'] . '" value="' . $row['membership_expire_date'] . '" type="text" data-mini="true">';
							$all_member .= '</div>';
							$all_member .= '<div class="ui-grid-solo">';
								$all_member .= 'Megjegyzés:<input style="background-color:#ede9ce;" readonly name="comment_' . $row['id'] . '" id="comment_' . $row['id'] . '" value="' . $row['comment'] . '" type="text" data-mini="true">';
							$all_member .= '</div>';
							$all_member .= '<div class="ui-grid-a">';
								$all_member .= '<a href="#" class="ui-btn ui-icon-recycle ui-btn-icon-top ui-corner-all renewMembershipBtn" style="background:#A0FFA0; font-size:3.0vw;" id="renewMembershipBtn_' . $row['id'] . '">Megújítás</a>';
							$all_member .= '</div>';						
							$all_member .= '<div class="ui-grid-b">';
								$all_member .= '<a href="#popupDeleteMember" data-rel="popup" data-position-to="window" data-transition="pop" class="ui-btn ui-icon-delete ui-btn-icon-top ui-corner-all deleteBtn" style="background:#FFA0A0; font-size: 3.0vw;" id="deleteBtn_' . $row['id'] . '">Törlés</a>';
							$all_member .= '</div>';	
						$all_member .= '</li>';
					$all_member .= '</ul>';	// end list
			//	$all_member .= '</form>'; // end form	
			$all_member .= '</div>';	// end list
		}
		$all_member .= '</div>';
		
		$menuList[] = $all_member;
	}
	else {
		$all_member = 'nem érvényes kód';
		$menuList[] = $all_member;
	}
	
	// data is JSON-formatted
	header("Content-type: application/json");
	echo json_encode($menuList);

	// -------------------------------------------------------------
	mysqli_close($connection);
	
	// Remove unwanted malicious characters  
	function prepare_data($data) {
		$data = trim($data);
		$data = stripcslashes($data);
		$data = htmlspecialchars($data);
		
		return $data;
	}
	
	//Calculate the difference between two dates
	function calculateElapsedDays($date1, $date2, $rowName) {
		$current_date = date('Y-m-d');          // Current date
		$db_date = date($date2);               // Date from your database
		if($current_date < $db_date) {
			$diff = abs(strtotime($current_date) - strtotime($db_date));
			$total_days = floor ($diff /  (60*60*24)) . ' nap';
			$nameTag = '<legend>' . $rowName . '<span style="float:right; background-color:#D4FFD4" class="ul-li-count">' . $total_days . '</span></legend>';
		} 
		else if($current_date == $db_date){
			$nameTag = '<legend>' . $rowName . '<span style="float:right; background-color:#FFFFD3" class="ul-li-count">*** Bérlet ma jár le! ***</span></legend>';
		}
		else {
			$nameTag = '<legend>' . $rowName . '<span style="float:right; background-color:#FFD2D2" class="ul-li-count">Bérlet Lejárt!</span></legend>';
		}
		
		return $nameTag;
	}
?>