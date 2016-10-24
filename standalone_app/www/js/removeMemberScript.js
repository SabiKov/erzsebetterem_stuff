/*
	This page responsible for deleting member form. 
	Once the profile is selected from the list, 
	the button listener invokes a findRemovableMemberForm POST request. 
	The id of the selected profile is passed to the load-removable-form.php API,
	then the API generates an HTML form with that profile details in a form of JSON. 
	That form is dynamically injected into the removeMember app’s page. 
	The form contains details of member, switch button, cancel button, and submit button. 
	The switch button makes sure the user cannot delete the profile from database accidently.
	Once the state of the switch button is changed to “YES” the delete button becomes active. 
	Once the delete button is clicked, the listener function invokes deleteMember(id) function, 
	which invokes an AJAX function, is called delete-profile.php. 
	The AJAX forwards the profile’s id to the server-side API. 
	The API executes DELETE SQL statement with the corresponding profile id. 
	After the server sends an acknowledgement to the app, 
	if the SQL operation was successful executed then the JavaScript function transits to the memberList page.
*/

$(document).on('pageinit', '#removeMember', function(event){
	event.preventDefault();
	event.stopPropagation();
	
	// Declare initial value of confirmation value
	APPATTRIBUTE.confirmationDelete = false;

		//Cancel delete profile process with this button listener
	$('#injectedContentDelete').on('click', '.deleteMembershipBtn', function (event) {

		try{
			event.preventDefault();
			event.stopPropagation();
			if(APPATTRIBUTE.confirmationDelete) {
				ajaxCall.deleteMember(APPATTRIBUTE.removableProfileId);

				//Call the helper script in order to fetch all members from database
				ajaxCall.fetchAllMembers(APPATTRIBUTE.validation);

				APPATTRIBUTE.confirmationDelete = false;
				//Reload first page
				//$('#injectedContent').trigger('create');
				$.mobile.changePage('#membersList');
			}

		} catch(err) {
			alert('Delete button ERROR: ' + err);
		}
		// blocks reloading previously visted page
		return false;
	});

	//Cancel delete profile process with this button listener
	$('#injectedContentDelete').on('click', '.backMembershipBtn', function (event) {
		try{
			//Reset selected id of profile
			APPATTRIBUTE.deleteBtnId = '';

			//Call the ajax in order to fetch all members from database
			ajaxCall.fetchAllMembers(APPATTRIBUTE.validation);

			//Reload first page
			event.preventDefault();
			event.stopPropagation();
			$.mobile.changePage('#membersList');
		} catch(err) {
			alert('From delete from to the main page ERROR: ' + err);
		}
		return false;
	});

	/*
		Make sure the switch button state is equal with YES, otherwise the selected profile
		cannot be deleted by clicking delete button.
	*/
	$('#injectedContentDelete').on('change', '.doubleCheckSwitch', function(event) {
		try{
			//alert($('#doubleCheck').val());
			event.preventDefault();
			event.stopPropagation();
			if($('#doubleCheck').val() == 'yes') {
				APPATTRIBUTE.confirmationDelete = true;
				//enable delete member button once the switch indicates yes
				$('.deleteMembershipBtn').removeClass('ui-state-disabled');
			}
			else {
				 APPATTRIBUTE.confirmationDelete = false;
				 $('.deleteMembershipBtn').addClass('ui-state-disabled');
			}
		} catch(err) {
			alert('Delete page switch button ERROR: ' + err);
		}
		return false;
	});

});