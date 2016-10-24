/*
This script file contains set of JavaScript functions.
Each function performs only a single task in order to facilitate
other functional operation during run time. 
*/

var helper = {
	    
	/* This function chops off the item's
		id near underscore symbol. 
		The returned substring is a corresponding id 
	*/
    chopperString: function(cssClassName) {
        return cssClassName.split("_").pop();
    },	
	deletePopupDialog: function(id) {
		$('#popupDeleteMember').append('<div data-role="header" data-theme="a">\
			<h1>Delete Page?</h1>\
			</div>\
			<div role="main" class="ui-content">\
				<h3 class="ui-title">' + id + '</h3>\
				<p>This action cannot be undone.</p>\
				<a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b" data-rel="back">Cancel</a>\
				<a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b" data-rel="back" data-transition="flow">Delete</a>\
			</div>');
		$('#popupDeleteMember').trigger( 'create' );
	},

	/* Replace slash to dash within dynamically fetched date object */
	replaceSlashToDash: function(dateValue) {
		var formattedDate
		formattedDate = dateValue.replace(/\//g, "-");
		
		return formattedDate;
	},
	/* Reset form's variables in order to reuse in multiple times */
	resetFormVariables: function() {
		APPATTRIBUTE.addName = '';
		APPATTRIBUTE.addKey = '';
		APPATTRIBUTE.addDate = '';
		APPATTRIBUTE.addComment = 'N/A';
		APPATTRIBUTE.userSubmit = [];
		APPATTRIBUTE.addValidation = true;
	},
	
/* 
	Validation process of new member's form, checking input values.
	Using custom build regular expression is essential becuase the original app
	is designed for Hungarian users. 
*/
	addNewMemberFormValidation: function(name, key, date) {
		//alert('name:' + APPATTRIBUTE.addName + ' key:' + APPATTRIBUTE.addKey + ' date:' + APPATTRIBUTE.addDate);
		var regexName = /^[a-z]+[aáeéiíoóöőuúüű]+[AÁEÉIÍOÓÖŐUÚÜŰ]+[A-Z\s]+$/i;
		if(name == '' || name == 'null' ) {
				//alert('here');
			$('.name_error').html('* Nem adtál meg nevet!');
				APPATTRIBUTE.addValidation = false;
			//	APPATTRIBUTE.confirmationRenew = false;
		}
		else if(!/^[a-zaáeéiíoóöőuúüűAÁEÉIÍOÓÖŐUÚÜŰA-Z\s]+$/i.test(name)) {
			$('.name_error').html('* Nem érvényes karakter!');
				APPATTRIBUTE.addValidation = false;
			//	APPATTRIBUTE.confirmationRenew = false;
		}
		else {
			$(".name_error").html('');
		}
		if(key == '' || key == 'null' ) {
			//alert('here');
			$('.key_error').html('* Nem adtál meg biléta számot!');
			APPATTRIBUTE.addValidation = false;
		//	APPATTRIBUTE.confirmationRenew = false;
		}
		else if(!/^[0-9\s]+$/i.test(key)) {
			$('.key_error').html('* Nem érvényes biléta szám!');
			APPATTRIBUTE.addValidation = false;
		//	APPATTRIBUTE.confirmationRenew = false;
		}
		else if(key.length < 13) {
			$('.key_error').html('* A biléta szám rövid!');
			APPATTRIBUTE.addValidation = false;
		//	APPATTRIBUTE.confirmationRenew = false;
		}
		else if(key.length > 13) {
			$('.key_error').html('* A biléta szám hosszú!');
			APPATTRIBUTE.addValidation = false;
		//	APPATTRIBUTE.confirmationRenew = false;
		}
		else {
			$(".key_error").html('');
		}
		if(date == '' || date == 'null') {
			$('.date_error').html('* Nem adtál meg dátumot!');
			APPATTRIBUTE.addValidation = false;
		//	APPATTRIBUTE.confirmationRenew = false;
		}
		else {
			$(".date_error").html('');
		}
	}
};
