/* 
	This page responsible for deleting member form. 
	Once the profile is selected from the list, 
	the button listener invokes a findRenewableMember function which executes a POST request. 
	The id of the selected profile is passed to the load-renewable-member.php API, 
	then the API generates an HTML form with that member profile, 
	including all details in a form of JSON. 
	That form is dynamically injected into the renewMembership app’s page. 
	The form contains details of member, switch button, 
	cancel button, and submit button. 
	The switch button makes sure the user cannot update 
	the profile in a database accidently. 
	Once the state of the switch button is changed to “YES” the update button is enabled. 
	Once the update button is clicked, the listener function invokes renewMember(id) function,
	which invokes an AJAX function, is called update-profile.php. 
	The AJAX forwards the profile’s id to the server-side API. 
	The API executes UPDATE SQL statement with the corresponding data. 
	After the server sends an acknowledgement to the app, 
	if the SQL operation was successful executed then the 
	JavaScript function transits to the memberList page. 
	
*/

$(document).on('pageinit', '#renewMembership', function(event){

	event.preventDefault();
	event.stopPropagation();

	APPATTRIBUTE.confirmationRenew = false;
	APPATTRIBUTE.addValidation = true;
				
		//Cancel delete profile process with this button listener
	$('#injectedRenewMembership').on('click', '.renewMembershipBtn', function (event) {
		try{
			event.preventDefault();
			
			// Resetting values of attributes before storing new values
			helper.resetFormVariables();

			APPATTRIBUTE.addName = $('#renewName').val();
			APPATTRIBUTE.addKey = $('#renewKey').val();
			APPATTRIBUTE.addDate = $('#renewDate').val();
			APPATTRIBUTE.addPhone = $('#renewPhoneNo').val();
			APPATTRIBUTE.addComment = $('#renewComment').val();

			// Perform validation process
			helper.addNewMemberFormValidation(APPATTRIBUTE.addName, APPATTRIBUTE.addKey, APPATTRIBUTE.addDate);

			if(APPATTRIBUTE.addValidation && APPATTRIBUTE.confirmationRenew) {
				//alert('validation check' + APPATTRIBUTE.renewableProfileId[1]);
	
				APPATTRIBUTE.userSubmit[0] = APPATTRIBUTE.validation;
				APPATTRIBUTE.userSubmit[1] = APPATTRIBUTE.renewableProfileId[1]; // profile ID
				APPATTRIBUTE.userSubmit[2] = APPATTRIBUTE.addName;
				APPATTRIBUTE.userSubmit[3] = APPATTRIBUTE.addKey;
				APPATTRIBUTE.userSubmit[4] = APPATTRIBUTE.addDate;
				APPATTRIBUTE.userSubmit[5] = APPATTRIBUTE.addComment;
	
				ajaxCall.renewableMember(APPATTRIBUTE.userSubmit);
			}
			else {
				alert('Az egyik mező hibás adatot tartalmaz!');
			}
		} catch(err) {
			alert('Renew button ERROR: ' + err);
		}
		return false;
	});
	
	//Cancel delete profile process with this button listener
	$('#injectedRenewMembership').on('click', '.renewBackMembershipBtn', function (event) { 
		event.preventDefault();
		event.stopPropagation();
		
		try{	
			//Call the ajax in order to fetch all members from database
			ajaxCall.fetchAllMembers(APPATTRIBUTE.validation);;
			
			//Change page to first page along with the whole list of member
			$.mobile.changePage('#membersList');
		} catch(err) {
			alert('Page renew membrship, pressed back button ERROR: ' + err);
		}
		return false;
	});
	
	// This function is attached to the switch button, including onChange listener to detect the state of the element.
	$('#injectedRenewMembership').on('change', '.renewCheck', function(event) {
		try{
			event.preventDefault();
			event.stopPropagation();
			if($('#renewCheck').val() == 'yes') {
				APPATTRIBUTE.confirmationRenew = true;
				//enable renew membership button once the switch indicates yes
				$('.renewMembershipBtn').removeClass('ui-state-disabled');
			}
			else {
				 APPATTRIBUTE.confirmationRenew = false;
				 $('.renewMembershipBtn').addClass('ui-state-disabled');
			}
		} catch(err) {
			alert('Update page switch button ERROR: ' + err);
		}
		return false;
	});

});