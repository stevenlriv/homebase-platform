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

        if(empty($_POST['check_required'])) {
            $form_error = 'You must agree to our terms of service and read our privacy policy.';
        }

        if(empty($form_error)) { 
            if(new_user($_POST['fullname'], $_POST['email'], $_POST['phone_number'], $_POST['password'])) {
                $form_success = 'Great, your account has been created.';

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
                $form_error = 'An error occurred while updating your account, please try again, or contact us.';
            }
        }

    }
?>