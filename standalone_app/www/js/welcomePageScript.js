// The first page of the form. The "breakfast list" is displayed on this page
$(document).on('pageinit', '#welcome', function(event){
	
	//alert(memberList.length);
	$("#pg1LoginBtn").click(function(e) {
		e.preventDefault();
		
		//alert('here');
		//Call the helper script in order to fetch all members from database
		ajaxCall.fetchAllMembers(APPATTRIBUTE.validation);
		
		// Login details are stored into variables
//		APPATTRIBUTE.loginName = $('#pg1Username').val();
//		APPATTRIBUTE.loginPassword = $('#pg1Password').val();
//		alert('2');
//		alert(APPATTRIBUTE.loginName + " " + APPATTRIBUTE.loginPassword);
		// Store login details
	/*	var request_login = {
			password: LOGIN.password,
			ward_name: LOGIN.ward_name
		}
*/
		$.mobile.changePage("#membersList");
	});
});