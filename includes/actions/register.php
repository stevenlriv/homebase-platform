<?php
    if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }
    
	if ( isset($_POST['submit']) ) {

        //Verify if the email address is already in use
		if(get_user_by_email($_POST['email'])) {
			$form_error = 'Esa dirección de correo electrónico ya está en uso.';
		}

        if ( strlen($_POST['password'])<8 ) {
            $form_error = 'Tu contraseña debe tener 8 caracteres o más.';
        }

        if(empty($_POST['password'])) {
            $form_error = 'Debes introducir tu nueva contraseña.';
        }

		if(!is_email($_POST['email'])) {
			$form_error = 'Ha introducido una dirección de correo electrónico inválida, inténtelo de nuevo.';
        }
        
        if(empty($_POST['phone_number'])) {
            $form_error = 'Debes introducir tu número de teléfono.';
        }

        if(empty($_POST['fullname'])) {
            $form_error = 'Debes introducir tu nombre completo.';
        }

        if(empty($_POST['check_required'])) {
            $form_error = 'Debe aceptar nuestros términos de servicio y leer nuestra política de privacidad.';
        }

        if(empty($form_error)) { 
            if(new_user($_POST['fullname'], $_POST['email'], $_POST['phone_number'], $_POST['password'])) {
                $form_success = 'Genial, tu cuenta ha sido creada.';

                // Account confirmation
                if(get_setting(24) == 'true') {
                    // Get user id
                    $id_user = get_user_by_email($_POST['email'])['id_user'];

                    // Email Confirmation resend
                    $code = generateNotSecureRandomString(20);
                    $link = get_domain()."/confirm?email={$_POST['email']}&validation=$code";

                    update_user_table('code', $id_user, $code); 
                    send_confirmation_email($_POST['fullname'], $_POST['email'], $link);
                }

                // Auto log-in them
                login_user($_POST['email'], $_POST['password']);

                // Refresh page
                header("Refresh:1");
            }
            else {
                $form_error = 'Se ha producido un error al actualizar su cuenta, por favor inténtelo de nuevo, o póngase en contacto con nosotros.';
            }
        }

    }
?>