<?php
    if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }
    
    // Cache Settings
    $_SESSION['CACHE_MY_PROFILE'] = 'my-profile';
    $cache_id = $_SESSION['CACHE_MY_PROFILE'];
    $cache = get_cache($cache_id);
    
    // Email Confirmation resend
    if(!empty($_GET['resend']) && $_GET['resend'] == 'true' && $user['status'] == 'pending') {
        $code = generateNotSecureRandomString(20);
        $link = get_domain()."/confirm?email={$user['email']}&validation=$code";

        if(update_user_table('code', $user['id_user'], $code) && send_confirmation_email($user['fullname'], $user['email'], $link)) {
            $form_success = 'Bien! Su correo electrónico de confirmación fue enviado exitosamente.';
        }
    }

    // My Profile Post Submit
	if ( isset($_POST['submit']) ) {

        if(empty($_POST['country'])) {
            $_POST['country'] = '';
        }

        if(empty($_POST['profile_bio'])) {
            $_POST['profile_bio'] = '';
        }

        if(empty($_POST['profile_linkedIn'])) {
            $_POST['profile_linkedIn'] = '';
        }

        //Verify if there is not an user with the same email, also confirm is not the same user
		if(get_user_by_email($_POST['email']) && get_user_by_email($_POST['email'])['id_user']!=$user['id_user']) {
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
            if(update_profile($user['id_user'], $_POST['fullname'], $_POST['phone_number'], $_POST['email'], $_POST['profile_bio'], $_POST['profile_linkedIn'], $_POST['country'])) {
                $form_success = 'Bien, su perfil fue actualizado exitosamente.';
                delete_cache($cache_id);
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