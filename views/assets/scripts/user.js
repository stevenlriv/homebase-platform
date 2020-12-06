/* ----------------- Start Document ----------------- */
(function($){
    "use strict";
    
    $(document).ready(function(){   
    
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
				driver_license: "required",
      		    phone_number: "required",
      		    email: {
        		    required: true,
        		    // Specify that email should be validated
        		    // by the built-in "email" rule
        		    email: true
				},
				fs_address: "required",
				city: "required",
				fs_state: "required",
				postal_code: "required"
				  
    	    },
	
			// Specify validation error messages
            messages: {
				fullname: "Por favor, introduzca su nombre completo",
				driver_license: "Por favor, introduzca el número de su licencia de conducir",
                phone_number: "Por favor, introduzca su número de teléfono",
				email: "Por favor, introduzca una dirección de correo electrónico válida",
				fs_address: "Por favor, introduzca una dirección la dirección donde reside",
				city: "Por favor, introduzca el nombre de la ciudad en la que reside",
				fs_state: "Por favor, introduzca el estado en el cual reside",
				postal_code: "Por favor, introduzca el código postal de donde reside"
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
                    minlength: 8
                },
                confirm: {
                    required: true,
                    minlength: 8
                },
    	    },
	
			// Specify validation error messages
            messages: {
                old: {
                    required: "Por favor, introduzca su contraseña actual",
                },
                password: {
                    required: "Por favor, introduzca su nueva contraseña",
                    minlength: "Su contraseña debe tener al menos 8 caracteres de longitud"
                },
                confirm: {
                    required: "Por favor, confirme su nueva contraseña",
                    minlength: "Su contraseña debe tener al menos 8 caracteres de longitud"
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
                bank_confirm_account_number: "required",
    	    },
	
			// Specify validation error messages
            messages: {
                bank_name: "Por favor, introduzca el nombre de su banco",
                bank_sole_owner: "Por favor, introduzca el nombre del único propietario de su cuenta bancaria",
                bank_routing_number: "Por favor, introduzca su número de ruta bancaria",
                bank_account_number: "Por favor, introduzca su número de cuenta bancaria",
                bank_confirm_account_number: "Por favor, introduzca su número de cuenta bancaria aquí también.",
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
                //checkin_access_code: "required",
                //checkin_description: "required",
                //check_required: {
                    //required: true,
                    //url: true
                //},             
    	    },
	
			// Specify validation error messages
            messages: {
                listing_title: {
                    required: "Debe introducir un título para su lista de propiedades.",
                    maxlength: "El título de la lista debe tener 40 caracteres o menos."
                },
                type: {
                    required: "Debe seleccionar un tipo para su propiedad.",
                },
                square_feet: {
                    required: "Debes poner los pies cuadrados de la propiedad.",
                },
                number_rooms: {
                    required: "Debe seleccionar el número de habitaciones de su propiedad.",
                },
                number_bathroom: {
                    required: "Debe seleccionar el número de baños de su propiedad.",
                },
                monthly_house_original: {
                    required: "Debes fijar la renta mensual.",
                },
                deposit_house_original: {
                    required: "Debe establecer el depósito de seguridad requerido para la propiedad.",
                },
                physical_address: {
                    required: "Debe establecer la dirección física de la propiedad.",
                },
                country: {
                    required: "Debe entrar en el país donde se encuentra su propiedad.",
                },
                state: {
                    required: "Debe entrar en el estado donde se encuentra su propiedad. Si no hay estados, sólo tiene que volver a introducir el nombre de su país.",
                },
                city: {
                    required: "Debe entrar en la ciudad donde se encuentra su propiedad.",
                },
                zipcode: {
                    required: "Debes establecer el código postal de la propiedad.",
                },
                listing_description: {
                    required: "Debe establecer la descripción del listado de propiedades.",
                    minlength: "Su descripción debe ser de al menos 100 caracteres o más.",
                    maxlength: "Su descripción debe ser de 2000 caracteres o menos.",
                },
                keywords: {
                    maxlength: "Sus palabras clave deben tener 100 caracteres o menos."
                },
                checkin_access_code: {
                    required: "Debes establecer el código de acceso a la propiedad.",
                },
                checkin_description: {
                    required: "Debe explicarle al inquilino cómo entrar en la propiedad usando el código de acceso.",
                },
                check_required: {
                    required: "Debe aceptar nuestros términos antes de agregar o editar el listado.",
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
		    var title = 'Comparte el siguiente enlace';
		    var content = 'Es simple, comparte el enlace con los posibles inquilinos y si alquilan con nosotros te pagan!';

		    var code = '<form><div class="input-group"><input type="text" class="form-control" value="' + a_href +'" placeholder="Su enlace unico" id="copy-input" disabled></div></form>';

		    //Generate the popup
		    $.magnificPopup.open({
			    items: {
				    src: '<div id="small-dialog" class="zoom-anim-dialog"><button title="Close" type="button" style="color: #000;" class="mfp-close"></button><h2>' + title + '</h2><p>' + content + '</p><p>'+ code +'</p></div>',
				    type: 'inline'
			    }
		    });
	    });

	    //Open Assign popup
	    $( ".open-aa-pp" ).click(function() {

		    //get url
		    var a_href = $(this).attr('href');
		    var a_href = a_href.replace("#", "?");
		
		    //define url
		    var listing_uri = a_href;

		    //Content
		    var title = 'Ingresa el id del usuario';
		    var content = 'El id del usuario la puedes conseguir realizando una buqueda con el nombre del mismo. Este es un proceso irréversible, una vez se asigna una propiedad, ya no puede volver a ser asignada a otra persona.';

		    //Generate the popup
			
		    $.magnificPopup.open({
			    items: {
				    src: '<div id="small-dialog" class="zoom-anim-dialog"><button title="Close" type="button" style="color: #000;" class="mfp-close"></button><h2>' + title + '</h2><p>' + content + '</p><p><form type="GET"><label>Id del usuario</label><input type="number" name="id_user"><input type="hidden" name="assign" value="' + listing_uri + '"><input type="hidden" name="confirm" value="true"><button type="submit" class="button">Asignar</button></form></div>', // can be a HTML string, jQuery object, or CSS selector
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
		    var title = '¿Está seguro?';
		    var content = 'Esto aprobará el listado en la plataforma y los motores de búsqueda. Los inquilinos podrán alquilarlo.';

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
		    var title = '¿Está seguro?';
		    var content = 'Esto esconderá su listado de la plataforma y los motores de búsqueda. Nadie podrá verlo o alquilarlo.';

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
		    var title = '¿Está seguro?';
		    var content = 'Esto listará su listado a la plataforma y los motores de búsqueda podrán verlo. Los inquilinos de la plataforma podrán verla y alquilarla.';

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
		    var title = '¿Está seguro?';
		    var content = 'Esto eliminará permanentemente su listado de la plataforma y nadie podrá verlos o alquilarlos. No hay vuelta atrás de esta acción.';

		    //Generate the popup
		    new_action_popup(title, content, cancel_url, confirm_url);
	    });

        /*----------------------------------------------------*/
	    /* User Actions Popup
        /*----------------------------------------------------*/

	    //Open activate user popup
	    $( ".open-us-pp" ).click(function() {

		    //get url
		    var a_href = $(this).attr('href');
		    var a_href = a_href.replace("#", "?");
		
		    //define url
		    var cancel_url = '#';
		    var confirm_url = '/all-users' + a_href;

		    //Content
		    var title = '¿Está seguro?';
		    var content = 'Esto habilitará la cuenta del usuario.';

		    //Generate the popup
		    new_action_popup(title, content, cancel_url, confirm_url);
        });

	    //Open Hide user popup
	    $( ".open-uh-pp" ).click(function() {

		    //get url
		    var a_href = $(this).attr('href');
		    var a_href = a_href.replace("#", "?");
		
		    //define url
		    var cancel_url = '#';
		    var confirm_url = '/all-users' + a_href;

		    //Content
		    var title = '¿Está seguro?';
		    var content = 'Esto inhabilitará la cuenta del usuario y ya no podrá entrar a la misma.';

		    //Generate the popup
		    new_action_popup(title, content, cancel_url, confirm_url);
	    });
        
	    /*----------------------------------------------------*/
	    /* Default Popup Functions
        /*----------------------------------------------------*/
        
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