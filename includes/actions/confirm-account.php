<?php
    if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }

    if(empty($_GET['email']) || empty($_GET['validation'])) {
        header('Location: /');
    }

    $user_details = get_user_by_email($_GET['email']);

    if($user_details['code'] == $_GET['validation']) {
        //Update code and user status
        if(update_user_table('code', $user_details['id_user'], '') && update_user_table('status', $user_details['id_user'], 'active')) {
            $form_success = 'Great! Your account was confirmed successfully.';
            
            //Send them to the properties page
            header('Location: /my-properties');
        }
        else {
            $form_error = 'An error occurred while confirming your account, please try again.';
        }
    }
    else {
        $form_error = 'It looks like your code is not valid. You can send a new code by, <a href="/my-profile?resend=true" style="color: #274abb !important">click here</a> (need to be logged in).';
    }
?>