<?php
    if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }
    
    // My Profile Post Submit
	if ( isset($_POST['submit']) ) {

        if(empty($_POST['driver_license'])) {
            $form_error = 'Favor de ingresar el número de la licencia de conducir.';
        }

        if(empty($_POST['fs_address'])) {
            $form_error = 'Favor de indicar la dirección donde reside.';
        }

        if(empty($_POST['city'])) {
            $form_error = 'Favor de indicar el nombre de la ciudad en la que reside.';
        }

        if(empty($_POST['fs_state'])) {
            $form_error = 'Favor de indicar el estado en el cual reside.';
        }

        if(empty($_POST['postal_code'])) {
            $form_error = 'Favor de indicar el código postal de donde reside.';
        }

        if(empty($_POST['country'])) {
            $form_error = 'Favor de indicar su país de residencia.';
        }

        if(empty($_POST['profile_bio'])) {
            $_POST['profile_bio'] = '';
        }

        if(empty($_POST['profile_linkedIn'])) {
            $_POST['profile_linkedIn'] = '';
        }

        //Verify if there is not an user with the same email, also confirm is not the same user
		if(get_user_by_email($_POST['email'])) {
			$form_error = 'El correo electrónico ingresado, ya está en uso.';
		}

		if(!is_email($_POST['email'])) {
			$form_error = 'Ha ingresado un correo electrónico inválido, favor de intentar nuevamente.';
        }
        
        if(empty($_POST['phone_number'])) {
            $form_error = 'Debe de ingresar el número de teléfono.';
        }

        if(empty($_POST['fullname'])) {
            $form_error = 'Debe ingresar el nombre completo.';
        }

        if(empty($_POST['bank_name'])) {
            $_POST['bank_name'] = '';
        }

        if(empty($_POST['bank_sole_owner'])) {
            $_POST['bank_sole_owner'] = '';
        }

        if(empty($_POST['bank_routing_number'])) {
            $_POST['bank_routing_number'] = '';
        }

        if(empty($_POST['bank_account_number'])) {
            $_POST['bank_account_number'] = '';
        }

        //Account type
        $type = $_POST['type'];

        //Autogenerate a password
        $password = generateNotSecureRandomString(10);

        if(empty($form_error)) { 
            if(new_user($_POST['fullname'], $_POST['email'], $_POST['phone_number'], $password, $_POST['country'], $_POST['driver_license'], $_POST['fs_address'], $_POST['city'], $_POST['fs_state'], $_POST['postal_code'], $_POST['preferred_lang'], $_POST['bank_name'], $_POST['bank_sole_owner'], $_POST['bank_routing_number'], $_POST['bank_account_number'])) {
                $form_success = 'Bien, el usuario fue creado exitosamente.';

                //Send email with password to the user
                send_notification_user_account_password($_POST['email'], $_POST['fullname'], $password, $type);

                header("Refresh:1");
            }
            else {
                $form_error = 'Hubo un error al crear el usuario, favor de intentarlo nuevamente.';
            }
        }

    }
    
    // My Profile Image Submit
    if ( isset($_POST['submit-image']) ) {
        if( empty($_FILES['profile_image'])) {
            $form_error = 'Favor de selecionar una foto de perfil e intentarlo nuevamente.';
        }

        if(empty($form_error)) { 
            if(profile_image($_FILES['profile_image'])){
                $form_success = 'Bien! Su foto de perfil fue actualizada correctamente.';
                header("Refresh:1");
            }
            else {
                $form_error = 'Hubo un error al actualizar su foto de perfil, favor de intentar nuevamente.';
            }
        }
    }
?>