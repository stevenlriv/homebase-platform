<?php
    if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }

    if(empty($_GET['email']) || empty($_GET['validation'])) {
        header('Location: /');
    }

    $user_details = get_user_by_email($_GET['email']);

    if($user_details['code'] == $_GET['validation']) {
        //Update code and user status
        if(update_user_table('code', $user_details['id_user'], '') && update_user_table('status', $user_details['id_user'], 'active')) {
            $form_success = 'Bien! Su cuenta fue confirmada exitosamente.';
            
            //Send them to the properties page
            header('Location: /my-properties');
        }
        else {
            $form_error = 'Hubo un error al confirmar su cuenta, favor de intentarlo nuevamente.';
        }
    }
    else {
        $form_error = 'Parece que su código no es válido. Puede recibir un nuevo código haciendo click <a href="/my-profile?resend=true" style="color: #274abb !important">aquí</a> (debe primero ingresar a su cuenta).';
    }
?>