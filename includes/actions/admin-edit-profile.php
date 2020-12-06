<?php
    if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }
    
    // My Profile Post Submit
	if ( isset($_POST['submit']) ) {

        if(empty($_POST['driver_license'])) {
            $form_error = 'Favor de ingresar el número de su licencia de conducir.';
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
            //$_POST['country'] = '';
            $form_error = 'Favor de indicar su país de residencia.';
        }

        if(empty($_POST['profile_bio'])) {
            $_POST['profile_bio'] = '';
        }

        if(empty($_POST['profile_linkedIn'])) {
            $_POST['profile_linkedIn'] = '';
        }

        //Verify if there is not an user with the same email, also confirm is not the same user
		if(get_user_by_email($_POST['email']) && get_user_by_email($_POST['email'])['id_user']!=$view_user['id_user']) {
			$form_error = 'El correo electrónico ingresado, ya está en uso.';
		}

		if(!is_email($_POST['email'])) {
			$form_error = 'Ha ingresado un correo electrónico inválido, favor de intentar nuevamente.';
        }
        
        if(empty($_POST['phone_number'])) {
            $form_error = 'Debe de ingresar su número de teléfono.';
        }

        if(empty($_POST['fullname'])) {
            $form_error = 'Debe ingresar su nombre completo.';
        }

        if (!empty($_POST['profile_linkedIn']) && !filter_var($_POST['profile_linkedIn'], FILTER_VALIDATE_URL)) {
            $form_error = 'Debe ingresar un enlace válido de LinkedIn.';
        }

        if(empty($form_error)) { 
            if(update_profile($view_user['id_user'], $_POST['fullname'], $_POST['phone_number'], $_POST['email'], $_POST['profile_bio'], $_POST['profile_linkedIn'], $_POST['country'], $_POST['driver_license'], $_POST['fs_address'], $_POST['city'], $_POST['fs_state'], $_POST['postal_code'], true)) {
                $form_success = 'Bien, su perfil fue actualizado exitosamente.';
                header("Refresh:1");
            }
            else {
                $form_error = 'Hubo un error al actualizar su perfil, favor intentarlo nuevamente.';
            }
        }

    }
    
    // My Profile Image Submit
    if ( isset($_POST['submit-image']) ) {
        if( empty($_FILES['profile_image'])) {
            $form_error = 'Favor de selecionar una foto de perfil e intentarlo nuevamente.';
        }

        if(empty($form_error)) { 
            if(profile_image($_FILES['profile_image'], true)){
                $form_success = 'Bien! Su foto de perfil fue actualizada correctamente.';
                header("Refresh:1");
            }
            else {
                $form_error = 'Hubo un error al actualizar su foto de perfil, favor de intentar nuevamente.';
            }
        }
    }
?>