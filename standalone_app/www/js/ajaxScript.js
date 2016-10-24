/*
 This script file contains all AJAX operations. Every function consumes a specific server-side API.
 Once the AJAX performs succesfuly request, the return values are injected into a content section of the page.
*/

var ajaxCall = {

/* 
	This AJAX function provides asynchronous data exchange mechanism with the server. 
	Once the valid authentication key is passed to the server (not secure) 
	then the server executes a prepared SQL statement, 
	based on the result the server returns a corresponding JSON data. 
	That JSON will be injected into the inner section of the page in a form of collapsible element. 
*/
	fetchAllMembers: function(oath) {
		$('#injectedContent').html(''); // remove previous content
		$.ajax({
			type: "POST",
			url: "http://ADDYOUROWNDOMAIN+APINAME.php",
			crossDomain: true,
			data:{dataOut:oath},
			cache: false,
			success: function(result){
				$('#injectedContent').html(result);
				$('#injectedContent').trigger('create');
				$.mobile.changePage("#membersList");
				return false;
			},
			error: function (request, status, error) {
				alert(request.responseText);
			}			 
		});	
	},
/* 
	This method passes an array with the user's details. 
	The AJAX type is a POST which contains only a valid data in order to minimaze incorrect data.
	Once the AJAX achieves a succes statement the form fields are reset to blank.
*/
	addNewProfile: function(newProfile) {
	//	$('#injectedContent').html(''); // remove previous content
	//	alert(newProfile[0] + ' / ' + newProfile[1] + ' / ' + newProfile[2] + ' / ' + newProfile[3] + ' / ' + newProfile[4] + ' / ' + newProfile[5] + ' / ');
		$.ajax({
			type: "POST",
			url: "http://http://ADDYOUROWNDOMAIN+APINAME.php",
			crossDomain: true,
			data:{dataOut:newProfile},
			cache: false,
			success: function(result){
				$('#createName').val("");
				$('#createKey').val("");
				$('#createDate').val("");
				$('#createComment').val("");
				return false;
			},
			error: function (request, status, error) {
				alert(request.responseText);
			}			 
		});	
	},
/*
	This AJAX requests a member profile from the database. 
	The SQL query is based on profile's id. 
	The API generates a valid HTML + JQuery Mobile content in a form of JSON. 
	Then the data is injected into an empty div container.
*/
	findRemovableMember: function(profileId) {
		//alert(profileId[1]);
		//$('#injectedContentDelete').html(''); // clear out previous content before the new profile is injected.
		$.ajax({
			type: "POST",
			url: "http://http://ADDYOUROWNDOMAIN+APINAME.php",
			crossDomain: true,
			data:{dataOut:profileId},
			cache: false,
			success: function(result){
				//alert('ajax findremovablemember profile: ' + result);
				$('#injectedContentDelete').html(result);
				$('#injectedContentDelete').trigger('create');
				APPATTRIBUTE.deleteBtnId = '';
				return false;
			},
			error: function (request, status, error) {
				alert(request.responseText);
			}			
		});	
	},
/*
	This AJAX sends a profile's id to the server. 
	The API executes a DELETE SQL statement. 
*/
	deleteMember: function(profileId) {
		$.ajax({
			type: "POST",
			url: "http://http://ADDYOUROWNDOMAIN+APINAME.php",
			crossDomain: true,
			data:{dataOut:profileId},
			cache: false,
			success: function(result){
				APPATTRIBUTE.deleteBtnId = '';
				return false;
			},
			error: function (request, status, error) {
				alert(request.responseText);
			}			
		});	
	},
	/* Loading member for renewing his/her profile */
	findRenewableMember: function(renewProfileId) { 
		$.ajax({
			type: "POST",
			url: "http://http://ADDYOUROWNDOMAIN+APINAME.php",
			crossDomain: true,
			data:{dataOut:renewProfileId},
			cache: false,
			success: function(result){
				$('#injectedRenewMembership').html(result);
				$('#injectedRenewMembership').trigger('create');
				return false;
			},
			error: function (request, status, error) {
				alert(request.responseText);
			}			
		});
		$.mobile.changePage('#renewMembership');
	},
	/* Renew member profile */
	renewableMember: function(renewProfile) { 
		$.ajax({
			type: "POST",
			url: "http://http://ADDYOUROWNDOMAIN+APINAME.php",
			crossDomain: true,
			data:{dataOut:renewProfile},
			cache: false,
			success: function(result){	
				//Call the ajax in order to fetch all members from database
				ajaxCall.fetchAllMembers(APPATTRIBUTE.validation);
				return false;
			},
			error: function (request, status, error) {
				alert(request.responseText);
			}			
		});
	},
		
	/* Search by using member name */
	searchMembers: function(searchName) {
		$.ajax({
			type: "POST",
			url: "http://http://ADDYOUROWNDOMAIN+APINAME.php",
			crossDomain: true,
			data:{dataOut:searchName},
			dataType: 'json',
			cache: false,
			success: function(result){
				$('#injectedContent').html('');
				$('#injectedContent').html(result);
				$('#injectedContent').trigger('create');
				$('#injectedContent').listview('refresh');
				return false;
			},
			error: function (request, status, error) {
				alert(request.responseText);
			}				 
		});	
	},
	
	/* Search by using member's key */
	searchKey: function(searchKey) {
		$.ajax({
			type: "POST",
			url: "http://http://ADDYOUROWNDOMAIN+APINAME.php",
			crossDomain: true,
			data:{dataOut:searchKey},
			dataType: 'json',
			cache: false,
			success: function(data){
				$('#injectedContent').html('');
				$('#injectedContent').html(data);
				$('#injectedContent').trigger('create');
				$('#injectedContent').listview('refresh');
				return false;
			},
			error: function (request, status, error) {
				alert(request.responseText);
			}
		});	
	}
}