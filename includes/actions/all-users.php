<?php
    if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }

    ////////////////// HIDE ////////////////// 

    if(!empty($_GET['hide']) && !empty($_GET['confirm']) && $_GET['confirm'] == 'true' && get_user_by_id($_GET['hide'])) {
        $edit_user = get_user_by_id($_GET['hide']);

        if(is_admin() && $edit_user['id_user']!=1 && $edit_user['status']!='inactive') {
            if(update_status($edit_user['id_user'], 'hide')) {
                $form_success = 'El usuario fue inhabilitado correctamente.';
            }
            else {
                $form_error = 'Hubo un error al inhabilitar el usuario, favor de intentarlo nuevamente.';
            }
        }
    }

    ////////////////// SHOW ////////////////// 
    
    if(!empty($_GET['show']) && !empty($_GET['confirm']) && $_GET['confirm'] == 'true' && get_user_by_id($_GET['show'])) {
        $edit_user = get_user_by_id($_GET['show']);

        if(is_admin() && $edit_user['id_user']!=1 && $edit_user['status']!='active') {
            if(update_status($edit_user['id_user'], 'show')) {
                $form_success = 'El usuario fue habilitado correctamente.';
            }
            else {
                $form_error = 'Hubo un error, habilitando el usuario, favor de intentarlo nuevamente.';
            }
        }
    }
?>