<?php
    if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }
    
	if ( isset($_POST['submit']) ) {

        //Verify if the email address is already in use
		if(get_user_by_email($_POST['email'])) {
			$form_error = 'That email address is already in use.';
		}

        if ( strlen($_POST['password'])<12 ) {
            $form_error = 'You password must be 12 characters or more.';
        }

        if(empty($_POST['password'])) {
            $form_error = 'You must enter your new password.';
        }

		if(!is_email($_POST['email'])) {
			$form_error = 'You have enter an invalid e-mail address, try again.';
        }
        
        if(empty($_POST['phone_number'])) {
            $form_error = 'You must enter your phone number.';
        }

        if(empty($_POST['fullname'])) {
            $form_error = 'You must enter your full name.';
        }

        if(empty($form_error)) { 
            if(new_user($_POST['fullname'], $_POST['email'], $_POST['phone_number'], $_POST['password'])) {
                $form_success = 'Great, your account has been created.';

                //Auto log-in them
                login_user($_POST['email'], $_POST['password']);

                header("Refresh:1");
            }
            else {
                $form_error = 'An error occurred while updating your account, please try again, or contact us.';
            }
        }

    }
?>