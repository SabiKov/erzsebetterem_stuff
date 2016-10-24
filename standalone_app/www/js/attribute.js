/*
	This script file only contains variables to store temporary user's inputs during the operation. 
	Since the state of variables are maintained by functions, either setting or getting their values. 
	The JavaScript’s variables are a global object by default, 
	therefore creating safely namespace is essential to avoid object collision with the same name, 
	if some library contains the same name. 
	Furthermore, the application starts and all variables reset to default values.  
*/

// This section needs to be moved later
$(document).on('pagebeforecreate', '[data-role="page"]', function() {
  loading('show', 1);
});
 
$(document).on('pageshow', '[data-role="page"]', function() {
  loading('hide', 1000);
});
 
function loading(showOrHide, delay) {
  setTimeout(function() {
    $.mobile.loading(showOrHide);
  }, delay);
}

 $(document).on({
    ajaxSend: function () { loading('show'); },
    ajaxStart: function () { loading('show'); },
    ajaxStop: function () { loading('hide'); },
    ajaxError: function () { loading('hide'); }
});
 
function loading(showOrHide) {
    setTimeout(function(){
        $.mobile.loading(showOrHide);
    }, 1); 
}
 
var APPATTRIBUTE = APPATTRIBUTE || {};

	// API key to exchange information with server-side API
	APPATTRIBUTE.validation = 'ADD-YOUR-OWN-KEY'; // fake API key -- THIS IS NOT SECURE AUTHENTICATION MECHANISM';

	// For holding login details
	APPATTRIBUTE.loginName = '';
	APPATTRIBUTE.loginPassword = '';
	
	// Variables for add new member form, each variable belong to one input field
	APPATTRIBUTE.addName;
	APPATTRIBUTE.addKey;
	APPATTRIBUTE.addDate;
	APPATTRIBUTE.addComment;
	APPATTRIBUTE.userSubmit;
	
	//Attributes for delete membership section
	APPATTRIBUTE.confirmationDelete = false;
	APPATTRIBUTE.deleteBtnId = '';
	APPATTRIBUTE.removableProfileId;
	
	// Renew membership 
	APPATTRIBUTE.renewableProfileId;
	
	// Search key holder
	APPATTRIBUTE.searchKey;
	