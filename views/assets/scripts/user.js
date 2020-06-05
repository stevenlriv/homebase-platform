/* ----------------- Start Document ----------------- */
(function($){
    "use strict";
    
    $(document).ready(function(){   

	    /*--------------------------------------------------*/
	    /*  User Profile Image
	    /*--------------------------------------------------*/
	    $("#profile_image").change(function(){
		    $( "#submit-image" ).trigger( "click" );
        });
    
	    /*----------------------------------------------------*/
	    /* My Profile Form Validation
	    /*----------------------------------------------------*/

  	    $("form[name='my-profile']").validate({
    	    // Specify validation rules
    	    rules: {
      		    // The key name on the left side is the name attribute
      		    // of an input field. Validation rules are defined
      		    // on the right side
      		    fullname: "required",
      		    phone_number: "required",
      		    email: {
        		    required: true,
        		    // Specify that email should be validated
        		    // by the built-in "email" rule
        		    email: true
      		    },
    	    },
	
			// Specify validation error messages
            messages: {
                fullname: "Please enter your full name",
                phone_number: "Please enter your phone number",
                email: "Please enter a valid email address"
            },

            // Make sure the form is submitted to the destination defined
            // in the "action" attribute of the form when valid
            submitHandler: function(form) {
                form.submit();
            }
        });

	    /*----------------------------------------------------*/
	    /* My Profile Change Password Validation
	    /*----------------------------------------------------*/

        $("form[name='change-password']").validate({
    	    // Specify validation rules
    	    rules: {
      		    // The key name on the left side is the name attribute
      		    // of an input field. Validation rules are defined
                // on the right side
                old: {
                    required: true,
                },
                password: {
                    required: true,
                    minlength: 12
                },
                confirm: {
                    required: true,
                    minlength: 12
                },
    	    },
	
			// Specify validation error messages
            messages: {
                old: {
                    required: "Please enter your current password",
                },
                password: {
                    required: "Please enter your new password",
                    minlength: "Your password must be at least 12 characters long"
                },
                confirm: {
                    required: "Please confirm your new password",
                    minlength: "Your password must be at least 12 characters long"
                },
            },

            // Make sure the form is submitted to the destination defined
            // in the "action" attribute of the form when valid
            submitHandler: function(form) {
                form.submit();
            }
        });

	    /*----------------------------------------------------*/
	    /* Financial Settings Form Validation
        /*----------------------------------------------------*/
        
        $("form[name='financial-settings']").validate({
    	    // Specify validation rules
    	    rules: {
      		    // The key name on the left side is the name attribute
      		    // of an input field. Validation rules are defined
      		    // on the right side
      		    bank_name: "required",
                bank_sole_owner: "required",
                bank_routing_number: "required",
                bank_account_number: "required",
    	    },
	
			// Specify validation error messages
            messages: {
                bank_name: "Please enter your bank name",
                bank_sole_owner: "Please enter your bank account sole owner name",
                bank_routing_number: "Please enter your bank routing number",
                bank_account_number: "Please enter your bank account number",
            },

            // Make sure the form is submitted to the destination defined
            // in the "action" attribute of the form when valid
            submitHandler: function(form) {
                form.submit();
            }
        });

	    /*----------------------------------------------------*/
	    /* Submit Property Form Validation
	    /*----------------------------------------------------*/

        $("form[name='submit-property']").validate({
    	    // Specify validation rules
    	    rules: {
      		    // The key name on the left side is the name attribute
      		    // of an input field. Validation rules are defined
      		    // on the right side
                listing_title: {
                    required: true,
                    maxlength: 40
                },
                type: "required",
                square_feet: "required",
                number_rooms: "required",
                number_bathroom: "required",
                monthly_house_original: "required",
                deposit_house_original: "required",
                physical_address: "required",
                country: "required",
                state: "required",
                city: "required",
                zipcode: "required",
                listing_description: {
                    required: true,
                    minlength: 100,
                    maxlength: 2000
                },
                keywords: {
                    maxlength: 100
                }, 
                checkin_access_code: "required",
                checkin_description: "required",
                check_required: {
                    required: true,
                    url: true
                },             
    	    },
	
			// Specify validation error messages
            messages: {
                listing_title: {
                    required: "You must enter a title for your property listing.",
                    maxlength: "You listing title must be 40 characters or less."
                },
                type: {
                    required: "You must select a type for your property.",
                },
                square_feet: {
                    required: "You must set the property square feet.",
                },
                number_rooms: {
                    required: "You must select the number of rooms for your property.",
                },
                number_bathroom: {
                    required: "You must select the number of bathrooms for your property.",
                },
                monthly_house_original: {
                    required: "You must set the monthly rent.",
                },
                deposit_house_original: {
                    required: "You must set the property required security deposit.",
                },
                physical_address: {
                    required: "You must set the property physical address.",
                },
                country: {
                    required: "You must enter the country where your property is located.",
                },
                state: {
                    required: "You must enter the state where your property is located. If there are no states, just re-enter your country name.",
                },
                city: {
                    required: "You must enter the city where your property is located.",
                },
                zipcode: {
                    required: "You must set the property zip code.",
                },
                listing_description: {
                    required: "You must set the property listing description.",
                    minlength: "You description must be at least 100 characters or more.",
                    maxlength: "You description must be 2000 characters or less.",
                },
                keywords: {
                    maxlength: "You keywords must be 100 characters or less."
                },
                checkin_access_code: {
                    required: "You must set the property access code.",
                },
                checkin_description: {
                    required: "You must explain the tenant how to get into the property using the access code.",
                },
                check_required: {
                    required: "You must agree to our terms before adding or editing the listing.",
                },
            },

            // Make sure the form is submitted to the destination defined
            // in the "action" attribute of the form when valid
            submitHandler: function(form) {
                form.submit();
            }
        });

	    /*----------------------------------------------------*/
	    /* My Properties Popups
	    /*----------------------------------------------------*/

	    //Open Unique Link Popup
	    $( ".open-ul-pp" ).click(function() {

		    //get url
		    var a_href = $(this).attr('href');
		    var a_href = a_href.replace("#", ""); //remove it

		    //Content
		    var title = 'Share the link below';
		    var content = 'Its simple, share the link to prospect tenants and if they rent with us you get paid!';

		    var code = '<form><div class="input-group"><input type="text" class="form-control" value="' + a_href +'" placeholder="Your unique url" id="copy-input" disabled></div></form>';

		    //Generate the popup
		    $.magnificPopup.open({
			    items: {
				    src: '<div id="small-dialog" class="zoom-anim-dialog"><button title="Close" type="button" style="color: #000;" class="mfp-close"></button><h2>' + title + '</h2><p>' + content + '</p><p>'+ code +'</p></div>',
				    type: 'inline'
			    }
		    });
	    });

	    //Open Approval popup
	    $( ".open-ap-pp" ).click(function() {

		    //get url
		    var a_href = $(this).attr('href');
		    var a_href = a_href.replace("#", "?");
		
		    //define url
		    var cancel_url = '#';
		    var confirm_url = '/my-properties' + a_href;

		    //Content
		    var title = 'Are you sure?';
		    var content = 'This will approve the listing on the platform and search engines. Tenants will be able to rent it.';

		    //Generate the popup
		    new_action_popup(title, content, cancel_url, confirm_url);
        });
        
	    //Open Hide popup
	    $( ".open-hd-pp" ).click(function() {

		    //get url
		    var a_href = $(this).attr('href');
		    var a_href = a_href.replace("#", "?");
		
		    //define url
		    var cancel_url = '#';
		    var confirm_url = '/my-properties' + a_href;

		    //Content
		    var title = 'Are you sure?';
		    var content = 'This will hide your listing from the platform and search engines. No one will be able to see it or rent it.';

		    //Generate the popup
		    new_action_popup(title, content, cancel_url, confirm_url);
	    });

	    //Open Show popup
	    $( ".open-sw-pp" ).click(function() {

		    //get url
		    var a_href = $(this).attr('href');
		    var a_href = a_href.replace("#", "?");
		
		    //define url
		    var cancel_url = '#';
		    var confirm_url = '/my-properties' + a_href;

		    //Content
		    var title = 'Are you sure?';
		    var content = 'This will list your listing to the platform and search engines will be able to see it. Tenants on the platform will be able to see it and rent it.';

		    //Generate the popup
		    new_action_popup(title, content, cancel_url, confirm_url);
	    });

	    //Open delete popup
	    $( ".open-dl-pp" ).click(function() {

		    //get url
		    var a_href = $(this).attr('href');
		    var a_href = a_href.replace("#", "?");
		
		    //define url
		    var cancel_url = '#';
		    var confirm_url = '/my-properties' + a_href;

		    //Content
		    var title = 'Are you sure?';
		    var content = 'This will permanently delete your listing from the platform and no one will be able to see them or rent it. There is no going back from this action.';

		    //Generate the popup
		    new_action_popup(title, content, cancel_url, confirm_url);
	    });

	    //Close popup
	    $( ".close-pp" ).click(function() {
		    $.magnificPopup.close(); 
	    });

	    //Popups
	    function new_action_popup(title, content, cancel_url, confirm_url) {
		    $.magnificPopup.open({
			    items: {
				    src: '<div id="small-dialog" class="zoom-anim-dialog"><button title="Close" type="button" style="color: #000;" class="mfp-close"></button><h2>' + title + '</h2><p>' + content + '</p><p><a href="' + cancel_url + '" class="button border close-pp" onClick="$.magnificPopup.close();">NO</a><a href="' + confirm_url + '" class="button">YES</a></div>', // can be a HTML string, jQuery object, or CSS selector
				    type: 'inline'
			    }
		    });		
	    }
    });

// ------------------ End Document ------------------ //

})(this.jQuery);